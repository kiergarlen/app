<?php
require "../libs/Slim/Slim.php";
require "../libs/JWT/JWT.php";
require "./logic.php";
require "./db.php";
//define("KEY", "cd372fb85148700fa88095e3492d3f9f5beb43e555e5ff26d95f5a6adc36f8e6");
define("KEY", "m0oxUT7L8Unn93hXMUGHpwq_jTSKVBjQfEVCUe8jZ38KUU4VSAfmsNk4JJYcJl7CukrY6QMlixxwat7AZSpDcSQ");

\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();

$app->post("/login", function() use ($app) {
  try {
    $jwt = processUserJwt($app->request());
    $result = json_encode($jwt);
    //////debugging only
    ////$jwt = $token;
    ////$decodedToken = decodeToken($jwt);
    $app->response()->status(200);
    $app->response()->header('Content-Type', 'application/json');
    ////$result = ")]}',\n" . $result;
    //// support for JSONP requests
    //if (!isset($_GET['callback'])) {
    //  echo json_encode($result);
    //} else {
    //  echo $_GET['callback'] . '(' . json_encode($result) . ');';
    //}
    ////debugging only
    ////$result = '{"result":"ok"}';
    print_r($result);
  } catch (Exception $e) {
    $app->response()->status(400);
    $app->response()->header('X-Status-Reason', $e->getMessage());
  }
});

$app->get("/menu", function() use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $result = processMenuToJson(getMenu($userId));
    $app->response()->status(200);
    $app->response()->header('Content-Type', 'application/json');
    //$result = ")]}',\n" . $result;
    print_r($result);
  } catch (Exception $e) {
    $app->response()->status(400);
    $app->response()->header('X-Status-Reason', $e->getMessage());
  }
});

$app->get("/tasks", function() use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $result = getTasks($userId);
    //TODO: Once Tasks table is in DB, replace for this:
    //$result = json_encode(getTasks($userId));
    $app->response()->status(200);
    $app->response()->header('Content-Type', 'application/json');
    //$result = ")]}',\n" . $result;
    print_r($result);
  } catch (Exception $e) {
    $app->response()->status(400);
    $app->response()->header('X-Status-Reason', $e->getMessage());
  }
});

$app->get("/studies(/)(:studyId)", function($studyId = -1) use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    if ($studyId > 0)
    {
      $result = json_encode(getStudy($studyId));
    }
    else if ($studyId == 0)
    {
      $result = json_encode(getBlankStudy());
    }
    else
    {
      $result = json_encode(getStudies());
    }
    $app->response()->status(200);
    $app->response()->header('Content-Type', 'application/json');
    //$result = ")]}',\n" . $result;
    print_r($result);
  } catch (Exception $e) {
    $app->response()->status(400);
    $app->response()->header('X-Status-Reason', $e->getMessage());
  }
});

$app->post("/studies", function() use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $request = $app->request();
    $studyId = extractDataFromRequest($request)->id_estudio;
    if ($studyId < 1)
    {
      $studyInsertData = processStudyInsert($request);
      $studyId = insertStudy($studyInsertData["study"]);
      processStudyOrderInsert($studyInsertData, $studyId);
    }
    else
    {
      $studyUpdateData = processStudyUpdate($request);
      $studyId = updateStudy($studyUpdateData["study"]);
      $orderData = processStudyOrderUpdate($studyUpdateData);
    }
    $result = '{"id_estudio":' . $studyId . '}';
    $app->response()->status(200);
    $app->response()->header('Content-Type', 'application/json');
    //$result = ")]}',\n" . $result;
    print_r($result);
  } catch (Exception $e) {
    $app->response()->status(400);
    $app->response()->header('X-Status-Reason', $e->getMessage());
  }
});

$app->get("/orders(/)(:orderId)", function($orderId = -1) use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    if ($orderId > -1)
    {
      $result = json_encode(getOrder($orderId));
    }
    else
    {
      $result = json_encode(getOrders());
    }
    $app->response()->status(200);
    $app->response()->header('Content-Type', 'application/json');
    //$result = ")]}',\n" . $result;
    print_r($result);
  } catch (Exception $e) {
    $app->response()->status(400);
    $app->response()->header('X-Status-Reason', $e->getMessage());
  }
});

