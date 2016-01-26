<?php
require "../libs/Slim/Slim.php";
require "../libs/JWT/JWT.php";
require "./logic.php";
require "./db.php";

\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
define("KEY", "m0oxUT7L8Unn93hXMUGHpwq_jTSKVBjQfEVCUe8jZ38KUU4VSAfmsNk4JJYcJl7CukrY6QMlixxwat7AZSpDcSQ");

/**
 * processUserJwt
 * @param mixed $request
 * @return mixed
 */
function processUserJwt($request)
{
  $input = json_decode($request->getbody());
  $usr = $input->username;
  $pwd = $input->password;

  $userInfo = getUserByCredentials($usr, $pwd);
  $userId = $userInfo->id_usuario;
  $userLv = $userInfo->id_nivel;
  $name = $userInfo->nombres . " ";
  $name .= $userInfo->apellido_paterno . " ";
  $name .= $userInfo->apellido_materno . "";

  $userPass = $usr . "." . $pwd . "." . "." . $userLv;
  $userPass = bin2hex($userPass);
  $token = array();
  $token["nam"] = $name;
  $token["upt"] = $userPass;
  $token["uid"] = $userId;
  $token["ulv"] = $userLv;
  $token["uro"] = $userInfo->id_rol;
  $token["uar"] = $userInfo->id_area;
  $token["cip"] = $request->getIp() . "";
  $token["iss"] = $request->getUrl();
  $token["aud"] = "sislab.ceajalisco.gob.mx";
  $token["iat"] = time();
  //// Token expires 24 hours from now
  $token["exp"] = time() + (48 * 60 * 60);
  $jwt = JWT::encode($token, KEY);
  return $jwt;
}

/**
 * decodeJwt
 * @param mixed $jwt
 * @return array
 */
function decodeJwt($jwt)
{
  return (array) JWT::decode($jwt, KEY);
}

/**
 * extractDataFromRequest
 * @param mixed $request
 */
function extractDataFromRequest($request)
{
  return json_decode($request->getBody());
}

/**
 * decodeUserToken
 * @param mixed $request
 * @return mixed
 */
function decodeUserToken($request)
{
  try {
    $headers = $request->headers();
    $jwt = $headers["Auth-Token"];
    $decoded = JWT::decode($jwt, KEY);
    $tokenUserId = $decoded->uid;
    $tokenIp = $decoded->cip;
    $tokenUrl = $decoded->iss;
    $requestIp = $request->getIp();
    $requestUrl = $request->getUrl();
    if ($tokenIp === $request->getIp()) {
      return $decoded;
    } else {
      sendNotFoundResponse($app);
    }
  } catch (Exception $e) {
    sendErrorResponse($app, $e);
  }
}

/**
 * sendSuccessResponse
 * @param  mixed $app
 * @param  mixed $result
 */
function sendSuccessResponse($app, $result)
{
  $app->response()->status(200);
  $app->response()->header("Content-Type", "application/json");
  //JSONP enable
  if (isset($_GET["callback"])) {
    $result = $_GET["callback"] . "(" . $result . ");";
  }
  //Angular XSS protection
  //$result = ")]}',\n" . $result;
  print_r($result);
}

/**
 * sendErrorResponse
 * @param  mixed $app
 * @param  mixed $e
 */
function sendErrorResponse($app, $e)
{
  $app->response()->status(400);
  $app->response()->header("X-Status-Reason", $e->getMessage());
}

/**
 * sendNotFoundResponse
 * @param  mixed $app
 * @param  mixed $e
 */
function sendNotFoundResponse($app)
{
  $app->response()->status(404);
  $app->response()->header('X-Status-Reason', 'Not found');
}

$app->post("/login", function () use ($app) {
  try {
    $jwt = processUserJwt($app->request());
    $result = json_encode($jwt);
    sendSuccessResponse($app, $result);
  } catch (Exception $e) {
    sendErrorResponse($app, $e);
  }
});

$app->get("/menu", function () use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $result = processMenuToJson(getMenu($userId));
    sendSuccessResponse($app, $result);
  } catch (Exception $e) {
    sendErrorResponse($app, $e);
  }
});

