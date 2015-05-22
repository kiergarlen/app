<?php
require "../libs/Slim/Slim.php";
require "../libs/JWT/JWT.php";
require "./Services/Sislab.php";
// cd372fb85148700fa88095e3492d3f9f5beb43e555e5ff26d95f5a6adc36f8e6
define("KEY", "m0oxUT7L8Unn93hXMUGHpwq_jTSKVBjQfEVCUe8jZ38KUU4VSAfmsNk4JJYcJl7CukrY6QMlixxwat7AZSpDcSQ");

define("DB_DRIVER", "sqlsrv");
define("DB_HOST", "localhost");
define("DB_USER", "sislab");
define("DB_PASSWORD", "sislab");
define("DB_DATA_BASE", "Sislab");

// define("DB_DRIVER", "mysql");
// define("DB_HOST", "localhost");
// define("DB_PORT", "8889");
// define("DB_USER", "root");
// define("DB_PASSWORD", "root");
// define("DB_DATA_BASE", "sislab");

\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();

$app->get("/user", function() use ($app) {
	try {
		$userId = validateTokenUser($app);
		$result = getMenu($userId);
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		//$result = ")]}',\n" . $result;
		echo $result;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->run();

print_r(getUr(1));

function getConnection() {
	try {
		// $dsn = "mysql:host=";
		// $dsn .= DB_HOST . ";";
		// $dsn .= "port=" . DB_PORT . ";";
		// $dsn .= "dbname=" . DB_DATA_BASE;
		$dsn = "sqlsrv:server=";
		$dsn .= DB_HOST . ";Database=";
		$dsn .= DB_DATA_BASE;

		$dbConnection = new PDO($dsn, DB_USER, DB_PASSWORD);
		$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch(PDOException $e) {
		//error_log($e->getMessage(), 3, '/var/tmp/php.log');
		//echo '{"error":{"text":'. $e->getMessage() .'}}';
		$output = '{"error":"' . $e->getMessage() . '"}';
	}
	return $dbConnection;
}

function getUsers() {
	$result = \Service\Sislab::getInstance()->getUsers();
	// $sql = "SELECT id_usuario, id_nivel, id_rol, id_area, id_puesto,
	// 	interno, cea, laboratorio, supervisa, analiza, muestrea,
	// 	nombres, apellido_paterno, apellido_materno, usr, pwd,
	// 	fecha_captura, fecha_actualiza, ip_captura, ip_actualiza,
	// 	host_captura, host_actualiza, activo
	// 	FROM Usuario WHERE activo = 1";
	// $db = getConnection();
	// $stmt = $db->prepare($sql);
	// $stmt->bindParam("userName", $userName);
	// $stmt->bindParam("userPassword", $userPassword);
	// $stmt->execute();
	// $result = processResultToJson($stmt->fetchAll(PDO::FETCH_ASSOC), false);
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
				//else
				//{
				//	$v = utf8_encode($v);
				//}
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