$app->get("/orders/study/(:studyId)", function($studyId) use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $result = json_encode(getOrdersByStudy($studyId));
    $app->response()->status(200);
    $app->response()->header('Content-Type', 'application/json');
    //$result = ")]}',\n" . $result;
    print_r($result);
  } catch (Exception $e) {
    $app->response()->status(400);
    $app->response()->header('X-Status-Reason', $e->getMessage());
  }
});

$app->post("/orders", function() use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $request = $app->request();
    $orderId = extractDataFromRequest($request)->id_orden;
    if ($orderId < 1)
    {
      $orderInsertData = processOrderInsert($request);
      $orderId = insertOrder($orderInsertData);
      // // TODO: check if processOrderPlansInsert() is needed
    }
    else
    {
      $orderUpdateData = processOrderUpdate($request);
      $orderId = updateOrder($orderUpdateData["order"]);
      processOrderPlansUpdate($orderUpdateData);
    }
    $result = '{"id_orden":' . $orderId . '}';
    $app->response()->status(200);
    $app->response()->header('Content-Type', 'application/json');
    //$result = ")]}',\n" . $result;
    print_r($result);
  } catch (Exception $e) {
    $app->response()->status(400);
    $app->response()->header('X-Status-Reason', $e->getMessage());
  }
});

$app->get("/order/sources", function() use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $result = json_encode(getOrderSources());
    $app->response()->status(200);
    $app->response()->header('Content-Type', 'application/json');
    //$result = ")]}',\n" . $result;
    print_r($result);
  } catch (Exception $e) {
    $app->response()->status(400);
    $app->response()->header('X-Status-Reason', $e->getMessage());
  }
});

$app->get("/plans(/)(:planId)", function($planId = -1) use ($app) {
  try {
    //$userId = decodeUserToken($app->request())->uid;
    if ($planId > -1)
    {
      $result = json_encode(getPlan($planId));
    }
    else
    {
      $result = json_encode(getPlans());
    }
    $app->response()->status(200);
    $app->response()->header('Content-Type', 'application/json');
    //$result = ")]}',\n" . $result;
    print_r($result);
  } catch (Exception $e) {
    $app->response()->status(400);
    $app->response()->header('X-Status-Reason', $e->getMessage());
  }
});

$app->post("/plans", function() use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $request = $app->request();
    $requestData = extractDataFromRequest($request);
    //$result = json_encode($requestData);
    $planId = extractDataFromRequest($request)->id_plan;
    if ($planId < 1)
    {
      // $planInsertData = processPlanInsert($request);
      // $planId = insertPlan($planInsertData["plan"]);
    }
    else
    {
      $planUpdateData = processPlanUpdate($request);
      $planId = updatePlan($planUpdateData["plan"]);
      processPlanInstrumentsUpdate($planUpdateData);
      processPlanPreservationsUpdate($planUpdateData);
      processPlanContainersUpdate($planUpdateData);
      $result = json_encode(processPlanContainersUpdate($planUpdateData));
      processPlanReactivesUpdate($planUpdateData);
      processPlanMaterialsUpdate($planUpdateData);
      processPlanCoolersUpdate($planUpdateData);
    }
    //$result = '{"id_plan":' . $planId . '}';
    $app->response()->status(200);
    $app->response()->header('Content-Type', 'application/json');
    //$result = ")]}',\n" . $result;
    print_r($result);
  } catch (Exception $e) {
    $app->response()->status(400);
    $app->response()->header('X-Status-Reason', $e->getMessage());
  }
});

$app->get("/sheets(/)(:sheetId)", function($sheetId = -1) use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $result = json_encode($app->request());
    if ($sheetId > -1)
    {
      $result = json_encode(getSheet($sheetId));
    }
    else
    {
      $result = json_encode(getSheets());
    }
    $app->response()->status(200);
    $app->response()->header('Content-Type', 'application/json');
    //$result = ")]}',\n" . $result;
    print_r($result);
  } catch (Exception $e) {
    $app->response()->status(400);
    $app->response()->header('X-Status-Reason', $e->getMessage());
  }
});