$app->get("/tasks", function () use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $result = json_encode(getTasks($userId));
    sendSuccessResponse($app, $result);
  } catch (Exception $e) {
    sendErrorResponse($app, $e);
  }
});

$app->get("/studies(/)(:studyId)", function ($studyId = -1) use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    if ($studyId > 0) {
      $result = json_encode(getStudy($studyId));
    } else if ($studyId == 0) {
      $result = json_encode(getBlankStudy());
    } else {
      $result = json_encode(getStudies());
    }
    sendSuccessResponse($app, $result);
  } catch (Exception $e) {
    sendErrorResponse($app, $e);
  }
});

$app->post("/studies", function () use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $request = $app->request();
    $studyId = extractDataFromRequest($request)->id_estudio;
    if ($studyId < 1) {
      $studyInsertData = processStudyInsert($request);
      $studyId = insertStudy($studyInsertData["study"]);
      processStudyOrderInsert($studyInsertData, $studyId);
    } else {
      $studyUpdateData = processStudyUpdate($request);
      $studyId = updateStudy($studyUpdateData["study"]);
      $orderData = processStudyOrderUpdate($studyUpdateData);
    }
    $result = "{\"id_estudio\":" . $studyId . "}";
    sendSuccessResponse($app, $result);
  } catch (Exception $e) {
    sendErrorResponse($app, $e);
  }
});

$app->get("/orders(/)(:orderId)", function ($orderId = -1) use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    if ($orderId > -1) {
      $result = json_encode(getOrder($orderId));
    } else {
      $result = json_encode(getOrders());
    }
    sendSuccessResponse($app, $result);
  } catch (Exception $e) {
    sendErrorResponse($app, $e);
  }
});

$app->get("/orders/study/(:studyId)", function ($studyId) use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $result = json_encode(getOrdersByStudy($studyId));
    sendSuccessResponse($app, $result);
  } catch (Exception $e) {
    sendErrorResponse($app, $e);
  }
});

$app->post("/orders", function () use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $request = $app->request();
    $orderId = extractDataFromRequest($request)->id_orden;
    if ($orderId > 0) {
      $orderUpdateData = processOrderUpdate($request);
      $orderId = updateOrder($orderUpdateData["order"]);
      processOrderPlansUpdate($orderUpdateData);
    }
    $result = "{\"id_orden\":" . $orderId . "}";
    sendSuccessResponse($app, $result);
  } catch (Exception $e) {
    sendErrorResponse($app, $e);
  }
});

$app->get("/order/sources(/)(:sourceId)", function ($sourceId = -1) use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    if ($sourceId > -1) {
      $result = json_encode(getOrderSource($sourceId));
    } else {
      $result = json_encode(getOrderSources());
    }
    sendSuccessResponse($app, $result);
  } catch (Exception $e) {
    sendErrorResponse($app, $e);
  }
});

$app->get("/plans(/)(:planId)", function ($planId = -1) use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    if ($planId > -1) {
      $result = json_encode(getPlan($planId));
    } else {
      $result = json_encode(getPlans());
    }
    sendSuccessResponse($app, $result);
  } catch (Exception $e) {
    sendErrorResponse($app, $e);
  }
});

$app->post("/plans", function () use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $request = $app->request();
    $planId = extractDataFromRequest($request)->id_plan;
    if ($planId > 0) {
      $planUpdateData = processPlanUpdate($request);
      $planId = updatePlan($planUpdateData["plan"]);
      processPlanSheetInsert($planUpdateData);
      processPlanReceptionInsert($planUpdateData);
      processPlanSheetSampleInsert($planUpdateData);
      processPlanInstrumentsUpdate($planUpdateData);
      processPlanPreservationsUpdate($planUpdateData);
      processPlanContainersUpdate($planUpdateData);
      processPlanReactivesUpdate($planUpdateData);
      processPlanMaterialsUpdate($planUpdateData);
      processPlanCoolersUpdate($planUpdateData);
    }
    // $result = json_encode(processPlanInstrumentsUpdate($planUpdateData));
    $result = "{\"id_plan\":" . $planId . "}";
    sendSuccessResponse($app, $result);
  } catch (Exception $e) {
    sendErrorResponse($app, $e);
  }
});

