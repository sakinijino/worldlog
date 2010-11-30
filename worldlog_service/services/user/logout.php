<?php
  header('Content-type: application/xml');
  session_start();
  $_SESSION['user_id'] =NULL;
  session_destroy( );
  print "<success>注销成功</success>";
?> 