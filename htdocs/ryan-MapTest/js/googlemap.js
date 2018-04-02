var map; /* global variable */
var geocoder; /*global variable */

/* initMap from Google Map API devleoper */
function initMap() {
	var sfo = {lat: 37.615, lng: -122.389};
    map = new google.maps.Map(document.getElementById('map'), {
    	zoom: 9,
        center: sfo
    });
    //var marker = new google.maps.Marker ({ position: sfo, map: map });

	/* airports info pass to google geocode map api */
    var airportData = JSON.parse(document.getElementById('data').innerHTML);
    //console.log(data);
    geocoder = new google.maps.Geocoder();
    codeAddress(airportData);

    var allAirportData = JSON.parse(document.getElementById('allAirportData').innerHTML);
    displayAllAirports(allAirportData)
}

/* to display all airports on Google Map APIs */
/* possible to list all available drivers on Map */
function displayAllAirports(allAirportData) {
	var informationWindow = new google.maps.InfoWindow;
	Array.prototype.forEach.call(allAirportData, function(data) {
		
		//var informationWindow = new google.maps.InfoWindow;
		var airportContent = document.createElement('div');
		var myStrong = document.createElement('myStrong');
		myStrong.textContent = data.name;
		airportContent.appendChild(myStrong);

		var img = document.createElement('img');
		img.src = 'img/airport.jpg';
		img.style.width = '80px';
		airportContent.appendChild(img);

		var marker = new google.maps.Marker ({
    		position: new google.maps.LatLng(data.lat, data.lng),
        	map: map
       	});

		/* listener on click on the markers to display info */
       	marker.addListener('click', function() {
       		informationWindow.setContent(airportContent);
       		informationWindow.open(map, marker);
       	});
	})
}

/* modified version of Google geocode api to get lat & lng*/
function codeAddress(airportData) {
 	Array.prototype.forEach.call(airportData, function(data) {
    	var address = data.name + ' ' + data.address;
	    geocoder.geocode( { 'address': address}, function(results, status) {
	      if (status == 'OK') {
	        map.setCenter(results[0].geometry.location);
	        var points = {};
	        points.id = data.id;
	        points.lat = map.getCenter().lat();
	        points.lng = map.getCenter().lng();
	        updateAirportLatLng(points); /* remote function */
	      } else {
	        alert('Geocode was not successful for the following reason: ' + status);
	      }
    	});
  	});
}

/* to update airports lat and lng of remote function called in codeAddress */
function updateAirportLatLng(points) {
	/* must included JQuery in index.php or called function main*/
	$.ajax({
		url:"update.php",
		method:"post",
		data: points,
		success: function(res) {
			console.log(res)
		}
	})
	// console.log(points)
}
