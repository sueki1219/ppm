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

function computeDate($year, $month, $day, $addDays,$type) 
{
    $baseSec = mktime(0, 0, 0, $month, $day, $year);//基準日を秒で取得
    $addSec = $addDays * 86400;//日数×１日の秒数
    $targetSec = $baseSec + $addSec;
	if($type == '1')
	{
	    return date("Y年m月d日", $targetSec);	
	}
	else
	{
	    return date("Y-m-d", $targetSec);				
	}
}
$date = getdate();
$weeklist = array();
$weeklisti = array();
//日付リスト作成
for($i=7;$i>-1;$i--)
{
	$weeklist[] = computeDate($date['year'],$date['mon'],$date['mday'],-$i,1);
	$weeklisti[] = computeDate($date['year'],$date['mon'],$date['mday'],-$i,2);
	$y++;
}
$fromdate = $weeklisti[0];
$todate = $weeklisti[7];


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

<h2>アイテム管理</h2>
<table id="item_list" class="item_list" >
	<tr>
		<th class="tamidashi">種別</th>
		<th class="tamidashi">アイテム名</th>
		<th class="tamidashi">担当チーム</th>
		<th class="tamidashi">進捗状況</th>
		<th class="tamidashi">予定開始日</th>
		<th class="tamidashi">予定終了日</th>
		<th class="tamidashi">開始日</th>
		<th class="tamidashi">終了日</th>
	</tr>
	<?php
		$sql = "SELECT 
				parent_item_seq, 
				parent_item_name, 
				m_team.team_name,
				m_item_type.item_type_name,
				DATE_FORMAT(schedule_start_date,'%Y年%m月%d日'),
				DATE_FORMAT(schedule_end_date,'%Y年%m月%d日'),
				DATE_FORMAT(start_date,'%Y年%m月%d日'),
				DATE_FORMAT(end_date,'%Y年%m月%d日'),
				progress 
				FROM parent_item 
				JOIN m_team ON m_team.team_seq = parent_item.team_seq 
				JOIN m_item_type ON m_item_type.item_type_seq = parent_item.item_type_seq;";
		$result = mysql_query($sql);
		while ($row = mysql_fetch_array($result))
		{?>
			<tr>
				<td><?php echo $row[3] ?></td>
				<td><a href="item_manager_details_list.php?id=<?php echo $row[0] ?>"><?php echo $row[1] ?></a></td>
				<td><?php echo $row[2] ?></td>
				<td class="progress"><a href="item_progress_manager.php?id=<?php echo $row[0] ?>"><?php echo $row[8] ?>%</a></td>
				<td><?php echo $row[4] ?></td>
				<td><?php echo $row[5] ?></td>
				<td><?php echo $row[6] ?></td>
				<td><?php echo $row[7] ?></td>
			</tr>		 
	<?php
		}
		mysql_free_result($result);	
		?>
</table>
<button><a href="item_manager.php">新規登録</a></button>
<h2>日報管理</h2>
<?php
		//日報データ表示
		//リーダー
		if($login_user_auth == '2')
		{
		$sql = "SELECT 
				m_user.name,
				DATE_FORMAT(report_date,'%Y年%m月%d日'), 
				report_seq,
				approval_flg
				FROM report 
				JOIN m_report_type ON m_report_type.report_type_seq = report.report_type_seq 
				JOIN m_approval_type ON m_approval_type.approval_type_seq = report.approval_flg 
				JOIN m_user ON m_user.user_seq = report.user_seq
				WHERE DATE_FORMAT(report_date,'%Y-%m-%d') BETWEEN '$fromdate' AND '$todate' 
				AND report.report_type_seq = 1
				AND report.approval_flg = 2
				AND m_user.team_seq = $login_user_team
				ORDER BY report_date";			
		}
		//マネージャー
		else
		{
			$sql = "SELECT 
				m_user.name,
				DATE_FORMAT(report_date,'%Y年%m月%d日'), 
				report_seq,
				approval_flg
				FROM report 
				JOIN m_user ON m_user.user_seq = report.user_seq
				WHERE DATE_FORMAT(report_date,'%Y-%m-%d') BETWEEN '$fromdate' AND '$todate' 
				AND report_type_seq = 1
				AND approval_flg = 3
				ORDER BY report_date";
		}
		$result = mysql_query($sql);
		$count = mysql_num_rows($result);
		if($count == '0')
		{	?>
		<p>現在確認してない日報はありません。</p>	
	<?php
		}
		else
		{?>
					
			<table id="item_list" class="report_list" >
				<tr>
					<th class="tamidashi">ユーザ名</th>
					<th class="tamidashi">日付</th>
					<th class="tamidashi">承認</th>
				</tr>
			<?php
			while($row = mysql_fetch_array($result))
			{
	?>
				<tr>
					<td><?php echo $row[0] ?></td>
					<td><?php echo $row[1] ?></td>
					<td><a href="report_manager.php?id=<?php echo $row[2] ?>">承認する</a></td>
				</tr>		 
	<?php
			}	?>
			</table>

<?php
		}	
		mysql_free_result($result);
		?>
<h2>週報管理</h2>		
<?php
		//日報データ表示
		//リーダー
		if($login_user_auth == '2')
		{
		$sql = "SELECT 
				m_user.name,
				DATE_FORMAT(report_date,'%Y年%m月%d日'), 
				report_seq,
				approval_flg
				FROM report 
				JOIN m_report_type ON m_report_type.report_type_seq = report.report_type_seq 
				JOIN m_approval_type ON m_approval_type.approval_type_seq = report.approval_flg 
				JOIN m_user ON m_user.user_seq = report.user_seq
				WHERE DATE_FORMAT(report_date,'%Y-%m-%d') BETWEEN '$fromdate' AND '$todate' 
				AND report.report_type_seq = 2
				AND report.approval_flg = 2
				AND m_user.team_seq = $login_user_team
				ORDER BY report_date";			
		}
		//マネージャー
		else
		{
			$sql = "SELECT 
				m_user.name,
				DATE_FORMAT(report_date,'%Y年%m月%d日'), 
				report_seq,
				approval_flg
				FROM report 
				JOIN m_user ON m_user.user_seq = report.user_seq
				WHERE DATE_FORMAT(report_date,'%Y-%m-%d') BETWEEN '$fromdate' AND '$todate' 
				AND report_type_seq = 2
				AND approval_flg = 3
				ORDER BY report_date";
		}
		$result = mysql_query($sql);
		$count = mysql_num_rows($result);
		if($count == '0')
		{	?>
		<p>現在確認してない週報はありません。</p>	
	<?php
		}
		else
		{?>
					
			<table id="item_list" class="report_list" >
				<tr>
					<th class="tamidashi">ユーザ名</th>
					<th class="tamidashi">日付</th>
					<th class="tamidashi">承認</th>
				</tr>
			<?php
			while($row = mysql_fetch_array($result))
			{
	?>
				<tr>
					<td><?php echo $row[0] ?></td>
					<td><?php echo $row[1] ?></td>
					<td><a href="report_manager.php?id=<?php echo $row[2] ?>">承認する</a></td>
				</tr>		 
	<?php
			}	?>
			</table>

<?php
		}	
		mysql_free_result($result);

if($login_user_auth == '3')
{
?>
<h2>お知らせ管理</h2>
<form action="news_regist.php" method="post">
	内容：<input type="text" name="contants" size="120"/><br />
	URL：<input type="url" name="url" />
	<input type="submit" value="登録" />
</form>	
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
