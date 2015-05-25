<?php
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

$insertData = '
	{
		"id_estudio":0,
		"id_cliente":"1",
		"id_origen_orden":"3",
		"id_ubicacion":1,
		"id_ejercicio":2015,
		"id_status":1,
		"id_etapa":1,
		"id_usuario_captura":0,
		"id_usuario_valida":0,
		"id_usuario_entrega":0,
		"id_usuario_actualiza":0,
		"oficio":0,
		"folio":"",
		"origen_descripcion":"",
		"ubicacion":"Río Santiago",
		"fecha":"2015-05-24T05:00:00.000Z",
		"fecha_entrega":"",
		"fecha_captura":"",
		"fecha_valida":"",
		"fecha_rechaza":"",
		"ip_captura":"",
		"ip_valida":"",
		"ip_actualiza":"",
		"host_captura":"",
		"host_valida":"",
		"host_actualiza":"",
		"motivo_rechaza":"",
		"activo":1,
		"cliente":
		{
			"id_cliente":"1",
			"id_estado":"14",
			"id_municipio":"14039",
			"id_localidad":"140390001",
			"interno":"1",
			"cea":"1",
			"tasa":"0.0",
			"cliente":"CEA Jalisco",
			"area":"Dirección de Operación de PTARS",
			"rfc":"xxxx-xxxxxxxx",
			"calle":"Av. Brasilia",
			"numero":"2970",
			"colonia":"Colomos Providencia",
			"codigo_postal":"44680",
			"telefono":"3030-9350 ext. 8370",
			"fax":"",
			"contacto":"Biól. Luis Aceves Martínez",
			"puesto_contacto":"Director de Operación de PTARS",
			"email":"laceves@ceajalisco.gob.mx",
			"fecha_captura":"2015-02-10 00:00:00.0000000",
			"fecha_actualiza":null,
			"ip_captura":"[::1]",
			"ip_actualiza":null,
			"host_captura":"localhost",
			"host_actualiza":null,
			"activo":"1"
		},
		"ordenes":
		[
			{
				"id_orden":0,
				"id_estudio":0,
				"id_cliente":0,
				"id_matriz":"1",
				"id_tipo_muestreo":1,
				"id_norma":"1",
				"id_cuerpo_receptor":5,
				"id_status":1,
				"id_usuario_captura":0,
				"id_usuario_valida":0,
				"id_usuario_actualiza":0,
				"cantidad_muestras":"4",
				"costo_total":0,
				"cuerpo_receptor":"",
				"tipo_cuerpo":"",
				"fecha":"",
				"fecha_entrega":"",
				"fecha_captura":"",
				"fecha_valida":"",
				"fecha_actualiza":"",
				"fecha_rechaza":"",
				"ip_captura":"",
				"ip_valida":"",
				"ip_actualiza":"",
				"host_captura":"",
				"host_valida":"",
				"host_actualiza":"",
				"motivo_rechaza":"",
				"comentarios":"",
				"activo":1,
				"$$hashKey":"object:158"
			}
		]
	}
';
$requestData = json_decode($insertData);
$request = array(
	"headers" = array (
		"Accept" => "application/json, text/plain, */*",
		"Accept-Encoding" => "gzip, deflate",
		"Accept-Language" => "es-ES,es;q=0.8,en;q=0.6",
		"Cache-Control" => "no-cache",
		"Connection" => "keep-alive",
		"Content-Length" => "100",
		"Content-Type" => "application/json;charset=UTF-8",
		"Host" => "localhost:8888",
		"Origin" => "http://localhost:8888",
		"Pragma" => "no-cache",
		"Referer" => "http://localhost:8888/siclab/app/",
		"User-Agent" => "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.65 Safari/537.36",
		"Auth-Token" => "--JWT TOKEN--"
	)
);
print_r(insertStudy($requestData, $request));

