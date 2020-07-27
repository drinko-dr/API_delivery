<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


	require_once "Product.php";
require_once "RateLimit.php";



$headers = getallheaders();

	$data = json_decode(file_get_contents('php://input'), false);

	$client_id = $headers['Client-Id'];
	$api_key = $headers['Api-Key'];


	if ( !empty($client_id) &&
		 !empty($api_key) &&
		 !empty($data->dir) &&
		 ($data->dir == 'asc' || $data->dir == 'desc') &&
		 !empty($data->limit) &&
		 $data->limit > 0 ){

		$database = new Database();
		$db = $database->getConnection();
		$database->checkApi($client_id, $api_key);

		$rl = new RateLimit();

		$remaining = $rl->fixSlideWindow($api_key."ord", 10);
		header("X-RateLimit-Limit: 10");
		header("X-RateLimit-Remaining: ". (10 - $remaining));
		if ( $remaining  == 10){
			http_response_code(429);
			die();
		}

		$products = new Product($db);
		$product = $products->getOrders($data);
		pg_close($db);

		if (!$product){

			http_response_code(404);

			echo json_encode(array("error" => "Не найденно заказов"), JSON_UNESCAPED_UNICODE);
		}else{

			http_response_code(200);

			echo json_encode(array("result" => $product), JSON_UNESCAPED_UNICODE);

		}
	}else{

		http_response_code(400);

		echo json_encode(array("error" => "Неверный ввод данных"), JSON_UNESCAPED_UNICODE);

	}

