<!DOCTYPE html>
<html>
  <head>
    <style>
      #map {
        height: 500px;
        width: 1000px;
      }
    </style>
  </head>
  <body>
    <div id="map"></div>
<p id="demo"></p>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCRIbTYik2x_e5--W85NiB2bckEMFDjVtc&callback=initialize" async defer></script>
    <script>
function initialize() {
  var map = new google.maps.Map(
    document.getElementById("map"), {
      center: new google.maps.LatLng(37.335187, -121.881072),
      zoom: 13,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });
  var directionsService = new google.maps.DirectionsService();
  var directionsDisplay = new google.maps.DirectionsRenderer({
    map: map,
    preserveViewport: true
  });
  directionsService.route({
    origin: new google.maps.LatLng(37.335187, -121.881072),
    destination: new google.maps.LatLng(37.621313, -122.378955),
    travelMode: google.maps.TravelMode.DRIVING
  }, function(response, status) {
    if (status === google.maps.DirectionsStatus.OK) {
      // directionsDisplay.setDirections(response);
      var polyline = new google.maps.Polyline({
        path: [],
        strokeColor: '#0000FF',
        strokeWeight: 3
      });
      var bounds = new google.maps.LatLngBounds();


      var legs = response.routes[0].legs;
      for (i = 0; i < legs.length; i++) {
        var steps = legs[i].steps;
        for (j = 0; j < steps.length; j++) {
          var nextSegment = steps[j].path;
          for (k = 0; k < nextSegment.length; k++) {
            polyline.getPath().push(nextSegment[k]);
            bounds.extend(nextSegment[k]);
          }
        }
      }

/*
http://www.hamstermap.com/quickmap.php
var route = result.routes[0];
var points = new Array();
var legs = route.legs;
for (i = 0; i < legs.length; i++) {
    var steps = legs[i].steps;
    for (j = 0; j < steps.length; j++) {
        var nextSegment = steps[j].path;
        for (k = 0; k < nextSegment.length; k++) {
            points.push(nextSegment[k]);
        }
    }
}



*/


      polyline.setMap(map);
      document.getElementById("demo").innerHTML = polyline.getPath().getArray();
    } else {
      window.alert('Directions request failed due to ' + status);
    }
  });
}
    </script>
  </body>
</html>