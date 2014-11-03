<?php

namespace App;

class FrontController
{
    /**
     * @var App_Request
     */
    public $request;


    /**
     * Class Constructor
     *
     * @param App_Config $config
     */
    public function __construct(\App\Config $config)
    {
        Registry::getInstance()
                    ->set('Config', $config)
                    ->set(
                        'Request',
                        new \App\Request()
        );


        $this->request = \App\Registry::getInstance()->get('Request');
    }


    /**
     * Run the Application
     *
     * @todo Bind View to the Controller
     */
    public function run()
    {
        // get controller
        $controller = preg_replace(
            '/\-([a-zA-Z]){1}/e',
            'ucfirst("$1")',
            ucfirst(strtolower($this->request->getControllerName()))
        ) . 'Controller';

        // get action
        $action = $this->request->getActionName() . 'Action';


        // get controller path
        $controllerPath = realpath(
            \App\Config::getInstance()->controllerDirectory
        ) . '/' . $controller . '.php';



        $view = new \App\View();
        $layout = new \App\Layout();

        $layout->setView($view);


        /**
         * Arg, freaking hack, i hate this...
         * need to refactor it..
         */
        if (!file_exists($controllerPath)) {

            $controllerPath = Config::getInstance()->controllerDirectory
            . '/ErrorController.php';

            $controller = "ErrorController";
            $this->request->controller = "error";
            $this->request->action = "error";
            $action = "errorAction";

            header("HTTP/1.0 404 Not Found");
        }


        if ($controller === 'ArticlesController' && ($action !== 'indexAction')) {

            $this->request->addParam('slug', $this->request->getActionName());

            $this->request->action = 'view';
            $action = 'viewAction';
        }




        include($controllerPath);
        $controller = new $controller;

        if (!method_exists($controller, $action)) {
            $controllerPath = Config::getInstance()->controllerDirectory
            . '/ErrorController.php';

            $controller = "ErrorController";
            $this->request->controller = "error";
            $this->request->action = "error";
            $action = "errorAction";
            include($controllerPath);

            $controller = new $controller;
            header("HTTP/1.0 404 Not Found");
        }


        try {
            $controller->setView($view)
                       ->setLayout($layout)
                       ->$action();

        }
        catch (\Exception $e) {
            $controllerPath = Config::getInstance()->controllerDirectory
            . '/ErrorController.php';
            $controller = "ErrorController";
            $this->request->controller = "error";
            $this->request->action = "error";
            $action = "errorAction";
            include($controllerPath);

            $controller = new $controller;
            header("HTTP/1.0 404 Not Found");

            $controller->setView($view)
                       ->setLayout($layout)
                       ->$action();
        }


        $layout->content = $view;

        // save cache
        \App\Cache::save($layout);

        echo $layout;
    }
}