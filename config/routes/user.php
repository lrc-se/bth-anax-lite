<?php

/**
 * User routes.
 */


/**
 * Login page.
 */
$app->router->get('user/login', function () use ($app) {
    $app->defaultLayout('Logga in', [
        [
            'path' => 'user/login',
            'data' => [
                'redirect' => $app->session->getOnce('redirect'),
                'user' => $app->getUser()
            ]
        ]
    ]);
});


/**
 * Login processor.
 */
$app->router->post('user/login', function () use ($app) {
    // validate request
    $uf = new \LRC\User\Functions($app->db);
    $user = $uf->getByUsername($app->request->getPost('username'));
    $redirect = $app->request->getPost('redirect');
    if ($user && password_verify($app->request->getPost('password'), $user->password)) {
        if ($user->active) {
            // all is well
            $app->session->set('user', $user->id);
            $app->cookie->set('last_login', time());
            $app->redirect(($redirect ?: 'user/profile'));
        } else {
            // inactive account
            $app->session->set('err', 'Användarkontot är inte tillgängligt.');
        }
    } else {
        // wrong credentials
        $app->session->set('err', 'Felaktigt användarnamn eller lösenord.');
    }
    
    // return to login form
    if (!is_null($redirect)) {
        $app->session->set('redirect', $redirect);
    }
    $app->redirect('user/login');
});


/**
 * Logout.
 */
$app->router->add('user/logout', function () use ($app) {
    if ($app->session->has('user')) {
        $app->session->remove('user');
        $app->session->set('msg', 'Du har loggats ut.');
        $app->cookie->remove('last_login');
    }
    $app->redirect('user/login');
});


/**
 * Create user (guest).
 */
$app->router->get('user/create', function () use ($app) {
    $app->defaultLayout('Skapa användare', [
        'user/create',
        [
            'path' => 'user/form',
            'data' => [
                'user' => new \LRC\User\User(),
                'action' => 'user/create',
                'admin' => false
            ]
        ]
    ]);
});


/**
 * Create user processor (guest).
 */
$app->router->post('user/create', function () use ($app) {
    $uf = new \LRC\User\Functions($app->db);
    $user = $uf->populateUser($app->request);
    
    // validate input
    $errors = $uf->getValidationErrors($app->request);
    if (count($errors) === 0) {
        // store new user and show success message
        $uf->save($user);
        $app->session->set('user', $user->id);
        $app->session->set('msg', 'Ditt användarkonto har skapats. Välkommen till Kalles sida!');
        $app->cookie->set('last_login', time());
        $app->redirect('user/login');
    }
    
    // return to form
    $app->session->set('err', '<p><strong>Följande fel inträffade:</strong></p><ul><li>' . implode('</li><li>', $errors) . '</li></ul>');
    $app->defaultLayout('Skapa användare', [
        'user/create',
        [
            'path' => 'user/form',
            'data' => [
                'user' => $user,
                'action' => 'user/create',
                'admin' => false
            ]
        ]
    ]);
});


/**
 * User profile.
 */
$app->router->add('user/profile', function () use ($app) {
    $user = $app->verifyUser();
    $app->defaultLayout((strtolower($user->username[strlen($user->username) - 1]) == 's' ? $user->username : $user->username . 's') . ' profil', [
        [
            'path' => 'user/profile',
            'data' => [
                'user' => $user,
                'lastLogin' => $app->cookie->get('last_login')
            ]
        ]
    ]);
});


/**
 * Edit user (regular user).
 */
$app->router->get('user/profile/edit', function () use ($app) {
    $user = $app->verifyUser();
    $app->defaultLayout('Redigera profil', [
        'user/edit',
        [
            'path' => 'user/form',
            'data' => [
                'user' => $user,
                'action' => 'user/profile/edit',
                'admin' => false
            ]
        ]
    ]);
});


/**
 * Edit user processor (regular user).
 */
