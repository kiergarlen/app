<?php
//DB FUNCTIONS
define("DB_HOST", "localhost");
define("DB_USER", "sislab");
define("DB_PASSWORD", "sislab");
define("DB_DATA_BASE", "Sislab");

/**
 * Conecta a la base de datos, regresa una instancia de PDO
 * @return PDO $dbConnection
 */
function getConnection() {
  try {
    $dsn = "sqlsrv:server=";
    $dsn .= DB_HOST . ";Database=";
    $dsn .= DB_DATA_BASE;
    $dbConnection = new PDO($dsn, DB_USER, DB_PASSWORD);
    $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch(PDOException $e) {
    ////Error logging, for development
    //error_log($e->getMessage(), 3, '/var/tmp/php.log');
    $output = '{"error":"' . $e->getMessage() . ', ';
    $output .= '"statement": "' . $dbConnection . '"}';
    //print_r($output);
  }
  return $dbConnection;
}

/**
 * Obtiene los Usuarios activos
 * @return Array $result Array de Usuarios activos
 */
function getUsers() {
  $sql = "SELECT id_usuario, id_nivel, id_rol, id_area, id_puesto,
    interno, cea, laboratorio, supervisa, analiza, muestrea,
    nombres, apellido_paterno, apellido_materno, usr, pwd,
    CONVERT(NVARCHAR, fecha_captura, 126) AS fecha_captura,
    CONVERT(NVARCHAR, fecha_actualiza, 126) AS fecha_actualiza,
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

/**
 * Obtiene un Usuario, por $userId
 * @param  integer $userId Id del usuario a obtener
 * @return stdClass $user
 */
function getUser($userId) {
  $sql = "SELECT id_usuario, id_nivel, id_rol, id_empleado,
    id_trabajad, id_area, id_puesto, interno, cea, laboratorio,
    calidad, supervisa, recibe, analiza, muestrea, nombres,
    apellido_paterno, apellido_materno, puesto, rol,
    usr, pwd, activo
    FROM viewUsuarioEmpleado
    WHERE activo = 1 AND id_usuario = :userId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("userId", $userId);
  $stmt->execute();
  $user = $stmt->fetch(PDO::FETCH_OBJ);
  $db = null;
  return $user;
}

/**
 * Obtiene las credenciales de un Usuario, por $userName y $userPassword
 * @param  string $userName Nombre de Usuario
 * @param  string $userPassword Password del Usuario
 * @return stdClass $user
 */
function getUserByCredentials($userName, $userPassword) {
  $sql = "SELECT id_usuario, id_nivel, id_rol, id_empleado,
    id_trabajad, id_area, id_puesto, interno, cea, laboratorio,
    calidad, supervisa, recibe, analiza, muestrea, nombres,
    apellido_paterno, apellido_materno, puesto, rol,
    usr, pwd, activo
    FROM viewUsuarioEmpleado
    WHERE activo = 1 AND pwd = :userPassword AND usr = :userName";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("userName", $userName);
  $stmt->bindParam("userPassword", $userPassword);
  $stmt->execute();
  $user = $stmt->fetch(PDO::FETCH_OBJ);
  $db = null;
  return $user;
}

/**
 * Inserta un nuevo Usuario desde $userData
 * @param  Array $userData Array con los datos del Usuario a insertar
 * @return integer $userId Id del Usuario insertado
 */
function insertUser($userData) {
  $sql = "INSERT INTO Usuario (id_nivel, id_rol, id_area, id_puesto,
    interno, cea, laboratorio, supervisa, analiza, muestrea,
    nombres, apellido_paterno, apellido_materno, usr, pwd,
    fecha_captura, ip_captura,host_captura, activo)
    VALUES (:id_nivel, :id_rol, :id_area, :id_puesto,
    :interno, :cea, :laboratorio, :supervisa, :analiza, :muestrea,
    :nombres, :apellido_paterno, :apellido_materno, :usr, :pwd,
    SYSDATETIMEOFFSET(), :ip_captura, :host_captura, :activo)";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($userData);
  $userId = $db->lastInsertId();
  $db = null;
  return $userId;
}

/**
 * Actualiza un Usuario desde $updateData
 * @param  Array $updateData Array con los datos del Usuario a actualizar
 * @return integer $userId Id del Usuario actualizado
 */
function updateUser($updateData) {
  $sql = "UPDATE Usuario SET id_nivel = :id_nivel, id_rol = :id_rol,
    id_area = :id_area, id_puesto = :id_puesto,interno = :interno,
    cea = :cea, laboratorio = :laboratorio, supervisa = :supervisa,
    analiza = :analiza, muestrea = :muestrea,nombres = :nombres,
    apellido_paterno = :apellido_paterno,
    apellido_materno = :apellido_materno, usr = :usr,
    pwd = :pwd, fecha_captura = :fecha_captura,
    fecha_actualiza = SYSDATETIMEOFFSET(),
    ip_captura = :ip_captura,
    ip_actualiza = :ip_actualiza,host_captura = :host_captura,
    host_actualiza = :host_actualiza, activo = :activo
    WHERE id_usuario = :id_usuario";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($updateData);
  $db = null;
  $userId = $updateData["id_usuario"];
  return $userId;
}

/**
 * Obtiene los elementos del Menu/Submenu asignados al usuario $userId
 * @param  $userId integer Id del Usuario
 * @return $result Array Elementos del menu de $userId
 */
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
  $result = array();
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
    CONVERT(NVARCHAR, fecha_captura, 126) AS fecha_captura,
    CONVERT(NVARCHAR, fecha_actualiza, 126) AS fecha_actualiza,
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
    CONVERT(NVARCHAR, fecha_captura, 126) AS fecha_captura,
    CONVERT(NVARCHAR, fecha_actualiza, 126) AS fecha_actualiza,
    ip_captura, ip_actualiza, host_captura,
    host_actualiza, activo
    FROM Cliente
    WHERE activo = 1 AND id_cliente = :clientId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("clientId", $clientId);
  $stmt->execute();
  $client = $stmt->fetch(PDO::FETCH_OBJ);
  $db = null;
  return $client;
}

function getStudies() {
  $sql = "SELECT id_estudio, id_cliente, id_origen_orden,
    id_ubicacion, id_ejercicio, id_status, id_etapa,
    id_usuario_captura, id_usuario_valida, id_usuario_entrega,
    id_usuario_actualiza, oficio, folio, origen_descripcion,
    ubicacion,
    CONVERT(NVARCHAR, fecha, 126) AS fecha,
    CONVERT(NVARCHAR, fecha_entrega, 126) AS fecha_entrega,
    CONVERT(NVARCHAR, fecha_captura, 126) AS fecha_captura,
    CONVERT(NVARCHAR, fecha_valida, 126) AS fecha_valida,
    CONVERT(NVARCHAR, fecha_actualiza, 126) AS fecha_actualiza,
    CONVERT(NVARCHAR, fecha_rechaza, 126) AS fecha_rechaza,
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
    "ubicacion" => "", "fecha" => NULL,
    "fecha_entrega" => NULL, "fecha_captura" => NULL,
    "fecha_valida" => NULL, "fecha_actualiza" => NULL,
    "fecha_rechaza" => NULL,
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
      "email" => "", "fecha_captura" => NULL,
      "fecha_actualiza" => NULL, "ip_captura" => "",
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
        "tipo_cuerpo" => "", "fecha" => NULL,
        "fecha_captura" => NULL,
        "fecha_valida" => NULL, "fecha_actualiza" => NULL,
        "fecha_rechaza" => NULL, "ip_captura" => "",
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
    CONVERT(NVARCHAR, fecha, 126) AS fecha,
    CONVERT(NVARCHAR, fecha_entrega, 126) AS fecha_entrega,
    CONVERT(NVARCHAR, fecha_captura, 126) AS fecha_captura,
    CONVERT(NVARCHAR, fecha_valida, 126) AS fecha_valida,
    CONVERT(NVARCHAR, fecha_actualiza, 126) AS fecha_actualiza,
    CONVERT(NVARCHAR, fecha_rechaza, 126) AS fecha_rechaza,
    ip_captura, ip_valida, ip_actualiza,
    host_captura, host_valida, host_actualiza, motivo_rechaza,
    activo
    FROM Estudio
    WHERE activo = 1 AND id_estudio = :studyId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("studyId", $studyId);
  $stmt->execute();
  $study = $stmt->fetch(PDO::FETCH_OBJ);
  $db = null;
  return $study;
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
    CONVERT(NVARCHAR, fecha, 126) AS fecha,
    CONVERT(NVARCHAR, fecha_entrega, 126) AS fecha_entrega,
    CONVERT(NVARCHAR, fecha_captura, 126) AS fecha_captura,
    CONVERT(NVARCHAR, fecha_valida, 126) AS fecha_valida,
    CONVERT(NVARCHAR, fecha_actualiza, 126) AS fecha_actualiza,
    CONVERT(NVARCHAR, fecha_rechaza, 126) AS fecha_rechaza,
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
  $result = $stmt->fetch(PDO::FETCH_OBJ);
  $db = null;
  return $result;
}

