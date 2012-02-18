<?php
//ログインチェック
if(!isset($_COOKIE['login']))
{
    header("Location: login.php");
}
else
{
	foreach ($_COOKIE['login'] as $key => $value) 
	{
		switch ($key) {
			case 'user_seq':
				$login_user_seq = $value;
				break;
			case 'name':
				$login_user_name = $value;
				break;
			case 'auth':
				$login_user_auth = $value;
				break;
		}
	}
}
function computeDate($year, $month, $day, $addDays) 
{
    $baseSec = mktime(0, 0, 0, $month, $day, $year);//基準日を秒で取得
    $addSec = $addDays * 86400;//日数×１日の秒数
    $targetSec = $baseSec + $addSec;
    return date("Y年m月d日", $targetSec);
}
	//DB接続
	require("lib/dbconect.php");
	$dbcn = DbConnect();
	
	$type = $_GET['type'];
	$date = $_GET['date'];
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
<?php 
if($login_user_auth == '1')
{ ?>
	<ul class="menber" id="menu">
	<li><a href="index.php"><img src="images/menu_0.jpg" alt="HOME" width="310" height="60" id="Image1" onmouseover="MM_swapImage('Image1','','images/menu_over1.jpg',0)" onmouseout="MM_swapImgRestore()" /></a></li>
	<li><a href="about.php"><img src="images/menu_1.jpg" alt="ABOUT" width="310" height="60" id="Image2" onmouseover="MM_swapImage('Image2','','images/menu_over2.jpg',0)" onmouseout="MM_swapImgRestore()" /></a></li>
	<li><a href="puppy.php"><img src="images/menu_2.jpg" alt="PUPPY" width="310" height="60" id="Image3" onmouseover="MM_swapImage('Image3','','images/menu_over3.jpg',0)" onmouseout="MM_swapImgRestore()" /></a></li>
	</ul>
<?php
}else
{ ?>
	<ul class="manager" id="menu">
	<li><a href="index.php"><img src="images/menu_0.jpg" alt="HOME" width="186" height="40" id="Image1" onmouseover="MM_swapImage('Image1','','images/menu_over1.jpg',0)" onmouseout="MM_swapImgRestore()" /></a></li>
	<li><a href="about.php"><img src="images/menu_1.jpg" alt="ABOUT" width="184" height="40" id="Image2" onmouseover="MM_swapImage('Image2','','images/menu_over2.jpg',0)" onmouseout="MM_swapImgRestore()" /></a></li>
	<li><a href="puppy.php"><img src="images/menu_2.jpg" alt="PUPPY" width="184" height="40" id="Image3" onmouseover="MM_swapImage('Image3','','images/menu_over3.jpg',0)" onmouseout="MM_swapImgRestore()" /></a></li>
	<li><a href="photo.php"><img src="images/menu_3.jpg" alt="PHOTO" width="184" height="40" id="Image4" onmouseover="MM_swapImage('Image4','','images/menu_over4.jpg',0)" onmouseout="MM_swapImgRestore()" /></a></li>
	<li><a href="contact.php"><img src="images/menu_4.jpg" alt="CONTACT" width="186" height="40" id="Image5" onmouseover="MM_swapImage('Image5','','images/menu_over5.jpg',0)" onmouseout="MM_swapImgRestore()" /></a></li>
	</ul>
<?php
}
?>
<p class="login_info">ログイン名：<?php echo $login_user_name ?></p>

<div id="main">

<h2>報告書記入</h2>
<form action="report_regist.php" method="post">
	<textarea class="report_contants" name="contants" rows="15" cols="120"></textarea>
	<input class="save" type="submit" value="保存" />
	<select class="report_type" name="type">
		<option value="1">日報</option>
		<option value="2">週報</option>
	</select>
	<?php
	if(isset($_GET['date']))
	{?>
	<input type="hidden" name="date" value="<?php echo $date ?>" />	
	<?php
	}
	?>
</form>
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
