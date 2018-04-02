<!DOCTYPE html>
<html>
<head>
	<title>Let-it-fly Map</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script type="text/javascript" src="js/googlemap.js"></script>
	<style type="text/css">
		.container {
			height: 450px;
		}
		#map {
			width: 100%;
			height: 100%;
			border: 1px solid green;
		}
	    #data, #allAirportData {
			display: none;
		} 
	</style>
</head>
<body>
	<div class="container">
		<center><h1>Let-it-fly Map</h1></center>
		<!-- to get all airport data and pass to JavaScripts-->
		<?php 
			require 'testmap.php';
			$testM = new testmap;
			/* for NULL data for lat and lng */
			$testAir = $testM->getAirportBlankLatLng();
			$testAir = json_encode($testAir, true);
			echo '<div id="data">' . $testAir . '</div>';

			$allAirportData = $testM->getAllAirports();
			$allAirportData = json_encode($allAirportData, true);
			echo '<div id="allAirportData">' . $allAirportData . '</div>';
		?>
		<div id="map"></div>
	</div>
</body>
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBx6WGkrHDWZ9clcT6OJkCyajxDNTAJqK8&callback=initMap">
    </script>
</html>