$app->post("/sheets", function() use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $request = $app->request();
    $sheetId = extractDataFromRequest($request)->id_hoja;
    if ($sheetId < 1)
    {
      // $sheetInsertData = processSheetInsert($request);
      // $sheetId = insertSheet($sheetInsertData["sheet"]);
      // //processSheetOrderInsert($sheetInsertData, $sheetId);
    }
    else
    {
      $sheetUpdateData = processSheetUpdate($request);
      $sheetId = updateSheet($sheetUpdateData["sheet"]);
      processSheetResultsUpdate($sheetUpdateData);
      processSheetPreservationsUpdate($sheetUpdateData);
    }
    $result = '{"id_hoja":' . $sheetId . '}';
    $app->response()->status(200);
    $app->response()->header('Content-Type', 'application/json');
    //$result = ")]}',\n" . $result;
    print_r($result);
  } catch (Exception $e) {
    $app->response()->status(400);
    $app->response()->header('X-Status-Reason', $e->getMessage());
  }
});

$app->get("/receptions(/)(:receptionId)", function($receptionId = -1) use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    if ($receptionId > -1)
    {
      $result = json_encode(getReception($receptionId));
    }
    else
    {
      $result = json_encode(getReceptions());
    }
    $app->response()->status(200);
    $app->response()->header('Content-Type', 'application/json');
    //$result = ")]}',\n" . $result;
    print_r($result);
  } catch (Exception $e) {
    $app->response()->status(400);
    $app->response()->header('X-Status-Reason', $e->getMessage());
  }
});

$app->get("/areas/reception", function() use ($app) {
  try {
    //$userId = decodeUserToken($app->request())->uid;
    $result = json_encode(getReceivingAreas());
    $app->response()->status(200);
    $app->response()->header('Content-Type', 'application/json');
    //$result = ")]}',\n" . $result;
    print_r($result);
  } catch (Exception $e) {
    $app->response()->status(400);
    $app->response()->header('X-Status-Reason', $e->getMessage());
  }
});

$app->post("/receptions", function() use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $request = $app->request();
    $receptionId = extractDataFromRequest($request)->id_recepcion;
    if ($receptionId < 1)
    {
      // $receptionInsertData = processReceptionInsert($request);
      // $receptionId = insertReception($receptionInsertData["reception"]);
      // //processReceptionOrderInsert($receptionInsertData, $receptionId);
    }
    else
    {
      $receptionUpdateData = processReceptionUpdate($request);
      $receptionId = updateReception($receptionUpdateData["reception"]);
      processReceptionSamplesUpdate($receptionUpdateData);
      processReceptionPreservationsUpdate($receptionUpdateData);
      processReceptionAreasUpdate($receptionUpdateData);
    }
    $result = '{"id_recepcion":' . $receptionId . '}';
    $app->response()->status(200);
    $app->response()->header('Content-Type', 'application/json');
    //$result = ")]}',\n" . $result;
    print_r($result);
  } catch (Exception $e) {
    $app->response()->status(400);
    $app->response()->header('X-Status-Reason', $e->getMessage());
  }
});

$app->get("/jobs(/)(:jobId)", function($jobId = -1) use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    if ($jobId > -1)
    {
      $result = json_encode(getJob($jobId));
    }
    else
    {
      $result = json_encode(getJobs());
    }
    $app->response()->status(200);
    $app->response()->header('Content-Type', 'application/json');
    //$result = ")]}',\n" . $result;
    print_r($result);
  } catch (Exception $e) {
    $app->response()->status(400);
    $app->response()->header('X-Status-Reason', $e->getMessage());
  }
});

$app->post("/jobs", function() use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $request = $app->request();
    $jobId = extractDataFromRequest($request)->id_orden_trabajo;
    if ($jobId < 1)
    {
      // // $jobInsertData = processJobInsert($request);
      // // $jobId = insertJob($jobInsertData["job"]);
      // // //processJobOrderInsert($jobInsertData, $jobId);
    }
    else
    {
      // $jobUpdateData = processJobUpdate($request);
      // $jobId = updateJob($jobUpdateData["job"]);
    }
    $result = '{"id_orden_trabajo":' . $jobId . '}';
    $app->response()->status(200);
    $app->response()->header('Content-Type', 'application/json');
    //$result = ")]}',\n" . $result;
    print_r($result);
  } catch (Exception $e) {
    $app->response()->status(400);
    $app->response()->header('X-Status-Reason', $e->getMessage());
  }
});

