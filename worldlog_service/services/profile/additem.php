<?php
  header('Content-type: application/xml');
  session_start();
  require_once('include.php');
  if ($_SESSION['user_id'] == NULL) {
    print "<error>未登陆用户</error>";
    exit;
  }
  
  $itemid = getParam('itemid');
  if ($itemid == "") {
    print "<error>输入要添加的item</error>";
    exit();
  }
  
  $dbhelper = getDBHelper();
  $db = $dbhelper->connect();
  $profiledao = new ProfileDao($db);
  $itemdao = new ItemDao($db);
  
  $profile = $profiledao->loadByID(0+getParam('id'));
  if ($profile==null) {
    print "<error>不存在这个profile</error>";
    exit();
  }
  if ($profile->user_id != $_SESSION['user_id']){
    print "<error>不能修改别人创建的profile</error>";
    exit();
  }
  $profiledao->addItem($profile->id, 0+$itemid);
	$db->close();
  print "<success>添加Item成功</success>";
?>