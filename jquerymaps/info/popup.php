<?php
	// Include the DB access
	include("..\libs\jqmDB.php");
	
	$map = ""; if (!empty($_REQUEST["map"])) { $map = $_REQUEST["map"]; }
	$id = ""; if (!empty($_REQUEST["id"])) { $id = $_REQUEST["id"]; }
	$popup = "";
	
	switch($map) {
		case "us":
			// US states
			$sql = "SELECT * FROM jqm_cities WHERE cityID = " . $id;
			$query = $jqm_db->query($sql);
			
			if ($query->num_rows > 0) {
				$rd = $query->fetch_assoc();
				$popup = "<b>" . $rd['city'] . "</b><br />Population: " . number_format($rd['population'],0);
			}
			$query->close();
			break;
			
		case "uscounties":
			// US counties by state
			$sql = "SELECT * FROM jqm_cities WHERE cityID = " . $id;
			$query = $jqm_db->query($sql);
			
			if ($query->num_rows > 0) {
				$rd = $query->fetch_assoc();
				$popup = "<b>" . $rd['city'] . "</b><br />Population: " . number_format($rd['population'],0);
			}
			$query->close();
			break;

		case "world":
			// World
			$sql = "SELECT a.*, c.country, c.countryISO FROM jqm_airports a, jqm_countries c WHERE a.countryID = c.countryID AND a.airportID = '" . $id . "'";
			$query = $jqm_db->query($sql);
	
			if ($query->num_rows > 0) {
				while ($rd = $query->fetch_assoc()) {
		
					$popup = "<b>" . $rd['airport'] . " (" . $rd['airportID'] . ")</b><br />";
					$popup .= $rd['city'] . "<br />";
					$popup .= "<div class='flag'><img src='images/flags/" . $rd['countryISO'] . ".png' /></div>" . $rd['country'];
					$popup .= "<br /><br />";
				
					if ($rd['passengers_2011'] != "")  { 
						$popup .= "<b>Passengers</b><br />";
						$popup .= "2011: " . number_format($rd['passengers_2011'], 0) . " (" . number_format(((($rd['passengers_2011']*100)/$rd['passengers_2010'])-100),2) . "%)<br />"; 
						$popup .= "2010: " . number_format($rd['passengers_2010'], 0) . "<br />";
					}
				}
			}
			$query->close();
			break;
	}
	
	$jqm_db->close();
		
	echo $popup;
?>