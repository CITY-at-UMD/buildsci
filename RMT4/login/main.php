<?php
require 'authentication.inc';
session_start();

//is the one accessing this page logged in or not?
if (!isset($_SESSION['db_is_logged_in'])
    || $_SESSION['db_is_logged_in'] != true) {
    // not logged in, move to login page
    header('Location: index.php');
    exit;
} else {
    // logged in, display appropriate information
	// Should use the user's name or id
    $greeting_message= "Hello ".$_SESSION['userID']."!";
}
?>

<html>
<head>
<title>RMT: Login</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>RMT 4</title>
<LINK REL="SHORTCUT ICON" HREF="img/eebhub" />
<link href="../css/ui-lightness/jquery-ui-1.10.3.custom.css" rel="stylesheet">
<link href="../css/bootstrap.min.css" rel="stylesheet">
<link href="../css/demo.css" rel="stylesheet">

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
	background: #111;	
	height: 200px;
	width: 200px;
}

.main-section {
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
	<h1 style="margin: 15px;"> <?php echo $greeting_message;?> </a></h1>
</div>

<div class="main-div">

<div class="main-section">
	<div> 
		<div class="profile-section">
		</div>
		<p><a href="profile.php">Profile</a> </p>
		<p><a href="logout.php">Logout</a> </p>

		<div>
		<p>This is the main application page. You are free to play around here since you
		are an autenthicated user :-) </p>
		</div>
	</div>
</div>
</div>

<footer>
    Copyright &copy; 2013, EEBHUB.
</footer>
</body>
</html>
