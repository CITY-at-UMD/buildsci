<?php
	require 'connection.php';
?>
<html>
	<head>
	<script type="text/javascript" src="js/validateForm.js"></script>
    <link rel="stylesheet" type="text/css" href="css/style.css">
        <!--DISQUS COMMENTS-->
        <script type="text/javascript">
            /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
            var disqus_shortname = 'virtualpulse'; // required: replace example with your forum shortname
        
            /* * * DON'T EDIT BELOW THIS LINE * * */ (function() {
                var s = document.createElement('script');
                s.async = true;
                s.type = 'text/javascript';
                s.src = '//' + disqus_shortname + '.disqus.com/count.js';
                (document.getElementsByTagName('HEAD')[0] || document.getElementsByTagName('BODY')[0]).appendChild(s);
            }());
        </script>
    
    
	</head>
	
	<body>
		</br>
		</br>
		<h1 align="center">Retrofit Manager Tool</h1>
		<h3 align="center"><i>simulate building energy ONLINE</i></h3>
		
		<form action="simulate.php" name="bform" method="post" onsubmit="return validateform()">
		<fieldset>
		<legend>USER</legend>
		Email: <input type="text" name="eMail" value="test@psu.edu" /><br/>
		Building (name): <input type="text" name="buildingName" value="TestBuilding" /><br/>
		</fieldset>
		<br/>
		
		<fieldset>
		<legend>LOCATION</legend>
		City, State: 
		<select name="locationID">
		<?php
			$result = mysql_query("SELECT * FROM locations ORDER BY Enabled DESC, City");
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
		Floors: <input type="text" name="floors" value="1"/><br/>
		Area (total floor) [m<sup>2</sup>]: <input type="text" name="floorArea" value="300" /><br/>
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
		% Windows: <input type="text" name="windowPercent" value="40"/><br/>
		</fieldset>
		<br/>
        <br/>
		
		<div align="center">
        <input type="submit" style="width:150px; height:25px;" value="SIMULATE" />
        </div>
        
		</form>
		
		<br/>
		<div id="footer" align="center">
        <br/>
        
        <div id="disqus_thread"></div>
        <!--DISQUS COMMENTS-->
        <script type="text/javascript">
            /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
            var disqus_shortname = 'virtualpulse'; // required: replace example with your forum shortname
        
            /* * * DON'T EDIT BELOW THIS LINE * * */
            (function() {
                var dsq = document.createElement('script');
                dsq.type = 'text/javascript';
                dsq.async = true;
                dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
                (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
            })();
        </script>
        <noscript>Please enable JavaScript to view the
            <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a>
        </noscript>
        <a href="http://disqus.com" class="dsq-brlink">comments powered by <span class="logo-disqus">Disqus</span></a>
        </div>
       	<p align="center">by DOE Energy Efficient Buildings HUB</p>

	</body>
</html>
<?php
	mysql_close($con);
?>
