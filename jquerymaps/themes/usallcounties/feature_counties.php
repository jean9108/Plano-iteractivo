<?php
	header("Content-Type: application/xml; charset=utf-8");
	echo "<jqm_features xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:noNamespaceSchemaLocation=\"../../xsd/jqm_features.xsd\">\n";
	
	include("..\..\libs\jqmDB.php");

	$year = "population"; if (!empty($_REQUEST["year"])) { $year = $_REQUEST["year"]; }		//PARAMETER
	$ranges = array();
	
	$sql = "SELECT r.rangeID, r.range_min, r.range_max FROM maps_ranges r WHERE r.mapID = 'usallcounties' AND r.levelID = 1 ORDER BY r.rangeID ";
	$query = $jqm_db->query($sql);
	
	if ($query->num_rows > 0)
		while ($rd = $query->fetch_assoc()) 
			array_push($ranges, array("id" => $rd['rangeID'], "min" => $rd['range_min'], "max" => $rd['range_max']));
	$query->close();

	//****************
	//*** COUNTIES ***	
	//****************
	$sql = "SELECT c.countryID, c.stateID, c.countyID, c.county, c.density_" . $year . "_2010 AS total ";
	$sql .= "FROM jqm_counties c ORDER BY c.countyID";
	$query = $jqm_db->query($sql);

	if ($query->num_rows > 0)
		while ($rd = $query->fetch_assoc()) {

			$category = "";
			for ($i = 0; $i < count($ranges); $i++) {
				if (($rd['total'] >= $ranges[$i]["min"]) && ($rd['total'] < $ranges[$i]["max"])) {
					$category = $ranges[$i]["id"];
				} elseif ($rd['total'] >= $ranges[$i]["min"] && $ranges[$i]["min"] > 0 && $ranges[$i]["max"] == 0) {
					$category = $ranges[$i]["id"];					
				}
			}
			
			$popup = "";
			if ($y == "population")
				$popup = "2010 Population Density: " . number_format($rd['total'], 2);
			else
				$popup = "2010 Housing Units Density: " . number_format($rd['total'], 2);

			echo "<feature id=\"" . strtolower($rd['countryID'] . "_" . $rd['stateID'] . "_" . $rd['countyID']) . "\" category=\"county_" . $category . "\" label=\"" .  htmlspecialchars($rd['county']) . "\" popup=\"" . htmlentities($popup) . "\" y=\"" . $year . "\" />\n";
		}
	$query->close();

	$sql = "SELECT s.countryID, s.stateID FROM jqm_states s ORDER BY s.stateID";
	$query = $jqm_db->query($sql);

	if ($query->num_rows > 0)
		while ($rd = $query->fetch_assoc())
			echo "<feature id=\"" . strtolower($rd['countryID'] . "_" . $rd['stateID']) . "\" category=\"state\" label=\"\" />\n";
	$query->close();
	$jqm_db->close();

	echo "</jqm_features>";
?>