<?php

class CompletedController extends Controller
{
    public function indexAction() {
        $variables = array(
        );
        /*
         * render($variables = array(), $template = null, $layout = 'layout')
         */
        return $this->render($variables);
    }
}