function insertStudy($insertData) {
  $sql = "INSERT INTO Estudio (id_cliente, id_origen_orden, id_ubicacion,
    id_ejercicio, id_status, id_etapa, id_usuario_captura,
    id_usuario_valida, id_usuario_entrega,
    oficio, folio, origen_descripcion,
    ubicacion, fecha, fecha_entrega, fecha_captura,
    fecha_valida, fecha_rechaza, ip_captura,
    ip_valida, host_captura, host_valida,
    motivo_rechaza, activo)
    VALUES (:id_cliente, :id_origen_orden, :id_ubicacion,
    :id_ejercicio, :id_status, :id_etapa, :id_usuario_captura,
    :id_usuario_valida, :id_usuario_entrega,
    :oficio, :folio, :origen_descripcion,
    :ubicacion, :fecha, :fecha_entrega, SYSDATETIMEOFFSET(),
    :fecha_valida,  :fecha_rechaza, :ip_captura,
    :ip_valida, :host_captura, :host_valida,
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
    fecha_valida = :fecha_valida, fecha_actualiza = SYSDATETIMEOFFSET(),
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
    CONVERT(NVARCHAR, fecha, 126) AS fecha,
    CONVERT(NVARCHAR, fecha_captura, 126) AS fecha_captura,
    CONVERT(NVARCHAR, fecha_valida, 126) AS fecha_valida,
    CONVERT(NVARCHAR, fecha_actualiza, 126) AS fecha_actualiza,
    CONVERT(NVARCHAR, fecha_rechaza, 126) AS fecha_rechaza,
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
    CONVERT(NVARCHAR, fecha, 126) AS fecha,
    CONVERT(NVARCHAR, fecha_captura, 126) AS fecha_captura,
    CONVERT(NVARCHAR, fecha_valida, 126) AS fecha_valida,
    CONVERT(NVARCHAR, fecha_actualiza, 126) AS fecha_actualiza,
    CONVERT(NVARCHAR, fecha_rechaza, 126) AS fecha_rechaza,
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
  $i = 0;
  $l = count($orders);
  for ($i = 0; $i < $l; $i++) {
    $orders[$i]["cliente"] = getClient($orders[$i]['id_cliente']);
    $orders[$i]["estudio"] = getPlainStudy($orders[$i]['id_estudio']);
    $orders[$i]["planes"] = getPlansByOrder($orders[$i]['id_orden']);
  }
  return $orders;
}

function getPlainOrder($orderId) {
  $sql = "SELECT id_orden, id_estudio, id_cliente, id_matriz,
    id_tipo_muestreo, id_norma, id_cuerpo_receptor, id_status,
    id_usuario_captura, id_usuario_valida, id_usuario_actualiza,
    cantidad_muestras, costo_total, cuerpo_receptor, tipo_cuerpo,
    CONVERT(NVARCHAR, fecha, 126) AS fecha,
    CONVERT(NVARCHAR, fecha_captura, 126) AS fecha_captura,
    CONVERT(NVARCHAR, fecha_valida, 126) AS fecha_valida,
    CONVERT(NVARCHAR, fecha_actualiza, 126) AS fecha_actualiza,
    CONVERT(NVARCHAR, fecha_rechaza, 126) AS fecha_rechaza,
    ip_captura, ip_valida,
    ip_actualiza, host_captura, host_valida, host_actualiza,
    motivo_rechaza, comentarios, activo
    FROM Orden
    WHERE activo = 1 AND id_orden = :orderId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("orderId", $orderId);
  $stmt->execute();
  $order = $stmt->fetch(PDO::FETCH_OBJ);
  $db = null;
  return $order;
}

function getOrder($orderId) {
  $order = getPlainOrder($orderId);
  $order->cliente = getClient($order->id_cliente);
  $order->estudio = getPlainStudy($order->id_estudio);
  $plans = getPlansByOrder($orderId);
  if (count($plans) < 1)
  {
    $plans = array((object) getBlankPlan());
  }
  $order->planes = $plans;
  return $order;
}

function getStudyOrders($studyId) {
  $sql = "SELECT id_orden, id_estudio, id_cliente, id_matriz,
    id_tipo_muestreo, id_norma, id_cuerpo_receptor, id_status,
    id_usuario_captura, id_usuario_valida, id_usuario_actualiza,
    cantidad_muestras, costo_total, cuerpo_receptor, tipo_cuerpo,
    CONVERT(NVARCHAR, fecha, 126) AS fecha,
    CONVERT(NVARCHAR, fecha_captura, 126) AS fecha_captura,
    CONVERT(NVARCHAR, fecha_valida, 126) AS fecha_valida,
    CONVERT(NVARCHAR, fecha_actualiza, 126) AS fecha_actualiza,
    CONVERT(NVARCHAR, fecha_rechaza, 126) AS fecha_rechaza,
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
    cantidad_muestras, costo_total,
    cuerpo_receptor, tipo_cuerpo, fecha, fecha_captura,
    fecha_valida, fecha_rechaza, ip_captura,
    ip_valida, host_captura, host_valida,
    motivo_rechaza, comentarios, activo)
    VALUES (:id_estudio, :id_cliente, :id_matriz,
    :id_tipo_muestreo, :id_norma, :id_cuerpo_receptor,
    :id_status, :id_usuario_captura, :id_usuario_valida,
    :cantidad_muestras, :costo_total,
    :cuerpo_receptor, :tipo_cuerpo, :fecha, SYSDATETIMEOFFSET(),
    :fecha_valida, :fecha_rechaza, :ip_captura,
    :ip_valida, :host_captura, :host_valida,
    :motivo_rechaza, :comentarios, :activo)";
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
    fecha_actualiza = SYSDATETIMEOFFSET(),
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
    CONVERT(NVARCHAR, fecha, 126) AS fecha,
    CONVERT(NVARCHAR, fecha_probable, 126) AS fecha_probable,
    CONVERT(NVARCHAR, fecha_probable, 126) AS fecha_probable,
    CONVERT(NVARCHAR, fecha_calibracion, 126) AS fecha_calibracion,
    CONVERT(NVARCHAR, fecha_captura, 126) AS fecha_captura,
    CONVERT(NVARCHAR, fecha_valida, 126) AS fecha_valida,
    CONVERT(NVARCHAR, fecha_actualiza, 126) AS fecha_actualiza,
    CONVERT(NVARCHAR, fecha_rechaza, 126) AS fecha_rechaza,
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
  //$i = 0;
  //$l = count($plans);
  //for ($i = 0; $i < $l; $i++) {
  //  $plans[$i]["cliente"] = getClient($clientId);
  //  $plans[$i]["orden"] = getPlainOrder($orderId);
  //  $plans[$i]["supervisor_muestreo"] = getSamplingSupervisor($supervisorId);
  //  $plans[$i]["puntos"] = getPointsByPackage($packageId);
  //  $plans[$i]["equipos"] = getEquipmentByPlan($planId);
  //  $plans[$i]["recipientes"] = getContainersByPlan($planId);
  //  $plans[$i]["reactivos"] = getReactivesByPlan($planId);
  //  $plans[$i]["materiales"] = getMaterialsByPlan($planId);
  //  $plans[$i]["hieleras"] = getCoolersByPlan($planId);
  //}
  return $plans;
}

