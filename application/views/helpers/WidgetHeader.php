<?php

class WidgetHeader extends \App\View\HelperAbstract
{
    public function direct($title)
    {
        return '<header class="sidebar-header">'
             . '<h1>' . $title . '</h1>'
             . '</header>';
    }
}
