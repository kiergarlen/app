<?php
// define("DB_DRIVER", "sqlsrv");
// define("DB_HOST", "localhost");
// define("DB_USER", "sislab");
// define("DB_PASSWORD", "sislab");
// define("DB_DATA_BASE", "Sislab");
// // define("DB_DRIVER", "mysql");
// // define("DB_HOST", "localhost");
// // define("DB_PORT", "8889");
// // define("DB_USER", "root");
// // define("DB_PASSWORD", "root");
// // define("DB_DATA_BASE", "sislab");

// function getConnection() {
// 	try {
// 		// $dsn = "mysql:host=";
// 		// $dsn .= DB_HOST . ";";
// 		// $dsn .= "port=" . DB_PORT . ";";
// 		// $dsn .= "dbname=" . DB_DATA_BASE;
// 		$dsn = "sqlsrv:server=";
// 		$dsn .= DB_HOST . ";Database=";
// 		$dsn .= DB_DATA_BASE;

// 		$dbConnection = new PDO($dsn, DB_USER, DB_PASSWORD);
// 		$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// 	} catch(PDOException $e) {
// 		//error_log($e->getMessage(), 3, '/var/tmp/php.log');
// 		//echo '{"error":{"text":'. $e->getMessage() .'}}';
// 		$output = '{"error":"' . $e->getMessage() . '"}';
// 	}
// 	return $dbConnection;
// }

// /*
// // THIS IS AN EXAMPLE
// $dbhost = "localhost";
// $dbname = "pdo";
// $dbusername = "root";
// $dbpassword = "845625";

// $link = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbusername,$dbpassword);

// $statement = $link->prepare("INSERT INTO testtable(name, lastname, age)
//     VALUES(:fname, :sname, :age)");
// $statement->execute(array(
//     "fname" => "Bob",
//     "sname" => "Desaunois",
//     "age" => "18"
// ));

// $statement = $link->prepare("INSERT INTO testtable(name, lastname, age)
//     VALUES(?, ?, ?)");

// $statement->execute(array("Bob", "Desaunois", "18"));


// //END EXAMPLE
// // define("DB_DRIVER", "sqlsrv");
// // define("DB_HOST", "localhost");
// // define("DB_PORT", "");
// // define("DB_USER", "sislab");
// // define("DB_PASSWORD", "sislab");
// // define("DB_DATA_BASE", "Sislab");

// define("DB_DRIVER", "mysql");
// define("DB_HOST", "localhost");
// define("DB_PORT", "8889");
// define("DB_USER", "root");
// define("DB_PASSWORD", "root");
// define("DB_DATA_BASE", "sislab");

// function getConnection() {
// 	try {
// 		$dsn = "mysql:host=";
// 		$dsn .= DB_HOST . ";";
// 		if (strlen(DB_PORT) > 0)
// 		{
// 			$dsn .= "port=" . DB_PORT . ";";
// 		}
// 		$dsn .= "dbname=" . DB_DATA_BASE;

// 		$dbConnection = new PDO($dsn, DB_USER, DB_PASSWORD);
// 		$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// 	} catch(PDOException $e) {
// 		//error_log($e->getMessage(), 3, '/var/tmp/php.log');
// 		//echo '{"error":{"text":'. $e->getMessage() .'}}';
// 		$output = '{"error":"' . $e->getMessage() . '"}';
// 	}
// 	return $dbConnection;
// }


// /*
// 	const DB_DRIVER = "mysql";
// 	//const DB_DRIVER = "sqlsrv";
// 	const DB_HOST = "localhost";
// 	const DB_PORT = "8889";
// 	const DB_USER = "root";
// 	const DB_PASSWORD = "root";
// 	const DB_DATA_BASE = "sislab";

// 	// const DB_USER = "sislab";
// 	// const DB_PASSWORD = "sislab@12#";
// 	// const DB_DATA_BASE = "Sislab";


// function getDB2() {
// 	$dsn = "sqlsrv:server=";
// 	$dsn .= DB_HOST . ";Database=";
// 	$dsn .= DB_DATA_BASE;

// 	$dbConnection = new PDO($dsn, DB_USER, DB_PASSWORD);
// 	$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// 	return $dbConnection;
// }

// function getDB() {
// 	$dsn = "mysql:host=";
// 	$dsn .= DB_HOST . ";";
// 	if (strlen(DB_PORT) > 0)
// 	{
// 		$dsn .= "port=" . DB_PORT . ";";
// 	}
// 	$dsn .= "dbname=" . DB_DATA_BASE;
// 	$dbConnection = new PDO($dsn, DB_USER, DB_PASSWORD);
// 	$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// 	return $dbConnection;
// }


