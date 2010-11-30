AjaxRequest.Item = function(){}

AjaxRequest.ItemArray = new Array();

AjaxRequest.Item.LoadCache = $H([]);
AjaxRequest.Item.LoadCache.setItem = function(item) {
  if (AjaxRequest.Item.LoadCache[item.id]!=null) return AjaxRequest.Item.LoadCache[item.id];
  else {
    AjaxRequest.Item.LoadCache[item.id] = item;
    return item;
  }
};

AjaxRequest.Item.prototype.addBlog = function(lnt, lat, rss, title, tags, succcallback, errcallback) {
  if (true) {
    //---------------------------------
    var item = ItemFactory.Create('blog');
    item.id = AjaxRequest.ItemArray.length;
    item.userid = Page.currentUser.id;
    item.longitude=lnt;
	  item.latitude=lat;
	  item.link=rss;
	  if (title=="") title="a blog";
	  item.title=title;
	  item.content=rss;
	  var tagarr = tags.split(" ");
	  tagarr.each(function(t){
	    if (t=='') return;
	    var tag;
	    if (AjaxRequest.TagArray[t]) {
	      ++AjaxRequest.TagArray[t].num;
	      tag = AjaxRequest.TagArray[t];
	    }
	    else {
	      tag = TagFactory.Create();
	      tag.name = t;
	      tag.num = 1;
	      AjaxRequest.TagArray[tag.name] = tag;
	    }
	    item.tags[t] = tag;
	  });
	  AjaxRequest.ItemArray.push(item);
	  item = ItemFactory.Clone(item);
	  //-------------------------------------
	  item = AjaxRequest.Item.LoadCache.setItem(item);
    if (succcallback!=null) succcallback(item);
    item.onCreate();
  }
  else {
    if (errcallback!=null) errcallback();
  }
}

AjaxRequest.Item.prototype.addLink = function(lnt, lat, link, title, tags, succcallback, errcallback) {
  if (true) {
    //---------------------------------
    var item = ItemFactory.Create('link');
    item.id = AjaxRequest.ItemArray.length;
    item.userid = Page.currentUser.id;
    item.longitude=lnt;
	  item.latitude=lat;
	  item.link=link;
	  if (title=="") title="a link";
	  item.title=title;
	  item.content=link;
	  var tagarr = tags.split(" ");
	  tagarr.each(function(t){
	    if (t=='') return;
	    var tag;
	    if (AjaxRequest.TagArray[t]) {
	      ++AjaxRequest.TagArray[t].num;
	      tag = AjaxRequest.TagArray[t];
	    }
	    else {
	      tag = TagFactory.Create();
	      tag.name = t;
	      tag.num = 1;
	      AjaxRequest.TagArray[tag.name] = tag;
	    }
	    item.tags[t] = tag;
	  });
	  AjaxRequest.ItemArray.push(item);
	  item = ItemFactory.Clone(item);
	  //-------------------------------------
	  item = AjaxRequest.Item.LoadCache.setItem(item);
    if (succcallback!=null) succcallback(item);
    item.onCreate();
  }
  else {
    if (errcallback!=null) errcallback();
  }
}

AjaxRequest.Item.prototype.addDiary = function(title, content, lnt, lat, tags, succcallback, errcallback) {
  if (true) {
    //---------------------------------
    var item = ItemFactory.Create('diary');
    item.id = AjaxRequest.ItemArray.length;
    item.userid = Page.currentUser.id;
    item.longitude=lnt;
	  item.latitude=lat;
	  item.link='';
	  item.title=title;
	  item.content=content;
	  var tagarr = tags.split(" ");
	  tagarr.each(function(t){
	    if (t=='') return;
	    var tag;
	    if (AjaxRequest.TagArray[t]) {
	      ++AjaxRequest.TagArray[t].num;
	      tag = AjaxRequest.TagArray[t];
	    }
	    else {
	      tag = TagFactory.Create();
	      tag.name = t;
	      tag.num = 1;
	      AjaxRequest.TagArray[tag.name] = tag;
	    }
	    item.tags[t] = tag;
	  });
	  AjaxRequest.ItemArray.push(item);
	  item = ItemFactory.Clone(item);
	  //-------------------------------------
	  item = AjaxRequest.Item.LoadCache.setItem(item);
    if (succcallback!=null) succcallback(item);
    item.onCreate();
  }
  else {
    if (errcallback!=null) errcallback();
  }
}

AjaxRequest.Item.prototype.getLastestItems = function(num, succcallback, errcallback) {
  if (true) {
    //-------------------------------------
    var low = AjaxRequest.ItemArray.length-num;
    var high = AjaxRequest.ItemArray.length;
	  var lis = AjaxRequest.ItemArray.slice(low>0?low:0, high>0?high:0);
	  var re = new Array();
	  lis.each(function(i){
      re.push(ItemFactory.Clone(i));
    });
	  //-------------------------------------
	  var arr = new Array();
	  re.each(function(i){
	    i = AjaxRequest.Item.LoadCache.setItem(i);
	    arr.push(i);
	  });
    if (succcallback!=null) succcallback(arr);
    arr.each(function(item){
      item.onLoad();
    });
  }
  else {
    if (errcallback!=null) errcallback();
  }
}

