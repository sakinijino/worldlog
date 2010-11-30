AjaxRequest.Tag = function(){}

AjaxRequest.TagArray = $H([]);

AjaxRequest.Tag.prototype.getAll = function(succcallback, errcallback) {
  if (true) {
    //-------------------------------------
    var arr = new Array();
    AjaxRequest.TagArray.values().each(function(t){
      arr.push(TagFactory.Clone(t));
    });
    //-------------------------------------
    if (succcallback!=null) succcallback(arr);
  }
  else {
    if (errcallback!=null) errcallback();
  }
}