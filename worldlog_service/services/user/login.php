<?php
  header('Content-type: application/xml');
  session_start();
  require_once('include.php');
  
  $name = getParam("name");
  $password = getParam("password");
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
  $user = $userdao->loadByNameAndPassword($name, $password);
  $db->close();
  if ($user == NULL) { 	
    print "<error>用户名密码错误</error>";
  }
  else
  {
    $_SESSION['user_id'] = $user->id;
    print userToXML($user);
  }
?>