function Tag() {
  this.name="";
  this.num = 0;
}
Tag.Events = ['Select', 'UnSelect', 'Search'];
Model.generateClassEvents(Tag, Tag.Events);

//Viewer Function
Tag.prototype.getTagSpan = function() {
  var tag = this;
  var spn = document.createElement('span');
  var searchbtn = document.createElement('span');
  searchbtn.className = "link";
  searchbtn.innerHTML = tag.name;
  searchbtn.onclick = function() {
    tag.onSearch();
  };
  var selectbtn = document.createElement('span');
  selectbtn.className = "link";
  selectbtn.style.fontStyle = "italic";
  selectbtn.innerHTML = "[过滤地图]";
  selectbtn.onclick = function() {
    tag.onSelect();
  };
  spn.appendChild(searchbtn);
  spn.appendChild(selectbtn);
  return spn;
}

//----------------------------------------------
function TagFactory() {}

TagFactory.Create = function() {
  var tag = new Tag();
  this.initListeners(tag);
  return tag;
}

TagFactory.CreateFromDOM = function(dom) {
  var tag = new Tag();
  XmlParserHelper.objPropXmlElemMapping(tag, dom, 'id');
  XmlParserHelper.objPropXmlElemMapping(tag, dom, 'name');
  XmlParserHelper.objPropXmlElemMapping(tag, dom, 'num');
  
  tag.id=Number(tag.id);
  this.initListeners(tag);
  return tag;
}

TagFactory.Clone = function(t) {
  var tag = new Tag();
  tag = Object.extend(tag, t);
  this.initListeners(tag);
  return tag;
}
Model.generateFactoryEvents(TagFactory, Tag.Events);