<?php

/**
 * Content routes.
 */


/**
 * Content list (regular user).
 */
$app->router->get('user/content', function () use ($app) {
    // parse and validate request
    $user = $app->verifyUser();
    $params = [
        'sort' => $app->request->getGet('sort', 'id'),
        'desc' => (int)$app->request->getGet('desc'),
        'num' => (int)$app->request->getGet('num'),
        'page' => max((int)$app->request->getGet('page'), 1)
    ];
    if (!in_array($params['sort'], \LRC\Content\Content::ORDER_BY) || $params['sort'] == 'username') {
        $params['sort'] = 'id';
    }
    $arrow = ($params['desc'] ? '&darr;' : '&uarr;');
    
    // retrieve and paginate content
    $cf = new \LRC\Content\Functions($app->db);
    $order = $params['sort'] . ($params['desc'] ? ' DESC' : ' ASC');
    $nums = [0, 3, 5, 10, 25];
    if (!in_array($params['num'], $nums)) {
        $params['num'] = 0;
    }
    $total = $cf->getTotal($user->id);
    $max = ($params['num'] > 0 ? ceil($total / $params['num']) : 1);
    if ($params['page'] > $max) {
        $params['page'] = $max;
    }
    $entries = $cf->getAll($user->id, $order, $params['num'], ($params['page'] - 1) * $params['num']);
    
    $app->defaultLayout((strtolower($user->username[strlen($user->username) - 1]) == 's' ? $user->username : $user->username . 's') . ' innehåll', [
        [
            'path' => 'content/user-index',
            'data' => [
                'admin' => false,
                'entries' => $entries,
                'params' => $params,
                'arrow' => $arrow,
                'total' => $total,
                'max' => $max,
                'nums' => $nums
            ]
        ]
    ]);
});


/**
 * Create content (regular user).
 */
$app->router->get('user/content/create', function () use ($app) {
    $user = $app->verifyUser();
    $app->defaultLayout('Skapa innehåll', [
        'content/create',
        [
            'path' => 'content/form',
            'data' => [
                'content' => new \LRC\Content\Content(),
                'action' => 'user/content/create',
                'admin' => false,
                'publish' => 'now'
            ]
        ]
    ]);
});


/**
 * Create content processor (regular user).
 */
$app->router->post('user/content/create', function () use ($app) {
    // authorize request
    $user = $app->verifyUser();
    $cf = new \LRC\Content\Functions($app->db);
    $content = $cf->populateEntry($app->request);
    $content->userId = $user->id;
    
    // validate input
    $errors = $cf->getValidationErrors($app->request);
    if (count($errors) === 0) {
        // store new content entry and show success message
        $cf->save($content);
        $app->session->set('msg', 'Innehållet har sparats.');
        $app->redirect('user/content/edit/' . $content->id);
    }
    
    // return to form
    $app->session->set('err', '<p><strong>Följande fel inträffade:</strong></p><ul><li>' . implode('</li><li>', $errors) . '</li></ul>');
    $app->defaultLayout('Skapa innehåll', [
        'content/create',
        [
            'path' => 'content/form',
            'data' => [
                'content' => $content,
                'action' => 'user/content/create',
                'admin' => false,
                'publish' => $app->request->getPost('publish')
            ]
        ]
    ]);
});


/**
 * Edit content (regular user).
 */
$app->router->get('user/content/edit/{id}', function ($id) use ($app) {
    // authorize request
    $user = $app->verifyUser();
    $cf = new \LRC\Content\Functions($app->db);
    $content = $cf->getById($id);
    if (!$content || $content->deleted) {
        $app->session->set('err', 'Kunde inte hitta aktivt innehåll med ID ' . $app->esc($id) . '.');
        $app->redirect('user/content');
    }
    if ($content->userId != $user->id) {
        $app->session->set('err', 'Du har inte behörighet att redigera det efterfrågade innehållet.');
        $app->redirect('user/content');
    }
    
    $app->defaultLayout('Redigera innehåll', [
        'content/edit',
        [
            'path' => 'content/form',
            'data' => [
                'content' => $content,
                'action' => 'user/content/edit',
                'admin' => false,
                'publish' => ($content->published ? 'same' : 'un'),
                'published' => !is_null($content->published)
            ]
        ]
    ]);
});


