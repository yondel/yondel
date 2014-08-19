<?php

class RegisterController extends Controller
{
    public function registerAction() {
        $variables = array(
            'title' => 'register',
        );
        /*
         * render($variables = array(), $template = null, $layout = 'layout')
         */
        return $this->render($variables);
    }
}
