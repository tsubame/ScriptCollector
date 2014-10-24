<?php
App::uses('AppModel', 'Model');
App::uses('TwitterOAuth', 'Vendor/Twitter/');
App::uses('TwistOAuth', 'Vendor/Twitter/');
App::uses('HtmlFetcher', 'Lib');

/**
 * 台本のタイトルでツイート検索を行い、ヒット数を返すクラス
 *
 * @package       app.Model
 */
class ScriptsGetTwCountAction extends AppModel {
	
	public $useTable = false;

	// Consumer key
	const CK = "bZbxqwSNX0ZLklcBCXOd4doQo";
	const CK2 = "h7dcXPCOe60XJHaQk1fagg";
	// Consumer secret
	const CS = "xEJR44BTWfWuret6HIHxow3cGcwjfyUksf56DTNFGRM1YXCYye";
	const CS2 = "RujT9Pp4faiACNLe68O5ByWGnmndADeK3Lt8Og04MY";
	// Access Token
	const AT = "1868721745-9PxesmcO2hpS0AMkHhKA8JZo3s9ozuZ60zpLzF4";
	const AT2 = "1868721745-ZCfXnbsX9WbrjQPV556r70A0BDcKOU81cf2U7zg";
	// Access token secret
	const ATS = "SEH3QqNqUFjt9Nkh73UlXQKF57QxhNVwD4YJ9nvV4ywKF";
	const ATS2 = "KAmNmxGTdHlJxcItf1puBErbmM9rNdAXE4YphOhyJRk";	
	
	private $errorMsgs = array();
	
	/**
	 * 処理実行
	 */
	public function exec() {
		debug("exec.");
		try {
			$to = new TwistOAuth(self::CK, self::CS, self::AT, self::ATS);
			//$to = new TwistOAuth(self::CK2, self::CS2, self::AT2, self::ATS2);
			//
			//$statuses = $to->get('statuses/home_timeline', array('count' => 5));
			$statuses = array();
			$params = array('q' => 'うさみん　ゴール', "count" => 50);
			$result = $to->get('search/tweets', $params);
			debug("test.");
				//debug($result);
			$statuses = $result->statuses;
			debug($result);
			/*
				$params =
				isset($result->search_metadata->next_results) ?
				substr($result->search_metadata->next_results, 1) :
				null
				;
				*/
		} catch (TwistException $e) {		
			// Set error message.
			$error = $e->getMessage();		
			$code = $e->getCode() ?: 500;
			debug($error);
		}
	}

	/**
	 * 
	 */
	public function curlSample($query, $cursor = "") {
		$param = http_build_query(array(
						"f" => "realtime",
						"q" => $query,
						"src" => "typd"
					));
		
		$ch = curl_init();
		curl_setopt_array($ch, array(
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_URL => "https://twitter.com/i/search/timeline?" . $param
			)
		);
		
		$resp = json_decode(curl_exec($ch), true);
		curl_close($ch);
		
		$ptn = '@screen-name="(\w+)".+?data-name="(.+?)".+?src="(.+?)".+?time="(\d+)".+?js-tweet-text.+?>(.+?)</p>@s';
		preg_match_all($ptn, $resp["items_html"], $tweets, PREG_SET_ORDER);
debug(count($tweets) . "件の検索結果");
		//$results = array();
		foreach($tweets as &$entry){
			$entry = array(
					"time" => (int)$entry[4],
					"id"   => $entry[3],
					"name" => $entry[2],
					"text" => preg_replace("@<.+?>@", "", preg_replace("@>(pic\.twitter\.com)@s", ">http://$1", $entry[5]))
			);
		}

		return $tweets;
	}
	
	/**
	 *
	 */
	public function getTweetCount($query) {
		$param = http_build_query(array(
				"f" => "realtime",
				"q" => $query,
				"src" => "typd"
		));
	
		$ch = curl_init();
		curl_setopt_array($ch, array(
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_URL => "https://twitter.com/i/search/timeline?" . $param
			)
		);
	
		$resp = json_decode(curl_exec($ch), true);
		curl_close($ch);
	
		$ptn = '@screen-name="(\w+)".+?data-name="(.+?)".+?src="(.+?)".+?time="(\d+)".+?js-tweet-text.+?>(.+?)</p>@s';
		preg_match_all($ptn, $resp["items_html"], $tweets, PREG_SET_ORDER);

		return count($tweets);
	}
	
	/**
	 * 
	 * @param unknown $words
	 */
	public function searchTweetParallel($words) {
		$searchUrl = "https://twitter.com/i/search/timeline?";
		$urls = array();
		
		foreach ($words as $word) {
			$param = http_build_query(array(
					"f" => "realtime",
					"q" => $word,
					"src" => "typd"
			));
			$url = $searchUrl . $param;
			array_push($urls, $url);
		}
		$fetcher = new HtmlFetcher();
		$results = $fetcher->getDataParallel($urls, 20);
		$errors  = $fetcher->getErrorMsgs();
		$this->errorMsgs = array_merge($this->errorMsgs, $errors);

		$returnTweets = array();
		foreach ($results as $res) {
			$resp = json_decode($res);
			$tweets = $this->getTweetsFromHtml($resp->items_html);

			array_push($returnTweets, $tweets);
		}

		return $returnTweets;
	}
	
	/**
	 * 
	 */
	private function getTweetsFromHtml($html) {
		$ptn = '@screen-name="(\w+)".+?data-name="(.+?)".+?src="(.+?)".+?time="(\d+)".+?js-tweet-text.+?>(.+?)</p>@s';
		preg_match_all($ptn, $html, $tweets, PREG_SET_ORDER);
		//debug(count($tweets) . "件の検索結果");
		//$results = array();
		foreach($tweets as &$entry){
			$entry = array(
					"time" => (int)$entry[4],
					"id"   => $entry[3],
					"name" => $entry[2],
					"text" => preg_replace("@<.+?>@", "", preg_replace("@>(pic\.twitter\.com)@s", ">http://$1", $entry[5]))
			);
		}
		
		return $tweets;
	}
	
	/**
	 * 
	 */
	public function getErrorMsgs() {
		return $this->errorMsgs;
	}
}
