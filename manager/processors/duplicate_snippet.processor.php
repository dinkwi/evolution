<?php
if( ! defined('IN_MANAGER_MODE') || IN_MANAGER_MODE !== true) {
    die("<b>INCLUDE_ORDERING_ERROR</b><br /><br />Please use the EVO Content Manager instead of accessing this file directly.");
}
if(!$modx->hasPermission('new_snippet')) {
	$modx->webAlertAndQuit($_lang["error_no_privileges"]);
}

$id = isset($_GET['id'])? (int)$_GET['id'] : 0;
if($id==0) {
	$modx->webAlertAndQuit($_lang["error_no_id"]);
}

// count duplicates
$name = $modx->getDatabase()->getValue($modx->getDatabase()->select('name', $modx->getFullTableName('site_snippets'), "id='{$id}'"));
$count = $modx->getDatabase()->getRecordCount($modx->getDatabase()->select('name', $modx->getFullTableName('site_snippets'), "name LIKE '{$name} {$_lang['duplicated_el_suffix']}%'"));
if($count>=1) $count = ' '.($count+1);
else $count = '';

// duplicate Snippet
$newid = $modx->getDatabase()->insert(
	array(
		'name'=>'',
		'description'=>'',
		'snippet'=>'',
		'properties'=>'',
		'category'=>'',
		), $modx->getFullTableName('site_snippets'), // Insert into
	"CONCAT(name, ' {$_lang['duplicated_el_suffix']}{$count}') AS name, description, snippet, properties, category", $modx->getFullTableName('site_snippets'), "id='{$id}'"); // Copy from

// Set the item name for logger
$name = $modx->getDatabase()->getValue($modx->getDatabase()->select('name', $modx->getFullTableName('site_snippets'), "id='{$newid}'"));
$_SESSION['itemname'] = $name;

// finish duplicating - redirect to new snippet
$header="Location: index.php?r=2&a=22&id=$newid";
header($header);
