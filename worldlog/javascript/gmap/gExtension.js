//add by Rookie
function GText(pointobj,gtext) {
  this.gtext_ = gtext;
  this.gpoint_ = pointobj;
}

GText.prototype = new GOverlay();


// Creates the DIV representing this rectangle.
GText.prototype.initialize = function(parentmap) {
  
  // Create the DIV representing our rectangle
  var div = document.createElement("div");
  this.map_ = parentmap;
  this.div_ = div;
  
  div.style.border = "0px";
  div.style.position = "absolute";
  
  div.innerHTML= this.gtext_;
  
  // Our rectangle is flat against the map, so we add our selves to the
  // MAP_PANE pane, which is at the same z-index as the map itself (i.e.,
  // below the marker shadows)
  parentmap.getPane(G_MAP_MAP_PANE).appendChild(div);

  
}

// Remove the main DIV from the map pane
GText.prototype.remove = function() {
  this.div_.parentNode.removeChild(this.div_);
}

// Copy our data to a new Rectangle
GText.prototype.copy = function() {
  return new GText(this.gpointobj_, this.gtext_);
}

// Redraw the rectangle based on the current projection and zoom level
GText.prototype.redraw = function(force) {
  // We only need to redraw if the coordinate system has changed
  if (!force) return;
  var latlng = new GLatLng(this.gpoint_.y, this.gpoint_.x);
  
  var p = this.map_.fromLatLngToDivPixel(latlng);
  	
  // Now position our DIV based on the DIV coordinates of our bounds
  this.div_.style.left = p.x-4 + "px";
  this.div_.style.top = p.y + 10 + "px";
  
  
  // Calculate the DIV coordinates of two opposite corners of our bounds to
  // get the size and position of our rectangle
  
};
 
GText.prototype.setVisible=function(visible) {
	if (visible) this.div_.style.display="";
	else this.div_.style.display="none";
};


function GIconMarker(point,imageUrl,iconSize)
	{
		
		this.point=point;
		this.iconSize = iconSize;
		
	
		this.imageUrl=imageUrl;
	}
GIconMarker.prototype = new GOverlay();
	
GIconMarker.prototype.initialize=function(a)
{
		this.map_= a;
		this.div_ =document.createElement("img");
		this.div_.src=this.imageUrl;
		this.div_.style.width = this.iconSize.width+'px';
		this.div_.style.height = this.iconSize.height+'px';
		this.div_.style.display='';
		this.div_.style.position="absolute";
		this.div_.style.border="0";
		this.div_.style.padding="0";
		this.div_.style.margin="0";
		this.div_.style.cursor="pointer";
		a.getPane(G_MAP_MARKER_PANE).appendChild(this.div_);
		GEvent.bindDom(this.div_,"click",this,this.onClick);
};

GIconMarker.prototype.remove = function() {
  this.div_.parentNode.removeChild(this.div_);
}

// Copy our data to a new Rectangle
GIconMarker.prototype.copy = function() {
  return new GIconMarker(this.imageUrl,this.point,this.iconSize);
}

// Redraw the rectangle based on the current projection and zoom level
GIconMarker.prototype.redraw = function(force) {
  // We only need to redraw if the coordinate system has changed
  if (!force) return;
  var latlng = new GLatLng(this.point.y, this.point.x);
  
  var p = this.map_.fromLatLngToDivPixel(latlng);
  
  // Now position our DIV based on the DIV coordinates of our bounds
  this.div_.style.left = p.x - this.iconSize.width/2+ "px";
  this.div_.style.top =  p.y - this.iconSize.height/2 + "px";
  
  // Calculate the DIV coordinates of two opposite corners of our bounds to
  // get the size and position of our rectangle
  
}; 

GIconMarker.prototype.onClick=function(a)
{
	
	if (window.navigator.userAgent.indexOf("MSIE")>=1)

	{
			window.event.cancelBubble=true;
			window.event.returnValue=false
	}
	else
	{
		a.cancelBubble=true;
		a.preventDefault();
		a.stopPropagation()
	}
	GEvent.trigger(this,"click",this);
	//GEvent.trigger(this.map,"click",this);
};

GIconMarker.prototype.openInfoWindowHtml=function(html,opts) {
	this.map_.openInfoWindowHtml( new GLatLng(this.point.y, this.point.x),html,opts);
};
GIconMarker.prototype.setVisible=function(visible) {
	if (visible) this.div_.style.display="";
	else this.div_.style.display="none";
};


function GMiniMapControl(size,position,latlng,zoom,zoomAdd) {
	if(size) this.size = size;
	else this.size=new GSize(240,150);
	
	if(position) this.position=position;
	else this.position=new GControlPosition(G_ANCHOR_BOTTOM_RIGHT,new GSize (4,4));
			
	this.latlng=latlng;
	this.zoom=zoom;
	this.zoomAdd=zoomAdd?zoomAdd:12;
	this.minimapRect=null;
}

