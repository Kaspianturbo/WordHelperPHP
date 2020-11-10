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
        <link rel="stylesheet" href="css/bootstrap.min.css">
    </header>
    <body>
        
        <form method="POST" action="generate.php">
            <input class="form-control" name="template" type="hidden" value="<? echo $template?>" readonly >
            <?php
                foreach ($fields as $val): 
            ?>
            <div class="form-group">
            <label for="<? echo $val['name']?>"><? echo $val['description']?></label>
            <input class="form-control" name="<? echo $val['name']?>" type="<?echo $val['type']?>" <?if ($val['isRequired'] == 'true') echo 'required'?>>
            </div>
            <?php endforeach;?>
            <input type="submit" class="btn btn-primary mb-2" value="завантажити">
        </form>
    </body>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap.js"></script>
</html>