function BlogViewer() {}

BlogViewer.prototype = new ItemViewer();

BlogViewer.prototype.getOpenInfoWindow = function() {
  var item = this;
  var div = document.createElement('div');
  var content = "<iframe frameborder='0' width='300' height='150' marginheight='0' marginwidth='0' scrolling=auto src='"+item.content+"'></iframe>";
	div.innerHTML= content;
	return {div:div, maxwidth:400};
}