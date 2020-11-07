<!DOCTYPE html>
<?php
require_once "library/Word.php";
require_once 'library/Templates.php';
require_once 'library/Database.php';

$template = $_GET['template'];
$link = db_connect();
$fields = get_fields_by_name($link, $template);
?>
<html>
    <header>
        <meta charset="UTF-8">
    </header>
    <body>
        
        <form method="POST" action="generate.php">
            <p>Назва документу <input name="template" type="text" value="<? echo $template?>" readonly></p>
            <?php
                foreach ($fields as $val): 
                    if ($val['isComputing'] == 'false')
                    {
            ?>
            <p><? echo $val['description']?> <input name="<? echo $val['name']?>" type="<?echo $val['type']?>" <?if ($val['isRequired'] == 'true') echo 'required'?>></p>
            <?php } endforeach;?>
            <input type="submit" value="завантажити">
        </form>
    </body>
</html>