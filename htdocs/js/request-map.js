var demoMode = 0;

var map;
var polylines = [];
var markers = [];
var bounds = new google.maps.LatLngBounds();

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

  refreshMap(1);
  window.setInterval(function() {
    if (demoMode === 0) {
      refreshMap(0);
    }
  }, 10000);
}

function refreshMap(load) {
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

    if (path_2 === null) {
      createPolyline(path_1, request[0]["eta_1"] / 60, "blue", 1, load);
    } else {
      createPolyline(path_2, request[0]["eta_2"] / 60, "blue", 0, load);
      createPolyline(path_1, request[0]["eta_1"] / 60, "orange", 1, load);
    }
  });
}

function createPolyline(path, position, color, main, load) {
  // Shrink
  var waypoints = [];
  waypoints.push(path[0]);
  var n = 0;
  for (var i = 1; i < path.length - 1; i++) {
    if (path[i]["eta"] >= n) {
      waypoints.push(path[i]);
      n += 60;
    }
  }
  waypoints.push(path[path.length - 1]);

  var mainRoutePoint = 0;
  for (var i = 0; i < path.length; i++) {
    if (main === 1 && waypoints[position]["lat"] === path[i]["lat"] && waypoints[position]["lng"] === path[i]["lng"] && waypoints[position]["eta"] === path[i]["eta"]) {
      mainRoutePoint = i;
    }
  }

  // Reconstruct polyline
  var polylinePath = [];

  for (var i = mainRoutePoint; i < path.length; i++) {
    var coord = new google.maps.LatLng(path[i]["lat"], path[i]["lng"]);
    polylinePath.push(coord);
    if (load === 1) {
      bounds.extend(coord);
    }

    if (i === mainRoutePoint && main === 1) {
      if (demoMode === 0) {
        var marker = new google.maps.Marker({
          position: coord,
          map: map,
          animation: google.maps.Animation.DROP
        });
      } else {
        var marker = new google.maps.Marker({
          position: coord,
          map: map
        });
      }
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

  if (load === 1) {
    map.fitBounds(bounds);
    map.setCenter(bounds.getCenter());
  }
}

function demo(mode) {
  if (mode === 1) {
    demoMode = mode;
    demoMap();
    return "Fast forward activated";
  } else {
    location = "/";
    return;
  }
}

function demoMap() {
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

    // Shrink
    var waypoints_1 = [];
    waypoints_1.push(path_1[0]);
    var n = 0;
    for (var i = 1; i < path_1.length - 1; i++) {
      if (path_1[i]["eta"] >= n) {
        waypoints_1.push(path_1[i]);
        n += 60;
      }
    }
    waypoints_1.push(path_1[path_1.length - 1]);

    if (path_2 !== null) {
      var waypoints_2 = [];
      waypoints_2.push(path_2[0]);
      var n = 0;
      for (var i = 1; i < path_2.length - 1; i++) {
        if (path_2[i]["eta"] >= n) {
          waypoints_2.push(path_2[i]);
          n += 60;
        }
      }
      waypoints_2.push(path_2[path_2.length - 1]);
    }

    var add = request[0]["eta_1"] - 60;
    var refreshId = setInterval(function() {

      // Reset previous polylines
      for (var i = 0; i < polylines.length; i++) {
        polylines[i].setMap(null);
      }

      // Reset previous markers
      for (var i = 0; i < markers.length; i++) {
        markers[i].setMap(null);
      }

      bounds = new google.maps.LatLngBounds();

      add += 60;

      if (path_2 !== null) {
        if (add >= waypoints_1.length * 60) {
          path_1 = path_2;
          path_2 = null;
          add = 0;
          waypoints_1 = waypoints_2;
        }
      } else {
        if (add >= waypoints_1.length * 60) {
          clearInterval(refreshId);
          return;
        }
      }

      if (path_2 === null) {
        createPolyline(path_1, (request[0]["eta_1"] + add) / 60, "blue", 1, 1);
      } else {
        createPolyline(path_2, (request[0]["eta_2"] + add) / 60, "blue", 0, 0);
        createPolyline(path_1, (request[0]["eta_1"] + add) / 60, "orange", 1, 1);
      }
    }, 500);
  });
}