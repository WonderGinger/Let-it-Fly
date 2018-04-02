<?php
	/* update database on lat, lng, & id */
	require 'testmap.php';
		$testM = new testmap;
		$testM->setLat($_REQUEST['lat']);
		$testM->setLng($_REQUEST['lng']);
		$testM->setId($_REQUEST['id']);
		$status = $testM->updateAirportsWithLatLng();
		if($status == true) {
			echo "Updated...";
		} else {
			echo "Failed...";
		}
?>
