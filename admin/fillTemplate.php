<!DOCTYPE html>
<?php
require_once "../library/Word.php";
require_once '../library/Templates.php';

$tmp_name = $_FILES['filename']['tmp_name'];
$name = $_FILES['filename']['name'];
if(move_uploaded_file($tmp_name, '../templates/'.$name))
{
    echo 'done';
}
else echo 'failed';

$word= new Word();
$fields = $word->readAllPatterns($name)[1];
$n = count($fields);
print_r($fields);
?>
<html>
    <header>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="..\css\main.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    </header>
    <body>
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
            <div class="w-25">Опис</div>
            <div class="w-25">Обов'язкове</div>
            <div class="w-25">Тип</div>
        </div>
        <? for ($i = 0; $i < $n; $i++):?>
        <div style="display: flex; flex-direction: row;">
            <input class="form-control" name="fieldName<?echo $i + 1?>" type="text" value="<?echo $fields[$i]?>" readonly>
            <input class="form-control" name="description<?echo $i + 1?>" type="text" required>
            <input class="form-control" name="isRequired<?echo $i + 1?>" type="text" required>
            <input class="form-control" name="type<?echo $i + 1?>" type="text" required>
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