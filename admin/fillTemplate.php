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
    </header>
    <body>
        <form method="POST" action="createTemplate.php">
        <input name="fileName" type="text" value="<?echo $name?>" readonly><br/>
        <input name="name" type="text" required><br/>
        <? for ($i = 0; $i < $n; $i++):?>
        <div style="display:inline-block">
            <input name="fieldName<?echo $i + 1?>" type="text" value="<?echo $fields[$i]?>" readonly>
            <input name="description<?echo $i + 1?>" type="text" required>
            <input name="isRequired<?echo $i + 1?>" type="text" required>
            <input name="isCompuring<?echo $i + 1?>" type="text" required>
            <input name="type<?echo $i + 1?>" type="text" required>
        </div><br/>
        <? endfor;?>
        <input type="submit" value="завантажити">
        </form>
    </body>
</html>