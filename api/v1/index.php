<?php
require "../libs/Slim/Slim.php";
require "../libs/JWT/JWT.php";
require "./Services/Siclab.php";

define("KEY", "m0oxUT7L8Unn93hXMUGHpwq_jTSKVBjQfEVCUe8jZ38KUU4VSAfmsNk4JJYcJl7CukrY6QMlixxwat7AZSpDcSQ");

\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();



$validateAccessToken= function($app) {
    return function () use ($app) {
        $tokenIsValid = false;
        $user_token = $app->request()->get("user_token");
        //validate token


        if(!$tokenIsValid) {
            $app->redirect("/errorpage");
        }
    };
};

$app->get("/tasks", $validateAccessToken($app), function() use ($app) {
    // here you have to define $user once again
    $user_token = $app->request()->get("user_token");
    //validate token
    //$user = \models\user::where("user_token", "=", $user_token)->first();
    //query database service
    //$emails = \models\emails::where("user_id", "=", $user->id)->toArray();
    echo(json_encode($emails));
});



$app->post("/login", function() use ($app) {
    try {
        // get and decode JSON request body
        $request = $app->request();
        $headers = $request->headers();
        $body = $request->getBody();
        $input = json_decode($body);
        $userId = 1;
        //$sessionId = bin2hex(openssl_random_pseudo_bytes(16));
        //$sessionId = bin2hex($userId);
        $userPass = $input->username . "." . $input->password . "." . $userId;
        $userPass = bin2hex($userPass);
        $name = "Reyna García Meneses";

        //TODO sanitize, check versus database
        $token = array();

        //$token["usr"] = $input->username;
        //$token["pwd"] = $input->password;
        $token["nam"] = $name;
        //$token["upt"] = "rgarcia" . "." . "1" . "." . "5";
        $token["upt"] = $userPass;
        $token["sid"] = $sessionId;
        $token["lvl"] = "5";
        $token["iss"] = $headers["Host"];
        $token["aud"] = "siclab.ceajalisco.gob.mx";
        $token["iat"] = time();
        $token["exp"] = time() + (5 * 60);

        $jwt = JWT::encode($token, KEY);

        ////debugging only
        //$decoded = JWT::decode($jwt, KEY);
        //$decoded_array = (array) $decoded;
        //print_r($decoded_array);

        //// return JSON-encoded response body
        $app->response()->status(200);
        $app->response()->header('Content-Type', 'application/json');
        echo json_encode($jwt);
        //echo json_encode($token);
    } catch (Exception $e) {
        $app->response()->status(400);
        //$app->response()->header('X-Status-Reason', $e->getMessage());
    }

});

