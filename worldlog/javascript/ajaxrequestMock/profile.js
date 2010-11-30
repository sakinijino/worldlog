AjaxRequest.Profile = function(){}

AjaxRequest.ProfileArray = new Array();

AjaxRequest.Profile.prototype.addProfile = function(name, longitude, latitude,
  zoomlevel, succcallback, errcallback) {
  if (true) {
    var p = ProfileFactory.Create();
    p.id = AjaxRequest.ProfileArray.length;
    p.userid = Page.currentUser.id;
    p.name=name;
    p.longitude=longitude;
    p.latitude=latitude;
    p.zoomlevel=zoomlevel;
    AjaxRequest.ProfileArray.push(p);
    var profile = ProfileFactory.Clone(p);
    //----------------------------------------------
    if (succcallback!=null) succcallback(profile);
    profile.onCreate();
  }
  else {
    if (errcallback!=null) errcallback();
  }
}

AjaxRequest.Profile.prototype.deleteProfile = function(profile, succcallback, errcallback) {
  //-------------------------------------
  if (profile!=null && Page.currentUser.id==profile.userid) {
	  AjaxRequest.ProfileArray = AjaxRequest.ProfileArray.partition(function(p){
	    if (p.id != profile.id) return true;
	  })[0];
	  //-------------------------------------
    if (succcallback!=null) succcallback(profile);
    profile.onDelete();
  }
  else {
    if (errcallback!=null) errcallback();
  }
}

AjaxRequest.Profile.prototype.getUserProfiles = function(user, succcallback, errcallback) {
  if (true) {
    //-------------------------------------
	  var uis = AjaxRequest.ProfileArray.partition(function(profile){
	    if (user.id == profile.userid) return true;
	  })[0];
	  var re = new Array();
	  uis.each(function(p){
      re.push(ProfileFactory.Clone(p));
    });
	  //-------------------------------------
	  var arr = re;
	  arr.each(function(profile){
	    profile.items.values().each(function(item){
	      item = AjaxRequest.Item.LoadCache.setItem(item);
	      profile.items[item.id] = item;
	      item.onLoad();
	    });
	  })
    if (succcallback!=null) succcallback(arr);
  }
  else {
    if (errcallback!=null) errcallback();
  }
}

AjaxRequest.Profile.prototype.addItem = function(profile, item, succcallback, errcallback) {
  if (true) {
    //-------------------------------------
	  var p = AjaxRequest.ProfileArray.find(function(p){
	    if (p.id == profile.id) return true;
	  });
	  var i = AjaxRequest.ItemArray.find(function(i){
	    if (i.id == item.id) return true;
	  });
	  if (p.items[i.id] == i) return;
	  p.items[i.id] = i;
	  //-------------------------------------
	  profile.items[item.id] = item;
    if (succcallback!=null) succcallback(profile);
    profile.onAddItem(item);
  }
  else {
    if (errcallback!=null) errcallback();
  }
}

AjaxRequest.Profile.prototype.delItem = function(profile, item, succcallback, errcallback) {
  if (true) {
    //-------------------------------------
	  var p = AjaxRequest.ProfileArray.find(function(p){
	    if (p.id == profile.id) return true;
	  });
	  delete p.items[item.id];
	  //-------------------------------------
	  delete profile.items[item.id];
    if (succcallback!=null) succcallback(profile);
    profile.onDelItem(item);
  }
  else {
    if (errcallback!=null) errcallback();
  }
}