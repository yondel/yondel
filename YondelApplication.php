<?php

class YondelApplication extends Application
{
    protected $login_aciton = array('account', 'signin');

    public function getRootDir()
    {
        return dirname(__FILE__);
    }

    protected function registerRoutes()
    {
        return array(
            '/' => array('controller' => 'top', 'action' => 'top'),
        );
    }

    protected function configure()
    {
//        $this->db_manager->connect('master', array(
//            'dsn' => '',
//            'user' => '',
//            'password' => '',
//        ));
    }
}
