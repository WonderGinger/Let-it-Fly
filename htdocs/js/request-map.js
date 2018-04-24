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
      var main = createPolyline(path_1, request[0]["eta_1"] / 60, "blue", 1, load);

      document.getElementById("td3").innerHTML = main + " mins";
    } else {
      var main = createPolyline(path_2, request[0]["eta_2"] / 60, "blue", 0, load);
      var prer = createPolyline(path_1, request[0]["eta_1"] / 60, "orange", 1, load);

      document.getElementById("td3").innerHTML = main + prer + " mins";
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
      marker.addListener("click", function() {
        document.getElementById("slider").click();
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

  if (load === 1) {
    map.fitBounds(bounds);
    map.setCenter(bounds.getCenter());
  }

  return (((waypoints.length * 60 - 60) - (position * 60)) / 60);
}

function demo() {
  demoMode = 1;
  demoMap();
  return "Speedometer: 4,000 mph";
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

    var request = JSON.parse(output);
    var path_1 = JSON.parse(request[0]["polyline_1"]);
    var path_2 = request[0]["polyline_2"] !== null ? JSON.parse(request[0]["polyline_2"]) : null;
    var dblTrack = true;
    if (path_2 === null) dblTrack = false;

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

    if (dblTrack) {
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


    var counter = 0;
    var refreshId = setInterval(function() {

      if (dblTrack) {
        if (path_2 !== null) {
          if ((request[0]["eta_1"] / 60) + counter > waypoints_1.length - 1) {
            path_1 = path_2;
            path_2 = null;
            counter = 0;
            return;
          }

          reset();

          var main = createPolyline(path_2, 0, "blue", 0, 0);
          var prer = createPolyline(path_1, (request[0]["eta_1"] / 60) + counter, "orange", 1, 1);
          document.getElementById("td3").innerHTML = main + prer + " mins";
        } else {
          if (counter >= waypoints_2.length - 1) {
            clearInterval(refreshId);
          }

          reset();

          var main = createPolyline(path_1, counter, "blue", 1, 1);
          document.getElementById("td3").innerHTML = main + " mins";
        }
      } else {
        if ((request[0]["eta_1"] / 60) + counter >= waypoints_1.length - 1) {
          clearInterval(refreshId);
        }

        reset();

        var main = createPolyline(path_1, (request[0]["eta_1"] / 60) + counter, "blue", 1, 1);
        document.getElementById("td3").innerHTML = main + " mins";
      }

      counter++;
    }, 500);
  });
}

function reset() {
  // Reset previous polylines
  for (var i = 0; i < polylines.length; i++) {
    polylines[i].setMap(null);
  }

  // Reset previous markers
  for (var i = 0; i < markers.length; i++) {
    markers[i].setMap(null);
  }

  // Reset bounds
  bounds = new google.maps.LatLngBounds();
}