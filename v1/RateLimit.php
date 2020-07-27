<?php
	class RateLimit{

		private $redis =  null;

		function __construct()
		{
			$this->redis = new Redis();
			$this->redis->connect('127.0.0.1',6379);
		}

		/**
		 * Ограничение запросов в минуту
		 * При переполнении возвращает false иначе колличество пройденных запросов
		 * @param $api
		 * @param $maxRequestPerMin
		 * @return bool|int
		 */

		function fixSlideWindow($api, $maxRequestPerMin){

			if ( !( $date_hashTime = $this->redis->hGetAll($api) ) ){
				$this->redis->hSet($api, time(), 1);
				$this->redis->expire($api,120);
				return 1;
			}

			$preTime = time() - 60;

			$count = 1;
			foreach ($date_hashTime as $key => $value){
				if ($key >= $preTime)
					$count += intval($value);
				else
					$this->redis->hDel($api, $key);
			}

			if ( $count <= $maxRequestPerMin ){
				$currentHash = $this->redis->hGet($api, time() );
				$val = $currentHash == null ? 1 : $currentHash + 1;

				$this->redis->hSet($api, time(), $val);
				return $count;
			}

			return $maxRequestPerMin;

		}

	}
