// Start / Stop "working" 
document.getElementById("working-toggle").addEventListener("click", function(){
    let workingValue = 0;
    if(this.textContent == "END") {
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
    element.textContent = "END";

    // Initialize the progress bar and status
    document.getElementById("preload").classList.remove("determinate");
    document.getElementById("preload").classList.add("indeterminate");
    document.getElementById("waiting-message").innerHTML = "Waiting for rider request";
    document.getElementById("progress").style.visibility = "visible";
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