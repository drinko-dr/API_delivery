<?php
$url = "http://127.0.0.1/API_delivery/v1/delivery.php";
$data = [
			"product_id" => "1",
			"sku" => "REDSGS9-512",
			"delivery" => "true"
		];

$dataString = json_encode($data);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
curl_setopt($ch,CURLOPT_HEADER,false);
curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
	'Content-Type: application/json',
	'Client-Id: 24',
	'Api-Key: 0296d4f2'
]);


$result = curl_exec($ch);
curl_close($ch);
//$result =json_decode($result);

//var_dump($result);
echo $result;

?>