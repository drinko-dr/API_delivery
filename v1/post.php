<?php
$url = "http://127.0.0.1/API_delivery/v1/orders.php";
$data = [
			"dir" => "asc",
		  	"filter" => [
					"since" => "2020-07-20",
					"to"=> "2020-07-22"
		  ],
		  "limit" => 10
		];
//$data = [
//			"order_id" => "11"
//		];

//$data = [
//	"product_id" => "3",
//	"destination" => "ул. белозерская 19",
//	"date_end" => "2020-07-21"
//];



$dataString = json_encode($data);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
curl_setopt($ch,CURLOPT_HEADER,true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
	'Content-Type: application/json',
	'Client-Id: 521',
	'Api-Key: 7dbb8d6e'
]);


$result = curl_exec($ch);
curl_close($ch);
//$result =json_decode($result);

//var_dump($result);
echo $result;

?>