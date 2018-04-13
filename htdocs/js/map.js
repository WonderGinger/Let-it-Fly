google.maps.event.addDomListener(window, "load", initMap);

// Change button states
function update() {
  if (loc_lat != null && loc_lng != null && document.getElementById("airport-select").value != "") {
    document.getElementById("update").classList.remove("disabled");
  } else {
    document.getElementById("update").classList.add("disabled");
  }
}

// call verify
document.getElementById("update").addEventListener("click", function() {
  verify();
});

// Styling for direction switch
document.getElementById("switch").addEventListener("click", function() {
  var indicator1 = document.getElementById("indicator1").innerHTML;
  var indicator2 = document.getElementById("indicator2").innerHTML;
  var td1 = document.getElementById("td1").innerHTML;
  var td2 = document.getElementById("td2").innerHTML;

  if (indicator1 === "location_on") {
    document.getElementById("indicator1").classList.remove("red-text");
    document.getElementById("indicator1").classList.add("blue-text");
  } else {
    document.getElementById("indicator1").classList.remove("blue-text");
    document.getElementById("indicator1").classList.add("red-text");
  }

  if (indicator2 === "my_location") {
    document.getElementById("indicator2").classList.remove("blue-text");
    document.getElementById("indicator2").classList.add("red-text");
  } else {
    document.getElementById("indicator2").classList.remove("red-text");
    document.getElementById("indicator2").classList.add("blue-text");
  }

  document.getElementById("indicator1").innerHTML = indicator2;
  document.getElementById("indicator2").innerHTML = indicator1;
  document.getElementById("td1").innerHTML = td2;
  document.getElementById("td2").innerHTML = td1;

  // Retain color on switch
  if (document.getElementById("td1").innerHTML === "Unspecified") {
    document.getElementById("td1").classList.remove("green-text");
    document.getElementById("td1").classList.add("red-text");
  } else {
    document.getElementById("td1").classList.remove("red-text");
    document.getElementById("td1").classList.add("green-text");
  }
  if (document.getElementById("td2").innerHTML === "Unspecified") {
    document.getElementById("td2").classList.remove("green-text");
    document.getElementById("td2").classList.add("red-text");
  } else {
    document.getElementById("td2").classList.remove("red-text");
    document.getElementById("td2").classList.add("green-text");
  }

  document.getElementById("td4").classList.remove("green-text");
  document.getElementById("td4").classList.add("red-text");
  document.getElementById("td4").innerHTML = "Unknown";
  document.getElementById("td7").classList.remove("green-text");
  document.getElementById("td7").classList.add("red-text");
  document.getElementById("td7").innerHTML = "Unknown";

  // UPDATE ROUTE
  update();
});

// Airport listener
document.getElementById("airport-select").addEventListener("change", function() {
  if (document.getElementById("indicator1").innerHTML === "location_on") {
    document.getElementById("td2").innerHTML = document.getElementById("airport-select").value;
    document.getElementById("td2").classList.remove("red-text");
    document.getElementById("td2").classList.add("green-text");
  } else {
    document.getElementById("td1").innerHTML = document.getElementById("airport-select").value;
    document.getElementById("td1").classList.remove("red-text");
    document.getElementById("td1").classList.add("green-text");
  }

  document.getElementById("td4").classList.remove("green-text");
  document.getElementById("td4").classList.add("red-text");
  document.getElementById("td4").innerHTML = "Unknown";
  document.getElementById("td7").classList.remove("green-text");
  document.getElementById("td7").classList.add("red-text");
  document.getElementById("td7").innerHTML = "Unknown";

  // UPDATE ROUTE
  update();
});

// Range slider listener
document.getElementById("range").addEventListener("change", function() {
  document.getElementById("td3").innerHTML = document.getElementById("range").value;

  document.getElementById("td4").classList.remove("green-text");
  document.getElementById("td4").classList.add("red-text");
  document.getElementById("td4").innerHTML = "Unknown";
  document.getElementById("td7").classList.remove("green-text");
  document.getElementById("td7").classList.add("red-text");
  document.getElementById("td7").innerHTML = "Unknown";

  // UPDATE ROUTE
  update();
});