function getBlankPlan() {
  return array(
    "id_plan" => 0, "id_estudio" => 1,
    "id_orden" => 1, "id_ubicacion" => 1,
    "id_paquete" => 1, "id_objetivo_plan" => 1,
    "id_norma_muestreo" => 1, "id_estado" => 14,
    "id_municipio" => 14001, "id_localidad" => 140010001,
    "id_supervisor_muestreo" => 1,
    "id_supervisor_entrega" => 1, "id_supervisor_recoleccion" => 1,
    "id_supervisor_registro" => 1, "id_ayudante_entrega" => 1,
    "id_ayudante_recoleccion" => 1, "id_ayudante_registro" => 1,
    "id_responsable_calibracion" => 1,
    "id_responsable_recipientes" => 1,
    "id_responsable_reactivos" => 1, "id_responsable_material" => 1,
    "id_responsable_hieleras" => 1, "id_status" => 1,
    "id_usuario_captura" => 1, "id_usuario_valida" => 0,
    "id_usuario_actualiza" => 0, "fecha" => NULL,
    "fecha_probable" => NULL, "fecha_calibracion" => NULL,
    "fecha_captura" => NULL, "fecha_valida" => NULL,
    "fecha_actualiza" => NULL, "fecha_rechaza" => NULL,
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
    CONVERT(NVARCHAR, fecha, 126) AS fecha,
    CONVERT(NVARCHAR, fecha_probable, 126) AS fecha_probable,
    CONVERT(NVARCHAR, fecha_probable, 126) AS fecha_probable,
    CONVERT(NVARCHAR, fecha_calibracion, 126) AS fecha_calibracion,
    CONVERT(NVARCHAR, fecha_captura, 126) AS fecha_captura,
    CONVERT(NVARCHAR, fecha_valida, 126) AS fecha_valida,
    CONVERT(NVARCHAR, fecha_actualiza, 126) AS fecha_actualiza,
    CONVERT(NVARCHAR, fecha_rechaza, 126) AS fecha_rechaza,
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
    CONVERT(NVARCHAR, fecha, 126) AS fecha,
    CONVERT(NVARCHAR, fecha_probable, 126) AS fecha_probable,
    CONVERT(NVARCHAR, fecha_probable, 126) AS fecha_probable,
    CONVERT(NVARCHAR, fecha_calibracion, 126) AS fecha_calibracion,
    CONVERT(NVARCHAR, fecha_captura, 126) AS fecha_captura,
    CONVERT(NVARCHAR, fecha_valida, 126) AS fecha_valida,
    CONVERT(NVARCHAR, fecha_actualiza, 126) AS fecha_actualiza,
    CONVERT(NVARCHAR, fecha_rechaza, 126) AS fecha_rechaza,
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
  $plan = $stmt->fetch(PDO::FETCH_OBJ);
  $db = null;
  return $plan;
}

function getPlan($planId) {
  $plan = getPlainPlan($planId);
  $study = getPlainStudy($plan->id_estudio);
  $plan->cliente = getClient($study->id_cliente);
  $plan->orden = getPlainOrder($plan->id_orden);
  $samplingTypeId = $plan->orden->id_tipo_muestreo;
  $plan->tipo_muestreo = getSamplingType($samplingTypeId)->tipo_muestreo;
  $supervisorId = $plan->id_supervisor_muestreo;
  $plan->supervisor_muestreo = getSamplingEmployee($supervisorId);
  $plan->puntos = getPointsByPackage($plan->id_paquete);
  $plan->instrumentos = getInstrumentsByPlan($planId);
  $plan->preservaciones = getPreservationsByPlan($planId);
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

function getContainersByPlan($planId) {
  $sql = "SELECT id_plan_recipiente, id_recipiente, id_plan, activo
    FROM PlanRecipiente
    WHERE activo = 1 AND id_plan = :planId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("planId", $planId);
  $stmt->execute();
  $containers = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  return $containers;
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
    id_usuario_valida, fecha,
    fecha_probable, fecha_calibracion, fecha_captura,
    fecha_valida, fecha_rechaza, ip_captura,
    ip_valida, host_captura, host_valida,
    calle, numero, colonia, codigo_postal,
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
    :id_usuario_valida, :fecha,
    :fecha_probable, :fecha_calibracion, SYSDATETIMEOFFSET(),
    :fecha_valida, :fecha_rechaza, :ip_captura,
    :ip_valida, :host_captura, :host_valida,
    :calle, :numero, :colonia, :codigo_postal,
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
    fecha_valida = :fecha_valida,
    fecha_actualiza = SYSDATETIMEOFFSET(),
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
    cantidad_hieleras = :cantidad_hieleras,
    frecuencia = :frecuencia, objetivo_otro = :objetivo_otro,
    motivo_rechaza = :motivo_rechaza,
    comentarios = :comentarios, activo = :activo
    WHERE id_plan = :id_plan";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($updateData);
  $db = null;
  return $updateData["id_plan"];
}

function getSheets() {
  $sql = "SELECT id_hoja, id_estudio, id_cliente, id_orden, id_plan,
    id_paquete, id_nubes, id_direccion_corriente, id_oleaje,
    id_status, id_usuario_captura, id_usuario_valida,
    id_usuario_actualiza,
    CONVERT(NVARCHAR, fecha_muestreo, 126) AS fecha_muestreo,
    CONVERT(NVARCHAR, fecha_entrega, 126) AS fecha_entrega,
    CONVERT(NVARCHAR, fecha_captura, 126) AS fecha_captura,
    CONVERT(NVARCHAR, fecha_valida, 126) AS fecha_valida,
    CONVERT(NVARCHAR, fecha_actualiza, 126) AS fecha_actualiza,
    ip_captura, ip_valida, ip_actualiza, host_captura,
    host_valida, host_actualiza, nubes_otro, comentarios,
    motivo_rechaza, activo
    FROM Hoja
    WHERE activo = 1";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  return $result;
}

function getSheetsByPlan($planId) {
  $sql = "SELECT id_hoja, id_estudio, id_cliente, id_orden, id_plan,
    id_paquete, id_nubes, id_direccion_corriente, id_oleaje,
    id_status, id_usuario_captura, id_usuario_valida,
    id_usuario_actualiza,
    CONVERT(NVARCHAR, fecha_muestreo, 126) AS fecha_muestreo,
    CONVERT(NVARCHAR, fecha_entrega, 126) AS fecha_entrega,
    CONVERT(NVARCHAR, fecha_captura, 126) AS fecha_captura,
    CONVERT(NVARCHAR, fecha_valida, 126) AS fecha_valida,
    CONVERT(NVARCHAR, fecha_actualiza, 126) AS fecha_actualiza,
    ip_captura, ip_valida, ip_actualiza, host_captura,
    host_valida, host_actualiza, nubes_otro, comentarios,
    motivo_rechaza, activo
    FROM Hoja
    WHERE activo = 1 AND id_plan = :planId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("planId", $planId);
  $stmt->execute();
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  return $result;
}

function getBlankSheet() {
  return array(
    "id_hoja" => 0, "id_estudio" => 0, "id_cliente" => 0, "id_orden" => 0,
    "id_plan" => 0, "id_paquete" => 0, "id_nubes" => 1,
    "id_direccion_corriente" => 1, "id_oleaje" => 1, "id_status" => 1,
    "id_usuario_captura" => 0, "id_usuario_valida" => 0,
    "id_usuario_actualiza" => 0,
    "fecha_muestreo" => NULL, "fecha_entrega" => NULL,
    "fecha_captura" => NULL, "fecha_valida" => NULL,
    "fecha_actualiza" => NULL, "fecha_rechaza" => NULL,
    "ip_captura" => "", "ip_valida" => "", "ip_actualiza" => "",
    "host_captura" => "", "host_valida" => "", "host_actualiza" => "",
    "nubes_otro" => "", "comentarios" => "", "motivo_rechaza" => "",
    "activo" => 1
  );
}

function getPlainSheet($sheetId) {
  $sql = "SELECT id_hoja, id_estudio, id_cliente, id_orden, id_plan,
    id_paquete, id_nubes, id_direccion_corriente, id_oleaje,
    id_status, id_usuario_captura, id_usuario_valida,
    id_usuario_actualiza,
    CONVERT(NVARCHAR, fecha_muestreo, 126) AS fecha_muestreo,
    CONVERT(NVARCHAR, fecha_entrega, 126) AS fecha_entrega,
    CONVERT(NVARCHAR, fecha_captura, 126) AS fecha_captura,
    CONVERT(NVARCHAR, fecha_valida, 126) AS fecha_valida,
    CONVERT(NVARCHAR, fecha_actualiza, 126) AS fecha_actualiza,
    CONVERT(NVARCHAR, fecha_rechaza, 126) AS fecha_rechaza,
    ip_captura, ip_valida, ip_actualiza, host_captura,
    host_valida, host_actualiza, nubes_otro, comentarios,
    motivo_rechaza, activo
    FROM Hoja
    WHERE activo = 1 AND id_hoja = :sheetId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("sheetId", $sheetId);
  $stmt->execute();
  $sheet = $stmt->fetch(PDO::FETCH_OBJ);
  $db = null;
  return $sheet;
}

function getSheet($sheetId) {
  $i = 0;
  $l = 0;

  $sheet = getPlainSheet($sheetId);
  $sheet->orden = getPlainOrder($sheet->id_orden);
  $sheet->norma = getNorm($sheet->orden->id_norma);
  $normId = $sheet->orden->id_norma;
  $parameters = (array) getSamplingParametersByNorm($normId);
  $sheet->parametros = $parameters;
  $sheet->preservaciones = getPreservationsBySheet($sheetId);
  $samples = getSamplesBySheet($sheetId);
  $sheet->muestras = $samples;
  $l = count($samples);

  $blankSamplingResult = getBlankSamplingResult();
  $blankSamplingResult["id_usuario_captura"] =  $sheet->id_usuario_captura;
  $blankSamplingResult["id_usuario_actualiza"] =  $sheet->id_usuario_captura;

  for($i = 0; $i < $l; $i++) {
    $pointId = $sheet->muestras[$i]["id_punto"];
    $sheet->muestras[$i]["punto"] = getPoint($pointId);
    $sampleId = $sheet->muestras[$i]["id_muestra"];
    $samplingResults = getResultsBySample($sampleId);
    if (count($samplingResults) < 1) {
      $j = 0;
      $m = count($parameters);
      for ($j = 0; $j < $m; $j++) {
        $blankSamplingResult["id_muestra"] = $sampleId;
        $blankSamplingResult["id_parametro"] = $parameters[$j]["id_parametro"];
        $blankSamplingResult["id_tipo_valor"] = $parameters[$j]["id_tipo_valor"];
        $blankSamplingResult["param"] = $parameters[$j]["param"];
        $samplingResults[] = $blankSamplingResult;
      }
    }
    $sheet->muestras[$i]["resultados"] = $samplingResults;
  }
  return $sheet;
}

function insertSheet($sheetData) {
  $sql = "INSERT INTO Hoja (id_estudio, id_cliente, id_orden,
    id_plan, id_paquete, id_nubes, id_direccion_corriente,
    id_oleaje, id_status, id_usuario_captura, id_usuario_valida,
    fecha_muestreo, fecha_entrega,
    fecha_captura, fecha_valida, fecha_rechaza, ip_captura,
    ip_valida, host_captura, host_valida, nubes_otro,
    comentarios, motivo_rechaza, activo)
    VALUES (:id_estudio, :id_cliente, :id_orden, :id_plan,
    :id_paquete, :id_nubes, :id_direccion_corriente, :id_oleaje,
    :id_status, :id_usuario_captura, :id_usuario_valida,
    :fecha_muestreo, :fecha_entrega,
    SYSDATETIMEOFFSET(), :fecha_valida, :fecha_rechaza, :ip_captura,
    :ip_valida, :host_captura, :host_valida, :nubes_otro,
    :comentarios, :motivo_rechaza, :activo)";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($sheetData);
  $sheetId = $db->lastInsertId();
  $db = null;
  return $sheetId;
}

function updateSheet($updateData) {
  $sql = "UPDATE Hoja SET id_estudio = :id_estudio,
    id_cliente = :id_cliente, id_orden = :id_orden,
    id_plan = :id_plan, id_paquete = :id_paquete,
    id_nubes = :id_nubes,
    id_direccion_corriente = :id_direccion_corriente,
    id_oleaje = :id_oleaje, id_status = :id_status,
    id_usuario_valida = :id_usuario_valida,
    id_usuario_actualiza = :id_usuario_actualiza,
    fecha_muestreo = :fecha_muestreo,
    fecha_entrega = :fecha_entrega,
    fecha_valida = :fecha_valida,
    fecha_actualiza = SYSDATETIMEOFFSET(),
    fecha_rechaza = :fecha_rechaza, ip_valida = :ip_valida,
    ip_actualiza = :ip_actualiza, host_valida = :host_valida,
    host_actualiza = :host_actualiza,
    nubes_otro = :nubes_otro, comentarios = :comentarios,
    motivo_rechaza = :motivo_rechaza, activo = :activo
    WHERE id_hoja = :id_hoja";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($updateData);
  $db = null;
  return $updateData["id_hoja"];
}

function insertSheetSample($sheetData) {
  $sql = "INSERT INTO HojaMuestra (id_hoja, id_muestra)
    VALUES (:id_hoja, :id_muestra)";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($sheetData);
  $sheetSampleId = $db->lastInsertId();
  $db = null;
  return $sheetSampleId;
}

function getReceptions() {
  $sql = "SELECT id_recepcion, id_orden, id_plan, id_hoja,
    id_recepcionista, id_verificador, id_muestra_validacion,
    id_status, id_usuario_captura, id_usuario_valida,
    id_usuario_entrega, id_usuario_actualiza,
    CONVERT(NVARCHAR, fecha_entrega, 126) AS fecha_entrega,
    CONVERT(NVARCHAR, fecha_recibe, 126) AS fecha_recibe,
    CONVERT(NVARCHAR, fecha_verifica, 126) AS fecha_verifica,
    CONVERT(NVARCHAR, fecha_captura, 126) AS fecha_captura,
    CONVERT(NVARCHAR, fecha_valida, 126) AS fecha_valida,
    CONVERT(NVARCHAR, fecha_actualiza, 126) AS fecha_actualiza,
    CONVERT(NVARCHAR, fecha_rechaza, 126) AS fecha_rechaza,
    ip_captura, ip_valida, ip_actualiza,
    host_captura, host_valida, host_actualiza, comentarios,
    motivo_rechaza, activo
    FROM Recepcion
    WHERE activo = 1";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $receptions = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  return $receptions;
}

function getBlankReception() {
  return array(
    "id_recepcion" => 0,"id_orden" => 0, "id_plan" => 0, "id_hoja" => 0,
    "id_recepcionista" => 0, "id_verificador" => 0,
    "id_muestra_validacion" => 0, "id_status" => 1, "id_usuario_captura" => 0,
    "id_usuario_valida" => 0, "id_usuario_entrega" => 0,
    "id_usuario_actualiza" => 0,
    "fecha_entrega" => NULL, "fecha_recibe" => NULL, "fecha_verifica" => NULL,
    "fecha_captura" => NULL, "fecha_valida" => NULL, "fecha_actualiza" => NULL,
    "fecha_rechaza" => NULL,
    "ip_captura" => "", "ip_valida" => "", "ip_actualiza" => "",
    "host_captura" => "", "host_valida" => "", "host_actualiza" => "",
    "comentarios" => "", "motivo_rechaza" => "", "activo" => 1
  );
}

function getPlainReception($receptionId) {
  $sql = "SELECT id_recepcion, id_orden, id_plan, id_hoja,
    id_recepcionista, id_verificador, id_muestra_validacion,
    id_status, id_usuario_captura, id_usuario_valida,
    id_usuario_entrega, id_usuario_actualiza,
    CONVERT(NVARCHAR, fecha_entrega, 126) AS fecha_entrega,
    CONVERT(NVARCHAR, fecha_recibe, 126) AS fecha_recibe,
    CONVERT(NVARCHAR, fecha_verifica, 126) AS fecha_verifica,
    CONVERT(NVARCHAR, fecha_captura, 126) AS fecha_captura,
    CONVERT(NVARCHAR, fecha_valida, 126) AS fecha_valida,
    CONVERT(NVARCHAR, fecha_actualiza, 126) AS fecha_actualiza,
    CONVERT(NVARCHAR, fecha_rechaza, 126) AS fecha_rechaza,
    ip_captura, ip_valida, ip_actualiza,
    host_captura, host_valida, host_actualiza, comentarios,
    motivo_rechaza, activo
    FROM Recepcion
    WHERE activo = 1 AND id_recepcion = :receptionId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("receptionId", $receptionId);
  $stmt->execute();
  $reception = $stmt->fetch(PDO::FETCH_OBJ);
  $db = null;
  return $reception;
}

function getReceptionsByPlan($planId) {
  $sql = "SELECT id_recepcion, id_orden, id_plan, id_hoja,
    id_recepcionista, id_verificador, id_muestra_validacion,
    id_status, id_usuario_captura, id_usuario_valida,
    id_usuario_entrega, id_usuario_actualiza,
    CONVERT(NVARCHAR, fecha_entrega, 126) AS fecha_entrega,
    CONVERT(NVARCHAR, fecha_recibe, 126) AS fecha_recibe,
    CONVERT(NVARCHAR, fecha_verifica, 126) AS fecha_verifica,
    CONVERT(NVARCHAR, fecha_captura, 126) AS fecha_captura,
    CONVERT(NVARCHAR, fecha_valida, 126) AS fecha_valida,
    CONVERT(NVARCHAR, fecha_actualiza, 126) AS fecha_actualiza,
    CONVERT(NVARCHAR, fecha_rechaza, 126) AS fecha_rechaza,
    ip_captura, ip_valida, ip_actualiza,
    host_captura, host_valida, host_actualiza, comentarios,
    motivo_rechaza, activo
    FROM Recepcion
    WHERE activo = 1 AND id_plan = :planId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("planId", $planId);
  $stmt->execute();
  $receptions = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  return $receptions;
}

function getReception($receptionId) {
  $reception = getPlainReception($receptionId);
  $samples = (array) getReceptionSamples($receptionId);
  $sheetSamples = getSamplesBySheet($reception->id_hoja);
  $i = 0;
  $j = 0;
  $l = count($samples);
  $m = count($sheetSamples);
  if ($l > 1)
  {
    for ($i = 0; $i < $l; $i++) {
      for ($j = 0; $j < $m; $j++) {
        if ($samples[$i]["id_muestra"] == $sheetSamples[$j]["id_muestra"])
        {
          $samples[$i]["id_punto"] = $sheetSamples[$j]["id_punto"];
          break;
        }
      }
      $samples[$i]["punto"] = getPoint($samples[$i]["id_punto"]);
      $samples[$i]["selected"] = true;
    }
    $reception->muestras = $samples;
  }
  else
  {
    for ($j = 0; $j < $m; $j++) {
      $newSamples[] = array(
        "id_recepcion_muestra" => 0,
        "id_recepcion" => $sheetSamples[$j]["id_recepcion"],
        "id_muestra" => $sheetSamples[$j]["id_muestra"],
        "activo" => 1,
        "selected" => true,
        "punto" => getPoint($sheetSamples[$j]["id_punto"])
      );
    }
    $reception->muestras = $newSamples;
  }

  $reception->preservaciones = getReceptionPreservations($receptionId);
  $reception->areas = getReceptionAreas($receptionId);
  $reception->trabajos = getReceptionJobsByReception($receptionId);
  return $reception;
}

function insertReception($receptionData) {
  $sql = "INSERT INTO Recepcion (id_orden, id_plan, id_hoja,
    id_recepcionista, id_verificador, id_muestra_validacion,
    id_status, id_usuario_captura, id_usuario_valida, id_usuario_entrega,
    fecha_entrega, fecha_recibe, fecha_verifica, fecha_captura,
    fecha_valida, fecha_rechaza, ip_captura, ip_valida, host_captura,
    host_valida, comentarios, motivo_rechaza, activo)
    VALUES (:id_orden, :id_plan, :id_hoja,
    :id_recepcionista, :id_verificador, :id_muestra_validacion,
    :id_status, :id_usuario_captura, :id_usuario_valida, :id_usuario_entrega,
    :fecha_entrega, :fecha_recibe, :fecha_verifica, SYSDATETIMEOFFSET(),
    :fecha_valida, :fecha_rechaza, :ip_captura, :ip_valida, :host_captura,
    :host_valida, :comentarios, :motivo_rechaza, :activo)";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($receptionDataonData);
  $receptionId = $db->lastInsertId();
  $db = null;
  return $receptionId;
}