$app->get("/custodies(/)(:custodyId)", function($custodyId = -1) use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    if ($custodyId > -1)
    {
      $result = json_encode(getCustody($custodyId));
    }
    else
    {
      $result = json_encode(getCustodies());
    }
    $app->response()->status(200);
    $app->response()->header('Content-Type', 'application/json');
    //$result = ")]}',\n" . $result;
    print_r($result);
  } catch (Exception $e) {
    $app->response()->status(400);
    $app->response()->header('X-Status-Reason', $e->getMessage());
  }
});

$app->post("/custodies", function() use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $request = $app->request();
    $custodyId = extractDataFromRequest($request)->id_custody;
    if ($custodyId < 1)
    {
      // $custodyInsertData = processReceptionInsert($request);
      // $custodyId = insertReception($custodyInsertData["custody"]);
      // //processReceptionOrderInsert($custodyInsertData, $custodyId);
    }
    else
    {
      //$custodyUpdateData = processReceptionUpdate($request);
      //$custodyId = updateReception($custodyUpdateData["custody"]);
      //processReceptionOrderUpdate($custodyUpdateData);
    }
    $result = '{"id_custody":' . $custodyId . '}';
    $requestData = extractDataFromRequest($request);
    $result = json_encode($requestData);
    $app->response()->status(200);
    $app->response()->header('Content-Type', 'application/json');
    //$result = ")]}',\n" . $result;
    print_r($result);
  } catch (Exception $e) {
    $app->response()->status(400);
    $app->response()->header('X-Status-Reason', $e->getMessage());
  }
});
//CATALOGS
$app->get("/clients(/)(:clientId)", function($clientId = -1) use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    if ($clientId > -1)
    {
      $result = json_encode(getClient($clientId));
    }
    else
    {
      $result = json_encode(getClients());
    }
    $app->response()->status(200);
    $app->response()->header('Content-Type', 'application/json');
    //$result = ")]}',\n" . $result;
    print_r($result);
  } catch (Exception $e) {
    $app->response()->status(400);
    $app->response()->header('X-Status-Reason', $e->getMessage());
  }
});

$app->get("/parameters", function() use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $result = json_encode(getParameters());
    $app->response()->status(200);
    $app->response()->header('Content-Type', 'application/json');
    //$result = ")]}',\n" . $result;
    print_r($result);
  } catch (Exception $e) {
    $app->response()->status(400);
    $app->response()->header('X-Status-Reason', $e->getMessage());
  }
});

$app->get("/norms(/)(:normId)", function($normId = -1) use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    if ($normId > -1)
    {
      $result = json_encode(getNorm($normId));
    }
    else
    {
      $result = json_encode(getNorms());
    }
    $app->response()->status(200);
    $app->response()->header('Content-Type', 'application/json');
    //$result = ")]}',\n" . $result;
    print_r($result);
  } catch (Exception $e) {
    $app->response()->status(400);
    $app->response()->header('X-Status-Reason', $e->getMessage());
  }
});

$app->get("/sampling/types", function() use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $result = json_encode(getSamplingTypes());
    $app->response()->status(200);
    $app->response()->header('Content-Type', 'application/json');
    //$result = ")]}',\n" . $result;
    print_r($result);
  } catch (Exception $e) {
    $app->response()->status(400);
    $app->response()->header('X-Status-Reason', $e->getMessage());
  }
});

$app->get("/matrices", function() use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $result = json_encode(getMatrices());
    $app->response()->status(200);
    $app->response()->header('Content-Type', 'application/json');
    //$result = ")]}',\n" . $result;
    print_r($result);
  } catch (Exception $e) {
    $app->response()->status(400);
    $app->response()->header('X-Status-Reason', $e->getMessage());
  }
});

$app->get("/points/packages", function() use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $result = json_encode(getPointPackages());
    $app->response()->status(200);
    $app->response()->header('Content-Type', 'application/json');
    //$result = ")]}',\n" . $result;
    print_r($result);
  } catch (Exception $e) {
    $app->response()->status(400);
    $app->response()->header('X-Status-Reason', $e->getMessage());
  }
});

