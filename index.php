<!DOCTYPE html>
<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/library/Templates.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/library/Database.php';

$link = db_connect();
$objects = get_templates($link);

foreach ($objects as $object) $data[]=$object;
$url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    </head>
    <body>
    <nav class="navbar navbar-dark bg-primary mb-3">
      <div class="container">
        <h1 class="text-light">Заповнення документів</h1>
      </div>
    </nav>
      <div class="container">
        <?if(count($objects) > 0):?>
          <div class="row">
            <div class="col-4">
              <div class="list-group" id="list-tab" role="tablist">
                <?php foreach ($data as $key=>$val):?>
                <a class="list-group-item list-group-item-action <?if($key==0) echo ('active');?>" id="list-home-list<?echo $key?>" data-toggle="list" href="#list-home<?echo $key?>" role="tab" aria-controls="home"><? echo $val->name?></a>
                <?php endforeach;?>
              </div>
            </div>
            <div class="col-8">
              <div class="tab-content" id="nav-tabContent">
                <?php foreach ($data as $key=>$val):?>
                <div class="tab-pane fade <?if($key==0) echo ('show active');?>" id="list-home<?echo $key?>" role="tabpanel" aria-labelledby="list-home-list<?echo $key?>">
                  <p><? echo $val->description?></p>
                  <iframe src=<?echo $url.'/form.php?template='.urlencode($val->name)?>></iframe>
                </div>
              <?php endforeach;?>
            </div>
          </div>
        <?endif;?>
        <?if(count($objects) == 0):?>
          <h3>Упс...</h3>
          <br>
          <p>Наразі немає доступних шаблонів</p>
        <?endif;?>
      </div>
    </div>
  </body>
</html>

