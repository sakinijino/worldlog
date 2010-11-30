function Page(){}

Page.currentUser = null;
Page.map = null;
AjaxRequest.facade = null;

Page.init = function() {
  Page.currentUser = UserFactory.Create();
  AjaxRequest.createFacade();
  
  UserFactory.registerLoginListener(function(user) {
    AjaxRequest.item.getUserItems(user, function(arr){
      arr.each(function(i){user.items[i.id] = i;});
      user.onUserItemsLoad();
    });
  });
  UserFactory.registerLoginListener(function(user) {
    AjaxRequest.profile.getUserProfiles(user, function(arr){
      arr.each(function(p){user.profiles[p.id] = p;});
      user.onUserProfilesLoad();
    });
  });
  
  ProfileFactory.registerCreateListener(function(profile){
    Page.currentUser.profiles[profile.id] = profile;
    Page.currentUser.onUserProfilesUpdate();
  });
  ProfileFactory.registerDeleteListener(function(profile){
    delete Page.currentUser.profiles[profile.id];
    Page.currentUser.onUserProfilesUpdate();
  });
  
  ItemFactory.registerCreateListener(function(item){
    Page.currentUser.items[item.id] = item;
    Page.currentUser.onUserItemsUpdate();
  });
  ItemFactory.registerDeleteListener(function(item){
    delete Page.currentUser.items[item.id];
    Page.currentUser.onUserItemsUpdate();
    Page.currentUser.profiles.values().each(function(p){
      if (p.items[item.id]!=null) {
        delete p.items[item.id];
        p.onDelItem(item);
      }
    });
  });
  ItemFactory.registerFocusListener(function(item){
    AjaxRequest.item.incItemVisits(item, false);
  });
  
  MapItemFactory.registerClickListener(function(mi){
    mi.item.onFocus();
	  mi.centerDisplay();
  });
  
  WorldlogMapFactory.registerMoveEndListener(AjaxRequest.item.getItemsByMapBound);
  WorldlogMapFactory.registerZoomListener(AjaxRequest.item.getItemsByMapBound);
}

Page.run = function() {
  //move this code from mapdiv to here, because of IE compatiable
  Page.map = WorldlogMapFactory.Create($("map"), 116.38933181762695, 39.92040099117151, 14);
  ItemFactory.registerCreateListener(Page.map.addItem.bind(Page.map));
  ItemFactory.registerLoadListener(Page.map.addItem.bind(Page.map));
  ItemFactory.registerDeleteListener(Page.map.delItem.bind(Page.map));
  
  TagFactory.registerSelectListener(Page.map.setTag.bind(Page.map));
  TagFactory.registerUnSelectListener(function(tag){
    Page.map.setTag(null);
  });
  
  ProfileFactory.registerSelectListener(Page.map.setProfile.bind(Page.map));
  ProfileFactory.registerUnSelectListener(function(tag){
    Page.map.setProfile(null);
  });
  
  Page.map.onMoveEnd();
  LastestItemsDiv.show();
}

//---------------------------------------------------
//View Helper. eg, Generate Div Close Button, etc
Page.generateShowHideFunc = function(divnamespace, div, ishide, showfunc, hidefunc) {
  divnamespace.ishide = ishide;
  divnamespace.hide = function() {
    if (divnamespace.ishide) {
      divnamespace.ishide = true;
      return;
    }
    divnamespace.ishide = true;
    if (hidefunc!=null) hidefunc();
    div.className = "section disappear";
  }
  divnamespace.show = function() {
    if (!divnamespace.ishide) {
      divnamespace.ishide = false;
      return;
    }
    divnamespace.ishide = false;
    if (showfunc!=null) showfunc();
    div.className = "section";
  }
  
  var closelnk = document.createElement('a');
  closelnk.href = "javascript:;";
  closelnk.innerHTML = "<img src=images/close.gif>"
  closelnk.onclick = divnamespace.hide;
  
  div.insertBefore(document.createElement('br'), div.firstChild);
  div.insertBefore(closelnk, div.firstChild);
}

Page.popupMenu = function(span, div, showfunc, hidefunc) {
  div.className = "popupmenu disappear";
  div.hide = true;
  span.onclick = function() {
    if (div.hide) {
      if (showfunc!=null) showfunc();
      div.className = "popupmenu";
      div.hide = false;
      if (navigator.userAgent.indexOf('MSIE')) {//need to find ie solution, now there has a bug
	      div.style.left = span.offsetLeft + 'px';
	      div.style.top = span.offsetHeight + 'px';
	    }
	    else
	      div.style.left = span.offsetLeft + 'px';
	  }
	  else {
	    if (hidefunc!=null) hidefunc();
	    div.className = "popupmenu disappear";
      div.hide = true;
	  }
	}
	var spnclass = span.className;
	span.onmouseover = function() {
	  span.className = "link";
	}
	span.onmouseout = function() {
	  span.className = spnclass;
	}
}