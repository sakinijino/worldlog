function GLngToLTLng(glng) {
  return (glng+0.009)*100000;
}

function LTLngToGLng(ltlng) {
  return ltlng/100000-0.009;
}

function GLatToLTLat(glat) {
  return (glat-0.003)*100000;
}

function LTLatToGLat(ltlat) {
  return ltlat/100000+0.003;
}

function GZoomToLTZoom(gzoom) {
  return 16-gzoom;
}

function LTZoomToGZoom(ltzoom) {
  return 16-ltzoom;
}
