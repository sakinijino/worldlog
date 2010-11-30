function MapItem(map, item) {
  this.map = map;
  this.item = item;
  this.visible = true;
  this.item.registerFocusListener(this.centerDisplay.bind(this));
  //this.item.registerUpdateListener(this.centerDisplay.bind(this));
  
  this.point =  new GPoint(item.longitude, item.latitude);
  this.textmarker = new GText(this.point, item.getMapTitle("#FFFFFF").innerHTML);
  this.marker = new GIconMarker(this.point, this.item.getIcon(), new GSize(24, 24));
}

MapItem.prototype.resetVisible = function() {
  var tagvisible = true;
  var profilevisible = true;
  var typevisible = false;
  if (this.map.currentTag!=null) {
    tagvisible = (this.item.tags[this.map.currentTag.name]!=null);
  }
  if (this.map.typesvisible[this.item.type] != null) {
    typevisible = this.map.typesvisible[this.item.type];
  }
  if (this.map.currentProfile!=null) {
    profilevisible = (this.map.currentProfile.items[this.item.id]!=null);
  }
  
  this.visible = (tagvisible && typevisible && profilevisible);
  this.marker.setVisible(tagvisible && typevisible && profilevisible);
  this.textmarker.setVisible(tagvisible && typevisible && profilevisible);
}

MapItem.prototype.centerDisplay = function() {
  if (this.visible) {
    var re = this.item.getOpenInfoWindow();
    var div = re.div;
    var mw = re.maxwidth;
    if (mw>0 && mw<500) 
      this.marker.openInfoWindowHtml(div.innerHTML, {maxWidth: mw});
    else this.marker.openInfoWindowHtml(div.innerHTML);
  }
}

MapItem.Events = ['Click'];
Model.generateClassEvents(MapItem, MapItem.Events);

//---------------------------------------------------
function MapItemFactory(){}

MapItemFactory.Create = function(map, item) {
  var mi = new MapItem(map, item);
  this.initListeners(mi);
  GEvent.addListener(mi.marker, 'click', mi.onClick.bind(mi));//??why need bind here??
  return mi;
}
Model.generateFactoryEvents(MapItemFactory, MapItem.Events);