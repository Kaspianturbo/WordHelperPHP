<!DOCTYPE html>
<?php

?>
<html>
    <header>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="..\css\main.css">
    </header>
    <body>
        <form method="POST" action="fillTemplate.php" enctype="multipart/form-data">
            <input name="filename" type="file" required>
            <input type="submit" value="завантажити">
        </form>
    </body>
</html>