/**
 * Edit content processor (regular user).
 */
$app->router->post('user/content/edit', function () use ($app) {
    // authorize request
    $user = $app->verifyUser();
    $cf = new \LRC\Content\Functions($app->db);
    $content = $cf->populateEntry($app->request);
    $oldContent = $cf->getById($content->id);
    if (!$oldContent || $oldContent->deleted) {
        $app->session->set('err', 'Kunde inte hitta aktivt innehåll med ID ' . $app->esc($id) . '.');
        $app->redirect('user/content');
    }
    if ($oldContent->userId != $user->id) {
        $app->session->set('err', 'Du har inte behörighet att redigera det efterfrågade innehållet.');
        $app->redirect('user/content');
    }
    $content->userId = $user->id;
    
    // validate input
    $errors = $cf->getValidationErrors($app->request);
    if (count($errors) === 0) {
        // store updated content and go to index page
        $cf->save($content);
        $app->session->set('msg', 'Innehållet har uppdaterats.');
        $app->redirect('user/content/edit/' . $content->id);
    }
    
    // return to form
    $app->session->set('err', '<p><strong>Följande fel inträffade:</strong></p><ul><li>' . implode('</li><li>', $errors) . '</li></ul>');
    $app->defaultLayout('Redigera innehåll', [
        'content/edit',
        [
            'path' => 'content/form',
            'data' => [
                'content' => $content,
                'action' => 'user/content/edit',
                'admin' => false,
                'publish' => $app->request->getPost('publish'),
                'published' => !is_null($oldContent->published)
            ]
        ]
    ]);
});


/**
 * Remove content (regular user).
 */
$app->router->get('user/content/delete/{id}', function ($id) use ($app) {
    // authorize request
    $user = $app->verifyUser();
    $cf = new \LRC\Content\Functions($app->db);
    $content = $cf->getById($id);
    if (!$content || $content->deleted) {
        $app->session->set('err', 'Kunde inte hitta aktivt innehåll med ID ' . $app->esc($id) . '.');
        $app->redirect('user/content');
    }
    if ($content->userId != $user->id) {
        $app->session->set('err', 'Du har inte behörighet att ta bort det valda innehållet.');
        $app->redirect('user/content');
    }
    
    $app->defaultLayout('Ta bort innehåll', [
        [
            'path' => 'content/delete',
            'data' => [
                'content' => $content,
                'admin' => false
            ]
        ]
    ]);
});


/**
 * Remove content processor (regular user).
 */
$app->router->post('user/content/delete/{id}', function ($id) use ($app) {
    // authorize request
    $user = $app->verifyUser();
    $cf = new \LRC\Content\Functions($app->db);
    $content = $cf->getById($id);
    if (!$content || $content->deleted) {
        $app->session->set('err', 'Kunde inte hitta aktivt innehåll med ID ' . $app->esc($id) . '.');
        $app->redirect('user/content');
    }
    if ($content->userId != $user->id) {
        $app->session->set('err', 'Du har inte behörighet att ta bort det valda innehållet.');
        $app->redirect('user/content');
    }
    
    // remove content and return to content list
    $cf->remove($id);
    $app->session->set('msg', 'Innehållet <strong>' . $app->esc($content->title) . '</strong> har tagits bort.');
    $app->redirect('user/content');
});


/**
 * Content list (admin).
 */
