<?php
// define("DB_DRIVER", "sqlsrv");
// define("DB_HOST", "localhost");
// define("DB_PORT", "");
// define("DB_USER", "sislab");
// define("DB_PASSWORD", "sislab");
// define("DB_DATA_BASE", "Sislab");

define("DB_DRIVER", "mysql");
define("DB_HOST", "localhost");
define("DB_PORT", "8889");
define("DB_USER", "root");
define("DB_PASSWORD", "root");
define("DB_DATA_BASE", "sislab");

function getConnection() {
	try {
		$dsn = "mysql:host=";
		$dsn .= DB_HOST . ";";
		if (strlen(DB_PORT) > 0)
		{
			$dsn .= "port=" . DB_PORT . ";";
		}
		$dsn .= "dbname=" . DB_DATA_BASE;

		$dbConnection = new PDO($dsn, DB_USER, DB_PASSWORD);
		$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch(PDOException $e) {
		//error_log($e->getMessage(), 3, '/var/tmp/php.log');
		//echo '{"error":{"text":'. $e->getMessage() .'}}';
		$output = '{"error":"' . $e->getMessage() . '"}';
	}
	return $dbConnection;
}

function getUserByCredentials($userName, $userPassword) {
	//$result = \Service\DALSislab::getInstance()->getUserByCredentials($userName, $userPassword);
	////$userName = "rgarcia";
	////$userPassword = "8493a161f70fffc0dcd4732ae4f6c4667f373688fff802ea13c71bd0fce41cb1";
	$sql = "SELECT id_usuario, id_nivel, id_rol, id_area, id_puesto, interno, cea, laboratorio, supervisa, analiza, muestrea, nombres, apellido_paterno, apellido_materno, usr, pwd, fecha_captura, fecha_actualiza, ip_captura, ip_actualiza, host_captura, host_actualiza, activo FROM Usuario WHERE usr = :userName AND pwd = :userPassword AND activo = 1";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->bindParam("userName", $userName);
	$stmt->bindParam("userPassword", $userPassword);
	$stmt->execute();
	$result = $stmt->fetchAll(PDO::FETCH_OBJ);
	return $result;
}

function getUsers() {
	//$result = \Service\DALSislab::getInstance()->getUsers();
	$sql = "SELECT id_usuario, id_nivel, id_rol, id_area, id_puesto, interno, cea, laboratorio, supervisa, analiza, muestrea, nombres, apellido_paterno, apellido_materno, usr, pwd, fecha_captura, fecha_actualiza, ip_captura, ip_actualiza, host_captura, host_actualiza, activo FROM Usuario WHERE activo = 1";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->bindParam("userName", $userName);
	$stmt->bindParam("userPassword", $userPassword);
	$stmt->execute();
	//$result = processResultToJson($stmt->fetchAll(PDO::FETCH_ASSOC), false);
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $result;
}


function processResultToJson($items, $isArrayOutputExpected) {
	$output = "";
	if ($isArrayOutputExpected)
	{
		$output .= "[";
	}
	$i = 0;
	$l = count($items);
	foreach ($items as $item) {
		$i++;
		$j = 0;
		$item = (array)$item;
		$m = count($item);
		$output .= "{";
		foreach ($item as $key => $value) {
			$j++;
			$output .= '"' . $key . '":';
			$v = $value;
			if (!is_numeric($v))
			{
				if (strtotime($v)) {
					$dateArray = explode(" ", $v);
					$v = $dateArray[0] . 'T'. substr($dateArray[1], 0, 5) . '-06:00';
				}
				else
				{
					$v = utf8_encode($v);
				}
				$v = '"' . $v .'"';
			}
			$output .= $v;
			if ($j < $m)
			{
				$output .= ",";
			}
		}
		$output .= "}";
		if ($isArrayOutputExpected && $i < $l)
		{
			$output .= ",";
		}
	}
	if ($isArrayOutputExpected)
	{
		$output .= "]";
	}
	return $output;
}


$usr = "rgarcia";
$pwd = "8493a161f70fffc0dcd4732ae4f6c4667f373688fff802ea13c71bd0fce41cb1";

//$userData = getUsers();
$userData =
	Array (
	        Array (
	            "id_menu" => 1,
	            "id_submenu" => 1,
	            "orden" => 1,
	            "orden_submenu" => 1,
	            "url" => "/estudio/estudio",
	            "menu" => "Informe",
	            "submenu" => "Informe"
	        ),
	        Array (
	            "id_menu" => 2,
	            "id_submenu" => 2,
	            "orden" => 2,
	            "orden_submenu" => 1,
	            "url" => "/muestreo/orden",
	            "menu" => "Muestreo",
	            "submenu" => "Orden Muestreo"
	        ),
	        Array (
	            "id_menu" => 2,
	            "id_submenu" => 3,
	            "orden" => 2,
	            "orden_submenu" => 2,
	            "url" => "/muestreo/orden",
	            "menu" => "Muestreo",
	            "submenu" => "Plan Muestreo"
	        ),
	        Array (
	            "id_menu" => 3,
	            "id_submenu" => 3,
	            "orden" => 3,
	            "orden_submenu" => 1,
	            "url" => "/recepcion/hoja",
	            "menu" => "Recepción",
	            "submenu" => "Hoja Campo"
	        )
	);
print_r(processMenuToJson($userData));
//print_r($userData[0]);

function processMenuToJson($items) {
	$output = '';
	$i = 0;
	$l = count($items);
	$currentItem = $items[$i];
	$output .= '[';
	$output .= '{';
	$output .= '"id_menu":' . $currentItem["id_menu"] . ',';
	$output .= '"orden":' . $currentItem["orden"] . ',';
	$output .= '"url":"' . $currentItem["url"] . '",';
	$output .= '"menu":"' . $currentItem["menu"] . '",';
	$output .= '"submenu":[';
	$output .= '{';
	$output .= '"id_submenu":' . $currentItem["id_submenu"] . ',';
	$output .= '"id_menu":' . $currentItem["id_menu"] . ',';
	$output .= '"orden":' . $currentItem["orden_submenu"] . ',';
	$output .= '"url":"' . $currentItem["url_submenu"] . '",';
	$output .= '"menu":"' . $currentItem["submenu"] . '"';
	$output .= '}';
	for($i = 1; $i < $l; $i++)
	{
		if ($currentItem["id_menu"] == $items[$i]["id_menu"])
		{
			$output .= ',';
			// add submenu
			$currentItem = $items[$i];
		}
		else
		{
			//close current menu, add new one
			$output .= ']';
			$output .= '},';
			$currentItem = $items[$i];
			$output .= '{';
			$output .= '"id_menu":' . $currentItem["id_menu"] . ',';
			$output .= '"orden":' . $currentItem["orden"] . ',';
			$output .= '"url":"' . $currentItem["url"] . '",';
			$output .= '"menu":"' . $currentItem["menu"] . '",';
			$output .= '"submenu":[';
		}
		$output .= '{';
		$output .= '"id_submenu":' . $currentItem["id_submenu"] . ',';
		$output .= '"id_menu":' . $currentItem["id_menu"] . ',';
		$output .= '"orden":' . $currentItem["orden_submenu"] . ',';
		$output .= '"url":"' . $currentItem["url_submenu"] . '",';
		$output .= '"menu":"' . $currentItem["submenu"] . '"';
		$output .= '}';
	}
	$output .= ']';
	$output .= '}';
	$output .= ']';
	return $output;
}
/*

	$userData = getUserByCredentials($usr, $pwd);
	$userInfo = $userData[0];
	//$userInfo = json_decode($userData);

	$userId = $userInfo->id_usuario;
	$userLv = $userInfo->id_nivel;
	$userRole = $userInfo->id_rol;
	$name = utf8_encode($userInfo->nombres) . " ";
	$name .= utf8_encode($userInfo->apellido_paterno) . " ";
	$name .= utf8_encode($userInfo->apellido_materno) . "";
	// $name = $userInfo->nombres . " ";
	// $name .= $userInfo->apellido_paterno . " ";
	// $name .= $userInfo->apellido_materno . "";



print_r($userId);
print_r("<hr>");

	$userPass = $usr . ".";
	$userPass .= $pwd . ".";
	$userPass .= $userId . "." . $userLv;
	$userPass = bin2hex($userPass);

	print_r($userPass);
print_r("<hr>");
print_r($name);

/*
	const DB_DRIVER = "mysql";
	//const DB_DRIVER = "sqlsrv";
	const DB_HOST = "localhost";
	const DB_PORT = "8889";
	const DB_USER = "root";
	const DB_PASSWORD = "root";
	const DB_DATA_BASE = "sislab";

	// const DB_USER = "sislab";
	// const DB_PASSWORD = "sislab@12#";
	// const DB_DATA_BASE = "Sislab";


function getDB2() {
	$dsn = "sqlsrv:server=";
	$dsn .= DB_HOST . ";Database=";
	$dsn .= DB_DATA_BASE;

	$dbConnection = new PDO($dsn, DB_USER, DB_PASSWORD);
	$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	return $dbConnection;
}

function getDB() {
	$dsn = "mysql:host=";
	$dsn .= DB_HOST . ";";
	if (strlen(DB_PORT) > 0)
	{
		$dsn .= "port=" . DB_PORT . ";";
	}
	$dsn .= "dbname=" . DB_DATA_BASE;
	$dbConnection = new PDO($dsn, DB_USER, DB_PASSWORD);
	$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	return $dbConnection;
}


function processResultToJson($items, $isArrayOutputExpected)
{
	$output = "";
	try {
		if ($isArrayOutputExpected)
		{
			$output .= "[";
		}
		$i = 0;
		$l = count($items);
		foreach ($items as $item) {
			$i++;
			$j = 0;
			$item = (array)$item;
			$m = count($item);
			$output .= "{";
			foreach ($item as $key => $value) {
				$j++;
				$output .= '"' . $key . '":';
				$v = $value;
				if (!is_numeric($v))
				{
					//TODO: format string for dates
					$v = '"' . utf8_encode($value) .'"';
				}
				$output .= $v;
				if ($j < $m)
				{
					$output .= ",";
				}
			}
			$output .= "}";
			if ($isArrayOutputExpected && $i < $l)
			{
				$output .= ",";
			}
		}
		if ($isArrayOutputExpected)
		{
			$output .= "]";
		}
	} catch(PDOException $e) {
		//error_log($e->getMessage(), 3, '/var/tmp/php.log');
		//echo '{"error":{"text":'. $e->getMessage() .'}}';
		$output = '{"error":"' . $e->getMessage() . '"}';
	}
	return $output;
}

	$userName = "rgarcia";
	$userPassword = "8493a161f70fffc0dcd4732ae4f6c4667f373688fff802ea13c71bd0fce41cb1";
	$sql = "SELECT id_usuario, id_nivel, id_rol, id_area, id_puesto, interno, cea, laboratorio, supervisa, analiza, muestrea, nombres, apellido_paterno, apellido_materno, usr, pwd, fecha_captura, fecha_actualiza, ip_captura, ip_actualiza, host_captura, host_actualiza, activo FROM Usuario WHERE usr = :userName AND pwd = :userPassword";


	$db = getDB();
	$stmt = $db->prepare($sql);
	$stmt->bindParam("userName", $userName);
	$stmt->bindParam("userPassword", $userPassword);
	$stmt->execute();
	print_r(processResultToJson($stmt->fetchAll(PDO::FETCH_ASSOC), false));

	/*
	$sql = "SELECT id_usuario, id_nivel, id_rol, id_area, id_puesto, interno, cea, laboratorio, supervisa, analiza, muestrea, nombres, apellido_paterno, apellido_materno, usr, pwd, fecha_captura, fecha_actualiza, ip_captura, ip_actualiza, host_captura, host_actualiza, activo FROM Usuario";
	$db = getDB();
	$stmt = $db->prepare($sql);
	$stmt->execute();
	print_r(processResultToJson($stmt->fetchAll(PDO::FETCH_ASSOC), false));



/*
require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

$app->get('/users','getUsers');
$app->get('/updates','getUserUpdates');
$app->post('/updates', 'insertUpdate');
$app->delete('/updates/delete/:update_id','deleteUpdate');
$app->get('/users/search/:query','getUserSearch');

$app->run();

function getUsers() {
	$sql = "SELECT user_id,username,name,profile_pic FROM users ORDER BY user_id";

	$sql = "SELECT id_usuario, id_nivel, id_rol, id_area, id_puesto, interno, cea, laboratorio, supervisa, analiza, muestrea, nombres, apellido_paterno, apellido_materno, usr, pwd, fecha_captura, fecha_actualiza, ip_captura, ip_actualiza, host_catura, host_actualiza, activo FROM Usuario";
	try {
		$db = getDB();
		$stmt = $db->query($sql);
		$users = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo '{"users": ' . json_encode($users) . '}';
	} catch(PDOException $e) {
	    //error_log($e->getMessage(), 3, '/var/tmp/php.log');
		echo '{"error":{"text":'. $e->getMessage() .'}}';
	}
}

function getUserUpdates() {
	$sql = "SELECT A.user_id, A.username, A.name, A.profile_pic, B.update_id, B.user_update, B.created FROM users A, updates B WHERE A.user_id=B.user_id_fk  ORDER BY B.update_id DESC";
	try {
		$db = getDB();
		$stmt = $db->prepare($sql);
		$stmt->execute();
		$updates = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo '{"updates": ' . json_encode($updates) . '}';

	} catch(PDOException $e) {
	    //error_log($e->getMessage(), 3, '/var/tmp/php.log');
		echo '{"error":{"text":'. $e->getMessage() .'}}';
	}
}

function getUserUpdate($update_id) {
	$sql = "SELECT A.user_id, A.username, A.name, A.profile_pic, B.update_id, B.user_update, B.created FROM users A, updates B WHERE A.user_id=B.user_id_fk AND B.update_id=:update_id";
	try {
		$db = getDB();
		$stmt = $db->prepare($sql);
        $stmt->bindParam("update_id", $update_id);
		$stmt->execute();
		$updates = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo '{"updates": ' . json_encode($updates) . '}';

	} catch(PDOException $e) {
	    //error_log($e->getMessage(), 3, '/var/tmp/php.log');
		echo '{"error":{"text":'. $e->getMessage() .'}}';
	}
}

function insertUpdate() {
	$request = \Slim\Slim::getInstance()->request();
	$update = json_decode($request->getBody());
	$sql = "INSERT INTO updates (user_update, user_id_fk, created, ip) VALUES (:user_update, :user_id, :created, :ip)";
	try {
		$db = getDB();
		$stmt = $db->prepare($sql);
		$stmt->bindParam("user_update", $update->user_update);
		$stmt->bindParam("user_id", $update->user_id);
		$time=time();
		$stmt->bindParam("created", $time);
		$ip=$_SERVER['REMOTE_ADDR'];
		$stmt->bindParam("ip", $ip);
		$stmt->execute();
		$update->id = $db->lastInsertId();
		$db = null;
		$update_id= $update->id;
		getUserUpdate($update_id);
	} catch(PDOException $e) {
		//error_log($e->getMessage(), 3, '/var/tmp/php.log');
		echo '{"error":{"text":'. $e->getMessage() .'}}';
	}
}

function deleteUpdate($update_id) {

	$sql = "DELETE FROM updates WHERE update_id=:update_id";
	try {
		$db = getDB();
		$stmt = $db->prepare($sql);
		$stmt->bindParam("update_id", $update_id);
		$stmt->execute();
		$db = null;
		echo true;
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}';
	}

}

function getUserSearch($query) {
	$sql = "SELECT user_id,username,name,profile_pic FROM users WHERE UPPER(name) LIKE :query ORDER BY user_id";
	try {
		$db = getDB();
		$stmt = $db->prepare($sql);
		$query = "%".$query."%";
		$stmt->bindParam("query", $query);
		$stmt->execute();
		$users = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo '{"users": ' . json_encode($users) . '}';
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}';
	}
}
*/


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
//	try {
//		$request = $app->request();
//		$headers = $request->headers();
//
//		$userId = validateTokenUser($headers);
//
//		$result = DALSislab::getInstance()->getTasks($userId);
//		$app->response()->status(200);
//		$app->response()->header('Content-Type', 'application/json');
//		//$result = ")]}',\n" . $result;
//echo $result;
//	} catch (Exception $e) {
//		$app->response()->status(400);
//		$app->response()->header('X-Status-Reason', $e->getMessage());
//	}
//});
/*
$app->get('/acciones/:id', 'getAccion');
*/
/*
function addWine() {
	$request = Slim::getInstance()->request();
	$wine = json_decode($request->getBody());
	$sql = "INSERT INTO wine (name, grapes, country, region, year, description) VALUES (:name, :grapes, :country, :region, :year, :description)";
	try {
		$db = getConnection();
		$stmt = $db->prepare($sql);
		$stmt->bindParam("name", $wine->name);
		$stmt->bindParam("grapes", $wine->grapes);
		$stmt->bindParam("country", $wine->country);
		$stmt->bindParam("region", $wine->region);
		$stmt->bindParam("year", $wine->year);
		$stmt->bindParam("description", $wine->description);
		$stmt->execute();
		$wine->id = $db->lastInsertId();
		$db = null;
		echo json_encode($wine);
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}';
	}
}
*/

/*
[
  {
    "id_menu":1,
    "id_submenu":1,
    "orden":1,
    "orden_submenu":1,
    "menu":"Informe",
    "submenu":"Informe",
    "url":"/estudio/estudio"
  },
  {
    "id_menu":2,
    "id_submenu":2,
    "orden":2,
    "orden_submenu":1,
    "submenu":"Orden Muestreo",
    "menu":"Muestreo",
    "url":"/muestreo/orden"
  },
  {
    "id_menu":2,
    "id_submenu":3,
    "orden":2,
    "orden_submenu":2,
    "submenu":"Plan Muestreo",
    "menu":"Muestreo",
    "url":"/muestreo/plan"
  },
  {
    "id_menu":3,
    "id_submenu":4,
    "orden":3,
    "orden_submenu":1,
    "submenu":"Hoja Campo",
    "menu":"Recepción",
    "url":"/recepcion/hoja"
  },
  {
    "id_menu":3,
    "id_submenu":5,
    "orden":3,
    "orden_submenu":2,
    "submenu":"Recepción",
    "menu":"Recepción",
    "url":"/recepcion/recepcion"
  },
  {
    "id_menu":3,
    "id_submenu":6,
    "orden":3,
    "orden_submenu":3,
    "submenu":"Custodia Interna",
    "menu":"Recepción",
    "url":"/recepcion/custodia"
  },
  {
    "id_menu":4,
    "id_submenu":7,
    "orden":4,
    "orden_submenu":1,
    "submenu":"Muestras",
    "menu":"Inventario",
    "url":"/inventario/muestras"
  },
  {
    "id_menu":4,
    "id_submenu":8,
    "orden":4,
    "orden_submenu":2,
    "submenu":"Equipos",
    "menu":"Inventario",
    "url":"/inventario/equipo"
  },
  {
    "id_menu":4,
    "id_submenu":9,
    "orden":4,
    "orden_submenu":3,
    "submenu":"Reactivos",
    "menu":"Inventario",
    "url":"/inventario/reactivo"
  },
  {
    "id_menu":4,
    "id_submenu":10,
    "orden":4,
    "orden_submenu":4,
    "submenu":"Recipientes",
    "menu":"Inventario",
    "url":"/inventario/recipiente"
  },
  {
    "id_menu":5,
    "id_submenu":11,
    "orden":5,
    "orden_submenu":1,
    "submenu":"Fisicoquímicos",
    "menu":"Análisis",
    "url":"/analisis/fisico"
  },
  {
    "id_menu":5,
    "id_submenu":12,
    "orden":5,
    "orden_submenu":2,
    "submenu":"Metales Pesados",
    "menu":"Análisis",
    "url":"/analisis/metal"
  },
  {
    "id_menu":5,
    "id_submenu":13,
    "orden":5,
    "orden_submenu":3,
    "submenu":"Microbiológicos",
    "menu":"Análisis",
    "url":"/analisis/biologico"
  },
  {
    "id_menu":6,
    "id_submenu":14,
    "orden":6,
    "orden_submenu":1,
    "submenu":"Reportes",
    "menu":"Reporte",
    "url":"/reporte/reporte"
  },
  {
    "id_menu":7,
    "id_submenu":15,
    "orden":7,
    "orden_submenu":1,
    "submenu":"Paquete Puntos",
    "menu":"Catálogo",
    "url":"/catalogo/paquete"
  },
  {
    "id_menu":7,
    "id_submenu":16,
    "orden":7,
    "orden_submenu":2,
    "submenu":"Puntos",
    "menu":"Catálogo",
    "url":"/catalogo/punto"
  },
  {
    "id_menu":7,
    "id_submenu":17,
    "orden":7,
    "orden_submenu":3,
    "submenu":"Clientes",
    "menu":"Catálogo",
    "url":"/catalogo/cliente"
  },
  {
    "id_menu":7,
    "id_submenu":18,
    "orden":7,
    "orden_submenu":4,
    "submenu":"Empleados",
    "menu":"Catálogo",
    "url":"/catalogo/empleados"
  },
  {
    "id_menu":7,
    "id_submenu":19,
    "orden":7,
    "orden_submenu":5,
    "submenu":"Normas",
    "menu":"Catálogo",
    "url":"/catalogo/norma"
  },
  {
    "id_menu":7,
    "id_submenu":20,
    "orden":7,
    "orden_submenu":6,
    "submenu":"Métodos",
    "menu":"Catálogo",
    "url":"/catalogo/metodo"
  },
  {
    "id_menu":7,
    "id_submenu":21,
    "orden":7,
    "orden_submenu":7,
    "submenu":"Parámetros",
    "menu":"Catálogo",
    "url":"/catalogo/parametro"
  },
  {
    "id_menu":8,
    "id_submenu":22,
    "orden":8,
    "orden_submenu":1,
    "submenu":"Usuarios",
    "menu":"Administración",
    "url":"/sistema/usuario"
  },
  {
    "id_menu":8,
    "id_submenu":23,
    "orden":8,
    "orden_submenu":2,
    "submenu":"Perfil",
    "menu":"Administración",
    "url":"/sistema/perfil"
  },
  {
    "id_menu":8,
    "id_submenu":24,
    "orden":8,
    "orden_submenu":3,
    "submenu":"Cerrar Sesión",
    "menu":"Administración",
    "url":"/sistema/logout"
  }
]