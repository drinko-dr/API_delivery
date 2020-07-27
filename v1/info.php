<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


	require_once "./includes/Product.php";
	require_once "./includes/RateLimit.php";



	$headers = getallheaders();

	$data = json_decode(file_get_contents('php://input'), false);

	$client_id = $headers['Client-Id'];
	$api_key = $headers['Api-Key'];
	if ( !empty($client_id) &&
		 !empty($api_key) &&
		 !empty($data->order_id) ) {

		$database = new Database();
		$db = $database->getConnection();
		$database->checkApi($client_id, $api_key);

		$rl = new RateLimit();

		$remaining = $rl->fixSlideWindow($api_key."info", 10);
		header("X-RateLimit-Limit: 10");
		header("X-RateLimit-Remaining: ".(10 - $remaining));
		if ( $remaining == 10){
			http_response_code(429);
			die();
		}

		$product = new Product($db);
		$info = $product->getOrderInfo($data->order_id);
		pg_close($db);
		if ( !$info ){

			http_response_code(404);

			echo json_encode(array("error" => "Неверный номер заказа"), JSON_UNESCAPED_UNICODE);
			die();
		}

		http_response_code(200);

		echo json_encode(array("result" => $info), JSON_UNESCAPED_UNICODE);
	}else{

		http_response_code(400);

		echo json_encode(array("error" => "Неверный ввод данных"), JSON_UNESCAPED_UNICODE);

	}
