<?php
App::uses('ScriptsGetTwCountAction', 'Model');
/**
 * NicoLive Test Case
 *
 */
class ScriptsGetTwCountActionTest extends CakeTestCase {

	/**
	 * Fixtures
	 *
	 * @var array
	 */
	public $fixtures = array(
		//'nico_lives'		
	);
	
	/**
	 * setUp method
	 *
	 * @return void
	 */
	public function setUp() {
		parent::setUp();
		$this->action = ClassRegistry::init('ScriptsGetTwCountAction');
	}

	/**
	 * tearDown method
	 *
	 * @return void
	 */
	public function tearDown() {
		unset($this->action);

		parent::tearDown();
	}
	
	/**
	 * 
	 * 
	 * test
	 */
	public function exec() {	
		$results = $this->action->exec();
	}
	
	/**
	 *
	 *
	 * test
	 */
	public function curlSample() {
		// 
		$q = "クトゥルフ　面白かった";
		// 
		$results = $this->action->curlSample($q);
		//var_dump($results);
		//$json = json_decode($results);
		debug($results);
		$count = count($results);
		debug($count . "件の検索結果");
	}
	
	/**
	 *
	 *
	 * @test
	 */
	public function searchTweetParallel() {		
		//
		$count = 20;
		$words = array();
		for ($i = 0; $i < $count; $i++) {
			array_push($words, "クトゥルフ " . $i);
		}
		
		$titles = array(
				"「今夜も雨が降る」声劇版",
				"ロールプレイングケーキ",
				"今日も平和(カオス)です。",
				"3つの月の物語",
				"5人即興劇(アドリブ)",
				"Arc Jihad(アークジハード)　-守るは望みしモノ-",
				"BAT×BAD",
				"DownDrop-気弱な時、人は惚気る-",
				"ERAIS 最終話 解散",
				"Fight Of Shout！",	
				"Little flavor 「秋」",
				"LunatiC　WaR",
				"Past memories 最終話",
				"Sham Garden　壱の庭『始まり』",
				"「サンタの事情」声劇版",
				"ある小説家の些細な願い事",
				"この世界の中で",
				"箱庭の世界で",
				"その想いチョコのように溶けて",
				"たとえばそれを、不幸と呼んでも。",
				"カーテンコールは永遠に",
				"マチ売りの少女"
		);
		$words = array();
		foreach ($titles as &$title) {
			$word = "\"{$title}\"　声劇";
			array_push($words, $word);
		}
//debug($titles);
		//
		$results = $this->action->searchTweetParallel($words);
		debug(count($results) . "件の検索結果");
		$errors = $this->action->getErrorMsgs();
		debug($errors);
		
		$msgs = array();
		
		foreach ($results as $i => $res) {
			//debug($title .= "　声劇";
			$count = count($res);
			$msg = "{$count}件　{$titles[$i]}";
			array_push($msgs, $msg);
		}
		
		debug($msgs);
	}
	
}
