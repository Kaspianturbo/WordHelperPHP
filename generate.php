<?php 
set_include_path(get_include_path().PATH_SEPARATOR.realpath(__DIR__."/library/")); 
function __autoload($name_class) {require_once $name_class.'.php';}

$object = new stdClass();
foreach( $_REQUEST as $key=>$val )  $object->$key = $val;

$word= new Word();

foreach ($object as $key=>$val) $data[$key]=$val;
$word->generate($data);