$app->get("/sampling/supervisors(/)(:empId)", function($empId = -1) use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    if ($empId > 0)
    {
      $result = json_encode(getSamplingEmployee($empId));
    }
    else
    {
      $result = json_encode(getSamplingEmployees());
    }
    $app->response()->status(200);
    $app->response()->header('Content-Type', 'application/json');
    //$result = ")]}',\n" . $result;
    print_r($result);
  } catch (Exception $e) {
    $app->response()->status(400);
    $app->response()->header('X-Status-Reason', $e->getMessage());
  }
});

$app->get("/sampling/employees(/)(:empId)", function($empId = -1) use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    if ($empId > 0)
    {
      $result = json_encode(getSamplingEmployee($empId));
    }
    else
    {
      $result = json_encode(getSamplingEmployees());
    }
    $app->response()->status(200);
    $app->response()->header('Content-Type', 'application/json');
    //$result = ")]}',\n" . $result;
    print_r($result);
  } catch (Exception $e) {
    $app->response()->status(400);
    $app->response()->header('X-Status-Reason', $e->getMessage());
  }
});

$app->get("/plan/objectives", function() use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $result = json_encode(getPlanObjectives());
    $app->response()->status(200);
    $app->response()->header('Content-Type', 'application/json');
    //$result = ")]}',\n" . $result;
    print_r($result);
  } catch (Exception $e) {
    $app->response()->status(400);
    $app->response()->header('X-Status-Reason', $e->getMessage());
  }
});

$app->get("/point/kinds", function() use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $result = json_encode(getPointKinds());
    $app->response()->status(200);
    $app->response()->header('Content-Type', 'application/json');
    //$result = ")]}',\n" . $result;
    print_r($result);
  } catch (Exception $e) {
    $app->response()->status(400);
    $app->response()->header('X-Status-Reason', $e->getMessage());
  }
});

$app->get("/districts(/)(:districtId)", function($districtId = -1) use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    if ($districtId > 0)
    {
      $result = json_encode(getDistrict($districtId));
    }
    else
    {
      $result = json_encode(getDistricts());
    }
    $app->response()->status(200);
    $app->response()->header('Content-Type', 'application/json');
    //$result = ")]}',\n" . $result;
    print_r($result);
  } catch (Exception $e) {
    $app->response()->status(400);
    $app->response()->header('X-Status-Reason', $e->getMessage());
  }
});


$app->get("/districts/cities/:districtId", function($districtId) use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $result =json_encode(getCitiesByDistrictId($districtId));
    $app->response()->status(200);
    $app->response()->header('Content-Type', 'application/json');
    //$result = ")]}',\n" . $result;
    print_r($result);
  } catch (Exception $e) {
    $app->response()->status(400);
    $app->response()->header('X-Status-Reason', $e->getMessage());
  }
});

$app->get("/preservations", function() use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $result = json_encode(getPreservations());
    $app->response()->status(200);
    $app->response()->header('Content-Type', 'application/json');
    //$result = ")]}',\n" . $result;
    print_r($result);
  } catch (Exception $e) {
    $app->response()->status(400);
    $app->response()->header('X-Status-Reason', $e->getMessage());
  }
});

$app->get("/containers(/)(:containerId)", function($containerId = -1) use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    if ($containerId > 0)
    {
      $result = json_encode(getContainer($containerId));
    }
    else
    {
      $result = json_encode(getContainers());
    }
    $app->response()->status(200);
    $app->response()->header('Content-Type', 'application/json');
    //$result = ")]}',\n" . $result;
    print_r($result);
  } catch (Exception $e) {
    $app->response()->status(400);
    $app->response()->header('X-Status-Reason', $e->getMessage());
  }
});

$app->get("/reactives", function() use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $result = json_encode(getReactives());
    $app->response()->status(200);
    $app->response()->header('Content-Type', 'application/json');
    //$result = ")]}',\n" . $result;
    print_r($result);
  } catch (Exception $e) {
    $app->response()->status(400);
    $app->response()->header('X-Status-Reason', $e->getMessage());
  }
});

$app->get("/materials", function() use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $result = json_encode(getMaterials());
    $app->response()->status(200);
    $app->response()->header('Content-Type', 'application/json');
    //$result = ")]}',\n" . $result;
    print_r($result);
  } catch (Exception $e) {
    $app->response()->status(400);
    $app->response()->header('X-Status-Reason', $e->getMessage());
  }
});

