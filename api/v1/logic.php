<?php
function processUserJwt($request) {
	$input = json_decode($request->getbody());
	$usr = $input->username;
	$pwd = $input->password;

	$userInfo = getUserByCredentials($usr, $pwd);
	$userId = $userInfo->id_usuario;
	$userLv = $userInfo->id_nivel;
	$userRole = $userInfo->id_rol;
	$name = $userInfo->nombres . " ";
	$name .= $userInfo->apellido_paterno . " ";
	$name .= $userInfo->apellido_materno . "";

	$userPass = $usr . ".";
	$userPass .= $pwd . ".";
	$userPass .= $userId . "." . $userLv;
	$userPass = bin2hex($userPass);
	$token = array();
	//$token["usr"] = $input->username;
	//$token["pwd"] = $input->password;
	$token["nam"] = $name;
	$token["upt"] = $userPass;
	$token["uid"] = $userId;
	$token["ulv"] = $userLv;
	$token["uro"] = $userRole;
	$token["cip"] = $request->getIp() . "";
	$token["iss"] = $request->getUrl();
	$token["aud"] = "sislab.ceajalisco.gob.mx";
	$token["iat"] = time();
	/// Token expires 48 hours from now
	$token["exp"] = time() + (48 * 60 * 60);
	$jwt = JWT::encode($token, KEY);
	return $jwt;
}

function decodeJwt($jwt) {
	return (array) JWT::decode($jwt, KEY);
}

function extractDataFromRequest($request) {
	return json_decode($request->getBody());
}

function decodeUserToken($request) {
	try {
		$headers = $request->headers();
		$jwt = $headers["Auth-Token"];
		$decoded = JWT::decode($jwt, KEY);
		// $tokenUserId = $jwt->uid;
		// $tokenIp = $jwt->cip;
		// $tokenUrl = $jwt->iss;
		// $requestIp = $request->getIp();
		// $requestUrl = $request->getUrl();
		// if ($tokenIp === $request->getIp())
		// {
		// 	return array("success" => "Ip match");
		// }
		// else
		// {
		// 	return array("error" => "Ip mismatch");
		// }
		return $decoded;
	} catch (Exception $e) {
		$app->response()->status(401);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
}

// function processResultToJson($items, $isArrayOutputExpected) {
// 	$output = "";
// 	if ($isArrayOutputExpected)
// 	{
// 		$output .= "[";
// 	}
// 	$i = 0;
// 	$l = count($items);
// 	foreach ($items as $item) {
// 		$i++;
// 		$j = 0;
// 		$item = (array)$item;
// 		$m = count($item);
// 		$output .= "{";
// 		foreach ($item as $key => $value) {
// 			$j++;
// 			$output .= '"' . $key . '":';
// 			$v = $value;
// 			if (!is_numeric($v) && strtotime($v))
// 			{
// 				$dateArray = explode(" ", $v);
// 				//$v = $dateArray[0] . 'T'. substr($dateArray[1], 0, 5) . '-06:00';
// 				$v = $dateArray[0] . 'T'. substr($dateArray[1], 0, 5);
// 			}
// 			$output .= '"' . $v .'"';
// 			if ($j < $m)
// 			{
// 				$output .= ",";
// 			}
// 		}
// 		$output .= "}";
// 		if ($isArrayOutputExpected && $i < $l)
// 		{
// 			$output .= ",";
// 		}
// 	}
// 	if ($isArrayOutputExpected)
// 	{
// 		$output .= "]";
// 	}
// 	return $output;
// }

function processMenuToJson($items) {
	$output = '';
	$i = 0;
	$l = count($items);
	$currentItem = $items[$i];
	$output .= '[{"id_menu":' . $currentItem["id_menu"] . ',';
	$output .= '"orden":' . $currentItem["orden"] . ',';
	$output .= '"url":"/#","menu":"' . $currentItem["menu"] . '",';
	$output .= '"submenu":[{"id_submenu":' . $currentItem["id_submenu"] . ',';
	$output .= '"id_menu":' . $currentItem["id_menu"] . ',';
	$output .= '"orden":' . $currentItem["orden_submenu"] . ',';
	$output .= '"url":"' . $currentItem["url"] . '",';
	$output .= '"menu":"' . $currentItem["submenu"] . '"}';
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
			$output .= ']},';
			$currentItem = $items[$i];
			$output .= '{';
			$output .= '"id_menu":' . $currentItem["id_menu"] . ',';
			$output .= '"orden":' . $currentItem["orden"] . ',';
			$output .= '"url":"/#","menu":"' . $currentItem["menu"] . '",';
			$output .= '"submenu":[';
		}
		$output .= '{"id_submenu":' . $currentItem["id_submenu"] . ',';
		$output .= '"id_menu":' . $currentItem["id_menu"] . ',';
		$output .= '"orden":' . $currentItem["orden_submenu"] . ',';
		$output .= '"url":"' . $currentItem["url"] . '",';
		$output .= '"menu":"' . $currentItem["submenu"] . '"}';
	}
	$output .= ']}]';
	return $output;
}

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
	return "2015-01-01 00:00";
}

