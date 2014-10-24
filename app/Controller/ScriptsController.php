<?php
App::uses('AppController', 'Controller');
/**
 * Scripts Controller
 *
 * @property Script $Script
 * @property PaginatorComponent $Paginator
 */
class ScriptsController extends AppController {

	/**
	 * Components
	 *
	 * @var array
	 */
	public $components = array('Paginator');

	/**
	 * index method
	 *
	 * @return void
	 */
	public function index() {
		$this->Script->recursive = 0;
		$this->set('scripts', $this->Paginator->paginate());
	}
	
	private $scripts       = array();
	private $blogScripts   = array();
	private $sequelScripts = array();
	
	
	/**
	 * 台本のツイート件数を更新
	 */
	public function updateTwCount() {
		$this->loadModel('ScriptsUpdateTwCountAction');
		$scripts = $this->ScriptsUpdateTwCountAction->exec();
		
		$this->render("index");
	}
	
	/**
	 * 
	 */
	public function searchFromVoidra() {
		$this->loadModel('ScriptsSearchFromVoidraAction');
		$scripts = $this->ScriptsSearchFromVoidraAction->exec();

		foreach($scripts as $script) {
			// 続き物台本かどうかを判別
			$script["is_sequel"] = $this->Script->isSequelTitle($script["title"]);

			// 原作モノなら省く
			if (strpos($script["genre"], "原作") !== FALSE) {
				debug($script["title"] . "は原作モノなので省きました(*´艸｀*)");
				continue;
			}
			
			$data = array();
			$data["Script"] = $script;
			// ユニークな列がエラーになった場合用
			try {
				$this->Script->save($data);
				$this->Script->create();
			} catch (Exception $e) {
		
			}
		}
	}
	
	/**
	 * 
	 */
	public function show() {
		$scripts = array();
		
		$options = array(
				"order" => array("Script.title ASC")
		);
		$results = $this->Script->find("all", $options);
//debug($results);
		
		foreach ($results as $res) {
			array_push($scripts, $res["Script"]);
		}
		
		$this->classifyScripts($scripts);
		
		$this->set("scripts", $results);
		$this->set("scripts", $this->scripts);
		$this->set("blogScripts", $this->blogScripts);
		$this->set("sequelScripts", $this->sequelScripts);
	}
	
	/**
	 * 
	 * @param unknown $scripts
	 */
	private function classifyScripts($scripts) {		
		foreach ($scripts as $script) {
			// ブログかどうかを判別
			if ($this->Script->isBlogURL($script["url"]) == TRUE) {
				array_push($this->blogScripts, $script);
			// 続き物かどうかを判別
			} elseif ($script["is_sequel"] == TRUE) {
				$script["common_title"] = $this->Script->getCommonTitle($script["title"]);
				// 続き物台本の先頭かどうかを判別
				$script["is_first_script"] = $this->Script->isSequelFirstTitle($script["title"]);
				array_push($this->sequelScripts, $script);
			// それ以外
			} else {
				array_push($this->scripts, $script);
			}
		}
	}
	
}
