<?php
class Post
{
private $delivery = "http://127.0.0.1/API_delivery/v1/calculate.php";
private $create = "http://127.0.0.1/API_delivery/v1/delivery.php";
private $info = "http://127.0.0.1/API_delivery/v1/info.php";
private $orders = "http://127.0.0.1/API_delivery/v1/orders.php";

private $headers = ["true" => [['Content-Type: application/json',
								'Client-Id: 521',
								'Api-Key: 7dbb8d6e'],
								['Content-Type: application/json',
								'Client-Id: 1452',
								'Api-Key: b1339024'],
								['Content-Type: application/json',
								'Client-Id: 6923',
								'Api-Key: d774c95c'],
								['Content-Type: application/json',
								'Client-Id: 6332',
								'Api-Key: 2cb6c608']],
								"false" => [['Content-Type: application/json',
								'Client-Id: f',
								'Api-Key: ew'],
								['Content-Type: application/json',
								'Client-Id: 6923',
								'Api-Key: ew'],
								['Content-Type: application/json',
								'Client-Id: wd',
								'Api-Key: d774c95c'],
								['Content-Type: application/json',
								'Client-Id: ',
								'Api-Key: ']]];
private $delivery_list = ["true" => [["dir" => "asc",
									"filter" => ["since" => "2020-07-20",
									"to" => "2020-10-30"],
									"limit" => 10],
									["dir" => "asc",
									"filter" => ["since" => "2020-07-20",
									"to" => "2020-10-30"],
									"limit" => 3],

									["dir" => "asc",
									"filter" => ["since" => "2020-07-20",
									"to" => "2020-10-27"],
									"limit" => 10],

									["dir" => "asc",
									"filter" => ["since" => "2020-07-20",
									"to" => "2020-10-30"],
									"limit" => 10],
									["dir" => "asc",
									"limit" => 10]],
				"false" => [["dir" => "ssc",
									"filter" => ["since" => "2020-07-20",
									"to" => "2020-07-22"],
									"limit" => 10],
									["dir" => "asc",
									"filter" => ["since" => "2020-07-23",
									"to" => "2020-07-22"],
									"limit" => 10],
									["dir" => "asc",
									"filter" => ["since" => "2020-07-20",
									"to" => "2020-07-19"],
									"limit" => 10],
									["dir" => "asc",
									"filter" => ["since" => "2020-07-20",
									"to" => "2020-07-19"],
									"limit" => 0],
									["dir" => "asc",
									"filter" => ["since" => "2020-07-20",
									"to" => "2020-07-19"]]]];

private $calc_delivery = ["true" => [["product_id" => "15"],
									["product_id" => "14"],
									["product_id" => "16"]],
						"false" => [["product_id" => "1"],
									["product_id" => ""],
									[]]];
private $delivery_info = null;

private $create_delivery = ["true" => [["name" => "Name",
				"phone" => "123456789",
				"product_id" => "16",
				"quantity" => 4,
				"destination" => "ул. street 19",
				"date_delivery" => "2020-10-21"],
				["name" => "Name2",
				"phone" => "123456789",
				"product_id" => "14",
				"destination" => "ул. street 19",
				"date_delivery" => "2020-10-30"], ["name" => "Name3",
				"phone" => "123456789",
				"product_id" => "15",
				"destination" => "ул. street 19",
				"date_delivery" => "2020-10-28"], ["name" => "Name4",
				"phone" => "123456789",
				"product_id" => "16",
				"destination" => "ул. street 19",
				"date_delivery" => "2020-10-21"]],
				"false" => [["name" => "Name",
				"phone" => "123456789",
				"product_id" => "1",
				"destination" => "ул. street 19",
				"date_delivery" => "2020-07-21"],
				["name" => "Name",
				"phone" => "123456789",
				"product_id" => "14",
				"destination" => "ул. street 19",
				"date_delivery" => "2020-06-21"],
				[]]];



public function __construct()
{
	$this->calc_test();
	$this->create_delivery_test();
	$this->delivery_list();
	$this->info_test($this->delivery_info, false);
	$delivery_info_false = [
		0,
		21534,
		2153214,
		null,
		""
	];
	$this->info_test($delivery_info_false, true);

}