$app->get("/menu", function() {
//$app->get("/menu", function($auth) {
    //if (!isset($auth))
    //{
    //  echo '[]';
    //}
    //$decoded = JWT::decode($auth, KEY);

    //if ($decoded->pwd === "rgarcia")
    if ("rgarcia" === "rgarcia")
    {
        echo '
            [
                {
                    "id_menu":1,
                    "orden":1,
                    "url":"/#",
                    "label":"Muestreo",
                    "activo":1,
                    "submenu":
                    [
                        {
                            "id_submenu":1,
                            "id_menu":1,
                            "orden":1,
                            "url":"/muestreo/solicitudes",
                            "label":"Solicitud",
                            "activo":1
                        },
                        {
                            "id_submenu":2,
                            "id_menu":1,
                            "orden":2,
                            "url":"/muestreo/orden",
                            "label":"Orden Muestreo",
                            "activo":1
                        },
                        {
                            "id_submenu":3,
                            "id_menu":1,
                            "orden":3,
                            "url":"/muestreo/plan",
                            "label":"Plan Muestreo",
                            "activo":1
                        }
                    ]
                },
                {
                    "id_menu":2,
                    "orden":2,
                    "url":"/#",
                    "label":"Recepción",
                    "activo":1,
                    "submenu":
                    [
                        {
                            "id_submenu":4,
                            "id_menu":2,
                            "orden":1,
                            "url":"/recepcion/campo",
                            "label":"Hoja Campo",
                            "activo":1
                        },
                        {
                            "id_submenu":5,
                            "id_menu":2,
                            "orden":1,
                            "url":"/recepcion/muestra",
                            "label":"Recepción Muestras",
                            "activo":1
                        },
                        {
                            "id_submenu":7,
                            "id_menu":2,
                            "orden":4,
                            "url":"/recepcion/custodia",
                            "label":"Cadena Custodia",
                            "activo":1
                        }
                    ]
                },
                {
                    "id_menu":3,
                    "orden":3,
                    "url":"/#",
                    "label":"Inventario",
                    "activo":1,
                    "submenu":
                    [
                        {
                            "id_submenu":8,
                            "id_menu":3,
                            "orden":1,
                            "url":"/inventario/muestras",
                            "label":"Inventario Muestras",
                            "activo":1
                        },
                        {
                            "id_submenu":9,
                            "id_menu":3,
                            "orden":2,
                            "url":"/inventario/equipos",
                            "label":"Equipos",
                            "activo":1
                        },
                        {
                            "id_submenu":10,
                            "id_menu":3,
                            "orden":3,
                            "url":"/inventario/reactivos",
                            "label":"Reactivos",
                            "activo":1
                        },
                        {
                            "id_submenu":11,
                            "id_menu":3,
                            "orden":4,
                            "url":"/inventario/recipientes",
                            "label":"Recipientes",
                            "activo":1
                        }
                    ]
                },
                {
                    "id_menu":4,
                    "orden":4,
                    "url":"/#",
                    "label":"Análisis",
                    "activo":1,
                    "submenu":
                    [
                        {
                            "id_submenu":12,
                            "id_menu":4,
                            "orden":1,
                            "url":"/analisis/consulta",
                            "label":"Consultar",
                            "activo":1
                        },
                        {
                            "id_submenu":13,
                            "id_menu":4,
                            "orden":2,
                            "url":"/analisis/captura",
                            "label":"Registrar",
                            "activo":1
                        }
                    ]
                },
                {
                    "id_menu":5,
                    "orden":5,
                    "url":"/#",
                    "label":"Reportes",
                    "activo":1,
                    "submenu":
                    [
                        {
                            "id_submenu":14,
                            "id_menu":5,
                            "orden":1,
                            "url":"/reporte/consulta",
                            "label":"Consultar",
                            "activo":1
                        },
                        {
                            "id_submenu":15,
                            "id_menu":5,
                            "orden":2,
                            "url":"/reporte/validar",
                            "label":"Validar",
                            "activo":1
                        }
                    ]
                },
                {
                    "id_menu":6,
                    "orden":6,
                    "url":"/#",
                    "label":"Catálogos",
                    "activo":1,
                    "submenu":
                    [
                        {
                            "id_submenu":16,
                            "id_menu":6,
                            "orden":1,
                            "url":"/catalogo/puntos",
                            "label":"Puntos Muestreo",
                            "activo":1
                        },
                        {
                            "id_submenu":17,
                            "id_menu":6,
                            "orden":2,
                            "url":"/catalogo/clientes",
                            "label":"Clientes",
                            "activo":1
                        },
                        {
                            "id_submenu":18,
                            "id_menu":6,
                            "orden":3,
                            "url":"/catalogo/areas",
                            "label":"Áreas",
                            "activo":1
                        },
                        {
                            "id_submenu":19,
                            "id_menu":6,
                            "orden":4,
                            "url":"/catalogo/empleados",
                            "label":"Empleados",
                            "activo":1
                        },
                        {
                            "id_submenu":20,
                            "id_menu":6,
                            "orden":5,
                            "url":"/catalogo/normas",
                            "label":"Normas",
                            "activo":1
                        },
                        {
                            "id_submenu":21,
                            "id_menu":6,
                            "orden":6,
                            "url":"/catalogo/referencia",
                            "label":"Valores Referencia",
                            "activo":1
                        },
                        {
                            "id_submenu":22,
                            "id_menu":6,
                            "orden":7,
                            "url":"/catalogo/metodos",
                            "label":"Métodos análisis",
                            "activo":1
                        },
                        {
                            "id_submenu":23,
                            "id_menu":6,
                            "orden":8,
                            "url":"/catalogo/precios",
                            "label":"Precio análisis",
                            "activo":1
                        }
                    ]
                },
                {
                    "id_menu":7,
                    "orden":7,
                    "url":"/#",
                    "label":"Administración",
                    "activo":1,
                    "submenu":
                    [
                        {
                            "id_submenu":24,
                            "id_menu":7,
                            "orden":1,
                            "url":"/sistema/usuarios",
                            "label":"Usuarios",
                            "activo":1
                        },
                        {
                            "id_submenu":25,
                            "id_menu":7,
                            "orden":2,
                            "url":"/sistema/perfil",
                            "label":"Ver Perfil",
                            "activo":1
                        },
                        {
                            "id_submenu":26,
                            "id_menu":7,
                            "orden":3,
                            "url":"/sistema/logout",
                            "label":"Cerrar sesión",
                            "activo":1
                        }
                    ]
                }
            ]
        ';
    }
    else
    {
        echo '[]';
    }

});

/*

$validateAccessToken= function($app) {
    return function () use ($app) {
        $user_token = $app->request()->get("user_token");
        $user = \models\user::where("user_token", "=", $user_token)->first();

        if($user === NULL) {
            $app->redirect("/errorpage");
        }


    };
};

$app->get("/v1/emails", $validateAccessToken($app), function() use ($app) {
    // here you have to define $user once again
    $user_token = $app->request()->get("user_token");
    $user = \models\user::where("user_token", "=", $user_token)->first();

    $emails = \models\emails::where("user_id", "=", $user->id)->toArray();
    echo(json_encode($emails));
});
*/

$app->run();
