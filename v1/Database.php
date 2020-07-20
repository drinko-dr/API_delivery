<?php
define(CONFIG, include 'config.php');

class Database
{


	private $host = CONFIG['host'];
	private $database = CONFIG["database"];
	private $user = CONFIG["user"];
	private $password = CONFIG["password"];
	public $connection;

	public function getConnection(){

		$this->connection = null;

		$this->connection = pg_connect("host=$this->host dbname=$this->database user=$this->user password=$this->password")
		or die("Failed to create connection to database: ". pg_last_error(). "\n");

		return $this->connection;
	}



	public function checkApi($client_id, $api_key){

		$query = "SELECT * FROM api WHERE api_key = '" . $api_key . "' AND client_id= '" . $client_id . "'";

		$result = pg_query($this->connection, $query);

		$result = pg_fetch_assoc($result);

		if (!$result){
			http_response_code(400);
			echo json_encode(array("error" => "Неверный 'Client-Id' или 'Api-Key'"), JSON_UNESCAPED_UNICODE);
			die();
		}
		return true;
	}

}