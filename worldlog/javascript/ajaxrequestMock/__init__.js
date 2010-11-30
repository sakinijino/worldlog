function AjaxRequest() {
}

AjaxRequest.createFacade = function() {
  AjaxRequest.user = new AjaxRequest.User();
  AjaxRequest.item = new AjaxRequest.Item();
  AjaxRequest.tag = new AjaxRequest.Tag();
  AjaxRequest.profile = new AjaxRequest.Profile();
}