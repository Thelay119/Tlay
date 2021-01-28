<?php
header("content-type:text/html;charset=utf-8");
if($_SERVER['REQUEST_METHOD']=="POST"){
   $author=$_POST['author'];
   $content=$_POST['content'];
   $face=$_POST['face'];
   include("conn.php");
   $flag=mysql_query("insert into message(author,content,face,addTime) values('$author','$content','$face',now())");
   if($flag){
	    echo '{"status":"10001","message":"success"}';
	}else{
	    echo '{"status":"10002","message":"添加留言失败，请联系管理员"}'; 
	}
}else{
	header("location:error.html");
}
?>