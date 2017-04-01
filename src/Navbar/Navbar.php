<?php

namespace LRC\Navbar;

class Navbar implements \Anax\Common\ConfigureInterface
{
    use \Anax\Common\ConfigureTrait;
    
    private $app;
    
    
    /**
     * Constructor.
     */
    public function __construct($app)
    {
        $this->app = $app;
    }
    
    /**
     * Returns config data.
     */
    public function getData($key)
    {
        return (array_key_exists($key, $this->config['data']) ? $this->config['data'][$key] : null);
    }
    
    /**
     * Returns the rendered HTML for the navbar items.
     */
    public function renderItems()
    {
        return $this->renderLevel($this->config['items']);
    }
    
    /**
     * Checks whether the specified route is active.
     */
    private function isActiveRoute($route)
    {
        $current = $this->app->request->getRoute();
        if (empty($route)) {
            return ($current === $route);
        }
        return (substr($current . '/', 0, strlen($route) + 1) === $route . '/');
    }
    
    /**
     * Checks whether the specified nav item is active.
     */
    private function isActiveItem($item)
    {
        // check subitems, if any
        if (isset($item['items']) && is_array($item['items'])) {
            foreach ($item['items'] as $subitem) {
                if ($this->isActiveItem($subitem)) {
                    return true;
                }
            }
        }
        
        return $this->isActiveRoute($item['route']);
    }
    
    /**
     * Recursively renders a list of navbar items.
     */
    private function renderLevel($items, $level = 1)
    {
        $list = "<ul>\n";
        foreach ($items as $item) {
            // set style classes
            $hasChildren = (isset($item['items']) && is_array($item['items']));
            $classes = [];
            if ($this->isActiveItem($item)) {
                $classes[] = 'active';
            }
            if ($hasChildren) {
                $classes[] = 'sub';
            }
            $list .= '<li' . (count($classes) > 0 ? ' class="' . implode(' ', $classes) . '"' : '') . ' data-level="' . $level . '">';
            
            // render link, if any
            if (!is_null($item['route'])) {
                $list .= '<a href="' . $this->app->url->create($item['route']) . '">' . $item['title']  . '</a>';
            } else {
                $list .= '<span>' . $item['title'] . '</span>';
            }
            
            // render subitems, if any
            if ($hasChildren) {
                $list .= "\n" . $this->renderLevel($item['items'], $level + 1);
            }
            
            $list .= "</li>\n";
        }
        return "$list</ul>\n";
    }
}
