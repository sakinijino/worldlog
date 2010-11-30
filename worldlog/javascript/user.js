function User(){
  this.name="";
  this.nickname="";
  this.email = "";
  this.password="";
  this.authKey="";
  this.items = $H([]);
  this.profiles = $H([]);
}
User.Events = ['Login', 'Logout', 'UserItemsLoad', 'UserItemsUpdate', 'UserProfilesLoad', 'UserProfilesUpdate'];
Model.generateClassEvents(User, User.Events);

//------------------------------------------
function UserFactory() {}

UserFactory.loginlisteners = new Array();
UserFactory.logoutlisteners = new Array();

UserFactory.Create = function() {
  var user = new User();
  this.initListeners(user);
  return user;
}

UserFactory.CreateFromDOM = function(dom) {
  var user = new User();
  XmlParserHelper.objPropXmlElemMapping(user, dom, 'id');
  XmlParserHelper.objPropXmlElemMapping(user, dom, 'name');
  XmlParserHelper.objPropXmlElemMapping(user, dom, 'nickname');
  XmlParserHelper.objPropXmlElemMapping(user, dom, 'email');
  
  user.id=Number(user.id);
  this.initListeners(user);
  return user;
}

UserFactory.Clone = function(u) {
  var user = new User();
  user = Object.extend(user, u);
  this.initListeners(user);
  return user;
}
Model.generateFactoryEvents(UserFactory, User.Events);