$app->get("/plans/containers/:planId", function ($planId) use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $result = json_encode(getPlanContainers($planId));
    sendSuccessResponse($app, $result);
  } catch (Exception $e) {
    sendErrorResponse($app, $e);
  }
});

$app->get("/sheets(/)(:sheetId)", function ($sheetId = -1) use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    if ($sheetId > -1) {
      $result = json_encode(getSheet($sheetId));
    } else {
      $result = json_encode(getSheets());
    }
    sendSuccessResponse($app, $result);
  } catch (Exception $e) {
    sendErrorResponse($app, $e);
  }
});

$app->post("/sheets", function () use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $request = $app->request();
    $sheetId = extractDataFromRequest($request)->id_hoja;
    if ($sheetId > 0) {
      $sheetUpdateData = processSheetUpdate($request);
      $sheetId = updateSheet($sheetUpdateData["sheet"]);
      processSheetResultsUpdate($sheetUpdateData);
      processSheetPreservationsUpdate($sheetUpdateData);
    }
    $result = "{\"id_hoja\":" . $sheetId . "}";
    sendSuccessResponse($app, $result);
  } catch (Exception $e) {
    sendErrorResponse($app, $e);
  }
});

$app->get("/receptions(/)(:receptionId)", function ($receptionId = -1) use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    if ($receptionId > -1) {
      $result = json_encode(getReception($receptionId));
    } else {
      $result = json_encode(getReceptions());
    }
    sendSuccessResponse($app, $result);
  } catch (Exception $e) {
    sendErrorResponse($app, $e);
  }
});

$app->get("/areas/reception", function () use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $result = json_encode(getReceivingAreas());
    sendSuccessResponse($app, $result);
  } catch (Exception $e) {
    sendErrorResponse($app, $e);
  }
});

$app->post("/receptions", function () use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $request = $app->request();
    $receptionId = extractDataFromRequest($request)->id_recepcion;
    if ($receptionId > 0) {
      $receptionUpdateData = processReceptionUpdate($request);
      $receptionId = updateReception($receptionUpdateData["reception"]);
      processReceptionSamplesUpdate($receptionUpdateData);
      processReceptionPreservationsUpdate($receptionUpdateData);
      processReceptionContainersUpdate($receptionUpdateData);
      processReceptionAreasUpdate($receptionUpdateData);
      processReceptionJobsUpdate($receptionUpdateData);
      processReceptionCustodiesUpdate($receptionUpdateData);
    }
    $result = "{\"id_recepcion\":" . $receptionId . "}";
    sendSuccessResponse($app, $result);
  } catch (Exception $e) {
    sendErrorResponse($app, $e);
  }
});

$app->get("/custodies(/)(:custodyId)", function ($custodyId = -1) use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    if ($custodyId > -1) {
      $result = json_encode(getCustody($custodyId));
    } else {
      $result = json_encode(getCustodies());
    }
    sendSuccessResponse($app, $result);
  } catch (Exception $e) {
    sendErrorResponse($app, $e);
  }
});

$app->post("/custodies", function () use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $request = $app->request();
    $custodyId = extractDataFromRequest($request)->id_custodia;
    if ($custodyId > 0) {
      $custodyUpdateData = processCustodyUpdate($request);
      $custodyId = updateCustody($custodyUpdateData["custody"]);
      processCustodyContainers($custodyUpdateData);
    }
    $result = "{\"id_custodia\":" . $custodyId . "}";
    sendSuccessResponse($app, $result);
  } catch (Exception $e) {
    sendErrorResponse($app, $e);
  }
});

$app->get("/jobs(/)(:jobId)", function ($jobId = -1) use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    if ($jobId > -1) {
      $result = json_encode(getJob($jobId));
    } else {
      $result = json_encode(getJobs());
    }
    sendSuccessResponse($app, $result);
  } catch (Exception $e) {
    sendErrorResponse($app, $e);
  }
});

$app->get("/jobs/user/:userId", function ($userId) use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $result = json_encode(getJobsByUser($userId * 1));
    sendSuccessResponse($app, $result);
  } catch (Exception $e) {
    sendErrorResponse($app, $e);
  }
});

