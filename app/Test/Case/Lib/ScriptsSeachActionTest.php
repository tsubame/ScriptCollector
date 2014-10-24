<?php
App::uses('ScriptsSearchAction', 'Model');
App::uses('ScriptsSearchActionFixture', 'Test/Fixture');
/**
 * NicoLive Test Case
 *
 */
class ScriptsSearchActionTest extends CakeTestCase {

	// テスト用HTML
	private $sampleHtml = <<<EOF

<html>
<head>
<META HTTP-EQUIV="Content-type" CONTENT="text/html; charset=Shift_JIS">
<META HTTP-EQUIV="Content-Style-Type" content="text/css">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<title>テーブル変更がある為このページを直にお気に入り登録しないで下さい。</title>
<STYLE TYPE="text/css">
<!--
.auto      {ime-mode:auto;}
.active    {ime-mode:active;}
.inactive  {ime-mode:inactive;}
.disable   {ime-mode:disabled;}
a:link.hov    {color : blue; text-decoration : none;}
a:visited.hov {color : blue; text-decoration : none;}
a:active.hov  {text-decoration : none;}
a:hover.hov   {color : red;} .cha{font-size:14px;}
-->
</STYLE>
<!--カリン-->
	<script src="js/prototype.js" type="text/javascript"></script>
	<script src="js/starrating.js" type="text/javascript"></script>
<!--カリン-->
</head>
<body background="" bgcolor="#ffffff" text="#000000">
<!-- HeRO DataBase Ver 1.30 <a href="http://www.hero.ne.jp/~db/">Make:HeRO</a> -->
<table width='100%' border='1' cellspacing='1' cellpadding='1' bordercolor='#666666' bgcolor='#ffffff'><tr align='center' valign='middle' bgcolor='#FF603E'><td><table width='100%' height='100%' border='1' cellspacing='2' cellpadding='10' bordercolor='#666666' bgcolor='#FFFFFF' align='center'>  <tr>    <td align='left' valign='center' width='50%'><div align='center'><img src="http://gokkoradio.jp/search/icon_daihonkensaku.gif" width="244" height="90" alt="テーブル変更がある為このページを直にお気に入り登録しないで下さい。"></div><font size='2'><!-- *ここから* -->
<UL>
<LI>リンク登録されている台本やリンク先のWEBサイトの提供する情報の正確性やこれらへのアクセスによって生ずる結果に対して、ボイドラサーチ管理者は責任を負いかねます。
<br> 
<p align="center"><a href="http://jbbs.livedoor.jp/music/8447/"><img border=0 src="http://gokkoradio.jp/search/bana_youbou.gif"></a></p>

</UL>
<!-- *ここまでに記述* -->
</font>    </td>    <td align='center' valign='center' width='50%'><font size='2'></font><table border='1' cellspacing='0' cellpadding='5' bordercolor='#FF603E' bgcolor='#ffffff' style='border-collapse: collapse'><form method='post' action='./db_kensaku.cgi?table=voice&view=L&recpoint=0' enctype='multipart/form-data'>  <tr valign='middle'>    <td width='100' align='center' bgcolor='#FF603E'><font color='#ffffff' size='2'>検索ワード</font></td>    <td width='200'><input type='text' name='SEARCH' size='40' value='　　　　>計10人　　' class='active' maxlength='1024'><input type='hidden' name='MPASS' value=''><input type='hidden' name='MODE' value='search'><input type='hidden' name='RND1' value=''><input type='hidden' name='RND2' value=''> <td width='150' align='center' bgcolor='#FF603E' ><a href='http://gokkoradio.jp/search/kensaku.html'><font size='2' color='#ffffff'>検索画面に戻る
	</font></a></td></tr></table>    </td></tr></form></table>    </td>  </tr></table></td></tr></table><table width='100%' border='0' cellspacing='1' cellpadding='1'><tr><td width='50'><font size='2'><a href='../index.html'>◆HOME◆</a> </font></td><form method='post' action='./db_kensaku.cgi?table=voice&view=L&recpoint=0' enctype='multipart/form-data'><td width='50'><input type='hidden' name='MPASS' value=''><input type='hidden' name='RND1' value=''><input type='hidden' name='RND2' value=''><input type='submit' name='SUBMIT' value='検索解除'></td></form><form method='post' action='./db_kensaku.cgi?table=voice&view=L&recpoint=0' enctype='multipart/form-data'><td width='50'><input type='hidden' name='MPASS' value=''><input type='hidden' name='SEARCH' value='　　　　>計10人　　'><input type='hidden' name='RND1' value=''><input type='hidden' name='RND2' value=''><input type='submit' name='SUBMIT' value='<< Top'></td></form><form method='post' action='./db_kensaku.cgi?table=voice&view=L&recpoint=0' enctype='multipart/form-data'><td width='50'><input type='hidden' name='MPASS' value=''><input type='hidden' name='SEARCH' value='　　　　>計10人　　'><input type='hidden' name='RND1' value=''><input type='hidden' name='RND2' value=''><input type='submit' name='SUBMIT' value='前はなし'></td></form><td width='150' align='center'><font size='2'>( 1-74 / 検索74件 )</font></td><form method='post' action='./db_kensaku.cgi?table=voice&view=L&recpoint=0' enctype='multipart/form-data'><td width='50'><input type='hidden' name='MPASS' value=''><input type='hidden' name='SEARCH' value='　　　　>計10人　　'><input type='hidden' name='RND1' value=''><input type='hidden' name='RND2' value=''><input type='submit' name='SUBMIT' value='次はなし'></td></form><form method='post' action='./db_kensaku.cgi?table=voice&view=L&recpoint=0' enctype='multipart/form-data'><td width='50'><input type='hidden' name='MPASS' value=''><input type='hidden' name='SEARCH' value='　　　　>計10人　　'><input type='hidden' name='RND1' value=''><input type='hidden' name='RND2' value=''><input type='submit' name='SUBMIT' value='Last >>'></td></form><td align='right'><font size='2'></font></td></tr></table><table width='100%' border='1' cellspacing='0' cellpadding='3' bordercolor='#dcdcdc' bgcolor='#ffffff' style='border-collapse: collapse'><tr align='center' valign='middle' bgcolor='#FF603E'><td><font size='2' color='#ffffff'>台本タイトル</font></td><td><font size='2' color='#ffffff'>原作者名</font></td><td><font size='2' color='#ffffff'>台本作者</font></td><td><font size='2' color='#ffffff'>台本</font></td><td><font size='2' color='#ffffff'>ＨＰ</font></td><td><font size='2' color='#ffffff'>ジャンル</font></td><td><font size='2' color='#ffffff'>男</font></td><td><font size='2' color='#ffffff'>女</font></td><td><font size='2' color='#ffffff'>不問</font></td><td><font size='2' color='#ffffff'>総数</font></td><td><font size='2' color='#ffffff'>時間</font></td><td><font size='2' color='#ffffff'>おすすめ度</font></td></tr><tr valign='middle'><td><font size=2>アーマードコア～ラストリンクス（中編）</font></td><td><font size=2>FROMSOFTWARE</font></td><td><font size=2>ひつぎ</font></td><td><font size=2><div align='center'><a href='http://ch.nicovideo.jp/hitsugi/blomaga/ar595534#-' target='_blank'><img src='./img/home.gif' border='0' alt='http://ch.nicovideo.jp/hitsugi/blomaga/ar595534#-'></a></div></font></td><td><font size=2><div align='center'><a href='http://ch.nicovideo.jp/hitsugi' target='_blank'><img src='./img/dhome.gif' border='0' alt='http://ch.nicovideo.jp/hitsugi'></a></div></font></td><td><font size=2>シリアス/ロボット系/原作アニメ･ゲーム/叫びセリフ有</font></td><td><font size=2>>♂5人</font></td><td><font size=2>>♀4人</font></td><td><font size=2>>不問1人</font></td><td><font size=2>>計10人</font></td><td><font size=2>～60分</font></td><td><font size=2>    <div style="width:80px;">
      <img src="img/rate0.png" width="80" height="16" id="starRating0"/>
      <span id="starRatingstr0" style="font-size:xx-small;color:#aaa;padding-top:-8px">(平均:0/0人)</span>
    </div>
	<script language="javascript" type="text/javascript">
	  new Starrating(
	    "starRating0",
	    ["rate1_0.png", "rate2_0.png", "rate3_0.png", "rate4_0.png", "rate5_0.png"], {
	      basePath: "img/",
	      onClick: function (img, rating) {
            if (confirm(rating + "を投票しますか？")) {
              execute("table=voice&view=L&id=14080823275900&score=" + rating, starRating0, 0, 0);
            }
            else {
              
            }
	      }
	    }
	  );
	</script>
</font></td></tr><tr valign='middle'><td><font size=2>アーマードコア～ラストリンクス（前編）</font></td><td><font size=2>FROMSOFTWARE</font></td><td><font size=2>ひつぎ</font></td><td><font size=2><div align='center'><a href='http://ch.nicovideo.jp/hitsugi/blomaga/ar557012' target='_blank'><img src='./img/home.gif' border='0' alt='http://ch.nicovideo.jp/hitsugi/blomaga/ar557012'></a></div></font></td><td><font size=2><div align='center'><a href='http://ch.nicovideo.jp/hitsugi' target='_blank'><img src='./img/dhome.gif' border='0' alt='http://ch.nicovideo.jp/hitsugi'></a></div></font></td><td><font size=2>シリアス/ロボット系/原作アニメ･ゲーム/叫びセリフ有</font></td><td><font size=2>>♂6人</font></td><td><font size=2>>♀3人</font></td><td><font size=2>>不問1人</font></td><td><font size=2>>計10人</font></td><td><font size=2>～60分</font></td><td><font size=2>    <div style="width:80px;">
      <img src="img/rate0.png" width="80" height="16" id="starRating1"/>
      <span id="starRatingstr1" style="font-size:xx-small;color:#aaa;padding-top:-8px">(平均:0/0人)</span>
    </div>
	<script language="javascript" type="text/javascript">
	  new Starrating(
	    "starRating1",
	    ["rate1_0.png", "rate2_0.png", "rate3_0.png", "rate4_0.png", "rate5_0.png"], {
	      basePath: "img/",
	      onClick: function (img, rating) {
            if (confirm(rating + "を投票しますか？")) {
              execute("table=voice&view=L&id=14080800512300&score=" + rating, starRating1, 0, 0);
            }
            else {
              
            }
	      }
	    }
	  );
	</script>
</font></td></tr><tr valign='middle'><td><font size=2>ポケットモンスター第６話</font></td><td><font size=2>日高政光</font></td><td><font size=2>素人A</font></td><td><font size=2><div align='center'><a href='http://suneets.com/uploda/src/file424.txt' target='_blank'><img src='./img/home.gif' border='0' alt='http://suneets.com/uploda/src/file424.txt'></a></div></font></td><td><font size=2><div align='center'><a href='http://' target='_blank'><img src='./img/dhome.gif' border='0' alt='http://'></a></div></font></td><td><font size=2>ファンタジー/原作アニメ･ゲーム</font></td><td><font size=2>>♂4人</font></td><td><font size=2>>♀2人</font></td><td><font size=2>>不問4人</font></td><td><font size=2>>計10人</font></td><td><font size=2>～30分</font></td><td><font size=2>    <div style="width:80px;">
      <img src="img/rate0.png" width="80" height="16" id="starRating2"/>
      <span id="starRatingstr2" style="font-size:xx-small;color:#aaa;padding-top:-8px">(平均:0/0人)</span>
    </div>
	<script language="javascript" type="text/javascript">
	  new Starrating(
	    "starRating2",
	    ["rate1_0.png", "rate2_0.png", "rate3_0.png", "rate4_0.png", "rate5_0.png"], {
	      basePath: "img/",
	      onClick: function (img, rating) {
            if (confirm(rating + "を投票しますか？")) {
              execute("table=voice&view=L&id=14073119591600&score=" + rating, starRating2, 0, 0);
            }
            else {
              
            }
	      }
	    }
	  );
	</script>
</font></td></tr><tr valign='middle'><td><font size=2>【ParasiteNOVA】第三話『目覚め』</font></td><td><font size=2>はやまおう。</font></td><td><font size=2>はやまおう。</font></td><td><font size=2><div align='center'><a href='http://urx.nu/aoJz' target='_blank'><img src='./img/home.gif' border='0' alt='http://urx.nu/aoJz'></a></div></font></td><td><font size=2><div align='center'><a href='http://parasite-nova.jimdo.com/' target='_blank'><img src='./img/dhome.gif' border='0' alt='http://parasite-nova.jimdo.com/'></a></div></font></td><td><font size=2>ファンタジー/オリジナル</font></td><td><font size=2>>♂5人</font></td><td><font size=2>>♀4人</font></td><td><font size=2>>不問1人</font></td><td><font size=2>>計10人</font></td><td><font size=2>～30分</font></td><td><font size=2>    <div style="width:80px;">
      <img src="img/rate0.png" width="80" height="16" id="starRating3"/>
      <span id="starRatingstr3" style="font-size:xx-small;color:#aaa;padding-top:-8px">(平均:0/0人)</span>
    </div>
	<script language="javascript" type="text/javascript">
	  new Starrating(
	    "starRating3",
	    ["rate1_0.png", "rate2_0.png", "rate3_0.png", "rate4_0.png", "rate5_0.png"], {
	      basePath: "img/",
	      onClick: function (img, rating) {
            if (confirm(rating + "を投票しますか？")) {
              execute("table=voice&view=L&id=14072415544300&score=" + rating, starRating3, 0, 0);
            }
            else {
              
            }
	      }
	    }
	  );
	</script>
</font></td></tr><tr valign='middle'><td><font size=2>ナイトソルジャーEpisode44</font></td><td><font size=2>れなし</font></td><td><font size=2>れなし</font></td><td><font size=2><div align='center'><a href='http://makikokkuri.web.fc2.com/daihon/nightsoldier44.html' target='_blank'><img src='./img/home.gif' border='0' alt='http://makikokkuri.web.fc2.com/daihon/nightsoldier44.html'></a></div></font></td><td><font size=2><div align='center'><a href='http://makikokkuri.web.fc2.com/main/nightsoldierseries.html' target='_blank'><img src='./img/dhome.gif' border='0' alt='http://makikokkuri.web.fc2.com/main/nightsoldierseries.html'></a></div></font></td><td><font size=2>シリアス/ファンタジー/オリジナル/叫びセリフ有</font></td><td><font size=2>>♂6人</font></td><td><font size=2>>♀2人</font></td><td><font size=2>>不問2人</font></td><td><font size=2>>計10人</font></td><td><font size=2>～10分</font></td><td><font size=2>    <div style="width:80px;">
      <img src="img/rate0.png" width="80" height="16" id="starRating4"/>
      <span id="starRatingstr4" style="font-size:xx-small;color:#aaa;padding-top:-8px">(平均:0/0人)</span>
    </div>
	<script language="javascript" type="text/javascript">
	  new Starrating(
	    "starRating4",
	    ["rate1_0.png", "rate2_0.png", "rate3_0.png", "rate4_0.png", "rate5_0.png"], {
	      basePath: "img/",
	      onClick: function (img, rating) {
            if (confirm(rating + "を投票しますか？")) {
              execute("table=voice&view=L&id=14062011110100&score=" + rating, starRating4, 0, 0);
            }
            else {
              
            }
	      }
	    }
	  );
	</script>
</font></td></tr><tr valign='middle'><td><font size=2>ナイトソルジャーEpisode34</font></td><td><font size=2>れなし</font></td><td><font size=2>れなし</font></td><td><font size=2><div align='center'><a href='http://makikokkuri.web.fc2.com/daihon/nightsoldier34.html' target='_blank'><img src='./img/home.gif' border='0' alt='http://makikokkuri.web.fc2.com/daihon/nightsoldier34.html'></a></div></font></td><td><font size=2><div align='center'><a href='http://makikokkuri.web.fc2.com/main/nightsoldierseries.html' target='_blank'><img src='./img/dhome.gif' border='0' alt='http://makikokkuri.web.fc2.com/main/nightsoldierseries.html'></a></div></font></td><td><font size=2>シリアス/ファンタジー/オリジナル</font></td><td><font size=2>>♂5人</font></td><td><font size=2>>♀3人</font></td><td><font size=2>>不問2人</font></td><td><font size=2>>計10人</font></td><td><font size=2>～10分</font></td><td><font size=2>    <div style="width:80px;">
      <img src="img/rate0.png" width="80" height="16" id="starRating5"/>
      <span id="starRatingstr5" style="font-size:xx-small;color:#aaa;padding-top:-8px">(平均:0/0人)</span>
    </div>
	<script language="javascript" type="text/javascript">
	  new Starrating(
	    "starRating5",
	    ["rate1_0.png", "rate2_0.png", "rate3_0.png", "rate4_0.png", "rate5_0.png"], {
	      basePath: "img/",
	      onClick: function (img, rating) {
            if (confirm(rating + "を投票しますか？")) {
              execute("table=voice&view=L&id=14062010263800&score=" + rating, starRating5, 0, 0);
            }
            else {
              
            }
	      }
	    }
	  );
	</script>
</font></td></tr><tr valign='middle'><td><font size=2>ナイトソルジャーEpisode28</font></td><td><font size=2>れなし</font></td><td><font size=2>れなし</font></td><td><font size=2><div align='center'><a href='http://makikokkuri.web.fc2.com/daihon/nightsoldier28.html' target='_blank'><img src='./img/home.gif' border='0' alt='http://makikokkuri.web.fc2.com/daihon/nightsoldier28.html'></a></div></font></td><td><font size=2><div align='center'><a href='http://makikokkuri.web.fc2.com/main/nightsoldierseries.html' target='_blank'><img src='./img/dhome.gif' border='0' alt='http://makikokkuri.web.fc2.com/main/nightsoldierseries.html'></a></div></font></td><td><font size=2>コメディー/ファンタジー/オリジナル/叫びセリフ有</font></td><td><font size=2>>♂6人</font></td><td><font size=2>>♀3人</font></td><td><font size=2>>不問1人</font></td><td><font size=2>>計10人</font></td><td><font size=2>～10分</font></td><td><font size=2>    <div style="width:80px;">
      <img src="img/rate0.png" width="80" height="16" id="starRating6"/>
      <span id="starRatingstr6" style="font-size:xx-small;color:#aaa;padding-top:-8px">(平均:0/0人)</span>
    </div>
	<script language="javascript" type="text/javascript">
	  new Starrating(
	    "starRating6",
	    ["rate1_0.png", "rate2_0.png", "rate3_0.png", "rate4_0.png", "rate5_0.png"], {
	      basePath: "img/",
	      onClick: function (img, rating) {
            if (confirm(rating + "を投票しますか？")) {
              execute("table=voice&view=L&id=14062010072400&score=" + rating, starRating6, 0, 0);
            }
            else {
              
            }
	      }
	    }
	  );
	</script>
</font></td></tr><tr valign='middle'><td><font size=2>ナイトソルジャーEpisode27</font></td><td><font size=2>れなし</font></td><td><font size=2>れなし</font></td><td><font size=2><div align='center'><a href='http://makikokkuri.web.fc2.com/daihon/nightsoldier27.html' target='_blank'><img src='./img/home.gif' border='0' alt='http://makikokkuri.web.fc2.com/daihon/nightsoldier27.html'></a></div></font></td><td><font size=2><div align='center'><a href='http://makikokkuri.web.fc2.com/main/nightsoldierseries.html' target='_blank'><img src='./img/dhome.gif' border='0' alt='http://makikokkuri.web.fc2.com/main/nightsoldierseries.html'></a></div></font></td><td><font size=2>コメディー/ファンタジー/オリジナル/叫びセリフ有</font></td><td><font size=2>>♂6人</font></td><td><font size=2>>♀2人</font></td><td><font size=2>>不問2人</font></td><td><font size=2>>計10人</font></td><td><font size=2>～10分</font></td><td><font size=2>    <div style="width:80px;">
      <img src="img/rate0.png" width="80" height="16" id="starRating7"/>
      <span id="starRatingstr7" style="font-size:xx-small;color:#aaa;padding-top:-8px">(平均:0/0人)</span>
    </div>
	<script language="javascript" type="text/javascript">
	  new Starrating(
	    "starRating7",
	    ["rate1_0.png", "rate2_0.png", "rate3_0.png", "rate4_0.png", "rate5_0.png"], {
	      basePath: "img/",
	      onClick: function (img, rating) {
            if (confirm(rating + "を投票しますか？")) {
              execute("table=voice&view=L&id=14062003131500&score=" + rating, starRating7, 0, 0);
            }
            else {
              
            }
	      }
	    }
	  );
	</script>
</font></td></tr><tr valign='middle'><td><font size=2>クリスマス企画</font></td><td><font size=2>花月姫梨</font></td><td><font size=2><img src='./img/omit.gif' alt='花月姫梨　協力者あり' align='top'>花月姫梨　協力者あ..</font></td><td><font size=2><div align='center'><a href='http://connectz.blog.fc2.com/blog-entry-6.html' target='_blank'><img src='./img/home.gif' border='0' alt='http://connectz.blog.fc2.com/blog-entry-6.html'></a></div></font></td><td><font size=2><div align='center'><a href='http://connectz.blog.fc2.com/' target='_blank'><img src='./img/dhome.gif' border='0' alt='http://connectz.blog.fc2.com/'></a></div></font></td><td><font size=2>コメディー</font></td><td><font size=2>>♂4人</font></td><td><font size=2>>♀6人</font></td><td><font size=2>>不問0人</font></td><td><font size=2>>計10人</font></td><td><font size=2>～10分</font></td><td><font size=2>    <div style="width:80px;">
      <img src="img/rate0.png" width="80" height="16" id="starRating8"/>
      <span id="starRatingstr8" style="font-size:xx-small;color:#aaa;padding-top:-8px">(平均:0/0人)</span>
    </div>
	<script language="javascript" type="text/javascript">
	  new Starrating(
	    "starRating8",
	    ["rate1_0.png", "rate2_0.png", "rate3_0.png", "rate4_0.png", "rate5_0.png"], {
	      basePath: "img/",
	      onClick: function (img, rating) {
            if (confirm(rating + "を投票しますか？")) {
              execute("table=voice&view=L&id=14051504373100&score=" + rating, starRating8, 0, 0);
            }
            else {
              
            }
	      }
	    }
	  );
	</script>
</font></td></tr><tr valign='middle'><td><font size=2>梛の木の下で</font></td><td><font size=2>筒赤トニー</font></td><td><font size=2>筒赤トニー</font></td><td><font size=2><div align='center'><a href='http://navylime.blog.fc2.com/blog-entry-10.html' target='_blank'><img src='./img/home.gif' border='0' alt='http://navylime.blog.fc2.com/blog-entry-10.html'></a></div></font></td><td><font size=2><div align='center'><a href='http://navylime.blog.fc2.com/' target='_blank'><img src='./img/dhome.gif' border='0' alt='http://navylime.blog.fc2.com/'></a></div></font></td><td><font size=2>シリアス/ファンタジー/オリジナル</font></td><td><font size=2>>♂8人</font></td><td><font size=2>>♀2人</font></td><td><font size=2>>不問0人</font></td><td><font size=2>>計10人</font></td><td><font size=2>～10分</font></td><td><font size=2>    <div style="width:80px;">
      <img src="img/rate0.png" width="80" height="16" id="starRating9"/>
      <span id="starRatingstr9" style="font-size:xx-small;color:#aaa;padding-top:-8px">(平均:0/0人)</span>
    </div>
	<script language="javascript" type="text/javascript">
	  new Starrating(
	    "starRating9",
	    ["rate1_0.png", "rate2_0.png", "rate3_0.png", "rate4_0.png", "rate5_0.png"], {
	      basePath: "img/",
	      onClick: function (img, rating) {
            if (confirm(rating + "を投票しますか？")) {
              execute("table=voice&view=L&id=14012223045300&score=" + rating, starRating9, 0, 0);
            }
            else {
              
            }
	      }
	    }
	  );
	</script>
</font></td></tr><tr valign='middle'><td><font size=2>10人即興劇(アドリブ)</font></td><td><font size=2>水寝狗雫</font></td><td><font size=2>水寝狗雫</font></td><td><font size=2><div align='center'><a href='http://rangeki.jimdo.com/即興ツール/10人/' target='_blank'><img src='./img/home.gif' border='0' alt='http://rangeki.jimdo.com/即興ツール/10人/'></a></div></font></td><td><font size=2><div align='center'><a href='http://rangeki.jimdo.com/即興ツール/' target='_blank'><img src='./img/dhome.gif' border='0' alt='http://rangeki.jimdo.com/即興ツール/'></a></div></font></td><td><font size=2>その他</font></td><td><font size=2>>♂0人</font></td><td><font size=2>>♀0人</font></td><td><font size=2>>不問10人</font></td><td><font size=2>>計10人</font></td><td><font size=2>～10分</font></td><td><font size=2>    <div style="width:80px;">
      <img src="img/rate0.png" width="80" height="16" id="starRating10"/>
      <span id="starRatingstr10" style="font-size:xx-small;color:#aaa;padding-top:-8px">(平均:0/0人)</span>
    </div>
	<script language="javascript" type="text/javascript">
	  new Starrating(
	    "starRating10",
	    ["rate1_0.png", "rate2_0.png", "rate3_0.png", "rate4_0.png", "rate5_0.png"], {
	      basePath: "img/",
	      onClick: function (img, rating) {
            if (confirm(rating + "を投票しますか？")) {
              execute("table=voice&view=L&id=13111500085200&score=" + rating, starRating10, 0, 0);
            }
            else {
              
            }
	      }
	    }
	  );
	</script>
</font></td></tr><tr valign='middle'><td><font size=2>時をかける少女【2006年アニメ映画版】</font></td><td><font size=2>筒井康隆</font></td><td><font size=2>早川ふう</font></td><td><font size=2><div align='center'><a href='http://milky.geocities.jp/fu_hayakawa_co460815/hanken/tokikake.html' target='_blank'><img src='./img/home.gif' border='0' alt='http://milky.geocities.jp/fu_hayakawa_co460815/hanken/tokikake.html'></a></div></font></td><td><font size=2><div align='center'><a href='http://milky.geocities.jp/fu_hayakawa_co460815/' target='_blank'><img src='./img/dhome.gif' border='0' alt='http://milky.geocities.jp/fu_hayakawa_co460815/'></a></div></font></td><td><font size=2>シリアス/ファンタジー/ラブストーリー/学園もの/感動巨編/原作小説/叫びセリフ有</font></td><td><font size=2>>♂3人</font></td><td><font size=2>>♀6人</font></td><td><font size=2>>不問1人</font></td><td><font size=2>>計10人</font></td><td><font size=2>～110分</font></td><td><font size=2>    <div style="width:80px;">
      <img src="img/rate0.png" width="80" height="16" id="starRating11"/>
      <span id="starRatingstr11" style="font-size:xx-small;color:#aaa;padding-top:-8px">(平均:0/0人)</span>
    </div>
	<script language="javascript" type="text/javascript">
	  new Starrating(
	    "starRating11",
	    ["rate1_0.png", "rate2_0.png", "rate3_0.png", "rate4_0.png", "rate5_0.png"], {
	      basePath: "img/",
	      onClick: function (img, rating) {
            if (confirm(rating + "を投票しますか？")) {
              execute("table=voice&view=L&id=13110322290600&score=" + rating, starRating11, 0, 0);
            }
            else {
              
            }
	      }
	    }
	  );
	</script>
</font></td></tr><tr valign='middle'><td><font size=2>ナイトソルジャーEpisode5</font></td><td><font size=2>狐狗狸☆魔鬼</font></td><td><font size=2>狐狗狸☆魔鬼</font></td><td><font size=2><div align='center'><a href='http://makikokkuri.web.fc2.com/daihon/nightsoldier05.html' target='_blank'><img src='./img/home.gif' border='0' alt='http://makikokkuri.web.fc2.com/daihon/nightsoldier05.html'></a></div></font></td><td><font size=2><div align='center'><a href='http://makikokkuri.web.fc2.com/top.html' target='_blank'><img src='./img/dhome.gif' border='0' alt='http://makikokkuri.web.fc2.com/top.html'></a></div></font></td><td><font size=2>ファンタジー/オリジナル</font></td><td><font size=2>>♂4人</font></td><td><font size=2>>♀5人</font></td><td><font size=2>>不問1人</font></td><td><font size=2>>計10人</font></td><td><font size=2>～10分</font></td><td><font size=2>    <div style="width:80px;">
      <img src="img/rate0.png" width="80" height="16" id="starRating12"/>
      <span id="starRatingstr12" style="font-size:xx-small;color:#aaa;padding-top:-8px">(平均:0/0人)</span>
    </div>
	<script language="javascript" type="text/javascript">
	  new Starrating(
	    "starRating12",
	    ["rate1_0.png", "rate2_0.png", "rate3_0.png", "rate4_0.png", "rate5_0.png"], {
	      basePath: "img/",
	      onClick: function (img, rating) {
            if (confirm(rating + "を投票しますか？")) {
              execute("table=voice&view=L&id=13021118010600&score=" + rating, starRating12, 0, 0);
            }
            else {
              
            }
	      }
	    }
	  );
	</script>
</font></td></tr><tr valign='middle'><td><font size=2>小波学園生徒会１　自己紹介の巻</font></td><td><font size=2>工藤幸人</font></td><td><font size=2>工藤幸人</font></td><td><font size=2><div align='center'><a href='http://ameblo.jp/yukihitopigg/entry-11417771592.html' target='_blank'><img src='./img/home.gif' border='0' alt='http://ameblo.jp/yukihitopigg/entry-11417771592.html'></a></div></font></td><td><font size=2><div align='center'><a href='http://ameblo.jp/yukihitopigg/' target='_blank'><img src='./img/dhome.gif' border='0' alt='http://ameblo.jp/yukihitopigg/'></a></div></font></td><td><font size=2>コメディー/学園もの</font></td><td><font size=2>>♂6人</font></td><td><font size=2>>♀4人</font></td><td><font size=2>>不問0人</font></td><td><font size=2>>計10人</font></td><td><font size=2>～20分</font></td><td><font size=2>    <div style="width:80px;">
      <img src="img/rate5.png" width="80" height="16" id="starRating13"/>
      <span id="starRatingstr13" style="font-size:xx-small;color:#aaa;padding-top:-8px">(平均:5/1
人)</span>
    </div>
	<script language="javascript" type="text/javascript">
	  new Starrating(
	    "starRating13",
	    ["rate1_0.png", "rate2_0.png", "rate3_0.png", "rate4_0.png", "rate5_0.png"], {
	      basePath: "img/",
	      onClick: function (img, rating) {
            if (confirm(rating + "を投票しますか？")) {
              execute("table=voice&view=L&id=12120123470300&score=" + rating, starRating13, 5, 1
);
            }
            else {
              
            }
	      }
	    }
	  );
	</script>
</font></td></tr><tr valign='middle'><td><font size=2>もののけ姫</font></td><td><font size=2>宮崎駿</font></td><td><font size=2>えーじー</font></td><td><font size=2><div align='center'><a href='http://loverinn.web.fc2.com/ziburi/ziburi_12' target='_blank'><img src='./img/home.gif' border='0' alt='http://loverinn.web.fc2.com/ziburi/ziburi_12'></a></div></font></td><td><font size=2><div align='center'><a href='http://' target='_blank'><img src='./img/dhome.gif' border='0' alt='http://'></a></div></font></td><td><font size=2>ファンタジー/感動巨編/原作アニメ･ゲーム</font></td><td><font size=2>>♂4人</font></td><td><font size=2>>♀4人</font></td><td><font size=2>>不問2人</font></td><td><font size=2>>計10人</font></td><td><font size=2>～60分</font></td><td><font size=2>    <div style="width:80px;">
      <img src="img/rate0.png" width="80" height="16" id="starRating14"/>
      <span id="starRatingstr14" style="font-size:xx-small;color:#aaa;padding-top:-8px">(平均:0/0人)</span>
    </div>
	<script language="javascript" type="text/javascript">
	  new Starrating(
	    "starRating14",
	    ["rate1_0.png", "rate2_0.png", "rate3_0.png", "rate4_0.png", "rate5_0.png"], {
	      basePath: "img/",
	      onClick: function (img, rating) {
            if (confirm(rating + "を投票しますか？")) {
              execute("table=voice&view=L&id=12043008454900&score=" + rating, starRating14, 0, 0);
            }
            else {
              
            }
	      }
	    }
	  );
	</script>
</font></td></tr><tr valign='middle'><td><font size=2>平成狸合戦ぽんぽこ</font></td><td><font size=2>高畑勲</font></td><td><font size=2>えーじー</font></td><td><font size=2><div align='center'><a href='http://loverinn.web.fc2.com/ziburi/ziburi_10' target='_blank'><img src='./img/home.gif' border='0' alt='http://loverinn.web.fc2.com/ziburi/ziburi_10'></a></div></font></td><td><font size=2><div align='center'><a href='http://' target='_blank'><img src='./img/dhome.gif' border='0' alt='http://'></a></div></font></td><td><font size=2>コメディー/ファンタジー/感動巨編</font></td><td><font size=2>>♂6人</font></td><td><font size=2>>♀2人</font></td><td><font size=2>>不問2人</font></td><td><font size=2>>計10人</font></td><td><font size=2>～40分</font></td><td><font size=2>    <div style="width:80px;">
      <img src="img/rate0.png" width="80" height="16" id="starRating15"/>
      <span id="starRatingstr15" style="font-size:xx-small;color:#aaa;padding-top:-8px">(平均:0/0人)</span>
    </div>
	<script language="javascript" type="text/javascript">
	  new Starrating(
	    "starRating15",
	    ["rate1_0.png", "rate2_0.png", "rate3_0.png", "rate4_0.png", "rate5_0.png"], {
	      basePath: "img/",
	      onClick: function (img, rating) {
            if (confirm(rating + "を投票しますか？")) {
              execute("table=voice&view=L&id=12043008431400&score=" + rating, starRating15, 0, 0);
            }
            else {
              
            }
	      }
	    }
	  );
	</script>
</font></td></tr><tr valign='middle'><td><font size=2>風の谷のナウシカ</font></td><td><font size=2>宮崎駿</font></td><td><font size=2>えーじー</font></td><td><font size=2><div align='center'><a href='http://loverinn.web.fc2.com/ziburi/ziburi_01' target='_blank'><img src='./img/home.gif' border='0' alt='http://loverinn.web.fc2.com/ziburi/ziburi_01'></a></div></font></td><td><font size=2><div align='center'><a href='http://' target='_blank'><img src='./img/dhome.gif' border='0' alt='http://'></a></div></font></td><td><font size=2>シリアス/ファンタジー/感動巨編/原作アニメ･ゲーム</font></td><td><font size=2>>♂5人</font></td><td><font size=2>>♀4人</font></td><td><font size=2>>不問1人</font></td><td><font size=2>>計10人</font></td><td><font size=2>～30分</font></td><td><font size=2>    <div style="width:80px;">
      <img src="img/rate0.png" width="80" height="16" id="starRating16"/>
      <span id="starRatingstr16" style="font-size:xx-small;color:#aaa;padding-top:-8px">(平均:0/0人)</span>
    </div>
	<script language="javascript" type="text/javascript">
	  new Starrating(
	    "starRating16",
	    ["rate1_0.png", "rate2_0.png", "rate3_0.png", "rate4_0.png", "rate5_0.png"], {
	      basePath: "img/",
	      onClick: function (img, rating) {
            if (confirm(rating + "を投票しますか？")) {
              execute("table=voice&view=L&id=12043008305500&score=" + rating, starRating16, 0, 0);
            }
            else {
              
            }
	      }
	    }
	  );
	</script>

EOF;
	
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
		$this->action = ClassRegistry::init('ScriptsSearchAction');
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
	 * crawlVoidra 正常系
	 * 
	 * $scriptsの配列が返ってくる
	 */
	public function testCrawlVoidra() {	
		$results = $this->action->crawlVoidra();
		debug($results);
		// 配列の件数が1以上である
		$this->assertNotEquals(count($results), 0);
		// 配列の各キーに値がセットされている
		foreach ($results as $script) {
			$this->assertTrue( isset($script["title"]) );
			$this->assertTrue( isset($script["url"]) );
			$this->assertTrue( isset($script["actor_count"]) );
			$this->assertTrue( isset($script["man_count"]) );
			$this->assertTrue( isset($script["woman_count"]) );
		}
	}
	
	/**
	 * searchVoidra
	 */
	public function testSample() {
		$n = 4;
		//$results = $this->action->searchVoidra($n);
		//debug($results);
		//$this->assertNotEquals(count($results), 0);
	}
	
	
	/**
	 * sample
	 */
	public function testSearchVoidra() {
		$results = $this->action->searchVoidra(2);
		//debug($results);
		//$this->assertNotEquals(count($results), 0);
	}
	
	/**
	 * cutVoidraHtml
	 */
	public function testCutVoidraHtml() {
		//$html = $this->sampleHtml; 
		//$results = $this->action->cutVoidraHtml($html);
		//debug($results);
		//$this->assertNotEquals(count($results), 0);
	}
	
	/**
	 * searchVoidra
	 */
	public function testSplitTableToTr() {
		//$html = $this->sampleHtml; 
		//$results = $this->action->splitTableToTr($html);
		//debug($results);
		//$this->assertNotEquals(count($results), 0);
	}
	
	
	
	
}
