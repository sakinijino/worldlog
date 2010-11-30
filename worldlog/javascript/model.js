//---------------------------------------------------
//Model Helper. eg, Generate Event Methods, etc
function Model(){}

Model.generateClassEvents = function(klass, listenernames) {
  listenernames.each(function(n){
    //n, eg. Select
    //ln, eg. SelectListener
    //lcln, eg. selectlisteners
    //onmeth, eg. onSelect
    var ln = n + 'Listener';
    var lcln = ln.toLowerCase() + 's';
    var onmech = 'on' + n;
    klass.prototype['register'+ln] = function(l) {
      this[lcln].push(l)
    }
    klass.prototype['unRegister'+ln] = function(l) {
      this[lcln] = this[lcln].partition(function(lf){if (l!=lf) return true;})[0];
    }
    klass.prototype[onmech] = function(l) {
      var obj = this;
      this[lcln].each(function(listener){
        listener(obj);
      });
    }
  });
}

Model.generateFactoryEvents = function(factory, listenernames) {
  listenernames.each(function(n){
    //n, eg. Select
    //ln, eg. SelectListener
    //lcln, eg. selectlisteners
    var ln = n + 'Listener';
    var lcln = ln.toLowerCase() + 's';
    factory[lcln] = new Array();
    factory['register'+ln] = function(l) {
      this[lcln].push(l)
    }
    factory['unRegister'+ln] = function(l) {
      this[lcln] = this[lcln].partition(function(lf){if (l!=lf) return true;})[0];
    }
  });
  factory.initListeners = function(obj){
    listenernames.each(function(n){
       var ln = n + 'Listener';
       var lcln = ln.toLowerCase() + 's';
       obj[lcln] = [];
       factory[lcln].each(function(l){obj['register'+ln](l);});
    });
  };
}