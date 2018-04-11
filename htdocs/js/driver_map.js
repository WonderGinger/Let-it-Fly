// Start / Stop working 
document.getElementById("working-toggle").addEventListener("click", function(){
    let workingValue = 0;
    if(this.textContent == "END") {
        if(this.classList.contains("red"))         
            this.classList.remove("red");
        if(!this.classList.contains("green")) 
            this.classList.add("green");
        this.textContent = "START";
        workingValue = 0;
    } else {
        if(this.classList.contains("green")) 
            this.classList.remove("green");
        if(!this.classList.contains("red"))
            this.classList.add("red");
        this.textContent = "END";
        workingValue = 1;
    }
    $.post("js/ajax/request.php", {
        selector: "working",
        value: workingValue
    }, function(output){
        console.log(output);
    });
});