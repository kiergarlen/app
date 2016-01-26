<?php
//PROCESSING FUNCTIONS
/**
 * processMenuToJson
 * @param mixed $items
 * @return mixed
 */
function processMenuToJson($items)
{
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
  for ($i = 1; $i < $l; $i++) {
    if ($currentItem["id_menu"] == $items[$i]["id_menu"]) {
      // add submenu
      $output .= ',';
      $currentItem = $items[$i];
    } else {
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

/**
 * isoDateToMsSql
 * @param string $dateString
 * @return mixed
 */
function isoDateToMsSql($dateString)
{
  //$format = "Y-m-d";
  //if (strlen($dateString) > 10)
  //{
  // $parsedDate = substr($dateString, 0, 19);
  // $parsedDate = str_replace("T", " ", $parsedDate);
  // if (DateTime::createFromFormat($format . " H:i:s", $parsedDate))
  // {
  // $date = DateTime::createFromFormat($format, $parsedDate);
  // return $date->format($format);
  // }
  //}
  //if (strlen($dateString) == 10)
  //{
  // $date = DateTime::createFromFormat('Y-m-d', $dateString);
  // return $date->format($format);
  //}
  if (strlen($dateString) > 9) {
    return $dateString;
  }
  return null;
}

/**
 * processStudyInsert
 * @param mixed $request
 * @return mixed
 */
function processStudyInsert($request)
{
  $token = decodeUserToken($request);
  $insertData = (array) json_decode($request->getBody());
  $lastStudyNumber = 0;
  $currentYear = date("Y");
  $clientId = $insertData["id_cliente"];
  $orders = $insertData["ordenes"];

  unset($insertData["cliente"]);
  unset($insertData["ordenes"]);
  unset($insertData["id_estudio"]);
  unset($insertData["fecha_captura"]);
  unset($insertData["id_usuario_actualiza"]);
  unset($insertData["fecha_actualiza"]);
  unset($insertData["host_actualiza"]);
  unset($insertData["ip_actualiza"]);

  $lastStudy = (array) getLastStudyByYear($currentYear);
  if (isset($lastStudy["oficio"]) && is_numeric($lastStudy["oficio"])) {
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

  $insertData["fecha_rechaza"] = null;
  if ($insertData["id_status"] == 3) {
    $insertData["fecha_rechaza"] = isoDateToMsSql($insertData["fecha"]);
    $insertData["id_usuario_rechaza"] = $insertData["id_usuario_captura"];
    $insertData["ip_rechaza"] = $insertData["ip_captura"];
    $insertData["host_rechaza"] = $insertData["host_captura"];
  }

  $insertData["fecha_valida"] = null;
  if ($insertData["id_status"] == 2) {
    $insertData["fecha_valida"] = isoDateToMsSql($insertData["fecha_valida"]);
    $insertData["id_usuario_valida"] = $insertData["id_usuario_captura"];
    $insertData["ip_valida"] = $insertData["ip_captura"];
    $insertData["host_valida"] = $insertData["host_captura"];
  }

  $studyInsertData = array(
    "study" => $insertData,
    "orders" => $orders,
  );
  return $studyInsertData;
}

/**
 * processStudyOrderInsert
 * @param array $studyInsertData
 * @param int $studyId
 * @return mixed
 */
function processStudyOrderInsert($studyInsertData, $studyId)
{
  $orders = (array) $studyInsertData["orders"];

  $study = array(
    "id_estudio" => $studyId,
    "id_cliente" => $studyInsertData["study"]["id_cliente"],
    "id_usuario_actualiza" => $studyInsertData["study"]["id_usuario_captura"],
    "ip_actualiza" => $studyInsertData["study"]["ip_captura"],
    "host_actualiza" => $studyInsertData["study"]["host_captura"],
  );

  $i = 0;
  $l = count($orders);

  for ($i = 0; $i < $l; $i++) {
    $order = (array) $orders[$i];
    processNewOrderInsert($order, $study);
  }
  return $studyId;
}

/**
 * processStudyUpdate
 * @param mixed $request
 * @return mixed
 */
function processStudyUpdate($request)
{
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
    "orders" => $orders,
  );
  return $studyUpdateData;
}

/**
 * processStudyOrderUpdate
 * @param array $studyUpdateData
 * @return mixed
 */
function processStudyOrderUpdate($studyUpdateData)
{
  $orders = (array) $studyUpdateData["orders"];
  $study = $studyUpdateData["study"];
  $studyId = $study["id_estudio"];
  $clientId = $study["id_cliente"];
  $updateUserId = $study["id_usuario_actualiza"];
  $updateIp = $study["ip_actualiza"];
  $updateUrl = $study["host_actualiza"];
  $storedOrders = getOrdersByStudy($studyId);

  $i = 0;
  $j = 0;
  $l = count($storedOrders);
  $m = count($orders);

  if ($l > 0) {
    disableStudyOrders($studyId);
  }

  for ($j = 0; $j < $m; $j++) {
    $order = (array) $orders[$j];
    if ($order["id_orden"] < 1 || $l < 1) {
      processNewOrderInsert($order, $study);
    } else {
      unset($order["cliente"]);
      unset($order["estudio"]);
      unset($order["planes"]);
      unset($order['$$hashKey']);
      unset($order["id_usuario_captura"]);
      unset($order["fecha_captura"]);
      unset($order["ip_captura"]);
      unset($order["host_captura"]);
      unset($order["fecha_actualiza"]);
      $order["activo"] = 1;
      $order["fecha"] = isoDateToMsSql($order["fecha"]);
      $order["id_usuario_actualiza"] = $updateUserId;
      $order["ip_actualiza"] = $updateIp;
      $order["host_actualiza"] = $updateUrl;
      updateOrder($order);
    }
  }

  return $studyId;
}

/**
 * processNewOrderInsert
 * @param array $newOrder
 * @param mixed $study
 */
function processNewOrderInsert($newOrder, $study)
{
  $studyId = $study["id_estudio"];
  $clientId = $study["id_cliente"];
  $updateUserId = $study["id_usuario_actualiza"];
  $updateIp = $study["ip_actualiza"];
  $updateUrl = $study["host_actualiza"];

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
  $newOrder["id_cuerpo"] = 8;
  // $order["id_status"] = 1;
  // $order["costo_total"] = 0;
  $newOrder["id_usuario_captura"] = $updateUserId;
  $newOrder["fecha"] = isoDateToMsSql($newOrder["fecha"]);
  $newOrder["fecha_valida"] = isoDateToMsSql($newOrder["fecha_valida"]);
  $newOrder["fecha_rechaza"] = isoDateToMsSql($newOrder["fecha_rechaza"]);
  $newOrder["ip_captura"] = $updateIp;
  $newOrder["host_captura"] = $updateUrl;
  // $order["activo"] = 1;
  return insertOrder($newOrder);
}

/**
 * processOrderUpdate
 * @param mixed $request
 * @return mixed
 */
function processOrderUpdate($request)
{
  $token = decodeUserToken($request);
  $update = (array) json_decode($request->getBody());
  $client = $update["cliente"];
  $study = $update["estudio"];
  $plans = $update["planes"];

  unset($update["cliente"]);
  unset($update["estudio"]);
  unset($update["planes"]);
  unset($update["status"]);
  // unset($update['$$hashKey']);
  unset($update["id_usuario_captura"]);
  unset($update["fecha_captura"]);
  unset($update["ip_captura"]);
  unset($update["host_captura"]);
  unset($update["fecha_actualiza"]);

  $update["id_usuario_actualiza"] = $token->uid;
  $update["ip_actualiza"] = $request->getIp();
  $update["host_actualiza"] = $request->getUrl();
  $update["fecha"] = isoDateToMsSql($update["fecha"]);
  $update["fecha_rechaza"] = isoDateToMsSql($update["fecha_rechaza"]);

  if ($update["id_status"] == 2 && strlen($update["ip_valida"]) < 1) {
    $update["ip_valida"] = $request->getIp();
    $update["host_valida"] = $request->getUrl();
    $update["fecha_valida"] = isoDateToMsSql($update["fecha_valida"]);
  }

  $orderUpdateData = array(
    "order" => $update,
    "plans" => $plans,
  );
  return $orderUpdateData;
}

/**
 * processOrderPlansUpdate
 * @param array $orderUpdateData
 * @return mixed
 */
function processOrderPlansUpdate($orderUpdateData)
{
  $orderData = $orderUpdateData["order"];
  $orderId = $orderData["id_orden"];
  $updateUserId = $orderData["id_usuario_actualiza"];
  $updateIp = $orderData["ip_actualiza"];
  $updateUrl = $orderData["host_actualiza"];
  $storedPlans = getPlansByOrder($orderId);
  $plans = (array) $orderUpdateData["plans"];

  $i = 0;
  $l = count($plans);
  if (count($storedPlans) > 0) {
    disableOrderPlans($orderId);
  }

  for ($i = 0; $i < $l; $i++) {
    $plan = (array) $plans[$i];
    if ($plan["id_plan"] == 0) {
      unset($plan['$$hashKey']);
      unset($plan["id_plan"]);
      unset($plan["fecha_captura"]);
      unset($plan["fecha_actualiza"]);
      unset($plan["id_usuario_actualiza"]);
      unset($plan["ip_actualiza"]);
      unset($plan["host_actualiza"]);
      $supervisorId = $plan["id_supervisor_muestreo"];
      $plan["id_estudio"] = $orderData["id_estudio"];
      $plan["id_orden"] = $orderId;
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
      $plan["fecha"] = isoDateToMsSql($plan["fecha_probable"]);
      $plan["fecha_probable"] = isoDateToMsSql($plan["fecha_probable"]);
      $plan["fecha_calibracion"] = null;
      $plan["fecha_valida"] = null;
      $plan["fecha_rechaza"] = null;
      insertPlan($plan);
    } else {
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
  return $orderId;
}

/**
 * processPlanUpdate
 * @param mixed $request
 * @return mixed
 */
function processPlanUpdate($request)
{
  $token = decodeUserToken($request);
  $plan = (array) json_decode($request->getBody());
  $client = $plan["cliente"];
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

  if ($plan["id_status"] == 2 && strlen($plan["ip_valida"]) < 1) {
    $plan["ip_valida"] = $request->getIp();
    $plan["host_valida"] = $request->getUrl();
    $plan["fecha_valida"] = isoDateToMsSql($plan["fecha_valida"]);
    //TODO: advance Study stage
  }

  $plan["fecha"] = isoDateToMsSql($plan["fecha"]);
  $plan["fecha_probable"] = isoDateToMsSql($plan["fecha_probable"]);
  $plan["fecha_calibracion"] = isoDateToMsSql($plan["fecha_calibracion"]);
  $plan["fecha_valida"] = isoDateToMsSql($plan["fecha_valida"]);
  $plan["fecha_rechaza"] = isoDateToMsSql($plan["fecha_rechaza"]);

  $planUpdateData = array(
    "plan" => $plan,
    "client" => $client,
    "instruments" => $instruments,
    "containers" => $containers,
    "preservations" => $preservations,
    "points" => $points,
    "reactives" => $reactives,
    "materials" => $materials,
    "coolers" => $coolers,
  );
  return $planUpdateData;
}

/**
 * processPlanSheetInsert
 * @param array $planUpdateData
 * @return mixed
 */
function processPlanSheetInsert($planUpdateData)
{
  $plan = (array) $planUpdateData["plan"];
  $client = (array) $planUpdateData["client"];
  $planId = $plan["id_plan"];
  $sheets = getSheetsByPlan($planId);
  if (count($sheets) < 1) {
    $sheetData = getBlankSheet();
    unset($sheetData["id_hoja"]);
    unset($sheetData["fecha_captura"]);
    unset($sheetData["id_usuario_actualiza"]);
    unset($sheetData["fecha_actualiza"]);
    unset($sheetData["ip_actualiza"]);
    unset($sheetData["host_actualiza"]);

    $sheetData["id_estudio"] = $plan["id_estudio"];
    $sheetData["id_cliente"] = $client["id_cliente"];
    $sheetData["id_orden"] = $plan["id_orden"];
    $sheetData["id_plan"] = $plan["id_plan"];
    $sheetData["id_paquete"] = $plan["id_paquete"];
    $sheetData["id_usuario_captura"] = $plan["id_usuario_actualiza"];
    $sheetData["ip_captura"] = $plan["ip_actualiza"];
    $sheetData["host_captura"] = $plan["host_actualiza"];
    return insertSheet($sheetData);
  }
  return $sheets[0]["id_hoja"];
}

/**
 * processPlanReceptionInsert
 * @param array $planUpdateData
 * @return mixed
 */
function processPlanReceptionInsert($planUpdateData)
{
  $plan = (array) $planUpdateData["plan"];
  $planId = $plan["id_plan"];
  $sheet = getSheetsByPlan($planId)[0];
  $receptions = (array) getReceptionsByPlan($planId);
  if (count($receptions) < 1) {
    $receptionData = getBlankReception();
    unset($receptionData["id_recepcion"]);
    unset($receptionData["fecha_captura"]);
    unset($receptionData["id_usuario_actualiza"]);
    unset($receptionData["fecha_actualiza"]);
    unset($receptionData["ip_actualiza"]);
    unset($receptionData["host_actualiza"]);
    unset($receptionData["fecha_captura"]);

    $receptionData["id_orden"] = $plan["id_orden"];
    $receptionData["id_plan"] = $plan["id_plan"];
    $receptionData["id_hoja"] = $sheet["id_hoja"];
    $receptionData["id_recepcionista"] = 14;
    $receptionData["id_verificador"] = 14;
    $receptionData["id_usuario_captura"] = $plan["id_usuario_actualiza"];
    $receptionData["ip_captura"] = $plan["ip_actualiza"];
    $receptionData["host_captura"] = $plan["host_actualiza"];
    return insertReception($receptionData);
  }
  return $receptions[0]["id_recepcion"];
}

/**
 * processPlanSheetSampleInsert
 * @param array $planUpdateData
 * @return mixed
 */
function processPlanSheetSampleInsert($planUpdateData)
{
  $plan = (array) $planUpdateData["plan"];
  $orderId = $plan["id_orden"];
  $client = (array) $planUpdateData["client"];
  $planId = $plan["id_plan"];
  $sheets = (array) getSheetsByPlan($planId);
  $order = getPlainOrder($orderId);
  $sheetId = $sheets[0]["id_hoja"];
  $samples = (array) getSamplesBySheet($sheetId);
  $sampleId = 0;

  if (count($samples) < 1) {
    $receptions = (array) getReceptionsByPlan($planId);
    $receptionId = $receptions[0]["id_recepcion"];
    $points = getPointsByPackage($plan["id_paquete"]);
    $i = 0;
    $l = count($points);
    $sampleData = (array) getBlankSample();

    unset($sampleData["id_muestra"]);
    $sampleData["id_estudio"] = $plan["id_estudio"];
    $sampleData["id_cliente"] = $client["id_cliente"];
    $sampleData["id_orden"] = $plan["id_orden"];
    $sampleData["id_plan"] = $plan["id_plan"];
    $sampleData["id_hoja"] = $sheetId;
    $sampleData["id_recepcion"] = $receptionId;
    $sampleData["id_paquete"] = $plan["id_paquete"];
    $sampleData["id_ubicacion"] = $plan["id_ubicacion"];
    $sampleData["id_tipo_muestreo"] = $order->id_tipo_muestreo;
    $sampleData["fecha_muestreo"] = isoDateToMsSql($plan["fecha"]);

    for ($i = 0; $i < $l; $i++) {
      $sampleData["id_punto"] = $points[$i]["id_punto"];
      $freq = 24;
      if ($plan["frecuencia"] > 0) {
        $freq = $plan["frecuencia"];
      }
      if ($freq < 24) {
        $sampleData["id_tipo_muestreo"] = 2;
      }
      $m = 24 / $freq;
      for ($j = 0; $j < $m; $j++) {
        $samplesArray[] = insertSample($sampleData);
      }
    }
  }
  return $planId;
}

/**
 * processPlanInstrumentsUpdate
 * @param array $planUpdateData
 * @return mixed
 */
function processPlanInstrumentsUpdate($planUpdateData)
{
  $instruments = (array) $planUpdateData["instruments"];
  $planId = $planUpdateData["plan"]["id_plan"];
  $storedInstruments = getPlanInstruments($planId);
  $i = 0;
  $l = count($instruments);

  if (count($storedInstruments) < 1) {
    disablePlanInstruments($planId);
  }
  for ($i = 0; $i < $l; $i++) {
    $instrument = array(
      "id_plan_instrumento" => $instruments[$i]->id_plan_instrumento,
      "id_plan" => $planId,
      "id_instrumento" => $instruments[$i]->id_instrumento,
      "bitacora" => $instruments[$i]->bitacora,
      "folio" => $instruments[$i]->folio,
      "activo" => $instruments[$i]->activo,
    );
    if ($instrument["id_plan_instrumento"] < 1) {
      unset($instrument["id_plan_instrumento"]);
      insertPlanInstrument($instrument);
    } else {
      updatePlanInstrument($instrument);
    }
  }
  return $planId;
}

/**
 * processPlanPreservationsUpdate
 * @param array $planUpdateData
 * @return mixed
 */
function processPlanPreservationsUpdate($planUpdateData)
{
  $preservations = (array) $planUpdateData["preservations"];
  $planId = $planUpdateData["plan"]["id_plan"];
  $storedPreservations = getPreservationsByPlan($planId);
  $i = 0;
  $j = 0;
  $l = count($storedPreservations);
  $m = count($preservations);

  if ($l < 1) {
    for ($j = 0; $j < $m; $j++) {
      $newPreservation = array(
        "id_plan" => $preservations[$j]->id_plan,
        "id_preservacion" => $preservations[$j]->id_preservacion,
        "activo" => 1,
      );
      insertPlanPreservation($newPreservation);
    }
    return $planId;
  } else {
    disablePlanPreservations($planId);
    for ($j = 0; $j < $m; $j++) {
      $preservation = array(
        "id_plan_preservacion" => $preservations[$j]->id_plan_preservacion,
        "id_plan" => $preservations[$j]->id_plan,
        "id_preservacion" => $preservations[$j]->id_preservacion,
        "activo" => $preservations[$j]->activo,
      );
      if ($preservation["id_plan_preservacion"] < 1) {
        unset($preservation["id_plan_preservacion"]);
        insertPlanPreservation($preservation);
      } else {
        $preservation["activo"] = 1;
        updatePlanPreservation($preservation);
      }
    }
  }
  return $planId;
}

/**
 * processPlanContainersUpdate
 * @param array $planUpdateData
 * @return mixed
 */
function processPlanContainersUpdate($planUpdateData)
{
  $containers = (array) $planUpdateData["containers"];
  $preservations = (array) $planUpdateData["preservations"];
  $points = (array) $planUpdateData["points"];
  $planId = $planUpdateData["plan"]["id_plan"];
  $storedSamples = getPlanSamples($planId);
  $storedPreservations = getPreservationsByPlan($planId);
  $storedContainers = getContainersByPlan($planId);
  $userId = $planUpdateData["plan"]["id_usuario_actualiza"];
  $ip = $planUpdateData["plan"]["ip_actualiza"];
  $url = $planUpdateData["plan"]["host_actualiza"];

  $i = 0;
  $j = 0;
  $k = 0;
  $l = count($storedContainers);
  $m = count($containers);
  $n = count($preservations);
  $o = count($points);

  $newContainer = getBlankContainer();
  unset($newContainer["id_recipiente"]);
  unset($newContainer["fecha_captura"]);
  unset($newContainer["fecha_actualiza"]);
  unset($newContainer["id_usuario_actualiza"]);
  unset($newContainer["ip_actualiza"]);
  unset($newContainer["host_actualiza"]);
  $newContainer["id_plan"] = $planId;
  $newContainer["id_usuario_captura"] = $userId;
  $newContainer["ip_captura"] = $ip;
  $newContainer["host_captura"] = $url;

  if ($l < 1) {
    foreach ($storedSamples as $sample) {
      $newContainer["id_muestra"] = $sample["id_muestra"];
      foreach ($storedPreservations as $preservation) {
        $newContainer["id_preservacion"] = $preservation["id_preservacion"];
        insertContainer($newContainer);
      }
    }

    $newContainers = getPlanContainers($planId);
    $l = count($newContainers);
    for ($i = 0; $i < $l; $i++) {
      $newContainer = array(
        "id_recipiente" => $newContainers[$i]["id_recipiente"],
        "id_plan" => $newContainers[$i]["id_plan"],
        "activo" => 1,
      );
      insertPlanContainer($newContainer);
    }
    return $planId;
  } else {
    // disablePlanContainers($planId);

    // for ($j = 0; $j < $m; $j++) {
    //  $container = (array) $containers[$j];
    //  // if ($container["id_plan_recipiente"] < 1) {
    //  //  unset($container["id_plan_recipiente"]);
    //  //  insertPlanContainer($container);
    //  // }
    //  if ($container["id_plan_recipiente"] > 0) {
    //   $container["activo"] = 1;
    //   updatePlanContainer($container);
    //  }
    // }
  }
  return $planId;
}

/**
 * processPlanReactivesUpdate
 * @param array $planUpdateData
 * @return mixed
 */
function processPlanReactivesUpdate($planUpdateData)
{
  $reactives = (array) $planUpdateData["reactives"];
  $planId = $planUpdateData["plan"]["id_plan"];
  disablePlanReactives($planId);
  $i = 0;
  $l = count($reactives);
  for ($i = 0; $i < $l; $i++) {
    $reactiveData = (array) $reactives[$i];
    if ($reactiveData["id_plan_reactivo"] > 0) {
      $reactive = array(
        "id_plan_reactivo" => $reactiveData["id_plan_reactivo"],
        "id_plan" => $reactiveData["id_plan"],
        "id_reactivo" => $reactiveData["id_reactivo"],
        "activo" => 1,
      );
      updatePlanReactive($reactive);
    } else {
      $reactive = array(
        "id_plan" => $reactiveData["id_plan"],
        "id_reactivo" => $reactiveData["id_reactivo"],
      );
      insertPlanReactive($reactive);
    }
  }
  return $planId;
}

/**
 * processPlanMaterialsUpdate
 * @param array $planUpdateData
 * @return mixed
 */
function processPlanMaterialsUpdate($planUpdateData)
{
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

/**
 * processPlanCoolersUpdate
 * @param array $planUpdateData
 * @return mixed
 */
function processPlanCoolersUpdate($planUpdateData)
{
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

/**
 * processSheetUpdate
 * @param mixed $request
 * @return mixed
 */
function processSheetUpdate($request)
{
  $token = decodeUserToken($request);
  $update = (array) json_decode($request->getBody());
  $preservations = $update["preservaciones"];
  $samples = $update["muestras"];

  unset($update["orden"]);
  unset($update["norma"]);
  unset($update["parametros"]);
  unset($update["preservaciones"]);
  unset($update["muestras"]);

  unset($update["fecha_actualiza"]);
  unset($update["id_usuario_captura"]);
  unset($update["fecha_captura"]);
  unset($update["ip_captura"]);
  unset($update["host_captura"]);

  $update["id_usuario_actualiza"] = $token->uid;
  $update["ip_actualiza"] = $request->getIp();
  $update["host_actualiza"] = $request->getUrl();

  $update["fecha_muestreo"] = isoDateToMsSql($update["fecha_muestreo"]);
  $update["fecha_entrega"] = isoDateToMsSql($update["fecha_entrega"]);
  $update["fecha_rechaza"] = isoDateToMsSql($update["fecha_rechaza"]);

  if ($update["id_status"] == 2 && strlen($update["ip_valida"]) < 1) {
    $update["ip_valida"] = $request->getIp();
    $update["host_valida"] = $request->getUrl();
    $update["fecha_valida"] = isoDateToMsSql($update["fecha_valida"]);
  }

  $sheetUpdateData = array(
    "sheet" => $update,
    "preservations" => $preservations,
    "samples" => $samples,
  );
  return $sheetUpdateData;
}

/**
 * processSheetResultsUpdate
 * @param array $sheetUpdateData
 * @return mixed
 */
function processSheetResultsUpdate($sheetUpdateData)
{
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
    $sample = (array) $samples[$j];
    $sampleResults = (array) $sample["resultados"];
    $n = count($sampleResults);
    for ($k = 0; $k < $n; $k++) {
      $result = (array) $sampleResults[$k];
      unset($result["param"]);
      unset($result['$$hashKey']);
      $results[] = $result;
    }
  }

  if ($l < 1) {
    $m = count($results);
    for ($j = 0; $j < $m; $j++) {
      $results[$j]["id_usuario_captura"] = $userId;
      unset($results[$j]["id_resultado"]);
      unset($results[$j]["id_usuario_actualiza"]);
      unset($results[$j]["fecha_captura"]);
      unset($results[$j]["fecha_actualiza"]);
      insertResult($results[$j]);
    }
    return $sheetId;
  } else {
    for ($i = 0; $i < $l; $i++) {
      $storedResults[$i]["id_usuario_actualiza"] = $userId;
      $storedResults[$i]["activo"] = 0;
      unset($storedResults[$i]["id_usuario_captura"]);
      unset($storedResults[$i]["fecha_captura"]);
      unset($storedResults[$i]["fecha_actualiza"]);
      unset($storedResults[$i]["param"]);
      updateResult($storedResults[$i]);
    }

    $m = count($results);
    for ($j = 0; $j < $m; $j++) {
      $result = (array) $results[$j];
      if ($result["id_resultado"] == 0) {
        $result["id_usuario_captura"] = $userId;
        unset($result["id_resultado"]);
        unset($result["id_usuario_actualiza"]);
        unset($result["fecha_captura"]);
        unset($result["fecha_actualiza"]);
        insertResult($result);
      } else {
        $result["id_usuario_actualiza"] = $userId;
        $result["activo"] = 1;
        unset($result["id_usuario_captura"]);
        unset($result["fecha_captura"]);
        unset($result["fecha_actualiza"]);
        unset($result["param"]);
        updateResult($result);
      }
    }
  }
  return $sheetId;
}

/**
 * processSheetPreservationsUpdate
 * @param array $sheetUpdateData
 * @return mixed
 */
function processSheetPreservationsUpdate($sheetUpdateData)
{
  $preservations = (array) $sheetUpdateData["preservations"];
  $sheetId = $sheetUpdateData["sheet"]["id_hoja"];
  $storedPreservations = (array) getPreservationsBySheet($sheetId);
  $i = 0;
  $j = 0;
  $l = count($storedPreservations);
  $m = count($preservations);
  if ($l < 1) {
    for ($j = 0; $j < $m; $j++) {
      $preservation = (array) $preservations[$j];
      $preservation["cantidad"] = count($sheetUpdateData["samples"]);
      $preservation["preservado"] = $preservation["selected"];
      $preservation["activo"] = 1;
      unset($preservation["id_hoja_preservacion"]);
      unset($preservation["id_tipo_preservacion"]);
      unset($preservation["preservacion"]);
      unset($preservation["descripcion"]);
      unset($preservation["selected"]);
      insertSheetPreservation($preservation);
    }
    return $sheetId;
  } else {
    disableSheetPreservations($sheetId);
    for ($j = 0; $j < $m; $j++) {
      $preservation = (array) $preservations[$j];
      $preservation["cantidad"] = count($sheetUpdateData["samples"]);
      $preservation["preservado"] = $preservation["selected"];
      $preservation["activo"] = 1;
      unset($preservation["id_tipo_preservacion"]);
      unset($preservation["preservacion"]);
      unset($preservation["descripcion"]);
      unset($preservation["selected"]);
      if ($preservation["id_hoja_preservacion"] < 1) {
        unset($preservation["id_hoja_preservacion"]);
        insertSheetPreservation($preservation);
      } else {
        $preservation["activo"] = 1;
        updateSheetPreservation($preservation);
      }
    }
  }
  return $sheetId;
}

/**
 * processReceptionUpdate
 * @param mixed $request
 * @return mixed
 */
function processReceptionUpdate($request)
{
  $token = decodeUserToken($request);
  $update = (array) json_decode($request->getBody());

  $samples = $update["muestras"];
  $preservations = $update["preservaciones"];
  $areas = $update["areas"];
  $jobs = $update["trabajos"];
  $custodies = $update["custodias"];

  unset($update["muestras"]);
  unset($update["preservaciones"]);
  unset($update["areas"]);
  unset($update["trabajos"]);
  unset($update["custodias"]);

  unset($update["id_usuario_captura"]);
  unset($update["fecha_captura"]);
  unset($update["ip_captura"]);
  unset($update["host_captura"]);
  unset($update["fecha_actualiza"]);

  $update["id_usuario_actualiza"] = $token->uid;
  $update["ip_actualiza"] = $request->getIp();
  $update["host_actualiza"] = $request->getUrl();

  $update["fecha_entrega"] = isoDateToMsSql($update["fecha_entrega"]);
  $update["fecha_recibe"] = isoDateToMsSql($update["fecha_recibe"]);
  // $update["fecha_recibe"] = isoDateToMsSql($update["fecha_recibe"]);
  ////No input in form por this date/time setting to reception date/time
  //$update["fecha_verifica"] = isoDateToMsSql($update["fecha_verifica"]);
  $update["fecha_verifica"] = $update["fecha_recibe"];
  $update["fecha_rechaza"] = isoDateToMsSql($update["fecha_rechaza"]);

  if ($update["id_status"] == 2 && strlen($update["ip_valida"]) < 1) {
    $update["ip_valida"] = $request->getIp();
    $update["host_valida"] = $request->getUrl();
    $update["fecha_valida"] = isoDateToMsSql($update["fecha_valida"]);
  }

  $receptionUpdateData = array(
    "reception" => $update,
    "samples" => $samples,
    "preservations" => $preservations,
    "areas" => $areas,
    "jobs" => $jobs,
    "custodies" => $custodies,
  );
  return $receptionUpdateData;
}

/**
 * processReceptionSamplesUpdate
 * @param array $receptionUpdateData
 * @return mixed
 */
function processReceptionSamplesUpdate($receptionUpdateData)
{
  $samples = (array) $receptionUpdateData["samples"];
  $receptionId = $receptionUpdateData["reception"]["id_recepcion"];
  $storedSamples = getReceptionSamples($receptionId);
  $i = 0;
  $j = 0;
  $l = count($storedSamples);
  $m = count($samples);

  if ($l > 0) {
    disableReceptionSamples($receptionId);
  }

  for ($i = 0; $i < $m; $i++) {
    $receptionSample = array(
      "id_recepcion_muestra" => $samples[$i]->id_recepcion_muestra,
      "id_recepcion" => $samples[$i]->id_recepcion,
      "id_muestra" => $samples[$i]->id_muestra,
    );
    if ($receptionSample["id_recepcion_muestra"] < 1 || $l < 1) {
      unset($receptionSample["id_recepcion_muestra"]);
      $receptionSamplesArray[] = $receptionSample;
      insertReceptionSample($receptionSample);
    } else {
      $receptionSample["activo"] = 1;
      updateReceptionSample($receptionSample);
    }
    $sampleData = array(
      "id_muestra" => $samples[$i]->id_muestra,
      "id_recepcion" => $samples[$i]->id_recepcion,
    );
    updateSampleReceptionId($sampleData);
  }
  return $receptionId;
}

/**
 * processReceptionPreservationsUpdate
 * @param array $receptionUpdateData
 * @return mixed
 */
function processReceptionPreservationsUpdate($receptionUpdateData)
{
  $preservations = (array) $receptionUpdateData["preservations"];
  $receptionId = $receptionUpdateData["reception"]["id_recepcion"];
  $storedPreservations = getReceptionPreservations($receptionId);
  $i = 0;
  $l = count($storedPreservations);
  $m = count($preservations);

  if ($l > 0) {
    disableReceptionPreservations($receptionId);
  }

  for ($i = 0; $i < $m; $i++) {
    $preservation = array(
      "id_recepcion_preservacion" => $preservations[$i]->id_recepcion_preservacion,
      "id_recepcion" => $preservations[$i]->id_recepcion,
      "id_preservacion" => $preservations[$i]->id_preservacion,
      "cantidad" => $preservations[$i]->cantidad,
    );
    if ($preservation["id_recepcion_preservacion"] < 1) {
      unset($preservation["id_recepcion_preservacion"]);
      insertReceptionPreservation($preservation);
    } else {
      $preservation["activo"] = 1;
      updateReceptionPreservation($preservation);
    }
  }
  return $receptionId;
}

/**
 * processReceptionContainersUpdate
 * @param array $receptionUpdateData
 * @return mixed
 */
function processReceptionContainersUpdate($receptionUpdateData)
{
  $receptionId = $receptionUpdateData["reception"]["id_recepcion"];
  $planId = $receptionUpdateData["reception"]["id_plan"];
  $containers = getPlanContainers($planId);

  $i = 0;
  $l = count($containers);

  for ($i = 0; $i < $l; $i++) {
    $containerData = array(
      "id_recipiente" => $containers[$i]["id_recipiente"],
      "id_recepcion" => $receptionId,
    );
    updateContainerReceptionId($containerData);
  }
  return $receptionId;
}

/**
 * processReceptionAreasUpdate
 * @param array $receptionUpdateData
 * @return mixed
 */
function processReceptionAreasUpdate($receptionUpdateData)
{
  $areas = (array) $receptionUpdateData["areas"];
  $reception = (array) $receptionUpdateData["reception"];
  $receptionId = $reception["id_recepcion"];
  $storedAreas = getReceptionAreas($receptionId);
  $i = 0;
  $l = count($storedAreas);
  $m = count($areas);

  if ($l > 0) {
    disableReceptionAreas($receptionId);
  }

  for ($i = 0; $i < $m; $i++) {
    $area = array(
      "id_recepcion_area" => $areas[$i]->id_recepcion_area,
      "id_recepcion" => $areas[$i]->id_recepcion,
      "id_area" => $areas[$i]->id_area,
      "id_muestra" => $reception["id_muestra_validacion"],
      "volumen" => $areas[$i]->volumen,
      "vigencia" => $areas[$i]->vigencia,
      "recipiente" => $areas[$i]->recipiente,
    );
    if ($area["id_recepcion_area"] < 1) {
      unset($area["id_recepcion_area"]);
      insertReceptionArea($area);
    } else {
      $area["activo"] = 1;
      updateReceptionArea($area);
    }
  }
  return $receptionId;
}

/**
 * processReceptionCustodiesInsert
 * @param array $receptionUpdateData
 * @return mixed
 */
function processReceptionCustodiesInsert($receptionUpdateData)
{
  $reception = (array) $receptionUpdateData["reception"];
  $receptionJobs = getReceptionJobs($reception["id_recepcion"]);
  $custodies = (array) $receptionUpdateData["custodies"];
  $receptionId = $reception["id_recepcion"];
  $i = 0;
  $l = count($custodies);
  $custodyData = getBlankCustody();
  $custodyData["id_recepcion"] = $reception["id_recepcion"];
  $custodyData["id_usuario_captura"] = $reception["id_usuario_actualiza"];
  $custodyData["ip_captura"] = $reception["ip_actualiza"];
  $custodyData["host_captura"] = $reception["host_actualiza"];
  unset($custodyData["id_custodia"]);
  unset($custodyData["fecha_captura"]);
  unset($custodyData["id_usuario_actualiza"]);
  unset($custodyData["fecha_actualiza"]);
  unset($custodyData["ip_actualiza"]);
  unset($custodyData["host_actualiza"]);

  for ($i = 0; $i < $l; $i++) {
    $custodyData["id_trabajo"] = $receptionJobs[$i]["id_trabajo"];
    $custodyData["id_area"] = $custodies[$i]->id_area;
    $custodyIds[] = insertCustody($custodyData);
  }
  return $custodyIds;
}

/**
 * processReceptionCustodiesUpdate
 * @param array $receptionUpdateData
 * @return mixed
 */
function processReceptionCustodiesUpdate($receptionUpdateData)
{
  $custodies = (array) $receptionUpdateData["custodies"];
  $reception = (array) $receptionUpdateData["reception"];
  $receptionId = $reception["id_recepcion"];
  $storedCustodies = getReceptionCustodies($receptionId);
  $custodiesByReception = getCustodiesByReception($receptionId);
  $i = 0;
  $l = count($storedCustodies);
  $m = count($custodies);
  $n = count($custodiesByReception);

  if ($l < 1 && $n < 1) {
    $custodyIds = (array) processReceptionCustodiesInsert($receptionUpdateData);
    for ($i = 0; $i < $m; $i++) {
      $custody = array(
        "id_recepcion" => $custodies[$i]->id_recepcion,
        "id_custodia" => $custodyIds[$i],
      );
      $insertedCustodiesIds[] = insertReceptionCustody($custody);
    }
    return $insertedCustodiesIds;
  } else {
    disableReceptionCustodies($receptionId);
    for ($i = 0; $i < $m; $i++) {
      $custody = array(
        "id_recepcion_custodia" => $custodies[$i]->id_recepcion_custodia,
        "id_recepcion" => $custodies[$i]->id_recepcion,
        "id_custodia" => $custodies[$i]->id_custodia,
      );
      if ($custody["id_recepcion_custodia"] < 1) {
        // if ($custody["id_custodia"] < 1) {
        //  $areaId = $custodies[$i]->id_area;
        //  $custodyId = processReceptionCustodyInsert($receptionUpdateData, $areaId);
        // }
        // $custody["id_custodia"] = $custodyId;
        // unset($custody["id_recepcion_custodia"]);
        // insertReceptionCustody($custody);
      } else {
        $custody["activo"] = 1;
        updateReceptionCustody($custody);
      }
    }
  }
  return $receptionId;
}

/**
 * processReceptionJobsInsert
 * @param array $receptionUpdateData
 * @return mixed
 */
function processReceptionJobsInsert($receptionUpdateData)
{
  $reception = (array) $receptionUpdateData["reception"];
  $samples = (array) $receptionUpdateData["samples"];
  $jobs = (array) $receptionUpdateData["jobs"];
  $receptionId = $reception["id_recepcion"];
  $storedCustodies = getReceptionCustodies($receptionId);
  $i = 0;
  $j = 0;
  $k = 0;
  $l = count($jobs);
  $m = count($storedCustodies);
  $n = count($samples);

  $jobData = getBlankJob();
  $jobData["id_recepcion"] = $reception["id_recepcion"];
  $jobData["id_plan"] = $reception["id_plan"];
  $jobData["id_usuario_captura"] = $reception["id_usuario_actualiza"];
  $jobData["ip_captura"] = $reception["ip_actualiza"];
  $jobData["host_captura"] = $reception["host_actualiza"];
  unset($jobData["id_trabajo"]);
  unset($jobData["fecha_captura"]);
  unset($jobData["id_usuario_actualiza"]);
  unset($jobData["fecha_actualiza"]);
  unset($jobData["ip_actualiza"]);
  unset($jobData["host_actualiza"]);

  for ($i = 0; $i < $l; $i++) {
    $areaId = $jobs[$i]->id_area;
    $jobData["id_area"] = $areaId;
    for ($j = 0; $j < $m; $j++) {
      if ($storedCustodies[$j]->id_area == $areaId) {
        $jobData["id_custodia"] = $storedCustodies[$j]->id_custodia;
        break;
      }
    }
    $jobId = insertJob($jobData);
    for ($k = 0; $k < $n; $n++) {
      $jobSample = array(
        "id_trabajo" => $jobId,
        "id_muestra" => $samples[$n]->id_muestra,
        "activo" => 1,
      );
      $jobSampleId = insertJobSample($jobSample);
    }
    $jobIds[] = $jobId;
  }
  return $jobIds;
}

/**
 * processReceptionJobInsert
 * @param array $receptionUpdateData
 * @param mixed $areaId
 */
function processReceptionJobInsert($receptionUpdateData, $areaId)
{
  $reception = (array) $receptionUpdateData["reception"];
  $jobs = (array) $receptionUpdateData["jobs"];
  $receptionId = $reception["id_recepcion"];
  $i = 0;
  $l = count($jobs);

  $jobData = getBlankJob();
  $jobData["id_recepcion"] = $reception["id_recepcion"];
  $jobData["id_plan"] = $reception["id_plan"];
  $jobData["id_usuario_captura"] = $reception["id_usuario_actualiza"];
  $jobData["ip_captura"] = $reception["ip_actualiza"];
  $jobData["host_captura"] = $reception["host_actualiza"];
  unset($jobData["id_trabajo"]);
  unset($jobData["fecha_captura"]);
  unset($jobData["id_usuario_actualiza"]);
  unset($jobData["fecha_actualiza"]);
  unset($jobData["ip_actualiza"]);
  unset($jobData["host_actualiza"]);

  $jobData["id_area"] = $areaId;
  return insertJob($jobData);
}

/**
 * processReceptionJobsUpdate
 * @param array $receptionUpdateData
 * @return mixed
 */
function processReceptionJobsUpdate($receptionUpdateData)
{
  $jobs = (array) $receptionUpdateData["jobs"];
  $samples = (array) $receptionUpdateData["samples"];
  $reception = (array) $receptionUpdateData["reception"];
  $receptionId = $reception["id_recepcion"];
  $storedJobs = getReceptionJobs($receptionId);
  $jobsByReception = getJobsByReception($receptionId);
  $i = 0;
  $j = 0;
  $l = count($storedJobs);
  $m = count($jobs);
  $n = count($jobsByReception);
  $o = count($samples);

  if ($l < 1 && $n < 1) {
    $jobIds = (array) processReceptionJobsInsert($receptionUpdateData);
    for ($i = 0; $i < $m; $i++) {
      $job = array(
        "id_recepcion" => $jobs[$i]->id_recepcion,
        "id_trabajo" => $jobIds[$i],
      );
      $insertedJobIds[] = insertReceptionJob($job);
    }
    return $insertedJobIds;
  } else {
    disableReceptionJobs($receptionId);
    for ($i = 0; $i < $m; $i++) {
      $job = array(
        "id_recepcion_trabajo" => $jobs[$i]->id_recepcion_trabajo,
        "id_recepcion" => $jobs[$i]->id_recepcion,
        "id_trabajo" => $jobs[$i]->id_trabajo,
      );
      if ($job["id_recepcion_trabajo"] < 1) {
        if ($job["id_trabajo"] < 1) {
          $areaId = $jobs[$i]->id_area;
          $jobId = processReceptionJobInsert($receptionUpdateData, $areaId);
          for ($j = 0; $j < $o; $o++) {
            $jobSample = array(
              "id_trabajo" => $jobId,
              "id_muestra" => $samples[$o]->id_muestra,
              "activo" => 1,
            );
            $jobSampleId = insertJobSample($jobSample);
          }
        }
        $job["id_trabajo"] = $jobId;
        unset($job["id_recepcion_trabajo"]);
        insertReceptionJob($job);
      } else {
        $job["activo"] = 1;
        updateReceptionJob($job);
      }
    }
  }
  return $receptionId;
}

/**
 * processCustodyInsert
 * @param mixed $request
 * @return mixed
 */
function processCustodyInsert($request)
{
  $token = decodeUserToken($request);
  $insertData = (array) json_decode($request->getBody());

  $custody = array(
    "id_custodia" => $insertData["id_custodia"],
    "id_estudio" => $insertData["id_estudio"],
    "id_recepcion" => $insertData["id_recepcion"],
    "id_trabajo" => $insertData["id_trabajo"],
    "id_area" => $insertData["id_area"],
    "id_status" => $insertData["id_status"],
    "id_usuario_entrega" => $insertData["id_usuario_entrega"],
    "id_usuario_recibe" => $insertData["id_usuario_recibe"],
    "id_usuario_captura" => $insertData["id_usuario_captura"],
    "id_usuario_valida" => $insertData["id_usuario_valida"],
    "fecha_entrega" => $insertData["fecha_entrega"],
    "fecha_recibe" => $insertData["fecha_recibe"],
    "fecha_valida" => $insertData["fecha_valida"],
    "fecha_rechaza" => $insertData["fecha_rechaza"],
    "ip_captura" => $request->getIp(),
    "ip_valida" => $insertData["ip_valida"],
    "host_captura" => $request->getUrl(),
    "host_valida" => $insertData["host_valida"],
    "comentarios" => $insertData["comentarios"],
    "motivo_rechaza" => $insertData["motivo_rechaza"],
    "activo" => 1,
  );
  $custodyId = insertCustody($custody);
  return $custodyId;
}

/**
 * processCustodyUpdate
 * @param mixed $request
 * @return mixed
 */
function processCustodyUpdate($request)
{
  $token = decodeUserToken($request);
  $update = (array) json_decode($request->getBody());

  $containers = $update["containers"];
  // $containersLogs = $update["containersLogs"];
  unset($update["containers"]);

  unset($update["id_usuario_captura"]);
  unset($update["fecha_captura"]);
  unset($update["ip_captura"]);
  unset($update["host_captura"]);
  unset($update["fecha_actualiza"]);
  unset($update["fecha_muestreo"]);
  unset($update["fecha_recepcion"]);

  unset($update["id_matriz"]);
  unset($update["id_hoja"]);
  unset($update["matriz"]);
  unset($update["cantidad_muestras"]);

  $update["id_usuario_actualiza"] = $token->uid;
  $update["ip_actualiza"] = $request->getIp();
  $update["host_actualiza"] = $request->getUrl();

  $update["fecha_entrega"] = isoDateToMsSql($update["fecha_entrega"]);
  $update["fecha_recibe"] = isoDateToMsSql($update["fecha_recibe"]);
  $update["fecha_valida"] = isoDateToMsSql($update["fecha_valida"]);
  $update["fecha_rechaza"] = isoDateToMsSql($update["fecha_rechaza"]);

  if ($update["id_status"] == 2 && strlen($update["ip_valida"]) < 1) {
    $update["ip_valida"] = $request->getIp();
    $update["host_valida"] = $request->getUrl();
    $update["fecha_valida"] = isoDateToMsSql($update["fecha_valida"]);
  }

  $custodyUpdateData = array(
    "custody" => $update,
    "containers" => $containers,
  );
  return $custodyUpdateData;
}

/**
 * processCustodyContainers
 * @param mixed $request
 * @return mixed
 */
function processCustodyContainers($custodyUpdateData)
{
  $custody = (array) $custodyUpdateData["custody"];
  $containers = (array) $custodyUpdateData["containers"];
  $custodyId = $custody["id_custodia"];
  // $storedContainers = getCustodyContainers($custodyId);

  $i = 0;
  $j = 0;
  $l = count($containers);
  $m = 0;

  $containerData = array(
    "id_recipiente" => 0,
    "id_almacenamiento" => 1,
    "id_usuario_actualiza" => $custody["id_usuario_actualiza"],
    "ip_actualiza" => $custody["ip_actualiza"],
    "host_actualiza" => $custody["host_actualiza"],
  );

  for ($i = 0; $i < $l; $i++) {
    $container = $containers[$i];
    $containerData["id_recipiente"] = $container->id_recipiente;
    $containerData["id_almacenamiento"] = $container->id_almacenamiento;
    $containerIds[] = updateContainerStorage($containerData);
    $containersData[] = $containerData;
    $containerId = $container->id_recipiente;

    if (isset($container->historial) || property_exists($container, "historial")) {
      $logs = $container->historial;
      $m = count($logs);

      for ($j = 0; $j < $m; $j++) {
        // Logs are write-once
        if ($logs[$j]->id_historial_recipiente < 1) {
          $logIds[] = insertContainerLog(array(
            "id_custodia" => $custodyId,
            "id_muestra" => $container->id_muestra,
            "id_recipiente" => $container->id_recipiente,
            "id_parametro" => $logs[$j]->id_parametro,
            "id_usuario_analiza" => $logs[$j]->id_usuario_analiza,
            "id_usuario_captura" => $custody["id_usuario_actualiza"],
            "volumen" => $logs[$j]->volumen,
            "fecha" => $logs[$j]->fecha,
            "ip_captura" => $custody["ip_actualiza"],
            "host_captura" => $custody["host_actualiza"],
          ));
        }
      }
    }
  }
  return $custodyId;
}

/**
 * processContainerLogInsert
 * @param mixed $request
 * @return mixed
 */
function processContainerLogInsert($request)
{
  $token = decodeUserToken($request);
  $insertData = (array) json_decode($request->getBody());

  $log = array(
    "id_custodia" => $insertData["id_custodia"],
    "id_muestra" => $insertData["id_muestra"],
    "id_recipiente" => $insertData["id_recipiente"],
    "id_parametro" => $insertData["id_parametro"],
    "id_usuario_captura" => $token->uid,
    "volumen" => $insertData["volumen"],
    "ip_captura" => $request->getIp(),
    "host_captura" => $request->getUrl(),
  );
  $newLogId = insertContainerLog($log);
  return $newLogId;
}

/**
 * processContainerLogUpdate
 * @param mixed $request
 * @return mixed
 */
function processContainerLogUpdate($request)
{
  $token = decodeUserToken($request);
  $updateData = (array) json_decode($request->getBody());

  $log = array(
    "id_historial_recipiente" => $updateData["id_historial_recipiente"],
    "id_custodia" => $updateData["id_custodia"],
    "id_muestra" => $updateData["id_muestra"],
    "id_recipiente" => $updateData["id_recipiente"],
    "id_parametro" => $updateData["id_parametro"],
    "id_usuario_actualiza" => $token->uid,
    "volumen" => $updateData["volumen"],
    "ip_actualiza" => $request->getIp(),
    "host_actualiza" => $request->getUrl(),
    "activo" => $updateData["activo"],
  );
  $logId = updateContainerLog($log);
  return $logId;
}

/**
 * processReceptionCustodyInsert
 * @param array $receptionUpdateData
 * @param mixed $areaId
 */
function processReceptionCustodyInsert($receptionUpdateData, $areaId)
{
  $reception = (array) $receptionUpdateData["reception"];
  $receptionJobs = getReceptionJobs($reception["id_recepcion"]);
  $custodies = (array) $receptionUpdateData["custodies"];
  $receptionId = $reception["id_recepcion"];
  $i = 0;
  $l = count($custodies);
  $custodyData = getBlankCustody();
  $custodyData["id_recepcion"] = $reception["id_recepcion"];
  $custodyData["id_usuario_captura"] = $reception["id_usuario_actualiza"];
  $custodyData["ip_captura"] = $reception["ip_actualiza"];
  $custodyData["host_captura"] = $reception["host_actualiza"];
  unset($custodyData["id_custodia"]);
  unset($custodyData["fecha_captura"]);
  unset($custodyData["id_usuario_actualiza"]);
  unset($custodyData["fecha_actualiza"]);
  unset($custodyData["ip_actualiza"]);
  unset($custodyData["host_actualiza"]);

  for ($i = 0; $i < $l; $i++) {
    $custodyData["id_trabajo"] = $receptionJobs[$i]["id_trabajo"];
    $custodyData["id_area"] = $areaId;
    $custodyIds[] = insertCustody($custodyData);
  }
  return $custodyIds;
}

/**
 * processJobUpdate
 * @param array $request
 * @param mixed $areaId
 */
function processJobUpdate($request)
{
  $token = decodeUserToken($request);
  $update = (array) json_decode($request->getBody());
  $samples = $update["muestras"];
  $analysisList = $update["lista_analisis"];
  $references = $update["referencias"];
  $parameters = $update["parametros"];

  unset($update["muestras"]);
  unset($update["lista_analisis"]);
  unset($update["referencias"]);
  unset($update["parametros"]);
  unset($update["fecha_captura"]);
  unset($update["id_usuario_captura"]);
  unset($update["ip_captura"]);
  unset($update["host_captura"]);
  unset($update["fecha_actualiza"]);

  if (!is_numeric($update["id_muestra_duplicada"])) {
    $update["id_muestra_duplicada"] = 0;
  }

  $update["id_usuario_actualiza"] = $token->uid;
  $update["ip_actualiza"] = $request->getIp();
  $update["host_actualiza"] = $request->getUrl();
  $update["id_usuario_recibe"] = $token->uid;

  $update["fecha_aprueba"] = isoDateToMsSql($update["fecha_aprueba"]);
  $update["fecha_entrega"] = isoDateToMsSql($update["fecha_entrega"]);
  $update["fecha_recibe"] = isoDateToMsSql($update["fecha_recibe"]);
  $update["fecha_rechaza"] = isoDateToMsSql($update["fecha_rechaza"]);

  if ($update["id_status"] == 2 && strlen($update["ip_valida"]) < 1) {
    $update["ip_valida"] = $request->getIp();
    $update["host_valida"] = $request->getUrl();
    $update["fecha_valida"] = isoDateToMsSql($update["fecha_valida"]);
  }

  $jobUpdateData = array(
    "job" => $update,
    "samples" => $samples,
    "analysisList" => $analysisList,
    "references" => $references,
    "parameters" => $parameters,
  );
  return $jobUpdateData;
}

/**
 * Función de ordenado para usort por id_usuario_analiza
 * @param mixed $a valor de ítem
 * @param mixed $b valor de ítem
 * @return bool Comparación de valores
 */
function customSort($a, $b)
{
  return $a->id_usuario_analiza > $b->id_usuario_analiza;
}

/**
 * processJobAnalysisInsert
 * @param mixed $jobUpdateData
 * @param mixed $jobId
 * @return array $analysisReferenceIds
 */
function processJobAnalysisInsert($jobUpdateData, $jobId)
{
  $job = (array) $jobUpdateData["job"];
  $analysisList = (array) $jobUpdateData["analysisList"];
  $samples = (array) $jobUpdateData["samples"];
  $parameters = (array) $jobUpdateData["parameters"];

  if (count($analysisList) > 0) {
    return $analysisList;
  } else {
    $i = 0;
    $j = 0;
    $l = count($parameters);
    usort($parameters, "customSort");
    $analystId = 0;

    $blankAnalysis = getBlankAnalysis();
    unset($blankAnalysis["id_analisis"]);
    unset($blankAnalysis["fecha_captura"]);
    unset($blankAnalysis["fecha_actualiza"]);
    unset($blankAnalysis["host_actualiza"]);
    unset($blankAnalysis["ip_actualiza"]);
    $blankAnalysis["id_trabajo"] = $jobId;
    $blankAnalysis["id_usuario_captura"] = $job["id_usuario_actualiza"];
    $blankAnalysis["ip_captura"] = $job["ip_actualiza"];
    $blankAnalysis["host_captura"] = $job["host_actualiza"];

    for ($i = 0; $i < $l; $i++) {
      if ($parameters[$i]->id_usuario_analiza != $analystId) {
        $analystId = $parameters[$i]->id_usuario_analiza;
        $blankAnalysis["id_usuario_analiza"] = $analystId;
        $analystIds[] = $analystId;
        $analysisId = insertAnalysis($blankAnalysis);
        $analysisIds[] = $analysisId;
        processAnalysisSamplesInsert($samples, $analysisId);
        processAnalysisParametersInsert($parameters, $analystId, $analysisId);
        processAnalysisReferencesInsert($jobUpdateData, $parameters, $analystId, $analysisId);
        processAnalysisResultsInsert($jobUpdateData, $analystId, $analysisId);
      }
    }
    return $analystIds;
  }
}

/**
 * processAnalysisSamplesInsert
 * @param mixed $samples
 * @param mixed $analysisId
 * @return array $analysisSampleIds
 */
function processAnalysisSamplesInsert($samples, $analysisId)
{
  $i = 0;
  $l = count($samples);
  for ($i = 0; $i < $l; $i++) {
    $analysisSample = array(
      "id_analisis" => $analysisId,
      "id_muestra" => $samples[$i]->id_muestra,
      "activo" => 1,
    );
    $analysisSampleIds[] = insertAnalysisSample($analysisSample);
  }
  return $analysisSampleIds;
}

/**
 * processAnalysisSamplesUpdate
 * @param mixed $analysisUpdateData
 * @return mixed $analysisId
 */
function processAnalysisSamplesUpdate($analysisUpdateData)
{
  $samples = (array) $analysisUpdateData["samples"];
  $analysisId = $analysisUpdateData["analysis"]["id_analisis"];
  $storedSamples = getAnalysisSamples($analysisId);
  $i = 0;
  $j = 0;
  $l = count($storedSamples);
  $m = count($samples);

  if ($l > 0) {
    disableAnalysisSamples($analysisId);
  }

  for ($i = 0; $i < $m; $i++) {
    $analysisSample = array(
      "id_analisis_muestra" => $samples[$i]->id_analisis_muestra,
      "id_analisis" => $samples[$i]->id_analisis,
      "id_muestra" => $samples[$i]->id_muestra,
    );
    if ($analysisSample["id_analisis_muestra"] < 1 || $l < 1) {
      unset($analysisSample["id_analisis_muestra"]);
      $analysisSamplesArray[] = $analysisSample;
      insertAnalysisSample($analysisSample);
    } else {
      $analysisSample["activo"] = 1;
      updateAnalysisSample($analysisSample);
    }
  }
  return $analysisId;
}

/**
 * processAnalysisReferencesInsert
 * @param mixed $jobUpdateData
 * @param mixed $parameters
 * @param mixed $analystId
 * @param mixed $analysisId
 * @return array $analysisReferenceIds
 */
function processAnalysisReferencesInsert($jobUpdateData, $parameters, $analystId, $analysisId)
{
  $job = (array) $jobUpdateData["job"];
  $userId = $job["id_usuario_actualiza"];
  $i = 0;
  $l = count($parameters);
  for ($i = 0; $i < $l; $i++) {
    if ($parameters[$i]->id_usuario_analiza == $analystId) {
      $parameterId = $parameters[$i]->id_parametro;
      $analysisReference = array(
        "id_analisis" => $analysisId,
        "id_parametro" => $parameterId,
        "id_usuario_analiza" => $analystId,
        "id_usuario_captura" => $userId,
        "duplicado" => "",
        "muestra_duplicada" => "",
        "estandar" => "",
        "coeficiente_variacion" => "",
        "tiempo_incubacion" => "",
        "temperatura_incubacion" => "",
        "fecha_analiza" => null,
        "activo" => 1,
      );
      $analysisReferenceIds[] = insertAnalysisReference($analysisReference);
    }
  }
  return $analysisReferenceIds;
}

/**
 * processAnalysisParametersUpdate
 * @param mixed $analysisUpdateData
 * @return mixed $analysisId
 */
function processAnalysisParametersUpdate($analysisUpdateData)
{
  $parameters = (array) $analysisUpdateData["parameters"];
  $analysisId = $analysisUpdateData["analysis"]["id_analisis"];
  $storedParameters = getAnalysisParameters($analysisId);
  $i = 0;
  $l = count($storedParameters);
  $m = count($parameters);

  if ($l > 0) {
    disableAnalysisParameters($analysisId);
  }
  for ($i = 0; $i < $m; $i++) {
    $analysisParameter = array(
      "id_analisis_parametro" => $parameters[$i]->id_analisis_parametro,
      "id_analisis" => $parameters[$i]->id_analisis,
      "id_parametro" => $parameters[$i]->id_parametro,
    );
    if ($analysisParameter["id_analisis_parametro"] < 1 || $l < 1) {
      unset($analysisParameter["id_analisis_parametro"]);
      $analysisParametersArray[] = $analysisParameter;
      insertAnalysisParameter($analysisParameter);
    } else {
      updateAnalysisParameter($analysisParameter);
    }
  }
  return $analysisId;
}

/**
 * processAnalysisResultsInsert
 * @param mixed $jobUpdateData
 * @param mixed $analysisId
 * @return array $resultIds
 */
function processAnalysisResultsInsert($jobUpdateData, $analystId, $analysisId)
{
  $job = (array) $jobUpdateData["job"];
  $analysisList = (array) $jobUpdateData["analysisList"];
  $samples = (array) $jobUpdateData["samples"];
  $parameters = (array) $jobUpdateData["parameters"];

  $result = getBlankResult();
  unset($result["id_resultado"]);
  unset($result["fecha_captura"]);
  unset($result["id_usuario_actualiza"]);
  unset($result["fecha_actualiza"]);
  $result["id_usuario_captura"] = $job["id_trabajo"];

  $i = 0;
  $j = 0;
  $l = count($parameters);
  $m = count($samples);
  usort($parameters, "customSort");

  for ($i = 0; $i < $l; $i++) {
    if ($parameters[$i]->id_usuario_analiza == $analystId) {
      $parameterId = $parameters[$i]->id_parametro;
      $parameterValueType = $parameters[$i]->id_tipo_valor;
      for ($j = 0; $j < $m; $j++) {
        $sampleId = $samples[$j]->id_muestra;
        $result["id_muestra"] = $sampleId;
        $result["id_parametro"] = $parameterId;
        $result["id_tipo_valor"] = $parameterValueType;
        $resultId = insertResult($result);
        $resultIds[] = $resultId;
        $jobResult = array(
          "id_trabajo" => $job["id_trabajo"],
          "id_resultado" => $resultId,
          "activo" => 1,
        );
        $jobResultIds[] = insertJobResult($jobResult);
        $analysisResult = array(
          "id_analisis" => $analysisId,
          "id_resultado" => $resultId,
          "activo" => 1,
        );
        $analysisResultIds[] = insertAnalysisResult($analysisResult);
      }
    }
  }
  return $resultIds;
}

/**
 * processAnalysisParametersInsert
 * @param mixed $parameters
 * @param mixed $analystId
 * @param mixed $analysisId
 * @return array $analysisParameterIds
 */
function processAnalysisParametersInsert($parameters, $analystId, $analysisId)
{
  $i = 0;
  $l = count($parameters);
  for ($i = 0; $i < $l; $i++) {
    if ($parameters[$i]->id_usuario_analiza == $analystId) {
      $parameterId = $parameters[$i]->id_parametro;
      $analysisParameter = array(
        "id_analisis" => $analysisId,
        "id_parametro" => $parameterId,
        "activo" => 1,
      );
      $analysisParameterIds[] = insertAnalysisParameter($analysisParameter);
    }
  }
  return $analysisParameterIds;
}

/**
 * processAnalysisUpdate
 * @param array $request
 * @param mixed $areaId
 */
function processAnalysisUpdate($request)
{
  $token = decodeUserToken($request);
  $update = (array) json_decode($request->getBody());
  $samples = $update["muestras"];
  $parameters = $update["parametros"];

  unset($update["muestras"]);
  unset($update["parametros"]);
  unset($update["fecha_captura"]);
  unset($update["id_usuario_captura"]);
  unset($update["id_usuario_recibe"]);
  unset($update["ip_captura"]);
  unset($update["host_captura"]);
  unset($update["fecha_actualiza"]);

  $update["id_usuario_actualiza"] = $token->uid;
  $update["ip_actualiza"] = $request->getIp();
  $update["host_actualiza"] = $request->getUrl();
  $update["id_usuario_recibe"] = $token->uid;

  $update["fecha_analiza"] = isoDateToMsSql($update["fecha_analiza"]);
  $update["fecha_aprueba"] = isoDateToMsSql($update["fecha_aprueba"]);
  $update["fecha_valida"] = isoDateToMsSql($update["fecha_valida"]);
  $update["fecha_rechaza"] = isoDateToMsSql($update["fecha_rechaza"]);

  $analysis = array(
    "id_analisis" => $update["id_analisis"],
    "id_trabajo" => $update["id_trabajo"],
    "id_usuario_analiza" => $update["id_usuario_analiza"],
    "id_usuario_valida" => $update["id_usuario_valida"],
    "id_usuario_actualiza" => $update["id_usuario_actualiza"],
    "fecha_analiza" => $update["fecha_analiza"],
    "fecha_aprueba" => $update["fecha_aprueba"],
    "fecha_valida" => $update["fecha_valida"],
    "fecha_rechaza" => $update["fecha_rechaza"],
    "ip_valida" => $update["ip_valida"],
    "ip_actualiza" => $update["ip_actualiza"],
    "host_valida" => $update["host_valida"],
    "host_actualiza" => $update["host_actualiza"],
    "comentarios" => $update["comentarios"],
    "motivo_rechaza" => $update["motivo_rechaza"],
    "activo" => $update["activo"],
  );

  $analysisUpdateData = array(
    "analysis" => $analysis,
    "samples" => $samples,
    "parameters" => $parameters,
  );
  return $analysisUpdateData;
}

/**
 * processAnalysisReferences
 * @param mixed $analysisUpdateData
 * @return array $analysisReferenceIds
 */
function processAnalysisReferencesUpdate($analysisUpdateData)
{
  $analysis = (array) $analysisUpdateData["analysis"];
  $parameters = (array) $analysisUpdateData["parameters"];
  $analysisId = $analysis["id_analisis"];
  $i = 0;
  $l = count($parameters);
  for ($i = 0; $i < $l; $i++) {
    $reference = (array) $parameters[$i]->referencias;
    unset($reference["id_usuario_captura"]);
    unset($reference["fecha_captura"]);
    unset($reference["fecha_actualiza"]);
    $reference["id_usuario_actualiza"] = $analysis["id_usuario_actualiza"];
    $referenceIds[] = updateAnalysisReference($reference);
  }
  return $referenceIds;
}

/**
 * processAnalysisResults
 * @param mixed $analysisUpdateData
 * @return array $analysisResultIds
 */
function processAnalysisResultsUpdate($analysisUpdateData)
{
  $analysis = (array) $analysisUpdateData["analysis"];
  $parameters = (array) $analysisUpdateData["parameters"];
  $userId = $analysis["id_usuario_actualiza"];

  $i = 0;
  $j = 0;
  $l = count($parameters);
  $m = 0;
  for ($i = 0; $i < $l; $i++) {
    $parameterResults = $parameters[$i]->resultados;
    $m = count($parameterResults);
    for ($j = 0; $j < $m; $j++) {
      $parameterResult = $parameterResults[$j];
      $result = array(
        "id_resultado" => $parameterResult->id_resultado,
        "id_muestra" => $parameterResult->id_muestra,
        "id_parametro" => $parameterResult->id_parametro,
        "id_tipo_resultado" => $parameterResult->id_tipo_resultado,
        "id_tipo_valor" => $parameterResult->id_tipo_valor,
        "id_usuario_actualiza" => $userId,
        "valor" => $parameterResult->valor,
        "activo" => 1,
      );
      $resultIds[] = updateResult($result);
    }
  }
  return $resultIds;
}
