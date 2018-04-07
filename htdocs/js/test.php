<?php
// Check if ajax is posting
if (isset($_POST["data"])) {
  // Do some array stuff here
  // echo the encoded output for ajax success function
  echo json_encode($_POST["data"]);
} else {
  echo "hi";
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Let It Fly</title>
  </head>
  <body>
    <input type="button" value="Post JSON" id="postJson">
    <div id="response"></div>

    <script src="https://code.jquery.com/jquery-3.1.0.min.js"></script>
    <script>

      // array to send through ajax
      var activities = ['Location Zero', 'Location One', 'Location Two'];

      $(document).ready(function(){
        $("#postJson").click(function(){
          // just indicates ajax was called
          $("#response").html("<b>Loading response...</b>");

          $.post("test.php", {
            data: { activities }
          }, function(data) {

            // $('#response').html("hi"); // this changes the response text for interfacing
            
            // TODO(brandt): note that the data has both the JSON encoded message from PHP and HTML
            // you need to cut out all the HTML, just leaving the JSON
            // this is because when you run JSON.parse(JSON ENCODED MESSAGE) it will bug out from
            // the html (it only accepts the encode, converting it into an object)
            alert(data);

            //var myObj = JSON.parse();

          });
        });
      });
    </script>
  </body>
</html>