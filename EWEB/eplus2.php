
<?php
// ini_set('max_execution_time', 120); //120 seconds = 2 minutes

chdir ('/usr/local/EnergyPlus-7-2-0/bin/');
echo '<pre>';
echo passthru('dir');
//$output = shell_exec('./runenergyplus ../../Buildings/minimalIDF2.idf http://tools.eebhub.org/weather/USA_CA_San.Francisco.Intl.AP.724940_TMY3.epw');

$output = shell_exec('./runenergyplus ../../Buildings/minimalIDF2.idf ../../Weather/USA_CA_San.Francisco.Intl.AP.724940_TMY3.epw');

echo $output.'</pre>';

?>