function insertStudy($study, $request) {
	$study = (array) $study;
	$studyClient = $study["cliente"];
	$studyOrders = $study["ordenes"];
	unset($study["cliente"]);
	unset($study["ordenes"]);
	unset($study["id_estudio"]);

	//"ip" = $request->getIp();
	//"url" = $request->getUrl();

	//hex2bin($token["upt"])  explode by '.' as array[2] -userId-
	//$decoded = JWT::decode($jwt, KEY);

	$study["ip_captura"] = $request->getIp();
	$study["host_captura"] = $request->getUrl();
	//CEA-001/2015
	/*
	$sql = "INSERT INTO Usuario
		( id_nivel, id_rol, id_area, id_puesto, interno, cea,
		 laboratorio, supervisa, analiza,
		 muestrea, nombres, apellido_paterno,
		 apellido_materno, usr, pwd,
		 fecha_captura, fecha_actualiza,
		 ip_captura, ip_actualiza,
		 host_captura, host_actualiza,
		 activo)
		VALUES ( :id_nivel, :id_rol, :id_area, :id_puesto, :interno,
			:cea, :laboratorio, :supervisa, :analiza, :muestrea, :nombres,
			:apellido_paterno, :apellido_materno, :usr, :pwd, :fecha_captura,
			:fecha_actualiza, :ip_captura, :ip_actualiza, :host_captura,
			:host_actualiza, :activo
		)";
	*/
	return $requestData;

}






// $studyPayload = json_decode($studyDataString);
// $orders = $studyPayload->ordenes;
// print_r($orders);
// // $l = count($orders);
// // for ($i=0; $i < $l; $i++) {
// // 	array (
// // 		"id_orden" => $orders[$i]->id_orden,
// // 		"id_estudio" => $orders[$i]->id_estudio,
// // 		"id_matriz" => $orders[$i]->id_matriz,
// // 		"id_tipo_muestreo" => $orders[$i]->id_tipo_muestreo,
// // 		"id_norma" => $orders[$i]->id_norma,
// // 		"id_status" => $orders[$i]->id_status,
// // 		"cantidad_muestras" => $orders[$i]->cantidad_muestras,
// // 		"activo" => $orders[$i]->activo
// // 	);
// // }

// $insertStudyData = array(
// 	"id_estudio" => $requestData->id_estudio,
// 	"id_cliente" => $requestData->id_cliente,
// 	"id_origen_orden" => $requestData->id_origen_orden,
// 	"id_ubicacion" => $requestData->id_ubicacion,
// 	"id_ejercicio" => $requestData->id_ejercicio,
// 	"id_status" => $requestData->id_status,
// 	"id_etapa" => $requestData->id_etapa,
// 	"id_usuario_captura" => $requestData->id_usuario_captura,
// 	"id_usuario_valida" => $requestData->id_usuario_valida,
// 	"id_usuario_entrega" => $requestData->id_usuario_entrega,
// 	"id_usuario_actualiza" => $requestData->id_usuario_actualiza,
// 	"oficio" => $requestData->oficio,
// 	"folio" => $requestData->folio,
// 	"origen_descripcion" => $requestData->origen_descripcion,
// 	"ubicacion" => $requestData->ubicacion,
// 	"fecha" => $requestData->fecha,
// 	"fecha_entrega" => $requestData->fecha_entrega,
// 	"fecha_captura" => $requestData->fecha_captura,
// 	"fecha_valida" => $requestData->fecha_valida,
// 	"fecha_rechaza" => $requestData->fecha_rechaza,
// 	"ip_captura" => $requestData->ip_captura,
// 	"ip_valida" => $requestData->ip_valida,
// 	"ip_actualiza" => $requestData->ip_actualiza,
// 	"host_captura" => $requestData->host_captura,
// 	"host_valida" => $requestData->host_valida,
// 	"host_actualiza" => $requestData->host_actualiza,
// 	"motivo_rechaza" => $requestData->motivo_rechaza,
// 	"activo" => $requestData->activo
// );



