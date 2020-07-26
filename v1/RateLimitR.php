<?php
	class RateLimitR{

		private $redis =  null;
		private $maxRequestPerMin = 10;
		private $api = "user_1";

		function __construct()
		{
			$this->redis = new Redis();
			$this->redis->connect('127.0.0.1',6379);


		}

		public function fixWindow() {
			$date_array = getdate();

			if (!($preTime = $this->redis->get($this->api))) {
				$this->redis->set($this->api, 1);
				$this->redis->expire($this->api,60 - $date_array['seconds']);
				return 1;
			}

			if ( $preTime < $this->maxRequestPerMin){
				$this->redis->set($this->api, $preTime + 1);
				$this->redis->expire($this->api,60 - $date_array['seconds']);
				return $preTime + 1;
			}

			return false;


		}

		function fixSlideWindow(){

			if ( !( $date_hashTime = $this->redis->hGetAll($this->api) ) ){
				$this->redis->hSet($this->api, time(), 1);
				$this->redis->expire($this->api,120);
				return 1;
			}

			$preTime = time() - 60;

			$count = 1;
			foreach ($date_hashTime as $key => $value){
				if ($key >= $preTime)
					$count += intval($value);
				else
					$this->redis->hDel($this->api, $key);
			}

			if ( $count <= $this->maxRequestPerMin ){
				$currentHash = $this->redis->hGet($this->api, time() );
				$val = $currentHash == null ? 1 : $currentHash + 1;

				$this->redis->hSet($this->api, time(), $val);
				return $count;
			}

			return false;

		}

	}
