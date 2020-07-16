<?php


class Database
{

	private $host = "127.0.0.1";
	private $db_name = "api_db";
	private $username = "root";
	private $password = "root";
	public $link;

	public function getConnection(){

		$this->link = null;

		try {
			$dsn = 'mysql:host='.$this->host.';dbname='.$this->db_name.';charset=utf8';
			$this->link = new PDO($dsn, $this->username, $this->password);
		} catch(PDOException $exception){
			echo "Connection error: " . $exception->getMessage();
		}

		return $this->link;
	}



	public function checkApi($client_id, $api_key){

		$query = "SELECT * FROM `api` WHERE `api-key` = '" . $api_key . "' AND `client-id`= '" . $client_id . "'";

		$stmt = $this->link->prepare( $query );

		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if (!$row){
			http_response_code(400);
			echo json_encode(array("error" => "Неверный 'Client-Id' или 'Api-Key'"), JSON_UNESCAPED_UNICODE);
			die();
		}
		return true;
	}

}