// Verify if all fields are correct before using direction service
function verify() {
  if (loc_lat != null && loc_lng != null && document.getElementById("airport-select").value != "") {
    document.getElementById("update").classList.add("disabled");
    document.getElementById("switch").disabled = true;
    document.getElementById("range").disabled = true;
    document.getElementById("range").classList.add("disabled");
    document.getElementsByClassName("select-dropdown")[0].disabled = true;
    document.getElementById("tabu").style["pointer-events"] = "none";
    document.getElementById("tabu").classList.remove("teal-text");
    document.getElementById("tabu").classList.remove("lighten-1");
    document.getElementById("tabu").classList.add("grey-text");
    document.getElementById("preload").classList.remove("determinate");
    document.getElementById("preload").classList.add("indeterminate");

    // Get selected airport coords
    var airport_lat;
    var airport_lng;

    if (document.getElementById("airport-select").value === "SFO") {
      airport_lat = destinations.sfo.lat;
      airport_lng = destinations.sfo.long;
    } else if (document.getElementById("airport-select").value === "OAK") {
      airport_lat = destinations.oak.lat;
      airport_lng = destinations.oak.long;
    } else {
      airport_lat = destinations.sjc.lat;
      airport_lng = destinations.sjc.long;
    }

    // Check if airport is the origin or destination
    var ori_lat;
    var ori_lng;
    var des_lat;
    var des_lng;

    if (document.getElementById("indicator1").innerHTML === "location_on") {
      ori_lat = loc_lat;
      ori_lng = loc_lng;
      des_lat = airport_lat;
      des_lng = airport_lng;
    } else {
      ori_lat = airport_lat;
      ori_lng = airport_lng;
      des_lat = loc_lat;
      des_lng = loc_lng;
    }

    var directionsService = new google.maps.DirectionsService();

    directionsService.route({
      origin: new google.maps.LatLng(ori_lat, ori_lng),
      destination: new google.maps.LatLng(des_lat, des_lng),
      travelMode: google.maps.TravelMode.DRIVING
    }, function (response, status) {
      if (status !== google.maps.DirectionsStatus.OK) {
        window.alert("Directions request failed: " + status);
      }

      // Update duration in confirmation pane
      var travelTime = response.routes[0].legs[0].duration.text;
      document.getElementById("td4").classList.remove("red-text");
      document.getElementById("td4").classList.add("green-text");
      document.getElementById("td4").innerHTML = travelTime;

      document.getElementById("td7").classList.remove("red-text");
      document.getElementById("td7").classList.add("green-text");
      document.getElementById("td7").innerHTML = response.routes[0].legs[0].distance.text;;

      // Load array of coordinates with lat, lng, and eta
      var coordinates = [];
      coordinates.push({ "lat": ori_lat, "lng": ori_lng, "eta": undefined });
      var legs = response.routes[0].legs;
      for (i = 0; i < legs.length; i++) {
        var steps = legs[i].steps;
        for (j = 0; j < steps.length; j++) {
          var nextSegment = steps[j].path;
          for (k = 0; k < nextSegment.length; k++) {
            coordinates.push({ "lat": nextSegment[k].lat(), "lng": nextSegment[k].lng(), "eta": undefined });
          }
        }
      }
      coordinates.push({ "lat": des_lat, "lng": des_lng, "eta": undefined });
      addTiming(coordinates, response.routes[0].legs[0].duration.value);

      // Only take the minute coordinates
      var waypoints = [];
      waypoints.push(coordinates[0]);
      var n = 0;
      for (var i = 1; i < coordinates.length - 1; i++) {
        if (coordinates[i]["eta"] >= n) {
          waypoints.push(coordinates[i]);
          n += 60;
        }
      }
      waypoints.push(coordinates[coordinates.length - 1]);

      $.post("js/ajax/request.php", {
        data: { waypoints },
        passengers: document.getElementById("range").value,
        selector: "drivers"
      }, function(output) {
        // List of working drivers with non-zero seats
        var drivers = JSON.parse(output)
        if (drivers.length > 0) {
          // TODO: do something with front end
        }

        for (var i = 0; i < drivers.length; i++) {
          var src = new google.maps.LatLng(drivers[i]["lat"], drivers[i]["lng"]);
          var des = new google.maps.LatLng(ori_lat, ori_lng);

          var request = {
            origin: src,
            destination: des,
            travelMode: google.maps.DirectionsTravelMode.DRIVING
          };

          getWaitTime(i, request, function(counter, result) {
            drivers[counter]["eta"] = result;
            console.log(result);
          });
        }

        var delay = 0;
        function getWaitTime(counter, request, callback) {
          var service = new google.maps.DirectionsService();
          service.route(request, function(result, status) {
            if (status === google.maps.DirectionsStatus.OK) {
              callback(counter, result.routes[0].legs[0].duration.value);
            } else if (status === google.maps.DirectionsStatus.OVER_QUERY_LIMIT) {
              delay++;
              setTimeout(function () {
                getWaitTime(counter, request, callback);
              }, delay * 1000);
            } else {
              window.alert("Directions request failed: " + status);
            }
          });
        }

        setTimeout(function() {
          document.getElementById("ajax").innerHTML = JSON.stringify(drivers);
          document.getElementById("range").disabled = false;
          document.getElementById("range").classList.remove("disabled");
          document.getElementById("switch").disabled = false;
          document.getElementsByClassName("select-dropdown")[0].disabled = false;
          document.getElementById("tabu").style["pointer-events"] = "auto";
          document.getElementById("tabu").classList.remove("grey-text");
          document.getElementById("tabu").classList.add("teal-text");
          document.getElementById("tabu").classList.add("lighten-1");
          document.getElementById("preload").classList.remove("indeterminate");
          document.getElementById("preload").classList.add("determinate");

          console.log(getBestDrivers(drivers)); // drivers array is sorted

          // TODO(ken): remember you left off here

         }, drivers.length * 1000);
      });
    });
  } else {
    // clear out data
    document.getElementById("td4").classList.remove("green-text");
    document.getElementById("td4").classList.add("red-text");
    document.getElementById("td4").innerHTML = "Unknown";

    document.getElementById("td7").classList.remove("green-text");
    document.getElementById("td7").classList.add("red-text");
    document.getElementById("td7").innerHTML = "Unknown";
  }
}

