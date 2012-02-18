<?php
	$type = $_POST['type'];
	$id = $_POST['id'];
	$pass = $_POST['pass'];
	
    //DB接続
    require("lib/dbconect.php");
    $dbcn = DbConnect();

    $sql = "SELECT user_seq, name, auth_seq FROM m_user WHERE user_id = '$id' AND pass = '$pass';";
    if($type == '1')
    {
        $result = mysql_query($sql);
        $userresult = mysql_fetch_array($result);
        if($userresult[0] != '')
        {
            $user_seq = $userresult[0];
            $name = $userresult[1];
            $auth_seq = $userresult[2];
            setcookie("login[user_seq]",$user_seq);
            setcookie("login[name]",$name);
            setcookie("login[auth]",$auth_seq);
			//管理者と一般は別ページ
            if($auth_seq == '1')
            {
                header("Location: index.php");
            }
            else
            {
                header("Location:bottom.php");
                exit;
            }
        }else
        {
            $msg = "ＩＤもしくはパスワードを確認してください";
        }
    }
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

<div id="main">
<h2>ログイン</h2>
<form method="post" action="login.php">
<?php echo $msg ?><br />
ID  :<input type="text" name="id" /><br>
PASS:<input type="password" name="pass" /><br>
<input type="hidden" name="type" value="1">
<input type="submit" value="ログイン" />
</form>
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
