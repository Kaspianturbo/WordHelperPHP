<?php
class Field
{
    public $template_name;
    public $name;
    public $description;
    public $is_required;
    public $type;

    function __construct($template_name, $name, $description, $is_required, $type)
    {
        $this->template_name = $template_name;
        $this->name = $name;
        $this->description = $description;
        $this->is_required = $is_required;
        $this->type = $type;
    }
}
?>