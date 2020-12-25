<!DOCTYPE html>
<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/library/Templates.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/library/Database.php';

$template = urldecode($_GET['template']);
$link = db_connect();
$fields = get_fields_by_name($link, $template);
$file_name = get_file_by_template($link, $template);
?>
<html>
    <header>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    </header>
    <body>
        <form method="POST" action="generate.php">
            <input class="form-control" name="template" type="hidden" value="<? echo $file_name?>" readonly >
            <?php
                foreach ($fields as $field):
            ?>
            <div class="form-group">
            <label for="<? echo $field->name?>" <?if ($field->is_service == 'Так') echo 'hidden'?>><? echo $field->description?></label>
            <input class="form-control" name="<? echo $field->name?>" type="<?echo $field->type?>" <?if ($field->is_required == 'Так') echo 'required '; if ($field->is_service == 'Так') echo 'hidden value="'.htmlspecialchars($field->value).'"'?>>
            </div>
            <?php endforeach;?>
            <input type="submit" class="btn btn-primary mb-2" value="завантажити">
        </form>
    </body>
</html>