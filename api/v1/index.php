<?php
require "../libs/Slim/Slim.php";
require "../libs/JWT/JWT.php";
require "./Services/DALSislab.php";
// cd372fb85148700fa88095e3492d3f9f5beb43e555e5ff26d95f5a6adc36f8e6
define("KEY", "m0oxUT7L8Unn93hXMUGHpwq_jTSKVBjQfEVCUe8jZ38KUU4VSAfmsNk4JJYcJl7CukrY6QMlixxwat7AZSpDcSQ");

// define("DB_DRIVER", "sqlsrv");
// define("DB_HOST", "localhost");
// define("DB_PORT", "");
// define("DB_USER", "sislab");
// define("DB_PASSWORD", "sislab");
// define("DB_DATA_BASE", "Sislab");

define("DB_DRIVER", "mysql");
define("DB_HOST", "localhost");
define("DB_PORT", "8889");
define("DB_USER", "root");
define("DB_PASSWORD", "root");
define("DB_DATA_BASE", "sislab");

\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();

$app->post("/login", function() use ($app) {
	try {
		$jwt = processUserJwt($app);
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
		$userId = validateTokenUser($app);
		$result = getMenu($userId);
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		//$result = ")]}',\n" . $result;
		echo $result;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/tasks", function() use ($app) {
	try {
		//$userId = validateTokenUser($app);
		$userId = 1;
		$result = getTasks($userId);
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		//$result = ")]}',\n" . $result;
		echo $result;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/studies(/)(:studyId)", function($studyId = -1) use ($app) {
	try {
		$userId = validateTokenUser($app);
		if ($studyId > -1)
		{
			$result = getStudy($studyId);
		}
		else
		{
			$result = getStudies();
		}
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		//$result = ")]}',\n" . $result;
		echo $result;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->post("/studies", function() use ($app) {
	try {
		$userId = validateTokenUser($app);
		$request = $app->request();
		$requestBody = $request->getBody();
		$requestData = extractDataFromRequest($app);
		$result = insertStudy($requestData);
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		//$result = ")]}',\n" . $result;
		echo $result;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/quotes(/)(:quoteId)", function($quoteId = -1) use ($app) {
	try {
		$userId = validateTokenUser($app);
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
		echo $result;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->post("/quotes", function() use ($app) {
	try {
		$request = $app->request();
		$requestBody = $request->getBody();

		$requestData = extractDataFromRequest($app);
		$result = json_encode($requestData);

		$userId = validateTokenUser($app);
		//$result = insertStudy();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		//$result = ")]}',\n" . $result;
		echo $result;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/orders(/)(:orderId)", function($orderId = -1) use ($app) {
	try {
		$userId = validateTokenUser($app);
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
		echo $result;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->post("/orders", function() use ($app) {
	try {
		$request = $app->request();
		$requestBody = $request->getBody();

		$requestData = extractDataFromRequest($app);
		$result = json_encode($requestData);

		$userId = validateTokenUser($app);
		//$result = insertStudy();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		//$result = ")]}',\n" . $result;
		echo $result;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/plans(/)(:planId)", function($planId = -1) use ($app) {
	try {
		$userId = validateTokenUser($app);
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
		echo $result;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->post("/plans", function() use ($app) {
	try {
		$request = $app->request();
		$requestBody = $request->getBody();

		$requestData = extractDataFromRequest($app);
		$result = json_encode($requestData);

		$userId = validateTokenUser($app);
		//$result = insertStudy();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		//$result = ")]}',\n" . $result;
		echo $result;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/sheets(/)(:sheetId)", function($sheetId = -1) use ($app) {
	try {
		//$userId = validateTokenUser($app);
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
		echo $result;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->post("/sheets", function() use ($app) {
	try {
		$request = $app->request();
		$requestBody = $request->getBody();

		$requestData = extractDataFromRequest($app);
		$result = json_encode($requestData);

		$userId = validateTokenUser($app);
		//$result = insertStudy();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		//$result = ")]}',\n" . $result;
		echo $result;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/receptions(/)(:receptionId)", function($receptionId = -1) use ($app) {
	try {
		$userId = validateTokenUser($app);
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
		echo $result;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->post("/receptions", function() use ($app) {
	try {
		$request = $app->request();
		$requestBody = $request->getBody();

		$requestData = extractDataFromRequest($app);
		$result = json_encode($requestData);

		$userId = validateTokenUser($app);
		//$result = insertStudy();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		//$result = ")]}',\n" . $result;
		echo $result;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/custodies(/)(:custodyId)", function($custodyId = -1) use ($app) {
	try {
		$userId = validateTokenUser($app);
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
		echo $result;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->post("/custodies", function() use ($app) {
	try {
		$request = $app->request();
		$requestBody = $request->getBody();

		$requestData = extractDataFromRequest($app);
		$result = json_encode($requestData);

		$userId = validateTokenUser($app);
		//$result = insertStudy();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		//$result = ")]}',\n" . $result;
		echo $result;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});
//CATALOGS
$app->get("/clients(/)(:clientId)", function($clientId = -1) use ($app) {
	try {
		$userId = validateTokenUser($app);
		if ($clientId > -1)
		{
			$result = getClient($userId);
		}
		else
		{
			$result = getClients();
		}
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		//$result = ")]}',\n" . $result;
		echo $result;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/parameters", function() use ($app) {
	try {
		$userId = validateTokenUser($app);
		$result = \Service\DALSislab::getInstance()->getParameters();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		//$result = ")]}',\n" . $result;
		echo $result;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/norms", function() use ($app) {
	try {
		$userId = validateTokenUser($app);
		$result = \Service\DALSislab::getInstance()->getNorms();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		//$result = ")]}',\n" . $result;
		echo $result;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/sampling/types", function() use ($app) {
	try {
		$userId = validateTokenUser($app);
		$result = \Service\DALSislab::getInstance()->getSamplingTypes();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		//$result = ")]}',\n" . $result;
		echo $result;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/order/sources", function() use ($app) {
	try {
		$userId = validateTokenUser($app);
		$result = \Service\DALSislab::getInstance()->getOrderSources();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		//$result = ")]}',\n" . $result;
		echo $result;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/matrices", function() use ($app) {
	try {
		$userId = validateTokenUser($app);
		$result = \Service\DALSislab::getInstance()->getMatrices();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		//$result = ")]}',\n" . $result;
		echo $result;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/points/packages", function() use ($app) {
	try {
		$userId = validateTokenUser($app);
		$result = \Service\DALSislab::getInstance()->getPointPackages();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		//$result = ")]}',\n" . $result;
		echo $result;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/sampling/supervisors", function() use ($app) {
	try {
		$userId = validateTokenUser($app);
		$result = \Service\DALSislab::getInstance()->getSamplingSupervisors();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		echo $result;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/sampling/employees", function() use ($app) {
	try {
		//$userId = validateTokenUser($app);
		$result = \Service\DALSislab::getInstance()->getSamplingEmployees();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		//$result = ")]}',\n" . $result;
		echo $result;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/plan/objectives", function() use ($app) {
	try {
		$userId = validateTokenUser($app);
		$result = \Service\DALSislab::getInstance()->getPlanObjectives();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		//$result = ")]}',\n" . $result;
		echo $result;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/point/kinds", function() use ($app) {
	try {
		$userId = validateTokenUser($app);
		$result = \Service\DALSislab::getInstance()->getPointKinds();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		//$result = ")]}',\n" . $result;
		echo $result;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/districts/:districtId", function($districtId) use ($app) {
	try {
		$userId = validateTokenUser($app);
		$result = \Service\DALSislab::getInstance()->getDistrict($districtId);
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		//$result = ")]}',\n" . $result;
		echo $result;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/districts", function() use ($app) {
	try {
		$userId = validateTokenUser($app);
		$result = \Service\DALSislab::getInstance()->getDistricts();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		//$result = ")]}',\n" . $result;
		echo $result;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/districts/cities/:districtId", function($districtId) use ($app) {
	try {
		$userId = validateTokenUser($app);
		$result = \Service\DALSislab::getInstance()->getCitiesByDistrictId($districtId);
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		//$result = ")]}',\n" . $result;
		echo $result;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/districts", function() use ($app) {
	try {
		$userId = validateTokenUser($app);
		$result = \Service\DALSislab::getInstance()->getDistricts();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		//$result = ")]}',\n" . $result;
		echo $result;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/preservations", function() use ($app) {
	try {
		$userId = validateTokenUser($app);
		$result = \Service\DALSislab::getInstance()->getPreservations();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		//$result = ")]}',\n" . $result;
		echo $result;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/containers/kinds", function() use ($app) {
	try {
		$userId = validateTokenUser($app);
		$result = \Service\DALSislab::getInstance()->getContainerKinds();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		//$result = ")]}',\n" . $result;
		echo $result;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/reactives", function() use ($app) {
	try {
		$userId = validateTokenUser($app);
		$result = \Service\DALSislab::getInstance()->getReactives();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		//$result = ")]}',\n" . $result;
		echo $result;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/materials", function() use ($app) {
	try {
		$userId = validateTokenUser($app);
		$result = \Service\DALSislab::getInstance()->getMaterials();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		//$result = ")]}',\n" . $result;
		echo $result;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/instruments/sampling", function() use ($app) {
	try {
		$userId = validateTokenUser($app);
		$result = \Service\DALSislab::getInstance()->getSamplingInstruments();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		//$result = ")]}',\n" . $result;
		echo $result;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/coolers", function() use ($app) {
	try {
		$userId = validateTokenUser($app);
		$result = \Service\DALSislab::getInstance()->getCoolers();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		//$result = ")]}',\n" . $result;
		echo $result;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/clouds", function() use ($app) {
	try {
		$userId = validateTokenUser($app);
		$result = \Service\DALSislab::getInstance()->getClouds();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		//$result = ")]}',\n" . $result;
		echo $result;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/winds", function() use ($app) {
	try {
		$userId = validateTokenUser($app);
		$result = \Service\DALSislab::getInstance()->getCurrentDirections();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		//$result = ")]}',\n" . $result;
		echo $result;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/waves", function() use ($app) {
	try {
		$userId = validateTokenUser($app);
		$result = \Service\DALSislab::getInstance()->getWaves();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		//$result = ")]}',\n" . $result;
		echo $result;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/sampling/norms", function() use ($app) {
	try {
		$userId = validateTokenUser($app);
		$result = \Service\DALSislab::getInstance()->getSamplingNorms();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		//$result = ")]}',\n" . $result;
		echo $result;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/points(/)(:pointid)", function($pointId = -1) use ($app) {
	try {
		$userId = validateTokenUser($app);
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
		echo $result;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/parameters/field", function() use ($app) {
	try {
		$userId = validateTokenUser($app);
		$result = \Service\DALSislab::getInstance()->getParametersField();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		//$result = ")]}',\n" . $result;
		echo $result;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/receptionists", function() use ($app) {
	try {
		$userId = validateTokenUser($app);
		$result = \Service\DALSislab::getInstance()->getReceptionists();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		//$result = ")]}',\n" . $result;
		echo $result;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/expirations", function() use ($app) {
	try {
		$userId = validateTokenUser($app);
		$result = \Service\DALSislab::getInstance()->getExpirations();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		//$result = ")]}',\n" . $result;
		echo $result;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/volumes", function() use ($app) {
	try {
		$userId = validateTokenUser($app);
		$result = \Service\DALSislab::getInstance()->getVolumes();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		//$result = ")]}',\n" . $result;
		echo $result;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/checkers", function() use ($app) {
	try {
		$userId = validateTokenUser($app);
		$result = \Service\DALSislab::getInstance()->getCheckers();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		//$result = ")]}',\n" . $result;
		echo $result;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/samples", function() use ($app) {
	try {
		$userId = validateTokenUser($app);
		$result = \Service\DALSislab::getInstance()->getSamples();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		//$result = ")]}',\n" . $result;
		echo $result;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/instruments", function() use ($app) {
	try {
		$userId = validateTokenUser($app);
		$result = \Service\DALSislab::getInstance()->getInstruments();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		//$result = ")]}',\n" . $result;
		echo $result;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/containers", function() use ($app) {
	try {
		$userId = validateTokenUser($app);
		$result = \Service\DALSislab::getInstance()->getContainers();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		//$result = ")]}',\n" . $result;
		echo $result;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/analysis", function() use ($app) {
	try {
		$userId = validateTokenUser($app);
		$result = \Service\DALSislab::getInstance()->getAnalysis();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		//$result = ")]}',\n" . $result;
		echo $result;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/areas", function() use ($app) {
	try {
		$userId = validateTokenUser($app);
		$result = \Service\DALSislab::getInstance()->getAreas();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		//$result = ")]}',\n" . $result;
		echo $result;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/analysis/selections", function() use ($app) {
	try {
		$userId = validateTokenUser($app);
		$result = \Service\DALSislab::getInstance()->getAnalysisSelections();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		//$result = ")]}',\n" . $result;
		echo $result;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/reports", function() use ($app) {
	try {
		$userId = validateTokenUser($app);
		$result = \Service\DALSislab::getInstance()->getReports();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		//$result = ")]}',\n" . $result;
		echo $result;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});
/*
$app->get("/reports/:reportId", function($reportId) use ($app) {
	try {
		$userId = validateTokenUser($app);
		$result = \Service\DALSislab::getInstance()->getReport($reportId);
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		//$result = ")]}',\n" . $result;
		echo $result;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/reports/:reportId", function() use ($app) {
	try {
		$userId = validateTokenUser($app);
		$result = \Service\DALSislab::getInstance()->getReports();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		//$result = ")]}',\n" . $result;
		echo $result;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});
*/
$app->get("/employees", function() use ($app) {
	try {
		$userId = validateTokenUser($app);
		$result = \Service\DALSislab::getInstance()->getEmployees();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		//$result = ")]}',\n" . $result;
		echo $result;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/references", function() use ($app) {
	try {
		$userId = validateTokenUser($app);
		$result = \Service\DALSislab::getInstance()->getReferences();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		//$result = ")]}',\n" . $result;
		echo $result;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/methods", function() use ($app) {
	try {
		$userId = validateTokenUser($app);
		$result = \Service\DALSislab::getInstance()->getMethods();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		//$result = ")]}',\n" . $result;
		echo $result;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/prices", function() use ($app) {
	try {
		$userId = validateTokenUser($app);
		$result = \Service\DALSislab::getInstance()->getPrices();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		//$result = ")]}',\n" . $result;
		echo $result;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/users(/)(:userId)", function($userId = -1) use ($app) {
	try {
		$userId = validateTokenUser($app);
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
		echo $result;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->run();

function processUserJwt($app) {
	$request = $app->request();
	$input = json_decode($request->getbody());
	$usr = $input->username;
	$pwd = $input->password;

	$userData = getUserByCredentials($usr, $pwd);
	$userInfo = $userData[0];
	//$userInfo = json_decode($userData);

	$userId = $userInfo->id_usuario;
	$userLv = $userInfo->id_nivel;
	$userRole = $userInfo->id_rol;
	$name = utf8_encode($userInfo->nombres) . " ";
	$name .= utf8_encode($userInfo->apellido_paterno) . " ";
	$name .= utf8_encode($userInfo->apellido_materno) . "";
	// $name = $userInfo->nombres . " ";
	// $name .= $userInfo->apellido_paterno . " ";
	// $name .= $userInfo->apellido_materno . "";

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
	$decoded = JWT::decode($jwt, KEY);
	$decoded_array = (array) $decoded;
	//print_r($decoded_array);
	return $decoded_array;
}

function extractDataFromRequest($app) {
	$request = $app->request();
	$requestBody = $request->getBody();
	return json_decode($requestBody);
}

function validateTokenUser($app) {
	$request = $app->request();
	$headers = $request->headers();

	$jwt = $headers["Auth-Token"];
	try {
		$decoded = JWT::decode($jwt, KEY);
		return $decoded->uid;
	} catch (Exception $e) {
		$app->response()->status(401);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
}

function getConnection() {
	try {
		$dsn = "mysql:host=";
		$dsn .= DB_HOST . ";";
		if (strlen(DB_PORT) > 0)
		{
			$dsn .= "port=" . DB_PORT . ";";
		}
		$dsn .= "dbname=" . DB_DATA_BASE;

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
			if (!is_numeric($v))
			{
				if (strtotime($v)) {
					$dateArray = explode(" ", $v);
					$v = $dateArray[0] . 'T'. substr($dateArray[1], 0, 5) . '-06:00';
				}
				//else
				//{
				//	$v = utf8_encode($v);
				//}
				$v = '"' . $v .'"';
			}
			$output .= $v;
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
	$output .= '"url":"' . $currentItem["url"] . '",';
	$output .= '"menu":"' . $currentItem["menu"] . '",';
	$output .= '"submenu":[';
	$output .= '{';
	$output .= '"id_submenu":' . $currentItem["id_submenu"] . ',';
	$output .= '"id_menu":' . $currentItem["id_menu"] . ',';
	$output .= '"orden":' . $currentItem["orden_submenu"] . ',';
	$output .= '"url":"' . $currentItem["url_submenu"] . '",';
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
			$output .= '"url":"' . $currentItem["url"] . '",';
			$output .= '"menu":"' . $currentItem["menu"] . '",';
			$output .= '"submenu":[';
		}
		$output .= '{';
		$output .= '"id_submenu":' . $currentItem["id_submenu"] . ',';
		$output .= '"id_menu":' . $currentItem["id_menu"] . ',';
		$output .= '"orden":' . $currentItem["orden_submenu"] . ',';
		$output .= '"url":"' . $currentItem["url_submenu"] . '",';
		$output .= '"menu":"' . $currentItem["submenu"] . '"';
		$output .= '}';
	}
	$output .= ']';
	$output .= '}';
	$output .= ']';
	return $output;
}

function getUserByCredentials($userName, $userPassword) {
	//$result = \Service\DALSislab::getInstance()->getUserByCredentials($userName, $userPassword);
	////$userName = "rgarcia";
	////$userPassword = "8493a161f70fffc0dcd4732ae4f6c4667f373688fff802ea13c71bd0fce41cb1";
	$sql = "SELECT id_usuario, id_nivel, id_rol, id_area, id_puesto, interno, cea, laboratorio, supervisa, analiza, muestrea, nombres, apellido_paterno, apellido_materno, usr, pwd, fecha_captura, fecha_actualiza, ip_captura, ip_actualiza, host_captura, host_actualiza, activo FROM Usuario WHERE usr = :userName AND pwd = :userPassword AND activo = 1";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->bindParam("userName", $userName);
	$stmt->bindParam("userPassword", $userPassword);
	$stmt->execute();
	$result = $stmt->fetchAll(PDO::FETCH_OBJ);
	return $result;
}

function getUser($userId) {
	$result = \Service\DALSislab::getInstance()->getUser($userId);
	$sql = "SELECT id_usuario, id_nivel, id_rol, id_area, id_puesto, interno, cea, laboratorio, supervisa, analiza, muestrea, nombres, apellido_paterno, apellido_materno, usr, pwd, fecha_captura, fecha_actualiza, ip_captura, ip_actualiza, host_captura, host_actualiza, activo FROM Usuario WHERE id_usuario = :userId AND activo = 1";
	// $db = getConnection();
	// $stmt = $db->prepare($sql);
	// $stmt->bindParam("userId", $userId);
	// $stmt->execute();
	// $result = $stmt->fetchAll(PDO::FETCH_OBJ);
	return $result;
}

function getUsers() {
	$result = \Service\DALSislab::getInstance()->getUsers();
	// $sql = "SELECT id_usuario, id_nivel, id_rol, id_area, id_puesto, interno, cea, laboratorio, supervisa, analiza, muestrea, nombres, apellido_paterno, apellido_materno, usr, pwd, fecha_captura, fecha_actualiza, ip_captura, ip_actualiza, host_captura, host_actualiza, activo FROM Usuario WHERE activo = 1";
	// $db = getConnection();
	// $stmt = $db->prepare($sql);
	// $stmt->bindParam("userName", $userName);
	// $stmt->bindParam("userPassword", $userPassword);
	// $stmt->execute();
	// $result = processResultToJson($stmt->fetchAll(PDO::FETCH_ASSOC), false);
	return $result;
}

function getMenu($userId) {
	$result = \Service\DALSislab::getInstance()->getMenu($userId);
	// $sql = "SELECT
	// 	dbo.Menu.id_menu, dbo.Submenu.id_submenu, dbo.Menu.orden,
	// 	dbo.Submenu.orden AS orden_submenu, dbo.Menu.menu,
	// 	dbo.Submenu.menu AS submenu,dbo.Submenu.url
	// 	FROM
	// 	dbo.Usuario INNER JOIN
	// 	dbo.Rol ON dbo.Usuario.id_rol = dbo.Rol.id_rol INNER JOIN
	// 	dbo.RolSubmenu ON dbo.Rol.id_rol = dbo.RolSubmenu.id_rol INNER JOIN
	// 	dbo.Submenu ON dbo.RolSubmenu.id_submenu = dbo.Submenu.id_submenu INNER JOIN
	// 	dbo.Menu ON dbo.Submenu.id_menu = dbo.Menu.id_menu
	// 	WHERE (dbo.Usuario.id_usuario = :userId) AND (dbo.Usuario.activo = 1)
	// 	ORDER BY dbo.Menu.id_menu, dbo.Menu.orden, orden_submenu";
	// $db = getConnection();
	// $stmt = $db->prepare($sql);
	// $stmt->bindParam("userId", $userId);
	// $stmt->execute();
	// $result = processResultToJson($stmt->fetchAll(PDO::FETCH_ASSOC), false);
	return $result;
}

function getTasks($userId) {
	$result = \Service\DALSislab::getInstance()->getTasks($userId);
	// $sql = "SELECT id_usuario, id_nivel, id_rol, id_area, id_puesto, interno, cea, laboratorio, supervisa, analiza, muestrea, nombres, apellido_paterno, apellido_materno, usr, pwd, fecha_captura, fecha_actualiza, ip_captura, ip_actualiza, host_captura, host_actualiza, activo FROM Usuario WHERE activo = 1";
	// $db = getConnection();
	// $stmt = $db->prepare($sql);
	// $stmt->bindParam("userId", $userId);
	// $stmt->execute();
	// $result = processResultToJson($stmt->fetchAll(PDO::FETCH_ASSOC), false);
	return $result;
}

function getClient($clientId) {
	$result = \Service\DALSislab::getInstance()->getClient($clientId);
	$sql = "SELECT id_usuario, id_nivel, id_rol, id_area, id_puesto, interno, cea, laboratorio, supervisa, analiza, muestrea, nombres, apellido_paterno, apellido_materno, usr, pwd, fecha_captura, fecha_actualiza, ip_captura, ip_actualiza, host_captura, host_actualiza, activo FROM Usuario WHERE id_usuario = :clientId AND activo = 1";
	// $sql = "SELECT
	// 	dbo.Menu.id_menu, dbo.Submenu.id_submenu, dbo.Menu.orden,
	// 	dbo.Submenu.orden AS orden_submenu, dbo.Menu.menu,
	// 	dbo.Submenu.menu AS submenu,dbo.Submenu.url
	// 	FROM
	// 	dbo.Usuario INNER JOIN
	// 	dbo.Rol ON dbo.Usuario.id_rol = dbo.Rol.id_rol INNER JOIN
	// 	dbo.RolSubmenu ON dbo.Rol.id_rol = dbo.RolSubmenu.id_rol INNER JOIN
	// 	dbo.Submenu ON dbo.RolSubmenu.id_submenu = dbo.Submenu.id_submenu INNER JOIN
	// 	dbo.Menu ON dbo.Submenu.id_menu = dbo.Menu.id_menu
	// 	WHERE (dbo.Usuario.id_usuario = :clientId) AND (dbo.Usuario.activo = 1)
	// 	ORDER BY dbo.Menu.id_menu, dbo.Menu.orden, orden_submenu";
	// $db = getConnection();
	// $stmt = $db->prepare($sql);
	// $stmt->bindParam("clientId", $clientId);
	// $stmt->execute();
	// $result = $stmt->fetchAll(PDO::FETCH_OBJ);
	return $result;
}

function getClients() {
	$result = \Service\DALSislab::getInstance()->getClients();
	// $sql = "SELECT
	// 	dbo.Menu.id_menu, dbo.Submenu.id_submenu, dbo.Menu.orden,
	// 	dbo.Submenu.orden AS orden_submenu, dbo.Menu.menu,
	// 	dbo.Submenu.menu AS submenu,dbo.Submenu.url
	// 	FROM
	// 	dbo.Usuario INNER JOIN
	// 	dbo.Rol ON dbo.Usuario.id_rol = dbo.Rol.id_rol INNER JOIN
	// 	dbo.RolSubmenu ON dbo.Rol.id_rol = dbo.RolSubmenu.id_rol INNER JOIN
	// 	dbo.Submenu ON dbo.RolSubmenu.id_submenu = dbo.Submenu.id_submenu INNER JOIN
	// 	dbo.Menu ON dbo.Submenu.id_menu = dbo.Menu.id_menu
	// 	WHERE (dbo.Usuario.id_usuario = :userId) AND (dbo.Usuario.activo = 1)
	// 	ORDER BY dbo.Menu.id_menu, dbo.Menu.orden, orden_submenu";
	// $db = getConnection();
	// $stmt = $db->prepare($sql);
	// $stmt->bindParam("userId", $userId);
	// $stmt->execute();
	// $result = processResultToJson($stmt->fetchAll(PDO::FETCH_ASSOC), false);
	return $result;
}

function getStudy($studyId) {
	$result = \Service\DALSislab::getInstance()->getStudy($studyId);
	$sql = "SELECT id_usuario, id_nivel, id_rol, id_area, id_puesto, interno, cea, laboratorio, supervisa, analiza, muestrea, nombres, apellido_paterno, apellido_materno, usr, pwd, fecha_captura, fecha_actualiza, ip_captura, ip_actualiza, host_captura, host_actualiza, activo FROM Usuario WHERE id_usuario = :studyId AND activo = 1";
	// $sql = "SELECT
	// 	dbo.Menu.id_menu, dbo.Submenu.id_submenu, dbo.Menu.orden,
	// 	dbo.Submenu.orden AS orden_submenu, dbo.Menu.menu,
	// 	dbo.Submenu.menu AS submenu,dbo.Submenu.url
	// 	FROM
	// 	dbo.Usuario INNER JOIN
	// 	dbo.Rol ON dbo.Usuario.id_rol = dbo.Rol.id_rol INNER JOIN
	// 	dbo.RolSubmenu ON dbo.Rol.id_rol = dbo.RolSubmenu.id_rol INNER JOIN
	// 	dbo.Submenu ON dbo.RolSubmenu.id_submenu = dbo.Submenu.id_submenu INNER JOIN
	// 	dbo.Menu ON dbo.Submenu.id_menu = dbo.Menu.id_menu
	// 	WHERE (dbo.Usuario.id_usuario = :studyId) AND (dbo.Usuario.activo = 1)
	// 	ORDER BY dbo.Menu.id_menu, dbo.Menu.orden, orden_submenu";
	// $db = getConnection();
	// $stmt = $db->prepare($sql);
	// $stmt->bindParam("studyId", $studyId);
	// $stmt->execute();
	// $result = $stmt->fetchAll(PDO::FETCH_OBJ);
	return $result;
}

function getStudies() {
	$result = \Service\DALSislab::getInstance()->getStudies();
	// $sql = "SELECT id_estudio, id_cliente, id_origen_orden, id_ubicacion,
	// id_ejercicio, id_status, id_etapa, id_usuario_captura,
	// id_usuario_valida, id_usuario_entrega, id_usuario_actualiza,
	// oficio, folio, origen_descripcion, ubicacion, fecha,
	// fecha_entrega, fecha_captura, fecha_valida, fecha_rechaza,
	// ip_captura, ip_valida, ip_actualiza, host_captura,
	//  host_valida, host_actualiza, motivo_rechaza, activo
	// FROM Estudio";
	// $db = getConnection();
	// $stmt = $db->prepare($sql);
	// $stmt->execute();
	// $result = processResultToJson($stmt->fetchAll(PDO::FETCH_OBJ), false);
	return $result;
}

//TODO: VALIDATION DRAFT
// function isQuoteListValid($quotes) {
// 	$i = 0;
// 	$l = count($quotes);
// 	if (isset($quotes) && count($quotes) > 0)
// 	{
// 		for ($i = 0; $i < $l; $i++) {
// 			if (!is_numeric($quotes[$i]->id_matriz) || $quotes[$i]->id_matriz > 1)
// 			{
// 				$message .= 'matriz:' . $i . ',';
// 			}
// 			if (!is_numeric($quotes[$i]->cantidad_muestras) || $quotes[$i]->cantidad_muestras > 1)
// 			{
// 				$message .= 'cantidad_muestras:' . $i . ',';
// 			}
// 			if ($quotes[$i]->id_tipo_muestreo > 1)
// 			{
// 				$message .= 'id_tipo_muestreo:' . $i . ',';
// 			}
// 			if ($quotes[$i]->id_norma > 1)
// 			{
// 				$message .= 'norma:' . $i . ',';
// 			}
// 		}
// 	}
// 	$output = '{';
// 	if ($status < 1)
// 	{
// 		$output .= '"status":"0","reason":"invalid input","message":"';
// 		$output .= $message . '"';
// 	}
// 	else
// 	{
// 		$output .= '"status":"1","reason":"valid input","message":"none"';
// 	}
// 	$output .= '}';
// 	return $output;
// }




function insertStudy($requestData) {
	$dataString = '
	{
	  "id_cliente" : 13,
	  "id_usuario_valida" : 1,
	  "id_usuario_actualiza" : 1,
	  "status" : "Validado",
	  "ip_captura" : "[::1]",
	  "id_ejercicio" : 2015,
	  "folio" : "CEA-432/2015",
	  "host_captura" : "[::1]",
	  "ip_valida" : "[::1]",
	  "host_valida" : "[::1]",
	  "motivo_rechaza" : "Error en datos cliente",
	  "id_status" : 2,
	  "ip_actualiza" : "[::1]",
	  "ubicacion" : "Río Santiago",
	  "host_actualiza" : "[::1]",
	  "fecha_valida" : "2015-03-21",
	  "origen_descripcion" : "GP-001/2015",
	  "id_origen_orden" : 1,
	  "numero_oficio" : 432,
	  "fecha" : "2015-03-21",
	  "fecha_rechaza" : "2015-03-21",
	  "fecha_actualiza" : "2015-03-21",
	  "solicitudes" : [
	    {
	      "activo" : 1,
	      "$$hashKey" : "object:113",
	      "id_matriz" : 1,
	      "id_norma" : 3,
	      "id_solicitud" : 1,
	      "id_estudio" : 1,
	      "id_tipo_muestreo" : 2,
	      "id_status" : 1,
	      "cantidad_muestras" : 15
	    },
	    {
	      "activo" : 1,
	      "$$hashKey" : "object:114",
	      "id_matriz" : 6,
	      "id_norma" : 1,
	      "id_solicitud" : 2,
	      "id_estudio" : 1,
	      "id_tipo_muestreo" : 1,
	      "id_status" : 1,
	      "cantidad_muestras" : 16
	    }
	  ],
	  "fecha_captura" : "2015-03-21",
	  "cliente" : {
	    "numero" : "100",
	    "cp" : "59940",
	    "id_organismo" : 6,
	    "tel" : "045-35-4100-1836",
	    "cea" : 0,
	    "municipio" : "Cotija",
	    "fax" : "",
	    "fecha_act" : "23/11/2014",
	    "colonia" : "Col. Centro",
	    "id_municipio" : 16019,
	    "localidad" : "Cotija de La Paz",
	    "rfc" : "Registro Federal de Contribuyentes",
	    "tasa" : 1,
	    "puesto_contacto" : "puesto contacto",
	    "email" : "ooapascotija@hotmail.com",
	    "id_estado" : 16,
	    "interno" : 0,
	    "area" : "",
	    "cliente" : "Ayuntamiento de Cotija, Michoacan",
	    "id_localidad" : 160190001,
	    "contacto" : "Arq. Juan Jesús Zarate Barajas",
	    "calle" : "Pino Suárez Pte.",
	    "estado" : "Michoacán de Ocampo",
	    "activo" : 1,
	    "id_cliente" : 13
	  },
	  "id_usuario_captura" : 20,
	  "activo" : 1,
	  "id_estudio" : 1
	}
	';
	$sql = "INSERT INTO Usuario
		(id_usuario, id_nivel, id_rol, id_area, id_puesto, interno, cea,
		 laboratorio, supervisa, analiza, muestrea, nombres, apellido_paterno,
		 apellido_materno, usr, pwd, fecha_captura, fecha_actualiza, ip_captura,
		 ip_actualiza, host_captura, host_actualiza, activo)
		VALUES
		(NULL, '3', '3', '3', '3', '1',
		 '1', '1', '1', '1', '1',
		 'Supervisor', 'de', 'Area', 'super',
		 '73d1b1b1bc1dabfb97f216d897b7968e44b06457920f00f2dc6c1ed3be25ad4c',
		 '', '', '', '', '', '', '1'
		);";
	// $db = getConnection();
	// $stmt = $db->prepare($sql);
	// $stmt->bindParam("data", $data);
	// $stmt->execute();
	// $result = $stmt->fetchAll(PDO::FETCH_OBJ);
	$result = json_encode($requestData);
	return $result;
}
/*
function insertUser($requestData) {
	try {
		//$requestData = json_decode($payload);
		$insertDataArray = array (
			"id_nivel" => $requestData->id_nivel,
			"id_rol" => $requestData->id_rol,
			"id_area" => $requestData->id_area,
			"id_puesto" => $requestData->id_puesto,
			"interno" => $requestData->interno,
			"cea" => $requestData->cea,
			"laboratorio" => $requestData->laboratorio,
			"supervisa" => $requestData->supervisa,
			"analiza" => $requestData->analiza,
			"muestrea" => $requestData->muestrea,
			"nombres" => utf8_decode($requestData->nombres),
			"apellido_paterno" => utf8_decode($requestData->apellido_paterno),
			"apellido_materno" => utf8_decode($requestData->apellido_materno),
			"usr" => $requestData->usr,
			"pwd" => $requestData->pwd,
			"fecha_captura" => $requestData->fecha_captura,
			"fecha_actualiza" => $requestData->fecha_actualiza,
			"ip_captura" => $requestData->ip_captura,
			"ip_actualiza" => $requestData->ip_actualiza,
			"host_captura" => $requestData->host_captura,
			"host_actualiza" => $requestData->host_actualiza,
			"activo" => $requestData->activo
		);
		$sql = "INSERT INTO Usuario
			( id_nivel, id_rol, id_area, id_puesto, interno, cea,
			 laboratorio, supervisa, analiza, muestrea, nombres,
			 apellido_paterno,
			 apellido_materno, usr, pwd, fecha_captura, fecha_actualiza,
			 ip_captura, ip_actualiza, host_captura, host_actualiza, activo)
			VALUES ( :id_nivel, :id_rol, :id_area, :id_puesto, :interno,
				:cea, :laboratorio, :supervisa, :analiza, :muestrea, :nombres,
				:apellido_paterno, :apellido_materno, :usr, :pwd, :fecha_captura,
				:fecha_actualiza, :ip_captura, :ip_actualiza, :host_captura,
				:host_actualiza, :activo
			)";
		$db = getConnection();
		$stmt = $db->prepare($sql);
		$stmt->execute($userData);
		$userId = $db->lastInsertId();
		$db = null;
		return getUser($userId);
	} catch(PDOException $e) {
		//print_r($e->getMessage());
		return 0;
	}
}

function getUser($userId) {
	try {
		$sql = "SELECT id_usuario, id_nivel, id_rol, id_area, id_puesto,
			interno, cea, laboratorio, supervisa, analiza, muestrea, nombres,
			apellido_paterno, apellido_materno, usr, pwd, fecha_captura,
			fecha_actualiza, ip_captura, ip_actualiza,
			host_captura, host_actualiza, activo
			FROM Usuario
			WHERE id_usuario=:userId
		";
		$db = getConnection();
		$stmt = $db->prepare($sql);
		$stmt->bindParam("userId", $userId);
		$stmt->execute();
		$user = $stmt->fetch(PDO::FETCH_OBJ);
		$db = null;
		return $user;
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}';
	}
}
*/