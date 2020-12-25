<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/library/Templates.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/library/Database.php';

$link = db_connect();
$file_name = $_REQUEST['filename'];
if($file_name)
{
    $file_path = $_SERVER['DOCUMENT_ROOT'].'/templates/'.$file_name;
    remove_all_templates_by_file($link, $file_name);
    unlink($file_path);
}

$url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/admin';
header("Location: ".$url);
exit;
?>
