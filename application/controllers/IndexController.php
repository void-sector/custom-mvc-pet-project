<?php

class IndexController extends \App\Controller\ControllerAbstract
{
    public function indexAction()
    {
        $this->layout->title = "Home";

        $this->view->articles = $this->getEntityManager()
                                     ->getRepository('\Model\entities\Article')
                                     ->findBy(array('published' => 'y'), array('id' => 'DESC'));
    }
}