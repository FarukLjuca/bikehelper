<?php
// Routes

$app->get('/store', function ($request, $response, $args) {
	$response->getBody()->write(getListJson("SELECT * from store"));	
	return $response;
});

$app->get('/store/rent', function ($request, $response, $args) {
	$response->getBody()->write(getListJson("SELECT * from store where (select count(*) from bike where storeid = store.id) > 0"));	
	return $response;
});

$app->get('/store/{id}', function ($request, $response, $args) {
	$id = (int)$args['id'];
	$response->getBody()->write(getJson("SELECT * from store where id = $id"));	
	return $response;
});

$app->post('/store', function ($request, $response, $args) {
	$data = $request->getParsedBody();
	$latitude = $data["latitude"];
	$longitude = $data["longitude"];
	$name = $data["name"];
	$description = $data["description"];
	$image = $data["image"];

	$response->getBody()->write(getJson("INSERT INTO store values (default, $latitude, $longitude, '$name', '$description', '$image') returning id"));	
	return $response;
});

$app->get('/user', function ($request, $response, $args) {
	$response->getBody()->write(getListJson("SELECT id, name, email, level from \"user\""));	
	return $response;
});

$app->get('/user/{id}', function ($request, $response, $args) {
	$id = (int)$args['id'];
	$response->getBody()->write(getJson("SELECT id, name, email, level from \"user\" where id = $id"));	
	return $response;
});

$app->post('/user/login', function ($request, $response, $args) {
	$data = $request->getParsedBody();
	$email = $data["Email"];
	$password = $data["Password"];

	$response->getBody()->write(login($email, $password));
	return $response;
});

$app->post('/user/register', function ($request, $response, $args) {
	$data = $request->getParsedBody();
	$name = $data["Name"];
	$email = $data["Email"];
	$password = $data["Password"];

	$response->getBody()->write(getJson("INSERT INTO \"user\" values (default, '$name', '$email', '$password') returning id"));

	return $response;
});

$app->get('/bike', function($request, $response, $args) {
	$response->getBody()->write(getListJson("SELECT * from bike"));	
	return $response;
});

$app->get('/bike/rented', function($request, $response, $args) {
	$response->getBody()->write(getListJson("SELECT * from bike where userid notnull"));	
	return $response;
});

$app->get('/bike/{id}', function($request, $response, $args) {
	$id = (int)$args['id'];
	$response->getBody()->write(getJson("SELECT * from bike where id = $id"));	
	return $response;
});

$app->get('/bike/store/{id}', function($request, $response, $args) {
	$id = (int)$args['id'];
	$response->getBody()->write(getListJson("SELECT * from bike where storeId = $id"));	
	return $response;
});

$app->post('/bike/rent', function($request, $response, $args) {
	$data = $request->getParsedBody();
	$userId = $data["UserId"];
	$storeId = $data["StoreId"];
	$bikeId = $data["BikeId"];

	getJson("UPDATE bike set storeid = null, userid = $userId where id = $bikeId");
	$response->getBody()->write(getJson("INSERT INTO rent values (default, $userId, $storeId, $bikeId, now(), null) returning id"));

	return $response;
});

$app->post('/bike/return', function($request, $response, $args) {
	$data = $request->getParsedBody();
	$storeId = $data["StoreId"];
	$bikeId = $data["BikeId"];

	getJson("UPDATE bike set storeid = $storeId, userid = null where id = $bikeId");
	$response->getBody()->write(getJson("UPDATE rent set returndate = now() where bikeid = $bikeId and returndate isnull  returning id"));

	return $response;
});