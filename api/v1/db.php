<?php
//DB FUNCTIONS

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
	$sql = "SELECT id_usuario, id_nivel, id_rol, id_area, id_puesto,
		interno, cea, laboratorio, supervisa, analiza, muestrea,
		nombres, apellido_paterno, apellido_materno, usr, pwd,
		CONVERT(nvarchar, fecha_captura, 126) AS fecha_captura,
		CONVERT(nvarchar, fecha_actualiza, 126) AS fecha_actualiza,
		ip_captura, ip_actualiza,
		host_captura, host_actualiza, activo
		FROM Usuario
		WHERE activo = 1";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->bindParam("userName", $userName);
	$stmt->bindParam("userPassword", $userPassword);
	$stmt->execute();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$db = null;
	return $result;
}

function getUser($userId) {
	$sql = "SELECT id_usuario, id_nivel, id_rol, id_area, id_puesto,
		interno, cea, laboratorio, supervisa, analiza, muestrea, nombres,
		apellido_paterno, apellido_materno, usr, pwd,
		CONVERT(nvarchar, fecha_captura, 126) AS fecha_captura,
		CONVERT(nvarchar, fecha_actualiza, 126) AS fecha_actualiza,
		ip_captura, ip_actualiza,
		host_captura, host_actualiza, activo
		FROM Usuario
		WHERE activo = 1 AND id_usuario = :userId";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->bindParam("userId", $userId);
	$stmt->execute();
	$user = (array) $stmt->fetchAll(PDO::FETCH_OBJ)[0];
	$db = null;
	return (object) $user;
}

function getUserByCredentials($userName, $userPassword) {
	$sql = "SELECT id_usuario, id_nivel, id_rol, id_area, id_puesto,
		interno, cea, laboratorio, supervisa, analiza, muestrea,
		nombres, apellido_paterno, apellido_materno, usr, pwd,
		CONVERT(nvarchar, fecha_captura, 126) AS fecha_captura,
		CONVERT(nvarchar, fecha_actualiza, 126) AS fecha_actualiza,
		ip_captura, ip_actualiza,
		host_captura, host_actualiza, activo
		FROM Usuario
		WHERE activo = 1 AND pwd = :userPassword AND usr = :userName";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->bindParam("userName", $userName);
	$stmt->bindParam("userPassword", $userPassword);
	$stmt->execute();
	$user = (array) $stmt->fetchAll(PDO::FETCH_OBJ)[0];
	$db = null;
	return (object) $user;
}

function insertUser($userData) {
	$sql = "INSERT INTO Usuario (id_nivel, id_rol, id_area, id_puesto,
		interno, cea, laboratorio, supervisa, analiza, muestrea,
		nombres, apellido_paterno, apellido_materno, usr, pwd,
		fecha_captura, fecha_actualiza,
		ip_captura, ip_actualiza,
		host_captura, host_actualiza, activo)
		VALUES (:id_nivel, :id_rol, :id_area, :id_puesto,
		:interno, :cea, :laboratorio, :supervisa, :analiza, :muestrea,
		:nombres, :apellido_paterno, :apellido_materno, :usr, :pwd,
		:fecha_captura, :fecha_actualiza,
		:ip_captura, :ip_actualiza,
		:host_captura, :host_actualiza, :activo,)";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->execute($userData);
	$userId = $db->lastInsertId();
	$db = null;
	return $userId;
}

function updateUser($updateData) {
	$sql = "UPDATE Usuario SET id_nivel = :id_nivel, id_rol = :id_rol,
		id_area = :id_area, id_puesto = :id_puesto,interno = :interno,
		cea = :cea, laboratorio = :laboratorio, supervisa = :supervisa,
		analiza = :analiza, muestrea = :muestrea,nombres = :nombres,
		apellido_paterno = :apellido_paterno,
		apellido_materno = :apellido_materno, usr = :usr,
		pwd = :pwd, fecha_captura = :fecha_captura,
		fecha_actualiza = :fecha_actualiza,
		ip_captura = :ip_captura,
		ip_actualiza = :ip_actualiza,host_captura = :host_captura,
		host_actualiza = :host_actualiza, activo = :activo
		WHERE id_usuario = :id_usuario";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->execute($updateData);
	$db = null;
	return $updateData["id_usuario"];
}

function getMenu($userId) {
	$sql = "SELECT
		id_usuario, id_menu, id_submenu, orden, orden_submenu,
		menu, submenu, url
		FROM viewUsuarioMenu
		WHERE id_usuario = :userId
		ORDER BY id_menu, orden, orden_submenu";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->bindParam("userId", $userId);
	$stmt->execute();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$db = null;
	return $result;
}

function getTasks($userId) {
	$result = '[]';
	// $sql = "SELECT * FROM Tarea WHERE activo = 1";
	// $db = getConnection();
	// $stmt = $db->prepare($sql);
	// $stmt->bindParam("userId", $userId);
	// $stmt->execute();
	// $result = json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
	return $result;
}

function getClients() {
	$sql = "SELECT id_cliente, id_estado, id_municipio,
		id_localidad, interno, cea, tasa, cliente, area,
		rfc, calle, numero, colonia, codigo_postal, telefono,
		fax, contacto, puesto_contacto, email,
		CONVERT(nvarchar, fecha_captura, 126) AS fecha_captura,
		CONVERT(nvarchar, fecha_actualiza, 126) AS fecha_actualiza,
		ip_captura, ip_actualiza, host_captura,
		host_actualiza, activo
		FROM Cliente
		WHERE activo = 1";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->execute();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$db = null;
	return $result;
}

function getClient($clientId) {
	$sql = "SELECT id_cliente, id_estado, id_municipio,
		id_localidad, interno, cea, tasa, cliente, area,
		rfc, calle, numero, colonia, codigo_postal, telefono,
		fax, contacto, puesto_contacto, email,
		CONVERT(nvarchar, fecha_captura, 126) AS fecha_captura,
		CONVERT(nvarchar, fecha_actualiza, 126) AS fecha_actualiza,
		ip_captura, ip_actualiza, host_captura,
		host_actualiza, activo
		FROM Cliente
		WHERE activo = 1 AND id_cliente = :clientId";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->bindParam("clientId", $clientId);
	$stmt->execute();
	$client = (array) $stmt->fetchAll(PDO::FETCH_OBJ)[0];
	$db = null;
	return (object) $client;
}

function getStudies() {
	$sql = "SELECT id_estudio, id_cliente, id_origen_orden,
		id_ubicacion, id_ejercicio, id_status, id_etapa,
		id_usuario_captura, id_usuario_valida, id_usuario_entrega,
		id_usuario_actualiza, oficio, folio, origen_descripcion,
		ubicacion,
		CONVERT(nvarchar, fecha, 126) AS fecha,
		CONVERT(nvarchar, fecha_entrega, 126) AS fecha_entrega,
		CONVERT(nvarchar, fecha_captura, 126) AS fecha_captura,
		CONVERT(nvarchar, fecha_valida, 126) AS fecha_valida,
		CONVERT(nvarchar, fecha_actualiza, 126) AS fecha_actualiza,
		CONVERT(nvarchar, fecha_rechaza, 126) AS fecha_rechaza,
		ip_captura, ip_valida, ip_actualiza,
		host_captura, host_valida, host_actualiza, motivo_rechaza,
		activo
		FROM Estudio
		WHERE activo = 1";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->execute();
	$studies = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$db = null;
	$i = 0;
	$l = count($studies);
	for ($i = 0; $i < $l; $i++) {
		$studies[$i]["cliente"] = getClient($studies[$i]['id_cliente']);
		$studies[$i]["ordenes"] = getStudyOrders($studies[$i]['id_estudio']);
	}
	return $studies;
}

function getBlankStudy() {
	return array(
		"id_estudio" => 0, "id_cliente" => 0,
		"id_origen_orden" => 0, "id_ubicacion" => 1,
		"id_ejercicio" => 2015, "id_status" => 1,
		"id_etapa" => 1, "id_usuario_captura" => 0,
		"id_usuario_valida" => 0, "id_usuario_entrega" => 0,
		"id_usuario_actualiza" => 0, "oficio" => 0,
		"folio" => "", "origen_descripcion" => "",
		"ubicacion" => "", "fecha" => "",
		"fecha_entrega" => "", "fecha_captura" => "",
		"fecha_valida" => "", "fecha_actualiza" => "",
		"fecha_rechaza" => "",
		"ip_captura" => "", "ip_valida" => "",
		"ip_actualiza" => "", "host_captura" => "",
		"host_valida" => "", "host_actualiza" => "",
		"motivo_rechaza" => "", "activo" => 1,
		"cliente" => array(
			"id_cliente" => 0, "id_estado" => 14,
			"id_municipio" => 14039, "id_localidad" => 140390001,
			"interno" => 0, "cea" => 0,
			"tasa" => 0, "cliente" => "",
			"area" => "", "rfc" => "",
			"calle" => "", "numero" => "",
			"colonia" => "", "codigo_postal" => "",
			"telefono" => "", "fax" => "",
			"contacto" => "", "puesto_contacto" => "",
			"email" => "", "fecha_captura" => "",
			"fecha_actualiza" => "", "ip_captura" => "",
			"ip_actualiza" => "", "host_captura" => "",
			"host_actualiza" => "", "activo" => 1
		),
		"ordenes" => array(
			array(
				"id_orden" => 0, "id_estudio" => 0,
				"id_cliente" => 0, "id_matriz" => 0,
				"id_tipo_muestreo" => 1, "id_norma" => 0,
				"id_cuerpo_receptor" => 5, "id_status" => 1,
				"id_usuario_captura" => 0, "id_usuario_valida" => 0,
				"id_usuario_actualiza" => 0, "cantidad_muestras" => 0,
				"costo_total" => 0, "cuerpo_receptor" => "",
				"tipo_cuerpo" => "", "fecha" => "",
				"fecha_captura" => "",
				"fecha_valida" => "", "fecha_actualiza" => "",
				"fecha_rechaza" => "", "ip_captura" => "",
				"ip_valida" => "", "ip_actualiza" => "",
				"host_captura" => "", "host_valida" => "",
				"host_actualiza" => "", "motivo_rechaza" => "",
				"comentarios" => "", "activo" => 1
			)
		)
	);
}

function getPlainStudy($studyId) {
	$sql = "SELECT id_estudio, id_cliente, id_origen_orden,
		id_ubicacion, id_ejercicio, id_status, id_etapa,
		id_usuario_captura, id_usuario_valida, id_usuario_entrega,
		id_usuario_actualiza, oficio, folio, origen_descripcion,
		ubicacion,
		CONVERT(nvarchar, fecha, 126) AS fecha,
		CONVERT(nvarchar, fecha_entrega, 126) AS fecha_entrega,
		CONVERT(nvarchar, fecha_captura, 126) AS fecha_captura,
		CONVERT(nvarchar, fecha_valida, 126) AS fecha_valida,
		CONVERT(nvarchar, fecha_actualiza, 126) AS fecha_actualiza,
		CONVERT(nvarchar, fecha_rechaza, 126) AS fecha_rechaza,
		ip_captura, ip_valida, ip_actualiza,
		host_captura, host_valida, host_actualiza, motivo_rechaza,
		activo
		FROM Estudio
		WHERE activo = 1 AND id_estudio = :studyId";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->bindParam("studyId", $studyId);
	$stmt->execute();
	$study = (array) $stmt->fetchAll(PDO::FETCH_OBJ)[0];
	$db = null;
	return (object) $study;
}

function getStudy($studyId) {
	$study = getPlainStudy($studyId);
	$study->cliente = getClient($study->id_cliente);
	$study->ordenes = getStudyOrders($studyId);
	return $study;
}

