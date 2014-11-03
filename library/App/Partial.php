<?php

namespace App;

class Partial extends \App\View
{

    /**
     * Gets the partial template
     * @return type
     */
    protected function getTemplate()
    {
        return implode(
            DIRECTORY_SEPARATOR,
            array(
                APPLICATION_PATH,
                $this->templatePath,
                $this->templateFile . $this->templateExtention
            )
        );
    }
}
