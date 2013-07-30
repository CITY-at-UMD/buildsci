<html>
<head>
<title>User Profile</title>
</head>

<body bgcolor="white">

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
    header('Location: login.php');
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
</body>

</html>
