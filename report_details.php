<?php
    //DB接続
    require("lib/dbconect.php");
    $dbcn = DbConnect();
	function computeDate($year, $month, $day, $addDays) 
	{
	    $baseSec = mktime(0, 0, 0, $month, $day, $year);//基準日を秒で取得
	    $addSec = $addDays * 86400;//日数×１日の秒数
	    $targetSec = $baseSec + $addSec;
	    return date("Y年m月d日", $targetSec);
	}
	if($_GET['seq'])
	{
		$seq = $_GET['seq'];
	}
	else
	{
		$seq = $_POST['seq'];	
	}
	$sql = "SELECT * FROM report WHERE report_seq = $seq";
	$result = mysql_query($sql);	
	$row = mysql_fetch_array($result);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<title>PCP用プロジェクト管理ツール</title>
<meta name="copyright" content="Nikukyu-Punch" />
<meta name="description" content="ここにサイト説明を入れます" />
<meta name="keywords" content="キーワード１,キーワード２,キーワード３,キーワード４,キーワード５" />
<link href="style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="script.js"></script>
</head>
<body>
<div id="header">
<div>
<img src="images/pcpmain.png" width="930" height="180" />
</div>
</div>
<!--/header-->


<div id="container">


<ul id="menu">
<li><a href="index.php"><img src="images/menu_01.gif" alt="HOME" width="186" height="50" id="Image1" onmouseover="MM_swapImage('Image1','','images/menu_over_01.gif',0)" onmouseout="MM_swapImgRestore()" /></a></li>
<li><a href="about.php"><img src="images/menu_02.gif" alt="ABOUT" name="Image2" width="184" height="50" id="Image2" onmouseover="MM_swapImage('Image2','','images/menu_over_02.gif',0)" onmouseout="MM_swapImgRestore()" /></a></li>
<li><a href="puppy.php"><img src="images/menu_03.gif" alt="PUPPY" width="184" height="50" id="Image3" onmouseover="MM_swapImage('Image3','','images/menu_over_03.gif',0)" onmouseout="MM_swapImgRestore()" /></a></li>
<li><a href="photo.php"><img src="images/menu_04.gif" alt="PHOTO" width="184" height="50" id="Image4" onmouseover="MM_swapImage('Image4','','images/menu_over_04.gif',0)" onmouseout="MM_swapImgRestore()" /></a></li>
<li><a href="contact.php"><img src="images/menu_05.gif" alt="CONTACT" width="186" height="50" id="Image5" onmouseover="MM_swapImage('Image5','','images/menu_over_05.gif',0)" onmouseout="MM_swapImgRestore()" /></a></li>
</ul>


<div id="main">
<?php
if(isset($_POST['update']))
{
	$contants = $_POST['contants'];
	$sql = "UPDATE report SET contents = '$contants' WHERE report_seq = '$seq';";
	mysql_query($sql);
	?>
	<h2>登録しました。</h2>
	無事登録が完了しました。<br>
	忘れずに報告して下さい。<br>
<?php
}
//報告内容編集
else if(isset($_POST['seq']))
{?>
	<h2>報告内容編集</h2>
<form action="report_details.php" method="post">
	<textarea class="report_contants" name="contants" rows="15" cols="120"><?php echo $row[3] ?></textarea>
	<input class="save" type="submit" value="編集" />
	<input style="width: 40px; text-align: center;" class="report_type" type="text" readonly value="<?php
	if($type == '!')
	{
		echo "日報";		
	}
	else
	{
		echo "週報";
	}
	?>" />
	<input type="hidden" name="seq" value="<?php echo $row[0] ?>" />
	<input type="hidden" name="update" value="1" />
	</select>
</form>
<?php
}
//初期画面
else
{?>
		
<h2>報告確認<font color="red">※この内容で報告してもよろしいですか？</font></h2>
<form action="report_details.php" method="post">
	<textarea class="report_contants" name="contants" rows="15" cols="120" readonly><?php echo $row[3] ?></textarea>
	<input class="save" type="submit" value="編集" />
	<input style="width: 40px; text-align: center;" class="report_type" type="text" readonly value="<?php
	if($type == '!')
	{
		echo "日報";		
	}
	else
	{
		echo "週報";
	}
	?>" />
	<input type="hidden" name="seq" value="<?php echo $row[0] ?>" />
	</select>
</form>
<form action="report_submission.php" method="post">
	<input type="hidden" name="seq" value="<?php echo $row[0] ?>" />
	<input style="clear: all" type="submit" value="報告" />
</form>

<?php
}
?>
<br>
<p><a href="javascript:history.back()"><img src="images/back.gif" alt="前のページにもどる" width="330" height="44" /></a></p>

</div>
<!--/main-->


<div id="footer">
Copyright&copy; 2011 サンプルブリーダーショップ All Rights Reserved.<br />
<a href="http://nikukyu-punch.com/" target="_blank">Template design by Nikukyu-Punch</a>
</div>
<!--/footer-->


</div>
<!--/container-->


</body>
</html>
