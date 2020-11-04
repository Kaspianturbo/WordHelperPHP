<!DOCTYPE html>
<?php
require_once "library/Word.php";

$template = $_GET['template'];
$word= new Word();
$fields = $word->readAllPatterns('/../templates/'.$template);

?>
<html>
    <header>
        <meta charset="UTF-8">
    </header>
    <body>
        
        <form method="POST" action="generate.php">
            <p>Назва документу <input name="template" type="text" value="<? echo $template?>" readonly></p>
            <?php
                foreach ($fields[1] as $key=>$val): 
            ?>
            <p><? echo $val?> <input name="<? echo $val?>" type="text"></p>
            <?php endforeach;?>
            <input type="submit" value="завантажити">
        </form>
    </body>
</html>