<?php
require "../libs/Slim/Slim.php";
require "../libs/JWT/JWT.php";

\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();

//	$request = \Slim\Slim::getInstance()->request();
//	$update = json_decode($request->getBody());

$app->post("/login", 'loginUser');

function loginUser() {
	try {
		$app = \Slim\Slim::getInstance();
		$request = $app->request();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		print_r($request);
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
		$app->stop();
	}
}