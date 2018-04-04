function coordinate(x, y) {
  this.x = x;
  this.y = y;
}

function initMap() {
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

  autocomplete.addListener("place_changed", function() {
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
        console.log('[a] Directions request failed due to ' + status);
      }
      // directionsDisplay.setDirections(response);
      var polyline = new google.maps.Polyline({
        path: [],
        strokeColor: '#0000FF',
        strokeWeight: 3
      });
      var bounds = new google.maps.LatLngBounds();


      var arr = [];

      var legs = response.routes[0].legs;
      for (i = 0; i < legs.length; i++) {
        var steps = legs[i].steps;
        for (j = 0; j < steps.length; j++) {
          var nextSegment = steps[j].path;
          for (k = 0; k < nextSegment.length; k++) {
            polyline.getPath().push(nextSegment[k]);
            // document.getElementById("info99").innerHTML = nextSegment[k].lng();
            arr.push(new coordinate(nextSegment[k].lat(), nextSegment[k].lng()));
            bounds.extend(nextSegment[k]);
          }
        }
      }

      polyline.setMap(map);
      map.fitBounds(bounds);

      document.getElementById("info3").innerHTML = "Estimated historic time: " + response.routes[0].legs[0].duration.text;

      var pointsList = polyline.getPath().getArray();

      document.getElementById("info99").innerHTML = pointsList;

      /*
      for( i = 0; i < arr.length; i++ ) {

        var position = new google.maps.LatLng(arr[i].x, arr[i].y);
        bounds.extend(position);
        var marker = new google.maps.Marker({
            position: position,
            map: map
        });

        // Automatically center the map fitting all markers on the screen
        map.fitBounds(bounds);
      }
      */

      // alert("lat: " + arr[0].x + ", lng: " + arr[0].y + "; " + "lat2: " + arr[1].x + ", lng: " + arr[1].y);

      var firstFruits = [];

      for (let i = 0; i < arr.length; i = i + 25) {
        firstFruits.push(arr[i]);
      }

      // alert(arr[20].x + " " + arr[20].y
      //37.337920000000004 -121.93791000000002
      //37.334160000000004 -121.93633000000001
      //37.334500000000006 -121.93552000000001
      //alert(firstFruits[0].x + ", " + firstFruits[0].y);
      //alert(firstFruits[40].x + ", " + firstFruits[40].y);


      var origin1 = new google.maps.LatLng(firstFruits[0].x, firstFruits[0].y);
      var destinationB = new google.maps.LatLng(firstFruits[40].x, firstFruits[40].y);
      var ds = new google.maps.DirectionsService();
      ds.route({
        origin: origin1,
        destination: destinationB,
        travelMode: google.maps.TravelMode.DRIVING
      }, function (response, status) {
        if (status === google.maps.DirectionsStatus.OK) {
          console.log(response.routes[0].legs[0].duration.text);
        } else {
          console.log('[b] Directions request failed due to ' + status);
        }
      });

      // OVERQUERY

      addTiming(arr, response.routes[0].legs[0].duration.value);

      for (let i = 0; i < firstFruits.length; i++) {
        ds.route({
          origin: origin1,
          destination: destinationB,
          travelMode: google.maps.TravelMode.DRIVING
        }, function (response, status) {
          if (status === google.maps.DirectionsStatus.OK) {
            console.log("hi");
          }
          else {
            console.log('[c] Directions request failed due to ' + status);
          }
        });
      }
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


google.maps.event.addDomListener(window, "load", initMap);