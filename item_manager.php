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
    //DB接続
    require("lib/dbconect.php");
    $dbcn = DbConnect();
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
<h2>親アイテム登録</h2>
<?php
if(isset($_POST['regist']))
{?>
<div id="regist">
	<?php
		$item_name = $_POST['item_name'];
		$difficulty_late = $_POST['difficulty_late'];
		$schedule_start_date = $_POST['schedule_start_date'];
		$team = $_POST['team'];
		$type = $_POST['type'];
		$schedule_end_date = $_POST['schedule_end_date'];
		$sql = "INSERT INTO parent_item (parent_item_name, team_seq, item_type_seq, schedule_start_date, schedule_end_date, difficulty_late) VALUES ('$item_name', $team, $type, '$schedule_start_date', '$schedule_end_date',$difficulty_late);";
		mysql_query($sql);
	?>
	登録しました。
</div>	
<?php
}
else
{?>
<div id="input">
	<form action="" method="post">
種別：<select name="type">
	<?php
	$sql = "SELECT * FROM m_item_type ORDER BY item_type_seq ASC;";
	$result = mysql_query($sql);
	while($row = mysql_fetch_array($result))
	{ ?>
		<option value="<?php echo $row[0] ?>"><?php echo $row[1] ?></option>	
	<?php
	}
	  ?>
</select><br>	
アイテム名：<input type="text" name="item_name" /><br>
担当チーム：<select name="team">
	<?php
	$sql = "SELECT * FROM m_team ORDER BY team_seq ASC;";
	$result = mysql_query($sql);
	while($row = mysql_fetch_array($result))
	{ ?>
		<option value="<?php echo $row[0] ?>"><?php echo $row[1] ?></option>	
	<?php
	}
	  ?>
</select><br>
難易度：<select name="difficulty_late">
		<?php
	$sql = "SELECT * FROM m_difficulty_late ORDER BY difficulty_late_seq ASC;";
	$result = mysql_query($sql);
	while($row = mysql_fetch_array($result))
	{ ?>
		<option value="<?php echo $row[0] ?>"><?php echo $row[1] ?></option>	
	<?php
	}
	  ?>

</select><br>
予定開始日：<input type="date" name="schedule_start_date" /><br>
予定終了日：<input type="date" name="schedule_end_date" /><br>
<input type="hidden" name="regist" value="1" />
<input class="save" type="submit" value="登録" />
</form>
</div>
	<p><a href="javascript:history.back()"><img src="images/back.gif" alt="前のページにもどる" width="330" height="44" /></a></p>

<?php
}
?>

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
