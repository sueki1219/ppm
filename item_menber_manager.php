<?php
    //DB接続
    require("lib/dbconect.php");
    $dbcn = DbConnect();
	$parent_item_seq = $_GET['id'];
	$chile_item_seq = $_GET['id2'];
	$team_seq = $_GET['id3'];
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
<li><a href="puppy.php"><img src="images/menu_03.gif" alt="PUPPY" name="Image3" width="184" height="50" id="Image3" onmouseover="MM_swapImage('Image3','','images/menu_over_03.gif',0)" onmouseout="MM_swapImgRestore()" /></a></li>
<li><a href="photo.php"><img src="images/menu_04.gif" alt="PHOTO" name="Image4" width="184" height="50" id="Image4" onmouseover="MM_swapImage('Image4','','images/menu_over_04.gif',0)" onmouseout="MM_swapImgRestore()" /></a></li>
<li><a href="contact.php"><img src="images/menu_05.gif" alt="CONTACT" name="Image5" width="186" height="50" id="Image5" onmouseover="MM_swapImage('Image5','','images/menu_over_05.gif',0)" onmouseout="MM_swapImgRestore()" /></a></li>
</ul><div id="main">
<h2>子アイテム登録</h2>
<?php
if(isset($_POST['regist']))
{?>
<div id="regist">
	<?php
		$childe_seq = $_POST['childe_seq'];
		$parent_seq = $_POST['parent_seq'];
		$user_seq = $_POST['user_seq'];
		$sql = "INSERT INTO user_item VALUES ('$user_seq','$childe_seq', '$parent_seq');";
		mysql_query($sql);
	?>
	登録しました。
</div>	
<?php
}
else
{
	$sql = "SELECT child_item_name FROM child_item WHERE child_item_seq = '$chile_item_seq';";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	?>
<div id="input">
	<form action="" method="post">
対象アイテム名：<?php echo $row[0] ?><br>	
担当メンバー:
<select name="user_seq">
		<?php
	$sql = "SELECT * FROM m_user WHERE team_seq = '$team_seq' ORDER BY user_seq";
	$result = mysql_query($sql);
	while($row = mysql_fetch_array($result))
	{ ?>
		<option value="<?php echo $row[0] ?>"><?php echo $row[3] ?></option>	
	<?php
	}
	  ?>

</select><br>
<input type="hidden" name="regist" value="1" />
<input type="hidden" name="parent_seq" value="<?php echo $parent_item_seq ?>" />
<input type="hidden" name="childe_seq" value="<?php echo $chile_item_seq ?>" />
<input class="save" type="submit" value="登録" />
</form>
<br>
<h2>担当メンバー</h2>
<table id="item_list" class="item_list" >
	<tr>
		<th class="tamidashi">メンバー</th>
	</tr>
	<?php
		$sql = "SELECT m_user.name
				FROM user_item 
				JOIN m_user ON user_item.user_seq = m_user.user_seq  
				WHERE user_item.child_item_seq = '$chile_item_seq'";
		$result = mysql_query($sql);
		while ($row = mysql_fetch_array($result))
		{?>
			<tr>
				<td><?php echo $row[0] ?></td>
			</tr>		 
	<?php
		}
		mysql_free_result($result);	
		?>
</table>

</div>
	
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
