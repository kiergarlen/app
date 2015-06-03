<?php
require "../libs/Slim/Slim.php";
require "../libs/JWT/JWT.php";
require "./Services/DALSislab.php";
require "./db.php";
// cd372fb85148700fa88095e3492d3f9f5beb43e555e5ff26d95f5a6adc36f8e6
define("KEY", "m0oxUT7L8Unn93hXMUGHpwq_jTSKVBjQfEVCUe8jZ38KUU4VSAfmsNk4JJYcJl7CukrY6QMlixxwat7AZSpDcSQ");

define("DB_DRIVER", "sqlsrv");
define("DB_HOST", "localhost");
define("DB_USER", "sislab");
define("DB_PASSWORD", "sislab");
define("DB_DATA_BASE", "Sislab");

// define("DB_DRIVER", "mysql");
// define("DB_HOST", "localhost");
// define("DB_PORT", "8889");
// define("DB_USER", "root");
// define("DB_PASSWORD", "root");
// define("DB_DATA_BASE", "sislab");

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
		//	echo json_encode($result);
		//} else {
		//	echo $_GET['callback'] . '(' . json_encode($result) . ');';
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
		$result = json_encode(getBlankStudy($studyId));
		if ($studyId > 0)
		{
			$result = json_encode(getStudy($studyId));
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
			$result = '{"id_estudio":' . $studyId . '}';
		}
		else
		{
			$studyUpdateData = processStudyUpdate($request);
			$studyId = updateStudy($studyUpdateData["study"]);
			processStudyOrderUpdate($studyUpdateData);
			$result = '{"id_estudio":' . $studyId . '}';
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

// $app->get("/quotes(/)(:quoteId)", function($quoteId = -1) use ($app) {
// 	try {
// 		$userId = decodeUserToken($app->request())->uid;
// 		if ($quoteId > -1)
// 		{
// 			$result = \Service\DALSislab::getInstance()->getQuote($quoteId);
// 		}
// 		else
// 		{
// 			$result = \Service\DALSislab::getInstance()->getQuotes();
// 		}
// 		$app->response()->status(200);
// 		$app->response()->header('Content-Type', 'application/json');
// 		//$result = ")]}',\n" . $result;
// 		print_r($result);
// 	} catch (Exception $e) {
// 		$app->response()->status(400);
// 		$app->response()->header('X-Status-Reason', $e->getMessage());
// 	}
// });

// $app->post("/quotes", function() use ($app) {
// 	try {
// 		$request = $app->request();
// 		$requestBody = $request->getBody();

// 		$requestData = extractDataFromRequest($request);
// 		$result = json_encode($requestData);

// 		$userId = decodeUserToken($app->request())->uid;
// 		//$result = insertStudy();
// 		$app->response()->status(200);
// 		$app->response()->header('Content-Type', 'application/json');
// 		//$result = ")]}',\n" . $result;
// 		print_r($result);
// 	} catch (Exception $e) {
// 		$app->response()->status(400);
// 		$app->response()->header('X-Status-Reason', $e->getMessage());
// 	}
// });

$app->get("/orders(/)(:orderId)", function($orderId = -1) use ($app) {
	try {
		$userId = decodeUserToken($app->request())->uid;
		if ($orderId > 0)
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

$app->post("/orders", function() use ($app) {
	try {
		$userId = decodeUserToken($app->request())->uid;
		$request = $app->request();
		//$requestData = extractDataFromRequest($request);
		$orderId = extractDataFromRequest($request)->id_orden;
		if ($orderId < 1)
		{
			$orderInsertData = processOrderInsert($request);
			$orderId = insertOrder($orderInsertData);
			//TODO: check if processOrderPlansInsert() is needed
			$result = '{"id_orden":' . $orderId . '}';
		}
		else
		{
			$orderUpdateData = processOrderUpdate($request);
			$orderId = updateOrder($orderUpdateData["order"]);
			$orderPlans = processOrderPlansUpdate($orderUpdateData);
			//$result = $orderPlans;
			$result = '{"id_orden":' . $orderId . '}';
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
		$userId = decodeUserToken($app->request())->uid;
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
		$request = $app->request();
		$requestBody = $request->getBody();

		$requestData = extractDataFromRequest($request);
		$result = json_encode($requestData);

		$userId = decodeUserToken($app->request())->uid;
		//$result = insertStudy();
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
		//$userId = decodeUserToken($app->request())->uid;
		$userId = 1;
		if ($sheetId > -1)
		{
			$result = \Service\DALSislab::getInstance()->getSheet($sheetId);
		}
		else
		{
			$result = \Service\DALSislab::getInstance()->getSheets();
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
		$request = $app->request();
		$requestBody = $request->getBody();

		$requestData = extractDataFromRequest($request);
		$result = json_encode($requestData);

		$userId = decodeUserToken($app->request())->uid;
		//$result = insertStudy();
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
			$result = \Service\DALSislab::getInstance()->getReception($receptionId);
		}
		else
		{
			$result = \Service\DALSislab::getInstance()->getReceptions();
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

$app->post("/receptions", function() use ($app) {
	try {
		$request = $app->request();
		$requestBody = $request->getBody();

		$requestData = extractDataFromRequest($request);
		$result = json_encode($requestData);

		$userId = decodeUserToken($app->request())->uid;
		//$result = insertStudy();
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
			$result = \Service\DALSislab::getInstance()->getCustody($custodyId);
		}
		else
		{
			$result = \Service\DALSislab::getInstance()->getCustodies();
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
		$request = $app->request();
		$requestBody = $request->getBody();

		$requestData = extractDataFromRequest($request);
		$result = json_encode($requestData);

		$userId = decodeUserToken($app->request())->uid;
		//$result = insertStudy();
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
		$result = \Service\DALSislab::getInstance()->getParameters();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		//$result = ")]}',\n" . $result;
		print_r($result);
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/norms", function() use ($app) {
	try {
		$userId = decodeUserToken($app->request())->uid;
		$result = \Service\DALSislab::getInstance()->getNorms();
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
		$result = \Service\DALSislab::getInstance()->getSamplingTypes();
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
		$result = \Service\DALSislab::getInstance()->getMatrices();
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
		//$userId = decodeUserToken($app->request())->uid;
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

$app->get("/sampling/supervisors", function() use ($app) {
	try {
		$userId = decodeUserToken($app->request())->uid;
		$result = \Service\DALSislab::getInstance()->getSamplingSupervisors();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		print_r($result);
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/sampling/employees", function() use ($app) {
	try {
		//$userId = decodeUserToken($app->request())->uid;
		$result = \Service\DALSislab::getInstance()->getSamplingEmployees();
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
		$result = \Service\DALSislab::getInstance()->getPointKinds();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		//$result = ")]}',\n" . $result;
		print_r($result);
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/districts/:districtId", function($districtId) use ($app) {
	try {
		$userId = decodeUserToken($app->request())->uid;
		$result = \Service\DALSislab::getInstance()->getDistrict($districtId);
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		//$result = ")]}',\n" . $result;
		print_r($result);
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/districts", function() use ($app) {
	try {
		$userId = decodeUserToken($app->request())->uid;
		$result = \Service\DALSislab::getInstance()->getDistricts();
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
		$result = \Service\DALSislab::getInstance()->getCitiesByDistrictId($districtId);
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		//$result = ")]}',\n" . $result;
		print_r($result);
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/districts", function() use ($app) {
	try {
		$userId = decodeUserToken($app->request())->uid;
		$result = \Service\DALSislab::getInstance()->getDistricts();
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
		$result = \Service\DALSislab::getInstance()->getPreservations();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		//$result = ")]}',\n" . $result;
		print_r($result);
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/containers/kinds", function() use ($app) {
	try {
		$userId = decodeUserToken($app->request())->uid;
		$result = \Service\DALSislab::getInstance()->getContainerKinds();
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
		$result = \Service\DALSislab::getInstance()->getReactives();
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
		$result = \Service\DALSislab::getInstance()->getMaterials();
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
		$result = \Service\DALSislab::getInstance()->getSamplingInstruments();
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
		$result = \Service\DALSislab::getInstance()->getCoolers();
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
		$result = \Service\DALSislab::getInstance()->getClouds();
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
		$result = \Service\DALSislab::getInstance()->getCurrentDirections();
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
		$result = \Service\DALSislab::getInstance()->getWaves();
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
		$result = \Service\DALSislab::getInstance()->getSamplingNorms();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		//$result = ")]}',\n" . $result;
		print_r($result);
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/points(/)(:pointid)", function($pointId = -1) use ($app) {
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
		$result = \Service\DALSislab::getInstance()->getParametersField();
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
		$result = \Service\DALSislab::getInstance()->getReceptionists();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		//$result = ")]}',\n" . $result;
		print_r($result);
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/expirations", function() use ($app) {
	try {
		$userId = decodeUserToken($app->request())->uid;
		$result = \Service\DALSislab::getInstance()->getExpirations();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		//$result = ")]}',\n" . $result;
		print_r($result);
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/volumes", function() use ($app) {
	try {
		$userId = decodeUserToken($app->request())->uid;
		$result = \Service\DALSislab::getInstance()->getVolumes();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		//$result = ")]}',\n" . $result;
		print_r($result);
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/checkers", function() use ($app) {
	try {
		$userId = decodeUserToken($app->request())->uid;
		$result = \Service\DALSislab::getInstance()->getCheckers();
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
		$result = \Service\DALSislab::getInstance()->getSamples();
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
		$result = \Service\DALSislab::getInstance()->getInstruments();
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
		$result = \Service\DALSislab::getInstance()->getContainers();
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
		$result = \Service\DALSislab::getInstance()->getAnalysis();
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
		$result = \Service\DALSislab::getInstance()->getAreas();
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
		$result = \Service\DALSislab::getInstance()->getAnalysisSelections();
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
		$result = \Service\DALSislab::getInstance()->getReports();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		//$result = ")]}',\n" . $result;
		print_r($result);
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});
/*
$app->get("/reports/:reportId", function($reportId) use ($app) {
	try {
		$userId = decodeUserToken($app->request())->uid;
		$result = \Service\DALSislab::getInstance()->getReport($reportId);
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		//$result = ")]}',\n" . $result;
		print_r($result);
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/reports/:reportId", function() use ($app) {
	try {
		$userId = decodeUserToken($app->request())->uid;
		$result = \Service\DALSislab::getInstance()->getReports();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		//$result = ")]}',\n" . $result;
		print_r($result);
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});
*/
$app->get("/employees", function() use ($app) {
	try {
		$userId = decodeUserToken($app->request())->uid;
		$result = \Service\DALSislab::getInstance()->getEmployees();
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
		$result = \Service\DALSislab::getInstance()->getReferences();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		//$result = ")]}',\n" . $result;
		print_r($result);
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/methods", function() use ($app) {
	try {
		$userId = decodeUserToken($app->request())->uid;
		$result = \Service\DALSislab::getInstance()->getMethods();
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
		$result = \Service\DALSislab::getInstance()->getPrices();
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
			$result = getUser($userId);
		}
		else
		{
			$result = getUsers();
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

function processUserJwt($request) {
	$input = json_decode($request->getbody());
	$usr = $input->username;
	$pwd = $input->password;

	$userData = getUserByCredentials($usr, $pwd);
	$userInfo = $userData[0];
	//comment json_decode for db use...
	//$userInfo = json_decode($userData);

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
	/// Token expires 10 hours from now
	$token["exp"] = time() + (10 * 60 * 60);
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

	if (is_numeric(getLastStudyByYear($currentYear)["oficio"])) {
		$lastStudyNumber = getLastStudyByYear($currentYear)["oficio"];
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
	$clientId = $studyInsertData["study"]["clientId"];
	$insertUserId = $studyInsertData["study"]["id_usuario_captura"];
	$insertDate = $studyInsertData["study"]["fecha_captura"];
	$insertIp = $studyInsertData["study"]["ip_captura"];
	$insertUrl = $studyInsertData["study"]["host_captura"];

	$blankPlan = getBlankPlan();
	unset($blankPlan["id_plan"]);
	$blankPlan["id_estudio"] = $studyId;
	$blankPlan["id_cliente"] = $clientId;
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
	$clientId = $studyUpdateData["study"]["id_cliente"];
	$updateUserId = $studyUpdateData["study"]["id_usuario_actualiza"];
	$updateDate = $studyUpdateData["study"]["fecha_actualiza"];
	$updateIp = $studyUpdateData["study"]["ip_actualiza"];
	$updateUrl = $studyUpdateData["study"]["host_actualiza"];

	$i = 0;
	$l = count($orders);
	for ($i = 0; $i < $l; $i++) {
		$order = (array) $orders[$i];

		if ($order["id_status"] == 2) {
			$order["id_status"] = 1;
			$order["ip_valida"] = "";
			$order["host_valida"] = "";
			$order["fecha_valida"] = "";
		}
		unset($order['$$hashKey']);

		$order["id_cliente"] = $clientId;
		$order["id_usuario_actualiza"] = $updateUserId;
		$order["fecha_actualiza"] = $updateDate;
		$order["ip_actualiza"] = $updateIp;
		$order["host_actualiza"] = $updateUrl;

		updateOrder($order);
	}
	return $clientId;
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
		// for ($i = 0; $i < $l; $i++) {
		// 	$storedPlans[$i]["activo"] = 0;
		// 	$storedPlans[$i]["id_usuario_actualiza"] = $orderData["id_usuario_actualiza"];
		// 	$storedPlans[$i]["fecha_actualiza"] = date('Y-m-d H:i:s');
		// 	$storedPlans[$i]["ip_actualiza"] = $orderData["ip_actualiza"];
		// 	$storedPlans[$i]["host_actualiza"] = $orderData["host_actualiza"];
		// 	//return json_encode($storedPlans[$i]);
		// 	//return "delete old";
		// 	updatePlan($storedPlans[$i]);
		// }
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

