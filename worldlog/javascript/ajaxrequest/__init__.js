function AjaxRequest() {
}

AjaxRequest.serviceURL = "../worldlog_service/services/";

AjaxRequest.isSuccess = function(originalRequest) {
  var dom = originalRequest.responseXML;
  var err = dom.getElementsByTagName('error')[0];
  var msg = "";
  if (err!=null && err.firstChild!=null)
    return {succ:false, err:true, msg:err.firstChild.nodeValue};
  
  var succ = dom.getElementsByTagName('success')[0];
  var msg = "";
  if (succ!=null && succ.firstChild!=null)
    return {succ:true, err:false, msg:succ.firstChild.nodeValue};
  
  return {succ:true, err:false, msg:""};
}

AjaxRequest.createFacade = function() {
  AjaxRequest.user = new AjaxRequest.User();
  AjaxRequest.item = new AjaxRequest.Item();
  AjaxRequest.tag = new AjaxRequest.Tag();
  AjaxRequest.profile = new AjaxRequest.Profile();
}