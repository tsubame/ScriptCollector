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
	/*
	public $consumer_key = " bZbxqwSNX0ZLklcBCXOd4doQo";
	public $consumer_secret = "xEJR44BTWfWuret6HIHxow3cGcwjfyUksf56DTNFGRM1YXCYye";
	public $callback_url = "http://kuroneko.info/sc/callback";
	*/
	
	const SEARCH_URL = "http://live.nicovideo.jp/search?orig_filter=+%3Aclosed%3A&sort=recent&date=&keyword=%E5%A3%B0%E5%8A%87";
	
	/**
	 * 
	 */
	public function exec() {
		//echo "nico live search model.";
		
		// ニコニコから検索
		$html = file_get_contents(self::SEARCH_URL, false);
		debug($html);
		
		// 2次元配列 $lives[0] = array("title" => "タイトル", "lvID" => "lv0102", "desc" => "説明")
		$lives = array();
		// タイトルを取ってくる
		$titlePtn = "/<a[^>]+https?:\/\/[^>]+lv[^>]+?title.+?([^\"]+)\">([^<]+)<\/a/is";
		// ヒット件数が過去の放送の数
		$live_count = preg_match_all($titlePtn, $html, $matches, PREG_SET_ORDER);
		foreach ($matches as $i => $match) {
			$lives[$i]["title"] = $match[1];
		}
		
		// 放送IDだけ抜き出す
		$lvIDPtn = "/https?:\/\/live.nicovideo.jp.searchresult.v=(lv[\d]+)/";
		preg_match_all($lvIDPtn, $html, $matches, PREG_SET_ORDER);
		// 過去の放送だけ取り出す
		$lvIDMatches = array_slice($matches, 0, $live_count * 2);
		$j = 0;
		foreach ($lvIDMatches as $i => $match) {
			if ($i % 2 == 1) {
				continue;
			}
			$lives[$j]["lvID"] = $match[1];
			$j++;
		}		
		// 説明
		$ptn = "/<span[^>]+search_stream_description[^>]+?>([^<]+?)</is";		
		$match_count = preg_match_all($ptn, $html, $matches, PREG_SET_ORDER);
		// 過去の放送だけ取り出す
		$descMatches = array_slice($matches, 0, $live_count);
		foreach ($descMatches as $i => $match) {
			$lives[$i]["desc"] = $match[1];
		}
		// 開始日時
		$ptn = "/<p[^>]+?status[^>]+?>[^\d]+([\d\/]+[^d]+[\d:]+)</is";
		$match_count = preg_match_all($ptn, $html, $matches, PREG_SET_ORDER);
		// 過去の放送だけ取り出す
		$descMatches = array_slice($matches, 0, $live_count);
		foreach ($descMatches as $i => $match) {
			$lives[$i]["desc"] = $match[1];
		}
		
		debug($lives);
	}
	
	/**
	 * 検索結果から開始日時を配列で取り出す
	 * 
	 * @param  String $html
	 * @return $dates
	 */
	public function getStartDates($html) {
		$dates = array();
		// <p class="status">2014/10/21(火)09:46 開始	(30分)</p>
		$ptn = "/<p[^>]+?status[^>]+?>[^\d]+([\d\/]+[^d]+[\d:]+)</is";
		// 抽出
		preg_match_all($ptn, $html, $matches, PREG_SET_ORDER);
		// 
		foreach ($matches as $i => $match) {
			array_push($dates, $match[1]);
		}
		
		return $dates;
	}
	
	public function sample() {
		echo "(　ﾟ∀ﾟ)o彡°おっぱい！おっぱい！";
	}
}
