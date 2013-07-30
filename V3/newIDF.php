<?php
   echo '<p>New building input file started. <p/>';
   $IDFfile = $building . $userID;
   $rubyCmdCreateIDF = 'xvfb-run -a ruby1.8 VirtualPULSE_run.rb '.
      $IDFfile.' '.				# ARGV[0] = idf_name
      $_POST[floorArea].' '.			# ARGV[1] = area
      $_POST[floors].' '.	                # ARGV[2] = num_floors
      $_POST[windowPercent].' '.		# ARGV[3] = wwr
      $city;                                    # ARGV[4] = location
   echo $rubyCmdCreateIDF;                    
   echo shell_exec($rubyCmdCreateIDF);
	
   echo "<p>Building Input File: ". $IDFfile. ".idf [created successfully]<p/>";
?>
