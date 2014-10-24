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
<?php 
debug("上演枠");
foreach($playLives as $live) {
	//debug($nicoLives)
?>
<p>
<h4><a href="http://live.nicovideo.jp/watch/<?= $live["live_id"] ?>" target="_blank"><?= $live["title"] ?></a></h4>
　　　　<?= $live["short_detail"] ?>
</p>
<?php 
}
?>


<?php 
/*
debug("声劇枠ではない");
foreach($nonVoiceDramaLives as $live) {
	//debug($nicoLives)
?>
<p>
<h4><a href="http://live.nicovideo.jp/watch/<?= $live["live_id"] ?>" target="_blank"><?= $live["title"] ?></a></h4>
　　　　<?= $live["short_detail"] ?>
</p>
<?php 
}
*/
?>
<?php 
debug("URLが書いてある枠");
foreach($hasUrlLives as $live) {
	//debug($nicoLives)
?>
<p>
<h4><a href="http://live.nicovideo.jp/watch/<?= $live["live_id"] ?>" target="_blank"><?= $live["title"] ?></a></h4>
　　　　<?= $live["short_detail"] ?>
</p>
<?php 
}
?>
<?php 
debug("それ以外");
foreach($otherLives as $live) {
	//debug($nicoLives)
?>
<p>
<h4><a href="http://live.nicovideo.jp/watch/<?= $live["live_id"] ?>" target="_blank"><?= $live["title"] ?></a></h4>
　　　　<?= $live["short_detail"] ?>
</p>
<?php 
}
?>
<?php 
debug("募集枠");
foreach($recruiteLives as $live) {
	//debug($nicoLives)
?>
<p>
<h4><a href="http://live.nicovideo.jp/watch/<?= $live["live_id"] ?>" target="_blank"><?= $live["title"] ?></a></h4>
　　　　<?= $live["short_detail"] ?>
</p>
<?php 
}
?>
