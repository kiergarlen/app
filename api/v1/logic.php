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
	return "1970-01-01 00:00";
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
	if (is_numeric($lastStudy["oficio"])) {
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
		if (isset($order["fecha_entrega"])) {
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

	if ($updateData["id_status"] == 2 && strlen($updateData["ip_valida"]) < 1) {
		$updateData["ip_valida"] = $request->getIp();
		$updateData["host_valida"] = $request->getUrl();
		$updateData["fecha_valida"] = isoDateToMsSql($updateData["fecha_valida"]);
	}

	$updateData["fecha"] = isoDateToMsSql($updateData["fecha"]);
	$updateData["fecha_entrega"] = isoDateToMsSql($updateData["fecha_entrega"]);
	$updateData["fecha_rechaza"] = isoDateToMsSql($updateData["fecha_rechaza"]);

	$studyUpdateData = array(
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
		//stored empty, insert all
		for ($j = 0; $j < $m; $j++) {
			$newOrder = (array) $orders[$j];
			unset($newOrder["id_orden"]);
			unset($newOrder['$$hashKey']);
			$newOrder["id_estudio"] = $studyId;
			$newOrder["id_cliente"] = $clientId;
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
			insertOrder($order);
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
			//return json_encode($storedOrders[$i]);
			//return "delete old";
			updateOrder($storedOrders[$i]);
		}
		for ($j = 0; $j < $m; $j++) {
			$order = (array) $orders[$i];
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
				//return json_encode($order);
				insertOrder($order);
			}
			else
			{
				//update
				unset($order['$$hashKey']);
				$order["activo"] = 1;
				$order["id_usuario_actualiza"] = $updateUserId;
				$order["fecha_actualiza"] = date('Y-m-d H:i:s');
				$order["ip_actualiza"] = $updateIp;
				$order["host_actualiza"] = $updateUrl;
				//return "...something old";
				//return json_encode($order);
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
	$updateData = (array) json_decode($request->getBody());
	$client = $updateData["cliente"];
	$study = $updateData["estudio"];
	$plans = $updateData["planes"];

	unset($updateData["cliente"]);
	unset($updateData["estudio"]);
	unset($updateData["planes"]);
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
	$updateData["fecha_rechaza"] = isoDateToMsSql($updateData["fecha_rechaza"]);

	$orderUpdateData = array(
		"order" => $updateData,
		"plans" => $plans
	);
	return $orderUpdateData;
}

function processOrderPlansUpdate($orderUpdateData) {
	$orderData = $orderUpdateData["order"];
	$orderId = $orderData["id_orden"];
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
		//stored empty, insert all
		for ($j = 0; $j < $m; $j++) {
			$plan = (array) $plans[$j];
			unset($plan["id_plan"]);
			unset($plan['$$hashKey']);
			$plan["id_orden"] = $orderId;
			$plan["id_usuario_captura"] = $orderData["id_usuario_captura"];
			$plan["fecha_captura"] = date('Y-m-d H:i:s');
			$plan["ip_captura"] = $orderData["ip_captura"];
			$plan["host_captura"] = $orderData["host_captura"];
			$plan["fecha"] = "";
			$plan["fecha_probable"] = isoDateToMsSql($plan["fecha_probable"]);
			$plan["fecha_calibracion"] = "";
			$plan["fecha_valida"] = "";
			$plan["fecha_actualiza"] = "";
			$plan["fecha_rechaza"] = "";
			//return json_encode($plan);
			insertPlan($plan);
		}
		//return "all new";
		return $orderId;
	}
	else
	{
		//mark all stored as deleted, only additions/matches persist
		for ($i = 0; $i < $l; $i++) {
			$storedPlans[$i]["activo"] = 0;
			$storedPlans[$i]["id_usuario_actualiza"] = $orderData["id_usuario_actualiza"];
			$storedPlans[$i]["fecha_actualiza"] = date('Y-m-d H:i:s');
			$storedPlans[$i]["ip_actualiza"] = $orderData["ip_actualiza"];
			$storedPlans[$i]["host_actualiza"] = $orderData["host_actualiza"];
			//return json_encode($storedPlans[$i]);
			//return "delete old";
			updatePlan($storedPlans[$i]);
		}
		for ($j = 0; $j < $m; $j++) {
			$plan = (array) $plans[$j];
			if ($plan["id_plan"] == 0)
			{
				//new, store it
				unset($updatedData[$j]["id_plan"]);
				unset($plan['$$hashKey']);
				$plan["id_usuario_captura"] = $orderData["id_usuario_captura"];
				$plan["fecha_captura"] = date('Y-m-d H:i:s');
				$plan["ip_captura"] = $orderData["ip_captura"];
				$plan["host_captura"] = $orderData["host_captura"];
				//return "something new...";
				//return json_encode($plan);
				insertPlan($plan);
			}
			else
			{
				//update
				unset($plan['$$hashKey']);
				$plan["activo"] = 1;
				$plan["id_usuario_actualiza"] = $orderData["id_usuario_actualiza"];
				$plan["fecha_actualiza"] = date('Y-m-d H:i:s');
				$plan["ip_actualiza"] = $orderData["ip_actualiza"];
				$plan["host_actualiza"] = $orderData["host_actualiza"];
				//return "...something old";
				//return json_encode($plan);
				updatePlan($plan);
			}
		}
	}
	//return "done";
	return $orderId;
}
