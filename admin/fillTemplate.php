<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/library/Word.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/library/Templates.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/library/Database.php';

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
$fields = $word->readAllPatterns($name)[1];
$fields = array_unique($fields);
$n = count($fields);
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
                <option value="tel">Телефон</option>
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
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
</html>