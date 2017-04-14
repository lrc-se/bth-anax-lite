<?php 

namespace LRC\App;

/**
 * App class to wrap the resources of the framework.
 */
class App
{
    public $request;
    public $response;
    public $url;
    public $view;
    public $session;
    public $db;
    public $navbar;
    public $router;
    
    
    public function __construct()
    {
        $this->request = new \Anax\Request\Request();
        $this->response = new \Anax\Response\Response();
        $this->url = new \Anax\Url\Url();
        $this->view = new \Anax\View\ViewContainer();
        $this->router = new \Anax\Route\RouterInjectable();
        $this->session = new \LRC\Session\Session();
        $this->db = new \LRC\Database\DbConnection();
        $this->navbar = new \LRC\Navbar\Navbar($this);
    }
}