// function processResultToJson($items, $isArrayOutputExpected)
// {
// 	$output = "";
// 	try {
// 		if ($isArrayOutputExpected)
// 		{
// 			$output .= "[";
// 		}
// 		$i = 0;
// 		$l = count($items);
// 		foreach ($items as $item) {
// 			$i++;
// 			$j = 0;
// 			$item = (array)$item;
// 			$m = count($item);
// 			$output .= "{";
// 			foreach ($item as $key => $value) {
// 				$j++;
// 				$output .= '"' . $key . '":';
// 				$v = $value;
// 				if (!is_numeric($v))
// 				{
// 					//TODO: format string for dates
// 					$v = '"' . utf8_encode($value) .'"';
// 				}
// 				$output .= $v;
// 				if ($j < $m)
// 				{
// 					$output .= ",";
// 				}
// 			}
// 			$output .= "}";
// 			if ($isArrayOutputExpected && $i < $l)
// 			{
// 				$output .= ",";
// 			}
// 		}
// 		if ($isArrayOutputExpected)
// 		{
// 			$output .= "]";
// 		}
// 	} catch(PDOException $e) {
// 		//error_log($e->getMessage(), 3, '/var/tmp/php.log');
// 		//echo '{"error":{"text":'. $e->getMessage() .'}}';
// 		$output = '{"error":"' . $e->getMessage() . '"}';
// 	}
// 	return $output;
// }

// 	$userName = "rgarcia";
// 	$userPassword = "8493a161f70fffc0dcd4732ae4f6c4667f373688fff802ea13c71bd0fce41cb1";


// 	$db = getDB();
// 	$stmt = $db->prepare($sql);
// 	$stmt->bindParam("userName", $userName);
// 	$stmt->bindParam("userPassword", $userPassword);
// 	$stmt->execute();
// 	print_r(processResultToJson($stmt->fetchAll(PDO::FETCH_ASSOC), false));




// /*
// require 'Slim/Slim.php';
// \Slim\Slim::registerAutoloader();

// $app = new \Slim\Slim();

// $app->get('/users','getUsers');
// $app->get('/updates','getUserUpdates');
// $app->post('/updates', 'insertUpdate');
// $app->delete('/updates/delete/:update_id','deleteUpdate');
// $app->get('/users/search/:query','getUserSearch');

// $app->run();

// function getUsers() {
// 	$sql = "SELECT user_id,username,name,profile_pic FROM users ORDER BY user_id";

// 	$sql = "SELECT id_usuario, id_nivel, id_rol, id_area, id_puesto, interno, cea, laboratorio, supervisa, analiza, muestrea, nombres, apellido_paterno, apellido_materno, usr, pwd, fecha_captura, fecha_actualiza, ip_captura, ip_actualiza, host_catura, host_actualiza, activo FROM Usuario";
// 	try {
// 		$db = getDB();
// 		$stmt = $db->query($sql);
// 		$users = $stmt->fetchAll(PDO::FETCH_OBJ);
// 		$db = null;
// 		echo '{"users": ' . json_encode($users) . '}';
// 	} catch(PDOException $e) {
// 	    //error_log($e->getMessage(), 3, '/var/tmp/php.log');
// 		echo '{"error":{"text":'. $e->getMessage() .'}}';
// 	}
// }

// function getUserUpdates() {
// 	$sql = "SELECT A.user_id, A.username, A.name, A.profile_pic, B.update_id, B.user_update, B.created FROM users A, updates B WHERE A.user_id=B.user_id_fk  ORDER BY B.update_id DESC";
// 	try {
// 		$db = getDB();
// 		$stmt = $db->prepare($sql);
// 		$stmt->execute();
// 		$updates = $stmt->fetchAll(PDO::FETCH_OBJ);
// 		$db = null;
// 		echo '{"updates": ' . json_encode($updates) . '}';

// 	} catch(PDOException $e) {
// 	    //error_log($e->getMessage(), 3, '/var/tmp/php.log');
// 		echo '{"error":{"text":'. $e->getMessage() .'}}';
// 	}
// }

