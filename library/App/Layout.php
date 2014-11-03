<?php

namespace App;

class Layout extends View
{
    /**
     * Path to templates
     * @var string
     */
    protected $templatePath = 'layouts';

    /**
     * Default Layout template
     * @var string
     */
    private $template = 'default';



    /**
     * Placeholder for the View Object
     * @var \App\View
     */
    private $view;


    /**
     * set an alternative layout
     * @param string $template
     * @return \App\Layout
     */
    public function setLayout($template)
    {
        $this->template = $template;
        return $this;
    }


    /**
     * Set the View Object
     * @param \App\View $view
     * @return \App\Layout
     */
    public function setView(\App\View $view)
    {
        $this->view = $view;
        return $this;
    }


    /**
     * Get the View Object
     * @return \App\View
     */
    public function getView()
    {
        return $this->view;
    }



    /**
     * @return string
     */
    protected function getTemplate()
    {
        return implode(
            DIRECTORY_SEPARATOR,
            array(
                APPLICATION_PATH,
                $this->templatePath,
                $this->template . $this->templateExtention
            )
        );
    }
}