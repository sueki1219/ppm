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

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<title>PCP用プロジェクト管理ツール</title>
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
<h2>更新情報・お知らせ</h2>

<div class="new">
<?php
	$oldweek = date("Y-m-d",strtotime("-1 week"));
	$sql = "SELECT * FROM news ORDER BY insdate DESC;";
	$result = mysql_query($sql);
	$newscount = mysql_num_rows($result);
	while($row = mysql_fetch_array($result))
	{
		//リンクありなら
		if($row[2] == '1')
		{ ?>
			<dl>
			<dt><?php echo $row[3] ?></dt>
			<dd><a href="<?php echo $row[4] ?>"><?php echo $row[1] ?></a>
				<?php
				//当日ならNEW
				if (strtotime($row[3]) == strtotime(date('Y-m-d')))
				{
				?>	
					<img src="images/icon_new.gif" alt="NEW" width="30" height="11" />	
			<?php
					
				}
				//１週間以内ならUP
				elseif(strtotime($row[3]) <= strtotime(date('Y-m-d')) AND strtotime($row[3]) >= strtotime(date('Y-m-d',"-1 week")))
				{
					?>
					<img src="images/icon_up.gif" alt="UP" width="30" height="11" />
			<?php
				}
				?>
				</dd>
			</dl>			
<?php
		}
		//リンクなし
		else
		{ ?>
			<dl>
				<dt><?php echo $row[3] ?></dt>
				<dd> 
				<?php
				echo $row[1];
				//当日ならNEW
				if (strtotime($row[3]) == strtotime(date('Y-m-d')))
				{
				?>	
					<img src="images/icon_new.gif" alt="NEW" width="30" height="11" />	
			<?php
					
				}
				//１週間以内ならUP
				elseif(strtotime($row[3]) <= strtotime(date('Y-m-d')) AND strtotime($row[3]) >= strtotime($oldweek))
				{?>
					<img src="images/icon_up.gif" alt="UP" width="30" height="11" />
			<?php
				}
				?>
				</dd>
			</dl>			
			
	<?php
		}
	}

?>
</div>
<!--/new-->

<h2>持ちアイテム一覧</h2>
<table id="item_list" class="item_list" >
	<tr>
		<th class="tamidashi">アイテム名</th>
		<th class="tamidashi">詳細アイテム名</th>
		<th class="tamidashi">進捗状況</th>
		<th class="tamidashi">予定開始日</th>
		<th class="tamidashi">予定終了日</th>
	</tr>
	<?php
		$sql = "SELECT parent_item_name,
				child_item_name, 
				progress,
				DATE_FORMAT(schedule_start_date,'%Y年%m月%d日'),
				DATE_FORMAT(schedule_end_date,'%Y年%m月%d日')
				FROM user_item 
				LEFT JOIN item_list ON item_list.parent_item_seq = user_item.parent_item_seq AND item_list.child_item_seq = user_item.child_item_seq 
				WHERE user_item.user_seq = $login_user_seq";
		$result = mysql_query($sql);
		while ($row = mysql_fetch_array($result))
		{?>
			<tr>
				<td><?php echo $row[0] ?></td>
				<td><?php echo $row[1] ?></td>
				<td class="progress"><?php echo $row[2] ?>%</td>
				<td><?php echo $row[3] ?></td>
				<td><?php echo $row[4] ?></td>
			</tr>		 
	<?php
		}
		mysql_free_result($result);	
		?>
</table>
<br>
<h2>報告書状況</h2>
<table id="item_list" class="report_list" >
	<tr>
		<th class="tamidashi">日付</th>
		<th class="tamidashi">日報・週報</th>
		<th class="tamidashi">提出状況</th>
	</tr>
<?php
		//日報データ表示
		$sql = "SELECT 
				DATE_FORMAT(report_date,'%Y年%m月%d日'), 
				m_report_type.report_type_name,
				m_approval_type.approval_type_name,
				report_seq,
				approval_flg
				FROM report 
				JOIN m_report_type ON m_report_type.report_type_seq = report.report_type_seq 
				JOIN m_approval_type ON m_approval_type.approval_type_seq = report.approval_flg 
				WHERE DATE_FORMAT(report_date,'%Y-%m-%d') BETWEEN '$fromdate' AND '$todate' 
				AND report.report_type_seq = 1
				AND user_seq = $login_user_seq
				ORDER BY report_date";
		$result = mysql_query($sql);
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
		$reportcount = mysql_num_rows($result);
		$j = 0;
		for($i = 0; $i <= 7; $i++)
		{
			//初回、又は存在したデータを表示した後は再度データを読み込み
			if($i == 0 || $flg == 1)
			{
				$row = mysql_fetch_array($result);	
			}
			if($row[0] == $weeklist[$i])
			{ 
?>
			<tr>
				<td><?php echo $row[0] ?></td>
				<td><?php echo $row[1] ?></td>
				<td><?php
					 if($row[4] == '1')
					 { ?>
					<a style="	color: #2B5EDB;" href="report_details.php?seq=<?php echo $row[3] ?>"><?php echo $row[2] ?></a> 		
					<?php
					 }
					 else
					 {
 						 echo $row[2]; 
					 }
					 
					 ?></td>
			</tr>		 
<?php
				//データを表示しました。
				$flg = 1;
			}
			else
			{ 
?>
			<tr>
				<td><?php echo $weeklist[$i] ?></td>
				<td>日報</td>
				<td><a href="report_input.php?date=<?php echo $weeklisti[$i] ?>&type=2">未提出</a></td>
			</tr>		 
<?php
				//データを表示していません。
				$flg = 0;
			}
		}	
		mysql_free_result($result);			

		//週報データ表示
		$sql = "SELECT 
				DATE_FORMAT(report_date,'%Y年%m月%d日'), 
				m_report_type.report_type_name,
				m_approval_type.approval_type_name,
				report_seq 
				FROM report 
				JOIN m_report_type ON m_report_type.report_type_seq = report.report_type_seq 
				JOIN m_approval_type ON m_approval_type.approval_type_seq = report.approval_flg 
				WHERE DATE_FORMAT(report_date,'%Y-%m-%d') BETWEEN '$fromdate' AND '$todate' 
				AND report.report_type_seq = 2
				AND user_seq = $login_user_seq
				ORDER BY report_date";
		$result = mysql_query($sql);
		$reportcount = mysql_num_rows($result);
		if($reportcount == 1)
		{ 
			$row = mysql_fetch_array($result);
?>
			<tr>
				<td><?php echo $row[0] ?></td>
				<td><?php echo $row[1] ?></td>
				<td><?php
					 if($row[4] == '1')
					 { ?>
					<a style="	color: #2B5EDB;" href="report_details.php?seq=<?php echo $row[3] ?>"><?php echo $row[2] ?></a> 		
					<?php
					 }
					 else
					 {
 						 echo $row[2]; 
					 }
					 
					 ?></td>
			</tr>		 
	<?php
		}
		else
		{ 
?>
			<tr>
				<td></td>
				<td>週報</td>
				<td><a href="report_input.php?type=2">未提出</a></td>
			</tr>		 
<?php
		}
?>



</table>
<br>

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