GMiniMapControl.prototype = new GControl();
	
GMiniMapControl.prototype.getDefaultPosition = function() {
	return this.position;
}

GMiniMapControl.prototype.initialize= function(a) {
	this.Map=a;
	this.div=document.createElement("div");
	this.div.style.position="absolute";
	this.div.style.width=this.size.width+"px";
	this.div.style.height=this.size.height+"px";
	this.div.style.border="1px solid white";
	a.getContainer().appendChild(this.div);
	this.miniMap=new GMap2(this.div);
	this.miniMap.disableDragging();
	GEvent.bind(this.miniMap,"click",this,this.onClick);
	GEvent.bind(this.Map,"moveend",this,this.onMapMoved);
	this.onMapMoved();
	return this.div;
};
	

GMiniMapControl.prototype.getMapRect=function() {
	if(this.minimapRect)
		this.miniMap.removeOverlay(this.minimapRect);
	bounds=this.Map.getBounds();
	span = this.Map.getBounds().toSpan();
	
	
	var minlnt = bounds.getSouthWest().lng();
    	var minlat = bounds.getSouthWest().lat();
    
	    	var maxlnt = bounds.getNorthEast().lng();
          	var maxlat = bounds.getNorthEast().lat();
	
	if (span.lat()<2){
		
		centerlat = (maxlat + minlat)/2;
		
		maxlat =centerlat + 1;
		minlat =centerlat - 1;
		centerlnt = (maxlnt + minlnt) /2;
		maxlnt = centerlnt + span.lng()/span.lat();
		minlnt = centerlnt - span.lng()/span.lat();

	}
	
	var points=[];
	
	points.push(new GLatLng(minlat, minlnt));
	points.push(new GLatLng(maxlat, minlnt));
	points.push(new GLatLng(maxlat,maxlnt));
	points.push(new GLatLng(minlat,maxlnt));
	points.push(new GLatLng(minlat,minlnt));
	
	this.minimapRect=new GPolyline(points,"red",1);
	this.miniMap.addOverlay(this.minimapRect);
	
}

GMiniMapControl.prototype.InitMap=function() {
	latlng=this.latlng?this.latlng:this.Map.getCenter();
	
	zoom=this.zoom?this.zoom:this.Map.getZoom()-this.zoomAdd;
	if(zoom<0)zoom=0;
	if(zoom>17)zoom=17;
	this.miniMap.setCenter(this.Map.getCenter(),zoom,G_NORMAL_MAP);
	this.getMapRect();
	return;
}

GMiniMapControl.prototype.onMapMoved=function() {
	if(!this.Map.isLoaded())
		return;
	if(!this.miniMap.isLoaded()){
		this.InitMap();
		}
	
	this.getMapRect();
	
	if(!this.point)
		this.miniMap.panTo(this.Map.getCenter());
	/*
	zoom=this.zoom?this.zoom:this.Map.getZoom()-this.zoomAdd;
	
	if(zoom<0)zoom=0;
	if(zoom>17)zoom=17;
	if(zoom!=this.miniMap.getZoom())
		this.miniMap.setZoom(zoom);
	*/
}

GMiniMapControl.prototype.onClick=function(overlay,point) {
	latlng = new GLatLng(point.y,point.x);
	this.Map.panTo(latlng);
	GEvent.trigger(this,"click");
}

// Creates a one DIV for each of the buttons and places them in a container
// DIV which is returned as our control element. We add the control to
// to the map container and return the element for the map class to
// position properly.
function GDragZoomControl() {}

GDragZoomControl.prototype = new GControl();

GDragZoomControl.prototype.initialize = function(map) {
	var container = document.createElement("div");

	var zoomInDiv = document.createElement("div");
	this.setButtonStyle_(zoomInDiv);
	container.appendChild(zoomInDiv);
	zoomInDiv.appendChild(document.createTextNode (" 拖动放大 "));
	GEvent.addDomListener(zoomInDiv, "click", function() {
   	var draggingdiv = document.createElement("div");
   	draggingdiv.style.display='';
    draggingdiv.style.position="absolute";
  	draggingdiv.style.border="0";
  	draggingdiv.style.padding="0";
  	draggingdiv.style.marginLeft="0";
  	draggingdiv.style.width="100%";
  	draggingdiv.style.height="100%";
  	if (window.navigator.userAgent.indexOf("MSIE")>=1){
  	  draggingdiv.style.backgroundColor = "white";
  	  draggingdiv.style.filter = "alpha(opacity=40)"
    }		
		map.getContainer().appendChild(draggingdiv);
		
		setDragHandler(draggingdiv, function(sw,ne){
  		var swLatlng = map.fromContainerPixelToLatLng(sw);
  		var neLatlng = map.fromContainerPixelToLatLng(ne);
  		var bounds = new GLatLngBounds(swLatlng,neLatlng);
  		var centerlatlng = new GLatLng ((swLatlng.lat()+neLatlng.lat())/2, (swLatlng.lng()+neLatlng.lng())/2);
  		newzoomlevel = map.getBoundsZoomLevel(bounds);
  		map.setCenter(centerlatlng,newzoomlevel);
  
  		map.getContainer().removeChild(draggingdiv);
	  });
  });

  
	map.getContainer().appendChild(container);
  	return container;
}

