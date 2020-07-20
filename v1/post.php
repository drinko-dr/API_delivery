<?php
$url = "http://127.0.0.1/API_delivery/v1/orders.php";


$delivery_list = [
			"dir" => "asc",
		  	"filter" => [
					"since" => "2020-07-20",
					"to"=> "2020-07-22"
		  ],
		  "limit" => 1
		];

$calc_delivery = [
	"product_id" => "16"
];
$one_delivery_info = [
	"order_id" => "3"
];

$create_delivery = [
	"name" => "Name",
	"phone" => "123456789",
	"product_id" => "16",
	"destination" => "ул. белозерская 19",
	"date_delivery" => "2020-07-21"
];

//$dataString = json_encode($calc_delivery);
//$dataString = json_encode($create_delivery);
//$dataString = json_encode($one_delivery_info);
$dataString = json_encode($delivery_list);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
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