<?php
require '../Slim/Slim.php';
\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

//Define a HTTP GET route:
$app->get('/hola/:name', function ($name) {
    echo "Hola, $name";
});

//Run the Slim application:
$app->run();