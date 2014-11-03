<?php

namespace App;

class Cache
{
    public static function load()
    {
        $file = Cache::getCacheFileName();

        if (file_exists($file)) {
            
            include($file);
            echo '<!-- loaded from cache -->';
            die();
            
            return true;
        }

        return false;
    }


    /**
     * @return string
     */
    public static function getCacheFileName()
    {
        return '../cache/' . str_replace(
            '/',
            '_',
            strtolower(
                $_SERVER['REQUEST_URI']
            )
        ) . '.cache';
    }


    /**
     * @param $layout
     */
    public static function save($layout)
    {
        if (@file_put_contents(Cache::getCacheFileName(), $layout)) {
            @header('location: http://'. $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
            die();
        }
        else {
            echo 'error creating cache file';
        }

        die();
    }
}