<?php
/**
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
 * @package       app.View.Pages
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

if (!Configure::read('debug')):
	throw new NotFoundException();
endif;
App::uses('Debugger', 'Utility');
?>
<br />
<br />
<br />
<table>
<?php 
debug("台本　" . count($scripts) . "件");
foreach($scripts as $script) {
	//$script = $data["Script"];
	//debug($nicoLives)
?>
	<tr>
		<td><h4><a href="<?= $script["url"] ?>" target="_blank"><?= $script["title"] ?></a></h4>
		</td>
		<td><h5><?= $script["actor_count"] ?>人</h5></td>
		<td><h5><?php 
		 	if (0 < $script["tw_count"] ) {
		 		?><?= $script["tw_count"] ?>件<?php 
		 	} else {
		 		?><?php 
		 	}
		 ?></h5></td>
		<td><h5><?= urldecode($script["url"]) ?></h5></td>
				<!--  <td><h5><?= $script["genre"] ?></h5></td> -->
</tr>
<?php 
}
?>
</table>

<table>
<?php 
debug("続き物台本");
foreach($sequelScripts as $script) {
	//$script = $data["Script"];
	//debug($nicoLives)
?>
	<tr>
				<td><?php 
		 	if ($script["is_first_script"] == TRUE) {
		 		?>■■■■<?php 
		 	} else {
		 		?><?php 
		 	}
		 ?>　
		 </td><td><h4><a href="<?= $script["url"] ?>" target="_blank"><?= $script["title"] ?></a></h4>
		</td>
		<td><?= $script["common_title"] ?>　</td>
		<td><?= $script["genre"] ?>　</td>
		<td><h5><?= urldecode($script["url"]) ?></h5></td>

		</tr>
<?php 
}
?>
</table>

<table>
<?php 
debug("ブログ台本");
foreach($blogScripts as $script) {
	//$script = $data["Script"];
	//debug($nicoLives)
?>
	<tr>
		<td><h4><a href="<?= $script["url"] ?>" target="_blank"><?= $script["title"] ?></a></h4>
		</td>
		<td><h5><?= $script["url"] ?></h5></td>
</tr>
<?php 
}
?>
</table>

<?php 
/*
debug("声劇枠ではない");
foreach($nonVoiceDramaLives as $cript) {
	//debug($nicoLives)
?>
<p>
<h4><a href="http://live.nicovideo.jp/watch/<?= $cript["live_id"] ?>" target="_blank"><?= $cript["title"] ?></a></h4>
　　　　<?= $cript["short_detail"] ?>
</p>
<?php 
}

?>
<?php 
debug("URLが書いてある枠");
foreach($hasUrlLives as $cript) {
	//debug($nicoLives)
?>
<p>
<h4><a href="http://live.nicovideo.jp/watch/<?= $cript["live_id"] ?>" target="_blank"><?= $cript["title"] ?></a></h4>
　　　　<?= $cript["short_detail"] ?>
</p>
<?php 
}
?>
<?php 
debug("それ以外");
foreach($otherLives as $cript) {
	//debug($nicoLives)
?>
<p>
<h4><a href="http://live.nicovideo.jp/watch/<?= $cript["live_id"] ?>" target="_blank"><?= $cript["title"] ?></a></h4>
　　　　<?= $cript["short_detail"] ?>
</p>
<?php 
}*/
?>