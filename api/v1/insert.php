<?php
$json = '
{
	"id_estudio":0,
	"id_cliente":"2",
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
	"ubicacion":"Ubicacion",
	"fecha":"2015-06-08T05:00:00.000Z",
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
	"activo":1,
	"cliente":
	{
		"id_cliente":"2",
		"id_estado":"14",
		"id_municipio":"14039",
		"id_localidad":"140390001",
		"interno":"1",
		"cea":"1",
		"tasa":"0.0",
		"cliente":"CEA Jalisco",
		"area":"Gerencia Técnica Consultiva",
		"rfc":"",
		"calle":"Av. Brasilia",
		"numero":"2970",
		"colonia":"Colomos Providencia",
		"codigo_postal":"44680",
		"telefono":"3030-9350 ext. 8384",
		"fax":"",
		"contacto":"Martha Olga Peña Lie",
		"puesto_contacto":"Gerente Técnico Consultivo",
		"email":"mpena@ceajalisco.gob.mx",
		"fecha_captura":"2015-02-10T00:00:00",
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
			"cantidad_muestras":"2",
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
			"$$hashKey":"object:237"
		},
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
			"cantidad_muestras":"2",
			"costo_total":0,
			"cuerpo_receptor":"",
			"tipo_cuerpo":"",
			"fecha":"",
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
			"$$hashKey":"object:476"
		},
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
			"cantidad_muestras":"2",
			"costo_total":0,
			"cuerpo_receptor":"",
			"tipo_cuerpo":"",
			"fecha":"",
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
			"$$hashKey":"object:498"
		}
	]
}
';

function isoDateToMsSql($dateString) {
	$format = 'Y-m-d H:i:s';
	if (strlen($dateString) > 18)
	{
		$dateString = substr($dateString, 0, 19);
		$dateString = str_replace("T", " ", $dateString);
		if (DateTime::createFromFormat($format, $dateString))
		{
			$date = DateTime::createFromFormat($format, $dateString);
			return $date->format($format);
		}
	}
	if (strlen($dateString) == 10)
	{
		$date = DateTime::createFromFormat('Y-m-d', $dateString);
		return $date->format($format);
	}
	return "1970-01-01 00:00";
}

function processStudyInsert($request) {
	//$token = decodeUserToken($request);
	//$insertData = (array) json_decode($request->getBody());
	$insertData = (array) json_decode($request);
	$lastStudyNumber = 0;
	$currentYear = date("Y");
	$clientId = $insertData["id_cliente"];
	$orders = $insertData["ordenes"];

	unset($insertData["id_estudio"]);
	unset($insertData["cliente"]);
	unset($insertData["ordenes"]);

	// $lastStudy = (array) getLastStudyByYear($currentYear);
	// if (is_numeric($lastStudy["oficio"])) {
	// 	$lastStudyNumber = $lastStudy["oficio"];
	// }

	$lastStudyNumber = $lastStudyNumber + 1;
	$folio = "CEA-" . str_pad($lastStudyNumber, 3, "0", STR_PAD_LEFT);
	$folio .= "-" . $currentYear;

	//$insertData["id_usuario_captura"] = $token->uid;
	$insertData["id_usuario_captura"] = 1;
	$insertData["ip_captura"] = "::1";
	$insertData["host_captura"] = "http://localhost";
	$insertData["id_status"] = 1;
	$insertData["id_etapa"] = 1;
	$insertData["oficio"] = $lastStudyNumber;
	$insertData["folio"] = $folio;
	$insertData["fecha"] = isoDateToMsSql($insertData["fecha"]);
	$insertData["fecha_captura"] = date('Y-m-d H:i:s');

	$studyInsertData = array(
		"study" => $insertData,
		"orders" => $orders
	);
	return $studyInsertData;
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
		:fecha_valida, :fecha_rechaza, :ip_captura, :ip_valida,
		:ip_actualiza, :host_captura, :host_valida, :host_actualiza,
		:motivo_rechaza, :activo)";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->execute($insertData);
	$studyId = $db->lastInsertId();
	$db = null;
	return $studyId;
	return $insertData;
}


print_r(insertStudy(processStudyInsert($json)["study"]));


/*
print_r(
    insertStudy(
        processStudyInsert(
            $json
        )["study"]
    )
);
*/