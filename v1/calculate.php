<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
//header("X-RateLimit-Limit: 60");

session_start();

const cap = 3;
$stamp_init = date("Y-m-d H:i:s");
if( !isset( $_SESSION['FIRST_REQUEST_TIME'] ) ){
	$_SESSION['FIRST_REQUEST_TIME'] = $stamp_init;
}
$first_request_time = $_SESSION['FIRST_REQUEST_TIME'];
$stamp_expire = date( "Y-m-d H:i:s", strtotime( $first_request_time )+( 60 ) );
if( !isset( $_SESSION['REQ_COUNT'] ) ){
	$_SESSION['REQ_COUNT'] = 0;
}
$req_count = $_SESSION['REQ_COUNT'];
$req_count++;
if( $stamp_init > $stamp_expire ){//Expired
	$req_count = 1;
	$first_request_time = $stamp_init;
}
$_SESSION['REQ_COUNT'] = $req_count;
$_SESSION['FIRST_REQUEST_TIME'] = $first_request_time;
header('X-RateLimit-Limit: '.cap);
header('X-RateLimit-Remaining: ' . ( cap-$req_count ) );
if( $req_count > cap){//Too many requests
	http_response_code( 429 );
	exit();
}


require_once "Product.php";

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