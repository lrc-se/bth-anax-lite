<?php

/**
 * Public routes.
 */


/**
 * Index page.
 */
$app->router->add('', function () use ($app) {
    $app->defaultLayout('Start', 'index');
});


/**
 * About page.
 */
$app->router->add('about', function () use ($app) {
    $app->defaultLayout('Om webbplatsen', ['about', 'byline']);
});


/**
 * Report page.
 */
$app->router->add('report', function () use ($app) {
    $app->defaultLayout('Redovisning', 'report');
});


/**
 * Test page.
 */
$app->router->add('test/test1', function () use ($app) {
    $texts = [
        'nl2br' => <<<TEXT
Detta är en text som innehåller radbrytningar.

Få se hur det funkar efter formatering!
TEXT
        ,
        'link' => 'Denna text innehåller ett par länkar (http://telemark.se/) som skall göras om automagiskt: https://dbwebb.se.',
        'strip' => 'Denna text innehåller <tt>HTML</tt>-taggar som <blink>ingen</blink> bör använda <font size="7000">idag</font>...',
        'esc' => 'Denna text innehåller <tt>HTML</tt>-taggar som <blink>ingen</blink> bör använda <font size="7000">idag</font>...',
        'slug' => 'Åh, jag *önskar* att _detta_ kunde omformas till en URL-vänlig sträng!!#&%',
        'bbcode' => 'Här skall det vara [b]fetstil[/b], [i]kursivering[/i], [u]understrykning[/u], en bild [img]' . $app->href('img/byline.png', true) . '[/img], en [url=http://telemark.se/]länk[/url] samt en länk till: [url]https://dbwebb.se/[/url]',
        'markdown' => 'Här skall det vara **fetstil**, *kursivering*, en bild ![me](' . $app->href('img/byline.png', true) . ') samt en [länk](http://telemark.se/).',
        'strip, nl2br, bbcode' => <<<TEXT
Här är en [i]helt annan[/i] flerradig text.
Visas den [b]också[/b] <BLINK>korrekt</BLINK>?
TEXT
        ,
        'blubb' => 'Här skall det *inte* formateras om [b]någonting[/b], annars är det <u>fel</u>: https://dbwebb.se/'
    ];
    $app->defaultLayout('Test', [
        [
            'path' => 'test',
            'data' => ['texts' => $texts]
        ]
    ]);
});


/**
 * Another test page.
 */
$app->router->add('test/test2/test3/test4', function () use ($app) {
    $app->defaultLayout('Test igen', 'test');
});


/**
 * Yet another test page.
 */
$app->router->add('test/test2/test5/test6', function () use ($app) {
    $app->defaultLayout('Test ytterligare en gång', 'test');
});


/**
 * Server data as JSON.
 */
$app->router->add('server', function () use ($app) {
    $app->response->sendJson($_SERVER);
});


/**
 * Month calendar (default).
 */
$app->router->add('calendar', function () use ($app) {
    $now = new DateTime();
    $month = new \LRC\Calendar\Month($now->format('Y'), $now->format('n'));
    $app->defaultLayout('Månadskalender', [
        [
            'path' => 'calendar',
            'data' => [
                'month' => $month,
                'small' => $app->request->getGet('small', false),
                'noImage' => $app->request->getGet('noimage', false)
            ]
        ]
    ]);
});


/**
 * Month calendar (with parameters).
 */
$app->router->add('calendar/{year:digit}/{monthNum:digit}', function ($year, $monthNum) use ($app) {
    try {
        $month = new \LRC\Calendar\Month($year, $monthNum);
        $app->defaultLayout('Månadskalender', [
            [
                'path' => 'calendar',
                'data' => [
                    'month' => $month,
                    'small' => $app->request->getGet('small', false),
                    'noImage' => $app->request->getGet('noimage', false)
                ]
            ]
        ]);
    } catch (Exception $ex) {
        $app->redirect('calendar');
    }
});


/**
 * Page content.
 */
$app->router->add('content/page/{label}', function ($label) use ($app) {
    $cf = new \LRC\Content\Functions($app->db);
    $content = $cf->getByLabel($label);
    if (!$content || !$content->isPage()) {
        $app->router->handleInternal('404');
        return;
    }
    $msg = null;
    $user = $app->getUser();
    if (!$content->published || $content->published > date('Y-m-d H:i:s')) {
        if ($user && $user->isAdmin()) {
            if ($content->published) {
                $msg = '<strong>OBS!</strong> Denna sida kommer inte att publiceras förrän ' . $content->published . '.';
            } else {
                $msg = '<strong>OBS!</strong> Denna sida är opublicerad.';
            }
        } else {
            $app->router->handleInternal('404');
            return;
        }
    }
    if ($content->deleted) {
        if ($user && $user->isAdmin()) {
            $msg = 'Denna sida togs bort ' . $content->deleted . '.<br><a href="' . $app->href('user/content-admin/restore/' . $content->id) . '">Återställ</a>';
        } else {
            $app->router->handleInternal('404');
            return;
        }
    }
    $app->defaultLayout($content->title, [
        [
            'path' => 'page',
            'data' => [
                'content' => $content,
                'msg' => $msg
            ]
        ]
    ]);
});


/**
 * Blog index.
 */
$app->router->add('content/blog', function () use ($app) {
    $num = 10;
    $page = max((int)$app->request->getGet('page'), 1);
    $cf = new \LRC\Content\Functions($app->db);
    $total = $cf->getTotal(null, 'post');
    $max = ($num > 0 ? ceil($total / $num) : 1);
    if ($page > $max) {
        $page = $max;
    }
    $app->defaultLayout('Inlägg', [
        [
            'path' => 'blog-index',
            'data' => [
                'entries' => $cf->getPosts(true, $num, ($page - 1) * $num),
                'cf' => $cf,
                'num' => $num,
                'link' => true,
                'shorten' => true,
                'page' => $page,
                'total' => $total,
                'max' => $max
            ]
        ]
    ]);
});


/**
 * Blog post content.
 */
$app->router->add('content/blog/{id}', function ($id) use ($app) {
    $cf = new \LRC\Content\Functions($app->db);
    $content = $cf->getById($id);
    if (!$content || !$content->isPost()) {
        $app->router->handleInternal('404');
        return;
    }
    $msg = null;
    $user = $app->getUser();
    if (!$content->published || $content->published > date('Y-m-d H:i:s')) {
        if ($user && $user->isAdmin()) {
            if ($content->published) {
                $msg = '<strong>OBS!</strong> Detta inlägg kommer inte att publiceras förrän ' . $content->published . '.';
            } else {
                $msg = '<strong>OBS!</strong> Detta inlägg är opublicerat.';
            }
        } else {
            $app->router->handleInternal('404');
            return;
        }
    }
    if ($content->deleted) {
        if ($user && $user->isAdmin()) {
            $msg = '<strong>OBS!</strong> Detta inlägg togs bort ' . $content->deleted . '.<br><a href="' . $app->href('user/content-admin/restore/' . $content->id) . '">Återställ</a>';
        } else {
            $app->router->handleInternal('404');
            return;
        }
    }
    $app->defaultLayout($content->title, [
        [
            'path' => 'blog-post',
            'data' => [
                'content' => $content,
                'user' => $cf->getUser($content),
                'link' => false,
                'shorten' => false,
                'msg' => $msg
            ]
        ]
    ]);
});


include 'session.php';
include 'user.php';
include 'content.php';