	private $count = 1;
	function calc_test()
	{
			$ch = curl_init($this->delivery);
		foreach ($this->calc_delivery['true'] as $value) {
			$calc_true = json_encode($value);

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HEADER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $calc_true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers['true'][0]);

			try {


				$result = curl_exec($ch);
				echo "=================TEST_" . $this->count . "=====================> OK\n";
				echo $result . "\n";
				sleep(1);
				$this->count++;
			} catch (Exception $e) {
				echo "=================TEST_" . $this->count . "=====================> KO\n";
				echo "error: " . $e . "\n";
			}
		}

		foreach ($this->calc_delivery['false'] as $value) {
			$calc_false = json_encode($value);

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HEADER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $calc_false);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers['true'][0]);

			try {
				$result = curl_exec($ch);
				echo "=================TEST_" . $this->count . "=====================> OK\n";
				echo $result . "\n";
				sleep(1);
				$this->count++;
			} catch (Exception $e) {
				echo "=================TEST_" . $this->count . "=====================> KO\n";
				echo "error: " . $e . "\n";
			}
		}
		curl_close($ch);

	}

	function create_delivery_test()
	{
			$ch = curl_init($this->create);
		foreach ($this->create_delivery['true'] as $value) {
			$create_true = json_encode($value);

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $create_true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers['true'][0]);

			try {
				$result = curl_exec($ch);
				echo "=================TEST_" . $this->count . "=====================> OK\n";
				echo $result . "\n";
				$result = json_decode($result);
				if (empty($result->error))
					$this->delivery_info[] = $result->result->order_id;
				sleep(1);
				$this->count++;
			} catch (Exception $e) {
				echo "=================TEST_" . $this->count . "=====================> KO\n";
				echo "error: " . $e . "\n";
			}
		}

		foreach ($this->create_delivery['false'] as $value) {
			$create_false = json_encode($value);

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HEADER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $create_false);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers['true'][0]);

			try {
				$result = curl_exec($ch);
				echo "=================TEST_" . $this->count . "=====================> OK\n";
				echo $result . "\n";
				sleep(1);
				$this->count++;
			} catch (Exception $e) {
				echo "=================TEST_" . $this->count . "=====================> KO\n";
				echo "error: " . $e . "\n";
			}
		}
		curl_close($ch);

	}
	public function delivery_list()
	{

			$ch = curl_init($this->orders);
		foreach ($this->delivery_list['true'] as $value) {
			$delivery_list_true = json_encode($value);

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $delivery_list_true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers['true'][0]);

			try {
				$result = curl_exec($ch);
				echo "=================TEST_" . $this->count . "=====================> OK\n";
				echo "Интревал времени - ".$value['filter']['since']." / ".$value['filter']['to']."\n";
				echo "Лимит вывода - ".$value['limit']."\n";
				$result = json_decode($result);
				if (empty($result->error))
					foreach ($result->result as $value) {
						print_r($value);
					}

				sleep(1);
				$this->count++;
			} catch
			(Exception $e) {
				echo "=================TEST_" . $this->count . "=====================> KO\n";
				echo "error: " . $e . "\n";
			}
		}


		foreach ($this->delivery_list['false'] as $value) {
			$delivery_list_false = json_encode($value);

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HEADER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $delivery_list_false);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers['true'][0]);

			try {
				$result = curl_exec($ch);
				echo "=================TEST_" . $this->count . "=====================> OK\n";
				echo $result."\n";
				sleep(1);
				$this->count++;
			} catch
			(Exception $e) {
				echo "=================TEST_" . $this->count . "=====================> KO\n";
				echo "error: " . $e . "\n";
			}
		}
		curl_close($ch);

	}

	public function info_test($arg, $header){
			$ch = curl_init($this->info);
		foreach ($arg as $value) {
			$delivery_list = json_encode(["order_id" => $value]);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HEADER, $header);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $delivery_list);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers['true'][0]);

			try {
				$result = curl_exec($ch);
				echo "=================TEST_" . $this->count . "=====================> OK\n";
				if ($header)
					echo $result."\n";
				else{
					echo $result."\n";
				}
				sleep(1);
				$this->count++;
			} catch
			(Exception $e) {
				echo "=================TEST_" . $this->count . "=====================> KO\n";
				echo "error: " . $e . "\n";
			}
		}
		curl_close($ch);

	}

}

new Post();
?>