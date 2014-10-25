<?php
App::uses('Script', 'Model');

/**
 * Script Test Case
 *
 */
class ScriptTest extends CakeTestCase {

	/**
	 * Fixtures
	 *
	 * @var array
	 */
	public $fixtures = array(
		'app.script'
	);

	/**
	 * setUp method
	 *
	 * @return void
	 */
	public function setUp() {
		parent::setUp();
		$this->Script = ClassRegistry::init('Script');
	}

	/**
	 * tearDown method
	 *
	 * @return void
	 */
	public function tearDown() {
		unset($this->Script);

		parent::tearDown();
	}
	
	
	
	/**
	 * タイトルが続き物台本かどうか
	 * @test
	 */
	public function isSequelTitle() {
		$seqTitles   = array(
				"メタモルフォーゼ　序章（その２）",
				"大気感戦ウェイブリンクス 最終話",
				"平安声劇草子、第一章　後編",
				"不散の椿　二章　合縁奇縁　二話　北の頂上",
				"ちぇりー☆ぼぉいに愛の手を！ 第１話",
				"ちぇりー☆ぼぉいに愛の手を！ 第1話",
				"ワンダバスタイル(第1話)",
				"ヴァンデ戦争　1話　戦いの始まり",
				"美女と野獣第1回",
				"跳ね回る風の下で　その2『好きにすればいいんじゃないの』",
				"風のシルヴィア（３）〜そよ風と豚と白狼と〜",
				"三騎士英雄譚〜第十六章",
				"美女と野獣　序章",
				"美女と野獣 前編",
				"美女と野獣 2",
				"電脳都市−Shangri_La-　５章"
		);
		$otherTitles = array(
				"美女と野獣",
				"Football mania",
				"ちぇりー☆ぼぉいに愛の手を",
				"ヴァンデ戦争",
				"空き巣注意"
		);
		
		//debug("続き物");
		foreach ($seqTitles as $title) {
			$res = $this->Script->isSequelTitle($title);
			//debug("{$title}");
			$this->assertTrue($res);
		}
		foreach ($otherTitles as $title) {
			$res = $this->Script->isSequelTitle($title);
			$this->assertFalse($res);
		}
	}

	/**
	 * 続き物台本の共通タイトルを取り出す
	 * @test
	 */
	public function getCommonTitle() {
		$seqTitles   = array(
				"いぬかぜ２",
				"ナイトソルジャーEpisode21",
				"スファレライトepisode1≪目覚めた石≫",
				"柘榴の果実ｅｐ２　再出",
				"平安声劇草子、第一章　後編",
				"ウサギと兎4",
				"ココ夏−第１話−",
				"シューティングマスター「第12話〜捕獲〜」",
				"カナリアの森 第１話「Loneliness」",
				"ちぇりー☆ぼぉいに愛の手を！ 第１話",
				"ちぇりー☆ぼぉいに愛の手を！ 第1話",
				"ワンダバスタイル(第1話)",
				"ヴァンデ戦争　1話　戦いの始まり",
				"美女と野獣第1回",
				"跳ね回る風の下で　その2『好きにすればいいんじゃないの』",
				"風のシルヴィア（３）〜そよ風と豚と白狼と〜",
				"三騎士英雄譚〜第十六章",
				"美女と野獣　序章",
				"美女と野獣 前編",
				"美女と野獣 2"
		);
		$otherTitles = array(
				"美女と野獣",
				"Football mania",
				"ちぇりー☆ぼぉいに愛の手を",
				"ヴァンデ戦争",
				"空き巣注意"
		);
	
		//debug("続き物");
		foreach ($seqTitles as $title) {
			$res = $this->Script->getCommonTitle($title);
			//debug($res);
			//debug("　　{$title}");
			//$this->assertNotEquals($res, $res);
		}
		foreach ($otherTitles as $title) {
			$res = $this->Script->isSequelTitle($title);
			//$this->assertEquals($res, $res);		
		}
	}
	
	/**
	 * 続き物台本の最初のタイトルかどうか
	 * @test
	 */
	public function isSequelFirstTitle() {
		$seqTitles   = array(
				"いぬかぜ１",
				"ナイトソルジャーEpisode01",
				"スファレライトepisode1≪目覚めた石≫",
				"柘榴の果実ｅｐ０１　再出",
				"平安声劇草子、第一章　前編",
				"ウサギと兎1",
				"ココ夏−第１話−",
				"シューティングマスター「第1話〜捕獲〜」",
				"カナリアの森 第１話「Loneliness」",
				"ちぇりー☆ぼぉいに愛の手を！ 第１話",
				"ちぇりー☆ぼぉいに愛の手を！ 第1話",
				"ワンダバスタイル(第1話)",
				"ヴァンデ戦争　1話　戦いの始まり",
				"美女と野獣第1回",
				"跳ね回る風の下で　その1『好きにすればいいんじゃないの』",
				"風のシルヴィア（１）〜そよ風と豚と白狼と〜",
				"三騎士英雄譚〜第一章",
				"美女と野獣　序章",
				"美女と野獣 前編",
				"美女と野獣 1"
		);
		$otherTitles = array(
				"カナリアの森 エピローグ",
				"メタモルフォーゼ　序章（その２）",
				"夢現　最終話",
				"平安声劇草子、第二章　前編", 
				"euforia〜幸せの国〜第一章第六話愛のために",
				"アンダンテ・クエスト Episode10",
				"シューティングマスター「第21話〜カーラ?〜」",
				"ファミコンクイーンあすか第２部第101話「インパクト！」",
				"Mellow(メロウ)〜海面に咲く華〜 第三話「兄妹DE保健室」",
				"美女と野獣",
				"Football mania",
				"ちぇりー☆ぼぉいに愛の手を",
				"ヴァンデ戦争",
				"空き巣注意",
				"いぬかぜ２",
				"ナイトソルジャーEpisode21",
				"スファレライトepisode2≪目覚めた石≫",
				"柘榴の果実ｅｐ２　再出",
				"平安声劇草子、第一章　後編",
				"ウサギと兎4",
				"ココ夏−第２話−",
				"シューティングマスター「第12話〜捕獲〜」",
				"カナリアの森 第３話「Loneliness」",
				"ちぇりー☆ぼぉいに愛の手を！ 第２話",
				"ちぇりー☆ぼぉいに愛の手を！ 第2話",
				"ワンダバスタイル(第4話)",
				"ヴァンデ戦争　5話　戦いの始まり",
				"美女と野獣第6回",
				"跳ね回る風の下で　その2『好きにすればいいんじゃないの』",
				"風のシルヴィア（３）〜そよ風と豚と白狼と〜",
				"三騎士英雄譚〜第十六章",
				"美女と野獣　断章",
				"美女と野獣 後編",
				"美女と野獣 2"
		);
	
		//debug("続き物");
		foreach ($seqTitles as $title) {
			$res = $this->Script->isSequelFirstTitle($title);
			//debug();
			//debug("{$res}　　{$title}");
			if ($res !== TRUE) {
				debug("　{$title}は初回ではありません");
			}
			$this->assertTrue($res);
		}
		foreach ($otherTitles as $title) {
			$res = $this->Script->isSequelFirstTitle($title);
			//debug("　　{$res}　　{$title}");
			if ($res !== FALSE) {
				debug("　{$title}は初回です");
			}
			$this->assertFalse($res);
		}
	}
}
