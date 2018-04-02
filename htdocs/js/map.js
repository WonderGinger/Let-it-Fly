function initMap() {
  var map = new google.maps.Map(document.getElementById("map"), {
    center: { lat: 37.3352, lng: -121.8811 },
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

  var sfo_lat = 37.6213;
  var sfo_lng = -122.3790;
  var sjc_lat = 37.3639;
  var sjc_lng = - 121.9289;
  var oak_lat = 37.7126
  var oak_lng = -122.2197;

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
    document.getElementById("info1").innerHTML = origin_lat + " " + origin_lng;
    document.getElementById("info2").innerHTML = document.getElementById("sel").value;


        var dest_lat;
        var dest_lng;

        if (document.getElementById("sel").value === "SFO") {
            dest_lat = sfo_lat;
            dest_lng = sfo_lng;
        }

        if (document.getElementById("sel").value === "SJC") {
            dest_lat = sjc_lat;
            dest_lng = sjc_lng;
        }

        if (document.getElementById("sel").value == "OAK") {
            dest_lat = oak_lat;
            dest_lng = oak_lng;
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

      polyline.setMap(map);
      document.getElementById("demo").innerHTML = polyline.getPath().getArray();
    } else {
      window.alert('Directions request failed due to ' + status);
    }
  });




























  });
}

google.maps.event.addDomListener(window, "load", initMap);