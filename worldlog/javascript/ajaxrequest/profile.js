AjaxRequest.Profile = function(){}

AjaxRequest.ProfileArray = new Array();

AjaxRequest.Profile.prototype.addProfile = function(name, longitude, latitude,
  zoomlevel, succcallback, errcallback) {
  var pars = {name:name, longitude:longitude, latitude:latitude, zoomlevel:zoomlevel};
  new Ajax.Request(
	  AjaxRequest.serviceURL + 'profile/addprofile.php', 
		{
			method: 'post', 
			parameters: $H(pars).toQueryString(), 
			onComplete: function (originalRequest) {
			  var status = AjaxRequest.isSuccess(originalRequest);
			  if (status.err) {
			    if (errcallback!=null) errcallback(status.msg);
			  }
			  else {
					var profile = ProfileFactory.CreateFromDOM(originalRequest.responseXML);
          if (succcallback!=null) succcallback(profile);
          profile.onCreate();
        }
		  }
		});
}

AjaxRequest.Profile.prototype.deleteProfile = function(profile, succcallback, errcallback) {
  var pars = {id:profile.id};
  new Ajax.Request(
	  AjaxRequest.serviceURL + 'profile/delprofile.php', 
		{
			method: 'post', 
			parameters: $H(pars).toQueryString(), 
			onComplete: function (originalRequest) {
			  var status = AjaxRequest.isSuccess(originalRequest);
			  if (status.err) {
			    if (errcallback!=null) errcallback(status.msg);
			  }
			  else {
					if (succcallback!=null) succcallback(profile);
          profile.onDelete();
        }
		  }
		});
}

AjaxRequest.Profile.prototype.getUserProfiles = function(user, succcallback, errcallback) {
  var pars = {userid:user.id};
  new Ajax.Request(
	  AjaxRequest.serviceURL + 'profile/getuserprofiles.php', 
		{
			method: 'post', 
			parameters: $H(pars).toQueryString(), 
			onComplete: function (originalRequest) {
			  var status = AjaxRequest.isSuccess(originalRequest);
			  if (status.err) {
			    if (errcallback!=null) errcallback(status.msg);
			  }
			  else {
			    var arr = new Array();
			    var domarr = originalRequest.responseXML.getElementsByTagName('profile');
			    for (var i=0; i<domarr.length; ++i) {
			      var profile = ProfileFactory.CreateFromDOM(domarr[i]);
			      arr.push(profile);
			    }
					if (succcallback!=null) succcallback(arr);
          arr.each(function(profile){
	          profile.items.values().each(function(item){
	            item.onLoad();
	          });
	        });
        }
		  }
		});
}

AjaxRequest.Profile.prototype.addItem = function(profile, item, succcallback, errcallback) {
  var pars = {id:profile.id, itemid:item.id};
  new Ajax.Request(
	  AjaxRequest.serviceURL + 'profile/additem.php', 
		{
			method: 'post', 
			parameters: $H(pars).toQueryString(), 
			onComplete: function (originalRequest) {
			  var status = AjaxRequest.isSuccess(originalRequest);
			  if (status.err) {
			    if (errcallback!=null) errcallback(status.msg);
			  }
			  else {
					profile.items[item.id] = item;
          if (succcallback!=null) succcallback(profile);
          profile.onAddItem(item);
        }
		  }
		});
}

AjaxRequest.Profile.prototype.delItem = function(profile, item, succcallback, errcallback) {
  var pars = {id:profile.id, itemid:item.id};
  new Ajax.Request(
	  AjaxRequest.serviceURL + 'profile/delitem.php', 
		{
			method: 'post', 
			parameters: $H(pars).toQueryString(), 
			onComplete: function (originalRequest) {
			  var status = AjaxRequest.isSuccess(originalRequest);
			  if (status.err) {
			    if (errcallback!=null) errcallback(status.msg);
			  }
			  else {
					delete profile.items[item.id];
          if (succcallback!=null) succcallback(profile);
          profile.onDelItem(item);
        }
		  }
		});
}