<?php

namespace App;

final class Config
{
    /**
     * Path to default config file
     */
    const DEFAULT_CONFIG_FILE = '/configs/application.ini';



    /**
     * PlaceHolder for self (Singlton)
     *
     * @var App_Config
     */
    public static $instance;



    /**
     * Get the Instance of self
     *
     * @return App_Config
     */
    public static function getInstance()
    {
        if (null == self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }


    /**
     * Class Constructor
     *
     * @param array $options
     * @internal param array $config
     * @access private
     */
    private function __construct(array $options=array())
    {
        if (empty($options)) {
            $options = parse_ini_file(
                APPLICATION_PATH . self::DEFAULT_CONFIG_FILE,
                'development'
            );


            $options = $this->getEnviromentSection($options);
        }

        $this->setConfig($options);
    }



    /**
     * Set config options, sets recurivly if it's a multydimentional array
     *
     * @param array $options
     * @access private
     * @return App_Config
     */
    private function setConfig(array $options=array())
    {
        foreach ($options as $key => $value) {

            if (is_array($value) && !empty($value)) {
                $value = new self($value);
            }

            $this->$key = $value;
        }

        return $this;
    }



    /**
     * Magic method get
     *
     * This get's triggerd if there is a call made to an undefined property in
     * the Isource_Config instance or subInstance, so we throw an Exception
     *
     * @param string $name
     * @throws Exception
     */
    public function __get($name)
    {
        throw new Exception('call to undefined property: ' . $name);
    }


    /**
     * Get the Application Enviroment Section from the Config based on the APPLICATION_ENV constant
     * @param array $options
     * @return array
     */
    private function getEnviromentSection(array $options = array())
    {
        if (array_key_exists(APPLICATION_ENV, $options)) {
            $options = $options[APPLICATION_ENV];
        }

        return $options;
    }
}