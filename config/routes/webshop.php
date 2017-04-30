<?php

/**
 * Webshop routes.
 */


/**
 * Product list (admin).
 */
$app->router->get('user/webshop-admin', function () use ($app) {
    // parse and validate request
    $admin = $app->verifyAdmin();
    $params = [
        'search' => $app->request->getGet('search', ''),
        'sort' => $app->request->getGet('sort', 'id'),
        'desc' => (int)$app->request->getGet('desc'),
        'num' => (int)$app->request->getGet('num', 10),
        'page' => max((int)$app->request->getGet('page'), 1)
    ];
    if (!in_array($params['sort'], \LRC\Webshop\Product::ORDER_BY)) {
        $params['sort'] = 'id';
    }
    $arrow = ($params['desc'] ? '&darr;' : '&uarr;');
    
    // filter and paginate users
    $pf = new \LRC\Webshop\ProductFunctions($app->db);
    $match = ($params['search'] !== '' ? $params['search'] : null);
    $order = $params['sort'] . ($params['desc'] ? ' DESC' : ' ASC');
    $nums = [0, 3, 5, 10, 25];
    if (!in_array($params['num'], $nums)) {
        $params['num'] = 10;
    }
    $matches = $pf->getTotal($match);
    $max = ($params['num'] > 0 ? ceil($matches / $params['num']) : 1);
    if ($params['page'] > $max) {
        $params['page'] = $max;
    }
    $products = $pf->getMatching($match, $order, $params['num'], ($params['page'] - 1) * $params['num']);
    
    $app->defaultLayout('Webbshopsadministration', [
        [
            'path' => 'webshop/admin-index',
            'data' => [
                'products' => $products,
                'cf' => new \LRC\Webshop\CategoryFunctions($app->db),
                'params' => $params,
                'arrow' => $arrow,
                'matches' => $matches,
                'total' => $pf->getTotal(),
                'max' => $max,
                'nums' => $nums
            ]
        ]
    ]);
});


/**
 * Create product (admin).
 */
$app->router->get('user/webshop-admin/product/create', function () use ($app) {
    $admin = $app->verifyAdmin();
    $cf = new \LRC\Webshop\CategoryFunctions($app->db);
    $app->defaultLayout('Skapa produkt', [
        'webshop/product-create',
        [
            'path' => 'webshop/product-form',
            'data' => [
                'product' => new \LRC\Webshop\Product(),
                'categories' => $cf->getAll(),
                'action' => 'user/webshop-admin/product/create'
            ]
        ]
    ]);
});


/**
 * Create user processor (admin).
 */
$app->router->post('user/webshop-admin/product/create', function () use ($app) {
    // authorize request
    $admin = $app->verifyAdmin();
    $pf = new \LRC\Webshop\ProductFunctions($app->db);
    $product = $pf->populateProduct($app->request);
    
    // validate input
    $errors = $pf->getValidationErrors($app->request);
    if (count($errors) === 0) {
        // store new product and return to admin page
        $pf->save($product);
        $app->session->set('msg', 'Produkten <strong>' . $product->name . '</strong> har skapats.');
        $app->redirect('user/webshop-admin');
    }
    
    // return to form
    $cf = new \LRC\Webshop\CategoryFunctions($app->db);
    $app->session->set('err', '<p><strong>Följande fel inträffade:</strong></p><ul><li>' . implode('</li><li>', $errors) . '</li></ul>');
    $app->defaultLayout('Skapa produkt', [
        'webshop/product-create',
        [
            'path' => 'webshop/product-form',
            'data' => [
                'product' => $product,
                'categories' => $cf->getAll(),
                'action' => 'user/webshop-admin/product/create'
            ]
        ]
    ]);
});


/**
 * Edit product (admin).
 */
$app->router->get('user/webshop-admin/product/edit/{id}', function ($id) use ($app) {
    // authorize request
    $admin = $app->verifyAdmin();
    $pf = new \LRC\Webshop\ProductFunctions($app->db);
    $product = $pf->getById($id);
    if (!$product) {
        $app->session->set('err', 'Kunde inte hitta produkten med ID ' . $app->esc($id) . '.');
        $app->redirect('user/webshop-admin');
    }
    
    $cf = new \LRC\Webshop\CategoryFunctions($app->db);
    $app->defaultLayout('Redigera produkt', [
        'webshop/product-edit',
        [
            'path' => 'webshop/product-form',
            'data' => [
                'product' => $product,
                'categories' => $cf->getAll(),
                'action' => "user/webshop-admin/product/edit/$id"
            ]
        ]
    ]);
});