function isoDateToMsSql1($dateString) {
	$format = "c";
	$outputFormat = "Y-m-d H:i:s P";
	$datePart = "2015-01-01";
	$hoursPart = "00:00:00";
	$secondsPart = ".000";
	$offsetPart = "";

	if (DateTime::createFromFormat($outputFormat, $dateString)) {
		return $dateString;
	}

	if (DateTime::createFromFormat($format, $dateString)) {
		$date = DateTime::createFromFormat($format, $dateString);
		return $date->format($outputFormat);
	}

	if (DateTime::createFromFormat("Y-m-d", $dateString))
	{
		$date = DateTime::createFromFormat("Y-m-d", $dateString);
		return $date->format($format) . " 00:00";
	}

	if (count(explode("T", $dateString)) > 1) {

		$dateStringArray = explode("T", $dateString);
		$datePart = $dateStringArray[0];
		$dateStringTime = $dateStringArray[1];
		if (count(explode("+", $dateStringTime)) > 1) {
			$dateStringTimeArray = explode("+", $dateStringTime);
			$timeString = $dateStringTimeArray[0];
			$hoursPart = substr($timeString, 0, 8);
			$secondsPart = substr($timeString, 8, strlen($timeString));
			//$offsetPart = "+" . $dateStringTimeArray[1];
		}

		if (count(explode("-", $dateStringTime)) > 1) {
			$dateStringTimeArray = explode("-", $dateStringTime);
			$timeString = $dateStringTimeArray[0];
			$hoursPart = substr($timeString, 0, 8);
			$secondsPart = substr($timeString, 8, strlen($timeString));
			//$offsetPart = "-" . $dateStringTimeArray[1];
		}

		$dateStringDate = $datePart . " ";
		$dateStringDate .= $hoursPart . "";
		//$dateStringDate .= " " . $offsetPart;

		if (DateTime::createFromFormat('Y-m-d H:i:s', $dateStringDate)) {
			$dateStringDate = $datePart . " ";
			$dateStringDate .= $hoursPart . "";
			$dateStringDate .= $secondsPart . "";
			//$dateStringDate .= " " . $offsetPart;
			return $dateStringDate;
		}
	}
	return "2015-01-01 00:00:00";
}

