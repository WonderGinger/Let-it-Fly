<?php
require_once "../private/utilities.php";
session_start();

if (!isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"]) {
  header("location: sign-in");
  exit();
}

if (!$result = $dbh->query("SELECT lat, lng, seats FROM drivers WHERE id = {$_SESSION['id']};")) db_error();
$result = $result->fetch_array(MYSQLI_ASSOC);


$account_name = explode("@", $_SESSION["email"], 2);
$account_name = strlen($account_name[0]) > 21 ? substr($account_name[0], 0, 21) . "..." : $account_name[0];
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no">
    <title>Account Settings</title>
    <!-- Import stylesheets -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-alpha.4/css/materialize.min.css">
    <link rel="stylesheet" href="css/nouislider.css">
    <link rel="stylesheet" href="css/master.css">
    <link rel="stylesheet" href="css/sign-in.css">
  </head>
  <body class="grey lighten-3">
    <!-- Navigation bar -->
    <nav class="white">
      <div class="container">
        <div class="nav-wrapper">
          <a class="brand-logo" href="/"><i class="material-icons teal-text text-lighten-1">airport_shuttle</i></a>
          <a class="sidenav-trigger" data-target="slide-out" href=""><i class="material-icons teal-text text-lighten-1">menu</i></a>
          <ul class="right hide-on-med-and-down">
            <li class="waves-effect"><a class="teal-text text-lighten-1" href="about">Documentation</a></li>
            <li class="active waves-effect"><a class="teal-text text-lighten-1" href="account"><?php echo $account_name; ?></a></li>
            <li><a class="btn waves-effect waves-light" href="sign-out">Sign Out</a></li>
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
              <a class="btn waves-effect waves-light" href="sign-out">Sign Out</a>
            </div>
          </div>
        </div>
      </li>
      <li><a class="teal-text text-lighten-1 waves-effect" href="about">Documentation</a></li>
      <li class="active"><a class="teal-text text-lighten-1 waves-effect" href="account"><?php echo $account_name; ?></a></li>
    </ul>

<?php
if ($_SESSION["user"] == "drivers") {
  // Initialize driver in account settings
  if ($result["lat"] == 0 && $result["lng"] == 0 && $result["seats"] == 0) {
    echo <<<EOT
    <!-- Content -->
    <div class="container">
      <div class="valign-table">
        <div class="valign-table-cell">
          <div class="row">
            <div class="col s12 m8 l6 offset-m2 offset-l3">
              <!-- Sign in card -->
              <div class="card">
                <div class="card-content">
                  <span class="card-title teal-text text-lighten-1">Account Settings</span>
                  <p>You must set your number of available passenger seats and location before starting.</p>
                  <div class="row">
                    <div class="col s6"><h6 class="teal-text lighten-1">Seats</h6></div>
                    <div class="col s6"><div id="nus"></div></div>
                  </div>
                  <div class="row">
                    <div class="input-field col s12" style="margin-top: 0;">
                      <select id="airport-select">
                        <option value="" disabled selected>Select an airport</option>
                        <option value="SFO">San Francisco (SFO)</option>
                        <option value="OAK">Oakland (OAK)</option>
                        <option value="SJC">San Jose (SJC)</option>
                      </select>
                    </div>
                  </div>
                  <div class="row">
                    <!-- Footnote -->
                    <div class="col s8"><p class="red-text" id="footnote"></p></div>
                    <div class="col s4 right-align"><button class="btn waves-effect waves-light" id="submit" type="submit">Next</button></div>
                  <div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
EOT;
  } else {
    header('Location: /');
    exit;
  }
} else {
  // work on billing
  header('Location: /');
  exit;
}
?>





    <style>
    /* Active color sign in button */
    nav ul a.btn {
      background-color: #26a69a !important;
      color: white !important;
    }

    .sidenav .user-view a.btn {
      background-color: #26a69a !important;
      color: white !important;
    }

    /* Footnote */
    #footnote {
      font-size: 12px;
    }

    /* noUiSlider */
#nus {
  margin: 21px 0 24px 4px;
  width: calc(100% - 5px);
}
    </style>


    <!-- Import JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-alpha.4/js/materialize.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAHd7wEeRlgn08q5xC4mifzgVZcKSoplUM&libraries=places"></script>
    <script src="js/materialize.js"></script>
    <script src="js/nouislider.min.js"></script>
    <script>
      var slider = document.getElementById("nus");
      noUiSlider.create(slider, {
        start: [ 1 ],
        connect: true,
        step: 1,
        orientation: "horizontal",
        range: {
          "min": [ 1 ],
          "max": [ 4 ]
        },
        format: wNumb({
          decimals: 0
        })
      });


      // If update button is enabled, call directions service
      document.getElementById("submit").addEventListener("click", function() {
        console.log();
        if (document.getElementById("airport-select").value === "SFO") {

          submit("sfo", slider.noUiSlider.get());


          document.getElementById("footnote").innerHTML = "";
        } else if (document.getElementById("airport-select").value === "OAK") {

          submit("oak", slider.noUiSlider.get());

          document.getElementById("footnote").innerHTML = "";
        } else if (document.getElementById("airport-select").value === "SJC") {

          submit("sjc", slider.noUiSlider.get());

          document.getElementById("footnote").innerHTML = "";
        } else {
          document.getElementById("footnote").innerHTML = "You must specify a location.";
        }
      });

      document.getElementById("airport-select").addEventListener("change", function() {
        document.getElementById("footnote").innerHTML = "";
      });

      var destinations = {
        "sfo": {
          "lat": 37.6213129,
          "long": -122.3789554
        },
        "oak": {
          "lat": 37.7125689,
          "long": -122.2197428
        },
        "sjc": {
          "lat": 37.3639472,
          "long": -121.92893750000002
        }
      };

      function submit(air, pass) {
        console.log(air + " " + pass);

        var lat = 0;
        var lng = 0;

        if (air === "sfo") {
          lat = destinations.sfo.lat;
          lng = destinations.sfo.long;
        } else if (air === "oak") {
          lat = destinations.oak.lat;
          lng = destinations.oak.long;
        } else {
          lat = destinations.sjc.lat;
          lng = destinations.sjc.long;
        }

        $.post("js/ajax/request.php", {
          lat: lat,
          lng: lng,
          pass: pass,
          selector: "initialization"
        }, function(output) {
          if (output === "db-error") {
            location = "/db-error";
            return;
          }

          if (output === "success") {
            location = "/";
            return;
          }
        });
      }
    </script>
  </body>
</html>