/**
 * Edit product processor (admin).
 */
$app->router->post('user/webshop-admin/product/edit/{id}', function ($id) use ($app) {
    // authorize request
    $admin = $app->verifyAdmin();
    $pf = new \LRC\Webshop\ProductFunctions($app->db);
    $product = $pf->getById($id);
    if (!$product) {
        $app->session->set('err', 'Kunde inte hitta produkten med ID ' . $app->esc($id) . '.');
        $app->redirect('user/webshop-admin');
    }
    
    // validate input
    $product = $pf->populateProduct($app->request);
    $errors = $pf->getValidationErrors($app->request);
    if (count($errors) === 0) {
        // store edited product and return to admin page
        $pf->save($product);
        $app->session->set('msg', 'Produkten <strong>' . $product->name . '</strong> har uppdaterats.');
        $app->redirect('user/webshop-admin');
    }
    
    // return to form
    $cf = new \LRC\Webshop\CategoryFunctions($app->db);
    $app->session->set('err', '<p><strong>Följande fel inträffade:</strong></p><ul><li>' . implode('</li><li>', $errors) . '</li></ul>');
    $app->defaultLayout('Redigera produkt', [
        'webshop/product-edit',
        [
            'path' => 'webshop/product-form',
            'data' => [
                'product' => $product,
                'categories' => $cf->getAll(),
                'action' => "user/webshop-admin/product/edit/$id"
            ]
        ]
    ]);
});


/**
 * Add stock.
 */
$app->router->get('user/webshop-admin/product/restock/{id}', function ($id) use ($app) {
    // authorize request
    $admin = $app->verifyAdmin();
    $pf = new \LRC\Webshop\ProductFunctions($app->db);
    $product = $pf->getById($id);
    if (!$product) {
        $app->session->set('err', 'Kunde inte hitta produkten med ID ' . $app->esc($id) . '.');
        $app->redirect('user/webshop-admin');
    }
    
    $app->defaultLayout('Lagerför leverans', [
        [
            'path' => 'webshop/product-restock',
            'data' => [
                'product' => $product,
                'amount' => null
            ]
        ]
    ]);
});


/**
 * Add stock processor.
 */
$app->router->post('user/webshop-admin/product/restock/{id}', function ($id) use ($app) {
    // authorize request
    $admin = $app->verifyAdmin();
    $pf = new \LRC\Webshop\ProductFunctions($app->db);
    $product = $pf->getById($id);
    if (!$product) {
        $app->session->set('err', 'Kunde inte hitta produkten med ID ' . $app->esc($id) . '.');
        $app->redirect('user/webshop-admin');
    }
    
    // validate input
    $amount = trim($app->request->getPost('amount'));
    if (!is_numeric($amount) || (int)$amount != $amount || $amount == 0) {
        $app->session->set('err', 'Antalet måste vara ett heltal och kan inte vara 0.');
    } elseif ($product->stock + $amount < 0) {
        $app->session->set('err', 'Det går inte att minska lagersaldot med fler produkter än det finns i lager.');
    } else {
        // store updated stock level and return to admin page
        $pf->addStock($product->id, (int)$amount);
        $app->session->set('msg', 'Lagersaldot för produkten <strong>' . $product->name . '</strong> har uppdaterats.');
        $app->redirect('user/webshop-admin');
    }
    
    // return to form
    $app->defaultLayout('Lagerför leverans', [
        [
            'path' => 'webshop/product-restock',
            'data' => [
                'product' => $product,
                'amount' => $amount
            ]
        ]
    ]);
});


/**
 * Stock alerts as JSON.
 */
$app->router->add('user/webshop-admin/product/alert', function () use ($app) {
    $app->response->sendJSON($app->db->query('SELECT * FROM oophp_viewalert;'));
});
