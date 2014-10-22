<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
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
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class NicoLivesController extends AppController {

	/**
	 * Controller name
	 *
	 * @var string
	 */
	public $name = 'NicoLives';

	/**
	 * This controller does not use a model
	 *
	 * @var array
	 */
	public $uses = array("NicoLive");
	
	
	private $playLives     = array();
	private $recruiteLives = array();
	private $hasUrlLives   = array();
	private $nonVoiceDramaLives = array();
	private $otherLives    = array();
	
	private $nonPlayLives  = array();
	
	/**
	 * 
	 */
	public function search() {
		$this->loadModel('NicoLivesSearchAction');
		$nicoLives = $this->NicoLivesSearchAction->exec();
// カラム名と連想配列のキーを合わせる		
		// DBに保存
		foreach($nicoLives as $nicoLive) {
			$data = array();
			$data["NicoLive"] = array(
					"live_id" => $nicoLive["lvID"],
					"title" => $nicoLive["title"],
					"short_detail" => $nicoLive["desc"],
					"date" => $nicoLive["date"]							
			);
			// ユニークな列がエラーになった場合用
			try {
				$this->NicoLive->save($data);
				$this->NicoLive->create();
			} catch (Exception $e) {
				
			}
		}
	}
	
	/**
	 * 
	 */
	public function show() {
		$results = $this->NicoLive->find("all");
		$lives = array();
		foreach ($results as $res) {
			array_push($lives, $res["NicoLive"]);
		}
		
		$this->classifyLives($lives);
		
		$this->set("nicoLives",    $lives);
		$this->set("playLives",    $this->playLives);
		$this->set("hasUrlLives",  $this->hasUrlLives);
		$this->set("recruiteLives", $this->recruiteLives);
		$this->set("nonVoiceDramaLives", $this->nonVoiceDramaLives);
		$this->set("otherLives",   $this->otherLives);

		$this->set("nonPlayLives", $this->nonPlayLives);
	}
	
	/**
	 * 3種類に振り分け
	 * 上演枠
	 * 明らかに上演枠ではないもの
	 * それ以外
	 */
	private function classifyLives($lives) {		
		// 上演枠を取り出す
		foreach ($lives as $live) {
			// 明らかに声劇枠ではないものを取り出す
			if ($this->isNonVoiceDramaLive($live) == true) {
				array_push($this->nonVoiceDramaLives, $live);
			// 募集枠を取り出す
			} elseif ($this->isRecruiteLive($live) == true) {
				array_push($this->recruiteLives, $live);
			// 上演枠を取り出す
			} elseif ($this->isPlayLive($live) == true) {
				array_push($this->playLives, $live);
			// URLの書いてある枠を取り出す
			} elseif ($this->isUrlLive($live) == true) {
				array_push($this->hasUrlLives, $live);
			} else {
				array_push($this->otherLives, $live);
			}
		}		
	}
	
	/**
	 * タイトルに上演とあればtrue
	 * 
	 * @param  array $live
	 * @return bool
	 */
	private function isPlayLive($live) {
		$keywords = array("上演");
		
		foreach ($keywords as $word) {
			if (strpos($live["title"], $word) !== FALSE) {
				return true;
			}
		}
		
		return false;
	}
	
	/**
	 * 募集枠ならtrueを返す
	 * ・タイトルに"募集"
	 * @param  array $live
	 * @return bool
	 */
	private function isRecruiteLive($live) {
		$keywords = array("募集");
	
		foreach ($keywords as $word) {
			if (strpos($live["title"], $word) !== FALSE) {
				return true;
			}
		}
	
		return false;
	}
	
	/**
	 * 詳細にURLがあればtrueを返す
	 * 
	 * @param  array $live
	 * @return bool
	 */
	private function isUrlLive($live) {
		$ptn = "/https?(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)/";
		if (0 < preg_match($ptn, $live["short_detail"])) {
			return true;
		}
	
		return false;
	}
	
	/**
	 * 以下の場合に上演枠以外とみなす
	 * ・タイトルに"募集"
	 * @param  array $live
	 * @return bool
	 */
	private function isNonPlayLive($live) {
		$keywords = array("募集");
		
		foreach ($keywords as $word) {
			if (strpos($live["title"], $word) !== FALSE) {
				return true;
			}
		}
		
		return false;
	}
	
	/**
	 * 声劇枠ではないならtrueを返す
	 * ・タイトルに"声劇"の文字がない
	 * ・タイトルに"誘導"の文字がある
	 * @param  array $live
	 * @return bool
	 */
	private function isNonVoiceDramaLive($live) {
		// タイトルに"誘導"が入っていればtrueを返す
		if (strpos($live["title"], "誘導") !== FALSE) {
			return true;
		}
		// タイトルに"声劇"が入っていればfalseを返す
		if (strpos($live["title"], "声劇") !== FALSE) {
			return false;
		}

		/*
		// 詳細に"声劇"が入っていればfalseを返す
		if (strpos($live["short_detail"], "声劇") !== FALSE) {
			return false;
		}*/
	
		return true;
	}

	
	/**
	 *
	 */
	public function test() {
		
		$this->loadModel('ScriptCrawler');
		$url = "http://yahoo.co.jp/";
		$url = "http://live.nicovideo.jp/search?track=&sort=point&date=&keyword=%E5%A3%B0%E5%8A%87";
		//$url = "http://live.nicovideo.jp/search?track=&sort=point&date=&keyword=%E5%A3%B0%E5%8A%87&filter=+:onair:";
		set_time_limit(10000);
		$res = file_get_contents($url, false);
		debug($res);

	}

/**
 * Displays a view
 *
 * @param mixed What page to display
 * @return void
 */
	public function display() {
		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			return $this->redirect('/');
		}
		$page = $subpage = $title_for_layout = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title_for_layout = Inflector::humanize($path[$count - 1]);
		}
		$this->set(compact('page', 'subpage', 'title_for_layout'));
		$this->render(implode('/', $path));
	}
}
