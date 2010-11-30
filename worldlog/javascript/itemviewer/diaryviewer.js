function DiaryViewer() {}

DiaryViewer.prototype = new ItemViewer();

DiaryViewer.prototype.getLink = function() {
  var spn = document.createElement('span');
  spn.className = "disappear";
  return spn;
}

DiaryViewer.prototype.getMapTitle = function(fontColor) {
  var item = this;
  var div = document.createElement('div');
  if (fontColor!=null)
	  div.innerHTML= "<font color="+fontColor+">"+item.title+"</font>";
	else 
	  div.innerHTML= item.title;
  return div;
}

DiaryViewer.prototype.getOpenInfoWindow = function() {
  var item = this;
  var div = document.createElement('div');
  var content = "<h2>"+item.title+"</h2>";
  content += "<div style='font-color:#999999'>"+item.createtime.toLocaleDateString()+"</div>";
  content += "<br/>";
  content += "<div style='font-color:#333333'>"+item.content+"</div>";
	div.innerHTML= content;
  return {div:div, maxwidth:400};
}