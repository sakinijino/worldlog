AjaxRequest.Item = function(){}

AjaxRequest.Item.LoadCache = $H([]);
AjaxRequest.Item.LoadCache.setItem = function(item) {
  if (AjaxRequest.Item.LoadCache[item.id]!=null) return AjaxRequest.Item.LoadCache[item.id];
  else {
    AjaxRequest.Item.LoadCache[item.id] = item;
    return item;
  }
};

AjaxRequest.Item.prototype.addBlog = function(lnt, lat, rss, title, tags, succcallback, errcallback) {
  var pars = {longitude:lnt, latitude:lat, link:rss, title:title, tags:tags, type:'blog'};
  new Ajax.Request(
	  AjaxRequest.serviceURL + 'item/additem.php', 
		{
			method: 'post', 
			parameters: $H(pars).toQueryString(), 
			onComplete: function (originalRequest) {
			  var status = AjaxRequest.isSuccess(originalRequest);
			  if (status.err) {
			    if (errcallback!=null) errcallback(status.msg);
			  }
			  else {
					var item = ItemFactory.CreateFromDOM(originalRequest.responseXML, 
					                                     AjaxRequest.Item.LoadCache);
          if (succcallback!=null) succcallback(item);
          item.onCreate();
        }
		  }
		});
}

AjaxRequest.Item.prototype.addLink = function(lnt, lat, link, title, tags, succcallback, errcallback) {
  var pars = {longitude:lnt, latitude:lat, link:link, title:title, tags:tags, type:'link'};
  new Ajax.Request(
	  AjaxRequest.serviceURL + 'item/additem.php', 
		{
			method: 'post', 
			parameters: $H(pars).toQueryString(), 
			onComplete: function (originalRequest) {
			  var status = AjaxRequest.isSuccess(originalRequest);
			  if (status.err) {
			    if (errcallback!=null) errcallback(status.msg);
			  }
			  else {
					var item = ItemFactory.CreateFromDOM(originalRequest.responseXML, 
					                                     AjaxRequest.Item.LoadCache);
          if (succcallback!=null) succcallback(item);
          item.onCreate();
        }
		  }
		});
}

AjaxRequest.Item.prototype.addDiary = function(title, content, lnt, lat, tags, succcallback, errcallback) {
  var pars = {longitude:lnt, latitude:lat, title:title, content:content, tags:tags, type:'diary'};
  new Ajax.Request(
	  AjaxRequest.serviceURL + 'item/additem.php', 
		{
			method: 'post', 
			parameters: $H(pars).toQueryString(), 
			onComplete: function (originalRequest) {
			  var status = AjaxRequest.isSuccess(originalRequest);
			  if (status.err) {
			    if (errcallback!=null) errcallback(status.msg);
			  }
			  else {
					var item = ItemFactory.CreateFromDOM(originalRequest.responseXML, 
					                                     AjaxRequest.Item.LoadCache);
          if (succcallback!=null) succcallback(item);
          item.onCreate();
        }
		  }
		});
}

AjaxRequest.Item.prototype.getLastestItems = function(num, succcallback, errcallback) {
  var pars = {num:10};
  new Ajax.Request(
	  AjaxRequest.serviceURL + 'item/getlatestitems.php', 
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
			    var domarr = originalRequest.responseXML.getElementsByTagName('item');
			    for (var i=0; i<domarr.length; ++i) {
			      var item = ItemFactory.CreateFromDOM(domarr[i]);
			      arr.push(item);
			    }
					if (succcallback!=null) succcallback(arr);
          arr.each(function(item){item.onLoad();});
        }
		  }
		});
}

AjaxRequest.Item.prototype.getUserItems = function(user, succcallback, errcallback) {
  var pars = {userid:user.id};
  new Ajax.Request(
	  AjaxRequest.serviceURL + 'item/getuseritems.php', 
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
			    var domarr = originalRequest.responseXML.getElementsByTagName('item');
			    for (var i=0; i<domarr.length; ++i) {
			      var item = ItemFactory.CreateFromDOM(domarr[i]);
			      arr.push(item);
			    }
					if (succcallback!=null) succcallback(arr);
          arr.each(function(item){item.onLoad();});
        }
		  }
		});
}