$app->router->post('user/profile/edit', function () use ($app) {
    // authorize request
    $oldUser = $app->verifyUser();
    $uf = new \LRC\User\Functions($app->db);
    $user = $uf->populateUser($app->request);
    if ($oldUser->id != $user->id) {
        $app->session->set('err', 'Du har inte behörighet att redigera den efterfrågade användaren.');
        $app->redirect('user/profile');
    }
    $user->level = $oldUser->level;
    
    // validate input
    $errors = $uf->getValidationErrors($app->request);
    if (count($errors) === 0) {
        // store updated user and go to profile page
        $uf->save($user);
        $app->session->set('msg', 'Din profil har uppdaterats.');
        $app->redirect('user/profile');
    }
    
    // return to form
    $app->session->set('err', '<p><strong>Följande fel inträffade:</strong></p><ul><li>' . implode('</li><li>', $errors) . '</li></ul>');
    $app->defaultLayout('Redigera användare', [
        'user/edit',
        [
            'path' => 'user/form',
            'data' => [
                'user' => $user,
                'action' => 'user/profile/edit',
                'admin' => false
            ]
        ]
    ]);
});


/**
 * User list (admin).
 */
$app->router->get('user/admin', function () use ($app) {
    // parse and validate request
    $admin = $app->verifyAdmin();
    $params = [
        'search' => $app->request->getGet('search', ''),
        'sort' => $app->request->getGet('sort', 'id'),
        'desc' => (int)$app->request->getGet('desc'),
        'num' => (int)$app->request->getGet('num', 10),
        'page' => max((int)$app->request->getGet('page'), 1)
    ];
    if (!in_array($params['sort'], \LRC\User\User::ORDER_BY)) {
        $params['sort'] = 'id';
    }
    $arrow = ($params['desc'] ? '&darr;' : '&uarr;');
    
    // filter and paginate users
    $uf = new \LRC\User\Functions($app->db);
    $match = ($params['search'] !== '' ? $params['search'] : null);
    $order = $params['sort'] . ($params['desc'] ? ' DESC' : ' ASC');
    $nums = [0, 3, 5, 10, 25];
    if (!in_array($params['num'], $nums)) {
        $params['num'] = 10;
    }
    $matches = $uf->getTotal($match);
    $max = ($params['num'] > 0 ? ceil($matches / $params['num']) : 1);
    if ($params['page'] > $max) {
        $params['page'] = $max;
    }
    $users = $uf->getMatching($match, $order, $params['num'], ($params['page'] - 1) * $params['num']);
    
    $app->defaultLayout('Användaradministration', [
        [
            'path' => 'user/admin-index',
            'data' => [
                'admin' => $admin,
                'users' => $users,
                'params' => $params,
                'arrow' => $arrow,
                'matches' => $matches,
                'total' => $uf->getTotal(),
                'max' => $max,
                'nums' => $nums
            ]
        ]
    ]);
});


/**
 * Create user (admin).
 */
$app->router->get('user/admin/create', function () use ($app) {
    $admin = $app->verifyAdmin();
    $app->defaultLayout('Skapa användare', [
        'user/create',
        [
            'path' => 'user/form',
            'data' => [
                'user' => new \LRC\User\User(),
                'action' => 'user/admin/create',
                'admin' => $admin
            ]
        ]
    ]);
});


/**
 * Create user processor (admin).
 */
$app->router->post('user/admin/create', function () use ($app) {
    // authorize request
    $admin = $app->verifyAdmin();
    $uf = new \LRC\User\Functions($app->db);
    $user = $uf->populateUser($app->request, true);
    if ($user->level > $admin->level) {
        $user->level = $admin->level;
    }
    
    // validate input
    $errors = $uf->getValidationErrors($app->request);
    if (count($errors) === 0) {
        // store new user and return to admin page
        $uf->save($user);
        $app->session->set('msg', 'Användaren <strong>' . $user->username . '</strong> har skapats.');
        $app->redirect('user/admin');
    }
    
    // return to form
    $app->session->set('err', '<p><strong>Följande fel inträffade:</strong></p><ul><li>' . implode('</li><li>', $errors) . '</li></ul>');
    $app->defaultLayout('Skapa användare', [
        'user/create',
        [
            'path' => 'user/form',
            'data' => [
                'user' => $user,
                'action' => 'user/admin/create',
                'admin' => $admin
            ]
        ]
    ]);
});


