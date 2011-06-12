<?php
##################################################
#
# Copyright (c) 2007-2008 OIC Group, Inc.
# Written and Designed by Adam Kessler
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

class install_tables extends upgradescript {
	protected $from_version = '0.96.3';
//	protected $to_version = '1110.97.0'; //set this to something ridiculously high so it always runs

	function name() { return "Upgrade Database Tables"; }

	function upgrade() {
		global $db;
?>
<?php echo '<p class="success">'.gt('Installing and Upgrading tables').'</p>'; ?>

<?php

define("TMP_TABLE_EXISTED",		1);
define("TMP_TABLE_INSTALLED",	2);
define("TMP_TABLE_FAILED",		3);
define("TMP_TABLE_ALTERED",		4);

$dirs = array(
	BASE."datatypes/definitions",
	BASE."framework/core/database/definitions",
	);

$tables = array();
foreach ($dirs as $dir) {
	if (is_readable($dir)) {
		$dh = opendir($dir);
		while (($file = readdir($dh)) !== false) {
			if (is_readable("$dir/$file") && is_file("$dir/$file") && substr($file,-4,4) == ".php" && substr($file,-9,9) != ".info.php") {
				$tablename = substr($file,0,-4);
				$dd = include("$dir/$file");
				$info = null;
				if (is_readable("$dir/$tablename.info.php")) $info = include("$dir/$tablename.info.php");
				if (!$db->tableExists($tablename)) {
					foreach ($db->createTable($tablename,$dd,$info) as $key=>$status) {
						$tables[$key] = $status;
					}
				} else {
					foreach ($db->alterTable($tablename,$dd,$info) as $key=>$status) {
						if (isset($tables[$key])) echo "$tablename, $key<br>";
						if ($status == TABLE_ALTER_FAILED){
							$tables[$key] = $status;
						}else{
							$tables[$key] = ($status == TABLE_ALTER_NOT_NEEDED ? DATABASE_TABLE_EXISTED : DATABASE_TABLE_ALTERED);
						}

					}
				}
			}
		}
	}
}

$newdef = BASE."framework/modules";

if (is_readable($newdef)) {
    $dh = opendir($newdef);
    while (($file = readdir($dh)) !== false) {
        if (is_dir($newdef.'/'.$file) && ($file != '..' && $file != '.')) {
            $dirpath = $newdef.'/'.$file.'/definitions';
            if (file_exists($dirpath)) {
                $def_dir = opendir($dirpath);
                while (($def = readdir($def_dir)) !== false) {
                    eDebug("$dirpath/$def");
    				if (is_readable("$dirpath/$def") && is_file("$dirpath/$def") && substr($def,-4,4) == ".php" && substr($def,-9,9) != ".info.php") {
    					$tablename = substr($def,0,-4);
    					$dd = include("$dirpath/$def");
    					$info = null;
    					if (is_readable("$dirpath/$tablename.info.php")) $info = include("$dirpath/$tablename.info.php");
    					if (!$db->tableExists($tablename)) {
    						foreach ($db->createTable($tablename,$dd,$info) as $key=>$status) {
    							$tables[$key] = $status;
    						}
    					} else {
    						foreach ($db->alterTable($tablename,$dd,$info) as $key=>$status) {
    							if (isset($tables[$key])) echo "$tablename, $key<br>";
    							if ($status == TABLE_ALTER_FAILED){
    								$tables[$key] = $status;
    							}else{
    								$tables[$key] = ($status == TABLE_ALTER_NOT_NEEDED ? DATABASE_TABLE_EXISTED : DATABASE_TABLE_ALTERED);
    							}

    						}
    					}
    				}
                }
            }
        }
    }
}

ksort($tables);

?>

<table cellpadding="2" cellspacing="0" width="100%" border="0" class="exp-skin-table">
<thead>
<tr>
	<th>
		<?php echo gt('Table Name') ?>
	</th>
	<th>
		<?php echo gt('Status') ?>
	</th>
</tr>
</thead>
<tbody>
<?php
$row = "even";
foreach ($tables as $table => $statusnum) {
?>

<tr class="<?php echo $row ?>">
	<td>
		 <?php echo gt($table) ?>
	</td>
	<td>
		 <?php  if ($statusnum == TMP_TABLE_EXISTED) { ?>
		<div style="color: blue; font-weight: bold">
			<?php echo gt('Table Exists') ?>
		</div>
		 <?php } elseif ($statusnum == TMP_TABLE_INSTALLED) {  ?>
		<div style="color: green; font-weight: bold">
			<?php echo gt('Succeeded') ?>
		</div>
        <?php } elseif ($statusnum == TMP_TABLE_FAILED) {  ?>
		<div style="color: red; font-weight: bold">
			<?php echo gt('Failed') ?>
		</div>
        <?php } elseif ($statusnum == TMP_TABLE_ALTERED) {  ?>
		<div style="color: green; font-weight: bold">
			<?php echo gt('Altered Existing') ?>
		</div>
        <?php } elseif ($statusnum == TABLE_ALTER_FAILED) {  ?>
		<div style="color: red; font-weight: bold">
			<?php echo gt('Failed Altering') ?>
		</div>
        <?php } ?>
	</td>
</tr>
<?php
$row  = $row == "even" ? "odd" : "even";
} ?>
 <tbody>
</table>
<?php
	}
}

?>
