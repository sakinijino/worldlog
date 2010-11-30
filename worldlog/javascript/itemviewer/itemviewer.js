//mix in item
function ItemViewer() {}

ItemViewer.prototype.getTitle = function(iscreator) {
  var item = this;
  var spn = document.createElement('span');
  spn.className = "link"
  spn.innerHTML = item.title;
  spn.onclick = function() {
   item.onFocus();
  }
  return spn;
}

ItemViewer.prototype.getDelLink = function() {
  var item = this;
  var del = document.createElement('span');
  del.className = "link"
  del.innerHTML = "[删除]";
  del.onclick = function() {
    AjaxRequest.item.deleteItem(item);
  }
  return del;
}

ItemViewer.prototype.getLink = function() {
  var item = this;
  var l = document.createElement('a');
  l.setAttribute('href', item.link);
  l.setAttribute('target', '_blank');
  l.innerHTML = '[链接]';
  return l;
}

ItemViewer.prototype.getTagsSpan = function() {
  var item = this;
  var spn = document.createElement('span');
  item.tags.values().each(function(tag){
	  spn.appendChild(tag.getTagSpan());
	  spn.appendChild(document.createTextNode(' '));
	});
  return spn;
}

ItemViewer.prototype.getRatingSpan = function() {
  var item = this;
  var spn = document.createElement('span');
	spn.appendChild(document.createTextNode(item.goodrating+"/"+(item.goodrating+item.badrating)+"人觉得这个地点有用"));
  return spn;
}

ItemViewer.prototype.getRatingOpSpan = function() {
  var item = this;
  var spn = document.createElement('span');
  var grlink = document.createElement('span');
  grlink.className = "link"
  grlink.innerHTML = "[有用]";
  grlink.onclick = function() {
    AjaxRequest.item.incItemGoodRating(item);
  }
  var brlink = document.createElement('span');
  brlink.className = "link"
  brlink.innerHTML = "[没用]";
  brlink.onclick = function() {
    AjaxRequest.item.incItemBadRating(item);
  }
	spn.appendChild(document.createTextNode("对你"));
	spn.appendChild(grlink);
	spn.appendChild(document.createTextNode("/"));
	spn.appendChild(brlink);
  return spn;
}

ItemViewer.prototype.getEmbedMapLink = function() {
  var item = this;
  var l = document.createElement('a');
  l.setAttribute('href', '');
  l.setAttribute('target', '_blank');
  l.innerHTML = '生成嵌入地图';
  return l
}

ItemViewer.prototype.getGoogleModuleLink = function() {
  var item = this;
  var l = document.createElement('a');
  l.setAttribute('href', '');
  l.setAttribute('target', '_blank');
  l.innerHTML = '添加到Google';
  return l
}

ItemViewer.prototype.getProfilesLink = function() {
  var item = this;
  var spn = document.createElement('span');
  spn.className = 'link'
  spn.innerHTML = '添加到我的地图';
  var div = document.createElement('div');
  spn.appendChild(div);
  Page.popupMenu(spn, div, function() {
    div.innerHTML = "";
    if (Page.currentUser.profiles.values().length==0) return;
    Page.currentUser.profiles.values().each(function(profile){
      div.appendChild(profile.getItemAddSpan(item));
      div.appendChild(document.createElement('br'));
    });
  });
  return spn;
}

ItemViewer.prototype.getIconImg = function(width, height) {
  var item = this;
  var img = document.createElement('img');
  if (width!=null) img.style.width = width+'px';
  if (height!=null) img.style.height = height+'px';
  img.style.border = 0;
  img.src = item.typeobj.icon;
  return img;
}

ItemViewer.prototype.getHumanName = function() {
  var item = this;	
  return item.typeobj.humanname;
}

//-----------------------------------
ItemViewer.prototype.getDetailDiv = function() {
  var item = this;
  var div = document.createElement('div');
  div.appendChild(item.getIconImg(24, 24));
  div.appendChild(document.createTextNode(" "));
  div.appendChild(document.createTextNode(item.getHumanName()));
  div.appendChild(document.createElement('br'));
  
  div.appendChild(item.getTitle());
  div.appendChild(document.createTextNode(" "));
  div.appendChild(item.getLink());
  div.appendChild(document.createTextNode(" 点击数:" + item.visits+ " "));
  div.appendChild(document.createElement('br'));
  
  div.appendChild(document.createTextNode("tags: "));
	div.appendChild(item.getTagsSpan());
	div.appendChild(document.createElement('br'));
	
	div.appendChild(document.createElement('br'));
  
	div.appendChild(item.getRatingSpan());
	div.appendChild(document.createElement('br'));
	div.appendChild(item.getRatingOpSpan());
  div.appendChild(document.createElement('br'));
	
	div.appendChild(document.createElement('br'));
	
	div.appendChild(document.createTextNode("附加功能"));
	div.appendChild(document.createElement('br'));
  div.appendChild(item.getEmbedMapLink());
  div.appendChild(document.createTextNode(" "));
  div.appendChild(item.getGoogleModuleLink());
  div.appendChild(document.createTextNode(" "));
  div.appendChild(item.getProfilesLink());
  return div;
}

ItemViewer.prototype.getItemSpan = function(isowner) {
  var item = this;
  var spn = document.createElement('span');
  spn.appendChild(item.getIconImg(16, 16));
  spn.appendChild(document.createTextNode(" "));
  spn.appendChild(item.getTitle());
  spn.appendChild(document.createTextNode(" "));
  spn.appendChild(item.getLink());
  if (isowner) {
    spn.appendChild(document.createTextNode(" "));
    spn.appendChild(item.getDelLink());
  }
  return spn;
}

ItemViewer.prototype.getMapTitle = function(fontColor){
  var item = this;
  var div = document.createElement('div');
  if (fontColor!=null)
	  div.innerHTML= "<a class='map' href='"+item.link+"' target='_blank'><font color="+fontColor+">"+item.title+"</font></a>";
	else 
	  div.innerHTML= "<a class='map' href='"+item.link+"' target='_blank'>"+item.title+"</a>";
  return div;
}

ItemViewer.prototype.getOpenInfoWindow = function() {
  var item = this;
  var div = document.createElement('div');
	div.innerHTML= item.content;		
  return {div:div};
}

ItemViewer.prototype.getIcon = function() {
  var item = this;
  return item.typeobj.icon;
}