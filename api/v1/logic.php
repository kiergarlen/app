<?php
//PROCESSING FUNCTIONS

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
  //// Token expires 192 hours from now
  $token["exp"] = time() + (192 * 60 * 60);
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
    //   return array("success" => "Ip match");
    // }
    // else
    // {
    //   return array("error" => "Ip mismatch");
    // }
    return $decoded;
  } catch (Exception $e) {
    $app->response()->status(401);
    $app->response()->header('X-Status-Reason', $e->getMessage());
  }
}

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
      // add submenu
      $output .= ',';
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
  if (strlen($dateString) > 10)
  {
    return $dateString;
    // $dateString = substr($dateString, 0, 19);
    // $dateString = str_replace("T", " ", $dateString);
    if (DateTime::createFromFormat($format, $dateString))
    {
      // $date = DateTime::createFromFormat($format, $dateString);
      // return $date->format($format);
    }
  }
  if (strlen($dateString) == 10)
  {
    // $date = DateTime::createFromFormat('Y-m-d', $dateString);
    return $dateString;
    // return $date->format($format);
  }
  return NULL;
}

function processStudyInsert($request) {
  $token = decodeUserToken($request);
  $insertData = (array) json_decode($request->getBody());
  $lastStudyNumber = 0;
  $currentYear = date("Y");
  $clientId = $insertData["id_cliente"];
  $orders = $insertData["ordenes"];

  unset($insertData["cliente"]);
  unset($insertData["ordenes"]);
  unset($insertData["id_estudio"]);
  unset($insertData["id_usuario_actualiza"]);
  unset($insertData["fecha_actualiza"]);
  unset($insertData["host_actualiza"]);
  unset($insertData["ip_actualiza"]);
  unset($insertData["fecha_captura"]);

  $lastStudy = (array) getLastStudyByYear($currentYear);
  if (is_numeric($lastStudy["oficio"]))
  {
    $lastStudyNumber = $lastStudy["oficio"];
  }

  $lastStudyNumber = $lastStudyNumber + 1;
  $folio = "CEA-" . str_pad($lastStudyNumber, 3, "0", STR_PAD_LEFT);
  $folio .= "-" . $currentYear;

  $insertData["id_status"] = 1;
  $insertData["id_etapa"] = 1;
  $insertData["oficio"] = $lastStudyNumber;
  $insertData["folio"] = $folio;
  $insertData["fecha"] = isoDateToMsSql($insertData["fecha"]);
  $insertData["id_usuario_captura"] = $token->uid;
  $insertData["ip_captura"] = $request->getIp();
  $insertData["host_captura"] = $request->getUrl();
  $insertData["fecha_rechaza"] = NULL;

  if ($insertData["id_status"] == 3) {
    $insertData["fecha_rechaza"] = $insertData["fecha"];
    $insertData["id_usuario_rechaza"] = $insertData["id_usuario_captura"];
    $insertData["ip_rechaza"] = $insertData["ip_captura"];
    $insertData["host_rechaza"] = $insertData["host_captura"];
  }

  $insertData["fecha_valida"] = NULL;
  if ($insertData["id_status"] == 2) {
    $insertData["fecha_valida"] = $insertData["fecha_valida"];
    $insertData["id_usuario_valida"] = $insertData["id_usuario_captura"];
    $insertData["ip_valida"] = $insertData["ip_captura"];
    $insertData["host_valida"] = $insertData["host_captura"];
  }

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
  $insertIp = $studyInsertData["study"]["ip_captura"];
  $insertUrl = $studyInsertData["study"]["host_captura"];

  // $blankPlan = getBlankPlan();
  // unset($blankPlan["id_plan"]);
  // $blankPlan["id_estudio"] = $studyId;
  // $blankPlan["id_usuario_captura"] = $insertUserId;
  // $blankPlan["fecha_captura"] = $insertDate;
  // $blankPlan["ip_captura"] = $insertIp;
  // $blankPlan["host_captura"] = $insertUrl;

  $i = 0;
  $l = count($orders);

  for ($i = 0; $i < $l; $i++)
  {
    $order = (array) $orders[$i];

    unset($order['$$hashKey']);
    unset($order["id_orden"]);
    unset($order["fecha_captura"]);
    unset($order["id_usuario_actualiza"]);
    unset($order["fecha_actualiza"]);
    unset($order["ip_actualiza"]);
    unset($order["host_actualiza"]);

    $order["id_estudio"] = $studyId;
    $order["id_cliente"] = $clientId;
    $order["id_cuerpo_receptor"] = 5;
    $order["id_status"] = 1;
    $order["costo_total"] = 0;
    $order["id_usuario_captura"] = $insertUserId;
    $order["fecha"] = isoDateToMsSql($order["fecha"]);
    $order["fecha_valida"] = isoDateToMsSql($order["fecha_valida"]);
    $order["fecha_rechaza"] = isoDateToMsSql($order["fecha_rechaza"]);
    $order["ip_captura"] = $insertIp;
    $order["host_captura"] = $insertUrl;
    $order["activo"] = 1;
    $orderId = insertOrder($order);
    // //assign this order's ID to blank plan
    // $blankPlan["id_orden"] = $orderId;
    // $planId = insertPlan($blankPlan);
  }
  return $studyId;
}

