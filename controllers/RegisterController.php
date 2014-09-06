<?php

class RegisterController extends Controller
{
    public function registerAction() {
        $variables = array(
            'test' => 'fooooooooo',
        );
        /*
         * render($variables = array(), $template = null, $layout = 'layout')
         */
        return $this->render($variables);
    }
}
