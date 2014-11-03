<?php

namespace App;

class HelperBroker
{

    /**
     * Path where to find the helpers
     * @todo place this in the application.ini
     */
    public $helperPath = 'views/helpers';



    /**
     * Static instance of self
     * @var App_HelperBroker
     */
    private static $instance;



    /**
     * Place to store the Cached Helpers
     * @var array
     */
    private $helpers = array();



    /**
     * private constructor for singleton
     */
    private function __construct()
    {
    }



    /**
     * Get the App_HelperBroker instance
     *
     * @static
     * @return App_HelperBroker
     */
    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }



    /**
     * Proxy to the Helper and returns the result of the 'direct()' method of it
     *
     * @param string $helper
     * @param array $params
     * @return mixed
     */
    public function __call($helper, array $params=array())
    {
        return call_user_func_array(
            array(
                $this->getHelper($helper),
                'direct'),
            $params
        );
    }



    /**
     * Get the Helper
     * @param string $helper
     * @return App_Helper_Abstract
     */
    public function getHelper($helper)
    {
        if (false === $this->hasHelper($helper)) {
            $this->helpers[$helper] = $this->loadHelper($helper);
        }

        return $this->helpers[$helper];
    }



    /**
     * Check if we have the helper in cache
     * @param $helper
     * @return bool
     */
    public function hasHelper($helper)
    {
        return (bool) array_key_exists($helper, $this->helpers);
    }



    /**
     * Load the Helper
     *
     * @todo autoloading (register in set_include_path - from config.ini)
     * @param $helper
     * @throws ErrorException
     * @return App_View_Helper_Abstract
     */
    public function loadHelper($helper)
    {
        $helper = ucfirst($helper);

        if (!file_exists($this->getHelperPath() . '/' . $helper . '.php')) {
            throw new \ErrorException(
                sprintf(
                    "the helper '%s' does not seem to exists exists in %s",
                    $helper,
                    $this->getHelperPath()
                )
            );
        }

        require_once($this->getHelperPath() . '/' . $helper . '.php');
        return new $helper($this);
    }



    /**
     * Get The HelperPath
     *
     * @todo this becomes obsolete then
     * @return string
     */
    private function getHelperPath()
    {
        return implode(
            DIRECTORY_SEPARATOR,
            array(
                APPLICATION_PATH,
                $this->helperPath
            )
        );
    }
}
