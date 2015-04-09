<?php
require "../libs/Slim/Slim.php";
require "../libs/JWT/JWT.php";
require "./Services/DALSislab.php";

define("KEY", "m0oxUT7L8Unn93hXMUGHpwq_jTSKVBjQfEVCUe8jZ38KUU4VSAfmsNk4JJYcJl7CukrY6QMlixxwat7AZSpDcSQ");

\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();

$app->post("/login", function() use ($app) {
	try {
		$jwt = processUserJwt($app);
		$result = json_encode($jwt);
		////debugging only
		//$jwt = $token;
		//$decodedToken = decodeToken($jwt);
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		//echo ")]}',\n" . $result;
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
		//echo ")]}',\n" . $result;
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
		//echo ")]}',\n" . $result;
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
		//echo ")]}',\n" . $result;
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
		//echo ")]}',\n" . $result;
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
		//echo ")]}',\n" . $result;
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
		//echo ")]}',\n" . $result;
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
		//echo ")]}',\n" . $result;
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
		//echo ")]}',\n" . $result;
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
		//echo ")]}',\n" . $result;
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
		//echo ")]}',\n" . $result;
		echo $result;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/sheets(/)(:sheetId)", function($sheetId = -1) use ($app) {
	try {
		$userId = validateTokenUser($app);
		if ($sheetId > -1)
		{
			$result = \Service\DALSislab::getInstance()->getFieldsheet($sheetId);
		}
		else
		{
			$result = \Service\DALSislab::getInstance()->getFieldsheets();
		}
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		//echo ")]}',\n" . $result;
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
		//echo ")]}',\n" . $result;
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
		//echo ")]}',\n" . $result;
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
		//echo ")]}',\n" . $result;
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
		//echo ")]}',\n" . $result;
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
		//echo ")]}',\n" . $result;
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
		//echo ")]}',\n" . $result;
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
		//echo ")]}',\n" . $result;
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
		//echo ")]}',\n" . $result;
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
		//echo ")]}',\n" . $result;
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
		//echo ")]}',\n" . $result;
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
		//echo ")]}',\n" . $result;
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
		//echo ")]}',\n" . $result;
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
		//echo ")]}',\n" . $result;
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
		//echo ")]}',\n" . $result;
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
		//echo ")]}',\n" . $result;
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
		//echo ")]}',\n" . $result;
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
		//echo ")]}',\n" . $result;
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
		//echo ")]}',\n" . $result;
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
		//echo ")]}',\n" . $result;
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
		//echo ")]}',\n" . $result;
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
		//echo ")]}',\n" . $result;
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
		//echo ")]}',\n" . $result;
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
		//echo ")]}',\n" . $result;
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
		//echo ")]}',\n" . $result;
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
		//echo ")]}',\n" . $result;
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
		//echo ")]}',\n" . $result;
		echo $result;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/winds", function() use ($app) {
	try {
		$userId = validateTokenUser($app);
		$result = \Service\DALSislab::getInstance()->getWinds();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		//echo ")]}',\n" . $result;
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
		//echo ")]}',\n" . $result;
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
		//echo ")]}',\n" . $result;
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
		//echo ")]}',\n" . $result;
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
		//echo ")]}',\n" . $result;
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
		//echo ")]}',\n" . $result;
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
		//echo ")]}',\n" . $result;
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
		//echo ")]}',\n" . $result;
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
		//echo ")]}',\n" . $result;
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
		//echo ")]}',\n" . $result;
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
		//echo ")]}',\n" . $result;
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
		//echo ")]}',\n" . $result;
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
		//echo ")]}',\n" . $result;
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
		//echo ")]}',\n" . $result;
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
		//echo ")]}',\n" . $result;
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
		//echo ")]}',\n" . $result;
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
		//echo ")]}',\n" . $result;
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
		//echo ")]}',\n" . $result;
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
		//echo ")]}',\n" . $result;
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
		//echo ")]}',\n" . $result;
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
		//echo ")]}',\n" . $result;
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
		//echo ")]}',\n" . $result;
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
		//echo ")]}',\n" . $result;
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
		//echo ")]}',\n" . $result;
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
		//echo ")]}',\n" . $result;
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

function processUserJwt($app) {
	$request = $app->request();
	$input = json_decode($request->getBody());
	$name = "";
	$userId = 1;
	$userLv = 0;
	$usr = $input->username;
	$pwd = $input->password;

	$userData = \Service\DALSislab::getInstance()->getUserByCredentials($usr, $pwd);
	$userInfo = json_decode($userData);

	$userId = $userInfo->id_usuario;
	$userLv = $userInfo->id_nivel;
	$name = $userInfo->nombres . " ";
	$name .= $userInfo->ap . " ";
	$name .= $userInfo->am . " ";

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
	$token["cip"] = $request->getIp() . "";
	$token["iss"] = $request->getUrl();
	$token["aud"] = "sislab.ceajalisco.gob.mx";
	$token["iat"] = time();
	/// Token expires 3 hours from now
	$token["exp"] = time() + (3 * 60 * 60);
	$jwt = JWT::encode($token, KEY);
	return $jwt;
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



/*
$validateAccessToken = function($app) {
   return function () use ($app) {
		$request = $app->request();
		$headers = $request->headers();

		$jwt = $headers["Auth-Token"];
		$decoded = JWT::decode($jwt, KEY);
		$userPass = hex2bin($decoded->upt);
		$userPassArray = explode (".", $userPass);
		$userId = 0;
		if ($userPassArray[0] === "rgarcia" && $userPassArray[1] === "rgarcia")
		{
			$userId = 1;
		}
		else
		{
		   //$app->redirect("/errorpage");
		}
	};
};
*/
//$app->get("/tasks", $validateAccessToken($app), function() use ($app) {
//	try {
//		$request = $app->request();
//		$headers = $request->headers();
//
//		$userId = validateTokenUser($headers);
//
//		$result = DALSislab::getInstance()->getTasks($userId);
//		$app->response()->status(200);
//		$app->response()->header('Content-Type', 'application/json');
//		//echo ")]}',\n" . $result;
echo $result;
//	} catch (Exception $e) {
//		$app->response()->status(400);
//		$app->response()->header('X-Status-Reason', $e->getMessage());
//	}
//});
/*
$app->get('/acciones/:id', 'getAccion');
*/
/*
function addWine() {
	$request = Slim::getInstance()->request();
	$wine = json_decode($request->getBody());
	$sql = "INSERT INTO wine (name, grapes, country, region, year, description) VALUES (:name, :grapes, :country, :region, :year, :description)";
	try {
		$db = getConnection();
		$stmt = $db->prepare($sql);
		$stmt->bindParam("name", $wine->name);
		$stmt->bindParam("grapes", $wine->grapes);
		$stmt->bindParam("country", $wine->country);
		$stmt->bindParam("region", $wine->region);
		$stmt->bindParam("year", $wine->year);
		$stmt->bindParam("description", $wine->description);
		$stmt->execute();
		$wine->id = $db->lastInsertId();
		$db = null;
		echo json_encode($wine);
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}';
	}
}
*/
/*
function getAccion($id) {
	$sql = "SELECT idaccion, idlicitacion, idcontrato, idprograma, idsubprograma, idtipoaccion, idcategoria, idsubcategoria, idejercicio, idcobertura, idpertenece, idsituacion,
		idstatusanexo, idobserobras, idconveniotrans, idsicpro, idresponsable, idclasificador, idagrupador, elabcontrato, ptars, DescAnexo, NombreObra, montoprogramado,
		montopreprogramado, montoorigenprogramado, obserpreprog, costobase, porcfederal, porcestatal, porcmunicipal, porcotros, porcindirecto, numaccionanexo,
		ctacontable, credito, contraparte, codigoBID, fichaSIIF, obraSIIF, [status], status1, poblacionbene, abona_cobertura, hab_bene, user_updt, validar, validarconceptos,
		observaciones, cob_abona, fecha_updt
		FROM Acciones
		WHERE idaccion=:id";
	try {
		$db = getConnection();
		$stmt = $db->prepare($sql);
		$stmt->bindParam("id", $id);
		$stmt->execute();
		$result = $stmt->fetchObject();
		$db = null;
		// Include support for JSONP requests
		if (!isset($_GET['callback'])) {
			echo json_encode($result);
		} else {
			echo $_GET['callback'] . '(' . json_encode($result) . ');';
		}
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}';
	}
}
*/
/*
function getConnection() {
	$dbhost = "SQLDESARROLLO";
	$dbuser= "obras";
	$dbpass= "0bra$@12#";
	$dbname= "CTRLOBRA";
	$dbh = new PDO("sqlsrv:server = $dbhost; Database = $dbname", $dbuser, $dbpass);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	return $dbh;
}
*/