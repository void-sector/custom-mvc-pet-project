<?php

class ArticlesController extends \App\Controller\ControllerAbstract
{
    public function indexAction()
    {
        $this->layout->title = "Articles";
        
        $this->view->articles = $this->getEntityManager()
                                     ->getRepository('\Model\entities\Article')
                                     ->findBy(array('published' => 'y'), array('id' => 'DESC'));
    }


    public function viewAction()
    {
        // try to find article
        $this->view->article = $this->getEntityManager()
                                    ->getRepository('\Model\entities\Article')
                                    ->findOneBy(
                                        array(
                                            'slug' => $this->getRequest()->getParam('slug'),
                                            'published' => 'y'
                                        )
                                    );

        
        // throw exception if article is not found
        if (null === $this->view->article) {
            throw new \Exception('Item not found');
        }

        // set Layout Title
        $this->layout->title = $this->view->article->title;
    }
}