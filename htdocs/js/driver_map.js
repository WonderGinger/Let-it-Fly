// Start / Stop "working" 
document.getElementById("working-toggle").addEventListener("click", function(){
    let workingValue = 0;
    if(this.textContent == "END") {
        if(this.classList.contains("red"))         
            this.classList.remove("red");
        if(!this.classList.contains("green")) 
            this.classList.add("green");
        this.textContent = "START";
        endWorking();
        workingValue = 0;
    } else {
        if(this.classList.contains("green")) 
            this.classList.remove("green");
        if(!this.classList.contains("red"))
            this.classList.add("red");
        this.textContent = "END";
        startWorking();
        workingValue = 1;
    }
    $.post("js/ajax/request.php", {
        selector: "working",
        value: workingValue
    }, function(output){
        // console.log(output);
    });
});

function startWorking(){
    document.getElementById("preload").classList.remove("determinate");
    document.getElementById("preload").classList.add("indeterminate");
    document.getElementById("waiting-message").innerHTML = "Waiting for rider request";
    document.getElementById("progress").style.visibility = "visible";
}

function endWorking(){
    document.getElementById("preload").classList.remove("indeterminate");
    document.getElementById("preload").classList.add("determinate");
    document.getElementById("waiting-message").innerHTML = "";
    document.getElementById("progress").style.visibility = "hidden";    
}