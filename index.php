<!DOCTYPE html>
<html>
    <header>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css\main.css">
    </header>
    <body>
        <?php
            $data = scandir('templates');
            foreach ($data as $val): 
        ?>
        <div class="doc"><a href="/form.php?template=<? echo $val?>"><? echo $val?></a></div>
        <?php endforeach;?>
    </body>
</html>