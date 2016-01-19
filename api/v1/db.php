<?php
//DB FUNCTIONS
define("DB_HOST", "localhost");
define("DB_USER", "sislab");
define("DB_PASSWORD", "sislab");
define("DB_DATA_BASE", "Sislab");

/**
 * Conecta a la base de datos, regresa una instancia de PDO
 * @return mixed $dbConnection
 */
function getConnection()
{
  $dsn = "sqlsrv:server=";
  $dsn .= DB_HOST . ";Database=";
  $dsn .= DB_DATA_BASE;
  try {
    $dbConnection = new PDO($dsn, DB_USER, DB_PASSWORD);
    $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch (PDOException $e) {
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
 * @return array $result Usuarios activos
 */
function getUsers()
{
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
  $stmt->execute();
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  return $result;
}

/**
 * Obtiene un Usuario
 * @param  int $userId Id del Usuario
 * @return stdClass $user
 */
function getUser($userId)
{
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
 * Obtiene las credenciales de un Usuario
 * @param  string $userName Nombre de Usuario
 * @param  string $userPassword Password del Usuario
 * @return stdClass $user
 */
function getUserByCredentials($userName, $userPassword)
{
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
 * Inserta un nuevo Usuario
 * @param  array $userData Datos del Usuario
 * @return int $userId Id del Usuario insertado
 */
function insertUser($userData)
{
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
 * Actualiza un Usuario
 * @param  array $updateData Array con los datos del Usuario a actualizar
 * @return int $userId Id del Usuario actualizado
 */
function updateUser($updateData)
{
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
 * @param  int $userId Id del Usuario
 * @return array $result Elementos del menu de $userId
 */
function getMenu($userId)
{
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

/**
 * @param $userId
 * @return mixed
 */
function getTasks($userId)
{
  $result = array();
  // $sql = "SELECT * FROM Tarea WHERE activo = 1";
  // $db = getConnection();
  // $stmt = $db->prepare($sql);
  // $stmt->bindParam("userId", $userId);
  // $stmt->execute();
  // $result = json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
  return $result;
}

/**
 * @return array
 */
function getBlankClient()
{
  return array(
    "id_cliente" => 0, "id_estado" => 14,
    "id_municipio" => 14039, "id_localidad" => 140390001,
    "interno" => 0, "cea" => 0,
    "tasa" => 0, "cliente" => "",
    "area" => "", "rfc" => "",
    "calle" => "", "numero" => "",
    "colonia" => "", "codigo_postal" => "",
    "telefono" => "", "fax" => "",
    "contacto" => "", "puesto_contacto" => "",
    "email" => "", "fecha_captura" => null,
    "fecha_actualiza" => null, "ip_captura" => "",
    "ip_actualiza" => "", "host_captura" => "",
    "host_actualiza" => "", "activo" => 1,
  );
}

/**
 * @return mixed
 */
function getClients()
{
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

/**
 * @param $clientId
 * @return mixed
 */
function getClient($clientId)
{
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

/**
 * @return mixed
 */
function getStudies()
{
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

/**
 * @return mixed
 */
function getBlankStudy()
{
  $blankClient = getBlankClient();
  $blankOrder = getBlankOrder();
  return array(
    "id_estudio" => 0, "id_cliente" => 0,
    "id_origen_orden" => 0, "id_ubicacion" => 1,
    "id_ejercicio" => date("Y"), "id_status" => 1,
    "id_etapa" => 1, "id_usuario_captura" => 0,
    "id_usuario_valida" => 0, "id_usuario_entrega" => 0,
    "id_usuario_actualiza" => 0, "oficio" => 0,
    "folio" => "", "origen_descripcion" => "",
    "ubicacion" => "", "fecha" => null,
    "fecha_entrega" => null, "fecha_captura" => null,
    "fecha_valida" => null, "fecha_actualiza" => null,
    "fecha_rechaza" => null,
    "ip_captura" => "", "ip_valida" => "",
    "ip_actualiza" => "", "host_captura" => "",
    "host_valida" => "", "host_actualiza" => "",
    "motivo_rechaza" => "", "activo" => 1,
    "cliente" => $blankClient,
    "ordenes" => array($blankOrder),
  );
}

/**
 * @param $studyId
 * @return mixed
 */
function getPlainStudy($studyId)
{
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

/**
 * @param $studyId
 * @return mixed
 */
function getStudy($studyId)
{
  $study = getPlainStudy($studyId);
  $study->cliente = getClient($study->id_cliente);
  $study->ordenes = getStudyOrders($studyId);
  return $study;
}

/**
 * @param $yearId
 * @return mixed
 */
function getLastStudyByYear($yearId)
{
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

/**
 * @param $insertData
 * @return mixed
 */
function insertStudy($insertData)
{
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

/**
 * @param $updateData
 * @return mixed
 */
function updateStudy($updateData)
{
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

/**
 * @return array
 */
function getBlankOrder()
{
  return array(
    "id_orden" => 0, "id_estudio" => 0,
    "id_cliente" => 0, "id_matriz" => 0,
    "id_tipo_muestreo" => 1, "id_norma" => 0,
    "id_cuerpo" => 8, "id_status" => 1,
    "id_usuario_captura" => 0, "id_usuario_valida" => 0,
    "id_usuario_actualiza" => 0, "cantidad_muestras" => 0,
    "costo_total" => 0, "cuerpo_receptor" => "",
    "tipo_cuerpo" => "", "fecha" => null,
    "fecha_captura" => null,
    "fecha_valida" => null, "fecha_actualiza" => null,
    "fecha_rechaza" => null, "ip_captura" => "",
    "ip_valida" => "", "ip_actualiza" => "",
    "host_captura" => "", "host_valida" => "",
    "host_actualiza" => "", "motivo_rechaza" => "",
    "comentarios" => "", "activo" => 1,
  );
}

/**
 * @return mixed
 */
function getOrders()
{
  $sql = "SELECT id_orden, id_estudio, id_cliente, id_matriz,
    id_tipo_muestreo, id_norma, id_cuerpo, id_status,
    id_usuario_captura, id_usuario_valida, id_usuario_actualiza,
    cantidad_muestras, costo_total, cuerpo_receptor, tipo_cuerpo,
    CONVERT(NVARCHAR, fecha, 126) AS fecha,
    CONVERT(NVARCHAR, fecha_captura, 126) AS fecha_captura,
    CONVERT(NVARCHAR, fecha_valida, 126) AS fecha_valida,
    CONVERT(NVARCHAR, fecha_actualiza, 126) AS fecha_actualiza,
    CONVERT(NVARCHAR, fecha_rechaza, 126) AS fecha_rechaza,
    ip_captura, ip_valida, ip_actualiza,
    host_captura, host_valida, host_actualiza,
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
  if ($l > 0) {
    for ($i = 0; $i < $l; $i++) {
      $orders[$i]["cliente"] = getClient($orders[$i]['id_cliente']);
      $orders[$i]["estudio"] = getPlainStudy($orders[$i]['id_estudio']);
      $orders[$i]["planes"] = getPlansByOrder($orders[$i]['id_orden']);
    }
  }
  return $orders;
}

/**
 * @param $studyId
 * @return mixed
 */
function getOrdersByStudy($studyId)
{
  $sql = "SELECT id_orden, id_estudio, id_cliente, id_matriz,
    id_tipo_muestreo, id_norma, id_cuerpo, id_status,
    id_usuario_captura, id_usuario_valida, id_usuario_actualiza,
    cantidad_muestras, costo_total, cuerpo_receptor, tipo_cuerpo,
    CONVERT(NVARCHAR, fecha, 126) AS fecha,
    CONVERT(NVARCHAR, fecha_captura, 126) AS fecha_captura,
    CONVERT(NVARCHAR, fecha_valida, 126) AS fecha_valida,
    CONVERT(NVARCHAR, fecha_actualiza, 126) AS fecha_actualiza,
    CONVERT(NVARCHAR, fecha_rechaza, 126) AS fecha_rechaza,
    ip_captura, ip_valida, ip_actualiza,
    host_captura, host_valida, host_actualiza,
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

/**
 * @param $orderId
 * @return mixed
 */
function getPlainOrder($orderId)
{
  $sql = "SELECT id_orden, id_estudio, id_cliente, id_matriz,
    id_tipo_muestreo, id_norma, id_cuerpo, id_status,
    id_usuario_captura, id_usuario_valida, id_usuario_actualiza,
    cantidad_muestras, costo_total, cuerpo_receptor, tipo_cuerpo,
    CONVERT(NVARCHAR, fecha, 126) AS fecha,
    CONVERT(NVARCHAR, fecha_captura, 126) AS fecha_captura,
    CONVERT(NVARCHAR, fecha_valida, 126) AS fecha_valida,
    CONVERT(NVARCHAR, fecha_actualiza, 126) AS fecha_actualiza,
    CONVERT(NVARCHAR, fecha_rechaza, 126) AS fecha_rechaza,
    ip_captura, ip_valida, ip_actualiza,
    host_captura, host_valida, host_actualiza,
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

/**
 * @param $orderId
 * @return mixed
 */
function getOrder($orderId)
{
  $order = getPlainOrder($orderId);
  $order->cliente = getClient($order->id_cliente);
  $order->estudio = getPlainStudy($order->id_estudio);
  $plans = getPlansByOrder($orderId);
  if (count($plans) < 1) {
    $plans = array((object) getBlankPlan());
  }
  $order->planes = $plans;
  return $order;
}

/**
 * @param $studyId
 * @return mixed
 */
function getStudyOrders($studyId)
{
  $sql = "SELECT id_orden, id_estudio, id_cliente, id_matriz,
    id_tipo_muestreo, id_norma, id_cuerpo, id_status,
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

/**
 * @param $orderData
 * @return mixed
 */
function insertOrder($orderData)
{
  $sql = "INSERT INTO Orden (id_estudio, id_cliente, id_matriz,
    id_tipo_muestreo, id_norma, id_cuerpo,
    id_status, id_usuario_captura, id_usuario_valida,
    cantidad_muestras, costo_total,
    cuerpo_receptor, tipo_cuerpo, fecha, fecha_captura,
    fecha_valida, fecha_rechaza, ip_captura,
    ip_valida, host_captura, host_valida,
    motivo_rechaza, comentarios, activo)
    VALUES (:id_estudio, :id_cliente, :id_matriz,
    :id_tipo_muestreo, :id_norma, :id_cuerpo,
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

/**
 * @param $updateData
 * @return mixed
 */
function updateOrder($updateData)
{
  $sql = "UPDATE Orden SET
    id_estudio = :id_estudio, id_cliente = :id_cliente,
    id_matriz = :id_matriz, id_tipo_muestreo = :id_tipo_muestreo,
    id_norma = :id_norma, id_cuerpo = :id_cuerpo,
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

/**
 * @param $studyId
 * @return mixed
 */
function disableStudyOrders($studyId)
{
  $sql = "UPDATE Orden SET activo = 0
    WHERE id_estudio = :studyId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("studyId", $studyId);
  $stmt->execute();
  $db = null;
  return $studyId;
}

/**
 * @return mixed
 */
function getOrderSources()
{
  $sql = "SELECT id_origen_orden, origen_orden, activo
    FROM OrigenOrden
    WHERE activo = 1";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $sources = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  return $sources;
}

/**
 * @param $sourceId
 * @return mixed
 */
function getOrderSource($sourceId)
{
  $sql = "SELECT id_origen_orden, origen_orden, activo
    FROM OrigenOrden
    WHERE activo = 1 AND id_origen_orden = :sourceId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("sourceId", $sourceId);
  $stmt->execute();
  $source = $stmt->fetch(PDO::FETCH_OBJ);
  $db = null;
  return $source;
}

/**
 * @return mixed
 */
function getPlans()
{
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
    ip_captura, ip_valida, ip_actualiza, host_captura, host_valida,
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
  return $plans;
}

/**
 * @return array
 */
function getBlankPlan()
{
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
    "id_usuario_actualiza" => 0, "fecha" => null,
    "fecha_probable" => null, "fecha_calibracion" => null,
    "fecha_captura" => null, "fecha_valida" => null,
    "fecha_actualiza" => null, "fecha_rechaza" => null,
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
    "comentarios" => "", "activo" => 1,
  );
}

/**
 * @param $orderId
 * @return mixed
 */
function getPlansByOrder($orderId)
{
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
    ip_captura, ip_valida, ip_actualiza, host_captura, host_valida,
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

/**
 * @param $planId
 * @return mixed
 */
function getPlainPlan($planId)
{
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
    ip_captura, ip_valida, ip_actualiza, host_captura, host_valida,
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

/**
 * @param $planId
 * @return mixed
 */
function getPlan($planId)
{
  $plan = getPlainPlan($planId);
  $study = getPlainStudy($plan->id_estudio);
  $plan->cliente = getClient($study->id_cliente);
  $plan->orden = getPlainOrder($plan->id_orden);
  $samplingTypeId = $plan->orden->id_tipo_muestreo;
  $plan->tipo_muestreo = getSamplingType($samplingTypeId)->tipo_muestreo;
  $supervisorId = $plan->id_supervisor_muestreo;
  $plan->supervisor_muestreo = getSamplingEmployee($supervisorId);
  $plan->puntos = getPointsByPackage($plan->id_paquete);
  $plan->instrumentos = getPlanInstruments($planId);
  $plan->preservaciones = getPreservationsByPlan($planId);
  $plan->recipientes = getContainersByPlan($planId);
  $plan->reactivos = getReactivesByPlan($planId);
  $plan->materiales = getMaterialsByPlan($planId);
  $plan->hieleras = getCoolersByPlan($planId);
  return $plan;
}

/**
 * @return mixed
 */
function getPlanObjectives()
{
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

/**
 * @param $planId
 * @return mixed
 */
function getContainersByPlan($planId)
{
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

/**
 * @param $planData
 * @return mixed
 */
function insertPlan($planData)
{
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

/**
 * @param $updateData
 * @return mixed
 */
function updatePlan($updateData)
{
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

/**
 * @param $orderId
 * @return mixed
 */
function disableOrderPlans($orderId)
{
  $sql = "UPDATE [Plan] SET activo = 0
    WHERE id_orden = :orderId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("orderId", $orderId);
  $stmt->execute();
  $db = null;
  return $orderId;
}

/**
 * @return mixed
 */
function getSheets()
{
  $sql = "SELECT id_hoja, id_estudio, id_cliente, id_orden, id_plan,
    id_paquete, id_nube, id_direccion_corriente, id_oleaje,
    id_status, id_usuario_captura, id_usuario_valida,
    id_usuario_actualiza,
    CONVERT(NVARCHAR, fecha_muestreo, 126) AS fecha_muestreo,
    CONVERT(NVARCHAR, fecha_entrega, 126) AS fecha_entrega,
    CONVERT(NVARCHAR, fecha_captura, 126) AS fecha_captura,
    CONVERT(NVARCHAR, fecha_valida, 126) AS fecha_valida,
    CONVERT(NVARCHAR, fecha_actualiza, 126) AS fecha_actualiza,
    ip_captura, ip_valida, ip_actualiza, host_captura,
    host_valida, host_actualiza, nube_otro, comentarios,
    motivo_rechaza, activo, ubicacion, id_tipo_muestreo
    FROM viewHojaUbicacion
    WHERE activo = 1";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  return $result;
}

/**
 * @param $planId
 * @return mixed
 */
function getSheetsByPlan($planId)
{
  $sql = "SELECT id_hoja, id_estudio, id_cliente, id_orden, id_plan,
    id_paquete, id_nube, id_direccion_corriente, id_oleaje,
    id_status, id_usuario_captura, id_usuario_valida,
    id_usuario_actualiza,
    CONVERT(NVARCHAR, fecha_muestreo, 126) AS fecha_muestreo,
    CONVERT(NVARCHAR, fecha_entrega, 126) AS fecha_entrega,
    CONVERT(NVARCHAR, fecha_captura, 126) AS fecha_captura,
    CONVERT(NVARCHAR, fecha_valida, 126) AS fecha_valida,
    CONVERT(NVARCHAR, fecha_actualiza, 126) AS fecha_actualiza,
    ip_captura, ip_valida, ip_actualiza, host_captura,
    host_valida, host_actualiza, nube_otro, comentarios,
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

/**
 * @return array
 */
function getBlankSheet()
{
  return array(
    "id_hoja" => 0, "id_estudio" => 0, "id_cliente" => 0, "id_orden" => 0,
    "id_plan" => 0, "id_paquete" => 0, "id_nube" => 4,
    "id_direccion_corriente" => 8, "id_oleaje" => 5, "id_status" => 1,
    "id_usuario_captura" => 0, "id_usuario_valida" => 0,
    "id_usuario_actualiza" => 0,
    "fecha_muestreo" => null, "fecha_entrega" => null,
    "fecha_captura" => null, "fecha_valida" => null,
    "fecha_actualiza" => null, "fecha_rechaza" => null,
    "ip_captura" => "", "ip_valida" => "", "ip_actualiza" => "",
    "host_captura" => "", "host_valida" => "", "host_actualiza" => "",
    "nube_otro" => "", "comentarios" => "", "motivo_rechaza" => "",
    "activo" => 1,
  );
}

/**
 * @param $sheetId
 * @return mixed
 */
function getPlainSheet($sheetId)
{
  $sql = "SELECT id_hoja, id_estudio, id_cliente, id_orden, id_plan,
    id_paquete, id_nube, id_direccion_corriente, id_oleaje,
    id_status, id_usuario_captura, id_usuario_valida,
    id_usuario_actualiza,
    CONVERT(NVARCHAR, fecha_muestreo, 126) AS fecha_muestreo,
    CONVERT(NVARCHAR, fecha_entrega, 126) AS fecha_entrega,
    CONVERT(NVARCHAR, fecha_captura, 126) AS fecha_captura,
    CONVERT(NVARCHAR, fecha_valida, 126) AS fecha_valida,
    CONVERT(NVARCHAR, fecha_actualiza, 126) AS fecha_actualiza,
    CONVERT(NVARCHAR, fecha_rechaza, 126) AS fecha_rechaza,
    ip_captura, ip_valida, ip_actualiza, host_captura,
    host_valida, host_actualiza, nube_otro, comentarios,
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

/**
 * @param $sheetId
 * @return mixed
 */
function getSheet($sheetId)
{
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
  $blankSamplingResult["id_usuario_captura"] = $sheet->id_usuario_captura;
  $blankSamplingResult["id_usuario_actualiza"] = $sheet->id_usuario_captura;

  for ($i = 0; $i < $l; $i++) {
    $pointId = $sheet->muestras[$i]["id_punto"];
    $sheet->muestras[$i]["punto"] = getPoint($pointId);
    $sampleId = $sheet->muestras[$i]["id_muestra"];
    $samplingResults = getResultsBySample($sampleId);
    if (count($samplingResults) < 1) {
      $j = 0;
      $m = count($parameters);
      for ($j = 0; $j < $m; $j++) {
        $params = (array) $parameters[$j];
        $blankSamplingResult["id_muestra"] = $sampleId;
        $blankSamplingResult["id_parametro"] = $params["id_parametro"];
        $blankSamplingResult["id_tipo_valor"] = $params["id_tipo_valor"];
        $blankSamplingResult["param"] = $params["param"];
        $samplingResults[] = $blankSamplingResult;
      }
    }
    $sheet->muestras[$i]["resultados"] = $samplingResults;
  }
  return $sheet;
}

/**
 * @param $sheetData
 * @return mixed
 */
function insertSheet($sheetData)
{
  $sql = "INSERT INTO Hoja (id_estudio, id_cliente, id_orden,
    id_plan, id_paquete, id_nube, id_direccion_corriente,
    id_oleaje, id_status, id_usuario_captura, id_usuario_valida,
    fecha_muestreo, fecha_entrega,
    fecha_captura, fecha_valida, fecha_rechaza, ip_captura,
    ip_valida, host_captura, host_valida, nube_otro,
    comentarios, motivo_rechaza, activo)
    VALUES (:id_estudio, :id_cliente, :id_orden, :id_plan,
    :id_paquete, :id_nube, :id_direccion_corriente, :id_oleaje,
    :id_status, :id_usuario_captura, :id_usuario_valida,
    :fecha_muestreo, :fecha_entrega, SYSDATETIMEOFFSET(),
    :fecha_valida, :fecha_rechaza, :ip_captura,
    :ip_valida, :host_captura, :host_valida, :nube_otro,
    :comentarios, :motivo_rechaza, :activo)";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($sheetData);
  $sheetId = $db->lastInsertId();
  $db = null;
  return $sheetId;
}

/**
 * @param $updateData
 * @return mixed
 */
function updateSheet($updateData)
{
  $sql = "UPDATE Hoja SET id_estudio = :id_estudio,
    id_cliente = :id_cliente, id_orden = :id_orden,
    id_plan = :id_plan, id_paquete = :id_paquete,
    id_nube = :id_nube,
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
    nube_otro = :nube_otro, comentarios = :comentarios,
    motivo_rechaza = :motivo_rechaza, activo = :activo
    WHERE id_hoja = :id_hoja";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($updateData);
  $db = null;
  return $updateData["id_hoja"];
}

/**
 * @param $sheetData
 * @return mixed
 */
function insertSheetSample($sheetData)
{
  $sql = "INSERT INTO HojaMuestra (id_hoja, id_muestra)
    VALUES (:id_hoja, :id_muestra)";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($sheetData);
  $sheetSampleId = $db->lastInsertId();
  $db = null;
  return $sheetSampleId;
}

/**
 * @return mixed
 */
function getReceptions()
{
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

/**
 * @param $sheetId
 * @return mixed
 */
function getReceptionsBySheet($sheetId)
{
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
    WHERE activo = 1 AND id_hoja = :sheetId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("sheetId", $sheetId);
  $stmt->execute();
  $receptions = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  return $receptions;
}

/**
 * @return array
 */
function getBlankReception()
{
  return array(
    "id_recepcion" => 0, "id_orden" => 0, "id_plan" => 0, "id_hoja" => 0,
    "id_recepcionista" => 0, "id_verificador" => 0,
    "id_muestra_validacion" => 0, "id_status" => 1, "id_usuario_captura" => 0,
    "id_usuario_valida" => 0, "id_usuario_entrega" => 0,
    "id_usuario_actualiza" => 0,
    "fecha_entrega" => null, "fecha_recibe" => null, "fecha_verifica" => null,
    "fecha_captura" => null, "fecha_valida" => null, "fecha_actualiza" => null,
    "fecha_rechaza" => null,
    "ip_captura" => "", "ip_valida" => "", "ip_actualiza" => "",
    "host_captura" => "", "host_valida" => "", "host_actualiza" => "",
    "comentarios" => "", "motivo_rechaza" => "", "activo" => 1,
  );
}

/**
 * @param $receptionId
 * @return mixed
 */
function getPlainReception($receptionId)
{
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

/**
 * @param $planId
 * @return mixed
 */
function getReceptionsByPlan($planId)
{
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

/**
 * @param $receptionId
 * @return mixed
 */
function getReception($receptionId)
{
  $reception = getPlainReception($receptionId);
  $samples = (array) getReceptionSamples($receptionId);
  $sheetSamples = getSamplesBySheet($reception->id_hoja);
  $i = 0;
  $j = 0;
  $l = count($samples);
  $m = count($sheetSamples);
  if ($l > 1) {
    for ($i = 0; $i < $l; $i++) {
      for ($j = 0; $j < $m; $j++) {
        if ($samples[$i]["id_muestra"] == $sheetSamples[$j]["id_muestra"]) {
          $samples[$i]["id_punto"] = $sheetSamples[$j]["id_punto"];
          break;
        }
      }
      $samples[$i]["punto"] = getPoint($samples[$i]["id_punto"]);
      $samples[$i]["selected"] = true;
    }
    $reception->muestras = $samples;
  } else {
    for ($j = 0; $j < $m; $j++) {
      $newSamples[] = array(
        "id_recepcion_muestra" => 0,
        "id_recepcion" => $sheetSamples[$j]["id_recepcion"],
        "id_muestra" => $sheetSamples[$j]["id_muestra"],
        "activo" => 1,
        "selected" => true,
        "punto" => getPoint($sheetSamples[$j]["id_punto"]),
      );
    }
    $reception->muestras = $newSamples;
  }

  $reception->preservaciones = getReceptionPreservations($receptionId);
  $reception->areas = getReceptionAreas($receptionId);
  $reception->trabajos = getReceptionJobsByReception($receptionId);
  $reception->custodias = getReceptionCustodiesByReception($receptionId);
  return $reception;
}

/**
 * @param $receptionData
 * @return mixed
 */
function insertReception($receptionData)
{
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
  $stmt->execute($receptionData);
  $receptionId = $db->lastInsertId();
  $db = null;
  return $receptionId;
}

/**
 * @param $updateData
 * @return mixed
 */
function updateReception($updateData)
{
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

/**
 * @return mixed
 */
function getAreas()
{
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

/**
 * @return mixed
 */
function getReceivingAreas()
{
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

/**
 * @param $receptionId
 * @return mixed
 */
function getReceptionAreas($receptionId)
{
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

/**
 * @param $areaData
 * @return mixed
 */
function insertReceptionArea($areaData)
{
  $sql = "INSERT INTO RecepcionArea (id_recepcion, id_area,
    id_muestra, volumen, vigencia, recipiente)
    VALUES (:id_recepcion, :id_area,
    :id_muestra, :volumen, :vigencia, :recipiente)";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($areaData);
  $receptionAreaId = $db->lastInsertId();
  $db = null;
  return $receptionAreaId;
}

/**
 * @param $updateData
 * @return mixed
 */
function updateReceptionArea($updateData)
{
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

/**
 * @param $receptionId
 * @return mixed
 */
function disableReceptionAreas($receptionId)
{
  $sql = "UPDATE RecepcionArea SET activo = 0
    WHERE id_recepcion = :receptionId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("receptionId", $receptionId);
  $stmt->execute();
  $db = null;
  return $receptionId;
}

/**
 * @param $receptionId
 * @return mixed
 */
function deleteReceptionAreas($receptionId)
{
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

/**
 * @param $receptionId
 * @return mixed
 */
function getCustodiesByReception($receptionId)
{
  $sql = "SELECT id_custodia, id_recepcion, id_trabajo,
    id_area, id_status, id_usuario_entrega, id_usuario_recibe,
    id_usuario_captura, id_usuario_valida,
    id_usuario_actualiza,
    CONVERT(NVARCHAR, fecha_entrega, 126) AS fecha_entrega,
    CONVERT(NVARCHAR, fecha_recibe, 126) AS fecha_recibe,
    CONVERT(NVARCHAR, fecha_captura, 126) AS fecha_captura,
    CONVERT(NVARCHAR, fecha_valida, 126) AS fecha_valida,
    CONVERT(NVARCHAR, fecha_actualiza, 126) AS fecha_actualiza,
    CONVERT(NVARCHAR, fecha_rechaza, 126) AS fecha_rechaza,
    ip_captura, ip_valida, ip_actualiza,
    host_captura, host_valida, host_actualiza, comentarios,
    motivo_rechaza, activo
    FROM Custodia
    WHERE activo = 1 AND id_recepcion = :receptionId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("receptionId", $receptionId);
  $stmt->execute();
  $custodies = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  $l = count($custodies);
  for ($i = 0; $i < $l; $i++) {
    $custodies[$i]["selected"] = true;
  }
  return $custodies;
}

/**
 * @return array
 */
function getBlankJob()
{
  return array(
    "id_trabajo" => 0, "id_plan" => 1,
    "id_recepcion" => 1, "id_custodia" => null,
    "id_area" => null, "id_muestra_duplicada" => null,
    "id_usuario_entrega" => 1, "id_usuario_recibe" => 0,
    "id_usuario_aprueba" => 1, "id_usuario_captura" => 0,
    "id_usuario_valida" => 0, "id_usuario_actualiza" => 0,
    "id_status" => 1,
    "positivo" => 0, "negativo" => 0,
    "fecha_entrega" => null, "fecha_recibe" => null,
    "fecha_aprueba" => null, "fecha_captura" => null,
    "fecha_valida" => null, "fecha_actualiza" => null,
    "fecha_rechaza" => null,
    "ip_captura" => "", "ip_aprueba" => "",
    "ip_valida" => "", "ip_actualiza" => "",
    "host_captura" => "", "host_aprueba" => "",
    "host_valida" => "", "host_actualiza" => "",
    "comentarios" => "", "comentarios_calidad" => "",
    "motivo_rechaza" => "", "activo" => 1,
  );
}

/**
 * @param $jobId
 * @return mixed
 */
function getPlainJob($jobId)
{
  $sql = "SELECT id_trabajo, id_plan, id_recepcion, id_custodia,
    id_area, id_muestra_duplicada,
    id_usuario_entrega, id_usuario_recibe, id_usuario_aprueba,
    id_usuario_captura, id_usuario_valida, id_usuario_actualiza,
    id_status, positivo, negativo,
    CONVERT(NVARCHAR, fecha_entrega, 126) AS fecha_entrega,
    CONVERT(NVARCHAR, fecha_recibe, 126) AS fecha_recibe,
    CONVERT(NVARCHAR, fecha_aprueba, 126) AS fecha_aprueba,
    CONVERT(NVARCHAR, fecha_captura, 126) AS fecha_captura,
    CONVERT(NVARCHAR, fecha_valida, 126) AS fecha_valida,
    CONVERT(NVARCHAR, fecha_actualiza, 126) AS fecha_actualiza,
    CONVERT(NVARCHAR, fecha_rechaza, 126) AS fecha_rechaza,
    ip_captura, ip_aprueba, ip_valida, ip_actualiza,
    host_captura, host_aprueba, host_valida, host_actualiza,
    comentarios, comentarios_calidad, motivo_rechaza, activo
    FROM Trabajo
    WHERE activo = 1 AND id_trabajo = :jobId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("jobId", $jobId);
  $stmt->execute();
  $job = $stmt->fetch(PDO::FETCH_OBJ);
  $db = null;
  return $job;
}

/**
 * @param $jobId
 * @return mixed
 */
function getJob($jobId)
{
  $job = getPlainJob($jobId);
  $receptionId = $job->id_recepcion;
  $job->parametros = getJobParameters($jobId);
  if (count(getJobSamples($jobId)) > 0) {
    $job->muestras = getJobSamples($jobId);
  } else {
    $receptionSamples = getReceptionSamples($receptionId);
    $i = 0;
    $l = count($receptionSamples);
    for ($i = 0; $i < $l; $i++) {
      $job->muestras[] = array(
        "id_trabajo" => 0,
        "id_muestra" => $receptionSamples[$i]["id_muestra"],
        "id_estudio" => 0,
        "id_cliente" => 0,
        "id_orden" => 0,
        "id_plan" => 0,
        "id_hoja" => 0,
        "id_recepcion" => $receptionId,
        "id_custodia" => 0,
        "id_tipo_muestreo" => 1,
        "fecha_muestreo" => 0,
        "fecha_recibe" => 0,
        "activo" => 1,
        "matriz" => 1,
        "tipo_muestreo" => 1,
      );
    }
  }
  if (count(getJobAnalysis($jobId)) > 0) {
    $job->referencias = getJobReferenceResults($jobId);
    $job->lista_analisis = getJobAnalysis($jobId);
  } else {
    $job->lista_analisis = array();
    $job->referencias = array();
  }
  return $job;
}

/**
 * @return mixed
 */
function getJobs()
{
  $sql = "SELECT id_trabajo, id_plan, id_recepcion, id_custodia,
    id_area, id_muestra_duplicada,
    id_usuario_entrega, id_usuario_recibe, id_usuario_aprueba,
    id_usuario_captura, id_usuario_valida, id_usuario_actualiza,
    id_status, positivo, negativo,
    CONVERT(NVARCHAR, fecha_entrega, 126) AS fecha_entrega,
    CONVERT(NVARCHAR, fecha_recibe, 126) AS fecha_recibe,
    CONVERT(NVARCHAR, fecha_aprueba, 126) AS fecha_aprueba,
    CONVERT(NVARCHAR, fecha_captura, 126) AS fecha_captura,
    CONVERT(NVARCHAR, fecha_valida, 126) AS fecha_valida,
    CONVERT(NVARCHAR, fecha_actualiza, 126) AS fecha_actualiza,
    CONVERT(NVARCHAR, fecha_rechaza, 126) AS fecha_rechaza,
    ip_captura, ip_aprueba, ip_valida, ip_actualiza,
    host_captura, host_aprueba, host_valida, host_actualiza,
    comentarios, comentarios_calidad, motivo_rechaza, activo
    FROM Trabajo
    WHERE activo = 1";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  return $jobs;
}

/**
 * @param $receptionId
 * @return mixed
 */
function getJobsByReception($receptionId)
{
  $sql = "SELECT id_trabajo, id_plan, id_recepcion, id_custodia,
    id_area, id_muestra_duplicada,
    id_usuario_entrega, id_usuario_recibe, id_usuario_aprueba,
    id_usuario_captura, id_usuario_valida, id_usuario_actualiza,
    id_status, positivo, negativo,
    CONVERT(NVARCHAR, fecha_entrega, 126) AS fecha_entrega,
    CONVERT(NVARCHAR, fecha_recibe, 126) AS fecha_recibe,
    CONVERT(NVARCHAR, fecha_aprueba, 126) AS fecha_aprueba,
    CONVERT(NVARCHAR, fecha_captura, 126) AS fecha_captura,
    CONVERT(NVARCHAR, fecha_valida, 126) AS fecha_valida,
    CONVERT(NVARCHAR, fecha_actualiza, 126) AS fecha_actualiza,
    CONVERT(NVARCHAR, fecha_rechaza, 126) AS fecha_rechaza,
    ip_captura, ip_aprueba, ip_valida, ip_actualiza,
    host_captura, host_aprueba, host_valida, host_actualiza,
    comentarios, comentarios_calidad, motivo_rechaza, activo
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

/**
 * @param $areaId
 * @return mixed
 */
function getJobsByArea($areaId)
{
  $sql = "SELECT id_trabajo, id_plan, id_recepcion, id_custodia,
    id_area, id_muestra_duplicada,
    id_usuario_entrega, id_usuario_recibe, id_usuario_aprueba,
    id_usuario_captura, id_usuario_valida, id_usuario_actualiza,
    id_status, positivo, negativo,
    CONVERT(NVARCHAR, fecha_entrega, 126) AS fecha_entrega,
    CONVERT(NVARCHAR, fecha_recibe, 126) AS fecha_recibe,
    CONVERT(NVARCHAR, fecha_aprueba, 126) AS fecha_aprueba,
    CONVERT(NVARCHAR, fecha_captura, 126) AS fecha_captura,
    CONVERT(NVARCHAR, fecha_valida, 126) AS fecha_valida,
    CONVERT(NVARCHAR, fecha_actualiza, 126) AS fecha_actualiza,
    CONVERT(NVARCHAR, fecha_rechaza, 126) AS fecha_rechaza,
    ip_captura, ip_aprueba, ip_valida, ip_actualiza,
    host_captura, host_aprueba, host_valida, host_actualiza,
    comentarios, comentarios_calidad, motivo_rechaza, activo
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

/**
 * @param $userId
 */
function getJobsByUser($userId)
{
  $user = getUser($userId);
  if ($user->id_nivel < 3 || $user->id_area > 3) {
    return getJobs();
  }
  return getJobsByArea($user->id_area);
}

/**
 * @param $jobData
 * @return mixed
 */
function insertJob($jobData)
{
  $sql = "INSERT INTO Trabajo (id_plan, id_recepcion, id_custodia,
    id_area, id_muestra_duplicada, id_usuario_entrega,
    id_usuario_recibe, id_usuario_aprueba, id_usuario_captura,
    id_usuario_valida, id_status, positivo, negativo, fecha_entrega,
    fecha_recibe, fecha_aprueba, fecha_captura, fecha_valida,
    fecha_rechaza, ip_captura, ip_aprueba, ip_valida, host_captura,
    host_aprueba, host_valida, comentarios, comentarios_calidad,
    motivo_rechaza, activo)
    VALUES(:id_plan, :id_recepcion, :id_custodia,
    :id_area, :id_muestra_duplicada, :id_usuario_entrega,
    :id_usuario_recibe, :id_usuario_aprueba, :id_usuario_captura,
    :id_usuario_valida, :id_status, :positivo, :negativo, :fecha_entrega,
    :fecha_recibe, :fecha_aprueba, SYSDATETIMEOFFSET(), :fecha_valida,
    :fecha_rechaza, :ip_captura, :ip_aprueba, :ip_valida, :host_captura,
    :host_aprueba, :host_valida, :comentarios, :comentarios_calidad,
    :motivo_rechaza, :activo)";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($jobData);
  $jobId = $db->lastInsertId();
  $db = null;
  return $jobId;
}

/**
 * @param $updateData
 * @return mixed
 */
function updateJob($updateData)
{
  $sql = "UPDATE Trabajo SET id_plan = :id_plan,
    id_recepcion = :id_recepcion, id_custodia = :id_custodia,
    id_area = :id_area, id_muestra_duplicada = :id_muestra_duplicada,
    id_usuario_entrega = :id_usuario_entrega,
    id_usuario_recibe = :id_usuario_recibe,
    id_usuario_aprueba = :id_usuario_aprueba,
    id_usuario_valida = :id_usuario_valida,
    id_usuario_actualiza = :id_usuario_actualiza,
    id_status = :id_status, positivo = :positivo, negativo = :negativo,
    fecha_entrega = :fecha_entrega, fecha_recibe = :fecha_recibe,
    fecha_aprueba = :fecha_aprueba, fecha_valida = :fecha_valida,
    fecha_actualiza = SYSDATETIMEOFFSET(), fecha_rechaza = :fecha_rechaza,
    ip_aprueba = :ip_aprueba, ip_valida = :ip_valida,
    ip_actualiza = :ip_actualiza,
    host_aprueba = :host_aprueba, host_valida = :host_valida,
    host_actualiza = :host_actualiza,
    comentarios = :comentarios, comentarios_calidad = :comentarios_calidad,
    motivo_rechaza = :motivo_rechaza, activo = :activo
    WHERE id_trabajo = :id_trabajo";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($updateData);
  $db = null;
  return $updateData["id_trabajo"];
}

/**
 * @param $receptionId
 * @return mixed
 */
function disableJobsByReception($receptionId)
{
  $sql = "UPDATE Trabajo SET activo = 0
    WHERE id_recepcion = :receptionId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("receptionId", $receptionId);
  $stmt->execute();
  $db = null;
  return $receptionId;
}

/**
 * @param $jobId
 * @return mixed
 */
function getJobSamples($jobId)
{
  $sql = "SELECT id_trabajo, id_muestra, id_estudio, id_cliente,
    id_orden, id_plan, id_hoja, id_recepcion, id_custodia,
    id_tipo_muestreo, fecha_muestreo, fecha_recibe, activo, matriz,
    tipo_muestreo
    FROM viewMuestraTrabajo
    WHERE activo = 1 AND id_trabajo = :jobId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("jobId", $jobId);
  $stmt->execute();
  $samples = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  return $samples;
}

/**
 * @param $jobId
 * @return mixed
 */
function getJobReferenceResults($jobId)
{
  $sql = "SELECT id_trabajo, id_resultado, id_muestra, valor, [param],
    unidad, activo
    FROM viewResultadoReferenciaTrabajo
    WHERE activo = 1 AND id_trabajo = :jobId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("jobId", $jobId);
  $stmt->execute();
  $referenceResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  return $referenceResults;
}

/**
 * @param $jobId
 * @return mixed
 */function getJobParameters($jobId)
{
  $sql = "SELECT id_trabajo, id_matriz, id_tipo_muestreo, id_norma,
    id_parametro, id_metodo, id_unidad, [param], id_tipo_valor, parametro
    FROM viewParametroTrabajo
    WHERE id_trabajo = :jobId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("jobId", $jobId);
  $stmt->execute();
  $referenceResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  return $referenceResults;
}

/**
 * @param $jobId
 * @return mixed
 */function getJobAnalysis($jobId)
{
  $sql = "SELECT id_analisis, id_trabajo, id_usuario_analiza,
    CONVERT(NVARCHAR, fecha_analiza, 126) AS fecha_analiza,
    CONVERT(NVARCHAR, fecha_aprueba, 126) AS fecha_aprueba,
    CONVERT(NVARCHAR, fecha_captura, 126) AS fecha_captura,
    CONVERT(NVARCHAR, fecha_valida, 126) AS fecha_valida,
    CONVERT(NVARCHAR, fecha_actualiza, 126) AS fecha_actualiza,
    CONVERT(NVARCHAR, fecha_rechaza, 126) AS fecha_rechaza,
    ip_captura, ip_valida, ip_actualiza,
    host_captura, host_valida, host_actualiza,
    comentarios, activo
    FROM Analisis
    WHERE id_trabajo = :jobId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("jobId", $jobId);
  $stmt->execute();
  $analysisList = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  return $analysisList;
}

// function getJobSamples($jobId)
// {
//   $sql = "SELECT id_trabajo_muestra, id_trabajo, id_muestra, activo
//     FROM TrabajoMuestra
//     WHERE activo = 1 AND id_trabajo = :jobId";
//   $db = getConnection();
//   $stmt = $db->prepare($sql);
//   $stmt->bindParam("jobId", $jobId);
//   $stmt->execute();
//   $samples = $stmt->fetchAll(PDO::FETCH_ASSOC);
//   $db = null;
//   return $samples;
// }

/**
 * @param $jobSampleData
 * @return mixed
 */
function insertJobSample($jobSampleData)
{
  $sql = "INSERT INTO TrabajoMuestra (id_trabajo, id_muestra, activo)
    VALUES(:id_trabajo, :id_muestra, :activo)";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($jobSampleData);
  $jobSampleId = $db->lastInsertId();
  $db = null;
  return $jobSampleId;
}

/**
 * @param $updateData
 * @return mixed
 */
function updateJobSample($updateData)
{
  $sql = "UPDATE TrabajoMuestra SET id_trabajo = :id_trabajo,
    id_muestra = :id_muestra, activo = :activo
    WHERE id_trabajo_muestra = :id_trabajo_muestra";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($updateData);
  $db = null;
  return $updateData["id_trabajo_muestra"];
}

/**
 * @param $jobId
 * @return mixed
 */
function disableJobSamplesByjob($jobId)
{
  $sql = "UPDATE TrabajoMuestra SET activo = 0
    WHERE id_trabajo = :jobId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("jobId", $jobId);
  $stmt->execute();
  $db = null;
  return $jobId;
}

/**
 * @param $jobId
 * @return mixed
 */
function getJobResults($jobId)
{
  $sql = "SELECT id_trabajo_resultado, id_trabajo, id_resultado, activo
    FROM TrabajoResultado
    WHERE activo = 1 AND id_trabajo = :jobId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("jobId", $jobId);
  $stmt->execute();
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  return $results;
}

/**
 * @param $jobData
 * @return mixed
 */
function insertJobResult($jobData)
{
  $sql = "INSERT INTO TrabajoResultado (id_trabajo, id_resultado, activo)
    VALUES(:id_trabajo, :id_resultado, :activo)";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($jobData);
  $jobResultId = $db->lastInsertId();
  $db = null;
  return $jobResultId;
}

/**
 * @param $updateData
 * @return mixed
 */
function updateJobResult($updateData)
{
  $sql = "UPDATE TrabajoResultado SET id_trabajo = :id_trabajo,
    id_resultado = :id_resultado, activo = :activo
    WHERE id_trabajo_resultado = :id_trabajo_resultado";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($updateData);
  $db = null;
  return $updateData["id_trabajo_resultado"];
}

/**
 * @param $jobId
 * @return mixed
 */
function disableJobResultsByjob($jobId)
{
  $sql = "UPDATE TrabajoResultado SET activo = 0
    WHERE id_trabajo = :jobId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("jobId", $jobId);
  $stmt->execute();
  $db = null;
  return $jobId;
}

/**
 * @param $receptionId
 * @return mixed
 */
function getReceptionCustodies($receptionId)
{
  $sql = "SELECT id_recepcion_custodia, id_recepcion, id_custodia, activo
    FROM RecepcionCustodia
    WHERE activo = 1 AND id_recepcion = :receptionId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("receptionId", $receptionId);
  $stmt->execute();
  $custodies = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  $l = count($custodies);
  for ($i = 0; $i < $l; $i++) {
    $custodies[$i]["selected"] = true;
  }
  return $custodies;
}

/**
 * @param $receptionId
 * @return mixed
 */
function getReceptionCustodiesByReception($receptionId)
{
  $sql = "SELECT id_recepcion_custodia, id_recepcion, id_custodia,
    id_area, activo, area,
    CONVERT(NVARCHAR, fecha_entrega, 126) AS fecha_entrega
    FROM viewCustodiaRecepcion
    WHERE activo = 1 AND id_recepcion = :receptionId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("receptionId", $receptionId);
  $stmt->execute();
  $custodies = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  $l = count($custodies);
  for ($i = 0; $i < $l; $i++) {
    $custodies[$i]["selected"] = true;
  }
  return $custodies;
}

/**
 * @param $receptionId
 * @return mixed
 */
function getReceptionJobs($receptionId)
{
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

/**
 * @param $receptionId
 * @return mixed
 */
function getReceptionJobsByReception($receptionId)
{
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

/**
 * @param $jobData
 * @return mixed
 */
function insertReceptionJob($jobData)
{
  $sql = "INSERT INTO RecepcionTrabajo (id_recepcion, id_trabajo)
    VALUES (:id_recepcion, :id_trabajo)";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($jobData);
  $receptionJobId = $db->lastInsertId();
  $db = null;
  return $receptionJobId;
}

/**
 * @param $updateData
 * @return mixed
 */
function updateReceptionJob($updateData)
{
  $sql = "UPDATE RecepcionTrabajo SET id_recepcion = :id_recepcion,
    id_trabajo = :id_trabajo, activo = :activo
    WHERE id_recepcion_trabajo = :id_recepcion_trabajo";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($updateData);
  $db = null;
  return $updateData["id_recepcion"];
}

/**
 * @param $receptionId
 * @return mixed
 */
function disableReceptionJobs($receptionId)
{
  $sql = "UPDATE RecepcionTrabajo SET activo = 0
    WHERE id_recepcion = :receptionId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("receptionId", $receptionId);
  $stmt->execute();
  $db = null;
  return $receptionId;
}

/**
 * @param $custodyData
 * @return mixed
 */
function insertReceptionCustody($custodyData)
{
  $sql = "INSERT INTO RecepcionCustodia (id_recepcion, id_custodia)
    VALUES (:id_recepcion, :id_custodia)";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($custodyData);
  $receptionCustodyId = $db->lastInsertId();
  $db = null;
  return $receptionCustodyId;
}

/**
 * @param $updateData
 * @return mixed
 */
function updateReceptionCustody($updateData)
{
  $sql = "UPDATE RecepcionCustodia SET id_recepcion = :id_recepcion,
    id_custodia = :id_custodia, activo = :activo
    WHERE id_recepcion_custodia = :id_recepcion_custodia";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($updateData);
  $db = null;
  return $updateData["id_recepcion"];
}

/**
 * @param $receptionId
 * @return mixed
 */
function disableReceptionCustodies($receptionId)
{
  $sql = "UPDATE RecepcionCustodia SET activo = 0
    WHERE id_recepcion = :receptionId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("receptionId", $receptionId);
  $stmt->execute();
  $db = null;
  return $receptionId;
}

/**
 * @return mixed
 */
function getCustodies()
{
  $sql = "SELECT id_custodia, id_recepcion, id_trabajo,
    id_area, id_status, id_usuario_entrega, id_usuario_recibe,
    id_usuario_captura, id_usuario_valida, id_usuario_actualiza, area,
    CONVERT(NVARCHAR, fecha_entrega, 126) AS fecha_entrega,
    CONVERT(NVARCHAR, fecha_recibe, 126) AS fecha_recibe,
    CONVERT(NVARCHAR, fecha_captura, 126) AS fecha_captura,
    CONVERT(NVARCHAR, fecha_valida, 126) AS fecha_valida,
    CONVERT(NVARCHAR, fecha_actualiza, 126) AS fecha_actualiza,
    CONVERT(NVARCHAR, fecha_rechaza, 126) AS fecha_rechaza,
    ip_captura, ip_valida, ip_actualiza,
    host_captura, host_valida, host_actualiza, comentarios,
    motivo_rechaza, activo
    FROM viewCustodiaArea
    WHERE activo = 1";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $custodies = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  return $custodies;
}

function getBlankCustody()
{
  return array(
    "id_custodia" => 0, "id_recepcion" => 0, "id_trabajo" => 0,
    "id_area" => 0, "id_status" => 1,
    "id_usuario_entrega" => 0, "id_usuario_recibe" => 0,
    "id_usuario_captura" => 0, "id_usuario_valida" => 0,
    "id_usuario_actualiza" => 0,
    "fecha_entrega" => null, "fecha_recibe" => null,
    "fecha_captura" => null, "fecha_valida" => null,
    "fecha_actualiza" => null, "fecha_rechaza" => null,
    "ip_captura" => "", "ip_valida" => "", "ip_actualiza" => "",
    "host_captura" => "", "host_valida" => "", "host_actualiza" => "",
    "comentarios" => "", "motivo_rechaza" => "", "activo" => 1,
  );
}

/**
 * @param $custodyId
 * @return mixed
 */
function getPlainCustody($custodyId)
{
  $sql = "SELECT id_custodia, id_recepcion, id_trabajo,
    id_area, id_status, id_usuario_entrega, id_usuario_recibe,
    id_usuario_captura, id_usuario_valida,
    id_usuario_actualiza,
    CONVERT(NVARCHAR, fecha_entrega, 126) AS fecha_entrega,
    CONVERT(NVARCHAR, fecha_recibe, 126) AS fecha_recibe,
    CONVERT(NVARCHAR, fecha_captura, 126) AS fecha_captura,
    CONVERT(NVARCHAR, fecha_valida, 126) AS fecha_valida,
    CONVERT(NVARCHAR, fecha_actualiza, 126) AS fecha_actualiza,
    CONVERT(NVARCHAR, fecha_rechaza, 126) AS fecha_rechaza,
    ip_captura, ip_valida, ip_actualiza,
    host_captura, host_valida, host_actualiza, comentarios,
    motivo_rechaza, activo
    FROM Custodia
    WHERE activo = 1 AND id_custodia = :custodyId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("custodyId", $custodyId);
  $stmt->execute();
  $custody = $stmt->fetch(PDO::FETCH_OBJ);
  $db = null;
  return $custody;
}

/**
 * @param $custodyId
 * @return mixed
 */
function getCustody($custodyId)
{
  $custody = getCustodyData($custodyId);
  $custody->containers = getCustodyContainers($custodyId);
  return $custody;
}

/**
 * @param $custodyId
 * @return mixed
 */
function getCustodyData($custodyId)
{
  $sql = "SELECT id_custodia, id_recepcion, id_trabajo,
    id_area, id_status, id_usuario_entrega, id_usuario_recibe,
    id_usuario_captura, id_usuario_valida, id_usuario_actualiza,
    CONVERT(NVARCHAR, fecha_entrega, 126) AS fecha_entrega,
    CONVERT(NVARCHAR, fecha_recibe, 126) AS fecha_recibe,
    CONVERT(NVARCHAR, fecha_captura, 126) AS fecha_captura,
    CONVERT(NVARCHAR, fecha_valida, 126) AS fecha_valida,
    CONVERT(NVARCHAR, fecha_actualiza, 126) AS fecha_actualiza,
    CONVERT(NVARCHAR, fecha_rechaza,126) AS fecha_rechaza,
    CONVERT(NVARCHAR, fecha_muestreo,126) AS fecha_muestreo,
    CONVERT(NVARCHAR, fecha_recepcion,126) AS fecha_recepcion,
    ip_captura, ip_valida, ip_actualiza,
    host_captura, host_valida, host_actualiza,
    comentarios, motivo_rechaza,
    id_matriz, matriz, cantidad_muestras, activo
    FROM viewCustodiaDatos
    WHERE id_custodia = :custodyId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("custodyId", $custodyId);
  $stmt->execute();
  $custody = $stmt->fetch(PDO::FETCH_OBJ);
  $db = null;
  return $custody;
}

/**
 * @param $custodyId
 * @return mixed
 */
function getCustodyContainers($custodyId)
{
  $sql = "SELECT id_custodia, id_recepcion, id_muestra, id_recipiente,
    id_tipo_recipiente, id_preservacion, id_tipo_preservacion,
    id_almacenamiento, id_status_recipiente,
    preservacion, tipo_preservacion, almacenamiento,
    status_recipiente,
    id_usuario_captura, id_usuario_actualiza,
    volumen, volumen_inicial,
    CONVERT(NVARCHAR, fecha_actualiza, 126) AS fecha_actualiza,
    activo
    FROM viewCustodiaRecipiente
    WHERE id_custodia = :custodyId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("custodyId", $custodyId);
  $stmt->execute();
  $containers = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  return $containers;
}

/**
 * @param $custodyData
 * @return mixed
 */
function insertCustody($custodyData)
{
  $sql = "INSERT INTO Custodia (id_recepcion, id_trabajo,
    id_area, id_status, id_usuario_entrega, id_usuario_recibe,
    id_usuario_captura, id_usuario_valida,
    fecha_entrega, fecha_recibe, fecha_captura,
    fecha_valida, fecha_rechaza,
    ip_captura, ip_valida, host_captura, host_valida,
    comentarios, motivo_rechaza, activo)
    VALUES (:id_recepcion, :id_trabajo,
    :id_area, :id_status, :id_usuario_entrega, :id_usuario_recibe,
    :id_usuario_captura, :id_usuario_valida,
    :fecha_entrega, :fecha_recibe, SYSDATETIMEOFFSET(),
    :fecha_valida, :fecha_rechaza,
    :ip_captura, :ip_valida, :host_captura, :host_valida,
    :comentarios, :motivo_rechaza, :activo)";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($custodyData);
  $custodyId = $db->lastInsertId();
  $db = null;
  return $custodyId;
}

/**
 * @param $updateData
 * @return mixed
 */
function updateCustody($updateData)
{
  $sql = "UPDATE Custodia SET id_recepcion = :id_recepcion,
    id_trabajo = :id_trabajo, id_area = :id_area,
    id_status = :id_status, id_usuario_entrega = :id_usuario_entrega,
    id_usuario_recibe = :id_usuario_recibe,
    id_usuario_valida = :id_usuario_valida,
    id_usuario_actualiza = :id_usuario_actualiza,
    fecha_entrega = :fecha_entrega, fecha_recibe = :fecha_recibe,
    fecha_actualiza = SYSDATETIMEOFFSET(),
    fecha_valida = :fecha_valida,
    fecha_rechaza = :fecha_rechaza,
    ip_valida = :ip_valida, ip_actualiza = :ip_actualiza,
    host_valida = :host_valida, host_actualiza = :host_actualiza,
    comentarios = :comentarios, motivo_rechaza = :motivo_rechaza,
    activo = :activo
    WHERE id_custodia = :id_custodia";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($updateData);
  $db = null;
  return $updateData["id_recepcion"];
}

/**
 * @return mixed
 */
function getPoints()
{
  $sql = "SELECT id_punto, id_cuerpo, id_tipo_punto,
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

/**
 * @param $pointId
 * @return mixed
 */
function getPoint($pointId)
{
  $sql = "SELECT id_punto, id_cuerpo, id_tipo_punto,
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

/**
 * @return mixed
 */
function getPackages()
{
  $sql = "SELECT id_paquete, id_ubicacion, paquete, activo
    FROM Paquete
    WHERE activo = 1";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $packages = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  return $packages;
}

/**
 * @param $locationId
 * @return mixed
 */
function getPackagesByLocation($locationId)
{
  $sql = "SELECT id_paquete, id_ubicacion, paquete, activo
    FROM Paquete
    WHERE activo = 1 AND id_ubicacion = :locationId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("locationId", $locationId);
  $stmt->execute();
  $packages = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  return $packages;
}

/**
 * @param $packageId
 * @return mixed
 */
function getPointsByPackage($packageId)
{
  $sql = "SELECT id_paquete, paquete, id_paquete_punto, id_punto,
    id_cuerpo, id_tipo_punto, id_estado, id_municipio,
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

/**
 * @return mixed
 */
function getMethods()
{
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

/**
 * @param $methodId
 * @return mixed
 */
function getMethod($methodId)
{
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

/**
 * @return mixed
 */
function getParameters()
{
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

/**
 * @return mixed
 */
function getParametersField()
{
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

/**
 * @return mixed
 */
function getParametersLab()
{
  $sql = "SELECT id_parametro, id_tipo_matriz, id_area,
    id_tipo_preservacion, id_metodo, id_unidad, id_tipo_valor,
    parametro, param, caducidad, limite_entrega, acreditado,
    precio, activo
    FROM Parametro
    WHERE activo = 1 AND id_area <> 4";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $parameters = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  return $parameters;
}

/**
 * @param $custodyId
 * @return mixed
 */
function getParametersByCustody($custodyId)
{
  $sql = "SELECT id_custodia, id_recepcion, id_orden, id_norma,
    id_parametro, id_tipo_matriz, id_area, id_tipo_preservacion,
    id_metodo, id_unidad, id_tipo_valor, parametro, [param],
    caducidad, limite_entrega, acreditado, precio
    FROM viewParametroCustodia
    WHERE id_custodia = :custodyId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("custodyId", $custodyId);
  $stmt->execute();
  $parameters = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  return $parameters;
}

/**
 * @param $normId
 * @return mixed
 */
function getParametersByNorm($normId)
{
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

/**
 * @return mixed
 */
function getReceptionists()
{
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

/**
 * @return mixed
 */
function getSamples()
{
  $sql = "SELECT id_muestra, id_estudio, id_cliente, id_orden,
    id_plan, id_hoja, id_recepcion, id_custodia, id_paquete,
    id_ubicacion, id_punto, id_tipo_muestreo,
    CONVERT(NVARCHAR, fecha_muestreo, 126) AS fecha_muestreo,
    CONVERT(NVARCHAR, fecha_recibe, 126) AS fecha_recibe,
    comentarios, activo, ubicacion
    FROM viewMuestraUbicacion
    WHERE activo = 1";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $samples = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  return $samples;
}

/**
 * @param $sampleId
 * @return mixed
 */
function getSample($sampleId)
{
  $sql = "SELECT id_muestra, id_estudio, id_cliente, id_orden,
    id_plan, id_hoja, id_recepcion, id_custodia, id_paquete,
    id_ubicacion, id_punto, id_tipo_muestreo,
    CONVERT(NVARCHAR, fecha_muestreo, 126) AS fecha_muestreo,
    CONVERT(NVARCHAR, fecha_recibe, 126) AS fecha_recibe,
    comentarios, activo
    FROM Muestra
    WHERE activo = 1 ANd id_muestra = :sampleId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("sampleId", $sampleId);
  $stmt->execute();
  $sample = $stmt->fetch(PDO::FETCH_OBJ);
  $db = null;
  return $sample;
}

function getBlankSample()
{
  return array(
    "id_muestra" => 0, "id_estudio" => 0,
    "id_cliente" => 0, "id_orden" => 0,
    "id_plan" => 0, "id_hoja" => 0,
    "id_recepcion" => 0, "id_custodia" => 0,
    "id_paquete" => 0, "id_ubicacion" => 0,
    "id_punto" => 0, "fecha_muestreo" => null,
    "fecha_recibe" => null, "comentarios" => "",
    "activo" => 1,
  );
}

/**
 * @param $sheetId
 * @return mixed
 */
function getSamplesBySheet($sheetId)
{
  $sql = "SELECT id_muestra, id_estudio, id_cliente, id_orden,
    id_plan, id_hoja, id_recepcion, id_custodia, id_paquete,
    id_ubicacion, id_punto, id_tipo_muestreo,
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

/**
 * @param $receptionId
 * @return mixed
 */
function getSamplesByReception($receptionId)
{
  $sql = "SELECT id_muestra, id_estudio, id_cliente, id_orden,
    id_plan, id_hoja, id_recepcion, id_custodia, id_paquete,
    id_ubicacion, id_punto, id_tipo_muestreo,
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

/**
 * @param $sampleData
 * @return mixed
 */
function insertSample($sampleData)
{
  $sql = "INSERT INTO Muestra (id_estudio, id_cliente, id_orden,
    id_plan, id_hoja, id_recepcion, id_custodia,
    id_paquete, id_ubicacion, id_punto, id_tipo_muestreo,
    fecha_muestreo, fecha_recibe, comentarios, activo)
    VALUES (:id_estudio, :id_cliente, :id_orden,
    :id_plan, :id_hoja, :id_recepcion, :id_custodia,
    :id_paquete, :id_ubicacion, :id_punto, :id_tipo_muestreo,
    :fecha_muestreo, :fecha_recibe, :comentarios, :activo)";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($sampleData);
  $sampleId = $db->lastInsertId();
  $db = null;
  return $sampleId;
}

/**
 * @param $updateData
 * @return mixed
 */
function updateSample($updateData)
{
  $sql = "UPDATE Muestra SET id_estudio = :id_estudio,
    id_cliente = :id_cliente, id_orden = :id_orden,
    id_plan = :id_plan, id_hoja = :id_hoja,
    id_recepcion = :id_recepcion, id_custodia = :id_custodia,
    id_paquete = :id_paquete, id_ubicacion = :id_ubicacion,
    id_punto = :id_punto, id_tipo_muestreo = :id_tipo_muestreo,
    fecha_muestreo = :fecha_muestreo, fecha_recibe = :fecha_recibe,
    comentarios = :comentarios, activo = :activo";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($updateData);
  $db = null;
  return $updateData["id_muestra"];
}

/**
 * @param $receptionId
 * @return mixed
 */
function getReceptionSamples($receptionId)
{
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

/**
 * @param $receptionData
 * @return mixed
 */
function insertReceptionSample($receptionData)
{
  $sql = "INSERT INTO RecepcionMuestra (id_recepcion, id_muestra)
    VALUES (:id_recepcion, :id_muestra)";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($receptionData);
  $receptionSampleId = $db->lastInsertId();
  $db = null;
  return $receptionSampleId;
}

/**
 * @param $receptionId
 * @return mixed
 */
function deleteReceptionSamples($receptionId)
{
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

/**
 * @param $receptionId
 * @return mixed
 */
function disableReceptionSamples($receptionId)
{
  $sql = "UPDATE RecepcionMuestra SET activo = 0
    WHERE id_recepcion = :receptionId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("receptionId", $receptionId);
  $stmt->execute();
  $db = null;
  return $receptionId;
}

/**
 * @param $updateData
 * @return mixed
 */
function updateReceptionSample($updateData)
{
  $sql = "UPDATE RecepcionMuestra SET id_recepcion = :id_recepcion,
    id_muestra = :id_muestra, activo = :activo
    WHERE id_recepcion_muestra = :id_recepcion_muestra";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($updateData);
  $db = null;
  return $updateData["id_recepcion_muestra"];
}

/**
 * @param $updateData
 * @return mixed
 */
function updateSampleReceptionId($updateData)
{
  $sql = "UPDATE Muestra SET id_recepcion = :id_recepcion
    WHERE id_muestra = :id_muestra";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($updateData);
  $db = null;
  return $updateData["id_muestra"];
}

/**
 * @param $sheetId
 * @return mixed
 */
function getResultsBySheet($sheetId)
{
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

/**
 * @param $sampleId
 * @return mixed
 */
function getResultsBySample($sampleId)
{
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

/**
 * @return array
 */
function getBlankSamplingResult()
{
  return array(
    "id_resultado" => 0, "id_muestra" => 0, "id_parametro" => 0,
    "id_tipo_resultado" => 1, "id_tipo_valor" => 1,
    "id_usuario_captura" => 0, "id_usuario_actualiza" => 0,
    "valor" => 0, "fecha_captura" => null, "fecha_actualiza" => null,
    "activo" => 1, "param" => "",
  );
}

/**
 * @param $sampleId
 * @return mixed
 */
function getSamplingResultsBySample($sampleId)
{
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

/**
 * @return mixed
 */
function getInstruments()
{
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

/**
 * @param $planId
 * @return mixed
 */
function getPlanInstruments($planId)
{
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

/**
 * @param $instrumentData
 * @return mixed
 */
function insertPlanInstrument($instrumentData)
{
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

/**
 * @param $updateData
 * @return mixed
 */
function updatePlanInstrument($updateData)
{
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

/**
 * @param $planId
 * @return mixed
 */
function disablePlanInstruments($planId)
{
  $sql = "UPDATE PlanInstrumento SET activo = 0
    WHERE id_plan = :planId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("planId", $planId);
  $db = null;
  return $planId;
}

/**
 * @param $normId
 * @return mixed
 */
function getSamplingParametersByNorm($normId)
{
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

/**
 * @return mixed
 */
function getNorms()
{
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

/**
 * @param $normId
 * @return mixed
 */
function getNorm($normId)
{
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

/**
 * @return mixed
 */
function getSamplingTypes()
{
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

/**
 * @param $samplingTypeId
 * @return mixed
 */
function getSamplingType($samplingTypeId)
{
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

/**
 * @return mixed
 */
function getMatrices()
{
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

/**
 * @param $matrixId
 * @return mixed
 */
function getMatrix($matrixId)
{
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

/**
 * @return mixed
 */
function getBlankContainer()
{
  return array(
    "id_recipiente" => 0,
    "id_plan" => 0,
    "id_recepcion" => 0,
    "id_muestra" => 0,
    "id_tipo_recipiente" => 1,
    "id_preservacion" => 1,
    "id_almacenamiento" => 1,
    "id_status_recipiente" => 1,
    "id_usuario_captura" => 0,
    "id_usuario_actualiza" => 0,
    "volumen" => 0,
    "volumen_inicial" => 0,
    "fecha_captura" => null,
    "fecha_actualiza" => null,
    "ip_captura" => "",
    "ip_actualiza" => "",
    "host_captura" => "",
    "host_actualiza" => "",
    "activo" => 1,
  );
}

/**
 * @return mixed
 */
function getContainers()
{
  $sql = "SELECT id_recipiente, id_plan, id_recepcion, id_muestra,
    id_tipo_recipiente, id_preservacion, id_almacenamiento,
    id_status_recipiente, id_usuario_captura, id_usuario_actualiza,
    volumen, volumen_inicial,
    CONVERT(NVARCHAR, fecha_captura, 126) AS fecha_captura,
    CONVERT(NVARCHAR, fecha_actualiza, 126) AS fecha_actualiza,
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

/**
 * @param $containerId
 * @return mixed
 */
function getContainer($containerId)
{
  $sql = "SELECT id_recipiente, id_plan, id_recepcion, id_muestra,
    id_tipo_recipiente, id_preservacion, id_almacenamiento,
    id_status_recipiente, id_usuario_captura, id_usuario_actualiza,
    volumen, volumen_inicial,
    CONVERT(NVARCHAR, fecha_captura, 126) AS fecha_captura,
    CONVERT(NVARCHAR, fecha_actualiza, 126) AS fecha_actualiza,
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

/**
 * @param $planId
 * @return mixed
 */
function getPlanContainers($planId)
{
  $sql = "SELECT id_recipiente, id_plan, id_recepcion, id_muestra,
    id_tipo_recipiente, id_preservacion, id_almacenamiento,
    id_status_recipiente, id_usuario_captura, id_usuario_actualiza,
    volumen, volumen_inicial,
    CONVERT(NVARCHAR, fecha_captura, 126) AS fecha_captura,
    CONVERT(NVARCHAR, fecha_actualiza, 126) AS fecha_actualiza,
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

/**
 * @param $containerData
 * @return mixed
 */
function insertContainer($containerData)
{
  $sql = "INSERT INTO Recipiente (id_plan, id_recepcion, id_muestra,
    id_tipo_recipiente, id_preservacion, id_almacenamiento,
    id_status_recipiente, id_usuario_captura, volumen, volumen_inicial,
    fecha_captura, ip_captura, host_captura, activo)
    VALUES (:id_plan, :id_recepcion, :id_muestra,
    :id_tipo_recipiente, :id_preservacion, :id_almacenamiento,
    :id_status_recipiente, :id_usuario_captura, :volumen, :volumen_inicial,
    SYSDATETIMEOFFSET(), :ip_captura, :host_captura, :activo)";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($containerData);
  $containerId = $db->lastInsertId();
  $db = null;
  return $containerId;
}

/**
 * @param $updateData
 * @return mixed
 */
function updateContainer($updateData)
{
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

/**
 * @param $updateData
 * @return mixed
 */
function updateContainerStorage($updateData)
{
  $sql = "UPDATE Recipiente SET id_almacenamiento = :id_almacenamiento,
    id_usuario_actualiza = :id_usuario_actualiza,
    fecha_actualiza = SYSDATETIMEOFFSET(), ip_actualiza = :ip_actualiza,
    host_actualiza = :host_actualiza
    WHERE id_recipiente = :id_recipiente";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($updateData);
  $db = null;
  return $updateData["id_recipiente"];
}

/**
 * @param $updateData
 * @return mixed
 */
function updateContainerReceptionId($updateData)
{
  $sql = "UPDATE Recipiente SET id_recepcion = :id_recepcion
    WHERE id_recipiente = :id_recipiente";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($updateData);
  $db = null;
  return $updateData["id_recipiente"];
}

/**
 * @param $containerData
 * @return mixed
 */
function insertPlanContainer($containerData)
{
  $sql = "INSERT INTO PlanRecipiente (id_plan, id_recipiente, activo)
    VALUES (:id_plan, :id_recipiente, :activo)";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($containerData);
  $containerId = $db->lastInsertId();
  $db = null;
  return $containerId;
}

/**
 * @param $updateData
 * @return mixed
 */
function updatePlanContainer($updateData)
{
  $sql = "UPDATE PlanRecipiente SET id_plan = :id_plan,
    id_recipiente = :id_recipiente, activo = :activo
    WHERE id_plan_recipiente = :id_plan_recipiente";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($updateData);
  $db = null;
  return $updateData["id_plan_recipiente"];
}

/**
 * @param $planId
 * @return mixed
 */
function disablePlanContainers($planId)
{
  $sql = "UPDATE PlanRecipiente SET activo = 0
    WHERE id_plan = :planId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("planId", $planId);
  $stmt->execute();
  $db = null;
  return $planId;
}

/**
 * @param $containerId
 * @return mixed
 */
function getContainerLogs($containerId)
{
  $sql = "SELECT id_historial_recipiente, id_custodia, id_muestra,
    id_recipiente, id_parametro, id_usuario_analiza, id_usuario_captura,
    id_usuario_actualiza, volumen,
    CONVERT(NVARCHAR, fecha, 126) AS fecha,
    CONVERT(NVARCHAR, fecha_captura, 126) AS fecha_captura,
    CONVERT(NVARCHAR, fecha_actualiza,126) AS fecha_actualiza,
    ip_captura, ip_actualiza, host_captura, host_actualiza, activo
    FROM HistorialRecipiente
    WHERE id_recipiente = :containerId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("containerId", $containerId);
  $stmt->execute();
  $logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  return $logs;
}

/**
 * @param $planData
 * @return mixed
 */
function insertContainerLog($insertData)
{
  $sql = "INSERT INTO HistorialRecipiente (id_custodia, id_muestra,
    id_recipiente, id_parametro, id_usuario_analiza, id_usuario_captura,
    volumen, fecha, fecha_captura, ip_captura, host_captura)
    VALUES (:id_custodia, :id_muestra,
    :id_recipiente, :id_parametro, :id_usuario_analiza, :id_usuario_captura,
    :volumen, :fecha, SYSDATETIMEOFFSET(), :ip_captura, :host_captura)";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($insertData);
  $containerLogId = $db->lastInsertId();
  $db = null;
  return $containerLogId;
}

/**
 * @param $updateData
 * @return mixed
 */
function updateContainerLog($updateData)
{
  $sql = "UPDATE HistorialRecipiente SET id_custodia = :id_custodia,
    id_muestra = :id_muestra, id_recipiente = :id_recipiente,
    id_parametro = :id_parametro, id_usuario_analiza = :id_usuario_analiza,
    id_usuario_actualiza = :id_usuario_actualiza,
    volumen = :volumen, fecha = :fecha,
    fecha_actualiza = SYSDATETIMEOFFSET(),
    ip_actualiza = :ip_actualiza, host_actualiza = :host_actualiza,
    activo = :activo
    WHERE id_historial_recipiente = :id_historial_recipiente";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($updateData);
  $db = null;
  return $updateData["id_historial_recipiente"];
}

/**
 * @return array
 */
function getBlankAnalysis()
{
  return array(
    "id_analisis" => 0, "id_trabajo" => 1, "id_usuario_analiza" => 1,
    "id_usuario_captura" => 0, "id_usuario_valida" => 0,
    "id_usuario_actualiza" => 0,
    "fecha_analiza" => null, "fecha_aprueba" => null,
    "fecha_captura" => null, "fecha_valida" => null,
    "fecha_actualiza" => null, "fecha_rechaza" => null,
    "ip_captura" => "", "ip_valida" => "", "ip_actualiza" => "",
    "host_captura" => "", "host_valida" => "", "host_actualiza" => "",
    "comentarios" => "", "motivo_rechaza" => "", "activo" => 1,
  );
}

/**
 * @param $analysisId
 * @return mixed
 */function getPlainAnalysis($analysisId)
{
  $sql = "SELECT id_analisis, id_trabajo, id_usuario_analiza,
    id_usuario_captura, id_usuario_valida, id_usuario_actualiza,
    CONVERT(NVARCHAR, fecha_analiza, 126) AS fecha_analiza,
    CONVERT(NVARCHAR, fecha_aprueba, 126) AS fecha_aprueba,
    CONVERT(NVARCHAR, fecha_captura, 126) AS fecha_captura,
    CONVERT(NVARCHAR, fecha_valida, 126) AS fecha_valida,
    CONVERT(NVARCHAR, fecha_actualiza, 126) AS fecha_actualiza,
    CONVERT(NVARCHAR, fecha_rechaza, 126) AS fecha_rechaza,
    ip_captura, ip_valida, ip_actualiza,
    host_captura, host_valida, host_actualiza,
    comentarios, motivo_rechaza, activo
    FROM Analisis
    WHERE activo = 1 AND id_analisis = :analysisId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("analysisId", $analysisId);
  $stmt->execute();
  $analysis = $stmt->fetch(PDO::FETCH_OBJ);
  $db = null;
  return $analysis;
}

/**
 * @param $analysisId
 * @return mixed
 */function getAnalysis($analysisId)
{
  $analysis = getPlainAnalysis($analysisId);
  $jobId = $analysis->id_trabajo;
  $analysis->muestras = getAnalysisSamples($analysisId);
  $parameters = getAnalysisParameters($analysisId);
  $references = getAnalysisReferences($analysisId);
  $results = getResultsByAnalysis($analysisId);

  $i = 0;
  $j = 0;
  $k = 0;
  $l = count($parameters);
  $m = count($references);
  $n = count($results);
  if (count($parameters) > 1) {
    for ($i = 0; $i < $l; $i++) {
      for ($j = 0; $j < $m; $j++) {
        if ($parameters[$i]["id_parametro"] == $references[$j]["id_parametro"]) {
          $parameters[$i]["referencias"] = $references[$j];
          // fecha_analiza
        }
      }
      for ($k = 0; $k < $n; $k++) {
        if ($parameters[$i]["id_parametro"] == $results[$k]["id_parametro"]) {
          $parameters[$i]["resultados"][] = $results[$k];
        }
      }
    }
  }
  $analysis->parametros = $parameters;
  return $analysis;
}

/**
 * @return mixed
 */function getAnalysisList()
{
  $sql = "SELECT id_analisis, id_trabajo, id_usuario_analiza,
    id_usuario_captura, id_usuario_valida, id_usuario_actualiza,
    CONVERT(NVARCHAR, fecha_analiza, 126) AS fecha_analiza,
    CONVERT(NVARCHAR, fecha_aprueba, 126) AS fecha_aprueba,
    CONVERT(NVARCHAR, fecha_captura, 126) AS fecha_captura,
    CONVERT(NVARCHAR, fecha_valida, 126) AS fecha_valida,
    CONVERT(NVARCHAR, fecha_actualiza, 126) AS fecha_actualiza,
    CONVERT(NVARCHAR, fecha_rechaza, 126) AS fecha_rechaza,
    ip_captura, ip_valida, ip_actualiza,
    host_captura, host_valida, host_actualiza,
    comentarios, motivo_rechaza, activo
    FROM Analisis
    WHERE activo = 1";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $analysisList = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  return $analysisList;
}

/**
 * @return mixed
 */function getUserAnalysisList($userId)
{
  $sql = "SELECT id_analisis, id_trabajo, id_usuario_analiza,
    id_usuario_captura, id_usuario_valida, id_usuario_actualiza,
    CONVERT(NVARCHAR, fecha_analiza, 126) AS fecha_analiza,
    CONVERT(NVARCHAR, fecha_aprueba, 126) AS fecha_aprueba,
    CONVERT(NVARCHAR, fecha_captura, 126) AS fecha_captura,
    CONVERT(NVARCHAR, fecha_valida, 126) AS fecha_valida,
    CONVERT(NVARCHAR, fecha_actualiza, 126) AS fecha_actualiza,
    CONVERT(NVARCHAR, fecha_rechaza, 126) AS fecha_rechaza,
    ip_captura, ip_valida, ip_actualiza,
    host_captura, host_valida, host_actualiza,
    comentarios, motivo_rechaza, activo
    FROM Analisis
    WHERE activo = 1 AND id_usuario_analiza = :userId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("userId", $userId);
  $stmt->execute();
  $analysisList = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  return $analysisList;
}

/**
 * @return mixed
 */function getAreaAnalysisList($areaId)
{
  $sql = "SELECT id_analisis, id_trabajo, id_usuario_analiza,
    id_usuario_captura, id_usuario_valida, id_usuario_actualiza,
    CONVERT(NVARCHAR, fecha_analiza, 126) AS fecha_analiza,
    CONVERT(NVARCHAR, fecha_aprueba, 126) AS fecha_aprueba,
    CONVERT(NVARCHAR, fecha_captura, 126) AS fecha_captura,
    CONVERT(NVARCHAR, fecha_valida, 126) AS fecha_valida,
    CONVERT(NVARCHAR, fecha_actualiza, 126) AS fecha_actualiza,
    CONVERT(NVARCHAR, fecha_rechaza, 126) AS fecha_rechaza,
    ip_captura, ip_valida, ip_actualiza,
    host_captura, host_valida, host_actualiza,
    comentarios, motivo_rechaza, activo, id_area, area, siglas
    FROM viewAnalisisArea
    WHERE activo = 1 AND id_area = :areaId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("areaId", $areaId);
  $stmt->execute();
  $analysisList = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  return $analysisList;
}

/**
 * @param $analysisData
 * @return mixed
 */
function insertAnalysis($analysisData)
{
  $sql = "INSERT INTO Analisis (id_trabajo, id_usuario_analiza,
    id_usuario_captura, id_usuario_valida, id_usuario_actualiza,
    fecha_analiza, fecha_aprueba, fecha_captura, fecha_valida,
    fecha_actualiza, fecha_rechaza, ip_captura, ip_valida,
    host_captura, host_valida, comentarios, motivo_rechaza, activo)
    VALUES (:id_trabajo, :id_usuario_analiza,
    :id_usuario_captura, :id_usuario_valida, :id_usuario_actualiza,
    :fecha_analiza, :fecha_aprueba, SYSDATETIMEOFFSET(), :fecha_valida,
    NULL, :fecha_rechaza, :ip_captura, :ip_valida,
    :host_captura, :host_valida, :comentarios, :motivo_rechaza, :activo)";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($analysisData);
  $analysisId = $db->lastInsertId();
  $db = null;
  return $analysisId;
}

/**
 * @param $updateData
 * @return mixed
 */
function updateAnalysis($updateData)
{
  $sql = "UPDATE Analisis SET id_trabajo = :id_trabajo,
    id_usuario_analiza = :id_usuario_analiza,
    id_usuario_captura = :id_usuario_captura,
    id_usuario_valida = :id_usuario_valida,
    id_usuario_actualiza = :id_usuario_actualiza,
    fecha_analiza = :fecha_analiza, fecha_aprueba = :fecha_aprueba,
    fecha_valida = :fecha_valida, fecha_actualiza = SYSDATETIMEOFFSET(),
    fecha_rechaza = :fecha_rechaza, ip_valida = :ip_valida,
    ip_actualiza = :ip_actualiza, host_valida = :host_valida,
    host_actualiza = :host_actualiza, comentarios = :comentarios,
    motivo_rechaza = :motivo_rechaza, activo = :activo
    WHERE id_analisis = :id_analisis";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($updateData);
  $db = null;
  return $updateData["id_analisis"];
}

/**
 * @param $jobId
 * @return mixed
 */
function disableJobAnalysis($jobId)
{
  $sql = "UPDATE Analisis SET activo = 0
    WHERE id_trabajo = :jobId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("jobId", $jobId);
  $stmt->execute();
  $db = null;
  return $jobId;
}

/**
 * @param $analysisId
 * @return mixed
 */
function getAnalysisSamples($analysisId)
{
  $sql = "SELECT id_analisis_muestra, id_analisis, id_muestra, activo
    FROM AnalisisMuestra
    WHERE activo = 1  AND id_analisis = :analysisId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("analysisId", $analysisId);
  $stmt->execute();
  $samples = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  return $samples;
}

/**
 * @param $sampleData
 * @return mixed
 */
function insertAnalysisSample($sampleData)
{
  $sql = "INSERT INTO AnalisisMuestra (id_analisis, id_muestra, activo)
    VALUES (:id_analisis, :id_muestra, :activo)";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($sampleData);
  $sampleId = $db->lastInsertId();
  $db = null;
  return $sampleId;
}

/**
 * @param $updateData
 * @return mixed
 */
function updateAnalysisSample($updateData)
{
  $sql = "UPDATE AnalisisMuestra SET id_analisis = :id_analisis,
    id_muestra = :id_muestra, activo = :activo
    WHERE id_analisis_muestra = :id_analisis_muestra";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($updateData);
  $db = null;
  return $updateData["id_analisis_muestra"];
}

/**
 * @param $analysisId
 * @return mixed
 */
function disableAnalysisSamples($analysisId)
{
  $sql = "UPDATE AnalisisMuestra SET activo = 0
    WHERE id_analisis = :analysisId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("analysisId", $analysisId);
  $stmt->execute();
  $db = null;
  return $analysisId;
}

/**
 * @param $analysisId
 * @return mixed
 */
function getAnalysisParameters($analysisId)
{
  $sql = "SELECT id_analisis_parametro, id_analisis, id_parametro,
    activo, parametro, [param], unidad
    FROM viewAnalisisParametroUnidad
    WHERE activo = 1  AND id_analisis = :analysisId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("analysisId", $analysisId);
  $stmt->execute();
  $parameters = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  return $parameters;
}

/**
 * @param $parameterData
 * @return mixed
 */
function insertAnalysisParameter($parameterData)
{
  $sql = "INSERT INTO AnalisisParametro (id_analisis, id_parametro, activo)
    VALUES (:id_analisis, :id_parametro, :activo)";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($parameterData);
  $parameterId = $db->lastInsertId();
  $db = null;
  return $parameterId;
}

/**
 * @param $updateData
 * @return mixed
 */
function updateAnalysisParameter($updateData)
{
  $sql = "UPDATE AnalisisParametro SET id_analisis = :id_analisis,
    id_parametro = :id_parametro, activo = :activo
    WHERE id_analisis_parametro = :id_analisis_parametro";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($updateData);
  $db = null;
  return $updateData["id_analisis_parametro"];
}

/**
 * @param $analysisId
 * @return mixed
 */
function disableAnalysisParameters($analysisId)
{
  $sql = "UPDATE AnalisisParametro SET activo = 0
    WHERE id_analisis = :analysisId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("analysisId", $analysisId);
  $stmt->execute();
  $db = null;
  return $analysisId;
}

/**
 * @return mixed
 */
function getBlankAnalysisReference()
{
  return array(
    "id_analisis_referencia" => 0, "id_analisis" => 0,
    "id_parametro" => 0, "id_usuario_analiza" => 0,
    "id_usuario_captura" => 0, "id_usuario_actualiza" => 0,
    "duplicado" => "", "muestra_duplicada" => "", "estandar" => "",
    "coeficiente_variacion" => "", "tiempo_incubacion" => "",
    "temperatura_incubacion" => "", "fecha_analiza" => null,
    "fecha_captura" => null, "fecha_actualiza" => null, "activo" => 1,
  );
}

/**
 * @return mixed
 */
function getAnalysisReferenceList()
{
  $sql = "SELECT id_analisis_referencia, id_analisis,
    id_parametro, id_usuario_analiza, id_usuario_captura,
    id_usuario_actualiza, duplicado, muestra_duplicada, estandar,
    coeficiente_variacion, tiempo_incubacion, temperatura_incubacion,
    CONVERT(NVARCHAR, fecha_analiza, 126) AS fecha_analiza,
    CONVERT(NVARCHAR, fecha_captura, 126) AS fecha_captura,
    CONVERT(NVARCHAR, fecha_actualiza, 126) AS fecha_actualiza,
    activo
    FROM AnalisisReferencia
    WHERE activo = 1";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $reference = $stmt->fetch(PDO::FETCH_OBJ);
  $db = null;
  return $reference;
}

/**
 * @param $analysisId
 * @return mixed
 */
function getAnalysisReferences($analysisId)
{
  $sql = "SELECT id_analisis_referencia, id_analisis,
    id_parametro, id_usuario_analiza, id_usuario_captura,
    id_usuario_actualiza, duplicado, muestra_duplicada, estandar,
    coeficiente_variacion, tiempo_incubacion, temperatura_incubacion,
    CONVERT(NVARCHAR, fecha_analiza, 126) AS fecha_analiza,
    CONVERT(NVARCHAR, fecha_captura, 126) AS fecha_captura,
    CONVERT(NVARCHAR, fecha_actualiza, 126) AS fecha_actualiza,
    activo
    FROM AnalisisReferencia
    WHERE activo = 1 AND id_analisis = :analysisId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("analysisId", $analysisId);
  $stmt->execute();
  $references = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  return $references;
}

/**
 * @param $referenceData
 * @return mixed
 */
function insertAnalysisReference($referenceData)
{
  $sql = "INSERT INTO AnalisisReferencia (id_analisis, id_parametro,
    id_usuario_analiza, id_usuario_captura,
    duplicado, muestra_duplicada, estandar, coeficiente_variacion,
    tiempo_incubacion, temperatura_incubacion,
    fecha_analiza, fecha_captura, activo)
    VALUES(:id_analisis, :id_parametro,
    :id_usuario_analiza, :id_usuario_captura,
    :duplicado, :muestra_duplicada, :estandar, :coeficiente_variacion,
    :tiempo_incubacion, :temperatura_incubacion,
    :fecha_analiza, SYSDATETIMEOFFSET(), :activo)";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($referenceData);
  $referenceId = $db->lastInsertId();
  $db = null;
  return $referenceId;
}

/**
 * @param $updateData
 * @return mixed
 */
function updateAnalysisReference($updateData)
{
  $sql = "UPDATE AnalisisReferencia SET id_analisis = :id_analisis,
    id_referencia = :id_referencia, activo = :activo
    WHERE id_analisis_referencia = :id_analisis_referencia";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($updateData);
  $db = null;
  return $updateData["id_analisis_referencia"];
}

/**
 * @param $analysisId
 * @return mixed
 */
function disableAnalysisReferences($analysisId)
{
  $sql = "UPDATE AnalisisReferencia SET activo = 0
    WHERE id_analisis = :analysisId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("analysisId", $analysisId);
  $stmt->execute();
  $db = null;
  return $analysisId;
}

/**
 * @param $analysisId
 * @return mixed
 */
function getResultsByAnalysis($analysisId)
{
  $sql = "SELECT  id_resultado, id_trabajo, id_analisis, id_muestra, id_parametro, id_tipo_resultado, id_tipo_valor, id_usuario_captura, id_usuario_actualiza, valor,
    CONVERT(NVARCHAR, fecha_captura, 126) AS fecha_captura,
    CONVERT(NVARCHAR, fecha_actualiza, 126) AS  fecha_actualiza,
    activo, param
    FROM viewAnalisisResultado
    WHERE activo = 1 AND id_analisis = :analysisId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("analysisId", $analysisId);
  $stmt->execute();
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  return $results;
}

/**
 * @param $analysisId
 * @return mixed
 */
function getAnalysisJobResults($analysisId)
{
  $sql = "SELECT id_resultado, id_trabajo, id_analisis, id_muestra,
    id_parametro, id_tipo_resultado, id_tipo_valor,
    id_usuario_captura, id_usuario_actualiza, valor,
    CONVERT(NVARCHAR, fecha_captura, 126) AS fecha_captura,
    CONVERT(NVARCHAR, fecha_actualiza, 126) AS fecha_actualiza,
    activo
    FROM viewAnalisisResultado
    WHERE activo = 1 AND id_analisis = :analysisId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("analysisId", $analysisId);
  $stmt->execute();
  $references = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  return $references;
}

/**
 * @param $analysisId
 * @return mixed
 */
function getAnalysisResults($analysisId)
{
  $sql = "SELECT id_analisis_resultado, id_analisis, id_resultado, activo
    FROM AnalisisResultado
    WHERE activo = 1 AND id_analisis = :analysisId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("analysisId", $analysisId);
  $stmt->execute();
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  return $results;
}

/**
 * @param $jobData
 * @return mixed
 */
function insertAnalysisResult($jobData)
{
  $sql = "INSERT INTO AnalisisResultado (id_analisis, id_resultado, activo)
    VALUES(:id_analisis, :id_resultado, :activo)";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($jobData);
  $jobResultId = $db->lastInsertId();
  $db = null;
  return $jobResultId;
}

/**
 * @param $updateData
 * @return mixed
 */
function updateAnalysisResult($updateData)
{
  $sql = "UPDATE AnalisisResultado SET id_analisis = :id_analisis,
    id_resultado = :id_resultado, activo = :activo
    WHERE id_analisis_resultado = :id_analisis_resultado";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($updateData);
  $db = null;
  return $updateData["id_analisis_resultado"];
}

/**
 * @param $analysisId
 * @return mixed
 */
function disableAnalysisResultsByjob($analysisId)
{
  $sql = "UPDATE AnalisisResultado SET activo = 0
    WHERE id_analisis = :analysisId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("analysisId", $analysisId);
  $stmt->execute();
  $db = null;
  return $analysisId;
}

/**
 * @return mixed
 */
function getReports()
{
  $json = '[]';
  return json_decode($json);
}

/**
 * @return mixed
 */
function getReferences()
{
  $json = '[]';
  return json_decode($json);
}

/**
 * @return mixed
 */
function getPrices()
{
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

/**
 * @param $planId
 * @return mixed
 */
function getPlanSamples($planId)
{
  $sql = "SELECT id_muestra, id_estudio, id_cliente, id_orden,
    id_plan, id_hoja, id_recepcion, id_custodia, id_paquete,
    id_ubicacion, id_punto, id_tipo_muestreo,
    CONVERT(NVARCHAR, fecha_muestreo, 126) AS fecha_muestreo,
    CONVERT(NVARCHAR, fecha_recibe, 126) AS fecha_recibe,
    comentarios, activo
    FROM Muestra
    WHERE activo = 1 AND id_plan = :planId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("planId", $planId);
  $stmt->execute();
  $samples = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  return $samples;
}

/**
 * @param $planId
 * @return mixed
 */
function getPreservationsByPlan($planId)
{
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

/**
 * @param $preservationData
 * @return mixed
 */
function insertPlanPreservation($preservationData)
{
  $sql = "INSERT INTO PlanPreservacion (id_plan, id_preservacion, activo)
    VALUES (:id_plan, :id_preservacion, :activo)";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($preservationData);
  $preservationId = $db->lastInsertId();
  $db = null;
  return $preservationId;
}

/**
 * @param $updateData
 * @return mixed
 */
function updatePlanPreservation($updateData)
{
  $sql = "UPDATE PlanPreservacion SET id_plan = :id_plan,
    id_preservacion = :id_preservacion, activo = :activo
    WHERE id_plan_preservacion = :id_plan_preservacion";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($updateData);
  $db = null;
  return $updateData["id_plan_preservacion"];
}

/**
 * @param $planId
 * @return mixed
 */
function disablePlanPreservations($planId)
{
  $sql = "UPDATE PlanPreservacion SET activo = 0
    WHERE id_plan = :planId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("planId", $planId);
  $stmt->execute();
  $db = null;
  return $planId;
}

/**
 * @param $planId
 * @return mixed
 */
function getReactivesByPlan($planId)
{
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

/**
 * @param $reactiveData
 * @return mixed
 */
function insertPlanReactive($reactiveData)
{
  $sql = "INSERT INTO PlanReactivo (id_plan, id_reactivo, valor, lote,
    folio)
    VALUES (:id_plan, :id_reactivo, :valor, :lote, :folio)";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($reactiveData);
  $reactiveId = $db->lastInsertId();
  $db = null;
  return $reactiveId;
}

/**
 * @param $planId
 * @return mixed
 */
function deletePlanReactives($planId)
{
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

/**
 * @param $planId
 * @return mixed
 */
function getMaterialsByPlan($planId)
{
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

/**
 * @param $materialData
 * @return mixed
 */
function insertPlanMaterial($materialData)
{
  $sql = "INSERT INTO PlanMaterial (id_plan, id_material)
    VALUES (:id_plan, :id_material)";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($materialData);
  $materialId = $db->lastInsertId();
  $db = null;
  return $materialId;
}

/**
 * @param $planId
 * @return mixed
 */
function deletePlanMaterials($planId)
{
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

/**
 * @param $planId
 * @return mixed
 */
function getCoolersByPlan($planId)
{
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

/**
 * @param $coolerData
 * @return mixed
 */
function insertPlanCooler($coolerData)
{
  $sql = "INSERT INTO PlanHielera (id_plan, id_hielera)
    VALUES (:id_plan, :id_hielera)";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($coolerData);
  $coolerId = $db->lastInsertId();
  $db = null;
  return $coolerId;
}

/**
 * @param $planId
 * @return mixed
 */
function deletePlanCoolers($planId)
{
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

/**
 * @return mixed
 */
function getEmployees()
{
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

/**
 * @return mixed
 */
function getSamplingEmployees()
{
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

/**
 * @param $userId
 * @return mixed
 */
function getSamplingEmployee($userId)
{
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

/**
 * @return mixed
 */
function getAnalysts()
{
  $sql = "SELECT id_usuario, id_nivel, id_rol, id_empleado,
    id_area, id_puesto, interno, cea, laboratorio, calidad,
    supervisa, recibe, analiza, muestrea, nombres,
    apellido_paterno, apellido_materno,
    CONVERT(NVARCHAR, fecha_captura, 126) AS fecha_captura,
    CONVERT(NVARCHAR, fecha_actualiza, 126) AS fecha_actualiza,
    ip_captura, ip_actualiza,
    host_captura, host_actualiza, activo
    FROM Usuario
    WHERE activo = 1 AND id_nivel > 1 AND analiza = 1";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $analysts = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  return $analysts;
}

/**
 * @return mixed
 */
function getPointKinds()
{
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

/**
 * @return mixed
 */
function getDistricts()
{
  $sql = "SELECT id_municipio, municipio
    FROM Municipio
    WHERE id_estado = 14
    ORDER BY municipio";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $districts = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  return $districts;
}

/**
 * @param $districtId
 * @return mixed
 */
function getDistrict($districtId)
{
  $sql = "SELECT id_municipio, municipio
    FROM Municipio
    WHERE id_municipio = :districtId
    ORDER BY municipio";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("districtId", $districtId);
  $stmt->execute();
  $district = $stmt->fetch(PDO::FETCH_OBJ);
  $db = null;
  return $district;
}

/**
 * @param $districtId
 * @return mixed
 */
function getCitiesByDistrictId($districtId)
{
  $sql = "SELECT id_municipio, id_localidad, localidad
    FROM Localidad
    WHERE id_municipio = :districtId
    ORDER BY localidad";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("districtId", $districtId);
  $stmt->execute();
  $districts = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  return $districts;
}

/**
 * @return mixed
 */
function getPreservations()
{
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

/**
 * @param $sheetId
 * @return mixed
 */
function getPreservationsBySheet($sheetId)
{
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

/**
 * @param $receptionId
 * @return mixed
 */
function getReceptionPreservations($receptionId)
{
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

/**
 * @param $preservationData
 * @return mixed
 */
function insertReceptionPreservation($preservationData)
{
  $sql = "INSERT INTO RecepcionPreservacion (id_recepcion,
    id_preservacion, cantidad)
    VALUES (:id_recepcion, :id_preservacion, :cantidad)";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($preservationData);
  $receptionPreservationId = $db->lastInsertId();
  $db = null;
  return $receptionPreservationId;
}

/**
 * @param $receptionId
 * @return mixed
 */
function deleteReceptionPreservations($receptionId)
{
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

/**
 * @param $receptionId
 * @return mixed
 */
function disableReceptionPreservations($receptionId)
{
  $sql = "UPDATE RecepcionPreservacion SET activo = 0
    WHERE id_recepcion = :receptionId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("receptionId", $receptionId);
  $stmt->execute();
  $db = null;
  return $receptionId;
}

/**
 * @param $updateData
 * @return mixed
 */
function updateReceptionPreservation($updateData)
{
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

/**
 * @param $preservationData
 * @return mixed
 */
function insertSheetPreservation($preservationData)
{
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

/**
 * @param $updateData
 * @return mixed
 */
function updateSheetPreservation($updateData)
{
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

/**
 * @param $sheetId
 * @return mixed
 */
function disableSheetPreservations($sheetId)
{
  $sql = "UPDATE HojaPreservacion SET activo = 0
    WHERE id_hoja = :sheetId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("sheetId", $sheetId);
  $stmt->execute();
  $db = null;
  return $sheetId;
}

/**
 * @param $sheetId
 * @return mixed
 */
function deleteSheetPreservations($sheetId)
{
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

/**
 * @param mixed $resultId
 * @return mixed
 */
function getBlankResult()
{
  return array(
    "id_resultado" => 0, "id_muestra" => 0, "id_parametro" => 0,
    "id_tipo_resultado" => 1, "id_tipo_valor" => 1,
    "id_usuario_captura" => 1, "id_usuario_actualiza" => 0,
    "valor" => "", "fecha_captura" => null,
    "fecha_actualiza" => null, "activo" => 1,
  );
}

/**
 * @param mixed $resultId
 * @return mixed
 */
function getResult($resultId)
{
  $sql = "SELECT id_resultado, id_muestra, id_parametro,
    id_tipo_resultado, id_tipo_valor, id_usuario_captura,
    id_usuario_actualiza, valor,
    CONVERT(NVARCHAR, fecha_captura, 126) AS fecha_captura,
    CONVERT(NVARCHAR, fecha_actualiza, 126) AS fecha_actualiza,
    activo
    FROM Resultado
    WHERE activo = 1 AND id_resultado = :resultId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("resultId", $resultId);
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_OBJ);
  $db = null;
  return $result;
}

/**
 * @return mixed
 */
function getResults()
{
  $sql = "SELECT id_resultado, id_muestra, id_parametro,
    id_tipo_resultado, id_tipo_valor, id_usuario_captura,
    id_usuario_actualiza, valor,
    CONVERT(NVARCHAR, fecha_captura, 126) AS fecha_captura,
    CONVERT(NVARCHAR, fecha_actualiza, 126) AS fecha_actualiza,
    activo
    FROM Resultado
    WHERE activo = 1";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  return $results;
}

/**
 * @param $sampleId
 * @return mixed
 */
function getSampleResults($sampleId)
{
  $sql = "SELECT id_muestra, id_parametro, id_tipo_resultado,
    id_tipo_valor, id_usuario_actualiza, valor,
    CONVERT(NVARCHAR, fecha_actualiza, 126) AS fecha_actualiza,
    activo
    FROM Resultado
    WHERE id_muestra = :sampleId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("sampleId", $sampleId);
  $stmt->execute();
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  return $results;
}

/**
 * @param $resultData
 * @return mixed
 */
function insertResult($resultData)
{
  $sql = "INSERT INTO Resultado (id_muestra, id_parametro,
    id_tipo_resultado, id_tipo_valor, id_usuario_captura,
    valor, fecha_captura, activo)
    VALUES (:id_muestra, :id_parametro,
    :id_tipo_resultado, :id_tipo_valor, :id_usuario_captura,
    :valor, SYSDATETIMEOFFSET(), :activo)";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute($resultData);
  $resultId = $db->lastInsertId();
  $db = null;
  return $resultId;
}

/**
 * @param $updateData
 * @return mixed
 */
function updateResult($updateData)
{
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

/**
 * @return mixed
 */
function getSamplingInstruments()
{
  $sql = "SELECT id_instrumento, instrumento, descripcion,
    muestreo, inventario, activo
    FROM Instrumento
    WHERE activo = 1 AND muestreo = 1";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $instruments = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  return $instruments;
}

/**
 * @return mixed
 */
function getReactives()
{
  $sql = "SELECT id_reactivo, id_tipo_reactivo, reactivo,
    registra_valor, lote, folio, activo, '0' AS valor
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

/**
 * @return mixed
 */
function getMaterials()
{
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

/**
 * @return mixed
 */
function getCoolers()
{
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

/**
 * @return mixed
 */
function getClouds()
{
  $sql = "SELECT id_nube, nube, activo
    FROM Nube
    WHERE activo = 1";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $clouds = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  return $clouds;
}

/**
 * @return mixed
 */
function getCurrentDirections()
{
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

/**
 * @return mixed
 */
function getWaves()
{
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

/**
 * @return mixed
 */
function getSamplingNorms()
{
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

/**
 * @return mixed
 */
function getLocations()
{
  $sql = "SELECT id_ubicacion, ubicacion,
    fecha_captura, fecha_actualiza, ip_captura, ip_actualiza,
    host_captura, host_actualiza, activo
    FROM Ubicacion
    WHERE activo = 1";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $locations = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  return $locations;
}

/**
 * @param $locationId
 * @return mixed
 */
function getLocation($locationId)
{
  $sql = "SELECT id_ubicacion, ubicacion,
    fecha_captura, fecha_actualiza, ip_captura, ip_actualiza,
    host_captura, host_actualiza, activo
    FROM Ubicacion
    WHERE activo = 1 AND id_ubicacion = :locationId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("locationId", $locationId);
  $stmt->execute();
  $location = $stmt->fetch(PDO::FETCH_OBJ);
  $db = null;
  return $location;
}

/**
 * @return mixed
 */
function getWaterBodies()
{
  $sql = "SELECT id_cuerpo, id_tipo_cuerpo, cuerpo, tipo_cuerpo,
    siglas, activo
    FROM Cuerpo
    WHERE activo = 1";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $waterBodies = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  return $waterBodies;
}

/**
 * @param $bodyId
 * @return mixed
 */
function getWaterBody($bodyId)
{
  $sql = "SELECT id_cuerpo, id_tipo_cuerpo, cuerpo, tipo_cuerpo,
    siglas, activo
    FROM Cuerpo
    WHERE activo = 1 AND id_cuerpo = :bodyId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("bodyId", $bodyId);
  $stmt->execute();
  $waterBody = $stmt->fetch(PDO::FETCH_OBJ);
  $db = null;
  return $waterBody;
}

/**
 * @return mixed
 */
function getStorages()
{
  $sql = "SELECT id_almacenamiento, almacenamiento, activo
    FROM Almacenamiento
    WHERE activo = 1";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $storages = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $db = null;
  return $storages;
}

/**
 * @param $storageId
 * @return mixed
 */
function getStorage($storageId)
{
  $sql = "SELECT id_almacenamiento, almacenamiento, activo
    FROM Almacenamiento
    WHERE activo = 1 AND id_almacenamiento = :storageId";
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("storageId", $storageId);
  $stmt->execute();
  $storage = $stmt->fetch(PDO::FETCH_OBJ);
  $db = null;
  return $storage;
}
