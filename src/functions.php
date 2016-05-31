<?php

// Function that gets database
function getDatabase() {
	$host = "ec2-54-243-243-89.compute-1.amazonaws.com";
	$user = "xzfcgltqfpdfry";
	$pass = "-38WMXBhIpfL2kMPttuhbGYoXf";
	$dbname = "dcvqga07rna3js";

	$connectionString = "host=$host port=5432 dbname=$dbname user=$user password=$pass";
	return pg_connect($connectionString);
}

// Function that transforms sql query to list of json objects
function getListJson($sql) {
	$db = getDatabase();

	$ret = pg_query($db, $sql);
	if(!$ret){
		echo pg_last_error($db);
		exit;
	}

	$myarray = array();
	while ($row = pg_fetch_assoc($ret)) {
		$myarray[] = $row;
	}

	pg_close($db);

	return json_encode($myarray, JSON_NUMERIC_CHECK);
}

// Function that transforms sql query to single json object
function getJson($sql) {
	$db = getDatabase();

	$ret = pg_query($db, $sql);
	if(!$ret){
		echo pg_last_error($db);
		exit;
	}

	$result = pg_fetch_assoc($ret);

	pg_close($db);

	return json_encode($result, JSON_NUMERIC_CHECK);
}

function login($email, $password) {
	$db = getDatabase();

	$ret = pg_query($db, "SELECT exists(select 1 from \"user\" where email = '$email' and password = '$password') as \"status\"");
	if(!$ret){
		echo pg_last_error($db);
		exit;
	}

	$result = pg_fetch_assoc($ret);

	if ($result["status"] == 't') {
		$ret = pg_query($db, "SELECT id from \"user\" where email = '$email' and password = '$password'");
		if(!$ret){
			echo pg_last_error($db);
			exit;
		}

		$innerResult = pg_fetch_assoc($ret);
		$result["userId"] = $innerResult["id"];
	}

	pg_close($db);

	return json_encode($result, JSON_NUMERIC_CHECK);
}