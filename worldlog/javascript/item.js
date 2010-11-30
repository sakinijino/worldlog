function Item() {
  this.id=0;
  this.userid=0;
  this.longitude=0;
	this.latitude=0;
  this.icon="";
	this.link="";
	this.title="";
	this.content="";
	this.type="";
	this.valid=true;
	this.createtime=new Date();
	this.enable=true;
	this.updatetime=new Date();
	this.visits=0;
	this.goodrating=0;
	this.badrating=0;
	this.tags = $H([]);
}

Item.prototype.isInRect = function(maxlnt, minlnt, maxlat, minlat) {
  return (this.longitude <= maxlnt) && (this.longitude >= minlnt) &&
         (this.latitude <= maxlat) && (this.latitude >= minlat);
}

Item.Events = ['Create', 'Update', 'Delete', 'Focus', 'Load'];
Model.generateClassEvents(Item, Item.Events);

//----------------------------------------------
function ItemType(name, humanname, icon, viewerclass) {
  this.name = name;
  this.humanname = humanname;
  this.icon = icon;
  if (viewerclass != null) this.viewerclass = viewerclass;
  else this.viewerclass = ItemViewer;//default ItemViewwe
  
  this.metaitem = Object.extend({type:this.name, typeobj:this}, new this.viewerclass());
}

ItemType.Types = $H([]);
ItemType.Types['blog'] = new ItemType('blog', '博客', 'images/Blog.png', BlogViewer);
ItemType.Types['link'] = new ItemType('link', '网页', 'images/Link.png', LinkViewer);
ItemType.Types['diary'] = new ItemType('diary', '日记', 'images/Diary.png', DiaryViewer);

//----------------------------------------------
function ItemFactory() {}

ItemFactory.Create = function(type) {
  var item = new Item();
  this.initListeners(item);
  item = Object.extend(item, ItemType.Types[type].metaitem);
  return item;
}

ItemFactory.CreateFromDOM = function(dom, cache) {
  var cache = AjaxRequest.Item.LoadCache;//a bug here, we should remove this sentence.

  var item = new Item();
  XmlParserHelper.objPropXmlElemMapping(item, dom, 'id');
  
  if (cache!=null) {
    var tmp=cache[Number(item.id)];
    if (tmp!=null) return tmp;
  }

  XmlParserHelper.objPropXmlElemMapping(item, dom, 'userid');
  XmlParserHelper.objPropXmlElemMapping(item, dom, 'longitude');
  XmlParserHelper.objPropXmlElemMapping(item, dom, 'latitude');
  XmlParserHelper.objPropXmlElemMapping(item, dom, 'icon');
  XmlParserHelper.objPropXmlElemMapping(item, dom, 'link');
  XmlParserHelper.objPropXmlElemMapping(item, dom, 'title');
  XmlParserHelper.objPropXmlElemMapping(item, dom, 'content');
  XmlParserHelper.objPropXmlElemMapping(item, dom, 'type');
  XmlParserHelper.objPropXmlElemMapping(item, dom, 'enable');
  XmlParserHelper.objPropXmlElemMapping(item, dom, 'createtime');
  XmlParserHelper.objPropXmlElemMapping(item, dom, 'updatetime');
  XmlParserHelper.objPropXmlElemMapping(item, dom, 'visits');
  XmlParserHelper.objPropXmlElemMapping(item, dom, 'goodrating');
  XmlParserHelper.objPropXmlElemMapping(item, dom, 'badrating');
  XmlParserHelper.objPropXmlElemMapping(item, dom, 'tags');
  
  item.id=Number(item.id);
  item.userid=Number(item.userid);
  item.longitude=Number(item.longitude);
	item.latitude=Number(item.latitude);
	item.createtime=XmlParserHelper.parseDateString(item.createtime);
	item.updatetime=XmlParserHelper.parseDateString(item.updatetime);
	item.visits=Number(item.visits);
	item.goodrating=Number(item.goodrating);
	item.badrating=Number(item.badrating);

	if (item.tags=="") item.tags = $H([]);
  else {
	  var tagarr = item.tags.split(' ');
	  item.tags = $H([]);
	  tagarr.each(function(t){
	    var tag = TagFactory.Create();
	    tag.name = t;
	    tag.num = -1;
	    item.tags[t] = tag;
	  });
	}

  this.initListeners(item);
  item = Object.extend(item, ItemType.Types[item.type].metaitem);
  if (cache!=null) cache.setItem(item);
  return item;
}

ItemFactory.Clone = function(i) {
  var item = new Item();
  item = Object.extend(item, i);
  this.initListeners(item);
  return item;
}
Model.generateFactoryEvents(ItemFactory, Item.Events);