$app->router->get('user/content-admin', function () use ($app) {
    // parse and validate request
    $admin = $app->verifyAdmin();
    $params = [
        'sort' => $app->request->getGet('sort', 'id'),
        'desc' => (int)$app->request->getGet('desc'),
        'num' => (int)$app->request->getGet('num'),
        'page' => max((int)$app->request->getGet('page'), 1)
    ];
    if (!in_array($params['sort'], \LRC\Content\Content::ORDER_BY)) {
        $params['sort'] = 'id';
    }
    $arrow = ($params['desc'] ? '&darr;' : '&uarr;');
    
    // retrieve and paginate content
    $cf = new \LRC\Content\Functions($app->db);
    $order = $params['sort'] . ($params['desc'] ? ' DESC' : ' ASC');
    $nums = [0, 3, 5, 10, 25];
    if (!in_array($params['num'], $nums)) {
        $params['num'] = 0;
    }
    $total = $cf->getTotal();
    $max = ($params['num'] > 0 ? ceil($total / $params['num']) : 1);
    if ($params['page'] > $max) {
        $params['page'] = $max;
    }
    $entries = $cf->getAll(null, $order, $params['num'], ($params['page'] - 1) * $params['num']);
    
    $app->defaultLayout('Innehållsadministration', [
        [
            'path' => 'content/admin-index',
            'data' => [
                'admin' => $admin,
                'entries' => $entries,
                'cf' => $cf,
                'params' => $params,
                'arrow' => $arrow,
                'total' => $total,
                'max' => $max,
                'nums' => $nums
            ]
        ]
    ]);
});


/**
 * Create content (admin).
 */
$app->router->get('user/content-admin/create', function () use ($app) {
    $admin = $app->verifyAdmin();
    $app->defaultLayout('Skapa innehåll', [
        'content/create',
        [
            'path' => 'content/form',
            'data' => [
                'content' => new \LRC\Content\Content(),
                'action' => 'user/content-admin/create',
                'admin' => true,
                'user' => $admin,
                'publish' => $app->request->getPost('publish')
            ]
        ]
    ]);
});


/**
 * Create content processor (admin).
 */
$app->router->post('user/content-admin/create', function () use ($app) {
    // authorize request
    $admin = $app->verifyAdmin();
    $cf = new \LRC\Content\Functions($app->db);
    $content = $cf->populateEntry($app->request);
    $content->userId = $admin->id;
    
    // validate input
    $errors = $cf->getValidationErrors($app->request);
    if (count($errors) === 0) {
        // store new content entry and show success message
        $cf->save($content);
        $app->session->set('msg', 'Innehållet har sparats.');
        $app->redirect('user/content-admin/edit/' . $content->id);
    }
    
    // return to form
    $app->session->set('err', '<p><strong>Följande fel inträffade:</strong></p><ul><li>' . implode('</li><li>', $errors) . '</li></ul>');
    $app->defaultLayout('Skapa innehåll', [
        'content/create',
        [
            'path' => 'content/form',
            'data' => [
                'content' => $content,
                'action' => 'user/content-admin/create',
                'admin' => true,
                'user' => $admin,
                'publish' => $app->request->getPost('publish')
            ]
        ]
    ]);

});


/**
 * Edit user (admin).
 */
$app->router->get('user/content-admin/edit/{id}', function ($id) use ($app) {
    // authorize request
    $admin = $app->verifyAdmin();
    $cf = new \LRC\Content\Functions($app->db);
    $content = $cf->getById($id);
    if (!$content) {
        $app->session->set('err', 'Kunde inte hitta innehållet med ID ' . $app->esc($id) . '.');
        $app->redirect('user/content-admin');
    }
    $user = $cf->getUser($content);
    if ($user && $user->level > $admin->level) {
        $app->session->set('err', 'Du har inte behörighet att redigera det efterfrågade innehållet.');
        $app->redirect('user/content-admin');
    }
    
    $app->defaultLayout('Redigera innehåll', [
        'content/edit',
        [
            'path' => 'content/form',
            'data' => [
                'content' => $content,
                'action' => "user/content-admin/edit/$id",
                'admin' => true,
                'user' => $user,
                'publish' => ($content->published ? ($content->published === 'now' ? 'now' : 'same') : 'un'),
                'published' => !is_null($content->published)
            ]
        ]
    ]);
});


/**
 * Edit content processor (admin).
 */
