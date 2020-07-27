<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");


	require_once "./includes/Product.php";
	require_once "./includes/RateLimit.php";

	$headers = getallheaders();

	$data = json_decode(file_get_contents('php://input'), false);

	$client_id = $headers['Client-Id'];
	$api_key = $headers['Api-Key'];
	$product_id = $data->product_id;

	if ( !empty($client_id) &&
		 !empty($api_key) &&
		 !empty($product_id)) {
		$database = new Database();
		$db = $database->getConnection();
		$database->checkApi($client_id, $api_key);

		$rl = new RateLimit();

		$remaining = $rl->fixSlideWindow($api_key."calc", 10);
		header("X-RateLimit-Limit: 10");
		header("X-RateLimit-Remaining: ".(10 - $remaining));
		if ( $remaining == 10){
			http_response_code(429);
			die();
		}

		$products = new Product($db);
		$product = $products->getProduct($product_id);
		pg_close($db);

		http_response_code(200);

		echo json_encode(array(
			"result" => calc($product)
		), JSON_UNESCAPED_UNICODE);
	}else{
		http_response_code(400);

		echo json_encode(array("error" => "Неверный ввод данных"), JSON_UNESCAPED_UNICODE);
		die();

	}
/**
 * @param $product
 * @return float|int - стоимость доставки.
 *
 */
function calc($product){
			$weight = $product['weight'];
			$width = $product['width'];
			$height = $product['height'];

			$cof = ($weight / 1000 - 5) * 200;
			$cof > 0 ? $cof += ($width * $height) / 100 : $cof = ($width * $height) / 100 ;
			$o = $cof % 100;
			if ($o > 0 )
				$cof += 100-$o;

		return intval($cof);
	}