// function getUserUpdate($update_id) {
// 	$sql = "SELECT A.user_id, A.username, A.name, A.profile_pic, B.update_id, B.user_update, B.created FROM users A, updates B WHERE A.user_id=B.user_id_fk AND B.update_id=:update_id";
// 	try {
// 		$db = getDB();
// 		$stmt = $db->prepare($sql);
//         $stmt->bindParam("update_id", $update_id);
// 		$stmt->execute();
// 		$updates = $stmt->fetchAll(PDO::FETCH_OBJ);
// 		$db = null;
// 		echo '{"updates": ' . json_encode($updates) . '}';

// 	} catch(PDOException $e) {
// 	    //error_log($e->getMessage(), 3, '/var/tmp/php.log');
// 		echo '{"error":{"text":'. $e->getMessage() .'}}';
// 	}
// }

// function insertUpdate() {
// 	$request = \Slim\Slim::getInstance()->request();
// 	$update = json_decode($request->getBody());
// 	$sql = "INSERT INTO updates (user_update, user_id_fk, created, ip) VALUES (:user_update, :user_id, :created, :ip)";
// 	try {
// 		$db = getDB();
// 		$stmt = $db->prepare($sql);
// 		$stmt->bindParam("user_update", $update->user_update);
// 		$stmt->bindParam("user_id", $update->user_id);
// 		$time=time();
// 		$stmt->bindParam("created", $time);
// 		$ip=$_SERVER['REMOTE_ADDR'];
// 		$stmt->bindParam("ip", $ip);
// 		$stmt->execute();
// 		$update->id = $db->lastInsertId();
// 		$db = null;
// 		$update_id= $update->id;
// 		getUserUpdate($update_id);
// 	} catch(PDOException $e) {
// 		//error_log($e->getMessage(), 3, '/var/tmp/php.log');
// 		echo '{"error":{"text":'. $e->getMessage() .'}}';
// 	}
// }

// function deleteUpdate($update_id) {

// 	$sql = "DELETE FROM updates WHERE update_id=:update_id";
// 	try {
// 		$db = getDB();
// 		$stmt = $db->prepare($sql);
// 		$stmt->bindParam("update_id", $update_id);
// 		$stmt->execute();
// 		$db = null;
// 		echo true;
// 	} catch(PDOException $e) {
// 		echo '{"error":{"text":'. $e->getMessage() .'}}';
// 	}

// }

// function getUserSearch($query) {
// 	$sql = "SELECT user_id,username,name,profile_pic FROM users WHERE UPPER(name) LIKE :query ORDER BY user_id";
// 	try {
// 		$db = getDB();
// 		$stmt = $db->prepare($sql);
// 		$query = "%".$query."%";
// 		$stmt->bindParam("query", $query);
// 		$stmt->execute();
// 		$users = $stmt->fetchAll(PDO::FETCH_OBJ);
// 		$db = null;
// 		echo '{"users": ' . json_encode($users) . '}';
// 	} catch(PDOException $e) {
// 		echo '{"error":{"text":'. $e->getMessage() .'}}';
// 	}
// }



//
// $validateAccessToken = function($app) {
//    return function () use ($app) {
// 		$request = $app->request();
// 		$headers = $request->headers();

// 		$jwt = $headers["Auth-Token"];
// 		$decoded = JWT::decode($jwt, KEY);
// 		$userPass = hex2bin($decoded->upt);
// 		$userPassArray = explode (".", $userPass);
// 		$userId = 0;
// 		if ($userPassArray[0] === "rgarcia" && $userPassArray[1] === "rgarcia")
// 		{
// 			$userId = 1;
// 		}
// 		else
// 		{
// 		   //$app->redirect("/errorpage");
// 		}
// 	};
// };

//
// $app->get('/acciones/:id', 'getAccion');

//
// function addWine() {
// 	$request = Slim::getInstance()->request();
// 	$wine = json_decode($request->getBody());
// 	$sql = "INSERT INTO wine (name, grapes, country, region, year, description) VALUES (:name, :grapes, :country, :region, :year, :description)";
// 	try {
// 		$db = getConnection();
// 		$stmt = $db->prepare($sql);
// 		$stmt->bindParam("name", $wine->name);
// 		$stmt->bindParam("grapes", $wine->grapes);
// 		$stmt->bindParam("country", $wine->country);
// 		$stmt->bindParam("region", $wine->region);
// 		$stmt->bindParam("year", $wine->year);
// 		$stmt->bindParam("description", $wine->description);
// 		$stmt->execute();
// 		$wine->id = $db->lastInsertId();
// 		$db = null;
// 		echo json_encode($wine);
// 	} catch(PDOException $e) {
// 		echo '{"error":{"text":'. $e->getMessage() .'}}';
// 	}
// }



