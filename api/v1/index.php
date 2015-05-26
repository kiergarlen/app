<?php
require "../libs/Slim/Slim.php";
require "../libs/JWT/JWT.php";
require "./Services/DALSislab.php";
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
		$result = getMenu($userId);
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
		if ($studyId > -1)
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

$app->post("/studies(/)(:studyId)", function($studyId = -1) use ($app) {
	try {
		//$userId = decodeUserToken($app->request())->uid;
		$request = $app->request();
		if ($studyId > -1)
		{
			$result = updateStudy($request);
		}
		else
		{
			$result = insertStudy($request);
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

$app->get("/quotes(/)(:quoteId)", function($quoteId = -1) use ($app) {
	try {
		$userId = decodeUserToken($app->request())->uid;
		if ($quoteId > -1)
		{
			$result = \Service\DALSislab::getInstance()->getQuote($quoteId);
		}
		else
		{
			$result = \Service\DALSislab::getInstance()->getQuotes();
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

$app->post("/quotes", function() use ($app) {
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

$app->get("/orders(/)(:orderId)", function($orderId = -1) use ($app) {
	try {
		$userId = decodeUserToken($app->request())->uid;
		if ($orderId > -1)
		{
			$result = \Service\DALSislab::getInstance()->getOrder($orderId);
		}
		else
		{
			$result = \Service\DALSislab::getInstance()->getOrders();
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

$app->get("/plans(/)(:planId)", function($planId = -1) use ($app) {
	try {
		$userId = decodeUserToken($app->request())->uid;
		if ($planId > -1)
		{
			$result = \Service\DALSislab::getInstance()->getPlan($planId);
		}
		else
		{
			$result = \Service\DALSislab::getInstance()->getPlans();
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

$app->get("/order/sources", function() use ($app) {
	try {
		$userId = decodeUserToken($app->request())->uid;
		$result = \Service\DALSislab::getInstance()->getOrderSources();
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
		$userId = decodeUserToken($app->request())->uid;
		$result = \Service\DALSislab::getInstance()->getPointPackages();
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
		$result = \Service\DALSislab::getInstance()->getPlanObjectives();
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
			$result = \Service\DALSislab::getInstance()->getPoint($pointId);
		}
		else
		{
			$result = \Service\DALSislab::getInstance()->getPoints();
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
			$result = \Service\DALSislab::getInstance()->getUser($userId);
		}
		else
		{
			$result = \Service\DALSislab::getInstance()->getUsers();
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
//comment json_decode for db use...
function processUserJwt($request) {
	$input = json_decode($request->getbody());
	$usr = $input->username;
	$pwd = $input->password;

	$userData = getUserByCredentials($usr, $pwd);
	$userInfo = $userData[0];
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
	/// Token expires 3 hours from now
	$token["exp"] = time() + (3 * 60 * 60);
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

function formatIsoDateForSqlServer($dateString) {
	$format = 'Y-m-d H:i:s';
	if (strlen($dateString) > 18) {
		$dateString = substr($dateString, 0, 19);
		$dateString = str_replace("T", " ", $dateString);
		if (DateTime::createFromFormat($format, $dateString)){
			$date = DateTime::createFromFormat($format, $dateString);
			return $date->format($format);
		}
		return "1970-01-01 00:00";
	}
	return "1970-01-01 00:00";
}

function getConnection() {
	try {
		// $dsn = "mysql:host=";
		// $dsn .= DB_HOST . ";";
		// $dsn .= "port=" . DB_PORT . ";";
		// $dsn .= "dbname=" . DB_DATA_BASE;
		$dsn = "sqlsrv:server=";
		$dsn .= DB_HOST . ";Database=";
		$dsn .= DB_DATA_BASE;

		$dbConnection = new PDO($dsn, DB_USER, DB_PASSWORD);
		$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch(PDOException $e) {
		//error_log($e->getMessage(), 3, '/var/tmp/php.log');
		//echo '{"error":{"text":'. $e->getMessage() .'}}';
		$output = '{"error":"' . $e->getMessage() . '"}';
	}
	return $dbConnection;
}

function processResultToJson($items, $isArrayOutputExpected) {
	$output = "";
	if ($isArrayOutputExpected)
	{
		$output .= "[";
	}
	$i = 0;
	$l = count($items);
	foreach ($items as $item) {
		$i++;
		$j = 0;
		$item = (array)$item;
		$m = count($item);
		$output .= "{";
		foreach ($item as $key => $value) {
			$j++;
			$output .= '"' . $key . '":';
			$v = $value;
			if (!is_numeric($v) && strtotime($v))
			{
				$dateArray = explode(" ", $v);
				$v = $dateArray[0] . 'T'. substr($dateArray[1], 0, 5) . '-06:00';
			}
			$output .= '"' . $v .'"';
			if ($j < $m)
			{
				$output .= ",";
			}
		}
		$output .= "}";
		if ($isArrayOutputExpected && $i < $l)
		{
			$output .= ",";
		}
	}
	if ($isArrayOutputExpected)
	{
		$output .= "]";
	}
	return $output;
}

function processMenuToJson($items) {
	$output = '';
	$i = 0;
	$l = count($items);
	$currentItem = $items[$i];
	$output .= '[';
	$output .= '{';
	$output .= '"id_menu":' . $currentItem["id_menu"] . ',';
	$output .= '"orden":' . $currentItem["orden"] . ',';
	$output .= '"url":"/#",';
	$output .= '"menu":"' . $currentItem["menu"] . '",';
	$output .= '"submenu":[';
	$output .= '{';
	$output .= '"id_submenu":' . $currentItem["id_submenu"] . ',';
	$output .= '"id_menu":' . $currentItem["id_menu"] . ',';
	$output .= '"orden":' . $currentItem["orden_submenu"] . ',';
	$output .= '"url":"' . $currentItem["url"] . '",';
	$output .= '"menu":"' . $currentItem["submenu"] . '"';
	$output .= '}';
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
			$output .= ']';
			$output .= '},';
			$currentItem = $items[$i];
			$output .= '{';
			$output .= '"id_menu":' . $currentItem["id_menu"] . ',';
			$output .= '"orden":' . $currentItem["orden"] . ',';
			$output .= '"url":"/#",';
			$output .= '"menu":"' . $currentItem["menu"] . '",';
			$output .= '"submenu":[';
		}
		$output .= '{';
		$output .= '"id_submenu":' . $currentItem["id_submenu"] . ',';
		$output .= '"id_menu":' . $currentItem["id_menu"] . ',';
		$output .= '"orden":' . $currentItem["orden_submenu"] . ',';
		$output .= '"url":"' . $currentItem["url"] . '",';
		$output .= '"menu":"' . $currentItem["submenu"] . '"';
		$output .= '}';
	}
	$output .= ']';
	$output .= '}';
	$output .= ']';
	return $output;
}

function getUserByCredentials($userName, $userPassword) {
	$result = \Service\DALSislab::getInstance()->getUserByCredentials($userName, $userPassword);
	//$userName = "rgarcia";
	////$userPassword = "8493a161f70fffc0dcd4732ae4f6c4667f373688fff802ea13c71bd0fce41cb1";
	$sql = "SELECT id_usuario, id_nivel, id_rol, id_area, id_puesto,
		interno, cea, laboratorio, supervisa, analiza, muestrea,
		nombres, apellido_paterno, apellido_materno, usr, pwd,
		fecha_captura, fecha_actualiza, ip_captura, ip_actualiza,
		host_captura, host_actualiza, activo
		FROM Usuario
		WHERE activo = 1 AND pwd = :userPassword AND usr = :userName";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->bindParam("userName", $userName);
	$stmt->bindParam("userPassword", $userPassword);
	$stmt->execute();
	return $stmt->fetchAll(PDO::FETCH_OBJ);
}

function getUser($userId) {
	//$result = \Service\DALSislab::getInstance()->getUser($userId);
	$sql = "SELECT id_usuario, id_nivel, id_rol, id_area, id_puesto,
		interno, cea, laboratorio, supervisa, analiza, muestrea, nombres,
		apellido_paterno, apellido_materno, usr, pwd, fecha_captura,
		fecha_actualiza, ip_captura, ip_actualiza,
		host_captura, host_actualiza, activo
		FROM Usuario
		WHERE activo = 1 AND id_usuario = :userId";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->bindParam("userId", $userId);
	$stmt->execute();
	return $stmt->fetchAll(PDO::FETCH_OBJ);
}

function getUsers() {
	//$result = \Service\DALSislab::getInstance()->getUsers();
	$sql = "SELECT id_usuario, id_nivel, id_rol, id_area, id_puesto,
		interno, cea, laboratorio, supervisa, analiza, muestrea,
		nombres, apellido_paterno, apellido_materno, usr, pwd,
		fecha_captura, fecha_actualiza, ip_captura, ip_actualiza,
		host_captura, host_actualiza, activo
		FROM Usuario
		WHERE activo = 1";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->bindParam("userName", $userName);
	$stmt->bindParam("userPassword", $userPassword);
	$stmt->execute();
	return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getMenu($userId) {
	//$result = \Service\DALSislab::getInstance()->getMenu($userId);
	$sql = "SELECT
		Menu.id_menu, Submenu.id_submenu, Menu.orden,
		Submenu.orden AS orden_submenu, Menu.menu,
		Submenu.menu AS submenu,Submenu.url
		FROM Usuario INNER JOIN
		Rol ON Usuario.id_rol = Rol.id_rol INNER JOIN
		RolSubmenu ON Rol.id_rol = RolSubmenu.id_rol INNER JOIN
		Submenu ON RolSubmenu.id_submenu = Submenu.id_submenu INNER JOIN
		Menu ON Submenu.id_menu = Menu.id_menu
		WHERE Usuario.activo = 1 AND Usuario.id_usuario = :userId
		ORDER BY Menu.id_menu, Menu.orden, orden_submenu";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->bindParam("userId", $userId);
	$stmt->execute();
	return processMenuToJson($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function getTasks($userId) {
	$result = '[]';
	//$result = json_encode(\Service\DALSislab::getInstance()->getTasks($userId));
	// $sql = "SELECT * FROM Tarea WHERE activo = 1";
	// $db = getConnection();
	// $stmt = $db->prepare($sql);
	// $stmt->bindParam("userId", $userId);
	// $stmt->execute();
	// $result = json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
	return $result;
}

function getClient($clientId) {
	//$result = \Service\DALSislab::getInstance()->getClient($clientId);
	$sql = "SELECT id_cliente, id_estado, id_municipio,
		id_localidad, interno, cea, tasa, cliente, area,
		rfc, calle, numero, colonia, codigo_postal, telefono,
		fax, contacto, puesto_contacto, email, fecha_captura,
		fecha_actualiza, ip_captura, ip_actualiza, host_captura,
		host_actualiza, activo
		FROM Cliente
		WHERE activo = 1 AND id_cliente = :clientId";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->bindParam("clientId", $clientId);
	$stmt->execute();
	return $stmt->fetchAll(PDO::FETCH_OBJ);
}

function getClients() {
	//$result = \Service\DALSislab::getInstance()->getClient($clientId);
	$sql = "SELECT id_cliente, id_estado, id_municipio,
		id_localidad, interno, cea, tasa, cliente, area,
		rfc, calle, numero, colonia, codigo_postal, telefono,
		fax, contacto, puesto_contacto, email, fecha_captura,
		fecha_actualiza, ip_captura, ip_actualiza, host_captura,
		host_actualiza, activo
		FROM Cliente
		WHERE activo = 1";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->execute();
	return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getStudy($studyId) {
	if ($studyId < 1)
	{
		$result = array(
			"id_estudio" => 0, "id_cliente" => 0,
			"id_origen_orden" => 0, "id_ubicacion" => 1,
			"id_ejercicio" => 2015, "id_status" => 1,
			"id_etapa" => 1, "id_usuario_captura" => 0,
			"id_usuario_valida" => 0, "id_usuario_entrega" => 0,
			"id_usuario_actualiza" => 0, "oficio" => 0,
			"folio" => "", "origen_descripcion" => "",
			"ubicacion" => "", "fecha" => "",
			"fecha_entrega" => "", "fecha_captura" => "",
			"fecha_valida" => "", "fecha_rechaza" => "",
			"ip_captura" => "", "ip_valida" => "",
			"ip_actualiza" => "", "host_captura" => "",
			"host_valida" => "", "host_actualiza" => "",
			"motivo_rechaza" => "", "activo" => 1,
			"cliente" => array(
				"id_cliente" => 0, "id_estado" => 14,
				"id_municipio" => 14039, "id_localidad" => 140390001,
				"interno" => 0, "cea" => 0,
				"tasa" => 0, "cliente" => "",
				"area" => "", "rfc" => "",
				"calle" => "", "numero" => "",
				"colonia" => "", "codigo_postal" => "",
				"telefono" => "", "fax" => "",
				"contacto" => "", "puesto_contacto" => "",
				"email" => "", "fecha_captura" => "",
				"fecha_actualiza" => "", "ip_captura" => "",
				"ip_actualiza" => "", "host_captura" => "",
				"host_actualiza" => "", "activo" => 1
			),
			"ordenes" => array(
				array(
					"id_orden" => 0, "id_estudio" => 0,
					"id_cliente" => 0, "id_matriz" => 0,
					"id_tipo_muestreo" => 1, "id_norma" => 0,
					"id_cuerpo_receptor" => 5, "id_status" => 1,
					"id_usuario_captura" => 0, "id_usuario_valida" => 0,
					"id_usuario_actualiza" => 0, "cantidad_muestras" => 0,
					"costo_total" => 0, "cuerpo_receptor" => "",
					"tipo_cuerpo" => "", "fecha" => "",
					"fecha_entrega" => "", "fecha_captura" => "",
					"fecha_valida" => "", "fecha_actualiza" => "",
					"fecha_rechaza" => "", "ip_captura" => "",
					"ip_valida" => "", "ip_actualiza" => "",
					"host_captura" => "", "host_valida" => "",
					"host_actualiza" => "", "motivo_rechaza" => "",
					"comentarios" => "", "activo" => 1
				)
			)
		);
	}
	else
	{
		//$result = \Service\DALSislab::getInstance()->getStudy($studyId);
		$sql = "SELECT id_estudio, id_cliente, id_origen_orden,
			id_ubicacion, id_ejercicio, id_status, id_etapa,
			id_usuario_captura, id_usuario_valida, id_usuario_entrega,
			id_usuario_actualiza, oficio, folio, origen_descripcion,
			ubicacion, fecha, fecha_entrega, fecha_captura, fecha_valida,
			fecha_rechaza, ip_captura, ip_valida, ip_actualiza,
			host_captura, host_valida, host_actualiza, motivo_rechaza,
			activo
			FROM Estudio
			WHERE activo = 1 AND id_estudio = :studyId";
		$db = getConnection();
		$stmt = $db->prepare($sql);
		$stmt->bindParam("studyId", $studyId);
		$stmt->execute();
		$study = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$db = null;
		$clientId = $study[0]['id_cliente'];
		$study[0]["cliente"] = getClient($clientId);
		$study[0]["ordenes"] = getStudyOrders($studyId);
		$result = $study[0];
	}
	return $result;
}

function getStudies() {
	//$result = \Service\DALSislab::getInstance()->getStudies();
	$sql = "SELECT id_estudio, id_cliente, id_origen_orden,
		id_ubicacion, id_ejercicio, id_status, id_etapa,
		id_usuario_captura, id_usuario_valida, id_usuario_entrega,
		id_usuario_actualiza, oficio, folio, origen_descripcion,
		ubicacion, fecha, fecha_entrega, fecha_captura, fecha_valida,
		fecha_rechaza, ip_captura, ip_valida, ip_actualiza,
		host_captura, host_valida, host_actualiza, motivo_rechaza,
		activo
		FROM Estudio
		WHERE activo = 1";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->execute();
	$studies = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$i = 0;
	$l = count($studies);
	for ($i = 0; $i < $l; $i++) {
		$studies[$i]["cliente"] = getClient($studies[$i]['id_cliente'])[0];
		$studies[$i]["ordenes"] = getStudyOrders($studies[$i]['id_estudio']);
	}
	return $studies;
}

function getStudyOrders($studyId) {
	$sql = "SELECT id_orden, id_estudio, id_cliente, id_matriz,
		id_tipo_muestreo, id_norma, id_cuerpo_receptor, id_status,
		id_usuario_captura, id_usuario_valida, id_usuario_actualiza,
		cantidad_muestras, costo_total, cuerpo_receptor, tipo_cuerpo,
		fecha, fecha_entrega, fecha_captura, fecha_valida,
		fecha_actualiza, fecha_rechaza, ip_captura, ip_valida,
		ip_actualiza, host_captura, host_valida, host_actualiza,
		motivo_rechaza, comentarios, activo
		FROM Orden
		WHERE activo = 1 AND id_estudio = :studyId";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->bindParam("studyId", $studyId);
	$stmt->execute();
	return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getLastStudyByYear($yearId) {
	$sql = "SELECT TOP (1) id_estudio, id_cliente, id_origen_orden,
		id_ubicacion, id_ejercicio, id_status, id_etapa,
		id_usuario_captura, id_usuario_valida, id_usuario_entrega,
		id_usuario_actualiza, oficio, folio, origen_descripcion,
		ubicacion, fecha, fecha_entrega, fecha_captura, fecha_valida,
		fecha_rechaza, ip_captura, ip_valida, ip_actualiza,
		host_captura, host_valida, host_actualiza, motivo_rechaza,
		activo
		FROM Estudio
		WHERE id_ejercicio = :yearId";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->bindParam("yearId", $yearId);
	$stmt->execute();
	$study = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$db = null;
	$result = $study[0];
	return $result;
}

function insertStudy($request) {
	$token = decodeUserToken($request);
	$insertData = (array) json_decode($request->getBody());
	$lastStudyId = 0;
	$currentYear = date("Y");
	$clientId = $insertData["id_cliente"];
	$orders = $insertData["ordenes"];

	unset($insertData["id_estudio"]);
	unset($insertData["cliente"]);
	unset($insertData["ordenes"]);
	if (is_numeric(getLastStudyByYear($currentYear)["oficio"])) {
		$lastStudyId = getLastStudyByYear($currentYear)["oficio"];
	}
	$lastStudyId++;
	$folio = "CEA-" . str_pad($lastStudyId, 3, "0", STR_PAD_LEFT);
	$folio .= "-" . $currentYear;

	$insertData["id_usuario_captura"] = $token->uid;
	$insertData["ip_captura"] = $request->getIp();
	$insertData["host_captura"] = $request->getUrl();
	$insertData["id_status"]  = 1;
	$insertData["id_etapa"]  = 1;
	$insertData["oficio"] = $lastStudyId;
	$insertData["folio"] = $folio;
	$insertData["fecha"] = formatIsoDateForSqlServer($insertData["fecha"]);
	$insertData["fecha_captura"] = date('Y-m-d H:i:s');

	$sql = "INSERT INTO Estudio (id_cliente, id_origen_orden, id_ubicacion,
		id_ejercicio, id_status, id_etapa, id_usuario_captura,
		id_usuario_valida, id_usuario_entrega,
		id_usuario_actualiza, oficio, folio, origen_descripcion,
		ubicacion, fecha, fecha_entrega, fecha_captura,
		fecha_valida, fecha_rechaza, ip_captura, ip_valida,
		ip_actualiza, host_captura, host_valida, host_actualiza,
		motivo_rechaza, activo)
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

	$i = 0;
	$l = count($orders);
	for ($i = 0; $i < $l; $i++) {
		insertStudyOrder($orders[$i], $studyId, $clientId);
	}
	return $studyId;
}

function insertStudyOrder($order, $studyId, $clientId) {
	$order = (array) $order;
	unset($order['$$hashKey']);
	unset($order["id_orden"]);
	$order["id_estudio"] = $studyId;
	$order["id_cliente"] = $clientId;
	$order["id_cuerpo_receptor"] = 5;
	$order["id_status"] = 1;
	$order["costo_total"] = 0;

	$sql = "INSERT INTO Orden (id_estudio, id_cliente, id_matriz,
		id_tipo_muestreo, id_norma, id_cuerpo_receptor, id_status,
		id_usuario_captura, id_usuario_valida, id_usuario_actualiza,
		cantidad_muestras, costo_total, cuerpo_receptor,
		tipo_cuerpo, fecha, fecha_entrega, fecha_captura,
		fecha_valida, fecha_actualiza, fecha_rechaza,
		ip_captura, ip_valida, ip_actualiza, host_captura,
		host_valida, host_actualiza, motivo_rechaza,
		comentarios, activo)
		VALUES (:id_estudio, :id_cliente, :id_matriz,
		:id_tipo_muestreo, :id_norma, :id_cuerpo_receptor, :id_status,
		:id_usuario_captura, :id_usuario_valida, :id_usuario_actualiza,
		:cantidad_muestras, :costo_total, :cuerpo_receptor,
		:tipo_cuerpo, :fecha, :fecha_entrega, :fecha_captura,
		:fecha_valida, :fecha_actualiza, :fecha_rechaza,
		:ip_captura, :ip_valida, :ip_actualiza, :host_captura,
		:host_valida, :host_actualiza, :motivo_rechaza,
		:comentarios, :activo)";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->execute($order);
	$orderId = $db->lastInsertId();
	$db = null;
	return $orderId;
}

function updateStudy($data) {
	return $data;
}

// function insertUser($requestData) {
// 	try {
// 		//$requestData = json_decode($payload);
// 		$insertDataArray = array (
// 			"id_nivel" => $requestData->id_nivel,
// 			"id_rol" => $requestData->id_rol,
// 			"id_area" => $requestData->id_area,
// 			"id_puesto" => $requestData->id_puesto,
// 			"interno" => $requestData->interno,
// 			"cea" => $requestData->cea,
// 			"laboratorio" => $requestData->laboratorio,
// 			"supervisa" => $requestData->supervisa,
// 			"analiza" => $requestData->analiza,
// 			"muestrea" => $requestData->muestrea,
// 			"nombres" => utf8_decode($requestData->nombres),
// 			"apellido_paterno" => utf8_decode($requestData->apellido_paterno),
// 			"apellido_materno" => utf8_decode($requestData->apellido_materno),
// 			"usr" => $requestData->usr,
// 			"pwd" => $requestData->pwd,
// 			"fecha_captura" => $requestData->fecha_captura,
// 			"fecha_actualiza" => $requestData->fecha_actualiza,
// 			"ip_captura" => $requestData->ip_captura,
// 			"ip_actualiza" => $requestData->ip_actualiza,
// 			"host_captura" => $requestData->host_captura,
// 			"host_actualiza" => $requestData->host_actualiza,
// 			"activo" => $requestData->activo
// 		);
// 		$sql = "INSERT INTO Usuario
// 			( id_nivel, id_rol, id_area, id_puesto, interno, cea,
// 			 laboratorio, supervisa, analiza, muestrea, nombres,
// 			 apellido_paterno,
// 			 apellido_materno, usr, pwd, fecha_captura, fecha_actualiza,
// 			 ip_captura, ip_actualiza, host_captura, host_actualiza, activo)
// 			VALUES ( :id_nivel, :id_rol, :id_area, :id_puesto, :interno,
// 				:cea, :laboratorio, :supervisa, :analiza, :muestrea, :nombres,
// 				:apellido_paterno, :apellido_materno, :usr, :pwd, :fecha_captura,
// 				:fecha_actualiza, :ip_captura, :ip_actualiza, :host_captura,
// 				:host_actualiza, :activo
// 			)";
// 		$db = getConnection();
// 		$stmt = $db->prepare($sql);
// 		$stmt->execute($userData);
// 		$userId = $db->lastInsertId();
// 		$db = null;
// 		return getUser($userId);
// 	} catch(PDOException $e) {
// 		//print_r($e->getMessage());
// 		return 0;
// 	}
// }

// function getUser($userId) {
// 	try {
// 		$sql = "SELECT id_usuario, id_nivel, id_rol, id_area, id_puesto,
// 			interno, cea, laboratorio, supervisa, analiza, muestrea, nombres,
// 			apellido_paterno, apellido_materno, usr, pwd, fecha_captura,
// 			fecha_actualiza, ip_captura, ip_actualiza,
// 			host_captura, host_actualiza, activo
// 			FROM Usuario
// 			WHERE id_usuario=:userId
// 		";
// 		$db = getConnection();
// 		$stmt = $db->prepare($sql);
// 		$stmt->bindParam("userId", $userId);
// 		$stmt->execute();
// 		$user = $stmt->fetch(PDO::FETCH_OBJ);
// 		$db = null;
// 		return $user;
// 	} catch(PDOException $e) {
// 		echo '{"error":{"text":'. $e->getMessage() .'}}';
// 	}
// }