$app->post("/jobs", function () use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $request = $app->request();
    $jobId = extractDataFromRequest($request)->id_trabajo;
    if ($jobId > 0) {
      $jobUpdateData = processJobUpdate($request);
      $jobId = updateJob($jobUpdateData["job"]);
      processJobAnalysisInsert($jobUpdateData, $jobId);
    }
    $result = "{\"id_trabajo\":" . $jobId . "}";
    sendSuccessResponse($app, $result);
  } catch (Exception $e) {
    sendErrorResponse($app, $e);
  }
});

$app->get("/analysis(/)(:analysisId)", function ($analysisId = -1) use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    if ($analysisId > -1) {
      $result = json_encode(getAnalysis($analysisId));
    } else {
      $result = json_encode(getAnalysisList());
    }
    sendSuccessResponse($app, $result);
  } catch (Exception $e) {
    sendErrorResponse($app, $e);
  }
});

$app->post("/analysis", function () use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $request = $app->request();
    $analysisId = 0;
    $analysisId = extractDataFromRequest($request)->id_analisis;
    if ($analysisId > 0) {
      $analysisUpdateData = processAnalysisUpdate($request);
      $analysisId = updateAnalysis($analysisUpdateData["analysis"]);
      processAnalysisReferencesUpdate($analysisUpdateData);
      processAnalysisResultsUpdate($analysisUpdateData);
    }
    $result = "{\"id_analisis\":" . $analysisId . "}";
    sendSuccessResponse($app, $result);
  } catch (Exception $e) {
    sendErrorResponse($app, $e);
  }
});

//CATALOGS
$app->get("/clients(/)(:clientId)", function ($clientId = -1) use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    if ($clientId > -1) {
      $result = json_encode(getClient($clientId));
    } else {
      $result = json_encode(getClients());
    }
    sendSuccessResponse($app, $result);
  } catch (Exception $e) {
    sendErrorResponse($app, $e);
  }
});

$app->get("/parameters", function () use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $result = json_encode(getParameters());
    sendSuccessResponse($app, $result);
  } catch (Exception $e) {
    sendErrorResponse($app, $e);
  }
});

$app->get("/parameters/field", function () use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $result = json_encode(getParametersField());
    sendSuccessResponse($app, $result);
  } catch (Exception $e) {
    sendErrorResponse($app, $e);
  }
});

$app->get("/parameters/custodies/:custodyId", function ($custodyId) use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    // $result = json_encode(getParametersByCustody($custodyId));
    $result = json_encode(getParametersLab());
    sendSuccessResponse($app, $result);
  } catch (Exception $e) {
    sendErrorResponse($app, $e);
  }
});

$app->get("/norms(/)(:normId)", function ($normId = -1) use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    if ($normId > -1) {
      $result = json_encode(getNorm($normId));
    } else {
      $result = json_encode(getNorms());
    }
    sendSuccessResponse($app, $result);
  } catch (Exception $e) {
    sendErrorResponse($app, $e);
  }
});

$app->get("/sampling/types", function () use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $result = json_encode(getSamplingTypes());
    sendSuccessResponse($app, $result);
  } catch (Exception $e) {
    sendErrorResponse($app, $e);
  }
});

$app->get("/matrices", function () use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $result = json_encode(getMatrices());
    sendSuccessResponse($app, $result);
  } catch (Exception $e) {
    sendErrorResponse($app, $e);
  }
});

$app->get("/packages/points/:packageId", function ($packageId) use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $result = json_encode(getPointsByPackage($packageId));
    //$result = json_encode(getPackages());
    sendSuccessResponse($app, $result);
  } catch (Exception $e) {
    sendErrorResponse($app, $e);
  }
});

$app->get("/packages/location(/)(:locationId)", function ($locationId = -1) use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    if ($locationId > -1) {
      $result = json_encode(getPackagesByLocation($locationId));
    } else {
      $result = json_encode(getPackages());
    }
    sendSuccessResponse($app, $result);
  } catch (Exception $e) {
    sendErrorResponse($app, $e);
  }
});

$app->get("/bodies(/)(:bodyId)", function ($bodyId = -1) use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    if ($bodyId > -1) {
      $result = json_encode(getWaterBody($bodyId));
    } else {
      $result = json_encode(getWaterBodies());
    }
    sendSuccessResponse($app, $result);
  } catch (Exception $e) {
    sendErrorResponse($app, $e);
  }
});

