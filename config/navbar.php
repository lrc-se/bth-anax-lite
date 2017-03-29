<?php

/**
 * Config file for navbar.
 */
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
        'report' => [
            'title' => 'Redovisning',
            'route' => 'report'
        ]
    ]
];