/**
 * Add timing to route
 *
 * @param arr of coordinates that determine a route
 * @param totalTime in seconds, to cover the route
 */
function addTiming(arr, totalTime) {
  let totalDistance = 0;

  // sum up all the distances, this is different from just start -> finish distance
  for (let i = 1; i < arr.length; i++) {
    totalDistance += getDistanceFromLatLonInKm(arr[i - 1]["lat"], arr[i - 1]["lng"], arr[i]["lat"], arr[i]["lng"]);
  }

  arr[0]["eta"] = 0; // time to first is zero
  for (let i = 1; i < arr.length; i++) {
    prev = arr[i - 1];
    // time to i-th coordinate = time to (i-1)th coordinate + time to cover the distance b/t the two
    arr[i]["eta"] = ((getDistanceFromLatLonInKm(prev["lat"], prev["lng"], arr[i]["lat"], arr[i]["lng"]) / totalDistance) * totalTime) + arr[i - 1]["eta"];
  }
}


var loc_lat = null;
var loc_lng = null;

// Hard-coded airport coordinates
var destinations = {
  "sfo": {
    "lat": 37.6213129,
    "long": -122.3789554
  },
  "oak": {
    "lat": 37.7125689,
    "long": -122.2197428
  },
  "sjc": {
    "lat": 37.3639472,
    "long": -121.92893750000002
  }
};

