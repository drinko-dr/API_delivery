<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
require_once "Product.php";


	$headers = getallheaders();

	$data = json_decode(file_get_contents('php://input'), false);

	$client_id = $headers['Client-Id'];
	$api_key = $headers['Api-Key'];
	$product_id = $data->product_id;
	$destination = $data->destination;
	$date_end = $data->date_end;

	if ( !empty($product_id) &&
		 !empty($destination) &&
		 !empty($date_end) ) {

		$database = new Database();
		$db = $database->getConnection();
		$database->checkApi($client_id, $api_key);

		$product = new Product($db);
		$res = $product->creatDelivery($product_id, $destination, $date_end);

		pg_close($db);

		http_response_code(200);

		echo json_encode(array(
							"result" => array(
										"success" => true,
										"order_id" => $res
										)
						), JSON_UNESCAPED_UNICODE);
	}else{
		http_response_code(400);

		echo json_encode(array("error" => "Неверный ввод данных"), JSON_UNESCAPED_UNICODE);
		die();

	}