// 	$payload = '
// 		{
// 			"id_usuario":5,
// 			"id_nivel":6,
// 			"id_rol":8,
// 			"id_area":5,
// 			"id_puesto":7,
// 			"interno":1,
// 			"cea":1,
// 			"laboratorio":1,
// 			"supervisa":0,
// 			"analiza":0,
// 			"muestrea":0,
// 			"nombres":"Mirna María",
// 			"apellido_paterno":"Román",
// 			"apellido_materno":"García",
// 			"usr":"mroman",
// 			"pwd":"73d1b1b1bc1dabfb97f216d897b7968e44b06457920f00f2dc6c1ed3be25ad4c",
// 			"fecha_captura":"2014-11-10 00:00",
// 			"fecha_actualiza":"2014-11-10 00:00",
// 			"ip_captura":"[::1]",
// 			"ip_actualiza":"[::1]",
// 			"host_captura":"localhost",
// 			"host_actualiza":"localhost",
// 			"activo":1
// 		}
// 	';
// 	$requestData = json_decode($payload);
// 	$insertDataArray = array (
// 		"id_nivel" => $requestData->id_nivel,
// 		"id_rol" => $requestData->id_rol,
// 		"id_area" => $requestData->id_area,
// 		"id_puesto" => $requestData->id_puesto,
// 		"interno" => $requestData->interno,
// 		"cea" => $requestData->cea,
// 		"laboratorio" => $requestData->laboratorio,
// 		"supervisa" => $requestData->supervisa,
// 		"analiza" => $requestData->analiza,
// 		"muestrea" => $requestData->muestrea,
// 		"nombres" => utf8_decode($requestData->nombres),
// 		"apellido_paterno" => utf8_decode($requestData->apellido_paterno),
// 		"apellido_materno" => utf8_decode($requestData->apellido_materno),
// 		"usr" => $requestData->usr,
// 		"pwd" => $requestData->pwd,
// 		"fecha_captura" => $requestData->fecha_captura,
// 		"fecha_actualiza" => $requestData->fecha_actualiza,
// 		"ip_captura" => $requestData->ip_captura,
// 		"ip_actualiza" => $requestData->ip_actualiza,
// 		"host_captura" => $requestData->host_captura,
// 		"host_actualiza" => $requestData->host_actualiza,
// 		"activo" => $requestData->activo
// 	);
// 	try {
// 		// $sql = "INSERT INTO Usuario
// 		// 	( id_nivel, id_rol, id_area, id_puesto, interno, cea,
// 		// 	 laboratorio, supervisa, analiza, muestrea, nombres, apellido_paterno,
// 		// 	 apellido_materno, usr, pwd, fecha_captura, fecha_actualiza,
// 		// 	 ip_captura, ip_actualiza, host_captura, host_actualiza, activo)
// 		// 	VALUES ( :id_nivel, :id_rol, :id_area, :id_puesto, :interno,
// 		// 		:cea, :laboratorio, :supervisa, :analiza, :muestrea, :nombres,
// 		// 		:apellido_paterno, :apellido_materno, :usr, :pwd, :fecha_captura,
// 		// 		:fecha_actualiza, :ip_captura, :ip_actualiza, :host_captura,
// 		// 		:host_actualiza, :activo
// 		// 	)";
// 		// $db = getConnection();
// 		// $stmt = $db->prepare($sql);
// 		// $stmt->execute($insertDataArray);
// 		// $userId = $db->lastInsertId();
// 		// $db = null;

// 		$userId = 9;
// 		print_r("<h1>ID: ");
// 		print_r($userId);
// 		print_r("</h1>");

// 		$sql = "SELECT id_usuario, id_nivel, id_rol, id_area, id_puesto,
// 			interno, cea, laboratorio, supervisa, analiza, muestrea, nombres,
// 			apellido_paterno, apellido_materno, usr, pwd, fecha_captura,
// 			fecha_actualiza, ip_captura, ip_actualiza,
// 			host_captura, host_actualiza, activo
// 			FROM Usuario
// 			WHERE id_usuario=:userId
// 		";
// 		try {
// 			$db = getConnection();
// 			$stmt = $db->prepare($sql);
// 			$stmt->bindParam("userId", $userId);
// 			$stmt->execute();
// 			$updates = $stmt->fetch(PDO::FETCH_OBJ);
// 			print_r($updates);
// 		} catch(PDOException $e) {
// 			echo '{"error":{"text":'. $e->getMessage() .'}}';
// 		}
// 		print_r("<hr>");
// 	} catch(PDOException $e) {
// 		print_r($e->getMessage());
// 	}
// 	echo "<hr>";


