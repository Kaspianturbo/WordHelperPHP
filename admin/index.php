<!DOCTYPE html>
<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/library/Templates.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/library/Database.php';

$link = db_connect();
$templates = get_templates($link);
$file_names = scandir($_SERVER['DOCUMENT_ROOT'].'/templates');
$file_names = array_slice($file_names, 2);

$url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
?>
<html>
    <header>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../css/main.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <script src="../js/admin.js"></script>
    </header>
    <body>
        <nav class="navbar navbar-dark bg-primary mb-3">
            <div class="container">
                <h1 class="text-light">Сторінка адміністратора</h1>
            </div>
        </nav>
        <div class="container mt-5">
            <h3>Завантажити файл та створити шаблон</h3>
            <form method="POST" action="fillTemplate.php" enctype="multipart/form-data">
                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" onChange="setCurrentFile()" class="custom-file-input" id="inputFile" aria-describedby="inputGroupFileAddon01" name="filename" required>
                        <label class="custom-file-label" for="inputFile">Вибрати файл</label>
                    </div>
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary"  onClick="return validate();" type="submit" id="inputGroupFileAddon01">Завантажити</button>
                    </div>
                </div>
            </form>
            <h3>Створити на основі існуючого файлу</h3>
            <form method="POST" action="fillTemplate.php" enctype="multipart/form-data">
                <div class="input-group">
                    <select class="custom-select w-25" name="filename" required>
                        <?
                            foreach ($file_names as $file_name):
                        ?>
                        <option><?echo $file_name?></option>
                        <?
                            endforeach;
                        ?>
                    </select>
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit" id="inputGroupFileAddon04">Створити</button>
                    </div>
                </div>
            </form>
            <h3>Видалити шаблон</h3>
            <form method="POST" action="deleteTemplate.php" enctype="multipart/form-data">
                <div class="input-group">
                    <select class="custom-select w-25" name="name" required>
                        <?
                            foreach ($templates as $obj):
                        ?>
                        <option><?echo $obj->name?></option>
                        <?
                            endforeach;
                        ?>
                    </select>
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" onClick="return confirmAction()" type="submit" id="inputGroupFileAddon04">Видалити</button>
                    </div>
                </div>
            </form>
            <h3>Видалити файл</h3>
            <form method="POST" action="deleteFile.php" enctype="multipart/form-data">
                <div class="input-group">
                    <select class="custom-select w-25" name="filename" required>
                        <?
                            foreach ($file_names as $file_name):
                        ?>
                        <option><?echo $file_name?></option>
                        <?
                            endforeach;
                        ?>
                    </select>
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" onClick="return confirmAction()" type="submit" id="inputGroupFileAddon04">Видалити</button>
                    </div>
                </div>
            </form>
            <a href="<?echo $url?>">Вернутися на головну</a>
        </div>
    </body>
</html>