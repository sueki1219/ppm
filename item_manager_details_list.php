<?php
    //DB接続
    require("lib/dbconect.php");
    $dbcn = DbConnect();
	$id = $_GET['id'];
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
<li><a href="photo.php"><img src="images/menu_04.gif" alt="PHOTO" width="184" height="50" id="Image4" onmouseover="MM_swapImage('Image4','','images/menu_over_04.gif',0)" onmouseout="MM_swapImgRestore()" /></a></li>
<li><a href="contact.php"><img src="images/menu_05.gif" alt="CONTACT" width="186" height="50" id="Image5" onmouseover="MM_swapImage('Image5','','images/menu_over_05.gif',0)" onmouseout="MM_swapImgRestore()" /></a></li>
</ul>


<div id="main">

<h2>子アイテム一覧</h2>
<table id="item_list" class="item_list" >
	<tr>
		<th class="tamidashi">アイテム名</th>
		<th class="tamidashi">詳細アイテム名</th>
		<th class="tamidashi">進捗状況</th>
		<th class="tamidashi">予定開始日</th>
		<th class="tamidashi">予定終了日</th>
		<th class="tamidashi">開始日</th>
		<th class="tamidashi">終了日</th>
	</tr>
	<?php
		$sql = "SELECT parent_item_name,
				child_item_name, 
				progress,
				DATE_FORMAT(schedule_start_date,'%Y年%m月%d日'),
				DATE_FORMAT(schedule_end_date,'%Y年%m月%d日'),
				DATE_FORMAT(start_date,'%Y年%m月%d日'),
				DATE_FORMAT(end_date,'%Y年%m月%d日'),
				item_list.child_item_seq ,
				item_list.parent_item_seq ,
				item_list.team_seq 
				FROM item_list 
				WHERE item_list.parent_item_seq = '$id'";
				
		$result = mysql_query($sql);
		while ($row = mysql_fetch_array($result))
		{?>
			<tr>
				<td><?php echo $row[0] ?></td>
				<td><a href="item_menber_manager.php?id=<?php echo $row[8] ?>&id2=<?php echo $row[7] ?>&id3=<?php echo $row[9] ?>"><?php echo $row[1] ?></a></td>
				<td class="progress"><a href="item_progress_manager.php?id=<?php echo $row[8] ?>&id2=<?php echo $row[7] ?>"><?php echo $row[2] ?></a>%</td>
				<td><?php echo $row[3] ?></td>
				<td><?php echo $row[4] ?></td>
				<td><?php echo $row[5] ?></td>
				<td><?php echo $row[6] ?></td>
			</tr>		 
	<?php
		}
		mysql_free_result($result);	
		?>
</table>

<button><a href="item_manager_details.php?id=<?php echo $id ?>">新規登録</a></button>
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
