<?php

//Отримуємо список шаблонів (видима користувачу назва, назва файлу)
function get_templates($link)
{
    $query = "SELECT `name`, `file_name`, `description` FROM `template`";
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
//Другим аргументом передається назва файлу. НЕ НАЗВА ШАБЛОНУ!!!!
function get_fields_by_name($link, $name)
{
    $t = "SELECT `name`, `description`, `isRequired`, `type` FROM `field` WHERE template_name = '%s';";

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
    $t = "INSERT INTO `template`(`name`, `file_name`, `description`, `date`) VALUES ('%s', '%s', '%s', CURRENT_DATE());";

    $query = sprintf($t, 
        $template[1],
        $template[0],
        $template[2]
    );

    $result = mysqli_query($link, $query);

    $n = count($fields);

    for ($i = 0; $i < $n / 4; $i++)
    {
        $t = "INSERT INTO `field` (`id`, `template_name`, `name`, `description`, `isRequired`, `type`) VALUES (NULL, '%s', '%s', '%s', '%s', '%s');";

        $query = sprintf($t, 
            $template[0], 
            $fields[$i * 4 + 0],
            $fields[$i * 4 + 1],
            $fields[$i * 4 + 2],
            $fields[$i * 4 + 3]
        );

        $result = mysqli_query($link, $query);

        if(!$result) die(mysqli_error($link));
    }
    return true;
}
?>