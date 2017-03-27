<?php

/**
 * Navbar.
 */

require ANAX_INSTALL_PATH . '/config/navbar.php';


/**
 * Checks whether the specified route is active.
 */
function is_active_route($route)
{
    global $app;
    $current = $app->request->getRoute();
    if (empty($route)) {
        return ($current === $route);
    }
    return (substr($current . '/', 0, strlen($route) + 1) === $route . '/');
}

/**
 * Checks whether the specified nav item is active.
 */
function is_active_item($item)
{
    // check subitems, if any
    if (isset($item['items']) && is_array($item['items'])) {
        foreach ($item['items'] as $subitem) {
            if (is_active_item($subitem)) {
                return true;
            }
        }
    }
    
    return is_active_route($item['route']);
}

/**
 * Recursively renders a list of navbar items.
 */
function render_level($items, $level = 1)
{
    global $app;
    $list = "<ul>\n";
    foreach ($items as $item) {
        // set style classes
        $hasChildren = (isset($item['items']) && is_array($item['items']));
        $classes = [];
        if (is_active_item($item)) {
            $classes[] = 'active';
        }
        if ($hasChildren) {
            $classes[] = 'sub';
        }
        $list .= '<li' . (count($classes) > 0 ? ' class="' . implode(' ', $classes) . '"' : '') . ' data-level="' . $level . '">';
        
        // render link, if any
        if (!is_null($item['route'])) {
            $list .= '<a href="' . $app->url->create($item['route']) . '">' . $item['title']  . '</a>';
        } else {
            $list .= '<span>' . $item['title'] . '</span>';
        }
        
        // render subitems, if any
        if ($hasChildren) {
            $list .= "\n" . render_level($item['items'], $level + 1);
        }
        
        $list .= "</li>\n";
    }
    return "$list</ul>\n";
}

?>
<nav class="<?= $navbar['data']['class'] ?> container clear">
    <button id="menu-toggle">Meny</button>
    <a class="logo" href="<?= $app->url->create('') ?>">Kalles sida</a>
<?= render_level($navbar['items']) ?>
</nav>
