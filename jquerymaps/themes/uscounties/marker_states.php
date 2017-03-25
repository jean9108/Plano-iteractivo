<?php
	header("Content-Type: application/xml; charset=utf-8");
	echo "<jqm_markers xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:noNamespaceSchemaLocation=\"../../xsd/jqm_markers.xsd\">\n";
	
	include("..\..\libs\jqmDB.php");

	$ranges = array();
	
	$sql = "SELECT r.rangeID, r.range_min, r.range_max FROM maps_ranges_cities r WHERE r.mapID = 'uscounties' ORDER BY r.rangeID ";
	$query = $jqm_db->query($sql);
	
	if ($query->num_rows > 0)
		while ($rd = $query->fetch_assoc())
			array_push($ranges, array("id" => $rd['rangeID'], "min" => $rd['range_min'], "max" => $rd['range_max']));
	$query->close();

	//**************
	//*** CITIES ***	
	//**************
	$sql = "SELECT c.cityID, c.city, c.lat, c.lon, c.population AS total FROM jqm_cities c WHERE c.lat <> 0 AND c.lon <> 0 AND c.population > 600000 ORDER BY c.population DESC";
	$query = $jqm_db->query($sql);

	if ($query->num_rows > 0)
		while ($rd = $query->fetch_assoc()) {
			
			$category = "";
			for ($i = 0; $i < count($ranges); $i++) {
				if (floatval($rd['total']) == 0 && $ranges[$i]["min"] == 0 && $ranges[$i]["max"] == 0) {
					$category = $ranges[$i]["id"];
				} elseif (($rd['total'] > $ranges[$i]["min"]) && ($rd['total'] <= $ranges[$i]["max"])) {
					$category = $ranges[$i]["id"];
				} elseif ($rd['total'] > $ranges[$i]["min"] && $ranges[$i]["min"] > 0 && $ranges[$i]["max"] == 0) {
					$category = $ranges[$i]["id"];					
				}
			}

			echo "<marker id=\"" . $rd['cityID'] . "\" category=\"city_" . $category . "\" label=\"" . htmlentities($rd['city']) . "\" lat=\"" . $rd['lat'] . "\" lon=\"" . $rd['lon'] . "\" popup=\"Population: " . number_format($rd['total'], 0) . "\" />\n";
		}
	$query->close();
	$jqm_db->close();

	echo "</jqm_markers>";
?>