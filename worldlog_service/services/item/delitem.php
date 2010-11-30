<?php
  header('Content-type: application/xml');
  session_start();
  require_once('include.php');
  if ($_SESSION['user_id'] == NULL) {
    print "<error>未登陆用户</error>";
    exit;
  }

  $dbhelper = getDBHelper();
  $db = $dbhelper->connect();
  $itemdao = new ItemDao($db);
  $tagdao = new TagDao($db);
  
  $item = $itemdao->loadByID(0+getParam('id'));
  if ($item==null) {
    print "<error>不存在这个item</error>";
    exit();
  }
  if ($item->user_id != $_SESSION['user_id']){
    print "<error>不能删除别人创建的item</error>";
    exit();
  }
  
  if ($item->tags != "") $tagarr = explode(" ", $item->tags);
  else $tagarr = array();
  
  $itemdao->delete($item);
  foreach ($tagarr as $tag){
	  $tagdao->delItemTag($tag, $item->id);
	}
	print "<success>成功删除</success>";
	
  $db->close();
?>
