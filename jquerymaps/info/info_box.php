<?php
	// Include the DB access
	include("..\libs\jqmDB.php");
	
	$map = ""; if (!empty($_REQUEST["map"])) { $map = $_REQUEST["map"]; }			//MAP
	$year = "2010"; if (!empty($_REQUEST["year"])) { $year = $_REQUEST["year"]; }	//YEAR	
	$id = ""; if (!empty($_REQUEST["id"])) { $id = $_REQUEST["id"]; }				//AREA
	$title = "";
	$subtitle = "";
	$total = "";
	$list = "";
	$box = "";
	
	switch($map) {
		case "us":
			// US states
			$title = $year . " Population";
			$subtitle = "Total Population:";
		
			$sql = "SELECT SUM(s.population_" . $year . ") AS total FROM jqm_states s ";
			$query = $jqm_db->query($sql);
			
			if ($query->num_rows > 0) {
				$rd = $query->fetch_assoc();
				$total .= number_format($rd['total'],0);
			}
			$query->close();
	
			$list = "<table class='box_info'>\n";		
			$i = 1;
		
			$sql = "SELECT s.countryID, s.stateID, s.state, s.population_" . $year . " AS total FROM jqm_states s ORDER BY s.population_" . $year . " DESC LIMIT 10 ";
			$query = $jqm_db->query($sql);
			
			if ($query->num_rows > 0)
				while ($rd = $query->fetch_assoc()) {
					$list .= "<tr><td>" . $i . " - <a href='Javascript:jqmRunInfoBoxAction(\"" . $rd['countryID'] . "_" . $rd['stateID'] . "\",\"\",\"\",\"\");' title='Click to zoom in and display information'>" . $rd['state'] . "</a></td>";
					$list .= "<td class='right'>" . number_format($rd['total'],0) . "</td></tr>\n";
					$i++;
				}
			$list .= "</table>";
			$query->close();
			
			$box = "<div class='box span_3 hide'>";
			$box .= "<div class='top'><h3>" . $title . "</h3></div>";
			$box .= "<div class='cnt'>";
			$box .= "<table class='box_info'><tr><td>" . $subtitle . "</td><td class='right'><b>" . $total . "</b></td></tr></table>";
			$box .= $list;
			$box .= "<p class='note'>Source: U.S. Census Bureau</p>";
			$box .= "</div>";
			$box .= "</div>";			
			break;
			
		case "uscounties":
			// US counties by state
			$title = $year . " Population";
			$subtitle = "Total Population:";
			
			if ($id == "")
				$sql = "SELECT SUM(s.population_" . $year . ") AS total FROM jqm_states s ";
			else
				$sql = "SELECT SUM(c.population_" . $year . ") AS total FROM jqm_counties c WHERE c.stateID = '" . substr($id, 3, 2) . "'";
			$query = $jqm_db->query($sql);
			
			if ($query->num_rows > 0) {
				$rd = $query->fetch_assoc();
				$total .= number_format($rd['total'],0);
			}
			$query->close();
	
			$list = "<table class='box_info'>\n";		
			$i = 1;
		
			if ($id == "") 
				$sql = "SELECT CONCAT(s.countryID,'_',s.stateID) AS id, s.state AS label, s.population_" . $year . " AS total FROM jqm_states s ORDER BY s.population_" . $year . " DESC LIMIT 10 ";
			else
				$sql = "SELECT CONCAT(c.countryID,'_',c.stateID,'_',c.countyID) AS id, c.county AS label, c.population_" . $year . " AS total FROM jqm_counties c WHERE c.stateID = '" . substr($id, 3, 2) . "' ORDER BY c.population_" . $year . " DESC LIMIT 10 ";
			$query = $jqm_db->query($sql);
			
			if ($query->num_rows > 0)
				while ($rd = $query->fetch_assoc()) {
					$list .= "<tr><td>" . $i . " - <a href='Javascript:jqmRunInfoBoxAction(\"" . $rd['id'] . "\",\"\",\"\",\"\");' title='Click to zoom in and display information'>" . $rd['label'] . "</a></td>";
					$list .= "<td class='right'>" . number_format($rd['total'],0) . "</td></tr>\n";
					$i++;
				}
			$list .= "</table>";
			$query->close();
			
			$box = "<div class='box span_3 hide'>";
			$box .= "<div class='top'><h3>" . $title . "</h3></div>";
			$box .= "<div class='cnt'>";
			$box .= "<table class='box_info'><tr><td>" . $subtitle . "</td><td class='right'><b>" . $total . "</b></td></tr></table>";
			$box .= $list;
			$box .= "<p class='note'>Source: U.S. Census Bureau</p>";
			$box .= "</div>";
			$box .= "</div>";			
			break;
			
		case "usallcounties":
			// US counties
			if ($year == "population") {
				$title = "2010 Population Density";
				$subtitle = "Avarage Population Density";
			} else {
				$title = "2010 Housing Units Density";
				$subtitle = "Average Housing Units Density";
			}
			
			$sql = "SELECT AVG(density_" . $year . "_2010) AS total FROM jqm_counties ";
			$query = $jqm_db->query($sql);
	
			if ($query->num_rows > 0) {
				$rd = $query->fetch_assoc();
				$total .= number_format($rd['total'],2);
			}
			$query->close();

			$list = "<table class='box_info'>\n";		
			$i = 1;
		
			$sql = "SELECT CONCAT(c.countryID,'_',c.stateID,'_',c.countyID) AS id, CONCAT(c.county,', ',UCASE(c.stateID)) AS label, c.density_" . $year . "_2010 AS total FROM jqm_counties c ORDER BY c.density_" . $year . "_2010 DESC LIMIT 10 ";
			$query = $jqm_db->query($sql);
			
			if ($query->num_rows > 0)
				while ($rd = $query->fetch_assoc()) {
					$list .= "<tr><td>" . $i . " - <a href='Javascript:jqmRunInfoBoxAction(\"" . $rd['id'] . "\",\"\",\"\",\"\");' title='Click to zoom in and display information'>" . $rd['label'] . "</a></td>";
					$list .= "<td class='right'>" . number_format($rd['total'],2) . "</td></tr>\n";
					$i++;
				}
			$list .= "</table>";
			$query->close();

			$box = "<div class='box span_3 hide'>";
			$box .= "<div class='top'><h3>" . $title . "</h3></div>";
			$box .= "<div class='cnt'>";
			$box .= "<table class='box_info'><tr><td>" . $subtitle . "</td><td class='right'><b>" . $total . "</b></td></tr></table>";
			$box .= $list;
			$box .= "<p class='note'>Source: U.S. Census Bureau</p>";
			$box .= "</div>";
			$box .= "</div>";			
			break;
			
		case "world":
			// World
			$list = "<table class='box_world_info'>\n";		

			$sql = "SELECT CONCAT(a.continentID,',',a.countryID) AS id, a.*, c.countryISO, a.lat, a.lon, a.airportID FROM jqm_airports a, jqm_countries c WHERE a.countryID = c.countryID ORDER BY a.passengers_2011 DESC LIMIT 10 ";
			$query = $jqm_db->query($sql);
	
			if ($query->num_rows > 0)
				while ($rd = $query->fetch_assoc()) {
					$list .= "<tr><td><img src='images/flags/" . $rd['countryISO'] . ".png' /></td><td><a href='Javascript:jqmRunInfoBoxAction(\"" . $rd['id'] . "\",\"" . $rd['airportID'] . "\",\"" . $rd['lat'] . "\",\"" . $rd['lon'] . "\");' title='Click to zoom in'>(" . $rd['airportID'] . ") " . $rd['airport'] . "</a></td>";
					$list .= "<td class='right'>" . number_format($rd['passengers_2011'],0) . "</td></tr>\n";
				}
			$list .= "</table>";
			$query->close();
	
			//*** INFO BOX ***
			$box = "<div class='box span_3 hide'>";
			$box .= "<div class='top'><h3>2010 Top Airports by Passenger</h3></div>";
			$box .= "<div class='cnt'>";
			$box .= $list;
			$box .= "</div>";
			$box .= "</div>";	
			break;
	}
	
	$jqm_db->close();
	
	echo $box;
?>