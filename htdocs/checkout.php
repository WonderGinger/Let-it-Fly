<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no">
    <title>Checkout</title>
    <!-- Import stylesheets -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-alpha.4/css/materialize.min.css">
    <link rel="stylesheet" href="css/master.css">
  </head>
  <body class="grey lighten-3">    
    <!-- Credit card  -->
    <div class="container">
        <section>
          <span class="teal-text text-lighten-1" id="thanks" style="text-align: center"></span>
        </section>
        <div class="card">
          <div class="card-content" id="form">
              <span class="card-title teal-text text-lighten-1">Enter payment information</span>

              <div class="row">
                <form class="col s12">
                    <div class="row">
                      <!-- Card number -->
                      <div class="input-field col s6">
                          <input id="card_number" type="text" data-length="10">
                          <label for="card_number">Card #</label>
                      </div>
                      <!-- MM -->
                      <div class="input-field col s2">
                        <input id="month" type="text" data-length="3">
                        <label for="month">MM</label>
                      </div>
                      <!-- YY -->
                      <div class="input-field col s2">
                        <input id="year" type="text" data-length="3">
                        <label for="year">YY</label>
                      </div>
                      <!-- CVC -->
                      <div class="input-field col s2">
                        <input id="cvc" type="text" data-length="3">
                        <label for="cvc">CVC</label>
                      </div>
                    </div>
                    <!-- Cardholder's name -->
                    <div class="row">
                      <div class="input-field col s12">
                        <input id="name" type="text">
                        <label for="name">Cardholder name</label>
                      </div>
                    </div>
                    <!-- Billing address (later maybe) -->
                </form>
                <button id="submit" class="btn waves-effect waves-light" type="submit" name="action">Submit
                  <i class="material-icons right">send</i>
                </button>
              </div>
          </div>
        </div>
    </div>

    <!-- Import JavaScript -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-alpha.4/js/materialize.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-alpha.4/js/materialize.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>    
    <script src="js/materialize.js"></script>
    <script src="js/checkout.js"></script>
  </body>
</html>