<?php
    function DbConnect()
    {
        //DB接続
		//本番環境用
        //$link = mysql_connect("mysql562.phy.lolipop.jp","LAA0172484","pcp2011");
        //mysql_select_db("LAA0172484-segmo");
        //ローカル用
        $link = mysql_connect("localhost","root","");
        mysql_select_db("pmc");
        
        return $link;    
    }

    function Dbdisconnect($link)
    {
        mysql_close($link);
    }
?>
