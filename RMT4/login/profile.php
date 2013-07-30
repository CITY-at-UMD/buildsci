<html>
<head>
<title>RMT: Login</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>RMT 4</title>
<link href="../css/ui-lightness/jquery-ui-1.10.3.custom.css" rel="stylesheet">
<link href="../css/bootstrap.min.css" rel="stylesheet">
<link href="../css/demo.css" rel="stylesheet">
<LINK REL="SHORTCUT ICON" HREF="../img/eebhub" />

<style>
.top {
	color: #eee; 
	position: absolute; 
	height: 80px; 
	width: 100%; 
	background: #999; 
	top: 0; 
	left: 0;
}
.profile-section {
	position: static;
	background: #eee;
    margin: 15% auto;
	padding: 20px;
    border-radius: 0px;
}
footer{
	position: fixed;
}
</style>
</head>

<body>
<div class="top">
	<h1 style="margin: 15px;"> Profile Setting </a></h1>
</div>

<div class="main-div"> 
<div class="profile-section">
<table border="1">
<?php
//include information required to access database
require 'authentication.inc'; 

//start a session 
session_start();

//still logged in?
if (!isset($_SESSION['db_is_logged_in'])
    || $_SESSION['db_is_logged_in'] != true) {
    //not logged in, move to login page
    header('Location: index.php');
    exit;
} else {

    //logged in 
    // Connect database server
    $connect = mysql_connect("$hostName", "$sqlusername", "$sqlpassword")
    or die("ERROR: selecting database server failed");

    // Select database
    mysql_select_db($databaseName, $connect)
	or die( "ERROR: Selecting database failed");

    // Prepare query
    $table = "userprofile";
    $uid = $_SESSION['userID'];
    
    $query = "SELECT * FROM $table where userid = '$uid'";

    // Execute query
    $query_result = mysql_query( $query, $connect)
	or die( "ERROR: Query failed");

    // Output query results: HTML tags

    // Get field names
    echo "<tr>\n"; // Start a new row
    while ($field = mysql_fetch_field($query_result)) { 
	echo "<th>$field->name</th>\n"; // Fill in a cell
    } 
    echo "</tr>\n\n";  // End a row

    // Get data
    while($line = mysql_fetch_row($query_result)){
	echo "<tr>\n"; // A new row
	foreach ($line as $eachline) {
	    echo "<td> $eachline </td> "; // A new cell
	} 
	echo "</tr>\n"; // End a rwo
    }mysql_close ($connect);  
}

?>

</table> 

<p><a href="logout.php">Logout</a> </p>
</div>
</div>
<footer>
    Copyright &copy; 2013, RMT All Rights Reserve.
</footer>
</body>

</html>
