<?php
class Template
{
    public $name;
    public $file_name;
    public $description;
    public $date;

    function __construct($name, $file_name, $description, $date)
    {
        $this->name = $name;
        $this->file_name = $file_name;
        $this->description = $description;
        $this->date = $date;
    }
}
?>