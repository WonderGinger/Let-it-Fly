

document.getElementById("update").addEventListener("click", function() {

    if (document.getElementById("update").textContent == "unclicked")
        document.getElementById("update").innerHTML = "clicked";
    else
        document.getElementById("update").innerHTML = "unclicked";
});