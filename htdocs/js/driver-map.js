var map;

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
}

/*

var loc_lat = null;
var loc_lng = null;
var map;
var initialMarker = null;
var interval = null;
var riderFound = false;

$(document).ready(function(){
    initMap();
    // Start / Stop "working" 
    document.getElementById("working-toggle").addEventListener("click", function(){
        if(riderFound) return;
        let workingValue = 0;
        if(this.textContent == "CANCEL") {
            cancel();
            workingValue = 0;
        } else {
            start();
            workingValue = 1;
        }
        $.post("js/ajax/request.php", {
            selector: "working",
            value: workingValue
        }, function(output){
            // console.log(output);
        });
    });
});


function start(){
    // Change button to CANCEL
    if(document.getElementById("working-toggle").classList.contains("green")) 
        document.getElementById("working-toggle").classList.remove("green");
    if(!document.getElementById("working-toggle").classList.contains("red"))
        document.getElementById("working-toggle").classList.add("red");
    document.getElementById("working-toggle").textContent = "CANCEL";

    // Initialize the progress bar and status
    document.getElementById("preload").classList.remove("determinate");
    document.getElementById("preload").classList.add("indeterminate");
    document.getElementById("waiting-message").innerHTML = "Waiting for rider request";
    document.getElementById("progress").style.visibility = "visible";

    // Check requests right away, and initialize a timer for checking.
    // Wait 2 seconds to check requests initially.
    setTimeout(checkRequests, 2000);
    interval = window.setInterval(checkRequests, 60000);
}

function cancel(){
    // TODO: Add error checks here to made sure it's allowed for the driver to stop working 
 
    // Change button back to START
    if(document.getElementById("working-toggle").classList.contains("red"))         
        document.getElementById("working-toggle").classList.remove("red");
    if(!document.getElementById("working-toggle").classList.contains("green")) 
        document.getElementById("working-toggle").classList.add("green");
    document.getElementById("working-toggle").textContent = "START";

    // Get rid of the progress bar if it isn't already taken care of.
    document.getElementById("preload").classList.remove("indeterminate");
    document.getElementById("preload").classList.add("determinate");
    document.getElementById("waiting-message").innerHTML = "";
    document.getElementById("progress").style.visibility = "hidden";

    // Clear interval checking for requests
    clearInterval(interval);
}

function initMap() {
    getLocation(); 
    map = new google.maps.Map(document.getElementById("map"), {
      center: { lat: 37.3351874, lng: -121.88107150000002 },
      clickableIcons: false,
      fullscreenControl: false,
      mapTypeControl: false,
      streetViewControl: false,
      zoom: 15
    });
}

// Fetches location from DB and stores it in loc_lat and loc_lng
function getLocation() {
    console.log("Getting location")
    $.post("js/ajax/request.php", {
        selector: "getLocation"
    }, function(output){
        if(output == "") return;
        if(output == "null") return;
        output = JSON.parse(output);
        console.log(output)
        loc_lat = output.lat;
        loc_lng = output.lng;
        showPosition();
    });
}

function showPosition(position) {
    console.log(loc_lat + ", " + loc_lng);
    initialLocation = new google.maps.LatLng(loc_lat, loc_lng);

    if(map == null) return;
    // Center map    
    map.setCenter(initialLocation);

    // Map marker
    initialMarker = new google.maps.Marker({
        position: initialLocation,
        map: map,
        title: loc_lat + ", " + loc_lng,
        animation: google.maps.Animation.DROP
    });
}

function showError(error) {
    switch(error.code) {
        case error.PERMISSION_DENIED:
            debug.innerHTML = "User denied the request for Geolocation."
            break;
        case error.POSITION_UNAVAILABLE:
            debug.innerHTML = "Location information is unavailable."
            break;
        case error.TIMEOUT:
            debug.innerHTML = "The request to get user location timed out."
            break;
        case error.UNKNOWN_ERROR:
            debug.innerHTML = "An unknown error occurred."
            break;
    }
} 

// Sends AJAX request to check the requests table for a rider who needs a driver.
function checkRequests(){
    console.log("Checking requests");
    $.post("js/ajax/request.php", {
        selector: "check"
    }, function(output){
        // Receives request in form of JSON
        // { "id", "id_rider", "id_driver", "airport", "time" }

        // IF (VALID REQUEST)
        if(output == "") return;
        if(output === "null") return;
        
        console.log("after check: " + output);
        output = JSON.parse(output);
        
        riderFound = true;

        // Clear interval checking for requests
        clearInterval(interval);
    
        // Stop progress bar and change message
        document.getElementById("waiting-message").innerHTML = 
            "Rider found!</br>" + output.time/1000/60 + " minutes to " + output.airport;
        document.getElementById("preload").classList.remove("indeterminate");    
        document.getElementById("preload").classList.add("determinate");
    
        // Change button to GO
        document.getElementById("working-toggle").innerHTML = "GO <i class='material-icons'>navigation</i>"
        document.getElementById("working-toggle").classList.remove("red");
        document.getElementById("working-toggle").classList.add("blue");
        // Change button to direct to official Google Maps navigation. Currently SJSU is hardcoded.
        document.getElementById("working-toggle").href =
            "https://www.google.com/maps/dir/?api=1&destination=" + 37.3351874 + "," + -121.88107150000002;

    });
}

*/