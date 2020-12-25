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
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
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
                        <input type="file" class="custom-file-input" id="inputGroupFile04" aria-describedby="inputGroupFileAddon01" name="filename" required>
                        <label class="custom-file-label" for="inputGroupFile04">Вибрати файл</label>
                    </div>
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit" id="inputGroupFileAddon01">Завантажити</button>
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
                        <button class="btn btn-outline-secondary" type="submit" id="inputGroupFileAddon04">Видалити</button>
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
                        <button class="btn btn-outline-secondary" type="submit" id="inputGroupFileAddon04">Видалити</button>
                    </div>
                </div>
            </form>
            <a href="<?echo $url?>">Вернутися на головну</a>
        </div>
        <script>
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
        </script>
    </body>
</html>