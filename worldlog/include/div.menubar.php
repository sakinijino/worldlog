<div id="menubar">
  <span>
  &nbsp;|&nbsp;<span id="menubar.map">地图切换</span>
  <div id="menubar.maplist" class="popupmenu" style="width:70px">
    <a href="index.php">Google地图</a><br/>
    <a href="index51ditu.php">本地地图</a><br/>
    <a href="javascript:window.location.reload()">刷新</a><br/>
  </div>
  </span>
  
  <span>
  &nbsp;|&nbsp;<span id="menubar.view">节点搜索</span>
  <div id="menubar.viewlist" class="popupmenu">
    <a href="javascript:TagDiv.show()">Tag搜索</a><br/>
  </div>
  </span>
  
  <span>
  &nbsp;|&nbsp;<span id="menubar.help">帮助信息</span>
  <div id="menubar.helplist" class="popupmenu">
    <a href='javascript:LastestItemsDiv.show()'>最新节点</a><br/>
    <a href="javascript:HelpDiv.show()">帮助信息</a><br/>
  </div>
  </span>
  
  <span id="menubar.unloginuser">
  &nbsp;|&nbsp;<span id="menubar.login">登陆菜单</span>
  <div id="menubar.loginlist" class="popupmenu">
    <a href='javascript:UserLoginDiv.show()'>登录</a><br/>
    <a href="javascript:UserSignupDiv.show()">注册</a><br/>
  </div>
  </span>
  
  <span id="menubar.loginuser" class="disappear">
  &nbsp;|&nbsp;<span id="menubar.userfunc" style="color:red">用户功能</span>
  <div id="menubar.userfunclist" class="popupmenu">
    <a href="javascript:ItemsDiv.show()">我的节点</a><br/>
    <a href="javascript:ProfilesDiv.show()">我的地图</a><br/>
    <a id="menubar.userlogoutlink" href="javascript:;">退出</a>
  </div>
  </span>
  &nbsp;|
</div>

<script>
  Page.popupMenu($("menubar.map"), $("menubar.maplist"));
  Page.popupMenu($("menubar.view"), $("menubar.viewlist"));
  Page.popupMenu($("menubar.help"), $("menubar.helplist"));
  Page.popupMenu($("menubar.login"), $("menubar.loginlist"));
  Page.popupMenu($("menubar.userfunc"), $("menubar.userfunclist"));
</script>
<script>
  function MenuBarDiv(){}
  
  UserFactory.registerLoginListener(function(){
    $("menubar.unloginuser").className = "disappear";
    $("menubar.loginuser").className = "";
  });
  UserFactory.registerLogoutListener(function(){
    $("menubar.unloginuser").className = "";
    $("menubar.loginuser").className = "disappear";
  });
  
  $("menubar.userlogoutlink").onclick = function(){
    AjaxRequest.user.logout();
  }
</script>