function updateReception($updateData) {
  $sql = "UPDATE Recepcion SET id_orden = :id_orden,
    id_plan = :id_plan, id_hoja = :id_hoja,
    id_recepcionista = :id_recepcionista,
    id_verificador = :id_verificador,
    id_muestra_validacion = :id_muestra_validacion,
    id_status = :id_status, id_usuario_valida = :id_usuario_valida,
    id_usuario_entrega = :id_usuario_entrega,
    id_usuario_actualiza = :id_usuario_actualiza,
    fecha_entrega = :fecha_entrega, fecha_recibe = :fecha_recibe,
    fecha_verifica = :fecha_verifica, fecha_valida = :fecha_valida,
    fecha_actualiza = SYSDATETIMEOFFSET(),
    fecha_rechaza = :fecha_rechaza,
    ip_valida = :ip_valida, ip_actualiza = :ip_actualiza,
    host_valida = :host_valida, host_actualiza = :host_actualiza,
    comentarios = :comentarios, motivo_rechaza = :motivo_rechaza,
    activo = :activo
    WHERE id_recepcion = :id_recepcion";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($updateData);
  $db = null;
  return $updateData["id_recepcion"];
}

function getAreas() {
  $sql = "SELECT id_area, id_usuario_supervisa, area,
    siglas, entrega, recibe, activo
    FROM Area
    WHERE activo = 1";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $areas = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  return $areas;
}

function getReceivingAreas() {
  $sql = "SELECT id_area, area, activo
    FROM Area
    WHERE activo = 1 AND recibe = 1";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $areas = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  return $areas;
}

function getReceptionAreas($receptionId) {
  $sql = "SELECT id_recepcion_area, id_recepcion, id_area,
    id_muestra, volumen, vigencia, recipiente, activo
    FROM RecepcionArea
    WHERE id_recepcion = :receptionId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("receptionId", $receptionId);
  $stmt->execute();
  $areas = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  $l = count($areas);
  for ($i = 0; $i < $l; $i++) {
    $areas[$i]["volumen"] = ($areas[$i]["volumen"] > 0);
    $areas[$i]["vigencia"] = ($areas[$i]["vigencia"] > 0);
    $areas[$i]["recipiente"] = ($areas[$i]["recipiente"] > 0);
    $areas[$i]["activo"] = ($areas[$i]["activo"] > 0);
  }
  return $areas;
}

