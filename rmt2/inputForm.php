<?php
	require 'connection.php';
?>
<html>
	<head>
	<script type="text/javascript" src="validateForm.js"></script>

	</head>
	
	<body>
		</br>
		</br>
		<h1>RMT 2</h1>
		<h3><i>simulate building energy ONLINE</i></h3>
		
		<form action="simulate.php" name="bform" method="post" onsubmit="return validateform()">
		<fieldset>
		<legend>USER</legend>
		Email: <input type="text" name="eMail" /><br/>
		Building (name): <input type="text" name="buildingName" /><br/>
		</fieldset>
		<br/>
		
		<fieldset>
		<legend>LOCATION</legend>
		City, State: 
		<select name="locationID">
		<?php
			$result = mysql_query("SELECT * FROM locations ORDER BY Enabled DESC, State, City");
			while($row = mysql_fetch_array($result))
			{
				if ($row['Enabled'] == 1)
				{
					echo "\t<option value=" . $row['locationID'] . ">" . $row['city'] . ", " . $row['state'] . "</option>\n";
				}
				else
				{
					echo "\t<option value=" . $row['locationID'] . " disabled=\"disabled\">" . $row['city'] . ", " . $row['state'].  " - Unavailable"  . "</option>\n";
				}
			}
		?>
		</select><br/>
		</fieldset>
		<br/>
		
		<fieldset>
		<legend>FUNCTION &amp SIZE</legend>
		Type:
		<select name="functionID">
		<?php
			$result = mysql_query("SELECT * FROM functions ORDER BY Enabled DESC, functionType");
			while($row = mysql_fetch_array($result))
			{
				if ($row['Enabled'] == 1)
				{
					echo "\t<option value=" . $row['functionID'] . ">" . $row['functionType'] . "</option>\n";
				}
				else
				{
					echo "\t<option value=" . $row['functionID'] . " disabled=\"disabled\">" . $row['functionType'] . " - Unavailable" . "</option>\n";
				}
			}
		?>
		</select><br/>
		Floors: <input type="text" name="floors" /><br/>
		Area (total floor) [m<sup>2</sup>]: <input type="text" name="floorArea" /><br/>
		</fieldset>
		<br/>
		
		<fieldset>
		<legend>MATERIALS</legend>
		Roof:
		<select name="roofMaterial">
		<?php
			$result = mysql_query("SELECT * FROM roofmaterials ORDER BY Enabled DESC, name");
			while($row = mysql_fetch_array($result))
			{
				if ($row['Enabled'] == 1)
				{
					echo "\t<option value=" . $row['roofMatID'] . ">" . $row['name'] . "</option>\n";
				}
				else
				{
					echo "\t<option value=" . $row['roofMatID'] . " disabled=\"disabled\">" . $row['name'] . " - Unavailable" . "</option>\n";
				}
			}
		?>
		</select><br/>
		Wall:
		<select name="wallMaterial">
		<?php
			$result = mysql_query("SELECT * FROM wallmaterials ORDER BY Enabled DESC, name");
			while($row = mysql_fetch_array($result))
			{
				if ($row['Enabled'] == 1)
				{
					echo "\t<option value=" . $row['wallMatID'] . ">" . $row['name'] . "</option>\n";
				}
				else
				{
					echo "\t<option value=" . $row['wallMatID'] . " disabled=\"disabled\">" . $row['name'] . " - Unavailable" . "</option>\n";
				}
			}
		?>
		</select><br/>
		% Windows: <input type="text" name="windowPercent" /><br/>
		</fieldset>
		<br/>
		
		<input type="submit" value="SIMULATE" />
		</form>
		
		<br/>
		<div id="footer" align="center">
<!--    		<p>Designed & Developed by <a href="http://www.joshwentz.net/">Josh Wentz</a>, Jeff Chen, Jin Bin Li, Mohammad Heidarinejad, Dr. Jelena Srebric</p>
            <p><a href="http://www.buildsci.us/people.html">building science GROUP</a> is based in the Architectural Engineering Department of Penn State University</p>
	-->	</div>
	</body>
</html>
<?php
	mysql_close($con);
?>
