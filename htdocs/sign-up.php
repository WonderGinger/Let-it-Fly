<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-alpha.4/css/materialize.min.css">
    <link rel="stylesheet" href="css/master.css">
    <link rel="stylesheet" href="css/sign-up.css">
  </head>
  <body class="grey lighten-3">
    <nav class="white">
      <div class="container">
        <div class="nav-wrapper">
          <a class="brand-logo" href="/"><i class="material-icons teal-text text-lighten-1">airport_shuttle</i></a>
          <a class="sidenav-trigger" data-target="slide-out" href=""><i class="material-icons teal-text text-lighten-1">menu</i></a>
          <ul class="right hide-on-med-and-down">
            <li class="waves-effect"><a class="teal-text text-lighten-1" href="">Lorem</a></li>
            <li class="waves-effect"><a class="teal-text text-lighten-1" href="">Ipsum</a></li>
            <li><a class="btn waves-effect waves-light" href="">Dolor</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container">
      <div class="valign-table">
        <div class="valign-table-cell">
          <div class="row">
            <div class="col s12 m10 l6 offset-m1 offset-l6">
              <div class="card">
                <div class="card-content">
                  <span class="card-title teal-text text-lighten-1">Begin Your Journey</span>
                  <p><?php echo nl2br(file_get_contents("lipsum.txt")); ?></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-alpha.4/js/materialize.min.js"></script>
    <script>
      var elem = document.querySelector(".sidenav");
      var instance = M.Sidenav.init(elem, { draggable: false });
    </script>
  </body>
</html>