function insertReceptionArea($areaData) {
  $sql = "INSERT INTO RecepcionArea (id_recepcion, id_area,
    id_muestra, volumen, vigencia, recipiente, activo)
    VALUES (:id_recepcion, :id_area,
    :id_muestra, :volumen, :vigencia, :recipiente, 1)";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($areaData);
  $receptionAreaId = $db->lastInsertId();
  $db = null;
  return $receptionAreaId;
}

function updateReceptionArea($updateData) {
  $sql = "UPDATE RecepcionArea SET id_recepcion = :id_recepcion,
    id_area = :id_area, id_muestra = :id_muestra, volumen = :volumen,
    vigencia = :vigencia, recipiente = :recipiente, activo = :activo
    WHERE id_recepcion_area = :id_recepcion_area";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($updateData);
  $db = null;
  return $updateData["id_recepcion"];
}

function disableReceptionAreas($receptionId) {
  $sql = "UPDATE RecepcionArea SET activo = 0
    WHERE id_recepcion = :receptionId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("receptionId", $receptionId);
  $stmt->execute();
  $db = null;
  return $receptionId;
}

function deleteReceptionAreas($receptionId) {
  $sql = "DELETE
    FROM RecepcionArea
    WHERE id_recepcion = :receptionId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("receptionId", $receptionId);
  $stmt->execute();
  $db = null;
  return $receptionId;
}

function getPlainJob($jobId) {
  $sql = "SELECT id_trabajo, id_plan, id_recepcion,
    id_muestra, id_muestra_duplicada, id_area, id_usuario_entrega,
    id_usuario_recibe, id_usuario_analiza, id_usuario_registra,
    id_usuario_aprueba, id_usuario_captura, id_usuario_valida,
    id_usuario_actualiza, id_status,
    CONVERT(NVARCHAR, fecha, 126) AS fecha,
    CONVERT(NVARCHAR, fecha_entrega, 126) AS fecha_entrega,
    CONVERT(NVARCHAR, fecha_recibe, 126) AS fecha_recibe,
    CONVERT(NVARCHAR, fecha_analiza, 126) AS fecha_analiza,
    CONVERT(NVARCHAR, fecha_registra, 126) AS fecha_registra,
    CONVERT(NVARCHAR, fecha_aprueba, 126) AS fecha_aprueba,
    CONVERT(NVARCHAR, fecha_captura, 126) AS fecha_captura,
    CONVERT(NVARCHAR, fecha_valida, 126) AS fecha_valida,
    CONVERT(NVARCHAR, fecha_actualiza, 126) AS fecha_actualiza,
    CONVERT(NVARCHAR, fecha_rechaza, 126) AS fecha_rechaza,
    ip_captura, ip_aprueba, ip_valida, ip_actualiza,
    host_captura, host_aprueba, host_valida, host_actualiza,
    comentarios, comentarios_calidad, activo
    FROM Trabajo
    WHERE activo = 1 AND id_trabajo = :jobId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("jobId", $jobId);
  $stmt->execute();
  $user = $stmt->fetch(PDO::FETCH_OBJ);
  $db = null;
  return $user;
}

function getJobs() {
  $sql = "SELECT id_trabajo, id_plan, id_recepcion,
    id_muestra, id_muestra_duplicada, id_area,
    id_usuario_entrega, id_usuario_recibe, id_usuario_analiza,
    id_usuario_registra, id_usuario_aprueba, id_usuario_captura,
    id_usuario_valida, id_usuario_actualiza, id_status,
    CONVERT(NVARCHAR, fecha, 126) AS fecha,
    CONVERT(NVARCHAR, fecha_entrega, 126) AS fecha_entrega,
    CONVERT(NVARCHAR, fecha_recibe, 126) AS fecha_recibe,
    CONVERT(NVARCHAR, fecha_analiza, 126) AS fecha_analiza,
    CONVERT(NVARCHAR, fecha_registra, 126) AS fecha_registra,
    CONVERT(NVARCHAR, fecha_aprueba, 126) AS fecha_aprueba,
    CONVERT(NVARCHAR, fecha_captura, 126) AS fecha_captura,
    CONVERT(NVARCHAR, fecha_valida, 126) AS fecha_valida,
    CONVERT(NVARCHAR, fecha_actualiza, 126) AS fecha_actualiza,
    CONVERT(NVARCHAR, fecha_rechaza, 126) AS fecha_rechaza,
    ip_captura, ip_aprueba, ip_valida,
    ip_actualiza, host_captura, host_aprueba,
    host_valida, host_actualiza, comentarios,
    comentarios_calidad, activo
    FROM Trabajo
    WHERE activo = 1";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  return $jobs;
}

function getBlankJob() {
  return array(
    "id_trabajo" => 0, "id_plan" => 1,
    "id_recepcion" => 1, "id_muestra" => NULL,
    "id_muestra_duplicada" => NULL, "id_area" => 1,
    "id_usuario_entrega" => 1, "id_usuario_recibe" => 1,
    "id_usuario_analiza" => 1, "id_usuario_registra" => 1,
    "id_usuario_aprueba" => 1, "id_usuario_captura" => 1,
    "id_usuario_valida" => 1, "id_usuario_actualiza" => 1,
    "id_status" => 1,
    "fecha" => NULL, "fecha_entrega" => NULL,
    "fecha_recibe" => NULL, "fecha_analiza" => NULL,
    "fecha_registra" => NULL, "fecha_aprueba" => NULL,
    "fecha_captura" => NULL, "fecha_valida" => NULL,
    "fecha_actualiza" => NULL, "fecha_rechaza" => NULL,
    "ip_captura" => "", "ip_aprueba" => "",
    "ip_valida" => "", "ip_actualiza" => "",
    "host_captura" => "", "host_aprueba" => "",
    "host_valida" => "", "host_actualiza" => "",
    "comentarios" => "", "comentarios_calidad" => "",
    "activo" => 1
  );
}

function getJobsByReception($receptionId) {
  $sql = "SELECT id_trabajo, id_plan, id_recepcion,
    id_muestra, id_muestra_duplicada, id_area,
    id_usuario_entrega, id_usuario_recibe, id_usuario_analiza,
    id_usuario_registra, id_usuario_aprueba, id_usuario_captura,
    id_usuario_valida, id_usuario_actualiza, id_status,
    CONVERT(NVARCHAR, fecha, 126) AS fecha,
    CONVERT(NVARCHAR, fecha_entrega, 126) AS fecha_entrega,
    CONVERT(NVARCHAR, fecha_recibe, 126) AS fecha_recibe,
    CONVERT(NVARCHAR, fecha_analiza, 126) AS fecha_analiza,
    CONVERT(NVARCHAR, fecha_registra, 126) AS fecha_registra,
    CONVERT(NVARCHAR, fecha_aprueba, 126) AS fecha_aprueba,
    CONVERT(NVARCHAR, fecha_captura, 126) AS fecha_captura,
    CONVERT(NVARCHAR, fecha_valida, 126) AS fecha_valida,
    CONVERT(NVARCHAR, fecha_actualiza, 126) AS fecha_actualiza,
    CONVERT(NVARCHAR, fecha_rechaza, 126) AS fecha_rechaza,
    ip_captura, ip_aprueba, ip_valida,
    ip_actualiza, host_captura, host_aprueba,
    host_valida, host_actualiza, comentarios,
    comentarios_calidad, activo
    FROM Trabajo
    WHERE activo = 1 AND id_recepcion = :receptionId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("receptionId", $receptionId);
  $stmt->execute();
  $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  $l = count($jobs);
  for ($i = 0; $i < $l; $i++) {
    $jobs[$i]["selected"] = true;
  }
  return $jobs;
}

function getJobsByArea($areaId) {
  $sql = "SELECT id_trabajo, id_plan, id_recepcion,
    id_muestra, id_muestra_duplicada, id_area,
    id_usuario_entrega, id_usuario_recibe, id_usuario_analiza,
    id_usuario_registra, id_usuario_aprueba, id_usuario_captura,
    id_usuario_valida, id_usuario_actualiza, id_status,
    CONVERT(NVARCHAR, fecha, 126) AS fecha,
    CONVERT(NVARCHAR, fecha_entrega, 126) AS fecha_entrega,
    CONVERT(NVARCHAR, fecha_recibe, 126) AS fecha_recibe,
    CONVERT(NVARCHAR, fecha_analiza, 126) AS fecha_analiza,
    CONVERT(NVARCHAR, fecha_registra, 126) AS fecha_registra,
    CONVERT(NVARCHAR, fecha_aprueba, 126) AS fecha_aprueba,
    CONVERT(NVARCHAR, fecha_captura, 126) AS fecha_captura,
    CONVERT(NVARCHAR, fecha_valida, 126) AS fecha_valida,
    CONVERT(NVARCHAR, fecha_actualiza, 126) AS fecha_actualiza,
    CONVERT(NVARCHAR, fecha_rechaza, 126) AS fecha_rechaza,
    ip_captura, ip_aprueba, ip_valida,
    ip_actualiza, host_captura, host_aprueba,
    host_valida, host_actualiza, comentarios,
    comentarios_calidad, activo
    FROM Trabajo
    WHERE activo = 1 AND id_area = :areaId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("areaId", $areaId);
  $stmt->execute();
  $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  return $jobs;
}

function getJobsByUser($userId) {
  $user = getUser($userId);
  if ($user->id_nivel < 3 || $user->id_area > 3) {
    return getJobs();
  }
  return getJobsByArea($user->id_area);
}

function getJob($jobId) {
  $job = getPlainJob($jobId);
  $job->muestras = getJobSamples($jobId);
  $job->parametros = array();
  $job->resultados = array();
  return $job;
}