function getLastStudyByYear($yearId) {
	$sql = "SELECT TOP (1) id_estudio, id_cliente, id_origen_orden,
		id_ubicacion, id_ejercicio, id_status, id_etapa,
		id_usuario_captura, id_usuario_valida, id_usuario_entrega,
		id_usuario_actualiza, oficio, folio, origen_descripcion,
		ubicacion,
		CONVERT(nvarchar, fecha, 126) AS fecha,
		CONVERT(nvarchar, fecha_entrega, 126) AS fecha_entrega,
		CONVERT(nvarchar, fecha_captura, 126) AS fecha_captura,
		CONVERT(nvarchar, fecha_valida, 126) AS fecha_valida,
		CONVERT(nvarchar, fecha_actualiza, 126) AS fecha_actualiza,
		CONVERT(nvarchar, fecha_rechaza, 126) AS fecha_rechaza,
		ip_captura, ip_valida, ip_actualiza,
		host_captura, host_valida, host_actualiza, motivo_rechaza,
		activo
		FROM Estudio
		WHERE id_ejercicio = :yearId
		ORDER BY id_estudio DESC";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->bindParam("yearId", $yearId);
	$stmt->execute();
	$result = (array) $stmt->fetchAll(PDO::FETCH_OBJ)[0];
	$db = null;
	return (object) $result;
}

function insertStudy($insertData) {
	$sql = "INSERT INTO Estudio (id_cliente, id_origen_orden, id_ubicacion,
		id_ejercicio, id_status, id_etapa, id_usuario_captura,
		id_usuario_valida, id_usuario_entrega,
		id_usuario_actualiza, oficio, folio, origen_descripcion,
		ubicacion, fecha, fecha_entrega, fecha_captura,
		fecha_valida, fecha_actualiza, fecha_rechaza, ip_captura,
		ip_valida, ip_actualiza, host_captura, host_valida,
		host_actualiza, motivo_rechaza, activo)
		VALUES (:id_cliente, :id_origen_orden, :id_ubicacion,
		:id_ejercicio, :id_status, :id_etapa, :id_usuario_captura,
		:id_usuario_valida, :id_usuario_entrega,
		:id_usuario_actualiza, :oficio, :folio, :origen_descripcion,
		:ubicacion, :fecha, :fecha_entrega, :fecha_captura,
		:fecha_valida, :fecha_actualiza, :fecha_rechaza, :ip_captura, :ip_valida,
		:ip_actualiza, :host_captura, :host_valida, :host_actualiza,
		:motivo_rechaza, :activo)";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->execute($insertData);
	$studyId = $db->lastInsertId();
	$db = null;
	return $studyId;
}

function updateStudy($updateData) {
	$sql = "UPDATE Estudio SET id_cliente = :id_cliente,
		id_origen_orden = :id_origen_orden, id_ubicacion = :id_ubicacion,
		id_ejercicio = :id_ejercicio, id_status = :id_status,
		id_etapa = :id_etapa, id_usuario_valida = :id_usuario_valida,
		id_usuario_entrega = :id_usuario_entrega,
		id_usuario_actualiza = :id_usuario_actualiza, oficio = :oficio,
		folio = :folio, origen_descripcion = :origen_descripcion,
		ubicacion = :ubicacion, fecha = :fecha,
		fecha_entrega = :fecha_entrega,
		fecha_valida = :fecha_valida, fecha_actualiza = :fecha_actualiza,
		fecha_rechaza = :fecha_rechaza, ip_valida = :ip_valida,
		ip_actualiza = :ip_actualiza, host_valida = :host_valida,
		host_actualiza = :host_actualiza, motivo_rechaza = :motivo_rechaza,
		activo = :activo
		WHERE id_estudio = :id_estudio";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->execute($updateData);
	$db = null;
	return $updateData["id_estudio"];
}

function getOrders() {
	$sql = "SELECT id_orden, id_estudio, id_cliente, id_matriz,
		id_tipo_muestreo, id_norma, id_cuerpo_receptor, id_status,
		id_usuario_captura, id_usuario_valida, id_usuario_actualiza,
		cantidad_muestras, costo_total, cuerpo_receptor, tipo_cuerpo,
		CONVERT(nvarchar, fecha, 126) AS fecha,
		CONVERT(nvarchar, fecha_captura, 126) AS fecha_captura,
		CONVERT(nvarchar, fecha_valida, 126) AS fecha_valida,
		CONVERT(nvarchar, fecha_actualiza, 126) AS fecha_actualiza,
		CONVERT(nvarchar, fecha_rechaza, 126) AS fecha_rechaza,
		ip_captura, ip_valida,
		ip_actualiza, host_captura, host_valida, host_actualiza,
		motivo_rechaza, comentarios, activo
		FROM Orden
		WHERE activo = 1";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->execute();
	$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$db = null;
	$i = 0;
	$l = count($orders);
	if ($l > 0)
	{
		for ($i = 0; $i < $l; $i++) {
			$orders[$i]["cliente"] = getClient($orders[$i]['id_cliente']);
			$orders[$i]["estudio"] = getPlainStudy($orders[$i]['id_estudio']);
			$orders[$i]["planes"] = getPlansByOrder($orders[$i]['id_orden']);
		}
	}
	return $orders;
}

function getOrdersByStudy($studyId) {
	$sql = "SELECT id_orden, id_estudio, id_cliente, id_matriz,
		id_tipo_muestreo, id_norma, id_cuerpo_receptor, id_status,
		id_usuario_captura, id_usuario_valida, id_usuario_actualiza,
		cantidad_muestras, costo_total, cuerpo_receptor, tipo_cuerpo,
		CONVERT(nvarchar, fecha, 126) AS fecha,
		CONVERT(nvarchar, fecha_captura, 126) AS fecha_captura,
		CONVERT(nvarchar, fecha_valida, 126) AS fecha_valida,
		CONVERT(nvarchar, fecha_actualiza, 126) AS fecha_actualiza,
		CONVERT(nvarchar, fecha_rechaza, 126) AS fecha_rechaza,
		ip_captura, ip_valida,
		ip_actualiza, host_captura, host_valida, host_actualiza,
		motivo_rechaza, comentarios, activo
		FROM Orden
		WHERE activo = 1 AND id_estudio = :studyId";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->bindParam("studyId", $studyId);
	$stmt->execute();
	$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$db = null;
	// $i = 0;
	// $l = count($orders);
	// for ($i = 0; $i < $l; $i++) {
	// 	$orders[$i]["cliente"] = getClient($orders[$i]['id_cliente']);
	// 	$orders[$i]["estudio"] = getPlainStudy($orders[$i]['id_estudio']);
	// 	$orders[$i]["planes"] = getPlansByOrder($orders[$i]['id_orden']);
	// }
	return $orders;
}

function getPlainOrder($orderId) {
	$sql = "SELECT id_orden, id_estudio, id_cliente, id_matriz,
		id_tipo_muestreo, id_norma, id_cuerpo_receptor, id_status,
		id_usuario_captura, id_usuario_valida, id_usuario_actualiza,
		cantidad_muestras, costo_total, cuerpo_receptor, tipo_cuerpo,
		CONVERT(nvarchar, fecha, 126) AS fecha,
		CONVERT(nvarchar, fecha_captura, 126) AS fecha_captura,
		CONVERT(nvarchar, fecha_valida, 126) AS fecha_valida,
		CONVERT(nvarchar, fecha_actualiza, 126) AS fecha_actualiza,
		CONVERT(nvarchar, fecha_rechaza, 126) AS fecha_rechaza,
		ip_captura, ip_valida,
		ip_actualiza, host_captura, host_valida, host_actualiza,
		motivo_rechaza, comentarios, activo
		FROM Orden
		WHERE activo = 1 AND id_orden = :orderId";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->bindParam("orderId", $orderId);
	$stmt->execute();
	$order = (array) $stmt->fetchAll(PDO::FETCH_OBJ)[0];
	$db = null;
	return (object) $order;
}

function getOrder($orderId) {
	$order = getPlainOrder($orderId);
	$order->cliente = getClient($order->id_cliente);
	$order->estudio = getPlainStudy($order->id_estudio);
	$order->planes = array((object) getBlankPlan());
	if (count(getPlansByOrder($orderId)) > 0)
	{
		$order->planes = getPlansByOrder($orderId);
	}
	return $order;
}

function getStudyOrders($studyId) {
	$sql = "SELECT id_orden, id_estudio, id_cliente, id_matriz,
		id_tipo_muestreo, id_norma, id_cuerpo_receptor, id_status,
		id_usuario_captura, id_usuario_valida, id_usuario_actualiza,
		cantidad_muestras, costo_total, cuerpo_receptor, tipo_cuerpo,
		CONVERT(nvarchar, fecha, 126) AS fecha,
		CONVERT(nvarchar, fecha_captura, 126) AS fecha_captura,
		CONVERT(nvarchar, fecha_valida, 126) AS fecha_valida,
		CONVERT(nvarchar, fecha_actualiza, 126) AS fecha_actualiza,
		CONVERT(nvarchar, fecha_rechaza, 126) AS fecha_rechaza,
		ip_captura, ip_valida, ip_actualiza, host_captura,
		host_valida, host_actualiza, motivo_rechaza,
		comentarios, activo
		FROM Orden
		WHERE activo = 1 AND id_estudio = :studyId";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->bindParam("studyId", $studyId);
	$stmt->execute();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$db = null;
	return $result;
}

function insertOrder($orderData) {
	$sql = "INSERT INTO Orden (id_estudio, id_cliente, id_matriz,
		id_tipo_muestreo, id_norma, id_cuerpo_receptor,
		id_status, id_usuario_captura, id_usuario_valida,
		id_usuario_actualiza, cantidad_muestras, costo_total,
		cuerpo_receptor, tipo_cuerpo, fecha, fecha_captura,
		fecha_valida, fecha_actualiza, fecha_rechaza, ip_captura,
		ip_valida, ip_actualiza, host_captura, host_valida,
		host_actualiza, motivo_rechaza, comentarios, activo)
		VALUES (:id_estudio, :id_cliente, :id_matriz,
		:id_tipo_muestreo, :id_norma, :id_cuerpo_receptor,
		:id_status, :id_usuario_captura, :id_usuario_valida,
		:id_usuario_actualiza, :cantidad_muestras, :costo_total,
		:cuerpo_receptor, :tipo_cuerpo, :fecha, :fecha_captura,
		:fecha_valida, :fecha_actualiza, :fecha_rechaza, :ip_captura,
		:ip_valida, :ip_actualiza, :host_captura, :host_valida,
		:host_actualiza, :motivo_rechaza, :comentarios, :activo)";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->execute($orderData);
	$orderId = $db->lastInsertId();
	$db = null;
	return $orderId;
}

function updateOrder($updateData) {
	$sql = "UPDATE Orden SET
		id_estudio = :id_estudio, id_cliente = :id_cliente,
		id_matriz = :id_matriz, id_tipo_muestreo = :id_tipo_muestreo,
		id_norma = :id_norma, id_cuerpo_receptor = :id_cuerpo_receptor,
		id_status = :id_status, id_usuario_valida = :id_usuario_valida,
		id_usuario_actualiza = :id_usuario_actualiza,
		cantidad_muestras = :cantidad_muestras, costo_total = :costo_total,
		cuerpo_receptor = :cuerpo_receptor, tipo_cuerpo = :tipo_cuerpo,
		fecha = :fecha,
		fecha_valida = :fecha_valida,
		fecha_actualiza = :fecha_actualiza,
		fecha_rechaza = :fecha_rechaza,
		ip_valida = :ip_valida,
		ip_actualiza = :ip_actualiza,
		host_valida = :host_valida, host_actualiza = :host_actualiza,
		motivo_rechaza = :motivo_rechaza, comentarios = :comentarios,
		activo = :activo
		WHERE id_orden = :id_orden";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->execute($updateData);
	$db = null;
	return $updateData["id_orden"];
}

