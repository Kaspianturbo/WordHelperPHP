<?php
require_once '../library/Templates.php';
require_once '../library/Database.php';

$link = db_connect();

$object = new stdClass(); // Создаём объект
foreach( $_REQUEST as $key=>$val )  $object->$key = $val; //получаем переменные
foreach ($object as $key=>$val) $data[]=$val;

$template = array_slice($data, 0, 2);
$fields = array_slice($data, 2);
print_r($fields);
new_template_and_fields($link, $template, $fields);
?>