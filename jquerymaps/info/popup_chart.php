<?php
	header("Content-type: text/json");
	// Include the DB access
	include("..\libs\jqmDB.php");
	
	$map = ""; if (!empty($_REQUEST["map"])) { $map = $_REQUEST["map"]; }
	$id = ""; if (!empty($_REQUEST["id"])) { $id = $_REQUEST["id"]; }
	$year = ""; if (!empty($_REQUEST["year"])) { $year = $_REQUEST["year"]; }
	$chart = array();
	$popup = "";
	
	switch($map) {
		case "us":
			// US states
			$sql = "SELECT * FROM jqm_states WHERE stateID = '" . substr($id, 3, 2) . "' ";
			$query = $jqm_db->query($sql);
			
			if ($query->num_rows > 0) {
				$rd = $query->fetch_assoc();
				array_push($chart, array("name" => "1970", "y" => $rd["population_1970"], "color" => "#4DA1BD", "label" => number_format($rd['population_1970'])));
				array_push($chart, array("name" => "1980", "y" => $rd["population_1980"], "color" => "#4DA1BD", "label" => number_format($rd['population_1980'])));
				array_push($chart, array("name" => "1990", "y" => $rd["population_1990"], "color" => "#4DA1BD", "label" => number_format($rd['population_1990'])));
				array_push($chart, array("name" => "2000", "y" => $rd["population_2000"], "color" => "#4DA1BD", "label" => number_format($rd['population_2000'])));
				array_push($chart, array("name" => "2010", "y" => $rd["population_2010"], "color" => "#4DA1BD", "label" => number_format($rd['population_2010'])));
				
				for ($i = 0; $i < count($chart); $i++)
					if ($chart[$i]["name"] == $year)
						$chart[$i]["color"] = "#DD3F24";
			}
			$query->close();
			
			echo json_encode($chart);
			break;

		case "uscounties":
			// US counties by state
			$sql = "SELECT * FROM jqm_counties WHERE countyID = '" . substr($id, 6, 5) . "' ";
			$query = $jqm_db->query($sql);
				
			if ($query->num_rows > 0) {
				$rd = $query->fetch_assoc();
				array_push($chart, array("name" => "1970", "y" => $rd["population_1970"], "color" => "#4DA1BD", "label" => number_format($rd['population_1970'])));
				array_push($chart, array("name" => "1980", "y" => $rd["population_1980"], "color" => "#4DA1BD", "label" => number_format($rd['population_1980'])));
				array_push($chart, array("name" => "1990", "y" => $rd["population_1990"], "color" => "#4DA1BD", "label" => number_format($rd['population_1990'])));
				array_push($chart, array("name" => "2000", "y" => $rd["population_2000"], "color" => "#4DA1BD", "label" => number_format($rd['population_2000'])));
				array_push($chart, array("name" => "2010", "y" => $rd["population_2010"], "color" => "#4DA1BD", "label" => number_format($rd['population_2010'])));
				
				for ($i = 0; $i < count($chart); $i++)
					if ($chart[$i]["name"] == $year)
						$chart[$i]["color"] = "#DD3F24";
			}
			$query->close();
			
			echo json_encode($chart);
			break;
			
		case "usallcounties":
			// US counties
			$sql = "SELECT * FROM jqm_counties WHERE countyID = '" . substr($id, 6, 5) . "' ";
			$query = $jqm_db->query($sql);
	
			if ($query->num_rows > 0) {
				$rd = $query->fetch_assoc();
		
				$popup .= "2010 Population: " . number_format($rd['population_2010'],0) . "<br />";
				$popup .= "Population Density: " . number_format($rd['density_population_2010'],2) . "<br /><br>";
				$popup .= "2010 Housing Units: " . number_format($rd['housing_units_2010'],0) . "<br />";
				$popup .= "Housing Units Density: " . number_format($rd['density_housing_units_2010'],2) . "<br />";
			}
			$query->close();
			
			echo json_encode($popup);
			break;
	}
	$jqm_db->close();
?>