GDragZoomControl.prototype.getDefaultPosition = function() {
  return new GControlPosition(G_ANCHOR_TOP_RIGHT, new GSize(7, 7));
}

// Sets the proper CSS for the given button element.
GDragZoomControl.prototype.setButtonStyle_ = function(button) {
  button.style.textDecoration = "none";
  //button.style.color = "#0000cc";
  button.style.backgroundColor = "white";
  //button.style.font = "small Arial";
  button.style.border = "1px solid black";
  button.style.paddingLeft = "8px";
  button.style.paddingRight = "8px";
  button.style.paddingTop = "1px";
  button.style.paddingBottom = "0px";
  button.style.marginBottom = "0px";
  button.style.textAlign = "center";
 // button.style.width = "6em";
  button.style.cursor = "pointer";
}

function setDragHandler(o,callbackfunc){

	o.onmousedown=function(a){
		var d=document;
		var oldmousemove = d.onmousemove;
		var oldmouseup = d.onmouseup;
		if(!a)a=window.event;
		var x=a.layerX?a.layerX:a.offsetX, y=a.layerY?a.layerY:a.offsetY;
		cx = a.clientX;
		cy = a.clientY;
		markerX= x;
		markerY= y;
		markerHeight = 0;
		markerWidth = 0;
		offset_x = cx -x;
		offset_y = cy -y;
		
		var marker = document.createElement("div");
		marker.style.display='';
		marker.style.position="absolute";
		marker.style.padding="0";
		marker.style.margin="0";
		marker.style.left=x+"px";
		marker.style.top=y+"px";
		marker.style.width=0;
		marker.style.height=0;
		marker.style.border= " 2px solid black";
		
		o.appendChild(marker);
		d.onmousemove=function(a){
			if(!a)a=window.event;
			if(!a.pageX)a.pageX=a.clientX;
			if(!a.pageY)a.pageY=a.clientY;
		
			var tx=a.pageX,ty=a.pageY;
			
			if (tx-cx < 0) {marker.style.left = tx -offset_x+"px"; markerX = tx -offset_x;}
			if (ty-cy < 0) {marker.style.top = ty-offset_y+"px"; markerY = ty-offset_y;}
			
			marker.style.width = Math.abs(tx-cx)+"px";
			markerWidth = Math.abs(tx-cx);
			marker.style.height =Math.abs(ty-cy)+"px";
			markerHeight = Math.abs(ty-cy);
		};//onmousemove
		d.onmouseup=function(){
			
			d.onmousemove=oldmousemove;
			d.onmouseup=oldmouseup;
			miny = markerY;
			minx = markerX;
			maxy = markerY + markerHeight;
			maxx = markerX+ markerWidth;
			
			o.removeChild(marker);
			
			swPoint = new GPoint(minx,maxy);
			nePoint = new GPoint(maxx,miny);
			
			
			
			if (callbackfunc) callbackfunc(swPoint,nePoint);
		};//onmouseup
	}
	
}//functionx

function GTypeSelectorControl() {
}
GTypeSelectorControl.prototype = new GControl();

GTypeSelectorControl.prototype.initialize = function(map) {
  var container = document.createElement("div");
  this.setButtonStyle_(container);
  
  map.itemtypes.values().each(function(it){
    var input = document.createElement('input');
    input.setAttribute('type', 'checkbox');
    input.onclick = function (){map.setTypeVisible(it.name, input.checked)}
    input.checked = true;
    container.appendChild(input);
    var img = document.createElement('img');
    img.style.width = '16px';
    img.style.height = '16px';
    img.style.border = 0;
    img.src = it.icon;
    container.appendChild(img);
    container.appendChild(document.createTextNode(it.humanname+' '));
  });

  map.getContainer().appendChild(container);
  return container;
}

GTypeSelectorControl.prototype.getDefaultPosition = function() {
  return new GControlPosition(G_ANCHOR_TOP_RIGHT, new GSize(7, 7));
}

// Sets the proper CSS for the given button element.
GTypeSelectorControl.prototype.setButtonStyle_ = function(div) {
  div.style.backgroundColor = "white";
  div.style.border = "1px solid black";
  div.style.border = "1px solid black";
  div.style.paddingLeft = "2px";
  div.style.paddingRight = "6px";
  div.style.paddingTop = "1px";
  div.style.paddingBottom = "0px";
}