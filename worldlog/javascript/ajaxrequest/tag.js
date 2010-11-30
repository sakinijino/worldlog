AjaxRequest.Tag = function(){}

AjaxRequest.Tag.prototype.getAll = function(succcallback, errcallback) {
  new Ajax.Request(
	  AjaxRequest.serviceURL + 'tag/getall.php', 
		{
			method: 'post', 
			onComplete: function (originalRequest) {
			  var status = AjaxRequest.isSuccess(originalRequest);
			  if (status.err) {
			    if (errcallback!=null) errcallback(status.msg);
			  }
			  else {
			    var arr = new Array();
			    var domarr = originalRequest.responseXML.getElementsByTagName('tag');
			    for (var i=0; i<domarr.length; ++i) {
			      var tag = TagFactory.CreateFromDOM(domarr[i]);
			      arr.push(tag);
			    }
					if (succcallback!=null) succcallback(arr);
        }
		  }
		});
}