function processStudyUpdate($request) {
  $token = decodeUserToken($request);
  $updateData = (array) json_decode($request->getBody());
  $studyId = $updateData["id_estudio"];
  $clientId = $updateData["id_cliente"];
  $orders = $updateData["ordenes"];

  unset($updateData["cliente"]);
  unset($updateData["ordenes"]);
  unset($updateData["status"]);
  unset($updateData["id_usuario_captura"]);
  unset($updateData["fecha_captura"]);
  unset($updateData["fecha_actualiza"]);
  unset($updateData["ip_captura"]);
  unset($updateData["host_captura"]);

  $updateData["id_usuario_actualiza"] = $token->uid;
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
  $updateIp = $studyUpdateData["study"]["ip_actualiza"];
  $updateUrl = $studyUpdateData["study"]["host_actualiza"];
  $storedOrders = getOrdersByStudy($studyId);

  $i = 0;
  $j = 0;
  $l = count($storedOrders);
  $m = count($orders);

  if ($l < 1)
  {
    for ($j = 0; $j < $m; $j++) {
      if ($orders[$j]->id_orden < 1) {
        $newOrder = (array) $orders[$j];
        unset($newOrder['$$hashKey']);
        unset($newOrder["id_orden"]);
        unset($newOrder["id_usuario_actualiza"]);
        unset($newOrder['fecha_captura']);
        unset($newOrder["fecha_actualiza"]);
        unset($newOrder["ip_actualiza"]);
        unset($newOrder["host_actualiza"]);

        $newOrder["id_estudio"] = $studyId;
        $newOrder["id_cliente"] = $clientId;
        //TODO: Get from catalog
        $newOrder["id_cuerpo_receptor"] = 5;
        $newOrder["fecha"] = isoDateToMsSql($newOrder["fecha"]);
        $newOrder["id_usuario_captura"] = $updateUserId;
        $newOrder["ip_captura"] = $updateIp;
        $newOrder["host_captura"] = $updateUrl;
        $newOrder["fecha_valida"] = isoDateToMsSql($newOrder["fecha_valida"]);
        $newOrder["fecha_rechaza"] = isoDateToMsSql($newOrder["fecha_rechaza"]);
        insertOrder($newOrder);
      }
    }
    return $studyId;
  }
  else
  {
    for ($i = 0; $i < $l; $i++) {
      unset($storedOrders[$i]["cliente"]);
      unset($storedOrders[$i]["estudio"]);
      unset($storedOrders[$i]["planes"]);
      unset($storedOrders[$i]['$$hashKey']);
      unset($storedOrders[$i]["id_usuario_captura"]);
      unset($storedOrders[$i]["fecha_actualiza"]);
      unset($storedOrders[$i]["fecha_captura"]);
      unset($storedOrders[$i]["ip_captura"]);
      unset($storedOrders[$i]["host_captura"]);
      $storedOrders[$i]["activo"] = 0;
      $storedOrders[$i]["fecha"] = isoDateToMsSql($storedOrders[$i]["fecha"]);
      $storedOrders[$i]["id_usuario_actualiza"] = $updateUserId;
      $storedOrders[$i]["ip_actualiza"] = $updateIp;
      $storedOrders[$i]["host_actualiza"] = $updateUrl;
      updateOrder($storedOrders[$i]);
    }

    for ($j = 0; $j < $m; $j++) {
      $order = (array) $orders[$j];
      if ($order["id_orden"] < 1)
      {
        unset($order['$$hashKey']);
        unset($order["id_orden"]);
        unset($order["id_usuario_actualiza"]);
        unset($order['fecha_captura']);
        unset($order["fecha_actualiza"]);
        unset($order["ip_actualiza"]);
        unset($order["host_actualiza"]);

        $order["id_estudio"] = $studyId;
        $order["id_cliente"] = $clientId;
        //TODO: Get from catalog
        $order["id_cuerpo_receptor"] = 5;

        $order["fecha"] = isoDateToMsSql($order["fecha"]);
        $order["id_usuario_captura"] = $updateUserId;
        $order["ip_captura"] = $updateIp;
        $order["host_captura"] = $updateUrl;
        $order["fecha_valida"] = isoDateToMsSql($order["fecha_valida"]);
        $order["fecha_rechaza"] = isoDateToMsSql($order["fecha_rechaza"]);
        insertOrder($order);
      }
      else
      {
        unset($order["cliente"]);
        unset($order["estudio"]);
        unset($order["planes"]);
        unset($order['$$hashKey']);
        unset($order["id_usuario_captura"]);
        unset($order["fecha_actualiza"]);
        unset($order["fecha_captura"]);
        unset($order["ip_captura"]);
        unset($order["host_captura"]);
        $order["activo"] = 1;
        $order["fecha"] = isoDateToMsSql($order["fecha"]);
        $order["id_usuario_actualiza"] = $updateUserId;
        $order["ip_actualiza"] = $updateIp;
        $order["host_actualiza"] = $updateUrl;
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
  unset($update["fecha_actualiza"]);
  unset($update["id_usuario_captura"]);
  unset($update["fecha_captura"]);
  unset($update["ip_captura"]);
  unset($update["host_captura"]);

  $update["id_usuario_actualiza"] = $token->uid;
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

  //TODO: refactor with array_walk() & use single transaction
  if ($l < 1)
  {
    for ($j = 0; $j < $m; $j++) {
      $plan = (array) $plans[$j];
      unset($plan['$$hashKey']);
      unset($plan["id_plan"]);
      unset($plan["fecha_captura"]);
      unset($plan["id_usuario_actualiza"]);
      unset($plan["ip_actualiza"]);
      unset($plan["host_actualiza"]);
      $plan["id_estudio"] = $orderData["id_estudio"];
      $plan["id_orden"] = $orderId;
      $supervisorId = $plan["id_supervisor_muestreo"];
      $plan["id_supervisor_entrega"] = $supervisorId;
      $plan["id_supervisor_recoleccion"] = $supervisorId;
      $plan["id_supervisor_registro"] = $supervisorId;
      $plan["id_ayudante_entrega"] = $supervisorId;
      $plan["id_ayudante_recoleccion"] = $supervisorId;
      $plan["id_ayudante_registro"] = $supervisorId;
      $plan["id_responsable_calibracion"] = $supervisorId;
      $plan["id_responsable_recipientes"] = $supervisorId;
      $plan["id_responsable_reactivos"] = $supervisorId;
      $plan["id_responsable_material"] = $supervisorId;
      $plan["id_responsable_hieleras"] = $supervisorId;
      $plan["id_usuario_captura"] = $updateUserId;
      $plan["ip_captura"] = $updateIp;
      $plan["host_captura"] = $updateUrl;
      $plan["fecha"] = NULL;
      $plan["fecha_probable"] = isoDateToMsSql($plan["fecha_probable"]);
      $plan["fecha_calibracion"] = NULL;
      $plan["fecha_actualiza"] = NULL;
      $plan["fecha_valida"] = NULL;
      $plan["fecha_rechaza"] = NULL;
      insertPlan($plan);
    }
    return $orderId;
  }
  else
  {
    for ($i = 0; $i < $l; $i++) {
      unset($storedPlans[$i]['$$hashKey']);
      unset($storedPlans[$i]["fecha_actualiza"]);
      unset($storedPlans[$i]["id_usuario_captura"]);
      unset($storedPlans[$i]["fecha_captura"]);
      unset($storedPlans[$i]["ip_captura"]);
      unset($storedPlans[$i]["host_captura"]);
      $storedPlans[$i]["activo"] = 0;
      $storedPlans[$i]["id_usuario_actualiza"] = $updateUserId;
      $storedPlans[$i]["ip_actualiza"] = $updateIp;
      $storedPlans[$i]["host_actualiza"] = $updateUrl;
      updatePlan($storedPlans[$i]);
    }
    for ($j = 0; $j < $m; $j++) {
      $plan = (array) $plans[$j];
      if ($plan["id_plan"] == 0)
      {
        unset($plan['$$hashKey']);
        unset($plan["id_plan"]);
        unset($plan["fecha_captura"]);
        unset($plan["id_usuario_actualiza"]);
        unset($plan["ip_actualiza"]);
        unset($plan["host_actualiza"]);
        $plan["id_estudio"] = $orderData["id_estudio"];
        $plan["id_orden"] = $orderId;
        $supervisorId = $plan["id_supervisor_muestreo"];
        $plan["id_supervisor_entrega"] = $supervisorId;
        $plan["id_supervisor_recoleccion"] = $supervisorId;
        $plan["id_supervisor_registro"] = $supervisorId;
        $plan["id_ayudante_entrega"] = $supervisorId;
        $plan["id_ayudante_recoleccion"] = $supervisorId;
        $plan["id_ayudante_registro"] = $supervisorId;
        $plan["id_responsable_calibracion"] = $supervisorId;
        $plan["id_responsable_recipientes"] = $supervisorId;
        $plan["id_responsable_reactivos"] = $supervisorId;
        $plan["id_responsable_material"] = $supervisorId;
        $plan["id_responsable_hieleras"] = $supervisorId;
        $plan["id_usuario_captura"] = $updateUserId;
        $plan["ip_captura"] = $updateIp;
        $plan["host_captura"] = $updateUrl;
        $plan["fecha"] = NULL;
        $plan["fecha_probable"] = isoDateToMsSql($plan["fecha_probable"]);
        $plan["fecha_calibracion"] = NULL;
        $plan["fecha_actualiza"] = NULL;
        $plan["fecha_valida"] = NULL;
        $plan["fecha_rechaza"] = NULL;
        insertPlan($plan);
      }
      else
      {
        unset($plan['$$hashKey']);
        unset($plan["fecha_actualiza"]);
        unset($plan["id_usuario_captura"]);
        unset($plan["fecha_captura"]);
        unset($plan["ip_captura"]);
        unset($plan["host_captura"]);
        $plan["activo"] = 1;
        $plan["id_usuario_actualiza"] = $updateUserId;
        $plan["ip_actualiza"] = $updateIp;
        $plan["host_actualiza"] = $updateUrl;
        updatePlan($plan);
      }
    }
  }
  return $orderId;
}

function processPlanUpdate($request) {
  $token = decodeUserToken($request);
  $plan = (array) json_decode($request->getBody());
  $planUpdateData = $plan;
  $instruments = $plan["instrumentos"];
  $containers = $plan["recipientes"];
  $preservations = $plan["preservaciones"];
  $points = $plan["puntos"];
  $reactives = $plan["reactivos"];
  $materials = $plan["materiales"];
  $coolers = $plan["hieleras"];

  unset($plan["cliente"]);
  unset($plan["orden"]);
  unset($plan["supervisor_muestreo"]);
  unset($plan["puntos"]);
  unset($plan["instrumentos"]);
  unset($plan["recipientes"]);
  unset($plan["preservaciones"]);
  unset($plan["reactivos"]);
  unset($plan["materiales"]);
  unset($plan["hieleras"]);
  unset($plan["planes"]);
  unset($plan["tipo_muestreo"]);
  unset($plan["id_usuario_captura"]);
  unset($plan["fecha_captura"]);
  unset($plan["ip_captura"]);
  unset($plan["host_captura"]);
  unset($plan["fecha_actualiza"]);

  $plan["id_usuario_actualiza"] = $token->uid;
  $plan["ip_actualiza"] = $request->getIp();
  $plan["host_actualiza"] = $request->getUrl();

  if ($plan["id_status"] == 2 && strlen($plan["ip_valida"]) < 1)
  {
    $plan["ip_valida"] = $request->getIp();
    $plan["host_valida"] = $request->getUrl();
    $plan["fecha_valida"] = isoDateToMsSql($plan["fecha_valida"]);
    //TODO: create <blank> Sheet, Reception for this Plan
    insertPlanBlankElements($plan);
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
    "preservations" => $preservations,
    "points" => $points,
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

function processPlanPreservationsUpdate($planUpdateData) {
  $preservations = (array) $planUpdateData["preservations"];
  $planId = $planUpdateData["plan"]["id_plan"];
  $storedPreservations = getPreservationsByPlan($planId);
  $i = 0;
  $j = 0;
  $l = count($storedPreservations);
  $m = count($preservations);

  if ($l < 1)
  {
    for ($j = 0; $j < $m; $j++) {
      $newPreservation = (array) $preservations[$j];
      unset($newPreservation["id_plan_preservacion"]);
      unset($newPreservation["preservacion"]);
      unset($newPreservation["selected"]);
      insertPlanPreservation($newPreservation);
    }
    return $planId;
  }
  else
  {
    for ($i = 0; $i < $l; $i++) {
      unset($storedPreservations[$i]["preservacion"]);
      unset($storedPreservations[$i]["selected"]);
      $storedPreservations[$i]["activo"] = 0;
      updatePlanPreservation($storedPreservations[$i]);
    }
    for ($j = 0; $j < $m; $j++) {
      $preservation = (array) $preservations[$j];
      unset($preservation["preservacion"]);
      unset($preservation["selected"]);
      if ($preservation["id_plan_preservacion"] < 1)
      {
        unset($preservation["id_plan_preservacion"]);
        insertPlanPreservation($preservation);
      }
      else
      {
        $preservation["activo"] = 1;
        updatePlanPreservation($preservation);
      }
    }
  }
  return $planId;
}

function processPlanContainersUpdate($planUpdateData) {
  $containers = (array) $planUpdateData["containers"];
  $preservations = (array) $planUpdateData["preservations"];
  $points = (array) $planUpdateData["points"];
  $planId = $planUpdateData["plan"]["id_plan"];
  $storedContainers = getContainersByPlan($planId);
  $i = 0;
  $j = 0;
  $k = 0;
  $l = count($storedContainers);
  $m = count($containers);
  $n = count($preservations);
  $o = count($points);

  if ($l < 1)
  {
    for ($i = 0; $i < $o; $i++) {
      for ($j = 0; $j < $n; $j++) {
        insertContainer(array(
          "id_plan" => $planId,
          "id_recepcion" => 1,
          "id_muestra" => 1,
          "id_tipo_recipiente" => 1,
          "id_preservacion" => $preservations[$j]->id_preservacion,
          "id_almacenamiento" => 1,
          "id_status_recipiente" => 1,
          "id_usuario_actualiza" => 1,
          "volumen" => 0,
          "volumen_inicial" => 0,
          "fecha_actualizacion" => "",
          "ip_actualiza" => "",
          "host_actualiza" => "",
          "activo" => 1
        ));
      }
    }

    $storedContainers = getPlanContainers($planId);
    $l = count($storedContainers);

    for ($i = 0; $i < $l; $i++) {
      $newContainer = array(
        "id_recipiente" => $storedContainers[$i]["id_recipiente"],
        "id_plan" => $storedContainers[$i]["id_plan"],
        "activo" => 1
      );
      insertPlanContainer($newContainer);
    }
    return $planId;
  }
  // else
  // {
  //   for ($i = 0; $i < $l; $i++) {
  //     $storedContainers[$i]["activo"] = 0;
  //     updatePlanContainer($storedContainers[$i]);
  //   }
  //   for ($j = 0; $j < $m; $j++) {
  //     $container = (array) $containers[$j];
  //     // if ($container["id_plan_recipiente"] < 1)
  //     // {
  //     //   unset($container["id_plan_recipiente"]);
  //     //   insertPlanContainer($container);
  //     // }
  //     if ($container["id_plan_recipiente"] > 0)
  //     {
  //       $container["activo"] = 1;
  //       updatePlanContainer($container);
  //     }
  //   }
  // }
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
      unset($preservation["id_tipo_preservacion"]);
      unset($preservation["preservacion"]);
      unset($preservation["descripcion"]);
      unset($preservation["selected"]);
      if ($preservation["id_hoja_preservacion"] < 1)
      {
        unset($preservation["id_hoja_preservacion"]);
        insertSheetPreservation($preservation);
      }
      else
      {
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

//TODO: insert elements: Sheet, Reception, etc
function processReceptionInsert($request) {
  return $request;
}

function processReceptionUpdate($request) {
  $token = decodeUserToken($request);
  $update = (array) json_decode($request->getBody());
  $samples = $update["muestras"];
  $preservations = $update["preservaciones"];
  $areas = $update["areas"];

  unset($update["hoja"]);
  unset($update["muestras"]);
  unset($update["preservaciones"]);
  unset($update["areas"]);

  unset($update["id_usuario_captura"]);
  unset($update["fecha_captura"]);
  unset($update["ip_captura"]);
  unset($update["host_captura"]);

  $update["id_usuario_actualiza"] = $token->uid;
  $update["fecha_actualiza"] = date('Y-m-d H:i:s');
  $update["ip_actualiza"] = $request->getIp();
  $update["host_actualiza"] = $request->getUrl();

  $update["fecha_entrega"] = isoDateToMsSql($update["fecha_entrega"]);
  $update["fecha_recibe"] = isoDateToMsSql($update["fecha_recibe"]);
  $update["fecha_recibe"] = isoDateToMsSql($update["fecha_recibe"]);
  ////No input in form por this date/time setting to reception date/time
  //$update["fecha_verifica"] = isoDateToMsSql($update["fecha_verifica"]);
  $update["fecha_verifica"] = $update["fecha_recibe"];
  $update["fecha_rechaza"] = isoDateToMsSql($update["fecha_rechaza"]);

  if ($update["id_status"] == 2 && strlen($update["ip_valida"]) < 1)
  {
    $update["ip_valida"] = $request->getIp();
    $update["host_valida"] = $request->getUrl();
    $update["fecha_valida"] = isoDateToMsSql($update["fecha_valida"]);
  }

  $receptionUpdateData = array(
    "reception" => $update,
    "samples" => $samples,
    "preservations" => $preservations,
    "areas" => $areas,
  );
  return $receptionUpdateData;
}

function processReceptionSamplesUpdate($receptionUpdateData) {
  $samples = (array) $receptionUpdateData["samples"];
  $receptionId = $receptionUpdateData["reception"]["id_recepcion"];
  //deleteReceptionSamples($receptionId);
  $i = 0;
  $l = count($samples);
  for ($i = 3; $i < $l; $i++) {
    // insertReceptionSample(
    //  array(
    //    "id_recepcion" => $samples[$i]->id_recepcion,
    //    "id_muestra" => $samples[$i]->id_muestra
    //  )
    // );
  }
  return $receptionId;
}

function processReceptionPreservationsUpdate($receptionUpdateData) {
  $preservations = (array) $receptionUpdateData["preservations"];
  $receptionId = $receptionUpdateData["reception"]["id_recepcion"];
  deleteReceptionPreservations($receptionId);
  $i = 0;
  $l = count($preservations);
  for ($i = 0; $i < $l; $i++) {
    insertReceptionPreservation(
      array(
        "id_recepcion" => $preservations[$i]->id_recepcion,
        "id_preservacion" => $preservations[$i]->id_preservacion,
        "cantidad" => $preservations[$i]->cantidad,
        "preservado" => $preservations[$i]->preservado
      )
    );
  }
  return $receptionId;
}

function processReceptionAreasUpdate($receptionUpdateData) {
  $areas = (array) $receptionUpdateData["areas"];
  $reception = $receptionUpdateData["reception"];
  $receptionId = $reception["id_recepcion"];
  deleteReceptionAreas($receptionId);
  $i = 0;
  $l = count($areas);
  for ($i = 0; $i < $l; $i++) {
    insertReceptionArea(
      array(
        "id_recepcion" => $areas[$i]->id_recepcion,
        "id_area" => $areas[$i]->id_area,
        "id_muestra" => $reception["id_muestra_validacion"],
        "volumen" => $areas[$i]->volumen,
        "vigencia" => $areas[$i]->vigencia,
        "recipiente" => $areas[$i]->recipiente,
      )
    );
  }
  return $receptionId;
}
