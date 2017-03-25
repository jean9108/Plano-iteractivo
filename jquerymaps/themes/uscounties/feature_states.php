<?php
	header("Content-Type: application/xml; charset=utf-8");
	echo "<jqm_features xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:noNamespaceSchemaLocation=\"../../xsd/jqm_features.xsd\">\n";
	
	include("..\..\libs\jqmDB.php");

	$year = ""; if (!empty($_REQUEST["year"])) { $year = $_REQUEST["year"]; }	//POPULATION YEAR
	$ranges = array();
	
	$sql = "SELECT r.rangeID, r.range_min, r.range_max FROM maps_ranges r WHERE r.mapID = 'uscounties' AND r.levelID = 1 ORDER BY r.rangeID ";
	$query = $jqm_db->query($sql);
	
	if ($query->num_rows > 0)
		while ($rd = $query->fetch_assoc())
			array_push($ranges, array("id" => $rd['rangeID'], "min" => $rd['range_min'], "max" => $rd['range_max']));
	$query->close();

	//**************
	//*** STATES ***	
	//**************
	$sql = "SELECT s.countryID, s.stateID, s.state, s.population_" . $year . " AS total ";
	$sql .= "FROM jqm_states s ORDER BY s.stateID";
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

			echo "<feature id=\"" . strtolower($rd['countryID'] . "_" . $rd['stateID']) . "\" category=\"state_" . $category . "\" label=\"" . $rd['state'] . "\" label_map=\"" . strtoupper($rd['stateID']) . "\" popup=\"" . $year . " Population: " . number_format($rd['total'], 0) . "\" y=\"" . $year . "\" map=\"uscounties\" />\n";
		}
	$query->close();
	$jqm_db->close();

	echo "</jqm_features>";
?>