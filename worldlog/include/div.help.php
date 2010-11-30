<div id="help" class="section disappear">
  点地图上的图标查看内容<br>
  使用左上角的+ -按钮可以放大,缩小地图<br>
  拖动鼠标移动地图<br>
  <br>
  您可以添加自己的Blog,添加方法如下,登录后:<br>
  1.输入RSS地址. &nbsp; 2.在地图上选点.&nbsp; 3.点击提交.<br>
  <br>
  什么是RSS地址? RSS地址就是你Blog下面那个
  <img src="http://image2.sina.com.cn/blog/tmpl/v3/images/xmlRSS2.gif">
  图标上的地址.<br>
</div>

<script>
  function HelpDiv(){}
  
  Page.generateShowHideFunc(HelpDiv, $("help"), true);
  
  UserFactory.registerLogoutListener(HelpDiv.hide);
  UserFactory.registerLoginListener(HelpDiv.show);
</script>
