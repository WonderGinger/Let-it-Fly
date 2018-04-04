function coordinate(x, y) {
    this.x = x;
    this.y = y;
}


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
    document.getElementById("info0").innerHTML = place.name;
    document.getElementById("info1").innerHTML = "Origin lat: " + origin_lat + "; Origin long: " + origin_lng;
    document.getElementById("info2").innerHTML = "Destination: " + document.getElementById("sel").value;


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


      var arr = new Array();



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

      var firstFruits = []

      for (var i = 0; i < arr.length; i = i+25) {
        firstFruits.push(arr[i]);
      };

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
      }, function(response, status) {
        if (status === google.maps.DirectionsStatus.OK) {
            alert(response.routes[0].legs[0].duration.text);
        } else {
          window.alert('Directions request failed due to ' + status);
        }
      });

      ds.route({
        origin: origin1,
        destination: destinationB,
        travelMode: google.maps.TravelMode.DRIVING
      } function(response, status) {
        if (status == google.maps.DirectionsStatus.OK) {
          alert("hi");
        }
        else {
            window.alert('Directions request failed due to ' + status);
        }
      });




    } else {
      window.alert('Directions request failed due to ' + status);
    }
  });


  });
}

google.maps.event.addDomListener(window, "load", initMap);