<?php
App::uses('AppModel', 'Model');
/**
 * Script Model
 *
 */
class Script extends AppModel {

	// 以下のキーワードが正規表現でヒットすれば続き物とみなす
	private $sequelWords = array ("第.+(話|章|回|幕)", "[\d]+話", "(前|中|後|序)(編|章)", "プロローグ", "エピローグ", "最終", "[\(（][\d\s]+[\)）]", "[♯#][\d]+",
				"(その|エピソード|episode|ep|CHAPTER)[\d\s\.]+", "[\d]+[\s　]*$", "[\d一ニ二三四五六七八九十百零千\s]+(話|章)", "(第|その)[一ニ三四五六七八九十百零千\d\s]+");
		
	/**
	 * 台本の人数で検索
	 * 
	 * @param  int   検索人数
	 * @return array $scripts $scriptの配列
	 */
	public function findByActorCount($n) {
		$options = array(
				"conditions" => array(
						"actor_count = {$n}",
						"is_ignorable = 0",
						"tw_count    != 0"
						),
				"order" => array("tw_count DESC")
		);
		debug($options);		
		$results = $this->find("all", $options);
//debug($results);		
		$scripts = array();
		foreach ($results as $data) {
			array_push($scripts, $data["Script"]);
		}
		
		return $scripts;
	}

	/**
	 * 台本取得時に足りない情報を補う
	 * "is_blog"、"is_sequel"、"is_ignorable"にそれぞれ値をセット
	 * 
	 * "is_ignorable" を TRUE にする条件
	 * 　・ブログ台本である
	 * 　・続き物台本であり、1話でない
	 * 　・ジャンルに"原作"が含まれる
	 * 
	 * @param  array $script
	 * @return array
	 */
	public function supplyOtherInfo($script) {
		// 続き物台本か
		if ($this->isSequelTitle($script["title"]) == TRUE) {
			$script["is_sequel"] = 1;
			// 続き物台本の1話か
			if ($this->isSequelFirstTitle($script["title"]) != TRUE) {
				$script["is_ignorable"] = 1;
				//debug($script["title"] . "は続き物の2話以降なので無視");
			}
		} 
		// ブログ台本か
		if ($this->isBlogUrl($script["url"]) == TRUE) {
			$script["is_blog"]      = 1;
			$script["is_ignorable"] = 1;
			//debug($script["title"] . "はブログ台本なので無視");
		}
		
		// 原作モノか
		if (strpos($script["org_genre"], "原作") !== FALSE) {
			$script["is_ignorable"] = 1;
			//debug($script["title"] . "は原作モノなので無視");
		}	
		// ジャンルの振り分け
		$script["genre"] = $this->getGenreFromOrgGenre($script["org_genre"]);
		
		return $script;
	}
	
	/**
	 * タイトルが続き物台本かどうか
	 * 
	 * @param  string $title
	 * @return boolean
	 */
	public function isSequelTitle($title) {
		// 全角英数字を半角に
		$title = mb_convert_kana($title, "a", "UTF-8");

		foreach ($this->sequelWords as $word) {
			$ptn = "/{$word}/is";
			if (0 < preg_match($ptn, $title)) {
				//debug("続き物： {$title}");
				//debug("{$ptn}がヒットしました！");
				return true;
			}
		}
		
		return false;
	}
	
	/**
	 * 続き物台本の共通タイトルを取り出す
	 *
	 * @param  string $title
	 * @return string $commonTitle
	 */
	public function getCommonTitle($title) {
		// 全角英数字を半角に
		$title = mb_convert_kana($title, "a", "UTF-8");
// バグあり 〜など上手く省けない		
		// 台本の最後に以下の文字がくっついていたら省く
		$trimCharPtn = "[\s　・「、\*\-:：\(]";
		
		foreach ($this->sequelWords as $word) {
			$ptn = "/(.+?){$trimCharPtn}*{$word}/is";
			if (0 < preg_match($ptn, $title, $matches)) {
				//debug($matches[1]);
								
				return $matches[1];
			}
		}
	
		return $title;
	}
	
	/**
	 * 続き物台本の1話かどうか
	 *
	 * @param  string  $title
	 * @return boolean
	 */
	public function isSequelFirstTitle($title) {
		// 全角英数字を半角に
		$title = mb_convert_kana($title, "a", "UTF-8");
		
		// 以下のキーワードがヒットすれば1話ではない
		$notFirstWords = array("[後中]編",
				"最終",
				"エピローグ",
				"(ニ|二|三|四|五|六|七|八|九|十).*話", 
				"[^\d][2-9][話|部|章]",
				"[\d\.]1[話|部|章]",
				"(その|エピソード|episode|ep|CHAPTER)0*[2-9]",
				"(その|エピソード|episode|ep|CHAPTER)0*[1-9]+[\d]+",
				"(ニ|二|三|四|五|六|七|八|九|十){1}章*"				
		);	
		foreach ($notFirstWords as $word) {
			$ptn = "/{$word}/is";
			if (0 < preg_match($ptn, $title)) {
				//debug("続き物： {$title}");
				//debug("　　　　{$ptn}がヒットしました！");
				return false;
			}
		}
		// 以下のキーワードがヒットすれば1話とみなす
		$firstWords = array("前編", "序章", "プロローグ", "[^1-9]1話", "一話", "第*[一ー1]+[章話回]", "[^\d]+1[\s　]*$", "[\(（]0*1[\)）]",
				//"(第|その){0,}(0|零){0, }(1|一|壱|序|前){1, }(話|章|回|幕|編){0, }", "[^\d]+1[\s　]*$", 
				"(その|エピソード|episode|ep|CHAPTER)0*1[^\d]*[\s]*"
		);
		
		foreach ($firstWords as $word) {
			$ptn = "/{$word}/is";
			if (0 < preg_match($ptn, $title, $matches)) {
				//debug("　 {$title}");
				//debug("　　　　{$ptn}がヒットしました！ 初回です");
				//debug($matches);
				return true;
			}
		}
		if ($this->isSequelTitle($title) == FALSE) {
			return false;
		}
	
		return false;
	}

	/**
	 * URLがブログかどうか
	 * 
	 * @param unknown $url
	 * @return boolean
	 */
	public function isBlogUrl($url) {
		$keywords = array("blog", "ameblo");
		
		foreach ($keywords as $word) {
			if (strpos($url, $word) !== FALSE) {
				return true;
			}
		}
		
		return false;
	}
	

	/**
	 * 
	 * @param  unknown $title
	 * @return boolean
	 */
	public function isShortWord($title) {
		// 文字数が4文字以下ならtrue
		if (mb_strlen($title) <= 4) {
			return true;
		}
		// 英語の場合一つの単語か？
		if (preg_match("/^[a-zA-Z]+$/", $title)) {
			if (strlen($title) <= 8) {
				return true;
			}
		} 
		
		return false;
	}
	
	/**
	 * ジャンルの振り分け
	 */
	public function getGenreFromOrgGenre($orgGenre) {
		if (strpos($orgGenre, "コメディ") !== FALSE) {
			return "コメディ";
		}		
		if (strpos($orgGenre, "ラブストーリー") !== FALSE) {
			return "恋愛";
		}
		if (strpos($orgGenre, "18禁")    !== FALSE) {
			return "R-18";
		}
		if (strpos($orgGenre, "BL") !== FALSE) {
			return "BL";
		}	
		if (strpos($orgGenre, "シリアス") !== FALSE) {
			return "シリアス";
		}
		
		return "シリアス";
	}
	
}
