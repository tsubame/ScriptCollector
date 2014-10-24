<?php
App::uses('ScriptsSearchAction', 'Model');
App::uses('ScriptsSearchActionFixture', 'Test/Fixture');
/**
 * NicoLive Test Case
 *
 */
class ScriptsSearchFromVoidraActionTest extends CakeTestCase {

	// テスト用HTML
	private $sampleHtml = "";
	
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
		$this->action = ClassRegistry::init('ScriptsSearchFromVoidraAction');
		//$this->fixture = ClassRegistry::init('ScriptsSearchActionFixture');
		//$this->action = new ScriptsSearchAction();

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
	 * exec() 正常系
	 * @test
	 */
	public function exec() {
		$results = $this->action->exec();
		//debug($results);
		// 配列の件数が1以上である
		$this->assertNotEquals(count($results), 0);
		/*
		// 配列の各キーに値がセットされている
		foreach ($results as $script) {
			$this->assertTrue( isset($script["title"]) );
			$this->assertTrue( isset($script["url"]) );
			$this->assertTrue( isset($script["actor_count"]) );
			$this->assertTrue( isset($script["man_count"]) );
			$this->assertTrue( isset($script["woman_count"]) );
		}*/
		
		debug($results);
		debug("{$this->action->hitCount}件数ヒット");
		$this->assertEquals(count($results), $this->action->hitCount);
		$this->assertNotEquals(count($results), 0);
	}
	
	/**
	 * search
	 * @test
	 */
	public function search() {
		/*
		$n = 9;
		$results = $this->action->search($n);
		debug($results);
		debug("{$this->action->hitCount}件数ヒット");
		$this->assertNotEquals(count($results), 0);*/
	}
	
	/**
	 * searchAllPage
	 * test
	 */
	public function searchAllPage() {
		$n = 2;
		$results = $this->action->searchAllPage($n);
		debug($results);
		debug("{$this->action->hitCount}件数ヒット");
		$this->assertNotEquals(count($results), 0);
	}
	
	/**
	 * sample コピペ用
	 * @test
	 */
	public function testSample() {
		$n = 4;
		//$results = $this->action->searchVoidra($n);
		//debug($results);
		//$this->assertNotEquals(count($results), 0);
	}
	
	
	
	
}