function initMap() {
  var map = new google.maps.Map(document.getElementById("map"), {
    center: { lat: 37.3351874, lng: -121.88107150000002 },
    clickableIcons: false,
    fullscreenControl: false,
    mapTypeControl: false,
    streetViewControl: false,
    zoom: 15
  });

  // Initialize autocomplete module
  var marker = new google.maps.Marker({ map: map });
  var input = document.getElementById("autocomplete-input");
  var autocomplete = new google.maps.places.Autocomplete(input);
  autocomplete.bindTo("bounds", map);

  autocomplete.addListener("place_changed", function() {
    // Clear previous marker
    marker.setVisible(false);

    var place = autocomplete.getPlace();

    // Clear data
    document.getElementById("td4").classList.remove("green-text");
    document.getElementById("td4").classList.add("red-text");
    document.getElementById("td4").innerHTML = "Unknown";
    document.getElementById("td7").classList.remove("green-text");
    document.getElementById("td7").classList.add("red-text");
    document.getElementById("td7").innerHTML = "Unknown";

    // Invalid input
    if (!place.geometry) {
      document.getElementById("autocomplete-input").value = "";
      document.getElementById("autocomplete-input").placeholder = "You must select an autocomplete location";
      document.getElementById("autocomplete-input").classList.add("invalid");
      document.getElementById("disabled").value = "Location has not been chosen yet";

      // Remove address from confirmation pane
      if (document.getElementById("indicator1").innerHTML === "location_on") {
        document.getElementById("td1").innerHTML = "Unspecified";
        document.getElementById("td1").classList.remove("green-text");
        document.getElementById("td1").classList.add("red-text");
      } else {
        document.getElementById("td2").innerHTML = "Unspecified";
        document.getElementById("td2").classList.remove("green-text");
        document.getElementById("td2").classList.add("red-text");
      }

      document.getElementById("td4").classList.remove("green-text");
      document.getElementById("td4").classList.add("red-text");
      document.getElementById("td4").innerHTML = "Unknown";
      document.getElementById("td7").classList.remove("green-text");
      document.getElementById("td7").classList.add("red-text");
      document.getElementById("td7").innerHTML = "Unknown";

      loc_lat = null;
      loc_lng = null;

      // UPDATE ROUTE
      update();

      return;
    }

    // Store lat and lng of autocomplete
    loc_lat = place.geometry.location.lat();
    loc_lng = place.geometry.location.lng();

    // Check if location is in county bounds
    if (!validateAddress(loc_lat, loc_lng, false)) {
      document.getElementById("autocomplete-input").value = "";
      document.getElementById("autocomplete-input").placeholder = "Location is not in operational bounds";
      document.getElementById("autocomplete-input").classList.add("invalid");
      document.getElementById("disabled").value = "Location has not been chosen yet";

      // Remove address from confirmation pane
      if (document.getElementById("indicator1").innerHTML === "location_on") {
        document.getElementById("td1").innerHTML = "Unspecified";
        document.getElementById("td1").classList.remove("green-text");
        document.getElementById("td1").classList.add("red-text");
      } else {
        document.getElementById("td2").innerHTML = "Unspecified";
        document.getElementById("td2").classList.remove("green-text");
        document.getElementById("td2").classList.add("red-text");
      }

      document.getElementById("td4").classList.remove("green-text");
      document.getElementById("td4").classList.add("red-text");
      document.getElementById("td4").innerHTML = "Unknown";
      document.getElementById("td7").classList.remove("green-text");
      document.getElementById("td7").classList.add("red-text");
      document.getElementById("td7").innerHTML = "Unknown";

      loc_lat = null;
      loc_lng = null;

      // UPDATE ROUTE
      update();

      return;
    }

    // Restore search bar
    document.getElementById("autocomplete-input").placeholder = "Search";
    document.getElementById("autocomplete-input").classList.remove("invalid");
    document.getElementById("disabled").value = place.formatted_address;

    // Append value to confirmation pane
    if (document.getElementById("indicator1").innerHTML === "location_on") {
      document.getElementById("td1").innerHTML = place.formatted_address;
      document.getElementById("td1").classList.remove("red-text");
      document.getElementById("td1").classList.add("green-text");
    } else {
      document.getElementById("td2").innerHTML = place.formatted_address;
      document.getElementById("td2").classList.remove("red-text");
      document.getElementById("td2").classList.add("green-text");
    }

    // Change viewport to fit marker
    if (place.geometry.viewport) {
      map.fitBounds(place.geometry.viewport);
    } else {
      map.setCenter(place.geometry.location);
      map.setZoom(15);
    }

    // Set marker
    marker.setPosition(place.geometry.location);
    marker.addListener("click", function() {
      document.getElementById("slider").click();
    });
    marker.setVisible(true);

    // UPDATE ROUTE
    update();
  });
}
