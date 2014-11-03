<?php

namespace App;

class Debug
{
    public static function Dump($var, $exit=true)
    {
        echo '<pre>';
        var_dump($var);
        echo '</pre>';

        if (true === $exit) {
            die();
        }
    }
}
