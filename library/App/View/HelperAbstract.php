<?php

namespace App\View;

abstract class HelperAbstract
{

    /**
     * PlaceHolder for the HelperBroker
     * @var App_HelperBroker
     */
    protected $helperBroker;


    /**
     * Class Contructor
     * @param App_HelperBroker $helperBroker
     */
    final public function __construct(\App\HelperBroker $helperBroker)
    {
        $this->helperBroker = $helperBroker;
    }



    /**
     * Get HelperBroker
     * @return App_HelperBroker
     */
    public function getHelperBroker()
    {
        return $this->helperBroker;
    }



    /**
     * Set Options
     * @param array $options
     * @throws Exeption
     * @return App_View_Helper_Abstract
     */
    public function setOptions(array $options=array())
    {
        foreach ($options as $method => $param) {

            $method = 'set' . ucfirst($method);

            if (!method_exists($this, $method)) {
                throw new Exeption(sprintf(
                    'Method %s was not found in the helper %s',
                    $method,
                    get_class($this)
                ));
            }

            $this->$method($param);
        }

        return $this;
    }
}
