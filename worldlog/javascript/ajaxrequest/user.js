AjaxRequest.User = function(){}

AjaxRequest.User.prototype.login = function(name, pw, succcallback, errcallback) {
  var pars = {name:name, password:pw};
  new Ajax.Request(
	  AjaxRequest.serviceURL + 'user/login.php', 
		{
			method: 'post', 
			parameters: $H(pars).toQueryString(), 
			onComplete: function (originalRequest) {
			  var status = AjaxRequest.isSuccess(originalRequest);
			  if (status.err) {
			    if (errcallback!=null) errcallback(status.msg);
			  }
			  else {
					Page.currentUser = UserFactory.CreateFromDOM(originalRequest.responseXML);
				  if (succcallback!=null) succcallback(Page.currentUser);
          Page.currentUser.onLogin();
        }
		  }
		});
}

AjaxRequest.User.prototype.logout = function(succcallback, errcallback) {
  new Ajax.Request(
	  AjaxRequest.serviceURL + 'user/logout.php', 
		{
			method: 'post', 
			onComplete: function (originalRequest) {
			    var status = AjaxRequest.isSuccess(originalRequest);
					if (status.succ){
					  Page.currentUser = UserFactory.Create();//clear user
					  if (succcallback!=null) succcallback(status.msg);
					  Page.currentUser.onLogout();
					}
				  else {
				    if (errcallback!=null) errcallback(status.msg);
				  }
				}
		});
}

AjaxRequest.User.prototype.signup = function(name, nickname, email, pw, succcallback, errcallback) {
  var pars = {name:name, nickname:nickname, email:email, password:pw};
  new Ajax.Request(
	  AjaxRequest.serviceURL + 'user/signup.php', 
		{
			method: 'post', 
			parameters: $H(pars).toQueryString(), 
			onComplete: function (originalRequest) {
			  var status = AjaxRequest.isSuccess(originalRequest);
			  if (status.err) {
			    if (errcallback!=null) errcallback(status.msg);
			  }
			  else {
				  Page.currentUser = UserFactory.CreateFromDOM(originalRequest.responseXML);
				  if (succcallback!=null) succcallback(Page.currentUser);
          Page.currentUser.onLogin();
        }
			}
		});
}