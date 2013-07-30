<?php
	$username="root";
	$password="srebric10-11";
	$database="hackathon";
	$localhost="localhost";
	
	$con = mysql_connect($localhost,$username,$password);
	if(!$con)
	{
		die('could not connect: ' . mysql_error());
	}

	mysql_select_db($database, $con);
?>