$app->get("/sampling/supervisors(/)(:empId)", function ($empId = -1) use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    if ($empId > 0) {
      $result = json_encode(getSamplingEmployee($empId));
    } else {
      $result = json_encode(getSamplingEmployees());
    }
    sendSuccessResponse($app, $result);
  } catch (Exception $e) {
    sendErrorResponse($app, $e);
  }
});

$app->get("/sampling/employees(/)(:empId)", function ($empId = -1) use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    if ($empId > 0) {
      $result = json_encode(getSamplingEmployee($empId));
    } else {
      $result = json_encode(getSamplingEmployees());
    }
    sendSuccessResponse($app, $result);
  } catch (Exception $e) {
    sendErrorResponse($app, $e);
  }
});

$app->get("/plan/objectives", function () use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $result = json_encode(getPlanObjectives());
    sendSuccessResponse($app, $result);
  } catch (Exception $e) {
    sendErrorResponse($app, $e);
  }
});

$app->get("/point/kinds", function () use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $result = json_encode(getPointKinds());
    sendSuccessResponse($app, $result);
  } catch (Exception $e) {
    sendErrorResponse($app, $e);
  }
});

$app->get("/districts(/)(:districtId)", function ($districtId = -1) use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    if ($districtId > 0) {
      $result = json_encode(getDistrict($districtId));
    } else {
      $result = json_encode(getDistricts());
    }
    sendSuccessResponse($app, $result);
  } catch (Exception $e) {
    sendErrorResponse($app, $e);
  }
});

$app->get("/districts/cities/:districtId", function ($districtId) use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $result = json_encode(getCitiesByDistrictId($districtId));
    sendSuccessResponse($app, $result);
  } catch (Exception $e) {
    sendErrorResponse($app, $e);
  }
});

$app->get("/preservations", function () use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $result = json_encode(getPreservations());
    sendSuccessResponse($app, $result);
  } catch (Exception $e) {
    sendErrorResponse($app, $e);
  }
});

$app->get("/containers(/)(:containerId)", function ($containerId = -1) use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    if ($containerId > 0) {
      $result = json_encode(getContainer($containerId));
    } else {
      $result = json_encode(getContainers());
    }
    sendSuccessResponse($app, $result);
  } catch (Exception $e) {
    sendErrorResponse($app, $e);
  }
});

$app->get("/containers/logs/:containerId", function ($containerId) use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $result = json_encode(getContainerLogs($containerId));
    sendSuccessResponse($app, $result);
  } catch (Exception $e) {
    sendErrorResponse($app, $e);
  }
});

$app->get("/reactives", function () use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $result = json_encode(getReactives());
    sendSuccessResponse($app, $result);
  } catch (Exception $e) {
    sendErrorResponse($app, $e);
  }
});

$app->get("/materials", function () use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $result = json_encode(getMaterials());
    sendSuccessResponse($app, $result);
  } catch (Exception $e) {
    sendErrorResponse($app, $e);
  }
});

$app->get("/instruments/sampling", function () use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $result = json_encode(getSamplingInstruments());
    sendSuccessResponse($app, $result);
  } catch (Exception $e) {
    sendErrorResponse($app, $e);
  }
});

$app->get("/coolers", function () use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $result = json_encode(getCoolers());
    sendSuccessResponse($app, $result);
  } catch (Exception $e) {
    sendErrorResponse($app, $e);
  }
});

$app->get("/clouds", function () use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $result = json_encode(getClouds());
    sendSuccessResponse($app, $result);
  } catch (Exception $e) {
    sendErrorResponse($app, $e);
  }
});

$app->get("/winds", function () use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $result = json_encode(getCurrentDirections());
    sendSuccessResponse($app, $result);
  } catch (Exception $e) {
    sendErrorResponse($app, $e);
  }
});

$app->get("/waves", function () use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $result = json_encode(getWaves());
    sendSuccessResponse($app, $result);
  } catch (Exception $e) {
    sendErrorResponse($app, $e);
  }
});

$app->get("/sampling/norms", function () use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $result = json_encode(getSamplingNorms());
    sendSuccessResponse($app, $result);
  } catch (Exception $e) {
    sendErrorResponse($app, $e);
  }
});

