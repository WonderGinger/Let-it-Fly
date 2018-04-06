var destinations = {
  "sfo": {
    "lat": 37.6213,
    "long": -122.3790
  },
  "sjc": {
    "lat": 37.3639,
    "long": -121.9289
  },
  "oak": {
    "lat": 37.7126,
    "long": -122.2197
  }
};

function coordinate(x, y) {
  this.x = x;
  this.y = y;
}

function initMap() {

  var polyline;

  var map = new google.maps.Map(document.getElementById("map"), {
    center: {lat: 37.3352, lng: -121.8811},
    clickableIcons: false,
    disableDefaultUI: true,
    zoom: 15,
  });

  var input = document.getElementById("autocomplete-input");
  var autocomplete = new google.maps.places.Autocomplete(input);
  // Bias the results to the map's viewport
  autocomplete.bindTo("bounds", map);
  autocomplete.setTypes(["address"]);

  var marker = new google.maps.Marker({
    map: map,
    anchorPoint: new google.maps.Point(0, -29)
  });

  var origin_lat;
  var origin_lng;



  autocomplete.addListener("place_changed", function () {
    marker.setVisible(false);
    var place = autocomplete.getPlace();
    if (!place.geometry) {
      // User entered the name of a place that was not suggested, or the place details request failed
      window.alert("No details available for input: " + place.name);
      return;
    }

    // If the place has a geometry, then present it on the map
    if (place.geometry.viewport) {
      map.fitBounds(place.geometry.viewport);
    } else {
      map.setCenter(place.geometry.location);
      map.setZoom(15);
    }
    marker.setPosition(place.geometry.location);
    marker.setVisible(true);

    // Save origin lat and lng
    origin_lat = place.geometry.location.lat();
    origin_lng = place.geometry.location.lng();

    document.getElementById("info0").innerHTML = place.name;
    document.getElementById("info1").innerHTML = "Origin lat: " + origin_lat + "; Origin long: " + origin_lng;
    document.getElementById("info2").innerHTML = "Destination: " + document.getElementById("sel").value;

    // Check if origin address is valid
    if(!validateAddress(origin_lat, origin_lng, true)){
      alert("The address must be in San Mateo County, Alameda County, or Santa Clara County.");
      return;
    }


    var dest_lat;
    var dest_lng;

    if (document.getElementById("sel").value === "SFO") {
      dest_lat = destinations.sfo.lat;
      dest_lng = destinations.sfo.long;
    }

    if (document.getElementById("sel").value === "SJC") {
      dest_lat = destinations.sjc.lat;
      dest_lng = destinations.sjc.long;
    }

    if (document.getElementById("sel").value === "OAK") {
      dest_lat = destinations.oak.lat;
      dest_lng = destinations.oak.long;
    }

    var directionsService = new google.maps.DirectionsService();
    var directionsDisplay = new google.maps.DirectionsRenderer({
      map: map,
      preserveViewport: true
    });

    directionsService.route({
      origin: new google.maps.LatLng(origin_lat, origin_lng),
      destination: new google.maps.LatLng(dest_lat, dest_lng),
      travelMode: google.maps.TravelMode.DRIVING
    }, function (response, status) {

      if (status !== google.maps.DirectionsStatus.OK) {
        window.alert('Directions request failed due to ' + status);
      }

      console.log("Travel time: " + response.routes[0].legs[0].duration.text);

      // had polyline from before, remove it from map
      if (polyline != null) {
        polyline.setMap(null);
      }

      // directionsDisplay.setDirections(response);
      polyline = new google.maps.Polyline({
        path: [],
        strokeColor: '#0000FF',
        strokeWeight: 3
      });

      var bounds = new google.maps.LatLngBounds();

      var coordinatesArr = [];

      var legs = response.routes[0].legs;
      for (i = 0; i < legs.length; i++) {
        var steps = legs[i].steps;
        for (j = 0; j < steps.length; j++) {
          var nextSegment = steps[j].path;
          for (k = 0; k < nextSegment.length; k++) {
            polyline.getPath().push(nextSegment[k]);
            // document.getElementById("info99").innerHTML = nextSegment[k].lng();
            coordinatesArr.push(new coordinate(nextSegment[k].lat(), nextSegment[k].lng()));
            bounds.extend(nextSegment[k]);
          }
        }
      }

      polyline.setMap(map);
      map.fitBounds(bounds);

      document.getElementById("info3").innerHTML = "Estimated historic time: " + response.routes[0].legs[0].duration.text;

      addTiming(coordinatesArr, response.routes[0].legs[0].duration.value);

      // Display point object data for demo
      var items = document.getElementById("info99");
      items.innerHTML = "";
      for (var i = 0; i < coordinatesArr.length; i++) {
        var output = document.createElement("li");
        output.innerHTML = "[Point " + i + "] lat: " + coordinatesArr[i].x + ", lng: " + coordinatesArr[i].y + ", time: " + coordinatesArr[i].time;
        items.appendChild(output);
      }


      var myarray = new Array();

      var params = { myarray: myarray };

      var paramJSON = JSON.stringify(params);

      // 1 Mile radius testing 
      console.log("1 mile radius: " + check1MileRadius(37.271099, -122.015098, coordinatesArr));

      $.post(
        'test.php',
          { data: paramJSON },
          function(data) {
              var result = JSON.parse(data);
          });
    });

  });
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
    totalDistance += getDistanceFromLatLonInKm(arr[i - 1].x, arr[i - 1].y, arr[i].x, arr[i].y);
  }

  arr[0].time = 0; // time to first is zero

  for (let i = 1; i < arr.length; i++) {

    prev = arr[i - 1];

    // time to i-th coordinate = time to (i-1)th coordinate + time to cover the distance b/t the two
    arr[i].time = ((getDistanceFromLatLonInKm(prev.x, prev.y, arr[i].x, arr[i].y) / totalDistance) * totalTime)
      + arr[i - 1].time;

  }

}

