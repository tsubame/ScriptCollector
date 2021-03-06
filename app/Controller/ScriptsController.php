<?php
App::uses('AppController', 'Controller');
/**
 * Scripts Controller
 *
 * @property Script $Script
 * @property PaginatorComponent $Paginator
 */
class ScriptsController extends AppController {

	private $scripts       = array();
	//private $unuseScripts  = array();
	//private $blogScripts   = array();
	//private $sequelScripts = array();
	private $shortTitleScripts = array();
	
	
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
		
	/**
	 * 
	 */
	public function update() {
		$id = (int) $this->request->data['id'];
		$bool = (bool)$this->request->data['is_ignorable'];
		$is_ignorable = 0;
		
		if ((int)$this->request->data['is_ignorable'] == 1) {
			$is_ignorable = 1;
		} 
		
		$is_ignorable = $this->request->data['is_ignorable'];
	
		$data["Script"] = array(
				"id" => $id,
				"is_ignorable" => $is_ignorable			
		);
		
		// データの更新
		try {
			$this->Script->save($data);
		} catch (Exception $e) {
			debug($e->getMessage());
		}
		
		$this->render("index");
	}
	
	/**
	 * 台本のツイート件数を更新
	 */
	public function updateTwCount() {
		$this->loadModel('ScriptsUpdateTwCountAction');
		$this->ScriptsUpdateTwCountAction->exec();
				
		$this->render("index");
	}
	
	/**
	 * 使わない台本をマークアップする
	 */
	public function markupUnused() {
		$results = $this->Script->find("all");

		foreach ($results as $res) {
			$data["Script"] = $this->Script->supplyOtherInfo($res["Script"]);
			// データの更新
			try {
				$this->Script->save($data);
			} catch (Exception $e) {
				//debug($e->getMessage());
			}
		}		
		//debug($results);
		$this->render("index");
	}
	
	/**
	 * ボイドラサーチから台本を登録
	 */
	public function searchFromVoidra() {
		$this->loadModel('ScriptsSearchFromVoidraAction');
		$scripts = $this->ScriptsSearchFromVoidraAction->exec();
		$insertCount = 0;
		
		foreach($scripts as $script) {
			// 足りない情報を補う
			$script = $this->Script->supplyOtherInfo($script);
			$data   = array( "Script" => $script );
			// データの挿入
			try {
				$this->Script->save($data);
				$this->Script->create();
				$insertCount ++ ;
			} catch (Exception $e) {
				//debug($e->getMessage());
			}
		}
		
		debug($insertCount . "件の台本を登録しました。");
	}
	
	/**
	 * 
	 */
	public function show() {		
		$options = array(
				"order" => array("Script.tw_count DESC, Script.title ASC")
		);
		$results = $this->Script->find("all", $options);

		$scripts = array();
		foreach ($results as $res) {
			array_push($scripts, $res["Script"]);
		}
		
		$this->classifyScripts($scripts);
	}
	
	/**
	 * 
	 * @param unknown $scripts
	 */
	private function classifyScripts($scripts) {	
		foreach ($scripts as $script) {
			if ($script["is_ignorable"] == TRUE) {
				//array_push($this->unuseScripts, $script);
			} else {
				array_push($this->scripts, $script);
				
				// タイトルが短すぎないか判別
				if ($this->Script->isShortWord($script["title"]) == TRUE) {
					array_push($this->shortTitleScripts, $script);
				}
			}		
		}
		
		$this->set("scripts",           $this->scripts);
		//$this->set("unuseScripts",  $this->unuseScripts);
		//$this->set("blogScripts",   $this->blogScripts);
		//$this->set("sequelScripts", $this->sequelScripts);
		$this->set("shortTitleScripts", $this->shortTitleScripts);
	}
	
}
