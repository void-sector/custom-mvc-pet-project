<?php

namespace App;

final class Registry
{

    /**
     * PlaceHolder for the App_Registry instance
     * @var App_Registry
     */
    private static $instance;


    /**
     * PlaceHolders for Objects registred by the Registry
     * @var array
     */
    private $data = array();


    /**
     * Class Construtor
     *
     * @access prvate
     */
    private function __construct()
    {
    }


    /**
     * Get an Singleton Instance of the App_Registry
     *
     * @static
     * @return App_Registry
     */
    public static function getInstance()
    {
        if (null == self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }


    /**
     * Set Object to the registry
     *
     * @param $name
     * @param $value
     * @return App_Registry
     */
    public function set($name, $value)
    {
        if (!is_object($value)) {
            throw new Exception(sprintf(
                '%s is not an object, could not register it into the Registry',
                $name
            ));
        }

        $this->data[$name] = $value;
        return $this;
    }


    /**
     * Get an Object from the Registry
     *
     * @param $name
     * @return mixed
     * @throws Exception
     */
    public function get($name)
    {
        if (!isset($this->data[$name])) {
            throw new Exception('Object does not exist in the registry');
        }

        return $this->data[$name];

    }


    /**
     * Magic Set method
     * proxy's to the Set() method
     *
     * @access private
     * @param $name
     * @param $value
     * @return App_Registry
     */
    public function __set($name, $value)
    {
        return $this->set($name, $value);
    }


    /**
     * Magic Get Method
     * proxy's to the Get() method
     *
     * @access private
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->get($name);
    }


    /**
     * Magic Clone function
     *
     * @throws Exception
     */
    private function __clone()
    {
        throw new Exception('Cloning is not allowed on the Registry');
    }
}