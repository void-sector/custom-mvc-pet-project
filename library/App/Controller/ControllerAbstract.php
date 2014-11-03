<?php

namespace App\Controller;

abstract class ControllerAbstract
{
    /**
     * PlaceHolder for the App_View
     * @var App_View
     */
    protected $view;


    /**
     * PlaceHolder for the App_Layout
     * @var App_Layout
     */
    protected $layout;


    /**
     * PlaceHolder for the App_Request Instance
     * @var App_Request
     */
    protected $request;


    /**
     * Doctrine\EntityManager
     * @var EntiyManager
     */
    protected $entityManager;



    /**
     * Get the Request object from the Registry
     * @return App_Request
     */
    public function getRequest()
    {
        if (null === $this->request) {
            $this->request = \App\Registry::getInstance()->get('Request');
        }

        return $this->request;
    }


    /**
     * Set the View Object to the Controller
     * @param App_View $view
     * @return App_Controller_Abstract
     */
    public function setView(\App\View $view)
    {
        $this->view = $view;
        return $this;
    }


    /**
     * Set the Layout Object to the Controller
     * @param App_Layout $layout
     * @return App_Controller_Abstract
     */
    public function setLayout(\App\Layout $layout)
    {
        $this->layout = $layout;
        return $this;
    }


    /**
     * @todo Refactoren
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager()
    {
        if (null == $this->entityManager) {

            $classLoader = new \Doctrine\Common\ClassLoader('Doctrine', 'DoctrineORM');
            $classLoader->register(); // register on SPL autoload stack

            $classloader = new \Doctrine\Common\ClassLoader('model', __DIR__);
            $classloader->register();

            $config = new \Doctrine\ORM\Configuration();
            $cache = new \Doctrine\Common\Cache\ArrayCache();
            $config->setMetadataCacheImpl($cache);
            $config->setQueryCacheImpl($cache);

            $driverImpl = $config->newDefaultAnnotationDriver('model');
            $config->setMetadataDriverImpl($driverImpl);
            $config->setProxyDir('proxies');
            $config->setProxyNamespace('proxies');

            $config->setAutoGenerateProxyClasses(true);
            $config->getAutoGenerateProxyClasses();

            $this->entityManager = \Doctrine\ORM\EntityManager::create(
                (array) \App\Config::getInstance()->db,
                $config
            );
        }

        return $this->entityManager;
    }
}