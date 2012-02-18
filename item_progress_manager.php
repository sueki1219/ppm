<?php
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


<ul id="menu">
<li><a href="index.php"><img src="images/menu_01.gif" alt="HOME" width="186" height="50" id="Image1" onmouseover="MM_swapImage('Image1','','images/menu_over_01.gif',0)" onmouseout="MM_swapImgRestore()" /></a></li>
<li><a href="about.php"><img src="images/menu_02.gif" alt="ABOUT" name="Image2" width="184" height="50" id="Image2" onmouseover="MM_swapImage('Image2','','images/menu_over_02.gif',0)" onmouseout="MM_swapImgRestore()" /></a></li>
<li><a href="puppy.php"><img src="images/menu_03.gif" alt="PUPPY" name="Image3" width="184" height="50" id="Image3" onmouseover="MM_swapImage('Image3','','images/menu_over_03.gif',0)" onmouseout="MM_swapImgRestore()" /></a></li>
<li><a href="photo.php"><img src="images/menu_04.gif" alt="PHOTO" name="Image4" width="184" height="50" id="Image4" onmouseover="MM_swapImage('Image4','','images/menu_over_04.gif',0)" onmouseout="MM_swapImgRestore()" /></a></li>
<li><a href="contact.php"><img src="images/menu_05.gif" alt="CONTACT" name="Image5" width="186" height="50" id="Image5" onmouseover="MM_swapImage('Image5','','images/menu_over_05.gif',0)" onmouseout="MM_swapImgRestore()" /></a></li>
</ul><div id="main">
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
