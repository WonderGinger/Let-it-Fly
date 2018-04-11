// Start / Stop working 
document.getElementById("working-toggle").addEventListener("click", function(){
    console.log(document.getElementById("working-toggle").textContent);
    if(this.textContent == "END") {
        if(this.classList.contains("red"))         
            this.classList.remove("red");
        if(!this.classList.contains("green")) 
            this.classList.add("green");
        this.textContent = "START";
    } else {
        if(this.classList.contains("green")) 
            this.classList.remove("green");
        if(!this.classList.contains("red"))
            this.classList.add("red");
        this.textContent = "END";
    }
    $.post("js/ajax/request.php", {
        selector: "working"
    }, function(output){
        console.log(output);
    });
});