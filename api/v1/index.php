<?php
require "../libs/Slim/Slim.php";
require "../libs/JWT/JWT.php";
require "./Services/DALSislab.php";
// cd372fb85148700fa88095e3492d3f9f5beb43e555e5ff26d95f5a6adc36f8e6
define("KEY", "m0oxUT7L8Unn93hXMUGHpwq_jTSKVBjQfEVCUe8jZ38KUU4VSAfmsNk4JJYcJl7CukrY6QMlixxwat7AZSpDcSQ");

define("DB_DRIVER", "sqlsrv");
define("DB_HOST", "localhost");
define("DB_PORT", "");
define("DB_USER", "sislab");
define("DB_PASSWORD", "sislab");
define("DB_DATA_BASE", "Sislab");
/*
define("DB_DRIVER", "mysql");
define("DB_PORT", "8889");
define("DB_USER", "root");
define("DB_PASSWORD", "root");
define("DB_DATA_BASE", "sislab");
*/

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
		print_r($result);
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/users", function() use ($app) {
	try {
		$userId = validateTokenUser($app);
		$result = \Service\DALSislab::getInstance()->getUsers();
		//$result = getUsers();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		//$result = ")]}',\n" . $result;
		echo $result;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/menu", function() use ($app) {
	try {
		$userId = validateTokenUser($app);
		$result = \Service\DALSislab::getInstance()->getMenu($userId);
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
		$userId = validateTokenUser($app);
		$result = \Service\DALSislab::getInstance()->getTasks($userId);
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
			$result = \Service\DALSislab::getInstance()->getStudy($studyId);
		}
		else
		{
			$result = \Service\DALSislab::getInstance()->getStudies();
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
		$request = $app->request();
		$requestBody = $request->getBody();

		$requestData = extractDataFromRequest($app);
		$result = json_encode($requestData);

		$userId = validateTokenUser($app);
		//$result = \Service\DALSislab::getInstance()->insertStudy();
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
		//$result = \Service\DALSislab::getInstance()->insertStudy();
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
		//$result = \Service\DALSislab::getInstance()->insertStudy();
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
		//$result = \Service\DALSislab::getInstance()->insertStudy();
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
		//$result = \Service\DALSislab::getInstance()->insertStudy();
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
		//$result = \Service\DALSislab::getInstance()->insertStudy();
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
		//$result = \Service\DALSislab::getInstance()->insertStudy();
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
$app->get("/clients", function() use ($app) {
	try {
		$userId = validateTokenUser($app);
		$result = \Service\DALSislab::getInstance()->getClients();
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

$app->get("/users", function() use ($app) {
	try {
		$userId = validateTokenUser($app);
		$result = \Service\DALSislab::getInstance()->getUsers();
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
$app->get("/users/:userId", function() use ($app) {
	try {
		$userId = validateTokenUser($app);
		$result = \Service\DALSislab::getInstance()->getUser($userId);
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
/*
$app->get("/clients/:clientId", function() use ($app) {
	try {
		$userId = validateTokenUser($app);
		$result = \Service\DALSislab::getInstance()->getClient($clientId);
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

$app->run();

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
		echo '{"error":"Unauthorized"}';
		$app->stop();
	}
}

function processResultToJson($items, $isArrayOutputExpected) {
	$output = "";
	try {
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
	} catch(PDOException $e) {
		//error_log($e->getMessage(), 3, '/var/tmp/php.log');
		//echo '{"error":{"text":'. $e->getMessage() .'}}';
		$output = '{"error":"' . $e->getMessage() . '"}';
	}
	return $output;
}

function getConnection() {
	$dsn = DB_DRIVER . ":";
	/*
	$dsn .= "host=" . DB_HOST . ";";
	if (strlen(DB_PORT) > 0)
	{
		$dsn .= "port=" . DB_PORT . ";";
	}
	$dsn .= "dbname=" . DB_DATA_BASE;
	*/
	$dsn .= "server=" . DB_HOST . ";";
	$dsn .= "Database=" . DB_DATA_BASE;

	$dbConnection = new PDO($dsn, DB_USER, DB_PASSWORD);
	$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	return $dbConnection;
}

function getUserByCredentials($userName, $userPassword) {
	//$userName = "rgarcia";
	//$userPassword = "8493a161f70fffc0dcd4732ae4f6c4667f373688fff802ea13c71bd0fce41cb1";
	$sql = "SELECT id_usuario, id_nivel, id_rol, id_area, id_puesto, interno, cea, laboratorio, supervisa, analiza, muestrea, nombres, apellido_paterno, apellido_materno, usr, pwd, fecha_captura, fecha_actualiza, ip_captura, ip_actualiza, host_captura, host_actualiza, activo FROM Usuario WHERE usr = :userName AND pwd = :userPassword AND activo = 1";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->bindParam("userName", $userName);
	$stmt->bindParam("userPassword", $userPassword);
	$stmt->execute();
	return $stmt->fetchAll(PDO::FETCH_OBJ);
}

function getUsers() {
	$sql = "SELECT id_usuario, id_nivel, id_rol, id_area, id_puesto, interno, cea, laboratorio, supervisa, analiza, muestrea, nombres, apellido_paterno, apellido_materno, usr, pwd, fecha_captura, fecha_actualiza, ip_captura, ip_actualiza, host_captura, host_actualiza, activo FROM Usuario WHERE activo = 1";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->bindParam("userName", $userName);
	$stmt->bindParam("userPassword", $userPassword);
	$stmt->execute();
	return processResultToJson($stmt->fetchAll(PDO::FETCH_ASSOC), false);
}

function processUserJwt($app) {
	$request = $app->request();
	$input = json_decode($request->getbody());
	$usr = $input->username;
	$pwd = $input->password;

	$userData = \Service\DALSislab::getInstance()->getUserByCredentials($usr, $pwd);
	$userInfo = json_decode($userData);
	//$res = getUserByCredentials($usr, $pwd);
	//$userInfo = $res[0];

	$userId = $userInfo->id_usuario;
	$userLv = $userInfo->id_nivel;
	$userRole = $userInfo->id_rol;
	//$name = utf8_encode($userInfo->nombres) . " ";
	//$name .= utf8_encode($userInfo->apellido_paterno) . " ";
	//$name .= utf8_encode($userInfo->apellido_materno) . "";
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
