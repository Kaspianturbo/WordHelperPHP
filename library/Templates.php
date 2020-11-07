<?php

//Отримуємо список шаблонів (видима користувачу назва, назва файлу)
function get_templates($link)
{
    $query = "SELECT `name`, `file_name` FROM `template`";
    $result = mysqli_query($link, $query);

    if(!$result) die(mysqli_error($link));

    $n = mysqli_num_rows($result);
    $templates = array();

    for ($i = 0; $i < $n; $i++)
    {
        $row = mysqli_fetch_assoc($result);
        $templates[] = $row;
    }
    return $templates;
}

//Повертає список полів та їх характеристик
//Другим аргументом передається назва шаблону. НЕ НАЗВА ФАЙЛУ!!!!
function get_fields_by_name($link, $name)
{
    $t = "SELECT `name`, `description`, `isRequired`, `isComputing`, `type` FROM `field` WHERE template_name = '%s';";

    $query = sprintf($t, $name);

    $result = mysqli_query($link, $query);

    if(!$result) die(mysqli_error($link));

    $n = mysqli_num_rows($result);
    $fields = array();

    for ($i = 0; $i < $n; $i++)
    {
        $row = mysqli_fetch_assoc($result);
        $fields[] = $row;
    }
    return $fields;
}

//Добавляє в БД новий шаблон і його поля
function new_template_and_fields($link, $template, $fields)
{
    $t = "INSERT INTO `template`(`name`, `file_name`, `date`) VALUES ('%s', '%s', CURRENT_DATE());";

    $query = sprintf($t, 
        mysql_real_escape_string($link, $template->name), 
        mysql_real_escape_string($link, $template->fileName)
    );

    $result = mysqli_query($link, $query);

    $n = count($fields);

    for ($i = 0; $i < $n; $i++)
    {
        $t = "INSERT INTO `field` (`id`, `template_name`, `name`, `description`, `isRequired`, `isComputing`, `type`) VALUES (NULL, '%s', '%s', '%s', '%s', '%s', '%s');";

        $query = sprintf($t, 
            mysql_real_escape_string($link, $template->fileName), 
            mysql_real_escape_string($link, $fields[i]->name),
            mysql_real_escape_string($link, $fields[i]->descr),
            mysql_real_escape_string($link, $fields[i]->isRequired),
            mysql_real_escape_string($link, $fields[i]->isComputing),
            mysql_real_escape_string($link, $fields[i]->type)
        );

        $result = mysqli_query($link, $query);

        if(!$result) die(mysqli_error($link));
    }
    return true;
}

class Template
{
    public $name;
    public $fileName;
    public $date;
}

class Field
{
    public $name;
    public $descr;
    public $isRequired;
    public $isComputing;
    public $type;
}
?>