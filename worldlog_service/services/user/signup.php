<?php
  header('Content-type: application/xml');
  session_start();
  require_once('include.php');
  
  $name = getParam("name");
  $nickname = getParam("nickname");
  $password = getParam("password");
  $email = getParam("email");
  if ($name == null || $name == "") {
    print "<error>用户名不能为空</error>";
  	exit();
  }
  if ($password == null || $password == "") {
    print "<error>密码不能为空</error>";
  	exit();
  }
  
  $dbhelper = getDBHelper();
  $db = $dbhelper->connect();
  $userdao = new UserDao($db);
  $user = $userdao->loadByName($name);
  if ($user != NULL) { 	
    print "<error>用户已存在</error>";
    $db->close();
  	exit();
  }
  else{
  	$user = new User();
  	$user->name = $name;
  	$user->nickname = $nickname;
  	$user->password = $password;
  	$user->email = $email;
  	$user->id = $userdao->save($user);
  	print userToXML($user);
  	exit();
  }
  $db->close();
?>