$app->get("/instruments/sampling", function() use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $result = json_encode(getSamplingInstruments());
    $app->response()->status(200);
    $app->response()->header('Content-Type', 'application/json');
    //$result = ")]}',\n" . $result;
    print_r($result);
  } catch (Exception $e) {
    $app->response()->status(400);
    $app->response()->header('X-Status-Reason', $e->getMessage());
  }
});

$app->get("/coolers", function() use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $result = json_encode(getCoolers());
    $app->response()->status(200);
    $app->response()->header('Content-Type', 'application/json');
    //$result = ")]}',\n" . $result;
    print_r($result);
  } catch (Exception $e) {
    $app->response()->status(400);
    $app->response()->header('X-Status-Reason', $e->getMessage());
  }
});

$app->get("/clouds", function() use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $result = json_encode(getClouds());
    $app->response()->status(200);
    $app->response()->header('Content-Type', 'application/json');
    //$result = ")]}',\n" . $result;
    print_r($result);
  } catch (Exception $e) {
    $app->response()->status(400);
    $app->response()->header('X-Status-Reason', $e->getMessage());
  }
});

$app->get("/winds", function() use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $result = json_encode(getCurrentDirections());
    $app->response()->status(200);
    $app->response()->header('Content-Type', 'application/json');
    //$result = ")]}',\n" . $result;
    print_r($result);
  } catch (Exception $e) {
    $app->response()->status(400);
    $app->response()->header('X-Status-Reason', $e->getMessage());
  }
});

$app->get("/waves", function() use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $result = json_encode(getWaves());
    $app->response()->status(200);
    $app->response()->header('Content-Type', 'application/json');
    //$result = ")]}',\n" . $result;
    print_r($result);
  } catch (Exception $e) {
    $app->response()->status(400);
    $app->response()->header('X-Status-Reason', $e->getMessage());
  }
});

$app->get("/sampling/norms", function() use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $result = json_encode(getSamplingNorms());
    $app->response()->status(200);
    $app->response()->header('Content-Type', 'application/json');
    //$result = ")]}',\n" . $result;
    print_r($result);
  } catch (Exception $e) {
    $app->response()->status(400);
    $app->response()->header('X-Status-Reason', $e->getMessage());
  }
});

$app->get("/points(/)(:pointId)", function($pointId = -1) use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    if ($pointId > -1)
    {
      $result = json_encode(getPoint($pointId));
    }
    else
    {
      $result = json_encode(getPoints());
    }
    $app->response()->status(200);
    $app->response()->header('Content-Type', 'application/json');
    //$result = ")]}',\n" . $result;
    print_r($result);
  } catch (Exception $e) {
    $app->response()->status(400);
    $app->response()->header('X-Status-Reason', $e->getMessage());
  }
});

$app->get("/parameters/field", function() use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $result = json_encode(getParametersField());
    $app->response()->status(200);
    $app->response()->header('Content-Type', 'application/json');
    //$result = ")]}',\n" . $result;
    print_r($result);
  } catch (Exception $e) {
    $app->response()->status(400);
    $app->response()->header('X-Status-Reason', $e->getMessage());
  }
});

$app->get("/receptionists", function() use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $result = json_encode(getReceptionists());
    $app->response()->status(200);
    $app->response()->header('Content-Type', 'application/json');
    //$result = ")]}',\n" . $result;
    print_r($result);
  } catch (Exception $e) {
    $app->response()->status(400);
    $app->response()->header('X-Status-Reason', $e->getMessage());
  }
});

$app->get("/samples", function() use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $result = json_encode(getSamples());
    $app->response()->status(200);
    $app->response()->header('Content-Type', 'application/json');
    //$result = ")]}',\n" . $result;
    print_r($result);
  } catch (Exception $e) {
    $app->response()->status(400);
    $app->response()->header('X-Status-Reason', $e->getMessage());
  }
});

$app->get("/sheet/samples/:sheetId", function($sheetId) use ($app) {
  try {
    //$userId = decodeUserToken($app->request())->uid;
    $result = json_encode(getSamplesBySheet($sheetId));
    $app->response()->status(200);
    $app->response()->header('Content-Type', 'application/json');
    //$result = ")]}',\n" . $result;
    print_r($result);
  } catch (Exception $e) {
    $app->response()->status(400);
    $app->response()->header('X-Status-Reason', $e->getMessage());
  }
});

