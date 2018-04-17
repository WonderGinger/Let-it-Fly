google.maps.event.addDomListener(window, "load", initMap);

var map;
var loc_lat = null;
var loc_lng = null;
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
  // Define map options
  map = new google.maps.Map(document.getElementById("map"), {
    center: { lat: 37.62445, lng: -122.26612 },
    clickableIcons: false,
    fullscreenControl: false,
    mapTypeControl: false,
    streetViewControl: false,
    zoom: 10
  });

  // Initialize autocomplete module
  var marker = new google.maps.Marker({ map: map });
  var input = document.getElementById("autocomplete-input");
  var autocomplete = new google.maps.places.Autocomplete(input);
  autocomplete.bindTo("bounds", map);

  // Autocomplete listener
  autocomplete.addListener("place_changed", function() {
    // Clear previous data
    marker.setVisible(false);
    clearRideDetails();

    // Store place for future use
    var place = autocomplete.getPlace();

    // Invalid input
    if (!place.geometry) {
      // Clear autocomplete and display error
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

      clearRideDetails();

      // Clear global values
      loc_lat = null;
      loc_lng = null;
      update();

      return;
    }

    // Store lat and lng of autocomplete for future use
    // lat and lng are global values for other methods
    loc_lat = place.geometry.location.lat();
    loc_lng = place.geometry.location.lng();

    // Check if location is in county bounds
    if (!validateAddress(loc_lat, loc_lng, false)) {
      // Clear autocomplete and display error
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

      clearRideDetails();

      // Clear global values
      loc_lat = null;
      loc_lng = null;
      update();

      return;
    }

    // Restore search bar
    document.getElementById("autocomplete-input").placeholder = "Search";
    document.getElementById("autocomplete-input").classList.remove("invalid");
    document.getElementById("disabled").value = place.formatted_address;

    // Append value to confirmation pane, depending on directions toggle
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
    }

    // Set marker
    marker.setPosition(place.geometry.location);
    marker.addListener("click", function() {
      document.getElementById("slider").click();
    });
    marker.setVisible(true);

    // Change update button status accordingly
    update();
  });
}

function clearRideDetails() {
  // Clear distance
  document.getElementById("td7").classList.remove("green-text");
  document.getElementById("td7").classList.add("red-text");
  document.getElementById("td7").innerHTML = "Unknown";
  // Clear duration
  document.getElementById("td4").classList.remove("green-text");
  document.getElementById("td4").classList.add("red-text");
  document.getElementById("td4").innerHTML = "Unknown";
  // Clear warning
  document.getElementById("warning").classList.add("hide");
  document.getElementById("warning").innerHTML = "";
  // Clear wait time
  document.getElementById("td5").classList.remove("green-text");
  document.getElementById("td5").classList.add("red-text");
  document.getElementById("td5").innerHTML = "Unknown";
  // Clear cost
  document.getElementById("td6").classList.remove("green-text");
  document.getElementById("td6").classList.add("red-text");
  document.getElementById("td6").innerHTML = "Unknown";
  // Clear submit button
  document.getElementById("update-wrap").classList.remove("hide");
  document.getElementById("submit-wrap").classList.add("hide");
}

// Change button state if valid status
function update() {
  if (loc_lat != null && loc_lng != null && document.getElementById("airport-select").value != "") {
    document.getElementById("update").classList.remove("disabled");
  } else {
    document.getElementById("update").classList.add("disabled");
  }
}

