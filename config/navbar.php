<?php

/**
 * Config file for navbar.
 */

// main routes
$navbar = [
    'data' => [
        'class' => 'navbar'
    ],
    'items' => [
        'start' => [
            'title' => 'Start',
            'route' => ''
        ],
        'about' => [
            'title' => 'Om',
            'route' => 'about'
        ],
        'content' => [
            'title' => 'Innehåll',
            'route' => 'content',
            'items' => [
                'pages' => [
                    'title' => 'Sidor',
                    'route' => 'content/page',
                    'items' => []
                ],
                'posts' => [
                    'title' => 'Inlägg',
                    'route' => 'content/blog'
                ]
            ]
        ],
        'test' => [
            'title' => 'Test',
            'route' => null,
            'items' => [
                'test1' => [
                    'title' => 'Test 1',
                    'route' => 'test/test1'
                ],
                'test2' => [
                    'title' => 'Test 2',
                    'route' => null,
                    'items' => [
                        'test3' => [
                            'title' => 'Test 3',
                            'route' => 'test/test2/test3',
                            'items' => [
                                'test4' => [
                                    'title' => 'Test 4',
                                    'route' => 'test/test2/test3/test4'
                                ]
                            ]
                        ],
                        'test5' => [
                            'title' => 'Test 5',
                            'route' => null,
                            'items' => [
                                'test6' => [
                                    'title' => 'Test 6',
                                    'route' => 'test/test2/test5/test6'
                                ]
                            ]
                        ]
                    ]
                ],
                'test7' => [
                    'title' => 'Test 7',
                    'route' => 'test/test7'
                ]
            ]
        ],
        'session' => [
            'title' => 'Session',
            'route' => 'session'
        ],
        'calendar' => [
            'title' => 'Kalender',
            'route' => 'calendar'
        ],
        'report' => [
            'title' => 'Redovisning',
            'route' => 'report'
        ]
    ]
];

// content pages
$cf = new \LRC\Content\Functions($this->app->db);
$pages = $cf->getPages();
foreach ($pages as $n => $page) {
    $navbar['items']['content']['items']['pages']['items']["page-$n"] = [
        'title' => $this->app->esc($page->title),
        'route' => 'content/page/' . $page->label
    ];
}

// user functions
try {
    $user = $this->app->getUser();
} catch (PDOException $ex) {
    // make sure we don't crash before the exception view can be fully rendered
    $user = null;
}
if (!$user) {
    // not logged in
    $navbar['items']['user'] = [
        'title' => 'Användare',
        'route' => 'user',
        'items' => [
            'create_user' => [
                'title' => 'Registrera ny',
                'route' => 'user/create'
            ],
            'login' => [
                'title' => 'Logga in',
                'route' => 'user/login'
            ]
        ]
    ];
} else {
    // logged in
    $navbar['items']['user'] = [
        'title' => '<img class="user-img-small" src="' . $this->app->href($user->getImage(), true) . '" alt=""> ' . $this->app->esc($user->username),
        'route' => 'user',
        'items' => [
            'profile' => [
                'title' => 'Profil',
                'route' => 'user/profile'
            ]
        ]
    ];
    if ($user->isAdmin()) {
        // admin addition
        $navbar['items']['user']['items']['admin'] = [
            'title' => 'Administration',
            'route' => 'user/admin'
        ];
    }
    $navbar['items']['user']['items']['logout'] = [
        'title' => 'Logga ut',
        'route' => 'user/logout'
    ];
}

return $navbar;
