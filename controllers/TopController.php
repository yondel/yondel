<?php

class TopController extends Controller
{
    public function topAction() {
        /*
         * render($variables = array(), $template = null, $layout = 'layout')
         */
        $variables = array(
            'hoge' => 'hogehoge',
        );
        return $this->render($variables);
    }
}
