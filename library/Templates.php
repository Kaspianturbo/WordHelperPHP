<?php

require_once $_SERVER['DOCUMENT_ROOT'].'\model\Template.php';
require_once $_SERVER['DOCUMENT_ROOT'].'\model\Field.php';

//Отримуємо список шаблонів (видима користувачу назва, назва файлу)
function get_templates($link)
{
    $query = "SELECT `name`, `file_name`, `description`, `date` FROM `template`;";
    $result = mysqli_query($link, $query);

    if(!$result) die(mysqli_error($link));

    $n = mysqli_num_rows($result);
    $templates = array();

    for ($i = 0; $i < $n; $i++)
    {
        $row = mysqli_fetch_assoc($result);
        $template = new Template
        (
            $row[name],
            $row[file_name],
            $row[description],
            $row[date]
        );
        $templates[] = $template;
    }
    return $templates;
}

function remove_template($link, $name)
{
    $t = "DELETE FROM `template` WHERE name = '%s';";
    $query = sprintf($t, $name);
    $result = mysqli_query($link, $query);
    if(!$result) die(mysqli_error($link));

    $t = "DELETE FROM `field` WHERE template_name = '%s';";
    $query = sprintf($t, $name);
    $result = mysqli_query($link, $query);
    if(!$result) die(mysqli_error($link));
}

function remove_all_templates_by_file($link, $file_name)
{
    $templates = get_templates_by_file($link, $file_name);
    if(!$templates) return;
    $t = "DELETE FROM `template` WHERE file_name = '%s';";
    $query = sprintf($t, $file_name);
    $result = mysqli_query($link, $query);
    if(!$result) die(mysqli_error($link));

    $n = count($templates);
    $query = "DELETE FROM `field` WHERE";
    for($i = 0; $i < $n; $i++)
    {
        if($i == 0) $query = $query." template_name = '{$templates[$i]}'";
        else $query = $query." OR template_name = '{$templates[$i]}'";
    }
    $result = mysqli_query($link, $query);
    if(!$result) die(mysqli_error($link));
}

function get_templates_by_file($link, $file_name)
{
    $t = "SELECT `name` FROM `template` WHERE file_name = '%s';";
    $query = sprintf($t, $file_name);
    $result = mysqli_query($link, $query);
    if(!$result) die(mysqli_error($link));

    $n = mysqli_num_rows($result);
    $names = array();

    for ($i = 0; $i < $n; $i++)
    {
        $row = mysqli_fetch_assoc($result);
        $names[] = $row[name];
    }
    return $names;
}

//Повертає список полів та їх характеристик
//Другим аргументом передається назва файлу. НЕ НАЗВА ШАБЛОНУ!!!!
function get_fields_by_name($link, $name)
{
    $t = "SELECT `name`, `value`, `description`, `isRequired`, `isService`, `type` FROM `field` WHERE template_name = '%s';";

    $query = sprintf($t, $name);

    $result = mysqli_query($link, $query);

    if(!$result) die(mysqli_error($link));

    $n = mysqli_num_rows($result);
    $fields = array();

    for ($i = 0; $i < $n; $i++)
    {
        $row = mysqli_fetch_assoc($result);
        $field = new Field(
            $name,
            $row[name],
            $row[value],
            $row[description],
            $row[isRequired],
            $row[isService],
            $row[type]
        );
        $fields[] = $field;
    }
    return $fields;
}

function get_field_names($link)
{
    $query = "SELECT `name` FROM `field`;";

    $result = mysqli_query($link, $query);

    if(!$result) die(mysqli_error($link));

    $n = mysqli_num_rows($result);
    $fields = array();

    for ($i = 0; $i < $n; $i++)
    {
        $row = mysqli_fetch_assoc($result);
        $fields[] = $row[name];
    }
    return $fields;
}

function get_file_by_template($link, $name)
{
    $t = "SELECT `file_name` FROM `template` WHERE name = '%s';";

    $query = sprintf($t, $name);

    $result = mysqli_query($link, $query);

    if(!$result) die(mysqli_error($link));

    $row = mysqli_fetch_assoc($result);

    return $row[file_name];
}

//Добавляє в БД новий шаблон і його поля
function new_template_and_fields($link, $template, $fields)
{
    $t = "INSERT INTO `template`(`name`, `file_name`, `description`, `date`) VALUES ('%s', '%s', '%s', CURRENT_DATE());";

    $query = sprintf($t, 
        $template[1],
        $template[0],
        $template[2]
    );

    $result = mysqli_query($link, $query);

    $n = count($fields);

    for ($i = 0; $i < $n / 6; $i++)
    {
        $t = "INSERT INTO `field` (`id`, `template_name`, `name`, `value`, `description`, `type`, `isRequired`, `isService`) VALUES (NULL, '%s', '%s', '%s', '%s', '%s', '%s', '%s');";

        $query = sprintf($t, 
            $template[1], 
            $fields[$i * 6 + 0],
            $fields[$i * 6 + 5],
            $fields[$i * 6 + 1],
            $fields[$i * 6 + 2],
            $fields[$i * 6 + 3],
            $fields[$i * 6 + 4]
        );

        $result = mysqli_query($link, $query);

        if(!$result) die(mysqli_error($link));
    }
    return true;
}
?>