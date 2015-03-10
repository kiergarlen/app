<?php
require "../libs/Slim/Slim.php";
require "../libs/JWT/JWT.php";
require "./Services/DalSiclab.php";

define("KEY", "m0oxUT7L8Unn93hXMUGHpwq_jTSKVBjQfEVCUe8jZ38KUU4VSAfmsNk4JJYcJl7CukrY6QMlixxwat7AZSpDcSQ");

\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();

$app->post("/login", function() use ($app) {
    try {
        // get and decode JSON request body
        $request = $app->request();

        $client = $request->getUrl();
        $clientIp = $request->getIp();
        $headers = $request->headers();
        $body = $request->getBody();
        $input = json_decode($body);
        $name = "Reyna García Meneses";
        $userId = 1;
        $userLv = 5;

        //TODO sanitize, check versus database
        $userPass = $input->username . ".";
        $userPass .= $input->password . ".";
        $userPass .= $userId . "." . $userLv;
        $userPass = bin2hex($userPass);

        $token = array();
        //$token["usr"] = $input->username;
        //$token["pwd"] = $input->password;
        $token["nam"] = $name;
        $token["upt"] = $userPass;
        $token["uid"] = $userId;
        $token["ulv"] = $userLv;
        $token["cip"] = $clientIp;
        $token["iss"] = $client;
        $token["aud"] = "siclab.ceajalisco.gob.mx";
        $token["iat"] = time();
        $token["exp"] = time() + (50 * 60);
        $jwt = JWT::encode($token, KEY);

        ////debugging only
        $decoded = JWT::decode($jwt, KEY);
        $decoded_array = (array) $decoded;
        //print_r($decoded_array);

        //// return JSON-encoded response body
        $app->response()->status(200);
        $app->response()->header('Content-Type', 'application/json');
        echo json_encode($jwt);
        //echo json_encode($token);
    } catch (Exception $e) {
        $app->response()->status(400);
        $app->response()->header('X-Status-Reason', $e->getMessage());
    }
});

$app->get("/menu", function() use ($app) {
    try {
        $userId = (validateTokenUser($app)) ? validateTokenUser($app) : 0;
        $menu = \Service\DalSiclab::getInstance()->getMenu($userId);
        $app->response()->status(200);
        $app->response()->header('Content-Type', 'application/json');
        echo $menu;
    } catch (Exception $e) {
        $app->response()->status(400);
        $app->response()->header('X-Status-Reason', $e->getMessage());
    }
});

$app->get("/tasks", function() use ($app) {
    try {
        $userId = (validateTokenUser($app)) ? validateTokenUser($app) : 0;
        $menu = \Service\DalSiclab::getInstance()->getTasks($userId);
        $app->response()->status(200);
        $app->response()->header('Content-Type', 'application/json');
        echo $menu;
    } catch (Exception $e) {
        $app->response()->status(400);
        $app->response()->header('X-Status-Reason', $e->getMessage());
    }
});

$app->get("/clients", function() use ($app) {
    try {
        $menu = \Service\DalSiclab::getInstance()->getClients();
        $app->response()->status(200);
        $app->response()->header('Content-Type', 'application/json');
        echo $menu;
    } catch (Exception $e) {
        $app->response()->status(400);
        $app->response()->header('X-Status-Reason', $e->getMessage());
    }
});

$app->get("/parameters", function() use ($app) {
    try {
        $menu = \Service\DalSiclab::getInstance()->getParameters();
        $app->response()->status(200);
        $app->response()->header('Content-Type', 'application/json');
        echo $menu;
    } catch (Exception $e) {
        $app->response()->status(400);
        $app->response()->header('X-Status-Reason', $e->getMessage());
    }
});

$app->get("/norms", function() use ($app) {
    try {
        $menu = \Service\DalSiclab::getInstance()->getNorms();
        $app->response()->status(200);
        $app->response()->header('Content-Type', 'application/json');
        echo $menu;
    } catch (Exception $e) {
        $app->response()->status(400);
        $app->response()->header('X-Status-Reason', $e->getMessage());
    }
});

$app->get("/sampling/types", function() use ($app) {
    try {
        $menu = \Service\DalSiclab::getInstance()->getSamplingTypes();
        $app->response()->status(200);
        $app->response()->header('Content-Type', 'application/json');
        echo $menu;
    } catch (Exception $e) {
        $app->response()->status(400);
        $app->response()->header('X-Status-Reason', $e->getMessage());
    }
});
/*
$app->get("/quotes/:quoteId", function() use ($app) {
    try {
        $userId = (validateTokenUser($app)) ? validateTokenUser($app) : 0;
        $menu = \Service\DalSiclab::getInstance()->getQuote($quoteId);
        $app->response()->status(200);
        $app->response()->header('Content-Type', 'application/json');
        echo $menu;
    } catch (Exception $e) {
        $app->response()->status(400);
        $app->response()->header('X-Status-Reason', $e->getMessage());
    }
});
*/
$app->get("/order/sources", function() use ($app) {
    try {
        $menu = \Service\DalSiclab::getInstance()->getOrderSources();
        $app->response()->status(200);
        $app->response()->header('Content-Type', 'application/json');
        echo $menu;
    } catch (Exception $e) {
        $app->response()->status(400);
        $app->response()->header('X-Status-Reason', $e->getMessage());
    }
});

$app->get("/matrices", function() use ($app) {
    try {
        $menu = \Service\DalSiclab::getInstance()->getMatrices();
        $app->response()->status(200);
        $app->response()->header('Content-Type', 'application/json');
        echo $menu;
    } catch (Exception $e) {
        $app->response()->status(400);
        $app->response()->header('X-Status-Reason', $e->getMessage());
    }
});


function validateTokenUser($app) {
    $request = $app->request();
    $headers = $request->headers();

    $jwt = $headers["Auth-Token"];
    $decoded = JWT::decode($jwt, KEY);
    $userPass = hex2bin($decoded->upt);
    $userPassArray = explode (".", $userPass);
    $userId = 0;
    if ($userPassArray[0] === "rgarcia" && $userPassArray[1] === "rgarcia")
    {
        $userId = 1;
    }
    return $userId;
}

/*
$validateAccessToken = function($app) {
   return function () use ($app) {
        $request = $app->request();
        $headers = $request->headers();

        $jwt = $headers["Auth-Token"];
        $decoded = JWT::decode($jwt, KEY);
        $userPass = hex2bin($decoded->upt);
        $userPassArray = explode (".", $userPass);
        $userId = 0;
        if ($userPassArray[0] === "rgarcia" && $userPassArray[1] === "rgarcia")
        {
            $userId = 1;
        }
        else
        {
           //$app->redirect("/errorpage");
        }
    };
};
*/
//$app->get("/tasks", $validateAccessToken($app), function() use ($app) {
//    try {
//        $request = $app->request();
//        $headers = $request->headers();
//
//        $userId = validateTokenUser($headers);
//
//        $menu = DalSiclab::getInstance()->getTasks($userId);
//        $app->response()->status(200);
//        $app->response()->header('Content-Type', 'application/json');
//        echo $menu;
//    } catch (Exception $e) {
//        $app->response()->status(400);
//        $app->response()->header('X-Status-Reason', $e->getMessage());
//    }
//});

$app->run();

