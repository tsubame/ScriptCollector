
<?php 
//echo $this->Html->script( array( 'inline' => false ) );
echo $this->Html->script(array('jquery-1.11.1.min', 'main'), array('inline'=>false)); 
?>
<br />
<br />
<br />
<table>
<?php 
debug("台本　" . count($scripts) . "件");
foreach($scripts as $script) {
	$word = "\"{$script["title"]}\"　声劇";
	$searchUrl = "https://twitter.com/search?f=realtime&src=typd&q=" . urlencode($word);
?>
	<tr id="tr_<?= $script["id"] ?>">
		<td>
		<?php if($script["is_ignorable"] == FALSE) { ?>
			<input type="checkbox" class="updateCheck" id="updateCheck<?= $script["id"] ?>" name="<?= $script["id"] ?>" checked="checked" />
		<?php } else { ?>
			<input type="checkbox" class="updateCheck" id="updateCheck<?= $script["id"] ?>" name="<?= $script["id"] ?>" />
		<?php } ?>
		</td>
		<td><h4><a href="<?= $searchUrl ?>" target="_blank" id="title<?= $script["id"] ?>" title="<?= $script["title"] ?>"><?= $script["title"] ?></a></h4></td>
		<td><h5><?= $script["actor_count"] ?>人</h5></td>
		<td><h5>♂<?= $script["man_count"] ?>♀<?= $script["woman_count"] ?></h5></td>
		<td><h5><?php 
		 	if (0 < $script["tw_count"] ) {
		 		?><?= $script["tw_count"] ?>件<?php 
		 	} else {
		 		?><?php 
		 	}
		 ?></h5></td>
		<td><h5><a href="<?= urldecode($script["url"]) ?>" target="_blank"><?= urldecode($script["url"]) ?></a></h5></td>
		<td><h5><?= $script["genre"] ?></h5></td>
</tr>
<?php 
}
?>
</table>

<table>
<?php 
debug("タイトルが短い台本　" . count($shortTitleScripts) . "件");
foreach($shortTitleScripts as $script) {
	$word = "\"{$script["title"]}\"　声劇";
	$searchUrl = "https://twitter.com/search?f=realtime&src=typd&q=" . urlencode($word);
?>
	<tr id="short_tr_<?= $script["id"] ?>">
		<td>
		<?php if($script["is_ignorable"] == FALSE) { ?>
			<input type="checkbox" class="updateCheck" name="<?= $script["id"] ?>" checked="checked" />
		<?php } else { ?>
			<input type="checkbox" class="updateCheck" name="<?= $script["id"] ?>" />
		<?php } ?>
		</td>
		<td><h4><a href="<?= $searchUrl ?>" target="_blank" title="<?= $script["title"] ?>"><?= $script["title"] ?></a></h4></td>
		<td><h5><?= $script["actor_count"] ?>人</h5></td>
		<td><h5><?php 
		 	if (0 < $script["tw_count"] ) {
		 		?><?= $script["tw_count"] ?>件<?php 
		 	} else {
		 		?><?php 
		 	}
		 ?></h5></td>
		<td><h5><a href="<?= urldecode($script["url"]) ?>" target="_blank"><?= urldecode($script["url"]) ?></a></h5></td>
				<!--  <td><h5><?= $script["genre"] ?></h5></td> -->
</tr>
<?php 
}
?>
</table>
<?php /* ?>
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