<?php
	// Include the DB access
	include("..\libs\jqmDB.php");
	
	$map = ""; if (!empty($_REQUEST["map"])) { $map = $_REQUEST["map"]; }
	$level = "1"; if (!empty($_REQUEST["level"])) { $level = $_REQUEST["level"]; }
	$legend = "";
	
	switch($map) {
		case "us":
			// US states
			$legend = "<div class=\"legend_label\">Population (millions):</div> ";

			$sql = "SELECT r.rangeID, r.range, r.range_color FROM maps_ranges r WHERE r.mapID = 'us' AND r.levelID = " . $level . " ORDER BY r.rangeID ";
			$query = $jqm_db->query($sql);
			
			if ($query->num_rows > 0)
				while ($rd = $query->fetch_assoc())
					$legend .= "<div class=\"legend_box\" style=\"background: " . $rd['range_color'] . "\" ></div><div class=\"legend_label\">" . $rd['range'] . "</div>";
			$query->close();
			break;

		case "uscounties":
			// US counties by state
			if ($level == "1")
				$legend = "<div class=\"legend_label\">Population (millions): </div>";
			else
				$legend = "<div class=\"legend_label\">Population (thousands): </div>";

			$sql = "SELECT r.rangeID, r.range, r.range_color FROM maps_ranges r WHERE r.mapID = 'uscounties' AND r.levelID = " . $level . " ORDER BY r.rangeID ";
			$query = $jqm_db->query($sql);
			
			if ($query->num_rows > 0)
				while ($rd = $query->fetch_assoc())
					$legend .= "<div class=\"legend_box\" style=\"background: " . $rd['range_color'] . "\" ></div><div class=\"legend_label\">" . $rd['range'] . "</div>";
			$query->close();
			break;

		case "usallcounties":
			// US counties
			$legend = "<div class=\"legend_label\">Population Density: </div>";

			$sql = "SELECT r.rangeID, r.range, r.range_color FROM maps_ranges r WHERE r.mapID = 'usallcounties' AND r.levelID = " . $level . " ORDER BY r.rangeID ";
			$query = $jqm_db->query($sql);
			
			if ($query->num_rows > 0)
				while ($rd = $query->fetch_assoc()) 
					$legend .= "<div class=\"legend_box\" style=\"background: " . $rd['range_color'] . "\" ></div><div class=\"legend_label\">" . $rd['range'] . "</div>";
			$query->close();
			break;
			
		case "world":
			// World
			$legend = "<div class=\"box_label\"><img src='jquerymaps/images/icons/airport_main.png' /></div><div class=\"box_label\">Top Airport</div>";
			$legend .= "<div class=\"box_label\"><img src='jquerymaps/images/icons/airport.png' /></div><div class=\"box_label\">Airport</div>";
			break;
	}
	
	$jqm_db->close();
		
	echo $legend;
?>