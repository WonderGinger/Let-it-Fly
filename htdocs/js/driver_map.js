// document.getElementById("working-toggle").addEventListener("click", function(){
//     console.log(document.getElementById("working-toggle"));
//     if(this.innerHTML == "START") {
//         this.classList.remove("red");
//         this.classList.add("green");
//         this.innerHTML = "END";
//     } else {
//         this.classList.remove("green");
//         this.classList.add("red");
//         this.innerHTML = "START";
        
//     }
// });

document.getElementById("update").addEventListener("click", function() {
    console.log(document.getElementById("update").innerHTML);
    if (document.getElementById("update").innerHTML === "Update") {
        document.getElementById("update").innerHTML === "clicked";
     } else {
         document.getElementById("update").innerHTML === "Update";
     }
   });
   