function getOrderSources() {
	$sql = "SELECT id_origen_orden, origen_orden, activo
		FROM OrigenOrden
		WHERE activo = 1";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->execute();
	$orderSources = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$db = null;
	return $orderSources;
}

function getPlans() {
	$sql = "SELECT id_plan, id_estudio, id_orden, id_ubicacion,
		id_paquete, id_objetivo_plan, id_norma_muestreo,
		id_estado, id_municipio, id_localidad,
		id_supervisor_muestreo, id_supervisor_entrega,
		id_supervisor_recoleccion, id_supervisor_registro,
		id_ayudante_entrega, id_ayudante_recoleccion,
		id_ayudante_registro, id_responsable_calibracion,
		id_responsable_recipientes, id_responsable_reactivos,
		id_responsable_material, id_responsable_hieleras, id_status,
		id_usuario_captura, id_usuario_valida, id_usuario_actualiza,
		CONVERT(nvarchar, fecha, 126) AS fecha,
		CONVERT(nvarchar, fecha_probable, 126) AS fecha_probable,
		CONVERT(nvarchar, fecha_probable, 126) AS fecha_probable,
		CONVERT(nvarchar, fecha_calibracion, 126) AS fecha_calibracion,
		CONVERT(nvarchar, fecha_captura, 126) AS fecha_captura,
		CONVERT(nvarchar, fecha_valida, 126) AS fecha_valida,
		CONVERT(nvarchar, fecha_actualiza, 126) AS fecha_actualiza,
		CONVERT(nvarchar, fecha_rechaza, 126) AS fecha_rechaza,
		ip_captura,
		ip_valida, ip_actualiza, host_captura, host_valida,
		host_actualiza, calle, numero, colonia, codigo_postal,
		telefono, contacto, email, comentarios_ubicacion,
		cantidad_puntos, cantidad_equipos, cantidad_recipientes,
		cantidad_reactivos, cantidad_hieleras, frecuencia,
		objetivo_otro, motivo_rechaza, comentarios, activo
		FROM [Plan]
		WHERE activo = 1";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->execute();
	$plans = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$db = null;
	// $i = 0;
	// $l = count($plans);
	// for ($i = 0; $i < $l; $i++) {
	// 	$plans[$i]["cliente"] = getClient($clientId);
	// 	$plans[$i]["orden"] = getPlainOrder($orderId);
	// 	$plans[$i]["supervisor_muestreo"] = getSamplingSupervisor($supervisorId);
	// 	$plans[$i]["puntos"] = getPointsByPackage($packageId);
	// 	$plans[$i]["equipos"] = getEquipmentByPlan($planId);
	// 	$plans[$i]["recipientes"] = getContainersByPlan($planId);
	// 	$plans[$i]["reactivos"] = getReactivesByPlan($planId);
	// 	$plans[$i]["materiales"] = getMaterialsByPlan($planId);
	// 	$plans[$i]["hieleras"] = getCoolersByPlan($planId);
	// }
	return $plans;
}

function getBlankPlan() {
	return array(
		"id_plan" => 1, "id_estudio" => 1,
		"id_orden" => 1, "id_ubicacion" => 1,
		"id_paquete" => 1, "id_objetivo_plan" => 1,
		"id_norma_muestreo" => 1, "id_estado" => 14,
		"id_municipio" => 1, "id_localidad" => 1,
		"id_supervisor_muestreo" => 0,
		"id_supervisor_entrega" => 0, "id_supervisor_recoleccion" => 0,
		"id_supervisor_registro" => 0, "id_ayudante_entrega" => 0,
		"id_ayudante_recoleccion" => 0, "id_ayudante_registro" => 0,
		"id_responsable_calibracion" => 0,
		"id_responsable_recipientes" => 0,
		"id_responsable_reactivos" => 0, "id_responsable_material" => 0,
		"id_responsable_hieleras" => 0, "id_status" => 1,
		"id_usuario_captura" => 0, "id_usuario_valida" => 0,
		"id_usuario_actualiza" => 0, "fecha" => "",
		"fecha_probable" => "", "fecha_calibracion" => "",
		"fecha_captura" => "", "fecha_valida" => "",
		"fecha_actualiza" => "", "fecha_rechaza" => "",
		"ip_captura" => "", "ip_valida" => "",
		"ip_actualiza" => "", "host_captura" => "",
		"host_valida" => "", "host_actualiza" => "",
		"calle" => "", "numero" => "",
		"colonia" => "", "codigo_postal" => "",
		"telefono" => "", "contacto" => "",
		"email" => "", "comentarios_ubicacion" => "",
		"cantidad_puntos" => 0, "cantidad_equipos" => 0,
		"cantidad_recipientes" => 0, "cantidad_reactivos" => 0,
		"cantidad_hieleras" => 0, "frecuencia" => 0,
		"objetivo_otro" => "", "motivo_rechaza" => "",
		"comentarios" => "", "activo" => 1
	);
}

function getPlansByOrder($orderId) {
	$sql = "SELECT id_plan, id_estudio, id_orden, id_ubicacion,
		id_paquete, id_objetivo_plan, id_norma_muestreo,
		id_estado, id_municipio, id_localidad,
		id_supervisor_muestreo, id_supervisor_entrega,
		id_supervisor_recoleccion, id_supervisor_registro,
		id_ayudante_entrega, id_ayudante_recoleccion,
		id_ayudante_registro, id_responsable_calibracion,
		id_responsable_recipientes, id_responsable_reactivos,
		id_responsable_material, id_responsable_hieleras, id_status,
		id_usuario_captura, id_usuario_valida, id_usuario_actualiza,
		CONVERT(nvarchar, fecha, 126) AS fecha,
		CONVERT(nvarchar, fecha_probable, 126) AS fecha_probable,
		CONVERT(nvarchar, fecha_probable, 126) AS fecha_probable,
		CONVERT(nvarchar, fecha_calibracion, 126) AS fecha_calibracion,
		CONVERT(nvarchar, fecha_captura, 126) AS fecha_captura,
		CONVERT(nvarchar, fecha_valida, 126) AS fecha_valida,
		CONVERT(nvarchar, fecha_actualiza, 126) AS fecha_actualiza,
		CONVERT(nvarchar, fecha_rechaza, 126) AS fecha_rechaza,
		ip_captura,
		ip_valida, ip_actualiza, host_captura, host_valida,
		host_actualiza, calle, numero, colonia, codigo_postal,
		telefono, contacto, email, comentarios_ubicacion,
		cantidad_puntos, cantidad_equipos, cantidad_recipientes,
		cantidad_reactivos, cantidad_hieleras, frecuencia,
		objetivo_otro, motivo_rechaza, comentarios, activo
		FROM [Plan]
		WHERE activo = 1 AND id_orden = :orderId";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->bindParam("orderId", $orderId);
	$stmt->execute();
	$plans = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $plans;
}

function getPlainPlan($planId) {
	//TODO: agregar id_estado, id_municipio, id_localidad
	$sql = "SELECT id_plan, id_estudio, id_orden, id_ubicacion,
		id_paquete, id_objetivo_plan, id_norma_muestreo,
		id_estado, id_municipio, id_localidad,
		id_supervisor_muestreo, id_supervisor_entrega,
		id_supervisor_recoleccion, id_supervisor_registro,
		id_ayudante_entrega, id_ayudante_recoleccion,
		id_ayudante_registro, id_responsable_calibracion,
		id_responsable_recipientes, id_responsable_reactivos,
		id_responsable_material, id_responsable_hieleras, id_status,
		id_usuario_captura, id_usuario_valida, id_usuario_actualiza,
		CONVERT(nvarchar, fecha, 126) AS fecha,
		CONVERT(nvarchar, fecha_probable, 126) AS fecha_probable,
		CONVERT(nvarchar, fecha_probable, 126) AS fecha_probable,
		CONVERT(nvarchar, fecha_calibracion, 126) AS fecha_calibracion,
		CONVERT(nvarchar, fecha_captura, 126) AS fecha_captura,
		CONVERT(nvarchar, fecha_valida, 126) AS fecha_valida,
		CONVERT(nvarchar, fecha_actualiza, 126) AS fecha_actualiza,
		CONVERT(nvarchar, fecha_rechaza, 126) AS fecha_rechaza,
		ip_captura,
		ip_valida, ip_actualiza, host_captura, host_valida,
		host_actualiza, calle, numero, colonia, codigo_postal,
		telefono, contacto, email, comentarios_ubicacion,
		cantidad_puntos, cantidad_equipos, cantidad_recipientes,
		cantidad_reactivos, cantidad_hieleras, frecuencia,
		objetivo_otro, motivo_rechaza, comentarios, activo
		FROM [Plan]
		WHERE activo = 1 AND id_plan = :planId";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->bindParam("planId", $planId);
	$stmt->execute();
	$plan = (array) $stmt->fetchAll(PDO::FETCH_OBJ)[0];
	return (object) $plan;
}

function getPlan($planId) {
	$plan = getPlainPlan($planId);
	$study = getPlainStudy($plan->id_estudio);
	$plan->cliente = getClient($study->id_cliente);
	$plan->orden = getPlainOrder($plan->id_orden);
	$plan->tipo_muestreo = getSamplingType($plan->orden->id_tipo_muestreo)->tipo_muestreo;
	$plan->supervisor_muestreo = getSamplingEmployee($plan->id_supervisor_muestreo);
	$plan->puntos = getPointsByPackage($plan->id_paquete);
	$plan->instrumentos = getInstrumentsByPlan($planId);
	$plan->recipientes = getContainersByPlan($planId);
	$plan->reactivos = getReactivesByPlan($planId);
	$plan->materiales = getMaterialsByPlan($planId);
	$plan->hieleras = getCoolersByPlan($planId);
	return $plan;
}

function getPlanObjectives() {
	$sql = "SELECT id_objetivo_plan, objetivo_plan, activo
		FROM ObjetivoPlan
		WHERE activo = 1";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->execute();
	$planObjectives = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$db = null;
	return $planObjectives;
}

function insertPlan($planData) {
	$sql = "INSERT INTO [Plan] (id_estudio, id_orden, id_ubicacion,
		id_paquete, id_objetivo_plan, id_norma_muestreo, id_estado,
		id_municipio, id_localidad, id_supervisor_muestreo,
		id_supervisor_entrega, id_supervisor_recoleccion,
		id_supervisor_registro, id_ayudante_entrega,
		id_ayudante_recoleccion, id_ayudante_registro,
		id_responsable_calibracion, id_responsable_recipientes,
		id_responsable_reactivos, id_responsable_material,
		id_responsable_hieleras, id_status, id_usuario_captura,
		id_usuario_valida, id_usuario_actualiza, fecha,
		fecha_probable, fecha_calibracion, fecha_captura,
		fecha_valida, fecha_actualiza, fecha_rechaza, ip_captura,
		ip_valida, ip_actualiza, host_captura, host_valida,
		host_actualiza, calle, numero, colonia, codigo_postal,
		telefono, contacto, email, comentarios_ubicacion,
		cantidad_puntos, cantidad_equipos, cantidad_recipientes,
		cantidad_reactivos, cantidad_hieleras, frecuencia,
		objetivo_otro, motivo_rechaza, comentarios, activo)
		VALUES (:id_estudio, :id_orden, :id_ubicacion,
		:id_paquete, :id_objetivo_plan, :id_norma_muestreo, :id_estado,
		:id_municipio, :id_localidad, :id_supervisor_muestreo,
		:id_supervisor_entrega, :id_supervisor_recoleccion,
		:id_supervisor_registro, :id_ayudante_entrega,
		:id_ayudante_recoleccion, :id_ayudante_registro,
		:id_responsable_calibracion, :id_responsable_recipientes,
		:id_responsable_reactivos, :id_responsable_material,
		:id_responsable_hieleras, :id_status, :id_usuario_captura,
		:id_usuario_valida, :id_usuario_actualiza, :fecha,
		:fecha_probable, :fecha_calibracion, :fecha_captura,
		:fecha_valida, :fecha_actualiza, :fecha_rechaza, :ip_captura,
		:ip_valida, :ip_actualiza, :host_captura, :host_valida,
		:host_actualiza, :calle, :numero, :colonia, :codigo_postal,
		:telefono, :contacto, :email, :comentarios_ubicacion,
		:cantidad_puntos, :cantidad_equipos, :cantidad_recipientes,
		:cantidad_reactivos, :cantidad_hieleras, :frecuencia,
		:objetivo_otro, :motivo_rechaza, :comentarios, :activo)";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->execute($planData);
	$planId = $db->lastInsertId();
	$db = null;
	return $planId;
}

