<?php
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('AppModel', 'Model');
App::uses('TwitterOAuth', 'Vendor/Twitter/');
App::uses('PHPCrawl', 'Vendor/PHPCrawl/libs/');

//App::import("Vendor", "twitter", array("file" => "Twitter/twitteroauth.php"));

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class NicoLivesSearchAction extends AppModel {
	
	public $useTable = false;
	// 何件検索するか
	private $searchCount = 80;

	// 1ページ内の検索件数（固定）
	const SEARCH_COUNT = 40;
	// ニコニコの検索URL	
	const SEARCH_URL = "http://live.nicovideo.jp/search?track=&sort=recent&date=&keyword=%E5%A3%B0%E5%8A%87&filter=%3Aclosed%3A&page=";
	
	// 検索結果のうち、過去の放送の数
	private $pastLiveCount = 0;
	
	// 2次元配列　検索結果の配列 
	// $nicoLives = array(
	// 						array("title" => "タイトル", "lvID" => "lv0102", "desc" => "説明")
	//					);
	private $nicoLives = array();
	
	/**
	 * 
	 */
	public function exec() {
		// 
		$accessCount = ceil($this->searchCount / self::SEARCH_COUNT);
		
		for($i = 0; $i < $accessCount; $i++) {
			$page = $i + 1;
			$url = self::SEARCH_URL . $page;			
			// 検索結果のHTMLを取得
			$html = file_get_contents($url, false);
			// 放送を取り出す
			$this->getNicoLives($html);
		}
				
		//debug($html);
		//debug($this->nicoLives);
		
		return $this->nicoLives;
	}
	
	/**
	 * タイトル、放送ID、説明、日付を抜き出して $this->nicoLivesに入れる
	 * 過去の放送のみを取り出す。
	 * 
	 * @param  String $html
	 */
	private function getNicoLives($html) {
		$titles = $this->getTitles($html);
		$lvIDs  = $this->getLvIds($html);
		$descs  = $this->getDescs($html);
		$dates  = $this->getDates($html);

		for($i = 0; $i < $this->past_live_count; $i++) {
			if ($this->searchCount <= count($this->nicoLives) ) {
				break;
			}
			$live = array();
			$live["title"] = $titles[$i];
			$live["lvID"]  = $lvIDs[$i];
			$live["desc"]  = $descs[$i];
			$live["date"]  = $dates[$i];
			
			array_push($this->nicoLives, $live);
		}
	}
	
	/**
	 * 検索結果から放送タイトルを配列で取り出す
	 * これの件数が過去の放送の数
	 *
	 * @param  String $html
	 * @return $titles タイトルの配列 
	 */
	public function getTitles($html) {
		$titles = array();
		
		$ptn = "/<a[^>]+https?:\/\/[^>]+lv[^>]+?title.+?([^\"]+)\">([^<]+)<\/a/is";
		// ヒット件数が過去の放送の数
		$this->past_live_count = preg_match_all($ptn, $html, $matches, PREG_SET_ORDER);
		foreach ($matches as $i => $match) {
			if (isset($match[1])) {
				array_push($titles, $match[1]);
			}
		}
	
		return $titles;
	}
	
	/**
	 * 検索結果から放送ID（lv○○）を配列で取り出す
	 *
	 * @param  String $html
	 * @return $lvIDs IDの配列 "lv192834"
	 */
	public function getLvIDs($html) {
		$lvIDs = array();
		// 正規表現パターン <p class="search_stream_title">　<a href="http://live.nicovideo.jp/searchresult?v=lv197402897&pp= ...
		$ptn = "/search_stream_title[^<]+?<[^<]+?https?:\/\/live.nicovideo.jp.searchresult.v=(lv[\d]+)/";
		// 抽出
		preg_match_all($ptn, $html, $matches, PREG_SET_ORDER);
		// lv○○の部分だけ取り出す
		foreach ($matches as $i => $match) {
			if (isset($match[1])) {
				array_push($lvIDs, $match[1]);
			}
		}
		
		return $lvIDs;
	}
	
	/**
	 * 検索結果から放送の説明を配列で取り出す
	 *
	 * @param  String $html
	 * @return $descs 説明の配列
	 */
	public function getDescs($html) {
		$descs = array();
		
		$ptn = "/<span[^>]+search_stream_description[^>]+?>([^<]+?)</is";		
		$match_count = preg_match_all($ptn, $html, $matches, PREG_SET_ORDER);
		// lv○○の部分だけ取り出す
		foreach ($matches as $i => $match) {
			if (isset($match[1])) {
				array_push($descs, $match[1]);
			}
		}
	
		return $descs;
	}
	
	/**
	 * 検索結果から開始日時を配列で取り出す
	 * 
	 * @param  String $html
	 * @return $dates 日付文字列の配列 2014/10/21 09:46:00
	 */
	public function getDates($html) {
		$dates = array();
		// <p class="status">2014/10/21(火)09:46 開始	(30分)</p>
		$ptn = "/<p.+?status.+?>[^<]+([\d\/]{10}.+?)[\s]開始[^<]+</is";
		// 抽出
		preg_match_all($ptn, $html, $matches, PREG_SET_ORDER);

		foreach ($matches as $i => $match) {
			if (isset($match[1])) {
				// 日付を 2014/10/21 09:46:00 の形式に変換
				$dateStr = preg_replace("/\(.+\)/", " ", $match[1]);
				$dateStr = preg_replace("/\//", "-", $dateStr);
				$dateStr .= ":00";
				//$ts = strtotime($dateStr);		
				array_push($dates, $dateStr);				
			}
		}
		
		return $dates;
	}
	
}
