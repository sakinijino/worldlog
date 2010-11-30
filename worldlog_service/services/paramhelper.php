<?php
  function getParam($paramname) {
    if ($_POST[$paramname]!=null) return $_POST[$paramname];
    elseif ($_GET[$paramname]!=null) return $_GET[$paramname];
    else return "";
  }
?>