function updatePlan($updateData) {
	$sql = "UPDATE [Plan] SET
		id_estudio = :id_estudio, id_orden = :id_orden,
		id_ubicacion = :id_ubicacion, id_paquete = :id_paquete,
		id_objetivo_plan = :id_objetivo_plan,
		id_norma_muestreo = :id_norma_muestreo, id_estado = :id_estado,
		id_municipio = :id_municipio, id_localidad = :id_localidad,
		id_supervisor_muestreo = :id_supervisor_muestreo,
		id_supervisor_entrega = :id_supervisor_entrega,
		id_supervisor_recoleccion = :id_supervisor_recoleccion,
		id_supervisor_registro = :id_supervisor_registro,
		id_ayudante_entrega = :id_ayudante_entrega,
		id_ayudante_recoleccion = :id_ayudante_recoleccion,
		id_ayudante_registro = :id_ayudante_registro,
		id_responsable_calibracion = :id_responsable_calibracion,
		id_responsable_recipientes = :id_responsable_recipientes,
		id_responsable_reactivos = :id_responsable_reactivos,
		id_responsable_material = :id_responsable_material,
		id_responsable_hieleras = :id_responsable_hieleras,
		id_status = :id_status, id_usuario_valida = :id_usuario_valida,
		id_usuario_actualiza = :id_usuario_actualiza, fecha = :fecha,
		fecha_probable = :fecha_probable,
		fecha_calibracion = :fecha_calibracion,
		fecha_valida = :fecha_valida, fecha_actualiza = :fecha_actualiza,
		fecha_rechaza = :fecha_rechaza, ip_valida = :ip_valida,
		ip_actualiza = :ip_actualiza, host_valida = :host_valida,
		host_actualiza = :host_actualiza, calle = :calle,
		numero = :numero, colonia = :colonia,
		codigo_postal = :codigo_postal, telefono = :telefono,
		contacto = :contacto, email = :email,
		comentarios_ubicacion = :comentarios_ubicacion,
		cantidad_puntos = :cantidad_puntos,
		cantidad_equipos = :cantidad_equipos,
		cantidad_recipientes = :cantidad_recipientes,
		cantidad_reactivos = :cantidad_reactivos,
		cantidad_hieleras = :cantidad_hieleras, frecuencia = :frecuencia,
		objetivo_otro = :objetivo_otro, motivo_rechaza = :motivo_rechaza,
		comentarios = :comentarios, activo = :activo
		WHERE id_plan = :id_plan";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->execute($updateData);
	$db = null;
	return $updateData["id_plan"];
}

function getSamplingEmployees() {
	$sql = "SELECT id_usuario, id_nivel, id_rol, id_area, id_puesto,
		interno, cea, laboratorio, supervisa, analiza, muestrea,
		nombres, apellido_paterno, apellido_materno,
		CONVERT(nvarchar, fecha_captura, 126) AS fecha_captura,
		CONVERT(nvarchar, fecha_actualiza, 126) AS fecha_actualiza,
		ip_captura, ip_actualiza,
		host_captura, host_actualiza, activo
		FROM Usuario
		WHERE activo = 1 AND id_area = 4";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->execute();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$db = null;
	return $result;
}

function getSheet() {
	$json = '
		{
			"id_hoja":1,
			"id_estudio":1,
			"id_cliente":1,
			"id_solicitud":1,
			"id_orden":1,
			"id_plan":1,
			"id_paquete_puntos":1,
			"id_norma_muestreo":2,
			"id_nubes":1,
			"id_direccion_corriente":1,
			"id_oleaje":1,
			"id_status":1,
			"fecha_muestreo":"2015-03-24T08:12-06:00",
			"fecha_entrega":"2015-03-24T11:47-06:00",
			"fecha_captura":"2015-03-23T08:25-06:00",
			"ip_captura":"[::1]",
			"host_captura":"localhost",
			"fecha_valida":"2015-03-23T08:25-06:00",
			"ip_valida":"[::1]",
			"host_valida":"localhost",
			"fecha_actualiza":"2015-03-23T08:25-06:00",
			"ip_actualiza":"[::1]",
			"host_actualiza":"localhost",
			"fecha_rechaza":"",
			"nubes_otro":"",
			"comentarios":"",
			"motivo_rechaza":"",
			"activo":1,
			"plan":
			{
				"id_plan":1,
				"id_estudio":1,
				"id_cliente":13,
				"id_solicitud":1,
				"id_orden":1,
				"id_matriz":1,
				"id_tipo_muestreo":2,
				"id_norma":1,
				"id_cuerpo_receptor":1,
				"id_tipo_cuerpo":3,
				"id_paquete_puntos":1,
				"id_supervisor_muestreo":3,
				"id_objetivo_plan":2,
				"id_supervisor_entrega":13,
				"id_ayudante_entrega":13,
				"id_supervisor_recoleccion":13,
				"id_ayudante_recoleccion":13,
				"id_supervisor_registro":13,
				"id_ayudante_registro":13,
				"id_responsable_calibracion":13,
				"id_responsable_recipientes":13,
				"id_responsable_reactivos":13,
				"id_responsable_material":13,
				"id_responsable_hieleras":13,
				"id_estado":14,
				"id_municipio":14039,
				"id_localidad":140390001,
				"id_ejercicio":2015,
				"id_status":1,
				"numero_oficio":437,
				"folio":"CEA-437/2014",
				"fecha_probable":"2015-03-23T08:25-06:00",
				"fecha_plan":"2015-03-23",
				"fecha_calibracion":"2015-03-23T08:25-06:00",
				"fecha_captura":"2015-03-23T08:25-06:00",
				"ip_captura":"[::1]",
				"host_captura":"localhost",
				"fecha_valida":"2015-03-23T08:25-06:00",
				"ip_valida":"[::1]",
				"host_valida":"localhost",
				"fecha_actualiza":"2015-03-23T08:25-06:00",
				"ip_actualiza":"[::1]",
				"host_actualiza":"localhost",
				"objetivo_otro":"esto es una prueba",
				"calle":"Av. Brasilia",
				"numero":"2970",
				"colonia":"Col. Colomos Providencia",
				"frecuencia_muestreo":2,
				"matriz":"Agua residual",
				"municipio":"Guadalajara",
				"localidad":"Guadalajara",
				"asistente_muestreo":"",
				"asistente_recoleccion":"",
				"asistente_registro":"",
				"tipo_muestreo":"Compuesto",
				"fecha_rechaza":"",
				"motivo_rechaza":"",
				"activo":1,
				"cliente":
				{
					"id_cliente":13,
					"id_organismo":6,
					"cliente":"Ayuntamiento de Cotija, Michoacan",
					"area":"",
					"rfc":"Registro Federal de Contribuyentes",
					"calle":"Pino Suárez Pte.",
					"numero":"100",
					"colonia":"Col. Centro",
					"cp":"59940",
					"id_estado":16,
					"estado":"Michoacán de Ocampo",
					"id_municipio":16019,
					"municipio":"Cotija",
					"id_localidad":160190001,
					"localidad":"Cotija de La Paz",
					"tel":"045-35-4100-1836",
					"fax":"",
					"contacto":"Arq. Juan Jesús Zarate Barajas",
					"puesto_contacto":"puesto contacto",
					"email":"ooapascotija@hotmail.com",
					"fecha_act":"23/11/2014",
					"interno":0,
					"cea":0,
					"tasa":1,
					"activo":1
				},
				"solicitud":
				{
					"id_solicitud":1,
					"id_estudio":1,
					"id_cliente":13,
					"id_matriz":1,
					"id_tipo_muestreo":2,
					"id_norma":1,
					"id_cuerpo_receptor":1,
					"id_tipo_cuerpo":3,
					"id_ejercicio":2015,
					"id_status":2,
					"id_usuario_captura":20,
					"id_usuario_valida":1,
					"id_usuario_actualiza":1,
					"numero_oficio":432,
					"folio":"CEA-432/2015",
					"matriz":"Agua residual",
					"cantidad_muestras":15,
					"tipo_muestreo":"Compuesto",
					"costo_total":35850,
					"cuerpo_receptor":"Río Santiago",
					"tipo_cuerpo":"C",
					"status":"Validado",
					"fecha":"2015-03-21",
					"fecha_captura":"2015-03-21",
					"ip_captura":"[::1]",
					"host_captura":"localhost",
					"fecha_valida":"2015-03-21",
					"ip_valida":"[::1]",
					"host_valida":"localhost",
					"fecha_actualiza":"2015-03-21",
					"ip_actualiza":"[::1]",
					"host_actualiza":"localhost",
					"fecha_acepta":"2015-03-21",
					"fecha_rechaza":"",
					"motivo_rechaza":"",
					"activo":1
				},
				"supervisor_muestreo":
				{
					"id_empleado":3,
					"id_nivel":3,
					"id_area":2,
					"area":"Metales Pesados",
					"id_puesto":4,
					"usr":"mgomar",
					"pwd":"mgomar",
					"puesto":"Supervisor (MP)",
					"nombres":"Marín",
					"apellido_paterno":"Gomar",
					"apellido_materno":"Sosa",
					"fecha_act":"2014-11-30",
					"calidad":0,
					"supervisa":1,
					"analiza":1,
					"muestrea":1,
					"cert":1,
					"activo":1
				}
			}
		}
	';
	return json_decode($json);
}

