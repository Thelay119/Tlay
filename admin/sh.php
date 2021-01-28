<?php
if($_SERVER['REQUEST_METHOD']=="POST"){		
    $messageId = $_POST['messageId'];
    include('../conn.php');
    $flag=mysql_query("update message set flag=1 where messageId='$messageId'");
    if($flag){
        echo '{"status":"10001","msg":"审核成功"}';
    }else {
        echo '{"status":"10002","msg":"完犊子玩意，审核不通过"}';
    }
}else{
  echo 'header("../error.html");';
}	
?>