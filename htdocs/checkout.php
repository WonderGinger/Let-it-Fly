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
    <!-- Navigation bar -->
    <nav class="white">
      <div class="container">
        <div class="nav-wrapper">
          <a class="brand-logo" href="/"><i class="material-icons teal-text text-lighten-1">airport_shuttle</i></a>
          <a class="sidenav-trigger" data-target="slide-out" href=""><i class="material-icons teal-text text-lighten-1">menu</i></a>
          <ul class="right hide-on-med-and-down">
            <li class="waves-effect"><a class="teal-text text-lighten-1" href="about">User Manual</a></li>
            <li class="waves-effect"><a class="teal-text text-lighten-1" href="sign-up">Create an Account</a></li>
            <li><a class="btn waves-effect waves-light" href="">Sign In</a></li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- Navigation menu -->
    <ul class="sidenav" id="slide-out">
      <li>
        <div class="user-view">
          <div class="background"><img src="img/sjsu.png" alt="SJSU"></div>
          <div class="valign-table">
            <div class="valign-table-cell">
              <a class="btn waves-effect waves-light" href="">Sign In</a>
            </div>
          </div>
        </div>
      </li>
      <li><a class="teal-text text-lighten-1 waves-effect" href="about">User Manual</a></li>
      <li><a class="teal-text text-lighten-1 waves-effect" href="sign-up">Create an Account</a></li>
    </ul>
    
    <!-- Credit card  -->
    <div class="container">
        <div class="card">
            <div class="card-content">
                <span class="card-title teal-text text-lighten-1">Enter payment information</span>

                <div class="row">
                <form class="col s12">
                    <div class="row">
                    <div class="input-field col s6">
                        <input id="input_text" type="text" data-length="10">
                        <label for="input_text">Input text</label>
                    </div>
                    </div>
                </form>
                </div>
                <div class="row">
                    <input class="col s3" placeholder="Security #">
                </div>
            </div>
        </div>
    </div>

    <!-- Import JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-alpha.4/js/materialize.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>    
    <script src="js/materialize.js"></script>
    <script src="js/checkout.js"></script>
  </body>
</html>