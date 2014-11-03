<?php

class App_View_Partial extends App_View
{

    private $template;

    // @note lol, misschien hoeft dit helemaal niet.. kan gewoon in de view :P
    public function __construct($template, array $params)
    {
        $this->template = $template;
        $this->data = $params;
    }
}
