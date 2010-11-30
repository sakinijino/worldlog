<?php
  header('Content-type: application/xml');
  session_start();
  require_once('include.php');
  if ($_SESSION['user_id'] == NULL) {
    print "<error>未登陆用户</error>";
    exit;
  }
  
  $profile = new Profile();
  $profile->user_id = $_SESSION['user_id'];
  $profile->name = getParam('name');
	$profile->longitude= getParam('longitude');
	$profile->latitude= getParam('latitude');
	$profile->zoom_level= getParam('zoomlevel');

  if ($profile->name == "") {
    print "<error>名称不能为空</error>";
  	exit();
  }
  
  if ($profile->longitude == "" || 
      $profile->latitude == "" || 
      $profile->zoom_level == "") {
    print "<error>经纬度、放大级别不能为空</error>";
  	exit();
  }
  
  $dbhelper = getDBHelper();
  $db = $dbhelper->connect();
  $profiledao = new ProfileDao($db);
  
  $profile->id = $profiledao->save($profile);
	$db->close();
	$profile->items = array();
  print profileToXML($profile);
?>