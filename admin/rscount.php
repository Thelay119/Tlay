<?php
    header("content-type:text/html;charset=utf-8");
    if($_SERVER['REQUEST_METHOD']=="POST"){
        include("../conn.php");
        $rs = mysql_query('select * from message');
        $rscount = mysql_num_rows($rs);
        $rs = mysql_query('select * from message where flag = 1');
        $rs1 = mysql_num_rows($rs);
        $rs = mysql_query('select * from message where flag = 0');
        $rs0 = mysql_num_rows($rs);
        $rs = mysql_query('select * from message where reply is not null');
        $readycount = mysql_num_rows($rs);
        echo '{"status":"10001","rscount":'.$rscount.',"rs0":'.$rs0.',"rs1":'.$rs1.',"readycount":'.$readycount.'}';
    }else {
        header("location:../error.html");        
    }
?>