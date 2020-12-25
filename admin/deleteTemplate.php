<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/library/Templates.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/library/Database.php';

$link = db_connect();

$template_name = $_REQUEST['name'];
remove_template($link, $template_name);

$url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST']  . '/admin';
header("Location: ".$url);
exit;
?>
