<?php
    header("content-type:text/html;charset=utf-8");
    if($_SERVER['REQUEST_METHOD']=="POST"){
        include("../conn.php");
        $rs = mysql_query('select * from message where flag = 0');
        $rs0 = mysql_num_rows($rs);
        echo '{"status":"10001","rs0":'.$rs0.'}';
    }else {
        header("location:../error.html");        
    }
?>