// function insertStudy() {


// 	//print_r(json_decode(isQuoteListValid($quotes)));

// return $userId;
// 	// $sql2 = "SELECT * FROM Usuario WHERE id_usuario = :userId";
// 	// $stmt2 = $db->prepare($sql2);
// 	// $stmt2->bindParam("userName", $userName);
// 	// $result2 = $stmt2->fetchAll(PDO::FETCH_OBJ);
// 	// return $result2;
// }

// 	print_r("<hr>");
// 	print_r(insertStudy($requestData, $insertDataArray));
// 	print_r("<hr>");

// function isQuoteListValid($quotes) {
// 	$i = 0;
// 	$l = count($quotes);
// 	if (isset($quotes) && count($quotes) > 0)
// 	{
// 		for ($i = 0; $i < $l; $i++) {
// 			if (!is_numeric($quotes[$i]->id_matriz) || $quotes[$i]->id_matriz > 1)
// 			{
// 				$message .= 'matriz:' . $i . ',';
// 			}
// 			if (!is_numeric($quotes[$i]->cantidad_muestras) || $quotes[$i]->cantidad_muestras > 1)
// 			{
// 				$message .= 'cantidad_muestras:' . $i . ',';
// 			}
// 			if ($quotes[$i]->id_tipo_muestreo > 1)
// 			{
// 				$message .= 'id_tipo_muestreo:' . $i . ',';
// 			}
// 			if ($quotes[$i]->id_norma > 1)
// 			{
// 				$message .= 'norma:' . $i . ',';
// 			}
// 		}
// 	}
// 	$output = '{';
// 	if ($status < 1)
// 	{
// 		$output .= '"status":"0","reason":"invalid input","message":"';
// 		$output .= $message . '"';
// 	}
// 	else
// 	{
// 		$output .= '"status":"1","reason":"valid input","message":"none"';
// 	}
// 	$output .= '}';
// 	return $output;
// }

// function isFormValid() {
// // 	$message = '';
// // 	if (!DateUtilsService.isValidDate(new Date($study->fecha)))
// // 	{
// // 		$message .= ' Ingrese una fecha válida ';
// // 		return false;
// // 	}
// // 	if ($study->id_cliente < 1)
// // 	{
// // 		$message .= ' Seleccione un cliente ';
// // 		return false;
// // 	}
// // 	if (!isQuoteListValid())
// // 	{
// // 		return isQuoteListValid();
// // 	}
// // 	if ($study->id_origen_orden < 1)
// // 	{
// // 		$message .= ' Seleccione un medio de solicitud de muestreo ';
// // 		return false;
// // 	}
// // 	if ($study->id_origen_orden == 1 || $study->id_origen_orden == 4)
// // 	{
// // 		if ($study->origen_descripcion.length < 1)
// // 		{
// // 			$message .= ' Ingrese oficio o emergencia ';
// // 			return false;
// // 		}
// // 	}
// // 	if ($study->ubicacion.length < 1)
// // 	{
// // 		$message .= ' Ingrese una ubicación ';
// // 		return false;
// // 	}
// // 	if ($userLevel < 3)
// // 	{
// // 		if ($study->id_status == 3 && strlen(($study->motivo_rechaza) < 1)
// // 		{
// // 			$message .= ' Ingrese el motivo de rechazo del Informe ';
// // 			return false;
// // 		}
// // 	}
// // 	return true;
// //
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



// /*
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

// /*
// $app->get('/acciones/:id', 'getAccion');

// /*
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

