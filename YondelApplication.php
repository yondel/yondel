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
            '/'                             => array('controller' => 'status', 'action' => 'index'),
            '/user/:mailaddress'            => array('controller' => 'status', 'action' => 'user'),
            '/user/:mailaddress/status/:id' => array('controller' => 'status', 'action' => 'show'),
            '/account'                      => array('controller' => 'account', 'action' => 'index'),
            '/account/:action'              => array('controller' => 'account'),
            '/register'                     => array('controller' => 'register', 'action' => 'register'),
            '/add'                          => array('controller' => 'add', 'action' => 'index'),
            '/completed'                    => array('controller' => 'completed', 'action' => 'index'),
        );
    }

    protected function configure()
    {
        $this->db_manager->connect('master', array(
            'dsn'      => 'mysql:dbname=heroku_298465b03b9924b;host=us-cdbr-iron-east-01.cleardb.net',
            'user'     => 'b52028346a3773',
            'password' => '9cad5b4e',
        ));
    }
}
