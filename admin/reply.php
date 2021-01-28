<?php
if($_SERVER['REQUEST_METHOD']=="POST"){
    include('../conn.php');
    $messageId = $_POST['messageId'];
    $reply = $_POST['reply'];
    // echo $messageId;
    // echo $reply;
    $flag=mysql_query("update message set reply='$reply' where messageId='$messageId'");
    if($flag){
        echo '{"status":"10001","msg":"回复成功！"}';
    }else{
        echo '{"status":"10002","msg":"咋整的，这也能回复失败"}';
    }
}else{
    echo 'aldaldfkjaklsdfjasdklf';
    header("location:../error.html");
}
?>