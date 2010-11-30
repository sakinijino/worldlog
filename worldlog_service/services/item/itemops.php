<?php
  header('Content-type: application/xml');
  session_start();
  require_once('include.php');
  
  $dbhelper = getDBHelper();
  $db = $dbhelper->connect();
  $itemdao = new ItemDao($db);
  
  $op = getParam('op');
  if ($op=="visit") {
    $itemdao->incVisits(0+getParam('id'));
    print "<success>访问Item成功</success>";
  }
  elseif ($op=="goodrate") {
    $itemdao->incGoodRating(0+getParam('id'));
    print "<success>评价Item成功</success>";
  }
  elseif ($op=="badrate") {
    $itemdao->incBadRating(0+getParam('id'));
    print "<success>评价Item成功</success>";
  }
  else {
    print "<error>错误操作名</error>";
  }
  $db->close();
?>