function getSheets() {
	$json = '
		[
			{
				"id_hoja":1,
				"id_estudio":1,
				"id_cliente":1,
				"id_solicitud":1,
				"id_orden":1,
				"id_plan":1,
				"id_paquete_puntos":1,
				"id_norma_muestreo":2,
				"id_nubes":1,
				"id_direccion_corriente":1,
				"id_oleaje":1,
				"id_status":1,
				"fecha_muestreo":"2015-03-24T08:12-06:00",
				"fecha_entrega":"2015-03-24T11:47-06:00",
				"fecha_captura":"2015-03-23T08:25-06:00",
				"ip_captura":"[::1]",
				"host_captura":"localhost",
				"fecha_valida":"2015-03-23T08:25-06:00",
				"ip_valida":"[::1]",
				"host_valida":"localhost",
				"fecha_actualiza":"2015-03-23T08:25-06:00",
				"ip_actualiza":"[::1]",
				"host_actualiza":"localhost",
				"fecha_rechaza":"",
				"nubes_otro":"",
				"comentarios":"",
				"motivo_rechaza":"",
				"activo":1,
				"plan":
				{
					"id_plan":1,
					"id_estudio":1,
					"id_cliente":13,
					"id_solicitud":1,
					"id_orden":1,
					"id_matriz":1,
					"id_tipo_muestreo":2,
					"id_norma":1,
					"id_cuerpo_receptor":1,
					"id_tipo_cuerpo":3,
					"id_paquete_puntos":1,
					"id_supervisor_muestreo":3,
					"id_objetivo_plan":2,
					"id_supervisor_entrega":13,
					"id_ayudante_entrega":13,
					"id_supervisor_recoleccion":13,
					"id_ayudante_recoleccion":13,
					"id_supervisor_registro":13,
					"id_ayudante_registro":13,
					"id_responsable_calibracion":13,
					"id_responsable_recipientes":13,
					"id_responsable_reactivos":13,
					"id_responsable_material":13,
					"id_responsable_hieleras":13,
					"id_estado":14,
					"id_municipio":14039,
					"id_localidad":140390001,
					"id_ejercicio":2015,
					"id_status":1,
					"numero_oficio":437,
					"folio":"CEA-437/2014",
					"fecha_probable":"2015-03-23T08:25-06:00",
					"fecha_plan":"2015-03-23",
					"fecha_calibracion":"2015-03-23T08:25-06:00",
					"fecha_captura":"2015-03-23T08:25-06:00",
					"ip_captura":"[::1]",
					"host_captura":"localhost",
					"fecha_valida":"2015-03-23T08:25-06:00",
					"ip_valida":"[::1]",
					"host_valida":"localhost",
					"fecha_actualiza":"2015-03-23T08:25-06:00",
					"ip_actualiza":"[::1]",
					"host_actualiza":"localhost",
					"objetivo_otro":"esto es una prueba",
					"calle":"Av. Brasilia",
					"numero":"2970",
					"colonia":"Col. Colomos Providencia",
					"frecuencia_muestreo":2,
					"matriz":"Agua residual",
					"municipio":"Guadalajara",
					"localidad":"Guadalajara",
					"asistente_muestreo":"",
					"asistente_recoleccion":"",
					"asistente_registro":"",
					"tipo_muestreo":"Compuesto",
					"fecha_rechaza":"",
					"motivo_rechaza":"",
					"activo":1,
					"cliente":
					{
						"id_cliente":13,
						"id_organismo":6,
						"cliente":"Ayuntamiento de Cotija, Michoacan",
						"area":"",
						"rfc":"Registro Federal de Contribuyentes",
						"calle":"Pino Suárez Pte.",
						"numero":"100",
						"colonia":"Col. Centro",
						"cp":"59940",
						"id_estado":16,
						"estado":"Michoacán de Ocampo",
						"id_municipio":16019,
						"municipio":"Cotija",
						"id_localidad":160190001,
						"localidad":"Cotija de La Paz",
						"tel":"045-35-4100-1836",
						"fax":"",
						"contacto":"Arq. Juan Jesús Zarate Barajas",
						"puesto_contacto":"puesto contacto",
						"email":"ooapascotija@hotmail.com",
						"fecha_act":"23/11/2014",
						"interno":0,
						"cea":0,
						"tasa":1,
						"activo":1
					},
					"solicitud":
					{
						"id_solicitud":1,
						"id_estudio":1,
						"id_cliente":13,
						"id_matriz":1,
						"id_tipo_muestreo":2,
						"id_norma":1,
						"id_cuerpo_receptor":1,
						"id_tipo_cuerpo":3,
						"id_ejercicio":2015,
						"id_status":2,
						"id_usuario_captura":20,
						"id_usuario_valida":1,
						"id_usuario_actualiza":1,
						"numero_oficio":432,
						"folio":"CEA-432/2015",
						"matriz":"Agua residual",
						"cantidad_muestras":15,
						"tipo_muestreo":"Compuesto",
						"costo_total":35850,
						"cuerpo_receptor":"Río Santiago",
						"tipo_cuerpo":"C",
						"status":"Validado",
						"fecha":"2015-03-21",
						"fecha_captura":"2015-03-21",
						"ip_captura":"[::1]",
						"host_captura":"localhost",
						"fecha_valida":"2015-03-21",
						"ip_valida":"[::1]",
						"host_valida":"localhost",
						"fecha_actualiza":"2015-03-21",
						"ip_actualiza":"[::1]",
						"host_actualiza":"localhost",
						"fecha_acepta":"2015-03-21",
						"fecha_rechaza":"",
						"motivo_rechaza":"",
						"activo":1
					},
					"supervisor_muestreo":
					{
						"id_empleado":3,
						"id_nivel":3,
						"id_area":2,
						"area":"Metales Pesados",
						"id_puesto":4,
						"usr":"mgomar",
						"pwd":"mgomar",
						"puesto":"Supervisor (MP)",
						"nombres":"Marín",
						"apellido_paterno":"Gomar",
						"apellido_materno":"Sosa",
						"fecha_act":"2014-11-30",
						"calidad":0,
						"supervisa":1,
						"analiza":1,
						"muestrea":1,
						"cert":1,
						"activo":1
					}
				}
			}
		]
	';
	return json_decode($json);
}

function insertSheet($sheetData) {
	return $sheetData;
}

function updateSheet($updateData) {
	return $updateData;
}

function getReception($receptionId) {
	$json = '
			{
				"id_recepcion":1,
				"id_hoja":1,
				"id_recepcionista":13,
				"id_verificador":13,
				"id_muestra_validacion":1,
				"id_status":1,
				"fecha_recibe":"2015-03-24T13:05-06:00",
				"fecha_verifica":"2015-03-23T13:06-06:00",
				"fecha_captura":"2015-03-23T14:25-06:00",
				"ip_captura":"[::1]",
				"host_captura":"localhost",
				"fecha_valida":"2015-03-23T14:25-06:00",
				"ip_valida":"[::1]",
				"host_valida":"localhost",
				"fecha_actualiza":"2015-03-23T14:25-06:00",
				"ip_actualiza":"[::1]",
				"host_actualiza":"localhost",
				"fecha_rechaza":"",
				"comentarios":"Sin observaciones",
				"motivo_rechaza":"",
				"activo":1,
				"plan":
				{
					"id_plan":1,
					"folio":"CEA-437/2014",
					"fecha_plan":"2015-03-23T09:12-06:00"
				},
				"hoja":
				{
					"id_hoja":1,
					"fecha_muestreo":"2015-03-24T08:12-06:00",
					"fecha_recibe":"2015-03-24T13:05-06:00"
				},
				"muestras":
				[
					{
						"id_muestra_validacion":1,
						"id_muestra":1,
						"id_estudio":1,
						"id_cliente":1,
						"id_solicitud":1,
						"id_orden":1,
						"id_plan":1,
						"id_hoja":1,
						"id_recepcion":1,
						"id_custodia":0,
						"id_paquete_puntos":1,
						"id_punto":1,
						"id_status":1,
						"id_ejercicio":2015,
						"id_municipio":14063,
						"id_localidad":140630001,
						"folio":"0419/2015",
						"punto":"Ocotlán",
						"descripcion":"Ocotlán",
						"lat":20.346928,
						"lng":-102.779392,
						"alt":0,
						"municipio":"municipio 14063",
						"localidad":"localidad 140630001",
						"fecha_muestreo":"2015-03-23T09:00-06:00",
						"selected":true,
						"comentarios_muestreo":""
					},
					{
						"id_muestra_validacion":2,
						"id_muestra":2,
						"id_estudio":1,
						"id_cliente":1,
						"id_solicitud":1,
						"id_orden":1,
						"id_plan":1,
						"id_hoja":1,
						"id_recepcion":1,
						"id_recepcion":0,
						"id_custodia":0,
						"id_paquete_puntos":1,
						"id_punto":2,
						"id_status":1,
						"id_ejercicio":2015,
						"id_municipio":14030,
						"id_localidad":140300038,
						"folio":"0420/2015",
						"punto":"Presa Corona",
						"descripcion":"Cortina Presa Corona - Poncitlán",
						"lat":20.399667,
						"lng":-103.090619,
						"alt":0,
						"municipio":"municipio 14030",
						"localidad":"localidad 140300038",
						"fecha_muestreo":"2015-03-23T10:40-06:00",
						"selected":true,
						"comentarios_muestreo":""
					},
					{
						"id_muestra_validacion":3,
						"id_muestra":3,
						"id_estudio":1,
						"id_cliente":1,
						"id_solicitud":1,
						"id_orden":1,
						"id_plan":1,
						"id_hoja":1,
						"id_recepcion":1,
						"id_recepcion":0,
						"id_custodia":0,
						"id_paquete_puntos":1,
						"id_punto":3,
						"id_status":1,
						"id_ejercicio":2015,
						"id_municipio":14051,
						"id_localidad":140510013,
						"folio":"0421/2015",
						"punto":"Ex-hacienda Zap.",
						"descripcion":"Ex-hacienda de Zapotlanejo",
						"lat":20.442003,
						"lng":-103.143814,
						"alt":0,
						"municipio":"municipio 14051",
						"localidad":"localidad 140510013",
						"fecha_muestreo":"2015-03-23T11:23-06:00",
						"selected":true,
						"comentarios_muestreo":""
					},
					{
						"id_muestra_validacion":4,
						"id_muestra":4,
						"id_estudio":1,
						"id_cliente":1,
						"id_solicitud":1,
						"id_orden":1,
						"id_plan":1,
						"id_hoja":1,
						"id_recepcion":1,
						"id_recepcion":0,
						"id_custodia":0,
						"id_paquete_puntos":1,
						"id_punto":4,
						"id_status":1,
						"id_ejercicio":2015,
						"id_municipio":14051,
						"id_localidad":140510001,
						"folio":"0422/2015",
						"punto":"Salto-Juanacatlán",
						"descripcion":"Compuerta - Puente El Salto-Juanacatlán",
						"lat":20.512825,
						"lng":-103.174558,
						"alt":0,
						"municipio":"municipio 14051",
						"localidad":"localidad 140510001",
						"fecha_muestreo":"2015-03-23T12:40-06:00",
						"selected":true,
						"comentarios_muestreo":""
					},
					{
						"id_muestra_validacion":5,
						"id_muestra":5,
						"id_estudio":1,
						"id_cliente":1,
						"id_solicitud":1,
						"id_orden":1,
						"id_plan":1,
						"id_hoja":1,
						"id_recepcion":1,
						"id_recepcion":0,
						"id_custodia":0,
						"id_paquete_puntos":1,
						"id_punto":5,
						"id_status":1,
						"id_ejercicio":2015,
						"id_municipio":14101,
						"id_localidad":141010026,
						"folio":"0423/2015",
						"punto":"Puente Grande",
						"descripcion":"Puente Grande",
						"lat":20.571036,
						"lng":-103.147283,
						"alt":0,
						"municipio":"municipio 14101",
						"localidad":"localidad 141010026",
						"fecha_muestreo":"2015-03-23T13:14-06:00",
						"selected":true,
						"comentarios_muestreo":""
					},
					{
						"id_muestra_validacion":6,
						"id_muestra":6,
						"id_estudio":1,
						"id_cliente":1,
						"id_solicitud":1,
						"id_orden":1,
						"id_plan":1,
						"id_hoja":1,
						"id_recepcion":1,
						"id_recepcion":0,
						"id_custodia":0,
						"id_paquete_puntos":1,
						"id_punto":6,
						"id_status":1,
						"id_ejercicio":2015,
						"id_municipio":14101,
						"id_localidad":141010009,
						"folio":"0424/2015",
						"punto":"Matatlán",
						"descripcion":"Vertedero Controlado Matatlán",
						"lat":20.668289,
						"lng":-103.187169,
						"alt":0,
						"municipio":"municipio 14101",
						"localidad":"localidad 141010009",
						"fecha_muestreo":"2015-03-23T13:51-06:00",
						"selected":true,
						"comentarios_muestreo":""
					}
				],
				"validacion_preservaciones":
				[
					{
						"id_validacion_preservacion":1,
						"id_recepcion":1,
						"id_preservacion":1,
						"id_clase_parametro":1,
						"clase_parametro":"Fisicoquímico",
						"clase_param":"FQ",
						"preservacion":"Hielo, 4°C",
						"tipo_preservacion":"Fisicoquímico",
						"descripcion":"Hielo, 4°C",
						"preservado":true,
						"selected":true,
						"cantidad":0,
						"activo":1
					},
					{
						"id_validacion_preservacion":2,
						"id_recepcion":1,
						"id_preservacion":2,
						"id_clase_parametro":2,
						"clase_parametro":"Oxígeno disuelto",
						"clase_param":"OD",
						"preservacion":"2 ml MnSo4 + 2 ml Álcali Ioduro + 2 ml H2So4",
						"tipo_preservacion":"Oxígeno disuelto",
						"descripcion":"2 ml MnSo4 + 2 ml Álcali Ioduro + 2 ml H2So4",
						"preservado":true,
						"selected":true,
						"cantidad":0,
						"activo":1
					},
					{
						"id_validacion_preservacion":3,
						"id_recepcion":1,
						"id_preservacion":3,
						"id_clase_parametro":3,
						"clase_parametro":"Sustancias activas al azul de metileno",
						"clase_param":"SAAM",
						"preservacion":"H2SO4, 4°C, pH<2",
						"tipo_preservacion":"Sustancias activas al azul de metileno",
						"descripcion":"H2SO4, 4°C, pH<2",
						"preservado":true,
						"selected":true,
						"cantidad":0,
						"activo":1
					},
					{
						"id_validacion_preservacion":4,
						"id_recepcion":1,
						"id_preservacion":4,
						"id_clase_parametro":4,
						"clase_parametro":"Fenoles",
						"clase_param":"FEN",
						"preservacion":"5ml H2SO4 + CuSO4, 4°C, pH<2",
						"tipo_preservacion":"Fenoles",
						"descripcion":"5ml H2SO4 + CuSO4, 4°C, pH<2",
						"preservado":true,
						"selected":true,
						"cantidad":0,
						"activo":1
					},
					{
						"id_validacion_preservacion":5,
						"id_recepcion":1,
						"id_preservacion":5,
						"id_clase_parametro":5,
						"clase_parametro":"Dureza",
						"clase_param":"DZA",
						"preservacion":"HNO3, pH<2",
						"tipo_preservacion":"Dureza",
						"descripcion":"HNO3, pH<2",
						"preservado":false,
						"selected":false,
						"cantidad":0,
						"activo":1
					},
					{
						"id_validacion_preservacion":6,
						"id_recepcion":1,
						"id_preservacion":6,
						"id_clase_parametro":6,
						"clase_parametro":"Sulfuros",
						"clase_param":"Sulfuros",
						"preservacion":"6.5 ml de Acetato de Zn 2N, NaOH 6N pH≥9, 4°C",
						"tipo_preservacion":"Sulfuros",
						"descripcion":"6.5 ml de Acetato de Zn 2N, NaOH 6N pH≥9, 4°C",
						"preservado":false,
						"selected":false,
						"cantidad":0,
						"activo":1
					},
					{
						"id_validacion_preservacion":8,
						"id_recepcion":1,
						"id_preservacion":8,
						"id_clase_parametro":8,
						"clase_parametro":"Grasas y aceites",
						"clase_param":"GyA",
						"preservacion":"HCL 1:1, 4°C, pH<2",
						"tipo_preservacion":"Grasas y aceites",
						"descripcion":"HCL1:1, 4°C, pH<2",
						"preservado":false,
						"selected":false,
						"cantidad":0,
						"activo":1
					}
				],
				"validacion_contenedores":
				[
					{
						"id_validacion_contenedor":1,
						"id_recepcion":1,
						"id_muestra":5,
						"id_area":1,
						"area":"Fisicoquímicos",
						"volumen":true,
						"vigencia":true,
						"contenedor":true,
						"selected":true
					},
					{
						"id_validacion_contenedor":2,
						"id_recepcion":1,
						"id_muestra":5,
						"id_area":2,
						"area":"Metales Pesados",
						"volumen":true,
						"vigencia":true,
						"contenedor":true,
						"selected":true
					},
					{
						"id_validacion_contenedor":3,
						"id_recepcion":1,
						"id_muestra":5,
						"id_area":3,
						"area":"Microbiología",
						"volumen":true,
						"vigencia":true,
						"contenedor":true,
						"selected":true
					}
				]
			}
	';
	return json_decode($json);
}

