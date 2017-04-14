<?php

/**
 * Front controller.
 */

// file locations
define('ANAX_INSTALL_PATH', realpath(__DIR__ . '/..'));
define('ANAX_APP_PATH', ANAX_INSTALL_PATH);

// init autoloader
require ANAX_INSTALL_PATH . '/vendor/autoload.php';

// init application wrapper
$app = new \LRC\App\App();

// init error handler
require ANAX_INSTALL_PATH . '/config/errors.php';

// init request component
$app->request->init();

// init url component
$app->url->setSiteUrl($app->request->getSiteUrl());
$app->url->setBaseUrl($app->request->getBaseUrl());
$app->url->setStaticSiteUrl($app->request->getSiteUrl());
$app->url->setStaticBaseUrl($app->request->getBaseUrl());
$app->url->setScriptName($app->request->getScriptName());
$app->url->configure('url.php');
$app->url->setDefaultsFromConfiguration();

// init view component
$app->view->setApp($app);
$app->view->configure('view.php');

// init database component
$app->db->configure('db.php');

// init navbar component
$app->navbar->configure('navbar.php');

// init router component
require ANAX_INSTALL_PATH . '/config/routes.php';
$app->router->handle($app->request->getRoute(), $app->request->getMethod());