AjaxRequest.Item.prototype.getUserItems = function(user, succcallback, errcallback) {
  if (true) {
    //-------------------------------------
	  var uis = AjaxRequest.ItemArray.partition(function(item){
	    if (user.id == item.userid) return true;
	  })[0];
	  var re = new Array();
	  uis.each(function(i){
      re.push(ItemFactory.Clone(i));
    });
	  //-------------------------------------
	  var arr = new Array();
	  re.each(function(i){
	    i = AjaxRequest.Item.LoadCache.setItem(i);
	    arr.push(i);
	  });
    if (succcallback!=null) succcallback(arr);
    arr.each(function(item){
      item.onLoad();
    });
  }
  else {
    if (errcallback!=null) errcallback();
  }
}

AjaxRequest.Item.prototype.getItemsByMapBound = function(map, succcallback, errcallback){
  if (map.getZoom() < 3) return;
  var rect = map.getRectLngLat();
	var minlnt = rect.minlnt;
	var minlat = rect.minlat;
	var maxlnt = rect.maxlnt;
  var maxlat = rect.maxlat;
  if (true) {
    //-------------------------------------
	  var tis = AjaxRequest.ItemArray.partition(function(item){
	    return item.isInRect(maxlnt, minlnt, maxlat, minlat);
	  })[0];
	  var re = new Array();
	  tis.each(function(i){
      re.push(ItemFactory.Clone(i));
    });
	  //-------------------------------------
	  var arr = new Array();
	  re.each(function(i){
	    i = AjaxRequest.Item.LoadCache.setItem(i);
	    arr.push(i);
	  });
    if (succcallback!=null) succcallback(arr);
    arr.each(function(item){
      item.onLoad();
    });
  }
  else {
    if (errcallback!=null) errcallback();
  }
}

AjaxRequest.Item.prototype.getTagItems = function(tname, succcallback, errcallback) {
  if (true) {
    //-------------------------------------
	  var tis = AjaxRequest.ItemArray.partition(function(item){
	    if (item.tags[tname]) return true;
	  })[0];
	  var re = new Array();
	  tis.each(function(i){
      re.push(ItemFactory.Clone(i));
    });
	  //-------------------------------------
	  var arr = new Array();
	  re.each(function(i){
	    i = AjaxRequest.Item.LoadCache.setItem(i);
	    arr.push(i);
	  });
    if (succcallback!=null) succcallback(arr);
    arr.each(function(item){
      item.onLoad();
    });
  }
  else {
    if (errcallback!=null) errcallback();
  }
}

AjaxRequest.Item.prototype.incItemVisits = function(item, isupdateeventtrigger, succcallback, errcallback) {
  //-------------------------------------
  if (item!=null && Page.currentUser.id==item.userid) {
    var tmp = AjaxRequest.ItemArray.find(function(i){return i.id==item.id});
    if (tmp==null) return;
	  var index = AjaxRequest.ItemArray.indexOf(tmp);
	  AjaxRequest.ItemArray[index].visits+=1;
	  //-------------------------------------
	  item.visits+=1;
    if (succcallback!=null) succcallback(item);
    if (isupdateeventtrigger) item.onUpdate();
  }
  else {
    if (errcallback!=null) errcallback();
  }
}

AjaxRequest.Item.prototype.incItemGoodRating = function(item, succcallback, errcallback) {
  //-------------------------------------
  if (item!=null && Page.currentUser.id==item.userid) {
    var tmp = AjaxRequest.ItemArray.find(function(i){return i.id==item.id});
    if (tmp==null) return;
	  var index = AjaxRequest.ItemArray.indexOf(tmp);
	  AjaxRequest.ItemArray[index].goodrating+=1;
	  //-------------------------------------
	  item.goodrating+=1;
    if (succcallback!=null) succcallback(item);
    item.onUpdate();
  }
  else {
    if (errcallback!=null) errcallback();
  }
}

AjaxRequest.Item.prototype.incItemBadRating = function(item, succcallback, errcallback) {
  //-------------------------------------
  if (item!=null && Page.currentUser.id==item.userid) {
    var tmp = AjaxRequest.ItemArray.find(function(i){return i.id==item.id});
    if (tmp==null) return;
	  var index = AjaxRequest.ItemArray.indexOf(tmp);
	  AjaxRequest.ItemArray[index].badrating+=1;
	  //-------------------------------------
	  item.badrating+=1;
    if (succcallback!=null) succcallback(item);
    item.onUpdate();
  }
  else {
    if (errcallback!=null) errcallback();
  }
}

AjaxRequest.Item.prototype.deleteItem = function(item, succcallback, errcallback) {
  //-------------------------------------
  if (item!=null && Page.currentUser.id==item.userid) {
	  AjaxRequest.ItemArray = AjaxRequest.ItemArray.partition(function(i){
	    if (i.id != item.id) return true;
	  })[0];
	  item.tags.values().each(function(tag){
      --AjaxRequest.TagArray[tag.name].num;
      if (AjaxRequest.TagArray[tag.name].num <= 0) delete AjaxRequest.TagArray[tag.name];
	  });
	  AjaxRequest.ProfileArray.each(function(p){
      if (p.items[item.id]!=null) {
        delete p.items[item.id];
      }
    });
	  //-------------------------------------
	  delete AjaxRequest.Item.LoadCache[item.id];
    if (succcallback!=null) succcallback(item);
    item.onDelete();
  }
  else {
    if (errcallback!=null) errcallback();
  }
}