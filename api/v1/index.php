<?php
require "../libs/Slim/Slim.php";
require "../libs/JWT/JWT.php";
require "./Services/DalSiclab.php";

define("KEY", "m0oxUT7L8Unn93hXMUGHpwq_jTSKVBjQfEVCUe8jZ38KUU4VSAfmsNk4JJYcJl7CukrY6QMlixxwat7AZSpDcSQ");

\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();

$app->post("/login", function() use ($app) {
	try {
		// get and decode JSON request body
		$request = $app->request();

		$client = $request->getUrl();
		$clientIp = $request->getIp();
		$headers = $request->headers();
		$body = $request->getBody();
		$input = json_decode($body);
		$name = "Reyna García Meneses";
		$userId = 1;
		$userLv = 5;

		//TODO sanitize, check versus database
		$userPass = $input->username . ".";
		$userPass .= $input->password . ".";
		$userPass .= $userId . "." . $userLv;
		$userPass = bin2hex($userPass);

		$token = array();
		//$token["usr"] = $input->username;
		//$token["pwd"] = $input->password;
		$token["nam"] = $name;
		$token["upt"] = $userPass;
		$token["uid"] = $userId;
		$token["ulv"] = $userLv;
		$token["cip"] = $clientIp;
		$token["iss"] = $client;
		$token["aud"] = "siclab.ceajalisco.gob.mx";
		$token["iat"] = time();
		$token["exp"] = time() + (50 * 60);
		$jwt = JWT::encode($token, KEY);

		////debugging only
		$decoded = JWT::decode($jwt, KEY);
		$decoded_array = (array) $decoded;
		//print_r($decoded_array);

		//// return JSON-encoded response body
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		echo json_encode($jwt);
		//echo json_encode($token);
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/menu", function() use ($app) {
	try {
		$userId = (validateTokenUser($app)) ? validateTokenUser($app) : 0;
		$menu = \Service\DalSiclab::getInstance()->getMenu($userId);
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		echo $menu;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/tasks", function() use ($app) {
	try {
		$userId = (validateTokenUser($app)) ? validateTokenUser($app) : 0;
		$menu = \Service\DalSiclab::getInstance()->getTasks($userId);
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		echo $menu;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/clients", function() use ($app) {
	try {
		$menu = \Service\DalSiclab::getInstance()->getClients();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		echo $menu;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/parameters", function() use ($app) {
	try {
		$menu = \Service\DalSiclab::getInstance()->getParameters();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		echo $menu;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/norms", function() use ($app) {
	try {
		$menu = \Service\DalSiclab::getInstance()->getNorms();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		echo $menu;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/sampling/types", function() use ($app) {
	try {
		$menu = \Service\DalSiclab::getInstance()->getSamplingTypes();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		echo $menu;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});
/*
$app->get("/quotes/:quoteId", function($quoteId) use ($app) {
	try {
		$userId = (validateTokenUser($app)) ? validateTokenUser($app) : 0;
		$menu = \Service\DalSiclab::getInstance()->getQuote($quoteId);
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		echo $menu;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});
*/
$app->get("/order/sources", function() use ($app) {
	try {
		$menu = \Service\DalSiclab::getInstance()->getOrderSources();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		echo $menu;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/matrices", function() use ($app) {
	try {
		$menu = \Service\DalSiclab::getInstance()->getMatrices();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		echo $menu;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/sampling/supervisors", function() use ($app) {
	try {
		$menu = \Service\DalSiclab::getInstance()->getSamplingSupervisors();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		echo $menu;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});
/*
$app->get("/sampling/orders/:orderId", function() use ($app) {
	try {
		$userId = (validateTokenUser($app)) ? validateTokenUser($app) : 0;
		$menu = \Service\DalSiclab::getInstance()->getSamplingOrder($orderId);
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		echo $menu;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});
*/
$app->get("/plan/objectives", function() use ($app) {
	try {
		$menu = \Service\DalSiclab::getInstance()->getPlanObjectives();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		echo $menu;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/point/kinds", function() use ($app) {
	try {
		$menu = \Service\DalSiclab::getInstance()->getPointKinds();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		echo $menu;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/districts", function() use ($app) {
	try {
		$menu = \Service\DalSiclab::getInstance()->getDistricts();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		echo $menu;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/sampling/employees", function() use ($app) {
	try {
		$menu = \Service\DalSiclab::getInstance()->getSamplingEmployees();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		echo $menu;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/preservations", function() use ($app) {
	try {
		$menu = \Service\DalSiclab::getInstance()->getPreservations();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		echo $menu;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/containers/kinds", function() use ($app) {
	try {
		$menu = \Service\DalSiclab::getInstance()->getContainerKinds();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		echo $menu;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/reactives", function() use ($app) {
	try {
		$menu = \Service\DalSiclab::getInstance()->getReactives();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		echo $menu;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/materials", function() use ($app) {
	try {
		$menu = \Service\DalSiclab::getInstance()->getMaterials();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		echo $menu;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/coolers", function() use ($app) {
	try {
		$menu = \Service\DalSiclab::getInstance()->getCoolers();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		echo $menu;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});
/*
$app->get("/sampling/plans/:planId", function() use ($app) {
	try {
		$userId = (validateTokenUser($app)) ? validateTokenUser($app) : 0;
		$menu = \Service\DalSiclab::getInstance()->getSamplingPlan($planId);
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		echo $menu;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});
*/
$app->get("/clouds", function() use ($app) {
	try {
		$menu = \Service\DalSiclab::getInstance()->getClouds();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		echo $menu;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/winds", function() use ($app) {
	try {
		$menu = \Service\DalSiclab::getInstance()->getWinds();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		echo $menu;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/waves", function() use ($app) {
	try {
		$menu = \Service\DalSiclab::getInstance()->getWaves();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		echo $menu;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/sampling/norms", function() use ($app) {
	try {
		$menu = \Service\DalSiclab::getInstance()->getSamplingNorms();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		echo $menu;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/points", function() use ($app) {
	try {
		$menu = \Service\DalSiclab::getInstance()->getPoints();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		echo $menu;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/parameters/field", function() use ($app) {
	try {
		$menu = \Service\DalSiclab::getInstance()->getParametersField();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		echo $menu;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});
/*
$app->get("/fieldsheets/:fieldsheetId", function() use ($app) {
	try {
		$userId = (validateTokenUser($app)) ? validateTokenUser($app) : 0;
		$menu = \Service\DalSiclab::getInstance()->getFieldsheet($fieldsheetId);
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		echo $menu;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});
*/
$app->get("/receptionists", function() use ($app) {
	try {
		$menu = \Service\DalSiclab::getInstance()->getReceptionists();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		echo $menu;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});
/*
$app->get("/receptions/:receptionId", function() use ($app) {
	try {
		$userId = (validateTokenUser($app)) ? validateTokenUser($app) : 0;
		$menu = \Service\DalSiclab::getInstance()->getReception($receptionId);
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		echo $menu;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});
*/
$app->get("/expirations", function() use ($app) {
	try {
		$menu = \Service\DalSiclab::getInstance()->getExpirations();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		echo $menu;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/volumes", function() use ($app) {
	try {
		$menu = \Service\DalSiclab::getInstance()->getVolumes();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		echo $menu;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/checkers", function() use ($app) {
	try {
		$menu = \Service\DalSiclab::getInstance()->getCheckers();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		echo $menu;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});
/*
$app->get("/custodies/:custodyId", function() use ($app) {
	try {
		$userId = (validateTokenUser($app)) ? validateTokenUser($app) : 0;
		$menu = \Service\DalSiclab::getInstance()->getCustody($custodyId);
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		echo $menu;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});
*/
$app->get("/samples", function() use ($app) {
	try {
		$menu = \Service\DalSiclab::getInstance()->getSamples();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		echo $menu;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/instruments", function() use ($app) {
	try {
		$menu = \Service\DalSiclab::getInstance()->getInstruments();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		echo $menu;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/containers", function() use ($app) {
	try {
		$menu = \Service\DalSiclab::getInstance()->getContainers();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		echo $menu;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/analysis", function() use ($app) {
	try {
		$menu = \Service\DalSiclab::getInstance()->getAnalysis();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		echo $menu;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/areas", function() use ($app) {
	try {
		$menu = \Service\DalSiclab::getInstance()->getAreas();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		echo $menu;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/analysis/selections", function() use ($app) {
	try {
		$menu = \Service\DalSiclab::getInstance()->getAnalysisSelections();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		echo $menu;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/reports", function() use ($app) {
	try {
		$menu = \Service\DalSiclab::getInstance()->getReports();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		echo $menu;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});
/*
$app->get("/reports/:reportId", function() use ($app) {
	try {
		$userId = (validateTokenUser($app)) ? validateTokenUser($app) : 0;
		$menu = \Service\DalSiclab::getInstance()->getReport($reportId);
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		echo $menu;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});
*/
$app->get("/employees", function() use ($app) {
	try {
		$menu = \Service\DalSiclab::getInstance()->getEmployees();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		echo $menu;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/references", function() use ($app) {
	try {
		$menu = \Service\DalSiclab::getInstance()->getReferences();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		echo $menu;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/methods", function() use ($app) {
	try {
		$menu = \Service\DalSiclab::getInstance()->getMethods();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		echo $menu;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/prices", function() use ($app) {
	try {
		$menu = \Service\DalSiclab::getInstance()->getPrices();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		echo $menu;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});

$app->get("/users", function() use ($app) {
	try {
		$userId = (validateTokenUser($app)) ? validateTokenUser($app) : 0;
		$menu = \Service\DalSiclab::getInstance()->getUsers();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		echo $menu;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});
/*
$app->get("/users/:userId", function() use ($app) {
	try {
		$userId = (validateTokenUser($app)) ? validateTokenUser($app) : 0;
		$menu = \Service\DalSiclab::getInstance()->getUser($userId);
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		echo $menu;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});
*/
$app->get("/quotes", function() use ($app) {
	try {
		$menu = \Service\DalSiclab::getInstance()->getQuotes();
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		echo $menu;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});
/*
$app->get("/clients/:clientId", function() use ($app) {
	try {
		$userId = (validateTokenUser($app)) ? validateTokenUser($app) : 0;
		$menu = \Service\DalSiclab::getInstance()->getClient($clientId);
		$app->response()->status(200);
		$app->response()->header('Content-Type', 'application/json');
		echo $menu;
	} catch (Exception $e) {
		$app->response()->status(400);
		$app->response()->header('X-Status-Reason', $e->getMessage());
	}
});
*/

function validateTokenUser($app) {
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
	return $userId;
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
//		$menu = DalSiclab::getInstance()->getTasks($userId);
//		$app->response()->status(200);
//		$app->response()->header('Content-Type', 'application/json');
//		echo $menu;
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
$app->run();

