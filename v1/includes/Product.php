<?php

require_once "Database.php";

class Product
{

	private $connection;

	public function __construct($db)
	{
		$this->connection = $db;
	}


	/**
	 * @param $id
	 * Поиск товара по id
	 * @return array|false|resource
	 */
	public function getProduct($id){

		$query = "SELECT * FROM products WHERE product_id = '" . intval($id ). "'";


		$result = pg_query($this->connection, $query);

		$result = pg_fetch_assoc($result);


		if (!$result){
			http_response_code(404);
			echo json_encode(array("error" => "Товар не найден"), JSON_UNESCAPED_UNICODE);
			die();
		}

		return $result;
	}

	/**
	 * @param $data
	 * @param $data->filter - необязательный параметр.
	 * Выводит результат заданного интервала времени
	 * Массив всех заказов с заданным лимитом вывода
	 *
	 * @return array|false|resource
	 */
	public function getOrders($data){

		$filter = null;
		if ( !empty($data->filter->since) &&
			 !empty($data->filter->to) )
			$filter = "WHERE order_delivery BETWEEN '".$data->filter->since."' AND '".$data->filter->to."'";

		$query = "SELECT delivery.*, products.product_name, products.price
        			FROM delivery
					JOIN products ON products.product_id = delivery.product_id
					".$filter."
					ORDER BY delivery.order_delivery ".htmlspecialchars($data->dir)."
					LIMIT ".intval( $data->limit );

		$result = pg_query($this->connection, $query);

		$result = pg_fetch_all($result);

		return $result;
	}

	/**
	 * @param $orderID
	 * @return array|false|resource
	 * Массив с данными о заказе
	 */
	public function getOrderInfo($orderID){
		$query = "SELECT *
        			FROM delivery
					JOIN products ON products.product_id = delivery.product_id
					WHERE delivery.order_id = '".intval($orderID)."'";

		$result = pg_query($this->connection, $query);

		$result = pg_fetch_assoc($result);

		return $result;
	}

	/**
	 * @param $data
	 * @return string - id сформированного заказа
	 */
	public function creatDelivery($data){

		$this->getProduct($data->product_id);

		if ( (strtotime($data->date_delivery) - time()) <= 0 ){

			http_response_code(404);
			echo json_encode(array("error" => "Неверная дата"), JSON_UNESCAPED_UNICODE);
			die();

		}

		$quantity = 1;

		$data->quantity == null ? : $quantity = $data->quantity;

		$today =  date("Y-m-d H:i");


		$query = "INSERT INTO delivery (order_date_create, order_delivery, product_id, quantity, destination, client_name, phone) 
						VALUES ('".$today."', 
								'".$data->date_delivery."', 
								'".intval($data->product_id)."', 
								'".intval($quantity)."', 
								'".htmlspecialchars($data->destination)."',
								'".htmlspecialchars($data->name)."',
								'".intval($data->phone)."') RETURNING order_id";

		$result = pg_query($this->connection, $query);

		$result = pg_fetch_assoc($result);

		if ( !$result ){
				 http_response_code(400);

				 echo json_encode(array("error" => "Не удалось создать заказ"), JSON_UNESCAPED_UNICODE);
				 die();
		 }

		return $result['order_id'];

	}


}