<?php

set_include_path(implode(
    PATH_SEPARATOR,
    array(
        get_include_path(),
        dirname(dirname(__FILE__)),
        APPLICATION_PATH
    )
));

spl_autoload_extensions('.php');

spl_autoload_register(function($class) {
    return include(
        str_replace(array('_', '\\'), DIRECTORY_SEPARATOR, $class) . '.php'
    );
});