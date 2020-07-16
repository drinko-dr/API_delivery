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
	$sku = $data->sku;

	$database = new Database();
	$db = $database->getConnection();
	$database->checkApi($client_id, $api_key);

	$products = new Product($db);
	$product = $products->creatDelivery($product_id, $sku);


	http_response_code(200);

	echo json_encode(array("result" => $product), JSON_UNESCAPED_UNICODE);

