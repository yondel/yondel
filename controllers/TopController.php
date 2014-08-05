<?php

class TopController extends Controller
{
    public function topAction() {
        /*
         * render($variables = array(), $template = null, $layout = 'layout')
         */
//        $amazonApi = new AmazonApiModel();
//        $data = $amazonApi->getData();
//        $variables = array(
//            'amazonData' => $data,
//        );
        return $this->render();
    }
}
