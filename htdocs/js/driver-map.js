// Handle browser back error
window.addEventListener( "pageshow", function ( event ) {
  var historyTraversal = event.persisted || (typeof window.performance != "undefined" && window.performance.navigation.type === 2);
  if (historyTraversal) window.location.reload();
});

var map;
var working = 0;

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

  checkWorking();
}

function checkWorking() {
  $.post("js/ajax/request.php", {
    selector: "working"
  }, function(output) {
    // Database error
    if (output === "db-error") {
      location = "/db-error";
      return;
    }

    var output = JSON.parse(output);

    if (output["working"] == 1) {
      working = 1;
    } else {
      document.getElementById("begin-working").classList.remove("hide");
      working = 0;
    }

    // Initial load of page
    if (working === 1) addPassenger(1);
    drawMarker();
    window.setInterval(function() {
      if (working === 1) addPassenger(0);
      drawMarker();
    }, 10000);
  });
}

function addPassenger(load) {
  $.post("js/ajax/request.php", {
    selector: "get-passengers"
  }, function(output) {
    // Database error
    if (output === "db-error") {
      location = "/db-error";
      return;
    }

    var requests = JSON.parse(output);

    document.getElementById("1").classList.add("hide");
    document.getElementById("2").classList.add("hide");

    for (var i = 0; i < requests.length; i++) {
      document.getElementById(i + 1).classList.remove("hide");

      document.getElementById(i + 1 + "-td1").innerHTML = requests[i]["rider_email"];
      document.getElementById(i + 1 + "-td2").innerHTML = requests[i]["seats"];

      if (requests.length > 1) {
        document.getElementById(i + 1 + "-td3").innerHTML = "$" + (requests[i]["cost"] - 5).toFixed(2);
      } else {
        document.getElementById(i + 1 + "-td3").innerHTML = "$" + (requests[i]["cost"]);
      }
    }

    if (requests.length === 0) {
      document.getElementById("request-warning").innerHTML = "Searching for requests...";
      document.getElementById("searching").classList.remove("hide");
      document.getElementById("capacity").classList.add("hide");

      //stop-working-button
      document.getElementById("stop-working-button").classList.remove("disabled");
      document.getElementById("stop-working-button").innerHTML = "Stop Working";

      document.getElementById("stop-working").classList.remove("hide");
    } else {
      if (requests[0]["des"] == null) {
        document.getElementById("request-warning").innerHTML = "(" + requests.length + "/1)";
        document.getElementById("capacity-bar").style.width = "100%";
      } else {
        document.getElementById("request-warning").innerHTML = "(" + requests.length + "/2)";
        document.getElementById("capacity-bar").style.width = 50 * requests.length + "%";
      }

      document.getElementById("searching").classList.add("hide");
      document.getElementById("capacity").classList.remove("hide");

      //stop-working-button
      document.getElementById("stop-working-button").classList.add("disabled");
      document.getElementById("stop-working-button").innerHTML = "Currently Working";

      document.getElementById("stop-working").classList.remove("hide");

      // Draw polylines
      var path_1 = JSON.parse(requests[0]["polyline_1"]);
      var path_2 = requests[0]["polyline_2"] !== null ? JSON.parse(requests[0]["polyline_2"]) : null;

      // Reset previous polylines
      for (var i = 0; i < polylines.length; i++) {
        polylines[i].setMap(null);
      }

      if (path_2 === null) {
        var main = createPolyline(path_1, requests[0]["eta_1"] / 60, "blue", 1, load);
      } else {
        var main = createPolyline(path_2, requests[0]["eta_2"] / 60, "blue", 0, load);
        var prer = createPolyline(path_1, requests[0]["eta_1"] / 60, "orange", 1, load);
      }
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

function drawMarker() {
  $.post("js/ajax/request.php", {
    selector: "get-location"
  }, function(output) {
    // Database error
    if (output === "db-error") {
      location = "/db-error";
      return;
    }

    // Reset previous markers
    for (var i = 0; i < markers.length; i++) {
      markers[i].setMap(null);
    }

    var output = JSON.parse(output);
    var coord = new google.maps.LatLng(output["lat"], output["lng"]);

    map.panTo(coord);

    var marker = new google.maps.Marker({
      position: coord,
      map: map,
      animation: google.maps.Animation.DROP
    });

    marker.addListener("click", function() {
      document.getElementById("slider").click();
    });
    markers.push(marker);
  });
}

document.getElementById("begin-working-button").addEventListener("click", function() {
  $.post("js/ajax/request.php", {
    selector: "begin-working"
  }, function(output) {
    // Database error
    if (output === "db-error") {
      location = "/db-error";
      return;
    }

    document.getElementById("begin-working").classList.add("hide");
    document.getElementById("stop-working").classList.remove("hide");
    working = 1;

    // Hide requests
    document.getElementById("1").classList.add("hide");
    document.getElementById("2").classList.add("hide");
    document.getElementById("searching").classList.remove("hide");
    document.getElementById("capacity").classList.add("hide");
    document.getElementById("request-warning").innerHTML = "Searching for requests...";
  });
});

document.getElementById("stop-working-button").addEventListener("click", function() {
  $.post("js/ajax/request.php", {
    selector: "stop-working"
  }, function(output) {
    // Database error
    if (output === "db-error") {
      location = "/db-error";
      return;
    }

    if (output == 1) {
      document.getElementById("stop-working").classList.add("hide");
      document.getElementById("begin-working").classList.remove("hide");
      working = 0;

      // Hide requests
      document.getElementById("1").classList.add("hide");
      document.getElementById("2").classList.add("hide");
      document.getElementById("searching").classList.remove("hide");
      document.getElementById("capacity").classList.add("hide");
      document.getElementById("request-warning").innerHTML = "Searching for requests...";

      //stop-working-button
      document.getElementById("stop-working-button").classList.remove("disabled");
      document.getElementById("stop-working-button").innerHTML = "Stop Working";
    } else {
      //stop-working-button
      document.getElementById("stop-working-button").classList.add("disabled");
      document.getElementById("stop-working-button").innerHTML = "Currently Working";
      addPassenger();
    }
  });
});