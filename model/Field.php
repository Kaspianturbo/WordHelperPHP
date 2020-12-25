<?php
class Field
{
    public $template_name;
    public $name;
    public $value;
    public $description;
    public $is_required;
    public $is_service;
    public $type;

    function __construct($template_name, $name, $value, $description, $is_required, $is_service, $type)
    {
        $this->template_name = $template_name;
        $this->name = $name;
        $this->value = $value;
        $this->description = $description;
        $this->is_required = $is_required;
        $this->is_service = $is_service;
        $this->type = $type;
    }
}
?>