function getReceptions() {
	$json = '
		[
			{
				"id_recepcion":1,
				"id_hoja":1,
				"id_recepcionista":13,
				"id_verificador":13,
				"id_muestra_validacion":1,
				"id_status":1,
				"fecha_recibe":"2015-03-24T13:05-06:00",
				"fecha_verifica":"2015-03-23T13:06-06:00",
				"fecha_captura":"2015-03-23T14:25-06:00",
				"ip_captura":"[::1]",
				"host_captura":"localhost",
				"fecha_valida":"2015-03-23T14:25-06:00",
				"ip_valida":"[::1]",
				"host_valida":"localhost",
				"fecha_actualiza":"2015-03-23T14:25-06:00",
				"ip_actualiza":"[::1]",
				"host_actualiza":"localhost",
				"fecha_rechaza":"",
				"comentarios":"Sin observaciones",
				"motivo_rechaza":"",
				"activo":1,
				"plan":
				{
					"id_plan":1,
					"folio":"CEA-437/2014",
					"fecha_plan":"2015-03-23T09:12-06:00"
				},
				"hoja":
				{
					"id_hoja":1,
					"fecha_muestreo":"2015-03-24T08:12-06:00",
					"fecha_recibe":"2015-03-24T13:05-06:00"
				},
				"muestras":
				[
					{
						"id_muestra_validacion":1,
						"id_muestra":1,
						"id_estudio":1,
						"id_cliente":1,
						"id_solicitud":1,
						"id_orden":1,
						"id_plan":1,
						"id_hoja":1,
						"id_recepcion":1,
						"id_custodia":0,
						"id_paquete_puntos":1,
						"id_punto":1,
						"id_status":1,
						"id_ejercicio":2015,
						"id_municipio":14063,
						"id_localidad":140630001,
						"folio":"0419/2015",
						"punto":"Ocotlán",
						"descripcion":"Ocotlán",
						"lat":20.346928,
						"lng":-102.779392,
						"alt":0,
						"municipio":"municipio 14063",
						"localidad":"localidad 140630001",
						"fecha_muestreo":"2015-03-23T09:00-06:00",
						"selected":true,
						"comentarios_muestreo":""
					},
					{
						"id_muestra_validacion":2,
						"id_muestra":2,
						"id_estudio":1,
						"id_cliente":1,
						"id_solicitud":1,
						"id_orden":1,
						"id_plan":1,
						"id_hoja":1,
						"id_recepcion":1,
						"id_recepcion":0,
						"id_custodia":0,
						"id_paquete_puntos":1,
						"id_punto":2,
						"id_status":1,
						"id_ejercicio":2015,
						"id_municipio":14030,
						"id_localidad":140300038,
						"folio":"0420/2015",
						"punto":"Presa Corona",
						"descripcion":"Cortina Presa Corona - Poncitlán",
						"lat":20.399667,
						"lng":-103.090619,
						"alt":0,
						"municipio":"municipio 14030",
						"localidad":"localidad 140300038",
						"fecha_muestreo":"2015-03-23T10:40-06:00",
						"selected":true,
						"comentarios_muestreo":""
					},
					{
						"id_muestra_validacion":3,
						"id_muestra":3,
						"id_estudio":1,
						"id_cliente":1,
						"id_solicitud":1,
						"id_orden":1,
						"id_plan":1,
						"id_hoja":1,
						"id_recepcion":1,
						"id_recepcion":0,
						"id_custodia":0,
						"id_paquete_puntos":1,
						"id_punto":3,
						"id_status":1,
						"id_ejercicio":2015,
						"id_municipio":14051,
						"id_localidad":140510013,
						"folio":"0421/2015",
						"punto":"Ex-hacienda Zap.",
						"descripcion":"Ex-hacienda de Zapotlanejo",
						"lat":20.442003,
						"lng":-103.143814,
						"alt":0,
						"municipio":"municipio 14051",
						"localidad":"localidad 140510013",
						"fecha_muestreo":"2015-03-23T11:23-06:00",
						"selected":true,
						"comentarios_muestreo":""
					},
					{
						"id_muestra_validacion":4,
						"id_muestra":4,
						"id_estudio":1,
						"id_cliente":1,
						"id_solicitud":1,
						"id_orden":1,
						"id_plan":1,
						"id_hoja":1,
						"id_recepcion":1,
						"id_recepcion":0,
						"id_custodia":0,
						"id_paquete_puntos":1,
						"id_punto":4,
						"id_status":1,
						"id_ejercicio":2015,
						"id_municipio":14051,
						"id_localidad":140510001,
						"folio":"0422/2015",
						"punto":"Salto-Juanacatlán",
						"descripcion":"Compuerta - Puente El Salto-Juanacatlán",
						"lat":20.512825,
						"lng":-103.174558,
						"alt":0,
						"municipio":"municipio 14051",
						"localidad":"localidad 140510001",
						"fecha_muestreo":"2015-03-23T12:40-06:00",
						"selected":true,
						"comentarios_muestreo":""
					},
					{
						"id_muestra_validacion":5,
						"id_muestra":5,
						"id_estudio":1,
						"id_cliente":1,
						"id_solicitud":1,
						"id_orden":1,
						"id_plan":1,
						"id_hoja":1,
						"id_recepcion":1,
						"id_recepcion":0,
						"id_custodia":0,
						"id_paquete_puntos":1,
						"id_punto":5,
						"id_status":1,
						"id_ejercicio":2015,
						"id_municipio":14101,
						"id_localidad":141010026,
						"folio":"0423/2015",
						"punto":"Puente Grande",
						"descripcion":"Puente Grande",
						"lat":20.571036,
						"lng":-103.147283,
						"alt":0,
						"municipio":"municipio 14101",
						"localidad":"localidad 141010026",
						"fecha_muestreo":"2015-03-23T13:14-06:00",
						"selected":true,
						"comentarios_muestreo":""
					},
					{
						"id_muestra_validacion":6,
						"id_muestra":6,
						"id_estudio":1,
						"id_cliente":1,
						"id_solicitud":1,
						"id_orden":1,
						"id_plan":1,
						"id_hoja":1,
						"id_recepcion":1,
						"id_recepcion":0,
						"id_custodia":0,
						"id_paquete_puntos":1,
						"id_punto":6,
						"id_status":1,
						"id_ejercicio":2015,
						"id_municipio":14101,
						"id_localidad":141010009,
						"folio":"0424/2015",
						"punto":"Matatlán",
						"descripcion":"Vertedero Controlado Matatlán",
						"lat":20.668289,
						"lng":-103.187169,
						"alt":0,
						"municipio":"municipio 14101",
						"localidad":"localidad 141010009",
						"fecha_muestreo":"2015-03-23T13:51-06:00",
						"selected":true,
						"comentarios_muestreo":""
					}
				],
				"validacion_preservaciones":
				[
					{
						"id_validacion_preservacion":1,
						"id_recepcion":1,
						"id_preservacion":1,
						"id_clase_parametro":1,
						"clase_parametro":"Fisicoquímico",
						"clase_param":"FQ",
						"preservacion":"Hielo, 4°C",
						"tipo_preservacion":"Fisicoquímico",
						"descripcion":"Hielo, 4°C",
						"preservado":true,
						"selected":true,
						"cantidad":0,
						"activo":1
					},
					{
						"id_validacion_preservacion":2,
						"id_recepcion":1,
						"id_preservacion":2,
						"id_clase_parametro":2,
						"clase_parametro":"Oxígeno disuelto",
						"clase_param":"OD",
						"preservacion":"2 ml MnSo4 + 2 ml Álcali Ioduro + 2 ml H2So4",
						"tipo_preservacion":"Oxígeno disuelto",
						"descripcion":"2 ml MnSo4 + 2 ml Álcali Ioduro + 2 ml H2So4",
						"preservado":true,
						"selected":true,
						"cantidad":0,
						"activo":1
					},
					{
						"id_validacion_preservacion":3,
						"id_recepcion":1,
						"id_preservacion":3,
						"id_clase_parametro":3,
						"clase_parametro":"Sustancias activas al azul de metileno",
						"clase_param":"SAAM",
						"preservacion":"H2SO4, 4°C, pH<2",
						"tipo_preservacion":"Sustancias activas al azul de metileno",
						"descripcion":"H2SO4, 4°C, pH<2",
						"preservado":true,
						"selected":true,
						"cantidad":0,
						"activo":1
					},
					{
						"id_validacion_preservacion":4,
						"id_recepcion":1,
						"id_preservacion":4,
						"id_clase_parametro":4,
						"clase_parametro":"Fenoles",
						"clase_param":"FEN",
						"preservacion":"5ml H2SO4 + CuSO4, 4°C, pH<2",
						"tipo_preservacion":"Fenoles",
						"descripcion":"5ml H2SO4 + CuSO4, 4°C, pH<2",
						"preservado":true,
						"selected":true,
						"cantidad":0,
						"activo":1
					},
					{
						"id_validacion_preservacion":5,
						"id_recepcion":1,
						"id_preservacion":5,
						"id_clase_parametro":5,
						"clase_parametro":"Dureza",
						"clase_param":"DZA",
						"preservacion":"HNO3, pH<2",
						"tipo_preservacion":"Dureza",
						"descripcion":"HNO3, pH<2",
						"preservado":false,
						"selected":false,
						"cantidad":0,
						"activo":1
					},
					{
						"id_validacion_preservacion":6,
						"id_recepcion":1,
						"id_preservacion":6,
						"id_clase_parametro":6,
						"clase_parametro":"Sulfuros",
						"clase_param":"Sulfuros",
						"preservacion":"6.5 ml de Acetato de Zn 2N, NaOH 6N pH≥9, 4°C",
						"tipo_preservacion":"Sulfuros",
						"descripcion":"6.5 ml de Acetato de Zn 2N, NaOH 6N pH≥9, 4°C",
						"preservado":false,
						"selected":false,
						"cantidad":0,
						"activo":1
					},
					{
						"id_validacion_preservacion":8,
						"id_recepcion":1,
						"id_preservacion":8,
						"id_clase_parametro":8,
						"clase_parametro":"Grasas y aceites",
						"clase_param":"GyA",
						"preservacion":"HCL 1:1, 4°C, pH<2",
						"tipo_preservacion":"Grasas y aceites",
						"descripcion":"HCL1:1, 4°C, pH<2",
						"preservado":false,
						"selected":false,
						"cantidad":0,
						"activo":1
					}
				],
				"validacion_contenedores":
				[
					{
						"id_validacion_contenedor":1,
						"id_recepcion":1,
						"id_muestra":5,
						"id_area":1,
						"area":"Fisicoquímicos",
						"volumen":true,
						"vigencia":true,
						"contenedor":true,
						"selected":true
					},
					{
						"id_validacion_contenedor":2,
						"id_recepcion":1,
						"id_muestra":5,
						"id_area":2,
						"area":"Metales Pesados",
						"volumen":true,
						"vigencia":true,
						"contenedor":true,
						"selected":true
					},
					{
						"id_validacion_contenedor":3,
						"id_recepcion":1,
						"id_muestra":5,
						"id_area":3,
						"area":"Microbiología",
						"volumen":true,
						"vigencia":true,
						"contenedor":true,
						"selected":true
					}
				]
			}
		]
	';
	return json_decode($json);
}