function processStudyInsert($request) {
	$token = decodeUserToken($request);
	$insertData = (array) json_decode($request->getBody());
	$lastStudyNumber = 0;
	$currentYear = date("Y");
	$clientId = $insertData["id_cliente"];
	$orders = $insertData["ordenes"];

	unset($insertData["id_estudio"]);
	unset($insertData["cliente"]);
	unset($insertData["ordenes"]);

	$lastStudy = (array) getLastStudyByYear($currentYear);
	if (is_numeric($lastStudy["oficio"]))
	{
		$lastStudyNumber = $lastStudy["oficio"];
	}

	$lastStudyNumber = $lastStudyNumber + 1;
	$folio = "CEA-" . str_pad($lastStudyNumber, 3, "0", STR_PAD_LEFT);
	$folio .= "-" . $currentYear;

	$insertData["id_usuario_captura"] = $token->uid;
	$insertData["ip_captura"] = $request->getIp();
	$insertData["host_captura"] = $request->getUrl();
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

function processStudyOrderInsert($studyInsertData, $studyId) {
	$orders = (array) $studyInsertData["orders"];
	$clientId = $studyInsertData["study"]["id_cliente"];
	$insertUserId = $studyInsertData["study"]["id_usuario_captura"];
	$insertDate = $studyInsertData["study"]["fecha_captura"];
	$insertIp = $studyInsertData["study"]["ip_captura"];
	$insertUrl = $studyInsertData["study"]["host_captura"];

	$blankPlan = getBlankPlan();
	unset($blankPlan["id_plan"]);
	$blankPlan["id_estudio"] = $studyId;
	$blankPlan["id_usuario_captura"] = $insertUserId;
	$blankPlan["fecha_captura"] = $insertDate;
	$blankPlan["ip_captura"] = $insertIp;
	$blankPlan["host_captura"] = $insertUrl;

	$i = 0;
	$l = count($orders);

	for ($i = 0; $i < $l; $i++) {
		$order = (array) $orders[$i];

		unset($order['$$hashKey']);
		unset($order["id_orden"]);
		if (isset($order["fecha_entrega"]))
		{
			unset($order["fecha_entrega"]);
		}

		$order["id_estudio"] = $studyId;
		$order["id_cliente"] = $clientId;
		$order["id_cuerpo_receptor"] = 5;
		$order["id_status"] = 1;
		$order["costo_total"] = 0;
		$order["id_usuario_captura"] = $insertUserId;
		$order["fecha_captura"] = $insertDate;
		$order["ip_captura"] = $insertIp;
		$order["host_captura"] = $insertUrl;
		$order["activo"] = 1;

		$orderId = insertOrder($order);
		//assign this order's ID to blank plan
		$blankPlan["id_orden"] = $orderId;
		$planId = insertPlan($blankPlan);
	}
}

function processStudyUpdate($request) {
	$token = decodeUserToken($request);
	$updateData = (array) json_decode($request->getBody());
	$studyId = $updateData["id_estudio"];
	$clientId = $updateData["id_cliente"];
	$orders = $updateData["ordenes"];

	unset($updateData["id_usuario_captura"]);
	unset($updateData["fecha_captura"]);
	unset($updateData["ip_captura"]);
	unset($updateData["host_captura"]);
	unset($updateData["cliente"]);
	unset($updateData["ordenes"]);
	unset($updateData["status"]);

	$updateData["id_usuario_actualiza"] = $token->uid;
	$updateData["fecha_actualiza"] = date('Y-m-d H:i:s');
	$updateData["ip_actualiza"] = $request->getIp();
	$updateData["host_actualiza"] = $request->getUrl();

	if ($updateData["id_status"] == 2 && strlen($updateData["ip_valida"]) < 1)
	{
		$updateData["ip_valida"] = $request->getIp();
		$updateData["host_valida"] = $request->getUrl();
		$updateData["fecha_valida"] = isoDateToMsSql($updateData["fecha_valida"]);
	}

	$updateData["fecha"] = isoDateToMsSql($updateData["fecha"]);
	$updateData["fecha_entrega"] = isoDateToMsSql($updateData["fecha_entrega"]);
	$updateData["fecha_rechaza"] = isoDateToMsSql($updateData["fecha_rechaza"]);

	$studyUpdateData = array (
		"study" => $updateData,
		"orders" => $orders
	);
	return $studyUpdateData;
}

function processStudyOrderUpdate($studyUpdateData) {
	$orders = (array) $studyUpdateData["orders"];
	$studyId = $studyUpdateData["study"]["id_estudio"];
	$clientId = $studyUpdateData["study"]["id_cliente"];
	$updateUserId = $studyUpdateData["study"]["id_usuario_actualiza"];
	$updateDate = $studyUpdateData["study"]["fecha_actualiza"];
	$updateIp = $studyUpdateData["study"]["ip_actualiza"];
	$updateUrl = $studyUpdateData["study"]["host_actualiza"];
	$storedOrders = getOrdersByStudy($studyId);

	$i = 0;
	$j = 0;
	$l = count($storedOrders);
	$m = count($orders);

	if ($l < 1)
	{
		//nothing stored, insert all
		for ($j = 0; $j < $m; $j++) {
			$newOrder = (array) $orders[$j];
			unset($newOrder["id_orden"]);
			unset($newOrder['$$hashKey']);
			$newOrder["id_estudio"] = $studyId;
			$newOrder["id_cliente"] = $clientId;
			//TODO: Get from catalog
			$newOrder["id_cuerpo_receptor"] = 5;

			$newOrder["fecha"] = isoDateToMsSql($newOrder["fecha"]);
			$newOrder["id_usuario_captura"] = $updateUserId;
			$newOrder["fecha_captura"] = date('Y-m-d H:i:s');
			$newOrder["ip_captura"] = $updateIp;
			$newOrder["host_captura"] = $updateUrl;
			$newOrder["fecha_valida"] = "";
			$newOrder["fecha_actualiza"] = "";
			$newOrder["fecha_rechaza"] = "";
			insertOrder($newOrder);
		}
		return $studyId;
	}
	else
	{
		//mark all stored as deleted, only additions/matches persist
		for ($i = 0; $i < $l; $i++) {
			unset($storedOrders[$i]['$$hashKey']);
			unset($storedOrders[$i]["id_usuario_captura"]);
			unset($storedOrders[$i]["fecha_captura"]);
			unset($storedOrders[$i]["ip_captura"]);
			unset($storedOrders[$i]["host_captura"]);
			$storedOrders[$i]["activo"] = 0;
			$storedOrders[$i]["id_usuario_actualiza"] = $updateUserId;
			$storedOrders[$i]["fecha_actualiza"] = date('Y-m-d H:i:s');
			$storedOrders[$i]["ip_actualiza"] = $updateIp;
			$storedOrders[$i]["host_actualiza"] = $updateUrl;
			//return $storedOrders[$i];
			//return "delete old";
			updateOrder($storedOrders[$i]);
		}
		for ($j = 0; $j < $m; $j++) {
			$order = (array) $orders[$j];
			if ($order["id_orden"] == 0)
			{
				//new, store it
				unset($order["id_orden"]);
				unset($order['$$hashKey']);
				$order["id_usuario_captura"] = $updateUserId;
				$order["fecha_captura"] = date('Y-m-d H:i:s');
				$order["ip_captura"] = $updateIp;
				$order["host_captura"] = $updateUrl;
				//return "...something new;
				//return $order;
				insertOrder($order);
			}
			else
			{
				//update
				unset($order['$$hashKey']);
				unset($order["id_usuario_captura"]);
				unset($order["fecha_captura"]);
				unset($order["ip_captura"]);
				unset($order["host_captura"]);
				$order["activo"] = 1;
				$order["id_usuario_actualiza"] = $updateUserId;
				$order["fecha_actualiza"] = date('Y-m-d H:i:s');
				$order["ip_actualiza"] = $updateIp;
				$order["host_actualiza"] = $updateUrl;
				//return "...something old";
				//return $order;
				updateOrder($order);
			}
		}
	}
	return $studyId;
}

function processOrderInsert($request) {
	$token = decodeUserToken($request);
	$insertData = (array) json_decode($request->getBody());
	return $insertData;
}

function processOrderUpdate($request) {
	$token = decodeUserToken($request);
	$update = (array) json_decode($request->getBody());
	$client = $update["cliente"];
	$study = $update["estudio"];
	$plans = $update["planes"];

	unset($update["cliente"]);
	unset($update["estudio"]);
	unset($update["planes"]);
	unset($update["status"]);
	unset($update["id_usuario_captura"]);
	unset($update["fecha_captura"]);
	unset($update["ip_captura"]);
	unset($update["host_captura"]);

	$update["id_usuario_actualiza"] = $token->uid;
	$update["fecha_actualiza"] = date('Y-m-d H:i:s');
	$update["ip_actualiza"] = $request->getIp();
	$update["host_actualiza"] = $request->getUrl();
	$update["fecha"] = isoDateToMsSql($update["fecha"]);
	$update["fecha_rechaza"] = isoDateToMsSql($update["fecha_rechaza"]);

	if ($update["id_status"] == 2 && strlen($update["ip_valida"]) < 1)
	{
		$update["ip_valida"] = $request->getIp();
		$update["host_valida"] = $request->getUrl();
		$update["fecha_valida"] = isoDateToMsSql($update["fecha_valida"]);
	}

	$orderUpdateData = array(
		"order" => $update,
		"plans" => $plans
	);
	return $orderUpdateData;
}

function processOrderPlansUpdate($orderUpdateData) {
	$orderData = $orderUpdateData["order"];
	$orderId = $orderData["id_orden"];
	$updateUserId = $orderData["id_usuario_actualiza"];
	$updateIp = $orderData["ip_actualiza"];
	$updateUrl = $orderData["host_actualiza"];
	$storedPlans = getPlansByOrder($orderId);
	$plans = (array) $orderUpdateData["plans"];

	$i = 0;
	$j = 0;
	$l = count($storedPlans);
	$m = count($plans);

	//TODO: refactor with array_walk()
	//TODO: use single transaction
	if ($l < 1)
	{
		//nothing stored, insert all
		for ($j = 0; $j < $m; $j++) {
			$plan = (array) $plans[$j];
			unset($plan["id_plan"]);
			unset($plan['$$hashKey']);
			$plan["id_orden"] = $orderId;
			$plan["id_usuario_captura"] = $updateUserId;
			$plan["fecha_captura"] = date('Y-m-d H:i:s');
			$plan["ip_captura"] = $updateIp;
			$plan["host_captura"] = $updateUrl;
			$plan["fecha"] = "";
			$plan["fecha_probable"] = isoDateToMsSql($plan["fecha_probable"]);
			$plan["fecha_calibracion"] = "";
			$plan["fecha_valida"] = "";
			$plan["fecha_actualiza"] = "";
			$plan["fecha_rechaza"] = "";
			insertPlan($plan);
		}
		return $orderId;
	}
	else
	{
		//mark all stored as deleted, only additions/matches persist
		for ($i = 0; $i < $l; $i++) {
			unset($storedPlans[$i]['$$hashKey']);
			unset($storedPlans[$i]["id_usuario_captura"]);
			unset($storedPlans[$i]["fecha_captura"]);
			unset($storedPlans[$i]["ip_captura"]);
			unset($storedPlans[$i]["host_captura"]);
			$storedPlans[$i]["activo"] = 0;
			$storedPlans[$i]["id_usuario_actualiza"] = $updateUserId;
			$storedPlans[$i]["fecha_actualiza"] = date('Y-m-d H:i:s');
			$storedPlans[$i]["ip_actualiza"] = $updateIp;
			$storedPlans[$i]["host_actualiza"] = $updateUrl;
			//return "delete old";
			updatePlan($storedPlans[$i]);
		}
		for ($j = 0; $j < $m; $j++) {
			$plan = (array) $plans[$j];
			if ($plan["id_plan"] == 0)
			{
				//new, store it
				unset($plan["id_plan"]);
				unset($plan['$$hashKey']);
				$plan["id_usuario_captura"] = $updateUserId;
				$plan["fecha_captura"] = date('Y-m-d H:i:s');
				$plan["ip_captura"] = $updateIp;
				$plan["host_captura"] = $updateUrl;
				//return "something new... again";
				//return $plan;
				insertPlan($plan);
			}
			else
			{
				//update
				unset($plan['$$hashKey']);
				unset($plan["id_usuario_captura"]);
				unset($plan["fecha_captura"]);
				unset($plan["ip_captura"]);
				unset($plan["host_captura"]);
				$plan["activo"] = 1;
				$plan["id_usuario_actualiza"] = $updateUserId;
				$plan["fecha_actualiza"] = date('Y-m-d H:i:s');
				$plan["ip_actualiza"] = $updateIp;
				$plan["host_actualiza"] = $updateUrl;
				//return "...something old, renewed";
				//return $plan;
				updatePlan($plan);
			}
		}
	}
	return $orderId;
}

function processPlanUpdate($request) {
	$token = decodeUserToken($request);
	$plan = (array) json_decode($request->getBody());
	$instruments = $plan["instrumentos"];
	$containers = $plan["recipientes"];
	$reactives = $plan["reactivos"];
	$materials = $plan["materiales"];
	$coolers = $plan["hieleras"];

	unset($plan["cliente"]);
	unset($plan["orden"]);
	unset($plan["supervisor_muestreo"]);
	unset($plan["puntos"]);
	unset($plan["instrumentos"]);
	unset($plan["recipientes"]);
	unset($plan["reactivos"]);
	unset($plan["materiales"]);
	unset($plan["hieleras"]);
	unset($plan["planes"]);
	unset($plan["tipo_muestreo"]);
	unset($plan["id_usuario_captura"]);
	unset($plan["fecha_captura"]);
	unset($plan["ip_captura"]);
	unset($plan["host_captura"]);

	$plan["id_usuario_actualiza"] = $token->uid;
	$plan["fecha_actualiza"] = date('Y-m-d H:i:s');
	$plan["ip_actualiza"] = $request->getIp();
	$plan["host_actualiza"] = $request->getUrl();

	if ($plan["id_status"] == 2 && strlen($plan["ip_valida"]) < 1)
	{
		$plan["ip_valida"] = $request->getIp();
		$plan["host_valida"] = $request->getUrl();
		$plan["fecha_valida"] = date('Y-m-d H:i:s');
		//TODO: create <blank> Sheet, Reception for this Plan
	}

	$plan["fecha"] = isoDateToMsSql($plan["fecha"]);
	$plan["fecha_probable"] = isoDateToMsSql($plan["fecha_probable"]);
	$plan["fecha_calibracion"] = isoDateToMsSql($plan["fecha_calibracion"]);
	$plan["fecha_valida"] = isoDateToMsSql($plan["fecha_valida"]);
	$plan["fecha_rechaza"] = isoDateToMsSql($plan["fecha_rechaza"]);

	$planUpdateData = array (
		"plan" => $plan,
		"instruments" => $instruments,
		"containers" => $containers,
		"reactives" => $reactives,
		"materials" => $materials,
		"coolers" => $coolers
	);
	return $planUpdateData;
}

function processPlanInstrumentsUpdate($planUpdateData) {
	$instruments = (array) $planUpdateData["instruments"];
	$planId = $planUpdateData["plan"]["id_plan"];
	$storedInstruments = getInstrumentsByPlan($planId);

	$i = 0;
	$j = 0;
	$l = count($storedInstruments);
	$m = count($instruments);

	if ($l < 1)
	{
		for ($j = 0; $j < $m; $j++) {
			$instrument = (array) $instruments[$j];
			unset($instrument["id_plan_instrumento"]);
			unset($instrument["instrumento"]);
			unset($instrument["descripcion"]);
			unset($instrument["muestreo"]);
			unset($instrument["inventario"]);
			unset($instrument["selected"]);
			insertPlanInstrument($instrument);
		}
		return $planId;
	}
	else
	{
		for ($i = 0; $i < $l; $i++) {
			unset($storedInstruments[$i]["instrumento"]);
			unset($storedInstruments[$i]["descripcion"]);
			unset($storedInstruments[$i]["muestreo"]);
			unset($storedInstruments[$i]["inventario"]);
			unset($storedInstruments[$i]["selected"]);
			$storedInstruments[$i]["activo"] = 0;
			updatePlanInstrument($storedInstruments[$i]);
		}
		for ($j = 0; $j < $m; $j++) {
			$instrument = (array) $instruments[$j];
			if ($instrument["id_plan_instrumento"] == 0)
			{
				unset($instrument["id_plan_instrumento"]);
				unset($instrument["instrumento"]);
				unset($instrument["descripcion"]);
				unset($instrument["muestreo"]);
				unset($instrument["inventario"]);
				unset($instrument["selected"]);
				insertPlanInstrument($instrument);
			}
			else
			{
				unset($instrument["instrumento"]);
				unset($instrument["descripcion"]);
				unset($instrument["muestreo"]);
				unset($instrument["inventario"]);
				unset($instrument["selected"]);
				$instrument["activo"] = 1;
				updatePlanInstrument($instrument);
			}
		}
	}
	return $planId;
}

function processPlanContainersUpdate($planUpdateData) {
	$containers = (array) $planUpdateData["containers"];
	$planId = $planUpdateData["plan"]["id_plan"];
	$storedContainers = getContainersByPlan($planId);

	$i = 0;
	$j = 0;
	$l = count($storedContainers);
	$m = count($containers);

	if ($l < 1)
	{
		for ($j = 0; $j < $m; $j++) {
			$newContainer = (array) $containers[$j];
			unset($newContainer["id_plan_recipiente"]);
			unset($newContainer["recipiente"]);
			unset($newContainer["tipo_recipiente"]);
			unset($newContainer["selected"]);
			insertPlanContainer($newContainer);
		}
		return $planId;
	}
	else
	{
		for ($i = 0; $i < $l; $i++) {
			unset($storedContainers[$i]["recipiente"]);
			unset($storedContainers[$i]["tipo_recipiente"]);
			unset($storedContainers[$i]["selected"]);
			$storedContainers[$i]["activo"] = 0;
			updatePlanContainer($storedContainers[$i]);
		}
		for ($j = 0; $j < $m; $j++) {
			$container = (array) $containers[$j];
			if ($container["id_plan_recipiente"] == 0)
			{
				unset($container["id_plan_recipiente"]);
				unset($container["recipiente"]);
				unset($container["tipo_recipiente"]);
				unset($container["selected"]);
				insertPlanContainer($container);
			}
			else
			{
				unset($container["recipiente"]);
				unset($container["tipo_recipiente"]);
				unset($container["selected"]);
				$container["activo"] = 1;
				updatePlanContainer($container);
			}
		}
	}
	return $planId;
}

function processPlanReactivesUpdate($planUpdateData) {
	$reactives = (array) $planUpdateData["reactives"];
	$planId = $planUpdateData["plan"]["id_plan"];
	deletePlanReactives($planId);
	$i = 0;
	$l = count($reactives);
	for ($i = 0; $i < $l; $i++) {
		$newReactive = (array) $reactives[$i];
		unset($newReactive["id_plan_reactivo"]);
		unset($newReactive["id_tipo_reactivo"]);
		unset($newReactive["reactivo"]);
		unset($newReactive["registra_valor"]);
		unset($newReactive["activo"]);
		unset($newReactive["selected"]);
		insertPlanReactive($newReactive);
	}
	return $planId;
}

function processPlanMaterialsUpdate($planUpdateData) {
	$materials = (array) $planUpdateData["materials"];
	$planId = $planUpdateData["plan"]["id_plan"];
	deletePlanMaterials($planId);
	$i = 0;
	$l = count($materials);
	for ($i = 0; $i < $l; $i++) {
		$newMaterial = (array) $materials[$i];
		unset($newMaterial["id_plan_material"]);
		unset($newMaterial["material"]);
		unset($newMaterial["activo"]);
		unset($newMaterial["selected"]);
		insertPlanMaterial($newMaterial);
	}
	return $planId;
}

function processPlanCoolersUpdate($planUpdateData) {
	$coolers = (array) $planUpdateData["coolers"];
	$planId = $planUpdateData["plan"]["id_plan"];
	deletePlanCoolers($planId);
	$i = 0;
	$l = count($coolers);
	for ($i = 0; $i < $l; $i++) {
		$newCooler = (array) $coolers[$i];
		unset($newCooler["id_plan_hielera"]);
		unset($newCooler["hielera"]);
		unset($newCooler["activo"]);
		unset($newCooler["selected"]);
		insertPlanCooler($newCooler);
	}
	return $planId;
}

function processSheetUpdate($request) {
	$token = decodeUserToken($request);
	$update = (array) json_decode($request->getBody());
	$preservations = $update["preservaciones"];
	$samples = $update["muestras"];

	unset($update["orden"]);
	unset($update["norma"]);
	unset($update["parametros"]);
	unset($update["preservaciones"]);
	unset($update["muestras"]);

	unset($update["id_usuario_captura"]);
	unset($update["fecha_captura"]);
	unset($update["ip_captura"]);
	unset($update["host_captura"]);

	$update["id_usuario_actualiza"] = $token->uid;
	$update["fecha_actualiza"] = date('Y-m-d H:i:s');
	$update["ip_actualiza"] = $request->getIp();
	$update["host_actualiza"] = $request->getUrl();

	$update["fecha_muestreo"] = isoDateToMsSql($update["fecha_muestreo"]);
	$update["fecha_entrega"] = isoDateToMsSql($update["fecha_entrega"]);
	$update["fecha_rechaza"] = isoDateToMsSql($update["fecha_rechaza"]);

	if ($update["id_status"] == 2 && strlen($update["ip_valida"]) < 1)
	{
		$update["ip_valida"] = $request->getIp();
		$update["host_valida"] = $request->getUrl();
		$update["fecha_valida"] = isoDateToMsSql($update["fecha_valida"]);
	}

	$sheetUpdateData = array(
		"sheet" => $update,
		"preservations" => $preservations,
		"samples" => $samples
	);
	return $sheetUpdateData;
}

function processSheetPreservationsUpdate($sheetUpdateData) {
	$preservations = (array) $sheetUpdateData["preservations"];
	$sheetId = $sheetUpdateData["sheet"]["id_hoja"];
	$storedPreservations = getPreservationsBySheet($sheetId);

	$i = 0;
	$j = 0;
	$l = count($storedPreservations);
	$m = count($preservations);

	if ($l < 1)
	{
		for ($j = 0; $j < $m; $j++) {
			$preservation = (array) $preservations[$j];
			unset($preservation["id_hoja_preservacion"]);
			unset($preservation["id_tipo_preservacion"]);
			unset($preservation["preservacion"]);
			unset($preservation["descripcion"]);
			unset($preservation["selected"]);
			insertSheetPreservation($preservation);
		}
		return $sheetId;
	}
	else
	{
		for ($i = 0; $i < $l; $i++) {
			unset($storedPreservations[$i]["id_tipo_preservacion"]);
			unset($storedPreservations[$i]["preservacion"]);
			unset($storedPreservations[$i]["descripcion"]);
			unset($storedPreservations[$i]["selected"]);
			$storedPreservations[$i]["activo"] = 0;
			updateSheetPreservation($storedPreservations[$i]);
		}
		for ($j = 0; $j < $m; $j++) {
			$preservation = (array) $preservations[$j];
			if ($preservation["id_hoja_preservacion"] == 0)
			{
				unset($preservation["id_hoja_preservacion"]);
				unset($preservation["id_tipo_preservacion"]);
				unset($preservation["preservacion"]);
				unset($preservation["descripcion"]);
				unset($preservation["selected"]);
				insertSheetPreservation($preservation);
			}
			else
			{
				unset($preservation["id_tipo_preservacion"]);
				unset($preservation["preservacion"]);
				unset($preservation["descripcion"]);
				unset($preservation["selected"]);
				$preservation["activo"] = 1;
				updateSheetPreservation($preservation);
			}
		}
	}
	return $sheetId;
}

function processSheetResultsUpdate($sheetUpdateData) {
	$samples = (array) $sheetUpdateData["samples"];
	$sheetId = $sheetUpdateData["sheet"]["id_hoja"];
	$userId = $sheetUpdateData["sheet"]["id_usuario_actualiza"];
	$storedResults = getResultsBySheet($sheetId);
	$results = array();

	$i = 0;
	$j = 0;
	$k = 0;
	$l = count($storedResults);
	$m = count($samples);
	$n = 0;

	for ($j = 0; $j < $m; $j++) {
		$sample = (array) $samples[$i];
		$sampleResults = (array) $sample["resultados"];
		$n = count($sampleResults);
		for ($k = 0; $k < $n; $k++) {
			$result = (array) $sampleResults[$k];
			unset($result["param"]);
			unset($result['$$hashKey']);
			$results[] = $result;
		}
	}

	if ($l < 1)
	{
		for ($j = 0; $j < $m; $j++) {
			$result = (array) $results[$j];
			$result["id_usuario_captura"] = $userId;
			$result["fecha_captura"] = date('Y-m-d H:i:s');
			unset($result["id_usuario_actualiza"]);
			unset($result["fecha_actualiza"]);
			insertResult($result);
		}
		return $sheetId;
	}
	else
	{
		for ($i = 0; $i < $l; $i++) {
			$storedResults[$i]["id_usuario_actualiza"] = $userId;
			$storedResults[$i]["fecha_actualiza"] = date('Y-m-d H:i:s');
			$storedResults[$i]["activo"] = 0;
			unset($storedResults[$i]["id_usuario_captura"]);
			unset($storedResults[$i]["fecha_captura"]);
			unset($storedResults[$i]["param"]);
			updateResult($storedResults[$i]);
		}
		$m = count($results);
		for ($j = 0; $j < $m; $j++) {
			$result = (array) $results[$j];
			if ($result["id_resultado"] == 0)
			{
				$result["id_usuario_captura"] = $userId;
				$result["fecha_captura"] = date('Y-m-d H:i:s');
				unset($result["id_usuario_actualiza"]);
				unset($result["fecha_actualiza"]);
				insertResult($result);
			}
			else
			{
				$result["id_usuario_actualiza"] = $userId;
				$result["fecha_actualiza"] = date('Y-m-d H:i:s');
				$result["activo"] = 1;
				unset($result["id_usuario_captura"]);
				unset($result["fecha_captura"]);
				updateResult($result);
			}
		}
	}
	return $sheetId;
}

//TODO: workout how to inert automatically elements: Sheet, Reception, etc
function processReceptionInsert($request) {
	return $request;
}

function processReceptionUpdate($request) {
	$token = decodeUserToken($request);
	$update = (array) json_decode($request->getBody());
	$samples = $update["muestras"];
	$preservations = $update["preservaciones"];
	$areas = $update["areas"];

	// //MODEL
	// id_orden,
	// id_plan,
	// id_hoja,
	// id_recepcionista,
	// id_verificador,
	// id_muestra_validacion,
	// id_status,
	// id_usuario_valida,
	// id_usuario_entrega,
	// id_usuario_actualiza,
	// fecha_entrega,
	// fecha_recibe,
	// fecha_verifica,
	// fecha_valida,
	// fecha_actualiza,
	// ip_valida,
	// ip_actualiza,
	// host_valida,
	// host_actualiza,
	// comentarios,
	// motivo_rechaza,
	// activo
	// 
	// //RECEIVED DATA
	// 
	// 
	// unset($update["orden"]);
	// unset($update["norma"]);
	// unset($update["parametros"]);
	// unset($update["preservaciones"]);
	// unset($update["muestras"]);

	// unset($update["id_usuario_captura"]);
	// unset($update["fecha_captura"]);
	// unset($update["ip_captura"]);
	// unset($update["host_captura"]);

	// $update["id_usuario_actualiza"] = $token->uid;
	// $update["fecha_actualiza"] = date('Y-m-d H:i:s');
	// $update["ip_actualiza"] = $request->getIp();
	// $update["host_actualiza"] = $request->getUrl();

	// $update["fecha_muestreo"] = isoDateToMsSql($update["fecha_muestreo"]);
	// $update["fecha_entrega"] = isoDateToMsSql($update["fecha_entrega"]);
	// $update["fecha_rechaza"] = isoDateToMsSql($update["fecha_rechaza"]);

	// if ($update["id_status"] == 2 && strlen($update["ip_valida"]) < 1)
	// {
	// 	$update["ip_valida"] = $request->getIp();
	// 	$update["host_valida"] = $request->getUrl();
	// 	$update["fecha_valida"] = isoDateToMsSql($update["fecha_valida"]);
	// }

	$receptionUpdateData = array(
		"reception" = $update,
		"samples" = $samples,
		"preservations" = $preservations,
		"areas" = $areas,
	);
	return $receptionUpdateData;
}

function processReceptionSamplesUpdate($receptionUpdateData) {
	$samples = (array) $receptionUpdateData["samples"];
	$receptionId = $receptionUpdateData["reception"]["id_reception"];
	$storedSamples = getSamplesByReception($receptionId);

	$i = 0;
	$j = 0;
	$l = count($storedSamples);
	$m = count($samples);

	// if ($l < 1)
	// {
	// 	for ($j = 0; $j < $m; $j++) {
	// 		$sample = (array) $samples[$j];
	// 		unset($sample["id_hoja_preservacion"]);
	// 		unset($sample["id_tipo_preservacion"]);
	// 		unset($sample["preservacion"]);
	// 		unset($sample["descripcion"]);
	// 		unset($sample["selected"]);
	// 		insertReceptionSample($sample);
	// 	}
	// 	return $receptionId;
	// }
	return $receptionId;
}