// Verify if all fields are correct before using direction service
function verify() {
  // Prevent user from updating data during load
  disableInterface();

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
  var toAirport = false;
  if (document.getElementById("indicator1").innerHTML === "location_on") {
    ori_lat = loc_lat;
    ori_lng = loc_lng;
    des_lat = airport_lat;
    des_lng = airport_lng;
    toAirport = true;
    var airportfix = document.getElementById("airport-select").value;
  } else {
    ori_lat = airport_lat;
    ori_lng = airport_lng;
    des_lat = loc_lat;
    des_lng = loc_lng;

    if (des_lat === destinations.sfo.lat && des_lng === destinations.sfo.long) {
      toAirport = true;
      var airportfix = "SFO";
    }
    if (des_lat === destinations.oak.lat && des_lng === destinations.oak.long) {
      toAirport = true;
      var airportfix = "OAK";
    }
    if (des_lat === destinations.sjc.lat && des_lng === destinations.sjc.long) {
      toAirport = true;
      var airportfix = "SJC";
    }
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

    // Update distance in confirmation pane
    document.getElementById("td7").classList.remove("red-text");
    document.getElementById("td7").classList.add("green-text");
    document.getElementById("td7").innerHTML = response.routes[0].legs[0].distance.text;

    // Update cost in confirmation pane
    var travelCost = (response.routes[0].legs[0].distance.value * 0.000621371192 * 2).toFixed(2);
    document.getElementById("td6").classList.remove("red-text");
    document.getElementById("td6").classList.add("green-text");
    document.getElementById("td6").innerHTML = "$" + travelCost;

    // Cancel request if cost is less than $15
    if (travelCost < 15) {
      enableInterface();

      // Display error
      document.getElementById("warning").classList.remove("hide");
      document.getElementById("warning").innerHTML = "Requests must cost a minimum of $15.";
      // Red out cost
      document.getElementById("td6").classList.remove("green-text");
      document.getElementById("td6").classList.add("red-text");
      // Change calculating wait time back to Unknown
      document.getElementById("td5").innerHTML = "Unknown";

      // Red out distance
      document.getElementById("td7").classList.remove("green-text");
      document.getElementById("td7").classList.add("red-text");

      return;
    }

    // Update duration in confirmation pane
    var travelTime = response.routes[0].legs[0].duration.text;
    document.getElementById("td4").classList.remove("red-text");
    document.getElementById("td4").classList.add("green-text");
    document.getElementById("td4").innerHTML = travelTime;

    // Build original polyline
    var polyline = new google.maps.Polyline({
      path: [],
      strokeColor: '#4597ff',
      strokeWeight: 6
    });

    // Load array of coordinates with lat, lng, and eta
    var coordinates = [];
    coordinates.push({ "lat": ori_lat, "lng": ori_lng, "eta": undefined });
    polyline.getPath().push(new google.maps.LatLng(ori_lat, ori_lng));
    var legs = response.routes[0].legs;
    for (i = 0; i < legs.length; i++) {
      var steps = legs[i].steps;
      for (j = 0; j < steps.length; j++) {
        var nextSegment = steps[j].path;
        for (k = 0; k < nextSegment.length; k++) {
          polyline.getPath().push(nextSegment[k]);
          coordinates.push({ "lat": nextSegment[k].lat(), "lng": nextSegment[k].lng(), "eta": undefined });
        }
      }
    }
    coordinates.push({ "lat": des_lat, "lng": des_lng, "eta": undefined });
    polyline.getPath().push(new google.maps.LatLng(des_lat, des_lng));
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

    // Encode the polyline
    var encodeString = google.maps.geometry.encoding.encodePath(polyline.getPath());

    // Check database for available drivers
    $.post("js/ajax/request.php", {
      data: { waypoints },
      passengers: document.getElementById("range").value,
      selector: "drivers"
    }, function(output) {
      // List of working drivers with non-zero seats and less than 2 parties
      var drivers = JSON.parse(output);

      // No drivers
      if (drivers.length === 0) {
        enableInterface();
        document.getElementById("warning").classList.remove("hide");
        document.getElementById("warning").innerHTML = "No drivers are available with open seats; please try again later.";
        // Change calculating wait time back to Unknown
        document.getElementById("td5").innerHTML = "Unknown";
        return;
      }

      // Check if rider is going to airport, filter drivers by matching destination
      // If rider is not going to airport, driver parties must be 0 and null des
      var betterDrivers = [];
      if (toAirport) {
        for (var i = 0; i < drivers.length; i++) {
          if (airportfix === drivers[i]["des"] || drivers[i]["des"] === null) {
            betterDrivers.push(drivers[i]);
          }
        }
        if (betterDrivers.length === 0) {
          enableInterface();
          document.getElementById("warning").classList.remove("hide");
          document.getElementById("warning").innerHTML = "No drivers with matching destination; please try again later.";
          document.getElementById("td5").innerHTML = "Unknown";
          return;
        }
      } else {
        for (var i = 0; i < drivers.length; i++) {
          if (drivers[i]["parties"] == 0 && drivers[i]["des"] === null) {
            betterDrivers.push(drivers[i]);
          }
        }
        if (betterDrivers.length === 0) {
          enableInterface();
          document.getElementById("warning").classList.remove("hide");
          document.getElementById("warning").innerHTML = "No drivers are available for private travel; please try again later.";
          document.getElementById("td5").innerHTML = "Unknown";
          return;
        }
      }

      // Iterate through each driver to find wait time
      for (var i = 0; i < betterDrivers.length; i++) {
        var src = new google.maps.LatLng(betterDrivers[i]["lat"], betterDrivers[i]["lng"]);
        var des = new google.maps.LatLng(ori_lat, ori_lng);
        var request = {
          origin: src,
          destination: des,
          travelMode: google.maps.DirectionsTravelMode.DRIVING
        };

        getWaitTime(i, request, src, des, function(counter, result, result2, result3) {
          betterDrivers[counter]["eta"] = result;
          betterDrivers[counter]["wpoints"] = result2;
          betterDrivers[counter]["polyline"] = result3;
          // Display async results one by one
          // console.log(result);
        });
      }

      // Delayed asynchronous function
      var delay = 0;
      function getWaitTime(counter, request, src, des, callback) {
        var service = new google.maps.DirectionsService();
        service.route(request, function(result, status) {
          if (status === google.maps.DirectionsStatus.OK) {
            // Only path is really needed
            var polyline = new google.maps.Polyline({
              path: [],
              strokeColor: '#4597ff',
              strokeWeight: 6
            });

            // Load array of dpoints with lat, lng, and eta
            var dpoints = [];
            dpoints.push({ "lat": src.lat(), "lng": src.lng(), "eta": undefined });
            polyline.getPath().push(new google.maps.LatLng(src.lat(), src.lng()));
            var legs = result.routes[0].legs;
            for (i = 0; i < legs.length; i++) {
              var steps = legs[i].steps;
              for (j = 0; j < steps.length; j++) {
                var nextSegment = steps[j].path;
                for (k = 0; k < nextSegment.length; k++) {
                  polyline.getPath().push(nextSegment[k]);
                  dpoints.push({ "lat": nextSegment[k].lat(), "lng": nextSegment[k].lng(), "eta": undefined });
                }
              }
            }
            dpoints.push({ "lat": des.lat(), "lng": des.lng(), "eta": undefined });
            polyline.getPath().push(new google.maps.LatLng(des.lat(), des.lng()));
            addTiming(dpoints, result.routes[0].legs[0].duration.value);

            // Only take the minute dpoints
            var wpoints = [];
            wpoints.push(dpoints[0]);
            var n = 0;
            for (var i = 1; i < dpoints.length - 1; i++) {
              if (dpoints[i]["eta"] >= n) {
                wpoints.push(dpoints[i]);
                n += 60;
              }
            }
            wpoints.push(dpoints[dpoints.length - 1]);

            // Encode the polyline
            var encodeString = google.maps.geometry.encoding.encodePath(polyline.getPath());

            callback(counter, result.routes[0].legs[0].duration.value, wpoints, encodeString);
          } else if (status === google.maps.DirectionsStatus.OVER_QUERY_LIMIT) {
            delay++;
            setTimeout(function () {
              getWaitTime(counter, request, src, des, callback);
            }, delay * 1000);
          } else {
            window.alert("Directions request failed: " + status);
          }
        });
      }

      // When all asynchronous functions finish, process data
      setTimeout(function() {
        enableInterface();
        var bestDrivers = getBestDrivers(betterDrivers);

        // 30-minute wait time check
        if (bestDrivers.length === 0) {
          document.getElementById("warning").classList.remove("hide");
          document.getElementById("warning").innerHTML = "No drivers are within a 30-minute distance; please try again later.";
          document.getElementById("td5").innerHTML = "Greater than 30 mins";
          return;
        }

        // Update wait time
        document.getElementById("td5").classList.remove("red-text");
        document.getElementById("td5").classList.add("green-text");
        document.getElementById("td5").innerHTML = Math.floor(bestDrivers[0]["eta"] / 60) + " mins";

        // Show request button
        document.getElementById("update-wrap").classList.add("hide");
        document.getElementById("submit-wrap").classList.remove("hide");

        // Debug alert
        console.log("Driver ID " + bestDrivers[0]["id"] + " selected.");

        // Use jQuery event handling or submit will trigger twice
        $("#submit").off("click");
        $("#submit").on("click", function() {
          // TODO: MUST CROSS-CHECK VALUES IF DRIVER IS MOVING
          console.log(JSON.stringify(bestDrivers[0]));



          //console.log(JSON.stringify(waypoints));
          /*
          $.post("js/ajax/request.php", {
            data: { guy },
            selector: "submit"
          }, function(output) {
            if (output === "db-error") {
              // Some kind of database error occurred
              location = "/db-error";
            } else {
              // Reload the page since request has been submitted
              // location.reload();
            }
          });
          */
        });
       }, betterDrivers.length * 1000);
    });
  });
}

