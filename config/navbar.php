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
        'report' => [
            'title' => 'Redovisning',
            'route' => 'report'
        ],
        'test' => [
            'title' => 'Test',
            'route' => null,
            'items' => [
                'test1' => [
                    'title' => 'Test1',
                    'route' => 'test/test1'
                ],
                'test2' => [
                    'title' => 'Test2',
                    'route' => 'test/test2'
                ],
                'test3' => [
                    'title' => 'Test3',
                    'route' => null,
                    'items' => [
                        'test4' => [
                            'title' => 'Test4',
                            'route' => 'test/test3/test4'
                        ]
                    ]
                ]
            ]
        ]
    ]
];
