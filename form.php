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