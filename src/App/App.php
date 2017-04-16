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
    public $cookie;
    public $db;
    public $navbar;
    public $router;
    
    
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->request = new \Anax\Request\Request();
        $this->response = new \Anax\Response\Response();
        $this->url = new \Anax\Url\Url();
        $this->view = new \Anax\View\ViewContainer();
        $this->router = new \Anax\Route\RouterInjectable();
        $this->session = new \LRC\Session\Session();
        $this->cookie = new \LRC\Cookie\Cookie();
        $this->db = new \LRC\Database\DbConnection();
        $this->navbar = new \LRC\Navbar\Navbar($this);
    }
    
    /**
     * Creates an absolute URL.
     *
     * @param   string  $url    URL to a route or asset.
     * @param   bool    $asset  Whether or not the URL points to an asset rather than a framework route.
     * @return  string          An absolute URL pointing to the route or asset.
     */
    public function href($url, $asset = false)
    {
        return ($asset ? $this->url->asset($url) : $this->url->create($url));
    }
    
    /**
     * Redirects to another route.
     *
     * @param   string  $url    The route to redirect to.
     *
     * @SuppressWarnings(PHPMD.ExitExpression)
     */
    public function redirect($url)
    {
        $this->response->redirect($this->href($url));
        exit;
    }
    
    /**
     * Merges new parameter values into the existing query string.
     *
     * @param   array   $arr    An associative array containing new or updated key/value parameter pairs.
     * @return  string          The merged query string, without the leading "?".
     */
    public function mergeQS($arr)
    {
        parse_str($this->request->getServer('QUERY_STRING'), $params);
        $params = array_merge($params, $arr);
        return http_build_query($params);
    }
    
    /**
     * Escapes a string for direct output in a view.
     *
     * @param   string  $str    The string to sanitize.
     * @return  string          The sanitized string.
     */
    public function esc($str)
    {
        return htmlspecialchars($str);
    }
    
    /**
     * Creates and outputs a default composite view layout.
     *
     * @param   string          $title  Page title.
     * @param   string|array    $views  A path to a view file, or an array of either paths or arrays defining paths and data for one or more views.
     * @param   int             $code   HTTP status code.
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
    
    /**
     * Returns the current user from ID stored in the session, if any.
     *
     * @return  \LRC\User\User|null
     */
    public function getUser()
    {
        $id = $this->session->get('user', null);
        if ($id) {
            $uf = new \LRC\User\Functions($this->db);
            return $uf->getById($id);
        }
        return null;
    }
    
    /**
     * Verifies that there is a logged-in user, redirecting to the login page if not.
     *
     * @return  \LRC\User\User|null     The logged-in user, if any.
     */
    public function verifyUser()
    {
        $user = $this->getUser();
        if (!$user) {
            $this->session->set('err', 'Du måste logga in för att kunna nå den efterfrågade sidan.');
            $this->session->set('redirect', $this->request->getCurrentUrl());
            $this->redirect('user/login');
        }
        return $user;
    }
    
    /**
     * Verifies that there is a logged-in administrator, redirecting to the login page if not.
     *
     * @param   bool                $super  Whether or not the user must also be a super admin.
     * @return  \LRC\User\User|null         The logged-in administrator, if any.
     */
    public function verifyAdmin($super = false)
    {
        $user = $this->getUser();
        if (!$user || !$user->isAdmin($super)) {
            $this->session->set('err', 'Du måste logga in som ' . ($super ? 'superadministratör' : 'administratör') . ' för att kunna nå den efterfrågade sidan.');
            $this->session->set('redirect', $this->request->getCurrentUrl());
            $this->redirect('user/login');
        }
        return $user;
    }
}
