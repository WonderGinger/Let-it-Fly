$(document).ready(function() {
    $('input#input_text, textarea#textarea2').characterCounter();
    // var cardNumberField = document.getElementById("input_text");
    // cardNumberField.addEventListener("change", function(event){
    //     if(validateCardNumber(event)){
    //         console.log("green")
    //     }
    //     else {
    //         //red
    //     }
    // });
  });
  
function validateCardNumber(number) {
    var regex = new RegExp("^[0-9]{16}$");
    if (!regex.test(number))
        return false;

    return luhnCheck(number);
}

function luhnCheck(val) {
    var sum = 0;
    for (var i = 0; i < val.length; i++) {
        var intVal = parseInt(val.substr(i, 1));
        if (i % 2 == 0) {
            intVal *= 2;
            if (intVal > 9) {
                intVal = 1 + (intVal % 10);
            }
        }
        sum += intVal;
    }
    return (sum % 10) == 0;
}