function insertJob($jobData) {
  $sql = "INSERT INTO Trabajo (id_plan, id_recepcion,
    id_muestra, id_muestra_duplicada, id_area,
    id_usuario_entrega, id_usuario_recibe, id_usuario_analiza,
    id_usuario_registra, id_usuario_aprueba, id_usuario_captura,
    id_usuario_valida, id_status, fecha,
    fecha_entrega, fecha_recibe, fecha_analiza,
    fecha_registra, fecha_aprueba, fecha_captura,
    fecha_valida, fecha_rechaza,
    ip_captura, ip_aprueba, ip_valida,
    host_captura, host_aprueba,
    host_valida, comentarios,
    comentarios_calidad, activo)
    VALUES (:id_plan, :id_recepcion,
    :id_muestra, :id_muestra_duplicada, :id_area,
    :id_usuario_entrega, :id_usuario_recibe, :id_usuario_analiza,
    :id_usuario_registra, :id_usuario_aprueba, :id_usuario_captura,
    :id_usuario_valida, :id_status, :fecha,
    :fecha_entrega, :fecha_recibe, :fecha_analiza,
    :fecha_registra, :fecha_aprueba, SYSDATETIMEOFFSET(),
    :fecha_valida, :fecha_rechaza,
    :ip_captura, :ip_aprueba, :ip_valida,
    :host_captura, :host_aprueba,
    :host_valida, :comentarios,
    :comentarios_calidad, :activo)";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($jobData);
  $jobId = $db->lastInsertId();
  $db = null;
  return $jobId;
}

function updateJob($updateData) {
  $sql = "UPDATE Trabajo SET id_plan = :id_plan,
    id_recepcion = :id_recepcion, id_muestra = :id_muestra,
    id_muestra_duplicada = :id_muestra_duplicada, id_area = :id_area,
    id_usuario_entrega = :id_usuario_entrega,
    id_usuario_recibe = :id_usuario_recibe,
    id_usuario_analiza = :id_usuario_analiza,
    id_usuario_registra = :id_usuario_registra,
    id_usuario_aprueba = :id_usuario_aprueba,
    id_usuario_valida = :id_usuario_valida,
    id_usuario_actualiza = :id_usuario_actualiza,
    id_status = :id_status,
    fecha = :fecha,
    fecha_entrega = :fecha_entrega, fecha_recibe = :fecha_recibe,
    fecha_analiza = :fecha_analiza, fecha_registra = :fecha_registra,
    fecha_aprueba = :fecha_aprueba, fecha_valida = :fecha_valida,
    fecha_actualiza = :SYSDATETIMEOFFSET(),
    fecha_rechaza = :fecha_rechaza,
    ip_aprueba = :ip_aprueba, ip_actualiza = :ip_actualiza,
    ip_valida = :ip_valida, host_aprueba = :host_aprueba,
    host_actualiza = :host_actualiza, host_valida = :host_valida,
    comentarios = :comentarios,
    comentarios_calidad = :comentarios_calidad, activo = :activo
    WHERE id_trabajo = :jobId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($updateData);
  $db = null;
  return $updateData["id_trabajo"];
}

function disableJobsByReception($receptionId) {
  $sql = "UPDATE Trabajo SET activo = 0
    WHERE id_recepcion = :receptionId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("receptionId", $receptionId);
  $stmt->execute();
  $db = null;
  return $receptionId;
}

function getJobSamples($jobId) {
  $sql = "SELECT id_trabajo_muestra, id_trabajo, id_muestra, activo
    FROM TrabajoMuestra
    WHERE activo = 1 AND id_trabajo = :jobId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("jobId", $jobId);
  $stmt->execute();
  $samples = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  $l = count($samples);
  for ($i = 0; $i < $l; $i++) {
    $samples[$i]["selected"] = true;
  }
  return $samples;
}

function getReceptionJobs($receptionId) {
  $sql = "SELECT id_recepcion_trabajo, id_recepcion, id_trabajo, activo
    FROM RecepcionTrabajo
    WHERE activo = 1 AND id_recepcion = :receptionId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("receptionId", $receptionId);
  $stmt->execute();
  $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  $l = count($jobs);
  for ($i = 0; $i < $l; $i++) {
    $jobs[$i]["selected"] = true;
  }
  return $jobs;
}

function getReceptionJobsByReception($receptionId) {
  $sql = "SELECT id_recepcion_trabajo, id_recepcion, id_trabajo, id_area,
    activo, area, fecha_entrega
    FROM viewTrabajoRecepcion
    WHERE activo = 1 AND id_recepcion = :receptionId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("receptionId", $receptionId);
  $stmt->execute();
  $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  $l = count($jobs);
  for ($i = 0; $i < $l; $i++) {
    $jobs[$i]["selected"] = true;
  }
  return $jobs;
}

function insertReceptionJob($jobData) {
  $sql = "INSERT INTO RecepcionTrabajo (id_recepcion, id_trabajo)
    VALUES (:id_recepcion, :id_trabajo)";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($jobData);
  $receptionJobId = $db->lastInsertId();
  $db = null;
  return $receptionJobId;
}

function updateReceptionJob($updateData) {
  $sql = "UPDATE RecepcionTrabajo SET id_recepcion = :id_recepcion,
    id_trabajo = :id_trabajo, activo = :activo
    WHERE id_recepcion_trabajo = :id_recepcion_trabajo";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($updateData);
  $db = null;
  return $updateData["id_recepcion"];
}

function disableReceptionJobs($receptionId) {
  $sql = "UPDATE RecepcionTrabajo SET activo = 0
    WHERE id_recepcion = :receptionId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("receptionId", $receptionId);
  $stmt->execute();
  $db = null;
  return $receptionId;
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
    CONVERT(NVARCHAR, fecha_captura, 126) AS fecha_captura,
    CONVERT(NVARCHAR, fecha_actualiza, 126) AS fecha_actualiza,
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
    CONVERT(NVARCHAR, fecha_captura, 126) AS fecha_captura,
    CONVERT(NVARCHAR, fecha_actualiza, 126) AS fecha_actualiza,
    ip_captura, ip_actualiza, host_captura, host_actualiza,
    comentarios, activo
    FROM Punto
    WHERE activo = 1 AND id_punto = :pointId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("pointId", $pointId);
  $stmt->execute();
  $point = $stmt->fetch(PDO::FETCH_OBJ);
  $db = null;
  return $point;
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
    CONVERT(NVARCHAR, fecha_captura, 126) AS fecha_captura,
    CONVERT(NVARCHAR, fecha_actualiza, 126) AS fecha_actualiza,
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
  $method = $stmt->fetch(PDO::FETCH_OBJ);
  $db = null;
  return $method;
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
    CONVERT(NVARCHAR, fecha_captura, 126) AS fecha_captura,
    CONVERT(NVARCHAR, fecha_actualiza, 126) AS fecha_actualiza,
    ip_captura, ip_actualiza,
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
    id_ubicacion, id_punto,
    CONVERT(NVARCHAR, fecha_muestreo, 126) AS fecha_muestreo,
    CONVERT(NVARCHAR, fecha_recibe, 126) AS fecha_recibe,
    comentarios, activo
    FROM Muestra
    WHERE activo = 1";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $samples = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  return $samples;
}

function getBlankSample() {
  return array(
    "id_muestra" => 0, "id_estudio" => 0,
    "id_cliente" => 0, "id_orden" => 0,
    "id_plan" => 0, "id_hoja" => 0,
    "id_recepcion" => 0, "id_custodia" => 0,
    "id_paquete" => 0, "id_ubicacion" => 0,
    "id_punto" => 0, "fecha_muestreo" => NULL,
    "fecha_recibe" => NULL, "comentarios" => "",
    "activo" => 1
  );
}

function getSamplesBySheet($sheetId) {
  $sql = "SELECT id_muestra, id_estudio, id_cliente, id_orden,
    id_plan, id_hoja, id_recepcion, id_custodia, id_paquete,
    id_ubicacion, id_punto,
    CONVERT(NVARCHAR, fecha_muestreo, 126) AS fecha_muestreo,
    CONVERT(NVARCHAR, fecha_recibe, 126) AS fecha_recibe,
    comentarios, activo
    FROM Muestra
    WHERE activo = 1 AND id_hoja = :sheetId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("sheetId", $sheetId);
  $stmt->execute();
  $samples = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  return $samples;
}

function getSamplesByReception($receptionId) {
  $sql = "SELECT id_muestra, id_estudio, id_cliente, id_orden,
    id_plan, id_hoja, id_recepcion, id_custodia, id_paquete,
    id_ubicacion, id_punto,
    CONVERT(NVARCHAR,fecha_muestreo, 126) AS fecha_muestreo,
    CONVERT(NVARCHAR, fecha_recibe, 126) AS fecha_recibe,
    comentarios, activo
    FROM Muestra
    WHERE id_recepcion = :receptionId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("receptionId", $receptionId);
  $stmt->execute();
  $samples = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  $l = count($samples);
  for ($i = 0; $i < $l; $i++) {
    $samples[$i]["selected"] = false;
    if ($samples[$i]["activo"] > 0) {
      $samples[$i]["selected"] = true;
    }
  }
  return $samples;
}

function insertSample($sampleData) {
  $sql = "INSERT INTO Muestra (id_estudio, id_cliente, id_orden,
    id_plan, id_hoja, id_recepcion, id_custodia,
    id_paquete, id_ubicacion, id_punto, fecha_muestreo,
    fecha_recibe, comentarios, activo)
    VALUES (:id_estudio, :id_cliente, :id_orden,
    :id_plan, :id_hoja, :id_recepcion, :id_custodia,
    :id_paquete, :id_ubicacion, :id_punto, :fecha_muestreo,
    :fecha_recibe, :comentarios, :activo)";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($sampleData);
  $sampleId = $db->lastInsertId();
  $db = null;
  return $sampleId;
}

