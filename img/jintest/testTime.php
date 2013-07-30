<?php

$time_start = microtime(true); //place this before any script you want to calculate time
//sample script
for($i=0; $i<100000; $i++){
 //do anything
}

$time_end = microtime(true);
$execution_time = ($time_end - $time_start)/60; //dividing with 60 will give the execution time in minutes other wise seconds
echo '<b>Total Execution Time:</b> '.$execution_time.' Mins'; //execution time of the script
?>