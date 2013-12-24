<?php
require_once '../admin_fnc.php';
$h = new H2O($_SERVER['DOCUMENT_ROOT'].$admin->path_to_admin.'/common/templates/autofill.js');
$c = array();
$c["admin_path"] = $admin->path_to_admin;
$c['id'] = !empty($_GET['id']) ? (int)$_GET['id'] : 0;

echo $h->render($c);
?>
