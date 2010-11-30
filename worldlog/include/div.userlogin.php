<!--View-->
<div id="userlogin" class="section">
  想添加您的Blog,请登录或注册:<br/> 
  用户: <input type="text" size='20' id="userlogin.name"/><br/>
  密码: <input type="password" size='20' id="userlogin.password"/><br/><br/>
  <input id="userlogin.loginbtn" type="button" value="登录">
  <input type="button" value="注册" onclick="UserSignupDiv.show();">
  <span id="userlogin.loginloading" class="disappear">&nbsp;<img src=images/loading.gif>&nbsp;登陆中...</span>
</div>

<!--Controller-->
<script>
  function UserLoginDiv(){}
  
  Page.generateShowHideFunc(UserLoginDiv, $("userlogin"), false);
  
  UserLoginDiv.loginBtnOnClick = function() {
    if ($F("userlogin.name")=="" || $F("userlogin.password")=="") {
      alert("用户名、密码不能为空");
      return;
    }
    $("userlogin.loginloading").className = "";
    
    AjaxRequest.user.login($F("userlogin.name"), $F("userlogin.password"),
      function(){
        $("userlogin.loginloading").className = "disappear";
        $("userlogin.password").value= "";
      }, 
      function(msg){
        $("userlogin.loginloading").className = "disappear";
        if (msg==null || msg=="") msg = "登陆失败";
        alert(msg);
    });
  }
  $("userlogin.loginbtn").onclick = UserLoginDiv.loginBtnOnClick;
  
  UserFactory.registerLogoutListener(UserLoginDiv.show);
  UserFactory.registerLoginListener(UserLoginDiv.hide);
</script>