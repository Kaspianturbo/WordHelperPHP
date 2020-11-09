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
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
    </header>
    <body>
    <div class="container-fluid">
<div class="row">
  <div class="col-4">
    <div class="list-group" id="list-tab" role="tablist">
    <?php foreach ($data as $key=>$val):?>
      <a class="list-group-item list-group-item-action <?if($key==0) echo ('active');?>" id="list-home-list<?echo $key?>" data-toggle="list" href="#list-home<?echo $key?>" role="tab" aria-controls="home"><? echo $val['name']?></a>
    <?php endforeach;?>
    </div>
  </div>
  <div class="col-8">
    <div class="tab-content" id="nav-tabContent">
    <?php foreach ($data as $key=>$val):?>
      <div class="tab-pane fade <?if($key==0) echo ('show active');?>" id="list-home<?echo $key?>" role="tabpanel" aria-labelledby="list-home-list<?echo $key?>">
        <iframe src=<?echo "http://wordhelperphp/form.php?template=".$val['file_name']?>>
     </iframe></div>
     <?php endforeach;?>
    </div>
  </div>
</div>
    </div>
    </body>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap.js"></script>
</html>

