<?php
	class testmap {

		private $id;
		private $name;
		private $address;
		private $type;
		private $lat;
		private $lng;
		private $conn;
		private $tableName = "testairport";
		/* data setter & getter */
		function setId($id) { $this->id = $id; }
		function getId() { return $this->id; }
		function setName($name) { $this->name = $name; }
		function getName() { return $this->name; }
		function setAddress($address) { $this->address = $address; }
		function getAddress() { return $this->address; }
		function setType($type) { $this->type = $type; }
		function getType() { return $this->type; }
		function setLat($lat) { $this->lat = $lat; }
		function getLat() { return $this->lat; }
		function setLng($lng) { $this->lng = $lng; }
		function getLng() { return $this->lng; }

		/* connection to database */
		public function __construct() {
			require_once('db/connectDB.php');
			$conn = new connectDB; /* object of connectDB.php */
			$this->conn = $conn->connect();
		}

		/* blank lat and lng for initial airport location */
		public function getAirportBlankLatLng() {
			$sql = "SELECT * FROM $this->tableName WHERE lat IS NULL AND lng IS NULL";
			/* prepared statment */
			$stmt = $this->conn->prepare($sql);
			$stmt->execute();
			return $stmt->fetchALL(PDO::FETCH_ASSOC);
		}

		/* airoorts lat and lng for airpot locations */
		public function getAllAirports() {
			$sql = "SELECT * FROM $this->tableName";
			/* prepared statements */
			$stmt = $this->conn->prepare($sql);
			$stmt->execute();
			return $stmt->fetchALL(PDO::FETCH_ASSOC);
		}

		/* update id, lat, & lng in database */
		public function updateAirportsWithLatLng() {
			$sql = "UPDATE $this->tableName SET lat = :lat, lng = :lng WHERE id = :id";
			/* prepared statements */
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(':lat', $this->lat);
			$stmt->bindParam(':lng', $this->lng);
			$stmt->bindParam(':id', $this->id);

			if($stmt->execute()) {
				return true;
			} else {
				return false;
			}

		}
	}


?>