function getCustody($custodyId) {
	$json = '
		{}
	';
	return json_decode($json);
}

function getCustodies() {
	$json = '
		[
			{}
		]
	';
	return json_decode($json);
}

function getPoints() {
	$sql = "SELECT id_punto, id_cuerpo_receptor, id_tipo_punto,
		id_estado, id_municipio, id_localidad, id_usuario_captura,
		id_usuario_actualiza, punto, descripcion, siglas,
		consecutivo, clave, lat, lng, alt, lat_gra, lat_min, lat_seg,
		lng_gra, lng_min, lng_seg,
		CONVERT(nvarchar, fecha_captura, 126) AS fecha_captura,
		CONVERT(nvarchar, fecha_actualiza, 126) AS fecha_actualiza,
		ip_captura, ip_actualiza, host_captura, host_actualiza,
		comentarios, activo
		FROM Punto
		WHERE activo = 1";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->execute();
	$points = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$db = null;
	return $points;
}

function getPoint($pointId) {
	$sql = "SELECT id_punto, id_cuerpo_receptor, id_tipo_punto,
		id_estado, id_municipio, id_localidad, id_usuario_captura,
		id_usuario_actualiza, punto, descripcion, siglas,
		consecutivo, clave, lat, lng, alt, lat_gra, lat_min, lat_seg,
		lng_gra, lng_min, lng_seg,
		CONVERT(nvarchar, fecha_captura, 126) AS fecha_captura,
		CONVERT(nvarchar, fecha_actualiza, 126) AS fecha_actualiza,
		ip_captura, ip_actualiza, host_captura, host_actualiza,
		comentarios, activo
		FROM Punto
		WHERE activo = 1 AND id_punto = :pointId";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->bindParam("pointId", $pointId);
	$stmt->execute();
	$point = (array) $stmt->fetchAll(PDO::FETCH_OBJ)[0];
	$db = null;
	return (object) $point;
}

function getPointPackages() {
	$sql = "SELECT id_paquete, paquete, activo
		FROM Paquete
		WHERE activo = 1";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->execute();
	$pointPackages = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$db = null;
	return $pointPackages;
}

function getPointsByPackage($packageId) {
	$sql = "SELECT id_paquete, paquete, id_paquete_punto, id_punto,
		id_cuerpo_receptor, id_tipo_punto, id_estado, id_municipio,
		id_localidad, id_usuario_captura, id_usuario_actualiza, punto,
		descripcion, siglas, consecutivo, clave, lat, lng, alt,
		lat_gra, lat_min, lat_seg, lng_gra, lng_min, lng_seg,
		CONVERT(nvarchar, fecha_captura, 126) AS fecha_captura,
		CONVERT(nvarchar, fecha_actualiza, 126) AS fecha_actualiza,
		 ip_captura, ip_actualiza,
		host_captura, host_actualiza, comentarios, activo
		FROM viewPuntoPaquete
		WHERE id_paquete = :packageId";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->bindParam("packageId", $packageId);
	$stmt->execute();
	$points = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$db = null;
	return $points;
}

function getMethods() {
	$sql = "SELECT id_metodo, id_norma, metodo, descripcion, activo
		FROM Metodo
		WHERE activo = 1";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->execute();
	$methods = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$db = null;
	return $methods;
}

function getMethod($methodId) {
	$sql = "SELECT id_metodo, id_norma, metodo, descripcion, activo
		FROM Metodo
		WHERE activo = 1 AND id_metodo = :methodId";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->bindParam("methodId", $methodId);
	$stmt->execute();
	$method = (array) $stmt->fetchAll(PDO::FETCH_OBJ)[0];
	$db = null;
	return (object) $method;
}

function getParameters() {
	$sql = "SELECT id_parametro, id_tipo_matriz, id_area,
		id_tipo_preservacion, id_metodo, id_unidad, id_tipo_valor,
		parametro, param, caducidad, limite_entrega, acreditado,
		precio, activo
		FROM Parametro
		WHERE activo = 1";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->execute();
	$parameters = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$db = null;
	return $parameters;
}

function getParametersField() {
	$sql = "SELECT id_parametro, id_tipo_matriz, id_area,
		id_tipo_preservacion, id_metodo, id_unidad, id_tipo_valor,
		parametro, param, caducidad, limite_entrega, acreditado,
		precio, activo
		FROM Parametro
		WHERE activo = 1 AND id_area = 4";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->execute();
	$parameters = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$db = null;
	return $parameters;
}


function getReceptionists() {
	$sql = "SELECT id_usuario, id_nivel, id_rol, id_empleado,
		id_area, id_puesto, interno, cea, laboratorio, calidad,
		supervisa, recibe, analiza, muestrea, nombres,
		apellido_paterno, apellido_materno,
		fecha_captura, fecha_actualiza, ip_captura, ip_actualiza,
		host_captura, host_actualiza, activo
		FROM Usuario
		WHERE activo = 1 AND recibe = 1";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->execute();
	$receptionists = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$db = null;
	return $receptionists;
}

function getSamples() {
	$sql = "SELECT id_muestra, id_estudio, id_cliente, id_orden,
		id_plan, id_hoja, id_recepcion, id_custodia, id_paquete,
		id_ubicacion, id_punto, fecha_muestreo, comentarios, activo
		FROM Muestra
		WHERE activo = 1";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->execute();
	$samples = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$db = null;
	return $samples;
}

function getInstruments() {
	$sql = "SELECT id_instrumento, id_usuario_captura,
		id_usuario_actualiza, instrumento, descripcion, muestreo,
		laboratorio, inventario, bitacora, folio,
		fecha_captura, fecha_actualiza,
		ip_captura, ip_actualiza, host_captura, host_actualiza,
		comentarios, activo
		FROM Instrumento
		WHERE activo = 1";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->execute();
	$instruments = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$db = null;
	return $instruments;
}

function getInstrumentsByPlan($planId) {
	$sql = "SELECT id_plan_instrumento, id_plan, id_instrumento,
		bitacora, folio, activo
		FROM PlanInstrumento
		WHERE id_plan = :planId";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->bindParam("planId", $planId);
	$stmt->execute();
	$instruments = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$db = null;
	$l = count($instruments);
	for ($i = 0; $i < $l; $i++) {
		$instruments[$i]["selected"] = true;
	}
	return $instruments;
}

function insertPlanInstrument($instrumentData) {
	$sql = "INSERT INTO PlanInstrumento (id_plan, id_instrumento,
		bitacora, folio, activo)
		VALUES (:id_plan, :id_instrumento,
		:bitacora, :folio, :activo)";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->execute($instrumentData);
	$instrumentId = $db->lastInsertId();
	$db = null;
	return $instrumentId;
}

function updatePlanInstrument($updateData) {
	$sql = "UPDATE PlanInstrumento SET id_plan = :id_plan,
		id_instrumento = :id_instrumento,
 		bitacora = :bitacora, folio = :folio,
 		activo = :activo
 		WHERE id_plan_instrumento = :id_plan_instrumento";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->execute($updateData);
	$db = null;
	return $updateData["id_plan_instrumento"];
}

function getParameter($parameterId) {
	$sql = "SELECT id_parametro, id_tipo_matriz, id_area,
		id_tipo_preservacion, id_metodo, id_unidad, id_tipo_valor,
		parametro, param, caducidad, limite_entrega, acreditado,
		precio, activo
		FROM Parametro
		WHERE activo = 1 AND id_parametro = :parameterId";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->bindParam("parameterId", $parameterId);
	$stmt->execute();
	$parameter = (array) $stmt->fetchAll(PDO::FETCH_OBJ)[0];
	$db = null;
	return (object) $parameter;
}

function getParametersByNorm($normId) {
	$sql = "SELECT id_parametro, id_tipo_matriz, id_area,
		id_tipo_preservacion, id_metodo, id_unidad, id_tipo_valor,
		parametro, param, caducidad, limite_entrega, acreditado,
		precio, activo, id_norma
		FROM viewParametroNorma
		WHERE id_norma = :normId";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->bindParam("normId", $normId);
	$stmt->execute();
	$parameter = (array) $stmt->fetchAll(PDO::FETCH_OBJ)[0];
	$db = null;
	return (object) $parameter;
}

