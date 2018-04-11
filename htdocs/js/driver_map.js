var loc_lat = null;
var loc_lng = null;

// Start / Stop "working" 
document.getElementById("working-toggle").addEventListener("click", function(){
    let workingValue = 0;
    if(this.textContent == "CANCEL") {
        endWorking(this);
        workingValue = 0;
    } else {
        startWorking(this);
        workingValue = 1;
    }
    $.post("js/ajax/request.php", {
        selector: "working",
        value: workingValue
    }, function(output){
        // console.log(output);
    });
});

function startWorking(element){
    // Change button to END
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

}

function endWorking(element){
    // TODO: Add error checks here to made sure it's allowed for the driver to stop working

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
    var map = new google.maps.Map(document.getElementById("map"), {
      center: { lat: 37.3351874, lng: -121.88107150000002 },
      clickableIcons: false,
      fullscreenControl: false,
      mapTypeControl: false,
      streetViewControl: false,
      zoom: 15
    });
}


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
    debug.innerHTML = "Latitude: " + position.coords.latitude +
    "<br>Longitude: " + position.coords.longitude;
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