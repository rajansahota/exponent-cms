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
	$classname = $_POST['mod'];
	$controller = new $classname();
    $actions = $controller->useractions;
    // Language-ize the action names
    foreach ($actions as $key=>$value) {
        $actions[$key] = gt($value);
    }
	echo json_encode($actions);
?>
