<?php
  header('Content-type: application/xml');
  session_start();
  require_once('include.php');
  if ($_SESSION['user_id'] == NULL) {
    print "<error>未登陆用户</error>";
    exit;
  }
  
  $item = new Item();
  $item->user_id = $_SESSION['user_id'];
	$item->longitude= getParam('longitude');
	$item->latitude= getParam('latitude');
	$item->tags = getParam('tags');
	$item->icon= getParam('icon'); 
	$item->link= getParam('link'); 
	$item->title= getParam('title');
	$item->content= getParam('content');
	$item->type= getParam('type'); 
	$item->createtime= date('Y-m-j H:i:s');
	$item->updatetime= date('Y-m-j H:i:s'); 
	$item->enable= 'true';
	
	$item->goodrating= 0;
	$item->badrating= 0;
	$item->visits= 0;

  if ($item->longitude == "" || $item->latitude == "") {
    print "<error>经纬度不能为空</error>";
  	exit();
  }
  
  if ($item->type=="blog") {
    if ($item->link=="") {
      print "<error>RSS地址不能为空</error>";
    }
    //should get rss content(xml) remotly
    $item->content = $item->link;
    if ($item->title=="") $item->title = 'A blog';
  }
  elseif ($item->type=="link") {
    if ($item->link=="") {
      print "<error>链接地址不能为空</error>";
    }
    //should get link content(html) remotly
    if ($item->title=="") $item->title = 'A link';
  }
  elseif ($item->type=="diary") {
    if ($item->title=="") {
      print "<error>标题不能为空</error>";
    }
    if ($item->content=="") {
      print "<error>内容不能为空</error>";
    }
  }
  
  if ($item->tags != "") $tagarr = explode(" ", $item->tags);
  else $tagarr = array();
  
  $dbhelper = getDBHelper();
  $db = $dbhelper->connect();
  $itemdao = new ItemDao($db);
  $tagdao = new TagDao($db);
  
  $item->id = $itemdao->save($item);
  foreach ($tagarr as $tag){
	  $tagdao->addItemTag($tag, $item->id);
	}
	$db->close();
  print itemToXML($item);
?>