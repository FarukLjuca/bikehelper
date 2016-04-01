<?php
// Routes

/*
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
*/

$app->get('/store', function ($request, $response, $args) {
	$dbhostname = "sql111.byethost31.com";
	//$dbhostname = "localhost";
	$dbusername = "b31_17273471";
	$dbpassword = "bahaha20.2.";
	$dbname = "b31_17273471_bikehelper";

	$conn = new PDO("mysql:host=" . $dbhostname . ";dbname=" . $dbname, $dbusername, $dbpassword);

	$result = $conn->prepare('SELECT * FROM store');
	$result->execute(array());
	if (!$result) {
		$error = $conn->errorInfo();
	  	echo "SQL greška: " . $error[2];
	}

	$response->getBody()->write(json_encode($result->fetchAll(PDO::FETCH_ASSOC)));
	
	return $response;
});

$app->get('/store/1', function ($request, $response, $args) {
	$dbhostname = "sql111.byethost31.com";
	//$dbhostname = "localhost";
	$dbusername = "b31_17273471";
	$dbpassword = "bahaha20.2.";
	$dbname = "b31_17273471_bikehelper";

	$conn = new PDO("mysql:host=" . $dbhostname . ";dbname=" . $dbname, $dbusername, $dbpassword);

	$result = $conn->prepare('SELECT * FROM store WHERE id = ?');
	$result->execute(array(1));
	if (!$result) {
		$error = $conn->errorInfo();
	  	echo "SQL greška: " . $error[2];
	}
	$response = $response->withHeader("Access-Control-Allow-Origin:", "*");
	$response = $response->withJson($result->fetch(PDO::FETCH_ASSOC));

	return $response;
});

/*
$app->get('/[{name}]', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});
*/