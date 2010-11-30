function MapItem(map, item) {
  this.map = map;
  this.item = item;
  this.visible = true;
  this.item.registerFocusListener(this.centerDisplay.bind(this));
  //this.item.registerUpdateListener(this.centerDisplay.bind(this));
  
  /*this.point =  new GPoint(item.longitude, item.latitude);
  this.textmarker = new GText(this.point, item.getMapTitle().innerHTML);
  this.marker = new GIconMarker(this.point, this.item.getIcon(), new GSize(24, 24));*/
  this.point =  new LTPoint(GLngToLTLng(item.longitude), GLatToLTLat(item.latitude));
  this.textmarker = new LTMapText(this.point);
  this.textmarker.setLabel(item.getMapTitle().innerHTML) ;
  var icon = new LTIcon();
  icon.setImageUrl(this.item.getIcon());
  icon.setWidth(24);
  icon.setHeight(24);
  this.marker = new LTMarker(this.point, icon);
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
  
  /*this.marker.setVisible(tagvisible && typevisible && profilevisible);*/
  if (tagvisible && typevisible && profilevisible) {
    this.marker.icon.style.width="24px";
    this.marker.icon.style.height="24px";
    this.marker.icon.style.visible = "";
  }
  else {
    this.marker.icon.style.width="0px";
    this.marker.icon.style.height="0px";
    this.marker.icon.style.visible = "none";
  }
  
  this.textmarker.setVisible(tagvisible && typevisible && profilevisible);
  
}

MapItem.prototype.centerDisplay = function() {
  if (this.visible) { 
    var re = this.item.getOpenInfoWindow();
    var div = re.div;
    var mw = re.maxwidth;
    /*if (mw>0 && mw<500) 
      this.marker.openInfoWindowHtml(div.innerHTML, {maxWidth: mw});
    else this.marker.openInfoWindowHtml(div.innerHTML);*/
    
    this.marker.openInfoWinHtml(div.innerHTML);
    this.map.moveToCenter(this.point); 
  }
}

MapItem.Events = ['Click'];
Model.generateClassEvents(MapItem, MapItem.Events);

//---------------------------------------------------
function MapItemFactory(){}

MapItemFactory.Create = function(map, item) {
  var mi = new MapItem(map, item);
  this.initListeners(mi);
  
  /*GEvent.addListener(mi.marker, 'click', mi.onClick.bind(mi));//??why need bind here??*/
  LTEvent.addListener(mi.marker, 'click', mi.onClick.bind(mi));
  
  return mi;
}
Model.generateFactoryEvents(MapItemFactory, MapItem.Events);