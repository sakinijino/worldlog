<?php
  function getDefaultUser()
  {
    $defaultuser = new User();
    $defaultuser->id = 1;
    $defaultuser->name = 'saki';
    $defaultuser->nickname = 'Saki';
    $defaultuser->email = 'Saki@123';
    $defaultuser->password = '123';
    $defaultuser->img_url = 'http://localhost/1.jpg';
    $defaultuser->default_profile_id = NULL;
    
    return $defaultuser;
  }
  
  function getDefaultProfile()
  {
    $defaultprofile = new Profile();
    $defaultprofile->name = 'PKU';
    $defaultprofile->user_id = 0;
    $defaultprofile->longitude = 136.12345;
    $defaultprofile->latitude = 49.0;
    $defaultprofile->zoom_level = 4;
    
    return $defaultprofile;
  }
  
  function gerDefaultItem()
  {
    $defaultitem = new Item();
    $defaultitem->id = 	1;
    $defaultitem->user_id = 	0;
    $defaultitem->longitude = 	123.453;
    $defaultitem->latitude = 	321.543;
    $defaultitem->tags = 	"as sa ew";
    $defaultitem->icon = 	"1.ico";
    $defaultitem->link = 	"sakinijino.bokee.com";
    $defaultitem->title = 	"future";
    $defaultitem->content = 	"<p>213</p>";
    $defaultitem->type = 	"blog";
    $defaultitem->createtime = 	"2006-05-12 00:00:00";
    $defaultitem->enable = 	'true';
    $defaultitem->updatetime = "2006-05-13 00:00:00";
    $defaultitem->visits = 	3;
    $defaultitem->goodrating= 	25;
    $defaultitem->badrating= 	10;
    
    return $defaultitem;
  }
?> 