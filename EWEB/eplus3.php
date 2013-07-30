<?php

//THIS WILL NOT WORK, EVEN WITH /usr/local/EnergyPlus-7-2-0/bin/ ADDED TO $PATH
//GO BACK TO EPLUS2.PHP

echo shell_exec('./runenergyplus ../../Buildings/minimalIDF2.idf ../../Weather/USA_CA_San.Francisco.Intl.AP.724940_TMY3.epw');

?>

