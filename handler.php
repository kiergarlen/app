<?php
require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();

$app->get('/acciones', 'getAcciones');
$app->get('/acciones/:id', 'getAccion');

$app->run();

function getAcciones() {
	$sql = "SELECT TOP 1 idaccion, idlicitacion, idcontrato, idprograma, idsubprograma, idtipoaccion, idcategoria, idsubcategoria, idejercicio, idcobertura, idpertenece, idsituacion, 
		idstatusanexo, idobserobras, idconveniotrans, idsicpro, idresponsable, idclasificador, idagrupador, elabcontrato, ptars, DescAnexo, NombreObra, montoprogramado, 
		montopreprogramado, montoorigenprogramado, obserpreprog, costobase, porcfederal, porcestatal, porcmunicipal, porcotros, porcindirecto, numaccionanexo, 
		ctacontable, credito, contraparte, codigoBID, fichaSIIF, obraSIIF, [status], status1, poblacionbene, abona_cobertura, hab_bene, user_updt, validar, validarconceptos, 
		observaciones, cob_abona, fecha_updt
		FROM Acciones
		WHERE (idejercicio = 2014)";
	try {
		$db = getConnection();
		$stmt = $db->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchObject();
		$db =  null;
		// Include support for JSONP requests
		if (!isset($_GET['callback'])) {
			echo json_encode($result);
		} else {
			echo $_GET['callback'] . '(' . json_encode($result) . ');';
		}
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}';
	}
}

function getAccion($id) {
	$sql = "SELECT idaccion, idlicitacion, idcontrato, idprograma, idsubprograma, idtipoaccion, idcategoria, idsubcategoria, idejercicio, idcobertura, idpertenece, idsituacion, 
		idstatusanexo, idobserobras, idconveniotrans, idsicpro, idresponsable, idclasificador, idagrupador, elabcontrato, ptars, DescAnexo, NombreObra, montoprogramado, 
		montopreprogramado, montoorigenprogramado, obserpreprog, costobase, porcfederal, porcestatal, porcmunicipal, porcotros, porcindirecto, numaccionanexo, 
		ctacontable, credito, contraparte, codigoBID, fichaSIIF, obraSIIF, [status], status1, poblacionbene, abona_cobertura, hab_bene, user_updt, validar, validarconceptos, 
		observaciones, cob_abona, fecha_updt
		FROM Acciones
		WHERE idaccion=:id";
	try {
		$db = getConnection();
		$stmt = $db->prepare($sql);
		$stmt->bindParam("id", $id);
		$stmt->execute();
		$result = $stmt->fetchObject();
		$db = null;
		// Include support for JSONP requests
		if (!isset($_GET['callback'])) {
			echo json_encode($result);
		} else {
			echo $_GET['callback'] . '(' . json_encode($result) . ');';
		}
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}';
	}
}

function getConnection() {
	$dbhost = "SQLDESARROLLO";
	$dbuser= "obras";
	$dbpass= "0bra$@12#";
	$dbname= "CTRLOBRA";
	$dbh = new PDO("sqlsrv:server = $dbhost; Database = $dbname", $dbuser, $dbpass);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	return $dbh;
}