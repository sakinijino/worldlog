<?php
  header('Content-type: application/xml');
  session_start();
  $_SESSION['user_id'] =NULL;
  session_destroy( );
  print "<success>娉ㄩ攢鎴愬姛</success>";
?> 