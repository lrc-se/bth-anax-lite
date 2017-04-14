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
    
    public function href($url, $asset = false)
    {
        return ($asset ? $this->url->asset($url) : $this->url->create($url));
    }
    
    /**
     * @SuppressWarnings(PHPMD.ExitExpression)
     */
    public function redirect($url)
    {
        $this->response->redirect($this->href($url));
        exit;
    }
    
    public function esc($str)
    {
        return htmlspecialchars($str);
    }
    
    /**
     * Creates a default composite view layout.
     */
    public function defaultLayout($title, $views, $code = 200)
    {
        $this->view->add('incl/header', [
            'title' => $title,
            'flash' => 'bg-main.jpg'
        ]);
        if (is_array($views)) {
            foreach ($views as $view) {
                if (is_array($view)) {
                    $this->view->add($view['path'], $view['data']);
                } else {
                    $this->view->add($view);
                }
            }
        } else {
            $this->view->add($views);
        }
        $this->view->add('incl/footer');
        $this->response->setBody([$this->view, 'render'])->send($code);
    }
}
