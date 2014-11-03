<?php

/**
 * @todo set default path to templates dir from config !?! into this object
 * @todo docblocks
 */
namespace App;

class View
{
    /**
     * Path to templates
     * @todo put this in the .ini configuration
     * @var string
     */
    protected $templatePath = 'views/scripts';


    /**
     * PlaceHolder for all the variables set to the ViewObject
     * @var array
     */
    protected $data = array();


    /**
     * @todo see if this is still nececary
     * @var null
     */
    protected $templateFile;


    /**
     * @todo place this in the application.ini
     * @var string
     */
    protected $templateExtention = '.phtml';



    /**
     * Class Constructor
     * @param null $templateFile
     */
    public function __construct($templateFile=null)
    {
        if(null !== $templateFile) {
            $this->templateFile = $templateFile;
        }
    }


    /**
     * Sets a variable
     * @param string $name
     * @param mixed $value
     * @return App_View
     */
    public function set($name, $value)
    {
        $this->data[$name] = $value;
        return $this;
    }


    /**
     * Gets a variable
     * @param mixed $name
     * @return string
     */
    public function get($name)
    {
        return $this->data[$name];
    }


    /**
     * Dispatch the view
     * @return string
     */
    public function dispatch()
    {
        ob_start();
        require_once($this->getTemplate());
        return ob_get_clean();
    }


    /**
     * Get's the view template based on the Request
     * @return string
     */
    protected function getTemplate()
    {
        $request = Registry::getInstance()->get('Request');

        return implode(
            DIRECTORY_SEPARATOR,
            array(
                APPLICATION_PATH,
                $this->templatePath,
                $request->getControllerName(),
                $request->getActionName() . $this->templateExtention
            )
        );
    }


    /**
     * Enables you to use partial views, partial views are view objects that
     * extends from the app_view self
     *
     * @param string $template
     * @param array $params
     * @return App_Partial
     */
    public function partial($template, array $params=array())
    {
        $partial = new \App\Partial($template);

        foreach ($params as $key => $value) {
            $partial->set($key, $value);
        }

        return $partial;
    }


    /**
     * Call's to undefined methods are proxyed to the App_HelperBroker
     *
     * @param string $helper
     * @param array $params
     * @return mixed the result of the called helper
     */
    public function __call($helper, array $params)
    {
        return call_user_func_array(
            array(
                \App\HelperBroker::getInstance(),
                $helper
            ),
            $params
        );
    }


    /**
     * magicly sets public variables
     * @param string $name
     * @param mixed $value
     * @return App_View
     */
    public function __set($name, $value)
    {
        $this->set($name, $value);
        return $this;
    }


    /**
     * Magicly get's a variable
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->get($name);
    }


    /**
     * Magic method toString delegates to the dispatch method
     * @return string the result of the App_View object and the template combined
     */
    public function __toString()
    {
        return $this->dispatch();
    }
}