$app->get("/instruments", function() use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $result = json_encode(getInstruments());
    $app->response()->status(200);
    $app->response()->header('Content-Type', 'application/json');
    //$result = ")]}',\n" . $result;
    print_r($result);
  } catch (Exception $e) {
    $app->response()->status(400);
    $app->response()->header('X-Status-Reason', $e->getMessage());
  }
});

$app->get("/containers", function() use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $result = json_encode(getContainers());
    $app->response()->status(200);
    $app->response()->header('Content-Type', 'application/json');
    //$result = ")]}',\n" . $result;
    print_r($result);
  } catch (Exception $e) {
    $app->response()->status(400);
    $app->response()->header('X-Status-Reason', $e->getMessage());
  }
});

$app->get("/analysis", function() use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $result = json_encode(getAnalysis());
    $app->response()->status(200);
    $app->response()->header('Content-Type', 'application/json');
    //$result = ")]}',\n" . $result;
    print_r($result);
  } catch (Exception $e) {
    $app->response()->status(400);
    $app->response()->header('X-Status-Reason', $e->getMessage());
  }
});

$app->get("/analysis/selections", function() use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $result = json_encode(getAnalysisSelections());
    $app->response()->status(200);
    $app->response()->header('Content-Type', 'application/json');
    //$result = ")]}',\n" . $result;
    print_r($result);
  } catch (Exception $e) {
    $app->response()->status(400);
    $app->response()->header('X-Status-Reason', $e->getMessage());
  }
});

$app->get("/areas", function() use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $result = json_encode(getAreas());
    $app->response()->status(200);
    $app->response()->header('Content-Type', 'application/json');
    //$result = ")]}',\n" . $result;
    print_r($result);
  } catch (Exception $e) {
    $app->response()->status(400);
    $app->response()->header('X-Status-Reason', $e->getMessage());
  }
});

$app->get("/reports", function() use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $result = json_encode(getReports());
    $app->response()->status(200);
    $app->response()->header('Content-Type', 'application/json');
    //$result = ")]}',\n" . $result;
    print_r($result);
  } catch (Exception $e) {
    $app->response()->status(400);
    $app->response()->header('X-Status-Reason', $e->getMessage());
  }
});

$app->get("/employees", function() use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $result = json_encode(getEmployees());
    $app->response()->status(200);
    $app->response()->header('Content-Type', 'application/json');
    //$result = ")]}',\n" . $result;
    print_r($result);
  } catch (Exception $e) {
    $app->response()->status(400);
    $app->response()->header('X-Status-Reason', $e->getMessage());
  }
});

$app->get("/references", function() use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $result = json_encode(getReferences());
    $app->response()->status(200);
    $app->response()->header('Content-Type', 'application/json');
    //$result = ")]}',\n" . $result;
    print_r($result);
  } catch (Exception $e) {
    $app->response()->status(400);
    $app->response()->header('X-Status-Reason', $e->getMessage());
  }
});

$app->get("/methods(/)(:methodId)", function() use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    if ($methodId > -1)
    {
      $result = json_encode(getMethod($methodId));
    }
    else
    {
      $result = json_encode(getMethods());
    }
    $app->response()->status(200);
    $app->response()->header('Content-Type', 'application/json');
    //$result = ")]}',\n" . $result;
    print_r($result);
  } catch (Exception $e) {
    $app->response()->status(400);
    $app->response()->header('X-Status-Reason', $e->getMessage());
  }
});

$app->get("/prices", function() use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $result = json_encode(getPrices());
    $app->response()->status(200);
    $app->response()->header('Content-Type', 'application/json');
    //$result = ")]}',\n" . $result;
    print_r($result);
  } catch (Exception $e) {
    $app->response()->status(400);
    $app->response()->header('X-Status-Reason', $e->getMessage());
  }
});

$app->get("/users(/)(:userId)", function($userId = -1) use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    if ($userId > -1)
    {
      $result = json_encode(getUser($userId));
    }
    else
    {
      $result = json_encode(getUsers());
    }
    $app->response()->status(200);
    $app->response()->header('Content-Type', 'application/json');
    //$result = ")]}',\n" . $result;
    print_r($result);
  } catch (Exception $e) {
    $app->response()->status(400);
    $app->response()->header('X-Status-Reason', $e->getMessage());
  }
});

$app->run();
