<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>rmt: result page</title>
<?php 
    include 'sql_functions.php';
?>
</head>

<body>
<div style="border: thick orange solid; width: 250px; position: relative; left:0;">
	<form action="rmt_result.php" method="get">
     <input type="text" style="border: none; color: grey" name="search"  size="29" height="50" value="search model ..."> </input>
     <input type="submit" value="Go" />
     </form>
</div>

<?php
     display_results($_GET['search']);
?>

<h1>&nbsp;</h1>
<p>&nbsp; </p>
<p>&nbsp;</p>
</body>
</html>
