<?php

##################################################
#
# Copyright (c) 2004-2012 OIC Group, Inc.
#
# This file is part of Exponent
#
# Exponent is free software; you can redistribute
# it and/or modify it under the terms of the GNU
# General Public License as published by the Free
# Software Foundation; either version 2 of the
# License, or (at your option) any later version.
#
# GPL: http://www.gnu.org/licenses/gpl.txt
#
##################################################

if (!defined('EXPONENT')) exit('');

global $router;

//expHistory::flowSet(SYS_FLOW_PUBLIC,SYS_FLOW_ACTION);
expHistory::set('viewable', $router->params);

$item = $db->selectObject("calendar","id=" . intval($_GET['id']));
if ($item) {
	$loc = unserialize($item->location_data);
	$iloc = expCore::makeLocation($loc->mod,$loc->src,$item->id);
	$item->permissions = array(
		"edit"=>(expPermissions::check("edit",$iloc) || expPermissions::check("edit",$loc)),
		"delete"=>(expPermissions::check("delete",$iloc) || expPermissions::check("delete",$loc)),
		"manage"=>(expPermissions::check("manage",$iloc) || expPermissions::check("manage",$loc)),
	);
	// Debugger test
	$item->permissions = array(
		"edit"=>expPermissions::check("edit",$iloc),
		"delete"=>expPermissions::check("delete",$iloc),
		"manage"=>expPermissions::check("manage",$iloc)
	);

	if (!isset($_GET['date_id'])) {
		$eventdate = $db->selectObject("eventdate","event_id=".$item->id);
	} else {
		$eventdate = $db->selectObject("eventdate","id=".intval($_GET['date_id']));
	}
	$item->eventdate = $eventdate;

	//Get the image file if there is one.
	if (isset($item->file_id) && $item->file_id > 0) {
		$file = $db->selectObject('file', 'id='.$item->file_id);
		$item->image_path = $file->directory.'/'.$file->filename;
	}	
	//FJD - Goofy-ass daylight savings time hack.  Should be improved at some point.
	//need to do some comparisons on the timestamp and value returned from strftime and adjust accordingly up or down 
	//to correct output.  This will still cause one display bug: if your times are within an hour of the change in one
	//direction, it will display incorrectly.  
	//US does the switch at 2AM, European union at 1AM.
	
	//get interger for hours from eventstart and end divided by 3600, then
	//get interger for hour of time returned from strtime, which should take DST from locale into consideration, 
	//(so our data should be portable).  If they are off, then create the adjustment +/- and correct
	//eventstart and eventend
	$timeHourStart =  intval($item->eventstart / 3600);
	$strHourStart = intval(strftime("%H", $eventdate->date + $item->eventstart));
	$timeHourEnd =  intval($item->eventend / 3600);
	$strHourEnd = intval(strftime("%H", $eventdate->date + $item->eventend));
	
	$adjustStart = (($timeHourStart - $strHourStart) * 3600); //could be + or - or 0 (most of the time);
	$adjustEnd = (($timeHourEnd - $strHourEnd) * 3600); //could be + or - or 0 (most of the time);
	
	$item->eventstart += ($eventdate->date + $adjustStart); 
	$item->eventend += ($eventdate->date + $adjustEnd); 
	$title = $db->selectValue('container', 'title', "internal='".serialize($loc)."'");
		
	$template = new template("calendarmodule","_view",$loc);

	if ($item->feedback_form != "") {
		$formtemplate = new formtemplate('forms/calendar', $item->feedback_form);
		$formtemplate->assign('formname', $item->feedback_form);
		$formtemplate->assign('module','calendarmodule');
		$formtemplate->assign('loc', $loc);
		$formtemplate->assign('action', 'send_feedback');
		$formtemplate->assign('id', $item->id);
		$form = $formtemplate->render();
		$template->assign('form', $form);
	}

//	$tags = unserialize($item->tags);
//	if (!empty($tags)) {
//		$selected_tags = $db->selectObjectsInArray('tags', $tags);
//	} else {
//		$selected_tags = array();
//	}
//	$template->assign('tags',$selected_tags);
//	$template->assign('tagcnt',count($selected_tags));

	$config = $db->selectObject("calendarmodule_config","location_data='".serialize($loc)."'");
	if (!$config) {
		$config->enable_ical = 1;
	}
	if (!isset($config->enable_ical)) {$config->enable_ical = 1;}
	$template->assign("enable_ical", $config->enable_ical);
	
	$template->assign("item",$item);
	$template->assign("directory","files/calendarmodule/".$loc->src);
	$template->register_permissions(
		array("create","edit","delete","manage"),
		$loc
	);
	$template->assign('moduletitle',$title);

	$template->output();
} else {
	echo SITE_404_HTML;
}

?>
