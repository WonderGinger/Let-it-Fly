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

  var marker = new google.maps.Marker({
    map: map,
    anchorPoint: new google.maps.Point(0, -29)
  });

  autocomplete.addListener('place_changed', function() {
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


    // TODO: find a way to tell if marker is fully loaded instead of relying on time
    setTimeout(function(){
      document.getElementById("slider").click();
    },1000);

  });

  autocomplete.setTypes(["address"]);
}

google.maps.event.addDomListener(window, "load", initMap);