$app->get("/points(/)(:pointId)", function ($pointId = -1) use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    if ($pointId > -1) {
      $result = json_encode(getPoint($pointId));
    } else {
      $result = json_encode(getPoints());
    }
    sendSuccessResponse($app, $result);
  } catch (Exception $e) {
    sendErrorResponse($app, $e);
  }
});

$app->get("/receptionists", function () use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $result = json_encode(getReceptionists());
    sendSuccessResponse($app, $result);
  } catch (Exception $e) {
    sendErrorResponse($app, $e);
  }
});

$app->get("/analysts", function () use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $result = json_encode(getAnalysts());
    sendSuccessResponse($app, $result);
  } catch (Exception $e) {
    sendErrorResponse($app, $e);
  }
});

$app->get("/samples(/)(:sampleId)", function ($sampleId = -1) use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    if ($sampleId > -1) {
      $result = json_encode(getSample($sampleId));
    } else {
      $result = json_encode(getSamples());
    }
    sendSuccessResponse($app, $result);
  } catch (Exception $e) {
    sendErrorResponse($app, $e);
  }
});

$app->get("/sheet/samples/:sheetId", function ($sheetId) use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $result = json_encode(getSamplesBySheet($sheetId));
    sendSuccessResponse($app, $result);
  } catch (Exception $e) {
    sendErrorResponse($app, $e);
  }
});

$app->get("/instruments", function () use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $result = json_encode(getInstruments());
    sendSuccessResponse($app, $result);
  } catch (Exception $e) {
    sendErrorResponse($app, $e);
  }
});

$app->get("/containers", function () use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $result = json_encode(getContainers());
    sendSuccessResponse($app, $result);
  } catch (Exception $e) {
    sendErrorResponse($app, $e);
  }
});

$app->get("/areas", function () use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $result = json_encode(getAreas());
    sendSuccessResponse($app, $result);
  } catch (Exception $e) {
    sendErrorResponse($app, $e);
  }
});

$app->get("/reports", function () use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $result = json_encode(getReports());
    sendSuccessResponse($app, $result);
  } catch (Exception $e) {
    sendErrorResponse($app, $e);
  }
});

$app->get("/employees", function () use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $result = json_encode(getEmployees());
    sendSuccessResponse($app, $result);
  } catch (Exception $e) {
    sendErrorResponse($app, $e);
  }
});

$app->get("/references", function () use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $result = json_encode(getReferences());
    sendSuccessResponse($app, $result);
  } catch (Exception $e) {
    sendErrorResponse($app, $e);
  }
});

$app->get("/methods(/)(:methodId)", function () use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    if ($methodId > -1) {
      $result = json_encode(getMethod($methodId));
    } else {
      $result = json_encode(getMethods());
    }
    sendSuccessResponse($app, $result);
  } catch (Exception $e) {
    sendErrorResponse($app, $e);
  }
});

$app->get("/storages(/)(:storageId)", function ($storageId = -1) use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    if ($storageId > -1) {
      $result = json_encode(getStorage($storageId));
    } else {
      $result = json_encode(getStorages());
    }
    sendSuccessResponse($app, $result);
  } catch (Exception $e) {
    sendErrorResponse($app, $e);
  }
});

$app->get("/prices", function () use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    $result = json_encode(getPrices());
    sendSuccessResponse($app, $result);
  } catch (Exception $e) {
    sendErrorResponse($app, $e);
  }
});

$app->get("/locations(/)(:locationId)", function ($locationId = -1) use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    if ($locationId > -1) {
      $result = json_encode(getLocation($locationId));
    } else {
      $result = json_encode(getLocations());
    }
    sendSuccessResponse($app, $result);
  } catch (Exception $e) {
    sendErrorResponse($app, $e);
  }
});

$app->get("/users(/)(:userId)", function ($userId = -1) use ($app) {
  try {
    $userId = decodeUserToken($app->request())->uid;
    if ($userId > -1) {
      $result = json_encode(getUser($userId));
    } else {
      $result = json_encode(getUsers());
    }
    sendSuccessResponse($app, $result);
  } catch (Exception $e) {
    sendErrorResponse($app, $e);
  }
});

$app->run();
