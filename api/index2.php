<?php

require 'vendor/autoload.php';
require 'services/CategoryService.php';

$catService = new \Service\CategoryService();
$app = new \Slim\Slim();
$app->response->headers->set('Content-Type', 'application/json');
$app->get('/category/:name', 'getCategory');

$app->run();

function getCategory($name) {
    global $catService;
    $namez = $catService->getCategory($name);
    echo json_encode($namez);
}
