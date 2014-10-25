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
class ScriptsSearchFromVoidraAction extends AppModel {
	
	public $useTable 		 = false;
	
	// ボイドラサーチのURL　キーワードを後につける
	const SEARCH_URL = "http://gokkoradio.jp/search/cgi-bin/db_kensaku.cgi?table=voice&search=";
	// ボイドラサーチで1ページに表示される最大件数
	const MAX_HIT_COUNT_PER_PAGE = 100;

	// 最小の台本の人数
	const SEARCH_MIN_ACTOR = 2; //2
	// この人数までの台本を検索する
	const SEARCH_MAX_ACTOR = 2; //5;//6;

	// 検索にヒットした件数
	public $hitCount = null;
	// 検索中の人数
	private $searchActorCount = null;
	
	/*
	 * 　台本の配列 データ形式は以下
	 *   array( 
	 * 		[0] => array(
	 * 			"title" 		=> "タイトル",
	 * 			"url" 			=> "http://~",
	 * 			"genre" 		=> "コメディ",
	 * 			"minutes"		=> 20,
	 * 			"actor_count" 	=> 4,
	 * 			"man_count" 	=> 2,
	 * 			"woman_count" 	=> 2,
	 * 			"other_count" 	=> 0
	 *			"is_ignorable"  => FALSE,
	 * 			"is_sequel"     => FALSE,
	 * 			"is_blog"       => FALSE
	 * 			),
	 * 		);
	 */
	public $scripts = array();
	
	/**
	 * 
	 */
	public function exec() {
		// 台本の人数分検索を繰り返す　例：2人〜6人
		for ($n = self::SEARCH_MIN_ACTOR; $n <= self::SEARCH_MAX_ACTOR; $n++) {
debug("{$n}人台本を検索...");			
			$this->searchAllPage($n);				
		}
		
		return $this->scripts;		
	}
	
	/**
	 * 検索結果をすべて $this->scripts に取得
	 *
	 * @param  int   $actorCount
	 * @return array $scripts
	 */
	public function searchAllPage($actorCount) {
		$this->searchActorCount = $actorCount;
// 並列に取得できないか？		
		while (TRUE) {
			// 検索
			$this->search($actorCount, count($this->scripts));
			// 検索件数分を配列に取得できれば終了
			if ($this->hitCount <= count($this->scripts)) {
				break;
			}
		}
	
		return $this->scripts;
	}

	/**
	 * 検索結果のうち、1ページ分だけを $this->scripts に取得
	 * 
	 * @param int $actorCount
	 * @param int $recpoint
	 */
	public function search($actorCount, $recpoint = 0) {
		// キーワードをSJISに変換
		$word = mb_convert_encoding(">計{$actorCount}人", "Shift_JIS");
		// URLを作成
		$url = self::SEARCH_URL . rawurlencode($word) . "&recpoint={$recpoint}";
		
		// 検索結果のHTMLを取得し、UTF-8に変換
		$html = file_get_contents($url, false);
		$html = mb_convert_encoding($html, "UTF-8", "Shift_JIS");
		// 台本を取り出す
		$this->getScriptsFromVoidraHtml($html);
	}
		
	/**
	 * ボイドラサーチの検索結果から台本を取り出す
	 * 
	 * @param unknown $html
	 * @return multitype:
	 */
	private function getScriptsFromVoidraHtml($html) {
		// テーブルの行で分割
		$trs = $this->splitTableToTr($html);
		foreach ($trs as $i => $tr) {
			// 一番最後はスキップ
			if ($i == count($trs) - 1) {
				break;
			}
			// 行から台本を取得
			$script = $this->getScriptFromTr($tr);
						
			array_push($this->scripts, $script);
		}
	}
	
	/**
	 * $script が正しい形式かどうか（台本の情報を取得できているかを判別）
	 * @param unknown $script
	 * @return boolean
	 */
	public function isRightScriptArray($script) {
		if ($script["actor_count"] != $this->searchActorCount) {
			return false;
		}
		
		return true;
	}
	
	/**
	 * <tr>〜</tr>の中から台本の情報を取り出して $script として返す
	 * 
	 * @param unknown $tr
	 * @return multitype:
	 */
	public function getScriptFromTr($tr) {
		// 行を<td></td>の中身に分割
		$tds    = $this->splitTrToTd($tr);
		// 
		$script = $this->getScriptInfoFromTd($tds);
		
		// 正しい形式か？　違ったらエラーを吐く
		if($this->isRightScriptArray($script) == FALSE) {
			debug($tds);
// エラー処理			
		}
		
		return $script;	
	}
	
	/**
	 * テーブルタグを<tr>〜</tr>に分割
	 * 
	 * @param unknown $html
	 * @return multitype:
	 */
	private function splitTableToTr($html) {
		$trs = array();
	
		$splits = explode("<tr", $html);
		foreach ($splits as $i => $split) {
			if ($i < 6) {
				// 検索件数を取得する
				if ($i == 4) {
					$this->getHitCount($split);
				}
				continue;
			}
			$tr = "<tr" . $split;
			// <script>〜</script>を削除
			$tr = preg_replace("/<script[^<]+<\/script>/is", "", $tr);
			array_push($trs, $tr);
		}
	
		return $trs;
	}
	
	/**
	 * 検索件数を $this->hitCount に入れる
	 * 
	 * @param string $str
	 */
	private function getHitCount($str) {
		$ptn = "/検索([\d]+)/s";
		$match_count = preg_match($ptn, $str, $matches);
		if (0 < $match_count) {
			if (isset ($matches[1])) {
				$this->hitCount = (int)$matches[1];
			}
		}
	}
	
	/**
	 * <tr>〜</tr>タグを<td></td>の中身に分割
	 *
	 * @param  string    $html
	 * @return multitype $datas:
	 */
	private function splitTrToTd($html) {
		$tds = array();
		// <td>で分割
		$splits = explode("<td", $html);
		foreach ($splits as $split) {
			$td = "<td" . $split;
			// <a>タグをURLに置き換える
			$ptn = "/https?:\/\/[-_.!~*\()a-zA-Z0-9;\/?:\@&=+\$,%#]+/is";
			$match_count = preg_match($ptn, $td, $matches);
			if (0 < $match_count) {
				$td = $matches[0];
			}
			// タグを削除
			$td = preg_replace("/<[^>]+?>/is", "", $td);

			array_push($tds, $td);
		}	
		
		return $tds;
	}
	
	/**
	 * <td>の配列から台本の情報を取得
	 * 
	 * @param  array $tds
	 * @return array $script
	 */
	private function getScriptInfoFromTd($tds) {
		$script = array();
		
		try {
			$script = array(
					"title" 		=> $tds[1],
					"url" 			=> $tds[4],
					"site_url" 		=> $tds[5],
					"genre" 		=> $tds[6],
					"actor_count" 	=> $this->formatToNumber($tds[10]),
					"man_count" 	=> $this->formatToNumber($tds[7]),
					"woman_count" 	=> $this->formatToNumber($tds[8]),
					"other_count" 	=> $this->formatToNumber($tds[9]),
					"minutes" 		=> $this->formatToNumber($tds[11]),
					//"is_ignorable"  => 0,
					//"is_sequel"     => 0,
					//"is_blog"       => 0
			);
		} catch (Exception $e) {
		}
//debug($script);		
		return $script;
	}
	
	/**
	 * 数字だけを取り出す
	 */
	private function formatToNumber($str) {
		$str = preg_replace("/[^\d]/is", "", $str);
		$num = intval($str);

		return $num;
	}
}
