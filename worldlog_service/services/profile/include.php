﻿<?php
  define("MODELDIR", "../../models/");
  define("DAODIR", "../../models/daos/");
   
  require_once('../dbhelper.php');
  require_once('../paramhelper.php');
  require_once(MODELDIR.'profile.class.php');
  require_once(DAODIR.'profiledao.class.php');
  require_once(MODELDIR.'item.class.php');
  require_once(DAODIR.'itemdao.class.php');
?>