$app->router->post('user/content-admin/edit/{id}', function ($id) use ($app) {
    // authorize request
    $admin = $app->verifyAdmin();
    $cf = new \LRC\Content\Functions($app->db);
    $oldContent = $cf->getById($id);
    if (!$oldContent) {
        $app->session->set('err', 'Kunde inte hitta innehållet med ID ' . $app->esc($id) . '.');
        $app->redirect('user/content-admin');
    }
    $user = $cf->getUser($oldContent);
    if ($user && $user->level > $admin->level) {
        $app->session->set('err', 'Du har inte behörighet att redigera det efterfrågade innehållet.');
        $app->redirect('user/content-admin');
    }
    
    // validate input
    $content = $cf->populateEntry($app->request);
    $content->userId = $oldContent->userId;
    $errors = $cf->getValidationErrors($app->request);
    if (count($errors) === 0) {
        // store edited content and return to form
        $cf->save($content);
        $app->session->set('msg', 'Innehållet har uppdaterats.');
        $app->redirect('user/content-admin/edit/' . $content->id);
    }
    
    // return to form
    $app->session->set('err', '<p><strong>Följande fel inträffade:</strong></p><ul><li>' . implode('</li><li>', $errors) . '</li></ul>');
    $app->defaultLayout('Redigera innehåll', [
        'content/edit',
        [
            'path' => 'content/form',
            'data' => [
                'content' => $content,
                'action' => "user/content-admin/edit/$id",
                'admin' => true,
                'user' => $user,
                'publish' => $app->request->getPost('publish'),
                'published' => !is_null($oldContent->published)
            ]
        ]
    ]);
});


/**
 * Remove content (admin).
 */
$app->router->get('user/content-admin/delete/{id}', function ($id) use ($app) {
    // authorize request
    $admin = $app->verifyAdmin();
    $cf = new \LRC\Content\Functions($app->db);
    $content = $cf->getById($id);
    if (!$content || $content->deleted) {
        $app->session->set('err', 'Kunde inte hitta aktivt innehåll med ID ' . $app->esc($id) . '.');
        $app->redirect('user/content-admin');
    }
    $user = $cf->getUser($content);
    if ($user && $user->level > $admin->level) {
        $app->session->set('err', 'Du har inte behörighet att ta bort det valda innehållet.');
        $app->redirect('user/content-admin');
    }
    
    $app->defaultLayout('Ta bort innehåll', [
        [
            'path' => 'content/delete',
            'data' => [
                'content' => $content,
                'user' => $user,
                'admin' => true
            ]
        ]
    ]);
});


/**
 * Remove content processor (admin).
 */
$app->router->post('user/content-admin/delete/{id}', function ($id) use ($app) {
    // authorize request
    $admin = $app->verifyAdmin();
    $cf = new \LRC\Content\Functions($app->db);
    $content = $cf->getById($id);
    if (!$content || $content->deleted) {
        $app->session->set('err', 'Kunde inte hitta aktivt innehåll med ID ' . $app->esc($id) . '.');
        $app->redirect('user/content-admin');
    }
    $user = $cf->getUser($content);
    if ($user && $user->level > $admin->level) {
        $app->session->set('err', 'Du har inte behörighet att ta bort det valda innehållet.');
        $app->redirect('user/content-admin');
    }
    
    // remove content and return to admin page
    $cf->remove($id);
    $app->session->set('msg', 'Innehållet <strong>' . $app->esc($content->title) . '</strong> har tagits bort.');
    $app->redirect('user/content-admin');
});


/**
 * Restore content processor (admin).
 */
$app->router->get('user/content-admin/restore/{id}', function ($id) use ($app) {
    // authorize request
    $admin = $app->verifyAdmin();
    $cf = new \LRC\Content\Functions($app->db);
    $content = $cf->getById($id);
    if (!$content || !$content->deleted) {
        $app->session->set('err', 'Kunde inte hitta borttaget innehåll med ID ' . $app->esc($id) . '.');
        $app->redirect('user/content-admin');
    }
    $user = $cf->getUser($content);
    if ($user && $user->level > $admin->level) {
        $app->session->set('err', 'Du har inte behörighet att återställa det valda innehållet.');
        $app->redirect('user/content-admin');
    }
    
    // restore content and return to admin page
    $cf->restore($id);
    $app->session->set('msg', 'Innehållet <strong>' . $app->esc($content->title) . '</strong> har återställts.');
    $app->redirect('user/content-admin');
});
