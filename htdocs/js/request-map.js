var map;
var polylines = [];
var markers = [];
var bounds;

google.maps.event.addDomListener(window, "load", initMap);

function initMap() {
  map = new google.maps.Map(document.getElementById("map"), {
    center: { lat: 37.6452181, lng: -122.17673625 },
    clickableIcons: false,
    fullscreenControl: false,
    mapTypeControl: false,
    streetViewControl: false,
    zoom: 9
  });
  bounds = new google.maps.LatLngBounds();

  refreshMap();
  window.setInterval(function() {
    refreshMap();
  }, 10000);
}

function refreshMap() {
  $.post("js/ajax/request.php", {
    selector: "refresh"
  }, function(output) {
    // Database error
    if (output === "db-error") {
      location = "/db-error";
      return;
    }

    // Load data
    var request = JSON.parse(output);
    var path_1 = JSON.parse(request[0]["polyline_1"]);
    var path_2 = request[0]["polyline_2"] !== null ? JSON.parse(request[0]["polyline_2"]) : null;


    // Reset previous polylines
    for (var i = 0; i < polylines.length; i++) {
      polylines[i].setMap(null);
    }

    // Reset previous markers
    for (var i = 0; i < markers.length; i++) {
      markers[i].setMap(null);
    }

    // Draw new polylines
    if (path_2 === null) {
      createPolyline(path_1, request[0]["eta_1"] / 60, "blue", 1);
    } else {
      createPolyline(path_2, request[0]["eta_2"] / 60, "blue", 0);
      createPolyline(path_1, request[0]["eta_1"] / 60, "orange", 1);
    }
  });
}

function createPolyline(path, position, color, main) {
  var polylinePath = [];

  for (var i = position; i < path.length; i++) {
    var coord = new google.maps.LatLng(path[i]["lat"], path[i]["lng"]);
    polylinePath.push(coord);
    bounds.extend(coord);

    if (i === position && main === 1) {
      var marker = new google.maps.Marker({
        position: coord,
        map: map,
        animation: google.maps.Animation.DROP
      });
      markers.push(marker);
    }
  }

  var polyline = new google.maps.Polyline({
    path: polylinePath,
    strokeColor: (color === "blue") ? "#4597ff" : "#fb8c00",
    strokeWeight: 6
  });
  polylines.push(polyline);
  polyline.setMap(map);
  map.fitBounds(bounds);
  map.setCenter(bounds.getCenter());
}