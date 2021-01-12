<!DOCTYPE html>
<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/library/Templates.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/library/Database.php';

$link = db_connect();

$object = new stdClass();
foreach( $_REQUEST as $key=>$val )  $object->$key = $val;
foreach ($object as $key=>$val) $data[]=$val;

$template = array_slice($data, 0, 3);
$fields = array_slice($data, 3);
new_template_and_fields($link, $template, $fields);

$url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
?>
<html>
    <header>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    </header>
    <body>
    <nav class="navbar navbar-dark bg-primary mb-3">
    <div class="container">
        <h1 class="text-light">Сторінка адміністратора</h1>
    </div>
    </nav>
    <div class="container">
        <h1>Шаблон добавлено!</h1><br>
        <a href="<?echo $url."/admin"?>">Вернутися до сторінки адміністратора</a><br>
        <a href="<?echo $url?>">Вернутися на головну</a>
    </div>
    </body>
</html>