var valid_card = false;
var valid_month = false;
var valid_year = false;
var valid_cvc = false;

$(document).ready(function() {
    // CARD #
    document.getElementById("card_number").addEventListener("input", function(){
        if($(this).val().length >= 16) {
            $(this).val(($(this).val().substr(0, 16)));
        }
        let validated = validateCardNumber($(this).val());
        if(validated) { 
            $(this).removeClass("invalid");
            $(this).addClass("valid");
            valid_card = true;
        }
        else { 
            $(this).removeClass("valid");
            $(this).addClass("invalid");
            valid_card = false;
        }
    })
    // MONTH
    document.getElementById("month").addEventListener("input", function(){
        if($(this).val().length >= 2) {
            $(this).val(($(this).val().substr(0, 2)));
        }
        let validated = validateMonth($(this).val());
        if(validated) { 
            $(this).removeClass("invalid");
            $(this).addClass("valid");
            valid_month = true;
        }
        else { 
            $(this).removeClass("valid");
            $(this).addClass("invalid");
            valid_month = false;
        }
    })
    // YEAR
    document.getElementById("year").addEventListener("input", function(){
        if($(this).val().length >= 2) {
            $(this).val(($(this).val().substr(0, 2)));
        }
        let validated = validateYear($(this).val());
        if(validated) { 
            $(this).removeClass("invalid");
            $(this).addClass("valid");
            valid_year = true;
        }
        else { 
            $(this).removeClass("valid");
            $(this).addClass("invalid");
            valid_year = false;
        }
    })
    // CVC
    document.getElementById("cvc").addEventListener("input", function(){
        if($(this).val().length >= 3) {
            $(this).val(($(this).val().substr(0, 3)));
        }
        let validated = validateCVC($(this).val());
        if(validated) { 
            $(this).removeClass("invalid");
            $(this).addClass("valid");
            valid_cvc = true;
        }
        else { 
            $(this).removeClass("valid");
            $(this).addClass("invalid");
            valid_cvc = false;
        }
    })

    // SUBMIT
    document.getElementById("submit").addEventListener("click", function(){
        if(valid_card && valid_month && valid_year && valid_cvc) {
            document.getElementById("form").remove();
            document.getElementById("thanks").innerHTML = "<h3>Thank you!</h3>";
            setTimeout(function(){
                window.location.replace("/");
            }, 3000);
        }
    })
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

var todaysDate = new Date();
var inputDate = new Date();
function validateMonth(number) {
    inputDate.setMonth(number);
    var monthValidated = inputDate.getFullYear() > todaysDate.getFullYear() || inputDate.getMonth() > todaysDate.getMonth() + 1;
    return (number - 0) == number && number <=12 && number > 0 && number.length > 1 && monthValidated;
}
function validateYear(number) {
    inputDate.setFullYear(20+number);
    var monthValidated = (inputDate.getMonth() < todaysDate.getMonth() + 1) || (inputDate.getFullYear() > todaysDate.getFullYear());
    return (number - 0) == number && number >= 18 && number.length > 1 && monthValidated;
}
function validateCVC(number) {
    return (number - 0) == number && number.length > 2;
}

Element.prototype.remove = function() {
    this.parentElement.removeChild(this);
}