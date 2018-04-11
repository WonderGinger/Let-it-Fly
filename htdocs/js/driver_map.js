var loc_lat = null;
var loc_lng = null;
var map = null;
var initialMarker = null;
var interval = null;

// Start / Stop "working" 
document.getElementById("working-toggle").addEventListener("click", function(){
    let workingValue = 0;
    if(this.textContent == "CANCEL") {
        cancel(this);
        workingValue = 0;
    } else {
        start(this);
        workingValue = 1;
    }
    $.post("js/ajax/request.php", {
        selector: "working",
        value: workingValue
    }, function(output){
        // console.log(output);
    });
});

function start(element){
    // Change button to CANCEL
    if(element.classList.contains("green")) 
        element.classList.remove("green");
    if(!element.classList.contains("red"))
        element.classList.add("red");
    element.textContent = "CANCEL";

    // Initialize the progress bar and status
    document.getElementById("preload").classList.remove("determinate");
    document.getElementById("preload").classList.add("indeterminate");
    document.getElementById("waiting-message").innerHTML = "Waiting for rider request";
    document.getElementById("progress").style.visibility = "visible";
    
    initMap();


    // Check requests right away, and initialize a timer for checking.
    // Wait 2 seconds to check requests initially.
    setTimeout(checkRequests, 2000);
    interval = window.setInterval(checkRequests, 60000);

}

function cancel(element){
    // TODO: Add error checks here to made sure it's allowed for the driver to stop working

    // Clear interval checking for requests
    clearInterval(interval);

    // Not sure if this actually works or just appears to, but we basically erase the map when we cancel.
    document.getElementById("map").innerHTML = "";    

    // Change button back to START
    if(element.classList.contains("red"))         
        element.classList.remove("red");
    if(!element.classList.contains("green")) 
        element.classList.add("green");
    element.textContent = "START";

    // Get rid of the progress bar if it isn't already taken care of.
    document.getElementById("preload").classList.remove("indeterminate");
    document.getElementById("preload").classList.add("determinate");
    document.getElementById("waiting-message").innerHTML = "";
    document.getElementById("progress").style.visibility = "hidden";

}

function initMap() {
    getLocation();
    validateAddress(loc_lat, loc_lng);
    map = new google.maps.Map(document.getElementById("map"), {
      center: { lat: 37.3351874, lng: -121.88107150000002 },
      clickableIcons: false,
      fullscreenControl: false,
      mapTypeControl: false,
      streetViewControl: false,
      zoom: 15
    });
}

// A <p> element above the START/CANCEL button that has no innerHTML unless we add some here for debugging.
var debug = document.getElementById("debug");
function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition, showError);
    } else {
        debug.innerHTML = "Geolocation is not supported by this browser.";
    }
}

function showPosition(position) {
    loc_lat = position.coords.latitude;
    loc_lng = position.coords.longitude;

    console.log(loc_lat + ", " + loc_lng);
    initialLocation = new google.maps.LatLng(loc_lat, loc_lng);

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
    // If lat and lng havent been set somehow, default to SJSU
    if(loc_lat == null || loc_lng == null){
        loc_lat = 37.3351874;
        loc_lng = -121.88107150000002;
    }
    $.post("js/ajax/request.php", {
        selector: "check",
        lat: loc_lat,
        lng: loc_lng
    }, function(output){
        // Receives request in form of JSON
        // { "id", "id_rider", "id_driver", "airport", "time" }
        console.log(output);

        // Sets "GO" button to SJSU for now
        document.getElementById("go").href = 
            "https://www.google.com/maps/dir/?api=1&destination=" + 37.3351874 + "," + -121.88107150000002;
    });
}