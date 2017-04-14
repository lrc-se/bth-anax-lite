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
                'err' => $app->session->getOnce('err'),
                'msg' => $app->session->getOnce('msg'),
                'user' => $app->getUser()
            ]
        ]
    ]);
});


/**
 * Login processor.
 */
$app->router->post('user/login', function () use ($app) {
    $uf = new \LRC\User\Functions($app->db);
    $user = $uf->getByUsername($app->request->getPost('username'));
    if ($user && password_verify($app->request->getPost('password'), $user->password)) {
        if ($user->active) {
            // all is well
            $app->session->set('user', $user);
            $app->redirect('user/profile');
        } else {
            // inactive account
            $app->session->set('err', 'Användarkontot är inte tillgängligt.');
        }
    } else {
        // wrong credentials
        $app->session->set('err', 'Felaktigt användarnamn eller lösenord.');
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
    }
    $app->redirect('user/login');
});


/**
 * User profile.
 */
$app->router->add('user/profile', function () use ($app) {
    $user = $app->verifyUser();
    $app->defaultLayout((strtolower($user->username[strlen($user->username) - 1]) == 's' ? $user->username : $user->username . 's') . ' profil', [
        [
            'path' => 'user/profile',
            'data' => ['user' => $user]
        ]
    ]);
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
        // store new user and go to profile page
        $uf->save($user);
        $app->session->set('user', $user);
        $app->redirect('user/profile');
    }
    
    // return to form
    $app->defaultLayout('Skapa användare', [
        'user/create',
        [
            'path' => 'user/form',
            'data' => [
                'user' => $user,
                'action' => 'user/create',
                'admin' => false,
                'err' => '<p><strong>Följande fel inträffade:</strong></p><ul><li>' . implode('</li><li>', $errors) . '</li></ul>'
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
    $admin = $app->verifyAdmin();
    $uf = new \LRC\User\Functions($app->db);
    $user = $uf->populateUser($app->request, true);
    
    // validate input
    $errors = $uf->getValidationErrors($app->request);
    if (count($errors) === 0) {
        // store new user and return to admin page
        $uf->save($user);
        $app->session->set('msg', 'Användaren <strong>' . $user->username . '</strong> har skapats.');
        $app->redirect('user/admin');
    }
    
    // return to form
    $app->defaultLayout('Skapa användare', [
        'user/create',
        [
            'path' => 'user/form',
            'data' => [
                'user' => $user,
                'action' => 'user/create',
                'admin' => $admin,
                'err' => '<p><strong>Följande fel inträffade:</strong></p><ul><li>' . implode('</li><li>', $errors) . '</li></ul>'
            ]
        ]
    ]);
});


/**
 * Edit user (guest).
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
 * Edit user processor (guest).
 */
$app->router->post('user/profile/edit', function () use ($app) {
    $uf = new \LRC\User\Functions($app->db);
    $user = $uf->populateUser($app->request);
    
    // validate input
    $errors = $uf->getValidationErrors($app->request);
    if (count($errors) === 0) {
        // store edited user and go to profile page
        $uf->save($user);
        $app->session->set('user', $user);
        $app->redirect('user/profile');
    }
    
    // return to form
    $app->defaultLayout('Redigera användare', [
        'user/edit',
        [
            'path' => 'user/form',
            'data' => [
                'user' => $user,
                'action' => 'user/profile/edit',
                'admin' => false,
                'err' => '<p><strong>Följande fel inträffade:</strong></p><ul><li>' . implode('</li><li>', $errors) . '</li></ul>'
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
        $app->session->set('err', 'Kunde inte hitta användaren med id ' . $app->esc($id) . '.');
        $app->redirect('user/admin');
    }
    if ($user->isAdmin(true)) {
        $app->verifyAdmin(true);
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
        $app->session->set('err', 'Kunde inte hitta användaren med id ' . $app->esc($id) . '.');
        $app->redirect('user/admin');
    }
    if ($user->isAdmin(true)) {
        $app->verifyAdmin(true);
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
    $app->defaultLayout('Redigera användare', [
        'user/admin-edit',
        [
            'path' => 'user/form',
            'data' => [
                'user' => $user,
                'action' => 'user/admin/edit/' . $id,
                'admin' => $admin,
                'err' => '<p><strong>Följande fel inträffade:</strong></p><ul><li>' . implode('</li><li>', $errors) . '</li></ul>'
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
    $user = $app->getUser($id);
    if (!$user) {
        $app->session->set('err', 'Kunde inte hitta användaren med id ' . $app->esc($id) . '.');
        $app->redirect('user/admin');
    }
    if ($user->level > $admin->level) {
        $app->session->set('err', 'Du har inte behörighet att ta bort den valda användaren.');
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
    $user = $app->getUser($id);
    if (!$user) {
        $app->session->set('err', 'Kunde inte hitta användaren med id ' . $app->esc($id) . '.');
        $app->redirect('user/admin');
    }
    if ($user->level > $admin->level) {
        $app->session->set('err', 'Du har inte behörighet att ta bort den valda användaren.');
        $app->redirect('user/admin');
    }
    
    // remove user and return to admin page
    $uf = new \LRC\User\Functions($app->db);
    $uf->remove($id);
    $app->session->set('msg', 'Användaren <strong>' . $app->esc($user->username) . '</strong> har tagits bort.');
    $app->redirect('user/admin');
});
