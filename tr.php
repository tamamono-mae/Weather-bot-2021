<?php

	$response = file_get_contents('php://input');
	$update = json_decode($response, true);
	echo $response;

?>