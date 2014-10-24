<?php
App::uses('AppModel', 'Model');
/**
 * Script Model
 *
 */
class Script extends AppModel {

	// 以下のキーワードが正規表現でヒットすれば続き物とみなす
	private $sequelWords = array ("第.+(話|章|回|幕)", "[\d]+話", "(前|中|後|序)(編|章)", "[\(（][\d\s]+[\)）]", "[♯#][\d]+",
				"(その|エピソード|episode|ep|CHAPTER)[\d\s\.]+", "[\d]+[\s　]*$", "[\d一ニ二三四五六七八九十百零千\s]+(話|章)", "(第|その)[一ニ三四五六七八九十百零千\d\s]+");
	
	
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
		if ($this->isSequelTitle($title) == FALSE) {
			return false;
		}
		// 全角英数字を半角に
		$title = mb_convert_kana($title, "a", "UTF-8");
		
		// 以下のキーワードがヒットすれば1話ではない
		$notFirstWords = array("[後中]編", 
				"(ニ|二|三|四|五|六|七|八|九|十).*話", 
				"[^\d][2-9][話|部|章]",
				"[\d\.]1[話|部|章]",
				"(その|エピソード|episode|ep|CHAPTER)0*[1-9]+[\d]+",
				"(ニ|二|三|四|五|六|七|八|九|十){1}章*");
		foreach ($notFirstWords as $word) {
			$ptn = "/{$word}/is";
			if (0 < preg_match($ptn, $title)) {
				//debug("続き物： {$title}");
				//debug("　　　　{$ptn}がヒットしました！");
				return false;
			}
		}
		// 以下のキーワードがヒットすれば1話とみなす
		$firstWords = array("前編", "序章", "[^1-9]1話", "一話", "第*[一ー1]+[章話回]", "[^\d]+1[\s　]*$", "[\(（]0*1[\)）]",
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
	
}
