<?php
App::uses('HtmlFetcher', 'Lib');

/**
 * NicoLive Test Case
 *
 */
class HtmlFetcherTest extends CakeTestCase {
	
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
		$this->fetcher = new HtmlFetcher();
		//$this->fixture = ClassRegistry::init('HtmlFetcherFixture');
		//$this->action = new HtmlFetcher();

	}

	/**
	 * tearDown method
	 *
	 * @return void
	 */
	public function tearDown() {
		unset($this->fetcher);

		parent::tearDown();
	}
	
	/**
	 * getDataParallel 正常系
	 * 
	 * @test
	 */
	public function getDataParallel() {	
		//$results = $this->fetcher->crawlVoidra();
		$urls = array(
				"http://p.booklog.jp/book/14712",
				"http://madheadhatcher.web.fc2.com/tonari.html",
				"http://www1.bbiq.jp/willows2/novel/d-02.html",
				"http://siafjfdaiwiieoe"
		);
		
		$results = $this->fetcher->getDataParallel($urls);
		$errors = $this->fetcher->getErrorMsgs();
		debug(count($results));
		debug($errors);
		//var_dump($results);
	}
	
	/**
	 * test
	 */
	public function execByCake() {
		$url = "http://www.geocities.jp/chaya_mode/daihon/Deleter1.html";	
		$url = "https://api.twitter.com/1.1/search/tweets.json?";
		$param = "q=%23freebandnames&since_id=24012619984051000&max_id=250126199840518145&result_type=mixed&count=4";
		$html = $this->fetcher->execByCake($url . $param);
		
		debug($html);
	}
	
	
	
}
