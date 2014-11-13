<?php

/**
 * Very simple MVC structure
 */

$loader = new \Phalcon\Loader();

$loader->registerDirs(array('../apps/controllers/', '../apps/models/', '../apps/forms/', '../apps/library/'));

$loader->registerNamespaces(
		array(
            'TwitterClone\Forms'    => "../apps/forms/",
            'TwitterClone\Models'   => "../apps/models/",
            'TwitterClone\Auth'     => "../apps/library/Auth",
		)
);

$loader->register();

$di = new \Phalcon\DI();

//Registering a router
$di->set('router', function(){
	$router = new \Phalcon\Mvc\Router();

	$router->removeExtraSlashes(true);
	$router->setDefaultController('session');
	$router->setDefaultAction('index');
	
	return $router;
});

//Registering an escaper
$di->set('escaper', 'Phalcon\Escaper');

//Registering a dispatcher
$di->set('dispatcher', 'Phalcon\Mvc\Dispatcher');

//Registering a Http\Response
$di->set('response', 'Phalcon\Http\Response');

//Registering a Http\Request
$di->set('request', 'Phalcon\Http\Request');

//Registering the view component
$di->set('view', function(){
	$view = new \Phalcon\Mvc\View();
	$view->setViewsDir('../apps/views/');
	return $view;
});

//Setup a base URI so that all generated URIs include the "tutorial" folder
$di->set('url', function(){
	$url = new \Phalcon\Mvc\Url();
	$url->setBaseUri('/');
	return $url;
});

$di->set('db', function(){
	return new \Phalcon\Db\Adapter\Pdo\Mysql(array(
		"host" => "localhost",
		"username" => "root",
		"password" => "root",
		"dbname" => "twitter_clone"
	));
});

//Set up the flash service
$di->set('flash', function() {
	return new \Phalcon\Flash\Direct(array(
        'error' => 'alert alert-error alert-danger',
        'success' => 'alert alert-success',
        'notice' => 'alert alert-info',
    ));
});

//Register a "filter" service in the container
$di->set('filter', function() {
	return new Phalcon\Filter();
});

//Register a "filter" service in the container
$di->set('tag', function() {
	return new Phalcon\Tag();
});

//Registering the Models-Metadata
$di->set('modelsMetadata', 'Phalcon\Mvc\Model\Metadata\Memory');

//Registering the Models Manager
$di->set('modelsManager', 'Phalcon\Mvc\Model\Manager');

//Set session
$di->setShared('session', function() {
    $session = new Phalcon\Session\Adapter\Files();
    $session->start();
    return $session;
});

//Set security
$di->set('security', function(){

    $security = new Phalcon\Security();

    //Set the password hashing factor to 12 rounds
    $security->setWorkFactor(12);

    return $security;
}, true);

//Set auth
$di->set('auth', function () {
    return new TwitterClone\Auth\Auth();
});

//Set modelsManager
$di->set('modelsManager', function() {
    return new Phalcon\Mvc\Model\Manager();
});

try {
	$application = new \Phalcon\Mvc\Application();
	$application->setDI($di);
	echo $application->handle()->getContent();
}
catch(Phalcon\Exception $e){
	echo $e->getMessage();
}
