<!--View-->
<div id="usersignup" class="section disappear">
  请输入用户名: <input type="text" size='14' id="usersignup.name"/><br/>
  请输入昵称: <input type="text" size='14' id="usersignup.nick"/><br/>
  请输入email: <input type="text" size='14' id="usersignup.email"/><br/>
  请输入密码: <input type="password" size='14' id="usersignup.pw"/><br/>
  请确认密码: <input type="password" size='14' id="usersignup.cfmpw"/><br/>
  <input id="usersignup.signupbtn" type="button" value="注册">
  <span id="usersignup.loading" class="disappear">&nbsp;<img src=images/loading.gif>&nbsp;注册中...</span>
</div>

<!--Controller-->
<script>
  function UserSignupDiv(){}
  
  Page.generateShowHideFunc(UserSignupDiv, $("usersignup"), true);
  
  UserSignupDiv.signupBtnOnClick = function() {
    if ($F("usersignup.name")=="" || $F("usersignup.pw")=="") {
      alert("用户名、密码不能为空");
      return;
    }
    if ($F("usersignup.pw") != $F("usersignup.cfmpw")) {
      alert("密码不一致");
      return;
    }
    $("usersignup.loading").className = "";  
    AjaxRequest.user.signup($F("usersignup.name"), $F("usersignup.nick"),
      $F("usersignup.email"), $F("usersignup.pw"), 
      function(){
        $("usersignup.loading").className = "disappear";
        $("usersignup.name").value = "";
        $("usersignup.nick").value = "";
        $("usersignup.email").value = "";
        $("usersignup.pw").value = "";
        $("usersignup.cfmpw").value = "";
      }, 
      function(msg){
        $("usersignup.loading").className = "disappear";
        if (msg==null || msg=="") msg = "注册失败";
        alert(msg);
    });
  }
  $("usersignup.signupbtn").onclick = UserSignupDiv.signupBtnOnClick;
  
  UserFactory.registerLoginListener(UserSignupDiv.hide);
</script>