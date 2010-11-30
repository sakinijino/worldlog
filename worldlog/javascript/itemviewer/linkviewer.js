function LinkViewer() {}

LinkViewer.prototype = new ItemViewer();

LinkViewer.prototype.getOpenInfoWindow = function() {
  var item = this;
  var div = document.createElement('div');
  var content = "<h2>"+item.title+"</h2>";
  content += "<iframe frameborder='0' width='300' height='150' marginheight='0' marginwidth='0' scrolling=auto src='"+item.link+"'></iframe>";
	div.innerHTML= content;
	return {div:div, maxwidth:400};
}