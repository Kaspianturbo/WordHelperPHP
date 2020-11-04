<?php 
/*
Видеокурс по созданию онлайн сервисов: http://aff.krotovroman.ru/phppro/
Видеокурс по созданию продающих сайтов: http://aff.krotovroman.ru/landing/
*/
set_include_path(get_include_path().PATH_SEPARATOR.realpath(__DIR__."/library/")); 
function __autoload($name_class) {require_once $name_class.'.php';} //автозагрузка классов из папки

$object = new stdClass(); // Создаём объект
foreach( $_REQUEST as $key=>$val )  $object->$key = $val; //получаем переменные

$word= new Word();

foreach ($object as $key=>$val) $data[$key]=$val;
$word->generate($data);