function getNorms() {
	$sql = "SELECT id_norma, id_tipo_norma, id_tipo_matriz, norma,
		descripcion, activo
		FROM Norma
		WHERE activo = 1";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->execute();
	$norms = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$db = null;
	return $norms;
}

function getNorm($normId) {
	$sql = "SELECT id_norma, id_tipo_norma, id_tipo_matriz, norma,
		descripcion, activo
		FROM Norma
		WHERE activo = 1 AND id_norma = :normId";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->bindParam("normId", $normId);
	$stmt->execute();
	$norm = (array) $stmt->fetchAll(PDO::FETCH_OBJ)[0];
	$db = null;
	return (object) $norm;
}

function getSamplingTypes() {
	$sql = "SELECT id_tipo_muestreo, tipo_muestreo, activo
		FROM TipoMuestreo
		WHERE activo = 1";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->execute();
	$samplingTypes = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$db = null;
	return $samplingTypes;
}

function getSamplingType($samplingTypeId) {
	$sql = "SELECT id_tipo_muestreo, tipo_muestreo, activo
		FROM TipoMuestreo
		WHERE activo = 1 AND id_tipo_muestreo = :samplingTypeId";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->bindParam("samplingTypeId", $samplingTypeId);
	$stmt->execute();
	$samplingType = (array) $stmt->fetchAll(PDO::FETCH_OBJ)[0];
	$db = null;
	return (object) $samplingType;
}

function getMatrices() {
	$sql = "SELECT id_matriz, id_tipo_matriz, id_norma, matriz,
		siglas, activo
		FROM Matriz
		WHERE activo = 1";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->execute();
	$matrices = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$db = null;
	return $matrices;
}

function getMatrix($matrixId) {
	$sql = "SELECT id_matriz, id_tipo_matriz, id_norma, matriz,
		siglas, activo
		FROM Matriz
		WHERE activo = 1 AND id_matriz = :matrixId";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->bindParam("matrixId", $matrixId);
	$stmt->execute();
	$matrix = (array) $stmt->fetchAll(PDO::FETCH_OBJ)[0];
	$db = null;
	return (object) $matrix;
}

function getContainers() {
	$sql = "SELECT id_recipiente, recipiente, tipo_recipiente, activo
		FROM Recipiente
		WHERE activo = 1";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->execute();
	$containers = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$db = null;
	return $containers;
}

function getAnalysis() {
	$json = '[]';
	return json_decode($json);
}

function getAnalysisSelections() {
	$json = '[]';
	return json_decode($json);
}

function getReports() {
	$json = '[]';
	return json_decode($json);
}

function getReferences() {
	$json = '[]';
	return json_decode($json);
}

function getPrices() {
	$sql = "SELECT DISTINCT precio, activo
		FROM Parametro
		ORDER BY precio";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->execute();
	$prices = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$db = null;
	return $prices;
}

function getContainersByPlan($planId) {
	$sql = "SELECT id_plan_recipiente, id_plan, id_recipiente,
		cantidad, activo
		FROM PlanRecipiente
		WHERE id_plan = :planId";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->bindParam("planId", $planId);
	$stmt->execute();
	$containers = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$db = null;
	$l = count($containers);
	for ($i = 0; $i < $l; $i++) {
		$containers[$i]["selected"] = true;
	}
	return $containers;
}

function insertPlanContainer($containerData) {
	$sql = "INSERT INTO PlanRecipiente (id_plan, id_recipiente,
		cantidad, activo)
		VALUES (:id_plan, :id_recipiente,
		:cantidad, :activo)";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->execute($containerData);
	$instrumentId = $db->lastInsertId();
	$db = null;
	return $instrumentId;
}

function updatePlanContainer($updateData) {
	$sql = "UPDATE PlanRecipiente SET id_plan = :id_plan,
		id_recipiente = :id_recipiente,
 		cantidad = :cantidad, activo = :activo
 		WHERE id_plan_recipiente = :id_plan_recipiente";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->execute($updateData);
	$db = null;
	return $updateData["id_plan_recipiente"];
}

function getReactivesByPlan($planId) {
	$sql = "SELECT id_plan_reactivo, id_plan, id_reactivo, valor,
		lote, folio
		FROM PlanReactivo
		WHERE id_plan = :planId";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->bindParam("planId", $planId);
	$stmt->execute();
	$reactives = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$db = null;
	$l = count($reactives);
	for ($i = 0; $i < $l; $i++) {
		$reactives[$i]["selected"] = true;
	}
	return $reactives;
}

function getMaterialsByPlan($planId) {
	$sql = "SELECT p.id_plan, pm.id_plan_material, m.id_material,
		m.material, m.activo
		FROM [Plan] p INNER JOIN
		PlanMaterial pm ON p.id_plan = pm.id_plan INNER JOIN
		Material m ON pm.id_material = m.id_material
		WHERE p.id_plan = :planId";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->bindParam("planId", $planId);
	$stmt->execute();
	$materials = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$db = null;
	$l = count($materials);
	for ($i = 0; $i < $l; $i++) {
		$materials[$i]["selected"] = true;
	}
	return $materials;
}

function getCoolersByPlan($planId) {
	$sql = "SELECT p.id_plan, ph.id_plan_hielera, h.id_hielera,
		h.hielera, h.activo, 'true' AS selected
		FROM [Plan] p INNER JOIN
		PlanHielera ph ON p.id_plan = ph.id_plan INNER JOIN
		Hielera h ON ph.id_hielera = h.id_hielera
		WHERE p.id_plan = :planId";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->bindParam("planId", $planId);
	$stmt->execute();
	$coolers = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$db = null;
	$l = count($coolers);
	for ($i = 0; $i < $l; $i++) {
		$coolers[$i]["selected"] = true;
	}
	return $coolers;
}

function getEmployees() {
	$sql = "SELECT id_usuario, id_nivel, id_rol, id_area, id_puesto,
		interno, cea, laboratorio, supervisa, analiza, muestrea, nombres,
		apellido_paterno, apellido_materno, activo
		FROM Usuario
		WHERE activo = 1 AND laboratorio = 1";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->execute();
	$samplingEmployees = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$db = null;
	return $samplingEmployees;
}

function getSamplingEmployee($userId) {
	$sql = "SELECT id_usuario, id_nivel, id_rol, id_area, id_puesto,
		interno, cea, laboratorio, supervisa, analiza, muestrea, nombres,
		apellido_paterno, apellido_materno, activo
		FROM Usuario
		WHERE activo = 1 AND id_area = 4 AND id_usuario = :userId";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->bindParam("userId", $userId);
	$stmt->execute();
	$samplingEmployee = (array) $stmt->fetchAll(PDO::FETCH_OBJ)[0];
	$db = null;
	return (object) $samplingEmployee;
}

function getPointKinds() {
	$sql = "SELECT id_tipo_punto, tipo_punto, activo
		FROM TipoPunto
		WHERE activo = 1";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->execute();
	$pointKinds = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$db = null;
	return $pointKinds;
}

function getDistricts() {
	$json = '
		[
			{
				"id_municipio":14001,
				"municipio":"Acatic"
			},
			{
				"id_municipio":14030,
				"municipio":"Chapala"
			},
			{
				"id_municipio":14039,
				"municipio":"Guadalajara"
			},
			{
				"id_municipio":14120,
				"municipio":"Zapopan"
			},
			{
				"id_municipio":14123,
				"municipio":"Zapotlan El Grande"
			},
			{
				"id_municipio":14124,
				"municipio":"Zapotlanejo"
			}
		]
	';
	return json_decode($json);
}

function getDistrict() {
	if ($districtId == 14001)
	{
		$json = '
			{
				"id_municipio":14001,
				"municipio":"Acatic"
			}
		';
	}
	else if ($districtId == 14030)
	{
		$json = '
			{
				"id_municipio":14030,
				"municipio":"Chapala"
			}
		';
	}
	else if ($districtId == 14039)
	{
		$json = '
			{
				"id_municipio":14039,
				"municipio":"Guadalajara"
			}
		';
	}
	else if ($districtId == 14120)
	{
		$json = '
			{
				"id_municipio":14120,
				"municipio":"Zapopan"
			}
		';
	}
	else if ($districtId == 14123)
	{
		$json = '
			{
				"id_municipio":14123,
				"municipio":"Zapotlan El Grande"
			}
		';
	}
	else
	{
		$json = '
			{
				"id_municipio":14124,
				"municipio":"Zapotlanejo"
			}
		';
	}
	return json_decode($json);
}

function getCitiesByDistrictId($districtId) {
	$json = '
		[
			{
				"id_municipio":' . $districtId . ',
				"id_localidad":' . $districtId . '0001,
				"localidad": "Localidad municipio ' . $districtId . '"
			}
		]
	';
	return json_decode($json);
}

function getPreservations() {
	$sql = "SELECT id_preservacion, id_tipo_preservacion, preservacion,
		descripcion, activo
		FROM Preservacion
		WHERE activo = 1";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->execute();
	$preservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$db = null;
	return $preservations;
}

function getSamplingInstruments() {
	$sql = "SELECT id_instrumento, instrumento, descripcion, muestreo,
		inventario, bitacora, folio, activo
		FROM Instrumento
		WHERE activo = 1 AND muestreo = 1";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->execute();
	$instruments = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$db = null;
	$l = count($instruments);
	for ($i = 0; $i < $l; $i++) {
		$instruments[$i]["selected"] = false;
	}
	return $instruments;
}

function getContainerKinds() {
	$sql = "SELECT  id_recipiente, recipiente, tipo_recipiente, activo,
		'0' AS cantidad, 'false' AS selected
		FROM Recipiente
		WHERE activo = 1";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->execute();
	$containerKinds = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$db = null;
	return $containerKinds;
}

function getReactives() {
	$sql = "SELECT   id_reactivo, id_tipo_reactivo, reactivo,
		registra_valor, lote, folio, activo,
		'0' AS valor
		FROM Reactivo
		WHERE activo = 1";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->execute();
	$reactives = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$db = null;
	$l = count($reactives);
	for ($i = 0; $i < $l; $i++) {
		$reactives[$i]["selected"] = false;
	}
	return $reactives;
}

function getMaterials() {
	$sql = "SELECT id_material, material, activo
		FROM Material
		WHERE activo = 1";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->execute();
	$materials = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$db = null;
	$l = count($materials);
	for ($i = 0; $i < $l; $i++) {
		$materials[$i]["selected"] = false;
	}
	return $materials;
}

function getCoolers() {
	$sql = "SELECT id_hielera, hielera, activo
		FROM Hielera
		WHERE activo = 1";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->execute();
	$coolers = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$db = null;
	$l = count($coolers);
	for ($i = 0; $i < $l; $i++) {
		$coolers[$i]["selected"] = false;
	}
	return $coolers;
}

function getClouds() {
	$sql = "SELECT id_nubes, nubes, activo
		FROM Nubes
		WHERE activo = 1";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->execute();
	$clouds = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$db = null;
	return $clouds;
}

function getCurrentDirections() {
	$sql = "SELECT id_direccion_corriente, direccion_corriente, activo
		FROM DireccionCorriente
		WHERE activo = 1";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->execute();
	$currentDirections = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$db = null;
	return $currentDirections;
}

function getWaves() {
	$sql = "SELECT id_oleaje, oleaje, activo
		FROM Oleaje
		WHERE activo = 1";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->execute();
	$waves = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$db = null;
	return $waves;
}

function getSamplingNorms() {
	$sql = "SELECT id_norma, id_tipo_norma, id_tipo_matriz,
		norma, descripcion, activo
		FROM Norma
		WHERE activo = 1 AND id_tipo_norma = 2";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->execute();
	$waves = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$db = null;
	return $waves;
}