function getReceptionSamples($receptionId) {
  $sql = "SELECT id_recepcion_muestra, id_recepcion, id_muestra, activo
    FROM RecepcionMuestra
    WHERE activo = 1 AND id_recepcion = :receptionId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("receptionId", $receptionId);
  $stmt->execute();
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  return $results;
}

function insertReceptionSample($receptionData) {
  $sql = "INSERT INTO RecepcionMuestra (id_recepcion, id_muestra, activo)
    VALUES (:id_recepcion, :id_muestra, 1)";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($receptionData);
  $receptionSampleId = $db->lastInsertId();
  $db = null;
  return $receptionSampleId;
}

function deleteReceptionSamples($receptionId) {
  $sql = "DELETE
    FROM RecepcionMuestra
    WHERE id_recepcion = :receptionId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("receptionId", $receptionId);
  $stmt->execute();
  $db = null;
  return $receptionId;
}

function disableReceptionSamples($receptionId) {
  $sql = "UPDATE RecepcionMuestra SET activo = 0
    WHERE id_recepcion = :receptionId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("receptionId", $receptionId);
  $stmt->execute();
  $db = null;
  return $receptionId;
}

function updateReceptionSample($updateData) {
  $sql = "UPDATE RecepcionMuestra SET id_recepcion = :id_recepcion,
    id_muestra = :id_muestra, activo = :activo
    WHERE id_recepcion_muestra = :id_recepcion_muestra";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($updateData);
  $db = null;
  return $updateData["id_recepcion_muestra"];
}

function getResultsBySheet($sheetId) {
  $sql = "SELECT id_resultado, id_muestra, id_parametro,
    id_tipo_resultado, id_tipo_valor, id_usuario_captura,
    id_usuario_actualiza, valor,
    CONVERT(NVARCHAR, fecha_captura, 126) AS fecha_captura,
    CONVERT(NVARCHAR, fecha_actualiza, 126) AS  fecha_actualiza,
    activo, param
    FROM viewResultadoHoja
    WHERE activo = 1 AND id_hoja = :sheetId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("sheetId", $sheetId);
  $stmt->execute();
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  return $results;
}

function getResultsBySample($sampleId) {
  $sql = "SELECT id_resultado, id_muestra, id_parametro,
    id_tipo_resultado, id_tipo_valor, id_usuario_captura,
    id_usuario_actualiza, valor,
    CONVERT(NVARCHAR, fecha_captura, 126) AS fecha_captura,
    CONVERT(NVARCHAR, fecha_actualiza, 126) AS  fecha_actualiza,
    activo, param
    FROM viewResultadoParametro
    WHERE activo = 1 AND id_muestra = :sampleId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("sampleId", $sampleId);
  $stmt->execute();
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  return $results;
}

function getBlankSamplingResult() {
  return array(
    "id_resultado" => 0, "id_muestra" => 0, "id_parametro" => 0,
    "id_tipo_resultado" => 1, "id_tipo_valor" => 1,
    "id_usuario_captura" => 0, "id_usuario_actualiza" => 0,
    "valor" => 0, "fecha_captura" => NULL, "fecha_actualiza" => NULL,
    "activo" => 1, "param" => "",
  );
}

function getSamplingResultsBySample($sampleId) {
  $sql = "SELECT id_resultado, id_muestra, id_parametro,
    id_tipo_resultado, id_tipo_valor, id_usuario_captura,
    id_usuario_actualiza, valor,
    CONVERT(NVARCHAR, fecha_captura, 126) AS fecha_captura,
    CONVERT(NVARCHAR, fecha_actualiza, 126) AS  fecha_actualiza,
    activo, param
    FROM viewResultadoMuestreoMuestra
    WHERE activo = 1 AND id_muestra = :sampleId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("sampleId", $sampleId);
  $stmt->execute();
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  return $results;
}

function getInstruments() {
  $sql = "SELECT id_instrumento, id_usuario_captura,
    id_usuario_actualiza, instrumento, descripcion, muestreo,
    laboratorio, inventario, bitacora, folio,
    CONVERT(NVARCHAR, fecha_captura, 126) AS fecha_captura,
    CONVERT(NVARCHAR, fecha_actualiza, 126) AS  fecha_actualiza,
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
    WHERE activo = 1 AND id_plan = :planId";
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
  $parameter = $stmt->fetch(PDO::FETCH_OBJ);
  $db = null;
  return $parameter;
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
  $parameters = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  return $parameters;
}

function getSamplingParametersByNorm($normId) {
  $sql = "SELECT id_parametro, id_tipo_matriz, id_area,
    id_tipo_preservacion, id_metodo, id_unidad, id_tipo_valor,
    parametro, param, caducidad, limite_entrega, acreditado,
    precio, activo, id_norma, '' AS valor
    FROM viewParametroNorma
    WHERE id_area = 4 AND id_norma = :normId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("normId", $normId);
  $stmt->execute();
  $parameters = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  return $parameters;
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
  $norm = $stmt->fetch(PDO::FETCH_OBJ);
  $db = null;
  return $norm;
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
  $samplingType = $stmt->fetch(PDO::FETCH_OBJ);
  $db = null;
  return $samplingType;
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
  $matrix = $stmt->fetch(PDO::FETCH_OBJ);
  $db = null;
  return $matrix;
}

function getContainers() {
  $sql = "SELECT id_recipiente, id_plan, id_recepcion, id_muestra,
    id_tipo_recipiente, id_preservacion, id_almacenamiento,
    id_status_recipiente, id_usuario_captura, id_usuario_actualiza,
    volumen, volumen_inicial,
        CONVERT(NVARCHAR, fecha_captura, 126) AS fecha_captura,
    CONVERT(NVARCHAR, fecha_actualiza, 126) AS  fecha_actualiza,
    ip_captura, ip_actualiza, host_captura, host_actualiza, activo
    FROM Recipiente
    WHERE activo = 1";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $containers = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  return $containers;
}

function getContainer($containerId) {
  $sql = "SELECT id_recipiente, id_plan, id_recepcion, id_muestra,
    id_tipo_recipiente, id_preservacion, id_almacenamiento,
    id_status_recipiente, id_usuario_captura, id_usuario_actualiza,
    volumen, volumen_inicial,
        CONVERT(NVARCHAR, fecha_captura, 126) AS fecha_captura,
    CONVERT(NVARCHAR, fecha_actualiza, 126) AS  fecha_actualiza,
    ip_captura, ip_actualiza, host_captura, host_actualiza, activo
    FROM Recipiente
    WHERE activo = 1 AND id_recipiente = :containerId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("containerId", $containerId);
  $stmt->execute();
  $container = $stmt->fetch(PDO::FETCH_OBJ);
  $db = null;
  return $container;
}

function getPlanContainers($planId) {
  $sql = "SELECT id_recipiente, id_plan, id_recepcion, id_muestra,
    id_tipo_recipiente, id_preservacion, id_almacenamiento,
    id_status_recipiente, id_usuario_captura, id_usuario_actualiza,
    volumen, volumen_inicial
        CONVERT(NVARCHAR, fecha_captura, 126) AS fecha_captura,
    CONVERT(NVARCHAR, fecha_actualiza, 126) AS  fecha_actualiza,
    ip_captura, ip_actualiza, host_captura, host_actualiza, activo
    FROM Recipiente
    WHERE activo = 1 AND id_plan = :planId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("planId", $planId);
  $stmt->execute();
  $containers = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  return $containers;
}

function insertContainer($containerData) {
  $sql = "INSERT INTO Recipiente (id_plan, id_recepcion, id_muestra,
    id_tipo_recipiente, id_preservacion, id_almacenamiento,
    id_status_recipiente, id_usuario_captura,
    fecha_captura, ip_captura, host_captura, activo)
    VALUES (:id_plan, :id_recepcion, :id_muestra,
    :id_tipo_recipiente, :id_preservacion, :id_almacenamiento,
    :id_status_recipiente, :id_usuario_captura,
    SYSDATETIMEOFFSET(), :ip_captura, :host_captura, :activo)";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($containerData);
  $containerId = $db->lastInsertId();
  $db = null;
  return $containerId;
}

function updateContainer($updateData) {
  $sql = "UPDATE Recipiente SET id_plan = :id_plan,
    id_recepcion = :id_recepcion, id_muestra = :id_muestra,
    id_tipo_recipiente = :id_tipo_recipiente,
    id_preservacion = :id_preservacion,
    id_almacenamiento = :id_almacenamiento,
    id_status_recipiente = :id_status_recipiente,
    id_usuario_actualiza = :id_usuario_actualiza,
    volumen = :volumen, volumen_inicial = :volumen_inicial,
    fecha_actualiza = SYSDATETIMEOFFSET(), ip_actualiza = :ip_actualiza,
    host_actualiza = :host_actualiza, activo = :activo
    WHERE id_recipiente = :id_recipiente";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($updateData);
  $db = null;
  return $updateData["id_recipiente"];
}

function insertPlanContainer($containerData) {
  $sql = "INSERT INTO PlanRecipiente (id_plan, id_recipiente, activo)
    VALUES (:id_plan, :id_recipiente, :activo)";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($containerData);
  $containerId = $db->lastInsertId();
  $db = null;
  return $containerId;
}