AjaxRequest.Item.prototype.getItemsByMapBound = function(map, succcallback, errcallback){
  if (map.getZoom() < 3) return;
  var rect = map.getRectLngLat();
  /*var minlnt = rect.minlnt;
	var minlat = rect.minlat;
	var maxlnt = rect.maxlnt;
  var maxlat = rect.maxlat;*/
  new Ajax.Request(
	  AjaxRequest.serviceURL + 'item/getitemsbybound.php', 
		{
			method: 'post',
			parameters: $H(rect).toQueryString(), 
			onComplete: function (originalRequest) {
			  var status = AjaxRequest.isSuccess(originalRequest);
			  if (status.err) {
			    if (errcallback!=null) errcallback(status.msg);
			  }
			  else {
			    var arr = new Array();
			    var domarr = originalRequest.responseXML.getElementsByTagName('item');
			    for (var i=0; i<domarr.length; ++i) {
			      var item = ItemFactory.CreateFromDOM(domarr[i]);
			      arr.push(item);
			    }
					if (succcallback!=null) succcallback(arr);
          arr.each(function(item){item.onLoad();});
        }
		  }
		});
}

AjaxRequest.Item.prototype.getTagItems = function(tname, succcallback, errcallback) {
  var pars = {tag:tname};
  new Ajax.Request(
	  AjaxRequest.serviceURL + 'item/gettagitems.php', 
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
			    var domarr = originalRequest.responseXML.getElementsByTagName('item');
			    for (var i=0; i<domarr.length; ++i) {
			      var item = ItemFactory.CreateFromDOM(domarr[i]);
			      arr.push(item);
			    }
					if (succcallback!=null) succcallback(arr);
          arr.each(function(item){item.onLoad();});
        }
		  }
		});
}

AjaxRequest.Item.prototype.incItemVisits = function(item, isupdateeventtrigger, succcallback, errcallback) {
  var pars = {op:'visit', id:item.id};
  new Ajax.Request(
	  AjaxRequest.serviceURL + 'item/itemops.php', 
		{
			method: 'post',
			parameters: $H(pars).toQueryString(), 
			onComplete: function (originalRequest) {
			  var status = AjaxRequest.isSuccess(originalRequest);
			  if (status.err) {
			    if (errcallback!=null) errcallback(status.msg);
			  }
			  else {
			    item.visits+=1;
          if (succcallback!=null) succcallback(item);
          if (isupdateeventtrigger) item.onUpdate();
        }
		  }
		});
}

AjaxRequest.Item.prototype.incItemGoodRating = function(item, succcallback, errcallback) {
  var pars = {op:'goodrate', id:item.id};
  new Ajax.Request(
	  AjaxRequest.serviceURL + 'item/itemops.php', 
		{
			method: 'post',
			parameters: $H(pars).toQueryString(), 
			onComplete: function (originalRequest) {
			  var status = AjaxRequest.isSuccess(originalRequest);
			  if (status.err) {
			    if (errcallback!=null) errcallback(status.msg);
			  }
			  else {
			    item.goodrating+=1;
          if (succcallback!=null) succcallback(item);
          item.onUpdate();
        }
		  }
		});
}

AjaxRequest.Item.prototype.incItemBadRating = function(item, succcallback, errcallback) {
  var pars = {op:'badrate', id:item.id};
  new Ajax.Request(
	  AjaxRequest.serviceURL + 'item/itemops.php', 
		{
			method: 'post',
			parameters: $H(pars).toQueryString(), 
			onComplete: function (originalRequest) {
			  var status = AjaxRequest.isSuccess(originalRequest);
			  if (status.err) {
			    if (errcallback!=null) errcallback(status.msg);
			  }
			  else {
			    item.badrating+=1;
          if (succcallback!=null) succcallback(item);
          item.onUpdate();
        }
		  }
		});
}

AjaxRequest.Item.prototype.deleteItem = function(item, succcallback, errcallback) {
  var pars = {id:item.id};
  new Ajax.Request(
	  AjaxRequest.serviceURL + 'item/delitem.php', 
		{
			method: 'post',
			parameters: $H(pars).toQueryString(), 
			onComplete: function (originalRequest) {
			  var status = AjaxRequest.isSuccess(originalRequest);
			  if (status.err) {
			    if (errcallback!=null) errcallback(status.msg);
			  }
			  else {
			    delete AjaxRequest.Item.LoadCache[item.id];
          if (succcallback!=null) succcallback(item);
          item.onDelete();
        }
		  }
		});
}