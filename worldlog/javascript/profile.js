function Profile() {
  this.id = 0;
  this.userid = 0;
  this.name="";
  this.longitude=0;
  this.latitude=0;
  this.zoomlevel=0;
  this.items = $H([]);
}
Profile.prototype.getSelectSpan = function(iscreator) {
  var profile = this;
  var spn = document.createElement('span');
  var title = document.createElement('span');
  title.className = 'link';
  title.innerHTML = profile.name;
  title.selected = false;
  title.onclick = function() {profile.onSelect();}
  spn.appendChild(title);
  spn.appendChild(document.createTextNode(' '));
  
  var itemsdiv = document.createElement('div');
  itemsdiv.className = "disappear";
  itemsdiv.hide = true;
  itemsdiv.style.marginLeft = "5px";
  var expbtn = document.createElement('span');
  expbtn.className = 'link';
  expbtn.innerHTML = '[展开]';
  var gendiv = function() {
    itemsdiv.innerHTML = "";
    profile.items.values().each(function(item){
      itemsdiv.appendChild(item.getItemSpan(false));
      if (iscreator) {
        var delbtn = document.createElement('span');
        delbtn.className = 'link';
        delbtn.innerHTML = '[删除]';
        delbtn.onclick = function() {
          AjaxRequest.profile.delItem(profile, item);
        }
        itemsdiv.appendChild(document.createTextNode(' '));
        itemsdiv.appendChild(delbtn);
      }
      itemsdiv.appendChild(document.createElement('br'));
    });
  };
  profile.registerAddItemListener(gendiv);
  profile.registerDelItemListener(gendiv);
  gendiv();
  expbtn.onclick = function() {
    if (itemsdiv.hide) {
      itemsdiv.className = "";
      itemsdiv.hide = false;
      expbtn.innerHTML = '[折叠]';
    }
    else {
      itemsdiv.className = "disappear";
      itemsdiv.hide = true;
      expbtn.innerHTML = '[展开]';
    }
  }
  spn.appendChild(expbtn);
  spn.appendChild(document.createTextNode(' '));
  
  if (iscreator) {
    var delbtn = document.createElement('span');
    delbtn.className = 'link';
    delbtn.innerHTML = '[删除]';
    delbtn.onclick = function() {
      AjaxRequest.profile.deleteProfile(profile);
    }
    spn.appendChild(delbtn);
  }
  
  spn.appendChild(itemsdiv);
  return spn;
}

Profile.prototype.getItemAddSpan = function(item) {
  var profile = this;
  var spn = document.createElement('span');
  spn.className = 'link';
  spn.innerHTML = profile.name;
  spn.onclick = function() {
    AjaxRequest.profile.addItem(profile, item);
  }
  return spn;
}

Profile.Events = ['Create', 'Delete', 'Select', 'AddItem', 'DelItem', 'UnSelect'];
Model.generateClassEvents(Profile, Profile.Events);
Profile.prototype.onAddItem = function(item) {
  var profile = this;
  this.additemlisteners.each(function(listener){
    listener(profile, item);
  });
}
Profile.prototype.onDelItem = function(item) {
  var profile = this;
  this.delitemlisteners.each(function(listener){
    listener(profile, item);
  });
}

//----------------------------------------------
function ProfileFactory() {}

ProfileFactory.Create = function() {
  var profile = new Profile();
  this.initListeners(profile);
  return profile;
}

ProfileFactory.CreateFromDOM = function(dom) {
  var profile = new Profile();

  XmlParserHelper.objPropXmlElemMapping(profile, dom, 'id');
  XmlParserHelper.objPropXmlElemMapping(profile, dom, 'userid');
  XmlParserHelper.objPropXmlElemMapping(profile, dom, 'name');
  XmlParserHelper.objPropXmlElemMapping(profile, dom, 'longitude');
  XmlParserHelper.objPropXmlElemMapping(profile, dom, 'latitude');
  XmlParserHelper.objPropXmlElemMapping(profile, dom, 'zoomlevel');
  XmlParserHelper.objPropXmlElemMapping(profile, dom, 'items', true);

  profile.id=Number(profile.id);
  profile.userid=Number(profile.userid);
  profile.longitude=Number(profile.longitude);
	profile.latitude=Number(profile.latitude);
	profile.zoomlevel=Number(profile.zoomlevel);

	//if (profile.items=="") //can't use in IE...
	if (dom.getElementsByTagName('items')[0].firstChild==null)//for IE compatiable
	  profile.items = $H([]);
  else {
	  var domarr = profile.items.getElementsByTagName('item');
	  profile.items = $H([]);
	  for (var i=0; i<domarr.length; ++i) {
	    var item = ItemFactory.CreateFromDOM(domarr[i]);//add cache, if not use global cache
  	  profile.items[item.id] = item;
	  }
	}	

  this.initListeners(profile);
  return profile;
}

ProfileFactory.Clone = function(p) {
  var profile = new Profile();
  profile = Object.extend(profile, p);
  profile.items = $H([]);
  p.items.values().each(function(item) {
    var i = ItemFactory.Clone(item);
    profile.items[i.id] = i;
  });
  this.initListeners(profile);
  return profile;
}
Model.generateFactoryEvents(ProfileFactory, Profile.Events);