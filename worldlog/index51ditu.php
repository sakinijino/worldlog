<?php session_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml">
  <head> 
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <title>Worldlog</title>
		<style type="text/css">
			v\:* {
			  behavior:url(#default#VML);
			}
		</style>
		<link href="css/worldlog.css" rel="stylesheet" type="text/css"/>

    <script src="http://api.51ditu.com/apis/mapapi?key=dmFua2VlLmNvbQ==1qaz2wsxc2FraW5pamlub0BnbWFpbC5jb20mJiZ2YW5rZWUuY29t" language="javascript"></script>
	  <script src='javascript/prototype.js' type='text/javascript'></script>
	  <script src='javascript/model.js' type='text/javascript'></script>
	  <script src='javascript/parsexml.js' type='text/javascript'></script>
	  <script src='javascript/51ditu/lnglatconvert.js' type='text/javascript'></script>
	  <script src='javascript/51ditu/51Extension.js' type='text/javascript'></script>
	  <script src='javascript/51ditu/51map.js' type='text/javascript'></script>
	  <script src='javascript/51ditu/51mapitem.js' type='text/javascript'></script>
	  <script src='javascript/user.js' type='text/javascript'></script>
	  <script src='javascript/tag.js' type='text/javascript'></script>
	  <script src='javascript/profile.js' type='text/javascript'></script>
	  <script src='javascript/itemviewer/itemviewer.js' type='text/javascript'></script>
	  <script src='javascript/itemviewer/blogviewer.js' type='text/javascript'></script>
	  <script src='javascript/itemviewer/linkviewer.js' type='text/javascript'></script>
	  <script src='javascript/itemviewer/diaryviewer.js' type='text/javascript'></script>
	  <script src='javascript/item.js' type='text/javascript'></script>
	  <script src='javascript/ajaxrequest/__init__.js' type='text/javascript'></script>
	  <script src='javascript/ajaxrequest/user.js' type='text/javascript'></script>
	  <script src='javascript/ajaxrequest/tag.js' type='text/javascript'></script>
	  <script src='javascript/ajaxrequest/item.js' type='text/javascript'></script>
	  <script src='javascript/ajaxrequest/profile.js' type='text/javascript'></script>
	  <script src='javascript/page.js' type='text/javascript'></script>
	</head>

  <body>
    <script>Page.init();</script>
    <?php include "include/div.titlebar.php";?>
    <?php include "include/div.menubar.php";?> 
    <table cellspacing=3>
  	<tr>
  	  <td valign="top">
  	  <?php include "include/div.map.php"?>
  	  </td>
  	  <td valign="top" width="300">
  	  <!--Main Interaction Area-->
  		<?php include "include/div.userlogin.php"?>
  		<?php include "include/div.usersignup.php"?>
  		<?php include "include/div.items.php"?>
  		<?php include "include/div.itemdetail.php"?>
  		<?php include "include/div.addblog.php"?>
  		<?php include "include/div.addlink.php"?>
  		<?php include "include/div.adddiary.php"?>
  		<?php include "include/div.profiles.php"?>
  		<?php include "include/div.addprofile.php"?>
  		<?php include "include/div.tag.php"?>
  		<?php include "include/div.tagitems.php"?>
  		<!--<div id="embedmap" class="section"></div>-->
  		<!--<div id="flickr" class="section"></div>-->
  		<?php include "include/div.lastestitems.php"?>
  		<?php include "include/div.help.php"?>
  	  <!--end of Main Interaction Area-->	
  	  </td>
  	</tr>
    </table>
    <div align="center">
      Powered by <a href="https://github.com/sakinijino/worldlog" target="_blank">Worldlog@github</a>
    </div>
  </body>
  <script>Page.run();</script>
</html>
