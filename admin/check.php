<?php
header("content-type:text/html;charset=utf-8");
header("Access-Control-Allow-Origin:*");
// 响应类型
header('Access-Control-Allow-Methods:POST');
// 响应头设置
header('Access-Control-Allow-Headers:x-requested-with, content-type');
date_default_timezone_set("PRC");   //系统使用北京时间
require 'JWT.php'; //引入JWT库
use \Firebase\JWT\JWT; //使用\Firebase\JWT\JWT命名空间
define('KEY', '1gHuiop975cdashyex9Ud23ldsvm2Xq');//定义加密秘钥
$res['result'] = 'failed';//定义result初始值
$action=@$_GET['action'];
if($action=='login'){//判断如果是登录操作
	if($_SERVER['REQUEST_METHOD']=="POST"){//通过post方法提交的请求
	  $adminName=$_POST['adminName'];
	  $adminPwd=md5($_POST['adminPwd']);
	  include("../conn.php");
	  $rs=mysql_query("select * from admins where adminName='$adminName' and adminPwd='$adminPwd'");
	  $num=mysql_num_rows($rs);
	  if($num>0){//用户名和密码正确
		    //获取当前时间戳
			$nowtime=time();
			//创建token
			$token = [
                'iss' => 'http://localhost', //签发者
                'aud' => 'http://localhost', //jwt所面向的用户
                'iat' => $nowtime, //签发时间
                'nbf' => $nowtime + 10, //在什么时间之后该jwt才可用
                'exp' => $nowtime + 60000, //过期时间-10min
                'data' => [
                    'userId' => 1,
                    'adminName' => $adminName
                ]
            ];
			$jwt=JWT::encode($token,KEY);
			
		     $res['result']="success";
			 $res['jwt']=$jwt;			
			 // {"result"=>"success","jwt"=>"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3QiLCJhdWQiOiJodHRwOlwvXC9sb2NhbGhvc3QiLCJpYXQiOjE1NzI0MzE4ODMsIm5iZiI6MTU3MjQzMTg5MywiZXhwIjoxNTcyNDMyNDgzLCJkYXRhIjp7InVzZXJJZCI6MSwidXNlck5hbWUiOiJ0b20ifX0.om_UbgFTvHIyHqay3xfZpannrQ8jubomNuRWIXF-aFU"}
		  }else{
		  	//用户名或密码不正确
		  	$res['msg']='用户名或密码错误';
		  }
		 
	  mysql_free_result($rs);
	  mysql_close($conn);
	}
	  echo json_encode($res);//向客户端输出jwt
}else{
	//非登录操作
	//验证请求头，token为空报错，非法登录
	$jwt=@$_SERVER['HTTP_TOKEN'];
	if(empty($jwt)){
		$res['msg']="非法登录";
		echo json_encode($res);
		exit;
	}
	//如果请求头，token不为空，解码后返回json给ajax
	try{
		 JWT::$leeway = 60;
        $decoded = JWT::decode($jwt, KEY, ['HS256']);
        $arr = (array)$decoded;
        if ($arr['exp'] < time()) {
            $res['msg'] = '请重新登录';
        } else {
            $res['result'] = 'success';
            $res['info'] = $arr;
        }

	}catch(Exception $e){//解码失败
		$res['msg']="Token验证失败，请重新登录";
	}
	echo json_encode($res);
}
?>