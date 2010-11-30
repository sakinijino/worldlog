AjaxRequest.User = function(){}

AjaxRequest.UserArray = new Array();

AjaxRequest.User.prototype.login = function(name, pw, succcallback, errcallback) {
  if ((AjaxRequest.UserArray.length != 0) &&
      AjaxRequest.UserArray.any(function(u){
        if (u.name == name && u.password == pw) {
          Page.currentUser = UserFactory.Clone(u);
          Page.currentUser.authKey = u.id.toString();
          Page.currentUser.password = "";
          return true;
        }
      })) {
    if (succcallback!=null) succcallback(Page.currentUser);
    Page.currentUser.onLogin();
  }
  else {
    if (errcallback!=null) errcallback();
  }
}

AjaxRequest.User.prototype.logout = function(succcallback, errcallback) {
  Page.currentUser = UserFactory.Create();//clear user
  if (succcallback!=null) succcallback();
  Page.currentUser.onLogout();
}

AjaxRequest.User.prototype.signup = function(name, nickname, email, pw, succcallback, errcallback) {
  if (true) {
    var u = UserFactory.Create();
    u.id = AjaxRequest.UserArray.length;
    u.name = name;
    u.email = email;
    u.nickname = nickname;
    u.password = pw;
    AjaxRequest.UserArray.push(u);
    if (succcallback!=null) succcallback();
    this.login(name, pw, succcallback, errcallback);
  }
  else {
    if (errcallback!=null) errcallback();
  }
}