function updatePlanContainer($updateData) {
  $sql = "UPDATE PlanRecipiente SET id_plan = :id_plan,
    id_recipiente = :id_recipiente, activo = :activo
    WHERE id_plan_recipiente = :id_plan_recipiente";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($updateData);
  $db = null;
  return $updateData["id_plan_recipiente"];
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

function getPreservationsByPlan($planId) {
  $sql = "SELECT id_plan_preservacion, id_plan, id_preservacion, activo
    FROM PlanPreservacion
    WHERE activo = 1 AND id_plan = :planId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("planId", $planId);
  $stmt->execute();
  $preservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  $l = count($preservations);
  for ($i = 0; $i < $l; $i++) {
    $preservations[$i]["selected"] = true;
  }
  return $preservations;
}

function insertPlanPreservation($preservationData) {
  $sql = "INSERT INTO PlanPreservacion (id_plan, id_preservacion, activo)
    VALUES (:id_plan, :id_preservacion, :activo)";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($preservationData);
  $preservationId = $db->lastInsertId();
  $db = null;
  return $preservationId;
}

function updatePlanPreservation($updateData) {
  $sql = "UPDATE PlanPreservacion SET id_plan = :id_plan,
    id_preservacion = :id_preservacion, activo = :activo
    WHERE id_plan_preservacion = :id_plan_preservacion";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($updateData);
  $db = null;
  return $updateData["id_plan_preservacion"];
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

function insertPlanReactive($reactiveData) {
  $sql = "INSERT INTO PlanReactivo (id_plan, id_reactivo,
    valor, lote, folio)
    VALUES (:id_plan, :id_reactivo,
    :valor, :lote, :folio)";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($reactiveData);
  $reactiveId = $db->lastInsertId();
  $db = null;
  return $reactiveId;
}

function deletePlanReactives($planId) {
  $sql = "DELETE
    FROM PlanReactivo
    WHERE id_plan = :planId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("planId", $planId);
  $stmt->execute();
  $db = null;
  return $planId;
}

function getMaterialsByPlan($planId) {
  $sql = "SELECT id_plan, id_plan_material, id_material,
    material, activo
    FROM viewMaterialPlan
    WHERE id_plan = :planId";
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

function insertPlanMaterial($materialData) {
  $sql = "INSERT INTO PlanMaterial (id_plan, id_material)
    VALUES (:id_plan, :id_material)";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($materialData);
  $materialId = $db->lastInsertId();
  $db = null;
  return $materialId;
}

function deletePlanMaterials($planId) {
  $sql = "DELETE
    FROM PlanMaterial
    WHERE id_plan = :planId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("planId", $planId);
  $stmt->execute();
  $db = null;
  return $planId;
}

function getCoolersByPlan($planId) {
  $sql = "SELECT id_plan, id_plan_hielera, id_hielera,
    hielera, activo
    FROM viewHieleraPlan
    WHERE id_plan = :planId";
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

function insertPlanCooler($coolerData) {
  $sql = "INSERT INTO PlanHielera (id_plan, id_hielera)
    VALUES (:id_plan, :id_hielera)";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($coolerData);
  $coolerId = $db->lastInsertId();
  $db = null;
  return $coolerId;
}

function deletePlanCoolers($planId) {
  $sql = "DELETE
    FROM PlanHielera
    WHERE id_plan = :planId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("planId", $planId);
  $stmt->execute();
  $db = null;
  return $planId;
}

function getEmployees() {
  $sql = "SELECT id_usuario, id_nivel, id_rol, id_area, id_puesto,
    interno, cea, laboratorio, supervisa, analiza, muestrea,
    nombres, apellido_paterno, apellido_materno, activo
    FROM Usuario
    WHERE activo = 1 AND laboratorio = 1";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $samplingEmployees = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  return $samplingEmployees;
}

function getSamplingEmployees() {
  $sql = "SELECT id_usuario, id_nivel, id_rol, id_area, id_puesto,
    interno, cea, laboratorio, supervisa, analiza, muestrea,
    nombres, apellido_paterno, apellido_materno,
    CONVERT(NVARCHAR, fecha_captura, 126) AS fecha_captura,
    CONVERT(NVARCHAR, fecha_actualiza, 126) AS fecha_actualiza,
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

function getSamplingEmployee($userId) {
  $sql = "SELECT id_usuario, id_nivel, id_rol, id_area, id_puesto,
    interno, cea, laboratorio, supervisa, analiza, muestrea,
    nombres, apellido_paterno, apellido_materno, activo
    FROM Usuario
    WHERE activo = 1 AND id_area = 4 AND id_usuario = :userId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("userId", $userId);
  $stmt->execute();
  $samplingEmployee = $stmt->fetch(PDO::FETCH_OBJ);
  $db = null;
  return $samplingEmployee;
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
  $sql = "SELECT id_municipio, municipio
    FROM Municipio
    WHERE id_estado = 14";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $districts = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  return $districts;
}

function getDistrict($districtId) {
  $sql = "SELECT id_municipio, municipio
    FROM Municipio
    WHERE id_municipio = :districtId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("districtId", $districtId);
  $stmt->execute();
  $district = $stmt->fetch(PDO::FETCH_OBJ);
  $db = null;
  return $district;
}

function getCitiesByDistrictId($districtId) {
  $sql = "SELECT id_municipio, id_localidad, localidad
    FROM Localidad
    WHERE id_municipio = :districtId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("districtId", $districtId);
  $stmt->execute();
  $districts = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  return $districts;
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

function getPreservationsBySheet($sheetId) {
  $sql = "SELECT id_hoja_preservacion, id_hoja, id_preservacion,
    cantidad, preservado, activo
    FROM HojaPreservacion
    WHERE activo = 1 AND id_hoja = :sheetId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("sheetId", $sheetId);
  $stmt->execute();
  $preservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  $l = count($preservations);
  for ($i = 0; $i < $l; $i++) {
    $preservations[$i]["selected"] = true;
  }
  return $preservations;
}

function getReceptionPreservations($receptionId) {
  $sql = "SELECT id_recepcion_preservacion, id_recepcion,
    id_preservacion, cantidad, activo
    FROM RecepcionPreservacion
    WHERE activo = 1 AND id_recepcion = :receptionId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("receptionId", $receptionId);
  $stmt->execute();
  $preservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  $l = count($preservations);
  for ($i = 0; $i < $l; $i++) {
    $preservations[$i]["selected"] = true;
  }
  return $preservations;
}

function insertReceptionPreservation($preservationData) {
  $sql = "INSERT INTO RecepcionPreservacion (id_recepcion,
    id_preservacion, cantidad, activo)
    VALUES (:id_recepcion, :id_preservacion,
    :cantidad, 1)";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($preservationData);
  $receptionPreservationId = $db->lastInsertId();
  $db = null;
  return $receptionPreservationId;
}

function deleteReceptionPreservations($receptionId) {
  $sql = "DELETE
    FROM RecepcionPreservacion
    WHERE id_recepcion = :receptionId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("receptionId", $receptionId);
  $stmt->execute();
  $db = null;
  return $receptionId;
}

function disableReceptionPreservations($receptionId) {
  $sql = "UPDATE RecepcionPreservacion SET activo = 0
    WHERE id_recepcion = :receptionId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("receptionId", $receptionId);
  $stmt->execute();
  $db = null;
  return $receptionId;
}

function updateReceptionPreservation($updateData) {
  $sql = "UPDATE RecepcionPreservacion SET id_recepcion = :id_recepcion,
    id_preservacion = :id_preservacion, cantidad = :cantidad,
    activo = :activo
    WHERE id_recepcion_preservacion = :id_recepcion_preservacion";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($updateData);
  $db = null;
  return $updateData["id_recepcion"];
}

function insertSheetPreservation($preservationData) {
  $sql = "INSERT INTO HojaPreservacion (id_hoja, id_preservacion,
    cantidad, preservado, activo)
    VALUES (:id_hoja, :id_preservacion,
    :cantidad, :preservado, :activo)";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($preservationData);
  $preservationId = $db->lastInsertId();
  $db = null;
  return $preservationId;
}

function updateSheetPreservation($updateData) {
  $sql = "UPDATE HojaPreservacion SET id_hoja = :id_hoja,
    id_preservacion = :id_preservacion, cantidad = :cantidad,
    preservado = :preservado, activo = :activo
    WHERE id_hoja_preservacion = :id_hoja_preservacion";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($updateData);
  $db = null;
  return $updateData["id_hoja"];
}

function deleteSheetPreservations($sheetId) {
  $sql = "DELETE
    FROM HojaPreservacion
    WHERE id_hoja = :sheetId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("sheetId", $sheetId);
  $stmt->execute();
  $db = null;
  return $sheetId;
}

function insertResult($resultData) {
  $sql = "INSERT INTO Resultado (id_muestra, id_parametro,
    id_tipo_resultado, id_tipo_valor, id_usuario_captura,
    valor, fecha_captura, fecha_actualiza, activo)
    VALUES (:id_muestra, :id_parametro,
    :id_tipo_resultado, :id_tipo_valor, :id_usuario_captura,
    :valor, SYSDATETIMEOFFSET(), NULL, :activo)";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($resultData);
  $preservationId = $db->lastInsertId();
  $db = null;
  return $preservationId;
}

function updateResult($updateData) {
  $sql = "UPDATE Resultado SET id_muestra = :id_muestra,
    id_parametro = :id_parametro,
    id_tipo_resultado = :id_tipo_resultado,
    id_tipo_valor = :id_tipo_valor,
    id_usuario_actualiza = :id_usuario_actualiza,
    valor = :valor, fecha_actualiza = SYSDATETIMEOFFSET(),
    activo = :activo
    WHERE id_resultado = :id_resultado";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($updateData);
  $db = null;
  return $updateData["id_resultado"];
}

function getResultsForUpdate($resultId) {
  $sql = "SELECT
    id_muestra,
    id_parametro,
    id_tipo_resultado,
    id_tipo_valor,
    id_usuario_actualiza,
    valor, fecha_actualiza,
    activo
    FROM Resultado
    WHERE id_resultado = :resultId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("resultId", $resultId);
  $stmt->execute();
  $result = $stmt->fetchAll(PDO::FETCH_OBJ);
  $db = null;
  return $result;
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
  return $instruments;
}

function getReactives() {
  $sql = "SELECT id_reactivo, id_tipo_reactivo, reactivo,
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