function disableInterface() {
  // Disable update button
  document.getElementById("update").classList.add("disabled");
  document.getElementById("update").innerHTML = "Loading...";
  // Passenger count
  document.getElementById("range").disabled = true;
  document.getElementById("range").classList.add("disabled");
  // Directions toggle
  document.getElementById("switch").disabled = true;
  // Airport selector
  document.getElementsByClassName("select-dropdown")[0].disabled = true;
  // Slider title
  document.getElementById("tabu").style["pointer-events"] = "none";
  document.getElementById("tabu").classList.remove("teal-text");
  document.getElementById("tabu").classList.remove("lighten-1");
  document.getElementById("tabu").classList.add("grey-text");
  // Loading bar
  document.getElementById("preload").classList.remove("hide");
  // Wait time loading
  document.getElementById("td5").classList.remove("red-text");
  document.getElementById("td5").classList.add("orange-text");
  document.getElementById("td5").innerHTML = "Calculating...";

}

function enableInterface() {
  // Display original update button text
  document.getElementById("update").innerHTML = "Search for Drivers";
  // Passenger count
  document.getElementById("range").disabled = false;
  document.getElementById("range").classList.remove("disabled");
  // Directions toggle
  document.getElementById("switch").disabled = false;
  // Airport selector
  document.getElementsByClassName("select-dropdown")[0].disabled = false;
  // Slider title
  document.getElementById("tabu").style["pointer-events"] = "auto";
  document.getElementById("tabu").classList.remove("grey-text");
  document.getElementById("tabu").classList.add("teal-text");
  document.getElementById("tabu").classList.add("lighten-1");
  // Loading bar
  document.getElementById("preload").classList.add("hide");
  // Wait time loading
  document.getElementById("td5").classList.remove("orange-text");
  document.getElementById("td5").classList.add("red-text");
  document.getElementById("td5").innerHTML = "";
}

// If airport selector is pressed, update values
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

  clearRideDetails();
  update();
});

// If direction toggle is pressed, switch values
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

  clearRideDetails();
  update();
});

// Range slider listener
document.getElementById("range").addEventListener("change", function() {
  document.getElementById("td3").innerHTML = document.getElementById("range").value;

  clearRideDetails();
  update();
});

// If update button is enabled, call directions service
document.getElementById("update").addEventListener("click", function() { verify(); });