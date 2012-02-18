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
			case 'team':
				$login_user_team = $value;
				break;
			case 'auth_name':
				$login_user_auth_name = $value;
				break;
			case 'team_name':
				$login_user_team_name = $value;
				break;
		}
	}

}
    //DB接続
    require("lib/dbconect.php");
    $dbcn = DbConnect();
	$parent_item_seq = $_GET['id'];
	$child_item_seq = $_GET['id2'];
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
<table class="login_info">
	<tr>
		<th>チーム名:</th>
		<td><?php echo $login_user_team_name ?></td>
	</tr>
	<tr>
		<th>ユーザ名:</th>
		<td><?php echo $login_user_name ?></td>
	</tr>
</table>
<br>
<br>
<br>
<div id="main">
<h2>アイテム進捗更新</h2>
<?php
if(isset($_POST['regist']))
{?>
<div id="regist">
	<?php
		//SQLを親と子で切り替え
		//開始日が入ってない場合は一緒にNOW（）をUPDATE
		//進捗が100の場合は終了日をNOWでUPDATE
		//子アイテムの進捗を更新
		if(isset($_POST['parent_seq']) AND isset($_POST['child_seq']))
		{
			$childe_seq = $_POST['child_seq'];
			$parent_seq = $_POST['parent_seq'];
			$progress = $_POST['progress'];
			$sql = "SELECT start_date FROM child_item WHERE parent_item_seq = '$parent_seq' AND child_item_seq = '$childe_seq';";
			$result = mysql_query($sql);
			$row = mysql_fetch_array($result);
			//すでに開始日が登録済み
			if(isset($row[0]))
			{
				//進捗が100なら終了日を登録
				if($progress == '100')
				{
					$sql = "UPDATE child_item SET progress = '$progress', end_date = NOW() WHERE child_item_seq = '$childe_seq' and parent_item_seq = '$parent_seq';";				
				}
				//日付は何もいじらない
				else
				{
					$sql = "UPDATE child_item SET progress = '$progress' WHERE child_item_seq = '$childe_seq' and parent_item_seq = '$parent_seq';";									
				}
			}
			//まだ開始日が登録されていない。
			else
			{
				//進捗が100なら終了日も登録
				if($progress == '100')
				{
					$sql = "UPDATE child_item SET start_date = NOW(), progress = '$progress', end_date = NOW() WHERE child_item_seq = '$childe_seq' and parent_item_seq = '$parent_seq';";				
				}
				//開始日のみ登録
				else
				{
					$sql = "UPDATE child_item SET start_date = NOW(), progress = '$progress' WHERE child_item_seq = '$childe_seq' and parent_item_seq = '$parent_seq';";				
				}
			}
		}
		//親アイテムの進捗を更新
		else
		{
			$parent_seq = $_POST['parent_seq'];
			$progress = $_POST['progress'];
			$sql = "SELECT start_date FROM parent_item WHERE parent_item_seq = '$parent_seq';";
			$result = mysql_query($sql);
			$row = mysql_fetch_array($result);
			//すでに開始日が登録済み
			if(isset($row[0]))
			{
				//進捗が100なら終了日を登録
				if($progress == '100')
				{
					$sql = "UPDATE parent_item SET progress = '$progress', end_date = NOW() WHERE parent_item_seq = '$parent_seq';";				
				}
				//日付は何もいじらない
				else
				{
					$sql = "UPDATE parent_item SET progress = '$progress' WHERE parent_item_seq = '$parent_seq';";									
				}
			}
			//まだ開始日が登録されていない。
			else
			{
				//進捗が100なら終了日も登録
				if($progress == '100')
				{
					$sql = "UPDATE parent_item SET start_date = NOW(), progress = '$progress', end_date = NOW() WHERE parent_item_seq = '$parent_seq';";				
				}
				//開始日のみ登録
				else
				{
					$sql = "UPDATE parent_item SET start_date = NOW(), progress = '$progress' WHERE parent_item_seq = '$parent_seq';";				
				}
			}
		}

		mysql_query($sql);			
		
	?>
	登録しました。
</div>	
<?php
}
else if(isset($_GET['id']) AND isset($_GET['id2']))
{
	$sql = "SELECT parent_item_name, child_item_name FROM item_list WHERE parent_item_seq = '$parent_item_seq' AND child_item_seq = '$child_item_seq';";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	?>
<div id="input">
	<form action="" method="post">
対象親アイテム名：<?php echo $row[0] ?><br>	
対象子アイテム名：<?php echo $row[1] ?><br>	
担当メンバー:<input type="text" name="progress" /><br>
<input type="hidden" name="regist" value="1" />
<input type="hidden" name="parent_seq" value="<?php echo $parent_item_seq ?>" />
<input type="hidden" name="child_seq" value="<?php echo $child_item_seq ?>" />
<input class="save" type="submit" value="登録" />
</form>
</div>
	
<?php
}else if(isset($_GET['id']))
{ 	$sql = "SELECT parent_item_name FROM item_list WHERE parent_item_seq = '$parent_item_seq';";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	?>
<div id="input">
	<form action="" method="post">
対象親アイテム名：<?php echo $row[0] ?><br>	
進捗度:<input type="text" name="progress" /><br>
<input type="hidden" name="regist" value="1" />
<input type="hidden" name="parent_seq" value="<?php echo $parent_item_seq ?>" />
<input class="save" type="submit" value="登録" />
</form>
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
