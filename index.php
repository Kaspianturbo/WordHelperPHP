<!DOCTYPE html>
<?php
require_once 'library/Templates.php';
require_once 'library/Database.php';

$link = db_connect();
$data = get_templates($link);
?>
<html>
    <header>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css\main.css">
    </header>
    <body>
        <?php
            foreach ($data as $val): 
        ?>
        <div class="doc"><a href="/form.php?template=<? echo $val['file_name']?>"><? echo $val['name']?></a></div>
        <?php endforeach;?>
    </body>
</html>