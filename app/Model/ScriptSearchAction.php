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
class ScriptSearchAction extends AppModel {
	
	public $useTable = false;
	
	public $consumer_key = " bZbxqwSNX0ZLklcBCXOd4doQo";
	public $consumer_secret = "xEJR44BTWfWuret6HIHxow3cGcwjfyUksf56DTNFGRM1YXCYye";
	public $callback_url = "http://kuroneko.info/sc/callback";
	
	/**
	 * 
	 */
	public function exec() {
		echo "model.";
		$test = "test";
		$this->TwitterOAuth = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);		
		$keyword = "声劇 nico.ms　上演"; //nico.ms
				
		$this->autoLayout = false;
		$options = array('q' => $keyword, 'count' => '100', 'lang' => 'ja');
		
		$jsonStr = $this->TwitterOAuth->OAuthRequest(
				'https://api.twitter.com/1.1/search/tweets.json',
				'GET',
				$options
		);		
		$jsons = json_decode($jsonStr, true);
			//var_dump($jsons);
		$results = $jsons["statuses"];
		$texts = array();
		$urls  = array();
		$dates = array();
		pr($results);
		
		$skip_words = array("誘導");
		
		foreach ($results as $res) {
			// retweeted_statusがあればスキップ
			if (isset($res["retweeted_status"])) {
				continue;
			}
			// URLがなければカット
			if (isset($res["entities"]["urls"][0]) == false) {
				echo $res["text"];
				continue;
			} else {
				// URLを取り出す
				$url = $res["entities"]["urls"][0]["expanded_url"];
				// #以降をカット
				$url = preg_replace("/#[\d]+:[\d]+/", "", $url);
			}
			
			// 省く条件　誘導　
			// メソッド化
			
			$is_skip = false;
			foreach ($skip_words as $word) {
				if (preg_match("/{$word}/", $res["text"])) {
					//echo "(｀・ω・´)！！！！" . $res["text"];
					$is_skip = true;
				}
			}
			
			if ($is_skip == true) {
				continue;
			}
			
			if (in_array($url, $urls) == false) {	
				array_push($urls, $url);
				array_push($texts, $res["text"]);
				array_push($dates, $res["created_at"]);
			} 
			

		}
		//pr($urls);
		pr($texts);
		pr($dates);
		//$type = gettype($jsonStr);
		//$str = mb_convert_encoding($jsonStr, "UTF-8");
		return null;
	}
	

}
