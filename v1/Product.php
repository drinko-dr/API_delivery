<?php

require_once "Database.php";

class Product
{

	private $link;

	public function __construct($db)
	{
		$this->link = $db;
	}

	public function getProduct($id, $sku){

		$query = "SELECT * FROM `products` WHERE `product_id` = '" . $id . "' AND sku= '" . $sku . "'";


		$stmt = $this->link->prepare( $query );

		$stmt->execute();


		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if (!$row){
			http_response_code(404);
			echo json_encode(array("error" => "Товар не найден"), JSON_UNESCAPED_UNICODE);
			die();
		}

		return $row;
	}

	public function getOrders(){

	}

	public function getOrderInfo($orderID){

	}

	public function creatDelivery($product_id, $sku){

		$this->getProduct($product_id, $sku);

	}


}