// from stackoverflow
function getDistanceFromLatLonInKm(lat1, lon1, lat2, lon2) {
  var R = 6371; // Radius of the earth in km
  var dLat = deg2rad(lat2 - lat1);  // deg2rad below
  var dLon = deg2rad(lon2 - lon1);
  var a =
    Math.sin(dLat / 2) * Math.sin(dLat / 2) +
    Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
    Math.sin(dLon / 2) * Math.sin(dLon / 2);
  var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
  var d = R * c; // Distance in km
  return d;
}

function deg2rad(deg) {
  return deg * (Math.PI / 180)
}

function km2mi(km) {
  return km * 0.621371;
}
google.maps.event.addDomListener(window, "load", initMap);

// These are rough polygons that more or less equate to the counties.
// They are not perfect or even particularly accurate, and surely overlap.
var sanMateoCounty = new google.maps.Polygon({
  paths: [
    new google.maps.LatLng(37.710187, -122.543591),
    new google.maps.LatLng(37.105402, -122.510670),
    new google.maps.LatLng(37.198355, -122.127484),
    new google.maps.LatLng(37.507291, -122.113751),
    new google.maps.LatLng(37.711817, -122.391156)
  ]
});

var santaClaraCounty = new google.maps.Polygon({
  paths: [
    new google.maps.LatLng(37.466437, -122.182572),
    new google.maps.LatLng(36.886512, -121.583130),
    new google.maps.LatLng(36.957874, -121.205475),
    new google.maps.LatLng(37.197617, -121.233602),
    new google.maps.LatLng(37.188878, -121.407682),
    new google.maps.LatLng(37.492592, -121.407349)
  ]
});

var alamedaCounty = new google.maps.Polygon({
  paths: [
    new google.maps.LatLng(37.822140, -121.556944),
    new google.maps.LatLng(37.544660, -121.556209),
    new google.maps.LatLng(37.483659, -121.469005),
    new google.maps.LatLng(37.452595, -121.926311),
    new google.maps.LatLng(37.874393, -122.411769),
    new google.maps.LatLng(37.913949, -122.263454),
    new google.maps.LatLng(37.732793, -121.899532)
  ]
});

/**
 * @param lat, the latitude of the address to be checked.
 * @param long, the longitude
 * @param debug, boolean used to print debugging information to the console.
 * @returns boolean of if the address passed is within the correct counties.
 */
function validateAddress(lat, long, debug = false){
  address = new google.maps.LatLng(lat, long);

  let sanMateo = google.maps.geometry.poly.containsLocation(address, sanMateoCounty);
  let santaClara = google.maps.geometry.poly.containsLocation(address, santaClaraCounty);
  let alameda = google.maps.geometry.poly.containsLocation(address, alamedaCounty);

  if(debug){
    console.log("San Mateo County: " + sanMateo);
    console.log("Santa Clara County: " + santaClara);
    console.log("Alameda County: " + alameda);
  }
  return sanMateo || santaClara || alameda;
}

/**
 * 
 * @param lat the latitude of the rider making the request
 * @param long the longitude
 * @param points the coordinate array of the path to check against
 * @returns boolean of if the address is within 1 mile radius
 */
function check1MileRadius(lat, long, points) {
  for ( p in points){
    var dist = km2mi(getDistanceFromLatLonInKm(points[p].x, points[p].y, lat, long));
    console.log(dist);
    if (dist <= 1) return true
  }
  return false;
}