<p>The apache user is: </p>
<?php
	passthru("whoami");
	echo ('<br /><br />');
	echo shell_exec("xvfb-run ruby1.8 bclsetup.rb");
?>
