<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/library/Word.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/library/Templates.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/library/Database.php';
error_reporting(E_ERROR | E_PARSE);
$link = db_connect();

$tmp_name = $_FILES['filename']['tmp_name'];
$name = $_FILES['filename']['name'];

if(!move_uploaded_file($tmp_name, '../templates/'.$name))
{
    $name = $_REQUEST['filename'];
    if(!$name)
    {
        $url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST']  . '/admin';
        header("Location: ".$url);
        exit;
    }
}

$word = new Word();
$n = 0;
try
{
    $fields = $word->readAllPatterns($name)[1];
    $fields = array_unique($fields);
    $n = count($fields);
}
catch(Exception $e)
{
    error_log("Invalid file. Can'n open file by PHPWord library\n".$e);
    $file_path = $_SERVER['DOCUMENT_ROOT'].'/templates/'.$name;
    unlink($file_path);
    $url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/admin';
    header("Location: ".$url);
}
?>
<!DOCTYPE html>
<html>
    <header>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="..\css\main.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    </header>
    <body>
    <nav class="navbar navbar-dark bg-primary mb-3">
    <div class="container">
        <h1 class="text-light">Сторінка адміністратора</h1>
    </div>
    </nav>
    <div class="container">
    <form method="POST" action="createTemplate.php">
        <label for="fileName">Ім'я файлу</label>
        <input class="form-control" name="fileName" type="text" value="<?echo $name?>" readonly>
        <label for="name">Ім'я документу, видиме користувачу</label>
        <input class="form-control" name="name" type="text" required>
        <label for="description">Опис документу, інструкція та ін.</label>
        <input class="form-control" name="description" type="text"></br>
        <div style="display: flex; flex-direction: row;">
            <div class="w-25">Поля вставки</div>
            <div class="w-100">Опис, видимий користувачу</div>
            <div class="w-25">Тип</div>
            <div class="w-25 text-center">Обов'язкове</div>
            <div class="w-25 text-center">Сервісне</div>
            <div class="w-25">За замовчуванням</div>
        </div>
        <? for ($i = 0; $i < $n; $i++):?>
        <div style="display: flex; flex-direction: row;">
            <input class="form-control w-25" name="fieldName<?echo $i + 1?>" type="text" value="<?echo $fields[$i]?>" readonly>
            <input class="form-control w-100" name="description<?echo $i + 1?>" type="text" required>
            <select class="custom-select w-25" name="type<?echo $i + 1?>">
                <option value="text">Текст</option>
                <option value="date">Дата</option>
                <option value="number">Номер</option>
            </select>
            <input type='hidden' value='Ні' name="isRequired<?echo $i + 1?>">
            <input class="form-control w-25" value='Так' name="isRequired<?echo $i + 1?>" type="checkbox" checked>
            <input type='hidden' value='Ні' name="isService<?echo $i + 1?>">
            <input class="form-control w-25" value='Так' name="isService<?echo $i + 1?>" type="checkbox">
            <input class="form-control w-25" name="value<?echo $i + 1?>" type="text">
        </div>
        <? endfor;?></br>
        <input class="btn btn-primary mb-2" type="submit" value="завантажити">
        </form>
    </div> 
    </body>
</html>