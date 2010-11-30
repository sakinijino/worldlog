function WorldlogMap(itemtypes) {
  this.itemArray = $H([]);
  this.currentTag = null;
  this.currentProfile = null;
  this.itemtypes = itemtypes;
  this.typesvisible = $H([]);
  var map = this;
  this.itemtypes.values().each(function(it){
    map.typesvisible[it.name] = true;
  });
  //this.itemMaxID = 0;
}

WorldlogMap.prototype.addItem = function(item) {
  if (this.itemArray[item.id]) return;
  this.itemArray[item.id] = MapItemFactory.Create(this, item);
  this.addOverlay(this.itemArray[item.id].textmarker);
  this.addOverlay(this.itemArray[item.id].marker);
  this.itemArray[item.id].resetVisible();
  //if (item.id > this.itemMaxID) this.itemMaxID=item.id;
}

WorldlogMap.prototype.refreshItems = function(){
	this.itemArray.values().each(function(mi){mi.resetVisible();});
}

WorldlogMap.prototype.delItem = function(item){
	if(this.itemArray[item.id] != null){
		this.closeInfoWindow();
		this.removeOverlay(this.itemArray[item.id].marker);
		this.removeOverlay(this.itemArray[item.id].textmarker);
		delete this.itemArray[item.id];
	}
}

WorldlogMap.prototype.setTag = function(tag) {
  var map = this;
  if (map.currentTag == tag) return;
  map.currentTag = tag;
  map.refreshItems();
}

WorldlogMap.prototype.setProfile = function(profile) {
  var map = this;
  if (profile!=null) {  
    if (map.getZoom()==profile.zoomlevel)
      map.panTo(new GLatLng(profile.latitude, profile.longitude));
    else 
      map.setCenter(new GLatLng(profile.latitude, profile.longitude), profile.zoomlevel);
  }
  if (map.currentProfile == profile) return;
  
  if (map.currentProfile != null) {
    map.currentProfile.unRegisterAddItemListener(map._profileAddItem);
    map.currentProfile.unRegisterDelItemListener(map._profileDelItem);
  }
  if (profile!=null) {
    profile.registerAddItemListener(map._profileAddItem.bind(map));
    profile.registerDelItemListener(map._profileDelItem.bind(map));
  }
  map.currentProfile = profile;
  map.refreshItems();
}

WorldlogMap.prototype._profileAddItem = function(profile, item) {
  var map = this;
  if (map.currentProfile==null) return;
  if (profile.id == map.currentProfile.id) {
    this.itemArray[item.id].resetVisible();
  }
}

WorldlogMap.prototype._profileDelItem = function(profile, item) {
  var map = this;
  if (map.currentProfile==null) return;
  if (profile.id == map.currentProfile.id && this.itemArray[item.id]) {
    this.itemArray[item.id].resetVisible();
  }
}

WorldlogMap.prototype.setTypeVisible = function(typename, isvisible) {
  var map = this;
  map.typesvisible[typename] = isvisible;
  map.refreshItems();
}

WorldlogMap.prototype.clear = function() {
  this.clearOverlays();
  this.itemArray = $H([]);
	//this.itemMaxID = 0;
}

WorldlogMap.prototype.getRectLngLat = function() {
  var bounds = this.getBounds();
  return {minlnt:bounds.getSouthWest().lng(),
	        minlat:bounds.getSouthWest().lat(),
	        maxlnt:bounds.getNorthEast().lng(),
          maxlat:bounds.getNorthEast().lat()};
}

WorldlogMap.Events = ['Click', 'MoveEnd', 'Zoom'];
Model.generateClassEvents(WorldlogMap, WorldlogMap.Events);

WorldlogMap.prototype.onClick = function(o, p) {
  var map = this;
  this.clicklisteners.each(function(listener){
    listener(map, p);
  });
}

//---------------------------------------------------
function WorldlogMapFactory(){}

WorldlogMapFactory.Create = function(container, longitude, latitude, zoomlevel) {
  var map = new GMap2(container);
  Object.extend(map, new WorldlogMap(ItemType.Types));
  map.setCenter(new GLatLng(latitude,longitude), zoomlevel, G_HYBRID_MAP);
  map.addControl(new GLargeMapControl());
  map.addControl(new GMapTypeControl());
  map.addControl(new GScaleControl());
  map.addControl(new GMiniMapControl());
  map.addControl(new GDragZoomControl(), new GControlPosition(G_ANCHOR_TOP_RIGHT, new GSize(250, 7)));
  map.addControl(new GTypeSelectorControl(), new GControlPosition(G_ANCHOR_TOP_RIGHT, new GSize(7, 30)));
  this.initListeners(map);
  GEvent.addListener(map, 'click', map.onClick);
  GEvent.addListener(map, 'moveend', map.onMoveEnd);
  GEvent.addListener(map, 'zoom', map.onZoom);
  return map;
}
Model.generateFactoryEvents(WorldlogMapFactory, WorldlogMap.Events);