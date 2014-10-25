<?php
App::uses('AppModel', 'Model');
App::uses('TwitterOAuth', 'Vendor/Twitter/');
App::uses('TwistOAuth', 'Vendor/Twitter/');
App::uses('HtmlFetcher', 'Lib');
App::import('Model','Script');

/**
 * 台本のタイトルでツイート検索を行い、テーブルを更新する
 *
 * @package  app.Model
 */
class ScriptsUpdateTwCountAction extends AppModel {
	
	public  $useTable = "scripts";

	// エラーメッセージの配列
	private $errorMsgs = array();
	
// 一度に更新する件数　外に出す
	const UPDATE_COUNT_ONCE = 90;	
	// 並列にアクセスする件数
	const SEARCH_COUNT_ONCE = 20;
	
	// Twitter検索URL
	const SEARCH_URL = "https://twitter.com/i/search/timeline?";
	
	/**
	 * 処理実行
	 */
	public function exec() {		
		// 台本を検索　100件程度　modifiedが古い順
		$model   = new Script();
		$options = array(
			"conditions" => array(
					"is_ignorable = 0",
					"tw_count = 0"
			), 
			"order" => array("modified ASC"),
			"limit" => self::UPDATE_COUNT_ONCE
		);
		$scripts = $model->find("all", $options);
		// 検索用キーワードの配列作成
		$words = array();
		foreach ($scripts as $data) {
			$title = $data["Script"]["title"];
			$word  = "\"{$title}\"　声劇";
			array_push($words, $word);
		}
		// 検索ワードの配列から検索のヒット件数を取得
		$hitCounts = $this->getSearchCountParallel($words);
		
		foreach ($scripts as $i => &$data) {
			$data["Script"]["tw_count"] = $hitCounts[$i];
			$data["Script"]["modified"] = null;
			debug("{$hitCounts[$i]} => {$data['Script']['title']}");
		}
		
//debug($scripts);		
		
		foreach ($scripts as $data) {
			// データの更新
			try {
				$model->save($data);
			} catch (Exception $e) {
				//debug($e->getMessage());
			}
		}
	}

	/**
	 * ツイートを検索し、ヒット件数を返す
	 *
	 * @param  array  $words
	 * @return array  $counts 2次元配列
	 */
	public function getSearchCountParallel($words) {
		$counts = array();
		$searchTweets = $this->searchTweetParallel($words);
		
		foreach ($searchTweets as $tweets) {
			array_push($counts, count($tweets));
		}
	
		return $counts;
	}
	
	/**
	 * ツイートを検索し、2次元配列で返す
	 * 
	 * @param  array  $words
	 * @return array  $results 2次元配列
	 */
	public function searchTweetParallel($words) {
		// 検索URLを配列に取得
		$urls = $this->buildSearchUrls($words);
		
		// twitter検索 並列にアクセス
		$fetcher = new HtmlFetcher();
		$parallelData = $fetcher->getDataParallel($urls, self::SEARCH_COUNT_ONCE);		
		// 取得したHTMLからツイートの配列を取得
		$results = array();
		foreach ($parallelData as $data) {
			$json   = json_decode($data);
			// ツイートのデータを抜き出す
			$tweets = $this->getTweetsFromHtml($json->items_html);
			array_push($results, $tweets);
		}
// ログに書き出すなら不要？↓
		// エラーメッセージ取得
		$errors = $fetcher->getErrorMsgs();
		$this->errorMsgs = array_merge($this->errorMsgs, $errors);

		return $results;
	}
	
	/**
	 * 検索キーワードの配列を受け取って、検索用URLの配列を返す
	 * 
	 * @param  array $words
	 * @return array
	 */
	public function buildSearchUrls($words) {
		$urls = array();
		foreach ($words as $q) {
			$param = http_build_query(array(
				"f"   => "realtime",
				"q"   => $q,
				"src" => "typd"
			));
			$url = self::SEARCH_URL . $param;
			array_push($urls, $url);
		}
		
		return $urls;
	}
	
	/**
	 * 検索結果からtweetのデータを抜き出し、配列で返す
	 * 
	 * @param  string $html
	 * @return array 
	 */
	private function getTweetsFromHtml($html) {
		$ptn = '@screen-name="(\w+)".+?data-name="(.+?)".+?src="(.+?)".+?time="(\d+)".+?js-tweet-text.+?>(.+?)</p>@s';
		preg_match_all($ptn, $html, $tweets, PREG_SET_ORDER);
		//debug(count($tweets) . "件の検索結果");
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
	
}