/**
 * Edit user (admin).
 */
$app->router->get('user/admin/edit/{id}', function ($id) use ($app) {
    // authorize request
    $admin = $app->verifyAdmin();
    $uf = new \LRC\User\Functions($app->db);
    $user = $uf->getById($id);
    if (!$user) {
        $app->session->set('err', 'Kunde inte hitta användaren med ID ' . $app->esc($id) . '.');
        $app->redirect('user/admin');
    }
    if ($user->level > $admin->level) {
        $app->session->set('err', 'Du har inte behörighet att redigera den efterfrågade användaren.');
        $app->redirect('user/admin');
    }
    
    $app->defaultLayout('Redigera användare', [
        'user/admin-edit',
        [
            'path' => 'user/form',
            'data' => [
                'user' => $user,
                'action' => 'user/admin/edit/' . $id,
                'admin' => $admin
            ]
        ]
    ]);
});


/**
 * Edit user processor (admin).
 */
$app->router->post('user/admin/edit/{id}', function ($id) use ($app) {
    // authorize request
    $admin = $app->verifyAdmin();
    $uf = new \LRC\User\Functions($app->db);
    $user = $uf->getById($id);
    if (!$user) {
        $app->session->set('err', 'Kunde inte hitta användaren med ID ' . $app->esc($id) . '.');
        $app->redirect('user/admin');
    }
    if ($user->level > $admin->level) {
        $app->session->set('err', 'Du har inte behörighet att redigera den efterfrågade användaren.');
        $app->redirect('user/admin');
    }
    
    // validate input
    $user = $uf->populateUser($app->request, true);
    $errors = $uf->getValidationErrors($app->request);
    if (count($errors) === 0) {
        // store edited user and return to admin page
        $uf->save($user);
        $app->session->set('msg', 'Användaren <strong>' . $user->username . '</strong> har uppdaterats.');
        $app->redirect('user/admin');
    }
    
    // return to form
    $app->session->set('err', '<p><strong>Följande fel inträffade:</strong></p><ul><li>' . implode('</li><li>', $errors) . '</li></ul>');
    $app->defaultLayout('Redigera användare', [
        'user/admin-edit',
        [
            'path' => 'user/form',
            'data' => [
                'user' => $user,
                'action' => 'user/admin/edit/' . $id,
                'admin' => $admin
            ]
        ]
    ]);
});


/**
 * Remove user (admin).
 */
$app->router->get('user/admin/delete/{id}', function ($id) use ($app) {
    // authorize request
    $admin = $app->verifyAdmin();
    $uf = new \LRC\User\Functions($app->db);
    $user = $uf->getById($id);
    if (!$user) {
        $app->session->set('err', 'Kunde inte hitta användaren med ID ' . $app->esc($id) . '.');
        $app->redirect('user/admin');
    }
    if ($user->level > $admin->level) {
        $app->session->set('err', 'Du har inte behörighet att ta bort den efterfrågade användaren.');
        $app->redirect('user/admin');
    } elseif ($user->id == $admin->id) {
        $app->session->set('err', 'Du kan inte ta bort din egen användare.');
        $app->redirect('user/admin');
    }
    
    $app->defaultLayout('Ta bort användare', [
        [
            'path' => 'user/admin-delete',
            'data' => ['user' => $user]
        ]
    ]);
});


/**
 * Remove user processor (admin).
 */
$app->router->post('user/admin/delete/{id}', function ($id) use ($app) {
    // authorize request
    $admin = $app->verifyAdmin();
    $uf = new \LRC\User\Functions($app->db);
    $user = $uf->getById($id);
    if (!$user) {
        $app->session->set('err', 'Kunde inte hitta användaren med ID ' . $app->esc($id) . '.');
        $app->redirect('user/admin');
    }
    if ($user->level > $admin->level) {
        $app->session->set('err', 'Du har inte behörighet att ta bort den efterfrågade användaren.');
        $app->redirect('user/admin');
    }
    
    // remove user and return to admin page
    $uf->remove($id);
    $app->session->set('msg', 'Användaren <strong>' . $app->esc($user->username) . '</strong> har tagits bort.');
    $app->redirect('user/admin');
});
