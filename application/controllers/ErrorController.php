<?php

class ErrorController extends \App\Controller\ControllerAbstract
{
    public function errorAction()
    {
        $this->layout->title = "404 Not Found";
    }
}