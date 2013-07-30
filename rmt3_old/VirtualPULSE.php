<?php
include 'Graph.php';
include 'readFile.php';
class VirtualPULSE  {	
	// idf file path  
	private $FilePath = './Buildings/Output/';
	
	// default version of Ruby
	private $rubyRun = 'ruby1.8';
	
	//  RUBY SCRIPT FOR GETTING DATA FROM SQL
	private $getDataRuby = 'get_data.rb';  

	// basic input information	
	private $user='';
	private $userID='';
	private $building='';
	private $modelName='';
	private $city='';
	private $buildingType='';
	private $numFloors='';
	private $roof='';
	private $wall='';
	private $area='';
	private $wwr='';
	
	// output results
	private $electricity=array( "Heating"=>0,
								"Cooling"=>0,
								"InteriorLighting"=>0,
								"ExteriorLighting"=>0,
						        "InteriorEquipment"=>0,
								"ExteriorEquipment"=>0,
								"Fans"=>0,
								"Pumps"=>0,
								"HeatRejection"=>0,
								"WaterSystems"=>0,
								"Refrigeration"=>0);
								
	private $naturalGas=array( "Heating"=>0,
        						"Cooling"=>0,
        						"InteriorLighting"=>0,
        						"ExteriorLighting"=>0,
        						"InteriorEquipment"=>0,
        						"ExteriorEquipment"=>0,
        						"Fans"=>0,
        						"Pumps"=>0,
        						"HeatRejection"=>0,
        						"WaterSystems"=>0,
        						"Refrigeration"=>0);
						
	private $totalSiteEnergy=0;
	private $totalSourceEnergy=0;
	private $naturalGasTotalEndUses=0;
	private $electricityTotalEndUses=0;
	
	// Default constructor
	public function __construct() {}
	
///////////////// Setter Methods //////////////////////////
	public function setUser($user) {
		$this->user=$user;
 	}  

	public function setBuilding($building) {
		$this->building = $building;
	}

	public function setCity($city)	{
		$this->city=$city;
	}

	public function setBuildingType($buildingType) {
		$this->buidlingType=$buildingType;
 	}  

	public function setNumFloors($numFloors) {
		$this->numFloors = $numFloors;
	}

	public function setRoof($roof)	{
		$this->roof=$roof;
	}

	public function setWall($wall) {
		$this->wall=$wall;
 	}  

	public function setArea($area) {
		$this->area = $area;
	}

	public function setWWR($wwr)	{
		$this->wwr=$wwr;
	}
	
	public function setUserID($userID) {
		$this->userID = $userID;
	}
	
	public function setModelName($modelName) {
		$this->modelName = $modelName;
	}
	
    ///////////////////////////// Running Process //////////////////////////	
	
	// Run Energy Simulation
	// Calling the VirtualPULSE_run.rb 
	// Pass 5 Arguments for the simulation
	public function runSimulation() {
		echo '<p>New building input file started. <p/>';
		$rubyCmdCreateIDF = 'xvfb-run -a ruby1.8 VirtualPULSE_run.rb '.
							$this->modelName.' '.						# ARGV[0] = idf_name
							$this->area.' '.							# ARGV[1] = area
							$this->numFloors.' '.	        			# ARGV[2] = num_floors
							$this->wwr.' '.								# ARGV[3] = wwr
							$this->city;                    			# ARGV[4] = city
		echo $rubyCmdCreateIDF;                    
		echo shell_exec($rubyCmdCreateIDF);
		echo "<p>Building Input File: ". $this->modelName. ".idf [created successfully]<p/>";
	}

	///////////////////////////////////////   Output Result   //////////////////////////
	// Display Basic Info of the Building Model
	public function displayBasicInfo() {
	    
	}
	
	
	// All Graphic should be called after finished running simulation
	public function displayElectricity() {
	  
		$htmlFile = $this->modelName.'Table.html';
        $data= readHtml($this->FilePath,$htmlFile,"End Uses",2,7);
		
        $this->electricity["Heating"]=$data['Heating(GJ)'];
		$this->electricity["Cooling"]=$data['Cooling(GJ)'];              
		$this->electricity["InteriorLighting"]=$data['Interior Lighting(GJ)'];
		$this->electricity["ExteriorLighting"]=$data['Exterior Lighting(GJ)'];
		$this->electricity["InteriorEquipment"]=$data['Interior Equipment(GJ)'];
		$this->electricity["ExteriorEquipment"]=$data['Exterior Equipment(GJ)'];
		$this->electricity["Fans"]=$data['Fans(GJ)'];
		$this->electricity["Pumps"]=$data['Pumps(GJ)'];
		$this->electricity["HeatRejection"]=$data['Heat Rejection(GJ)'];
		$this->electricity["WaterSystems"]=$data['Water Systems(GJ)'];
		$this->electricity["Refrigeration"]=$data['Refrigeration(GJ)'];
        $this->electricity["TotalEndUses"]=$data['Total End Uses(GJ)'];
        $this->electricity["Generators"]=$data['Generators(GJ)'];
        $this->electricity["Humidification"]=$data['Humidification(GJ)'];
        $this->electricity["HeatRecovery"]=$data['Heat Recovery(GJ)'];




echo '<table style="width: 45%; height: 45%; float: right;" border="1" cellpadding="4" cellspacing="0">
  <tbody><tr>
    <td></td>
    <td align="center">Electricity [GJ]</td>
    <td></td>
    <td align="center">Electricity [GJ]</td>
    </tr>
  <tr>
    <td align="right">Pumps</td>
    <td align="right"> '.$this->electricity["Pumps"].'</td>
    <td align="right">Heating</td>
    <td align="right">        '.$this->electricity["Heating"].'</td>
    </tr>
  <tr>
    <td align="right">Heat Rejection</td>
    <td align="right"> '.$this->electricity["HeatRejection"].'</td>
    <td align="right">Cooling</td>
    <td align="right">        '.$this->electricity["Cooling"].'</td>
    </tr>
  <tr>
    <td align="right">Humidification</td>
    <td align="right"> '.$this->electricity["Humidification"].'</td>
    <td align="right">Interior Lighting</td>
    <td align="right">       '.$this->electricity["InteriorLighting"].'</td>
    </tr>
  <tr>
    <td align="right">Heat Recovery</td>
    <td align="right"> '.$this->electricity["HeatRecovery"].'</td>
    <td align="right">Exterior Lighting</td>
    <td align="right"> '.$this->electricity["ExteriorLighting"].'</td>
    </tr>
  <tr>
    <td align="right">Water Systems</td>
    <td align="right"> '.$this->electricity["WaterSystems"].'</td>
    <td align="right">Interior Equipment</td>
    <td align="right">        '.$this->electricity["InteriorEquipment"].'</td>
    </tr>
  <tr>
    <td align="right">Refrigeration</td>
    <td align="right"> '.$this->electricity["Refrigeration"].'</td>
    <td align="right">Exterior Equipment</td>
    <td align="right">        '.$this->electricity["ExteriorEquipment"].'</td>
    </tr>
  <tr>
    <td align="right">Generators</td>
    <td align="right"> '.$this->electricity["Generators"].'</td>
    <td align="right">Fans</td>
    <td align="right">        '.$this->electricity["Fans"].'</td>
    </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">Total End Uses</td>
    <td align="right">       '.$this->electricity["TotalEndUses"].'</td>
    </tr>
</tbody></table>';


		$graph = new Graph();
		$result = $graph->pieChart($this->electricity, "Electricity");
		
		echo $result;
	}
	
	public function displayNaturalGas() {
	
		$htmlFile = $this->modelName.'Table.html';
		$data= readHtml($this->FilePath,$htmlFile,"End Uses",3,7);
        
		$this->naturalGas["Heating"]=$data['Heating(GJ)'];
		$this->naturalGas["Cooling"]=$data['Cooling(GJ)'];              
		$this->naturalGas["InteriorLighting"]=$data['Interior Lighting(GJ)'];
		$this->naturalGas["ExteriorLighting"]=$data['Exterior Lighting(GJ)'];
		$this->naturalGas["InteriorEquipment"]=$data['Interior Equipment(GJ)'];
		$this->naturalGas["ExteriorEquipment"]=$data['Exterior Equipment(GJ)'];
		$this->naturalGas["Fans"]=$data['Fans(GJ)'];
		$this->naturalGas["Pumps"]=$data['Pumps(GJ)'];
		$this->naturalGas["HeatRejection"]=$data['Heat Rejection(GJ)'];
		$this->naturalGas["WaterSystems"]=$data['Water Systems(GJ)'];
		$this->naturalGas["Refrigeration"]=$data['Refrigeration(GJ)'];
        $this->naturalGas["TotalEndUses"]=$data['Total End Uses(GJ)'];
        $this->naturalGas["Generators"]=$data['Generators(GJ)'];
        $this->naturalGas["Humidification"]=$data['Humidification(GJ)'];
        $this->naturalGas["HeatRecovery"]=$data['Heat Recovery(GJ)'];


echo '<table style="width: 45%; height: 45%; float: right;" border="1" cellpadding="4" cellspacing="0">
  <tbody><tr>
    <td></td>
    <td align="center">Natural Gas [GJ]</td>
    <td></td>
    <td align="center">Natural Gas [GJ]</td>
    </tr>
  <tr>
    <td align="right">Pumps</td>
    <td align="right"> '.$this->naturalGas["Pumps"].'</td>
    <td align="right">Heating</td>
    <td align="right">        '.$this->naturalGas["Heating"].'</td>
    </tr>
  <tr>
    <td align="right">Heat Rejection</td>
    <td align="right"> '.$this->naturalGas["HeatRejection"].'</td>
    <td align="right">Cooling</td>
    <td align="right">        '.$this->naturalGas["Cooling"].'</td>
    </tr>
  <tr>
    <td align="right">Humidification</td>
    <td align="right"> '.$this->naturalGas["Humidification"].'</td>
    <td align="right">Interior Lighting</td>
    <td align="right">       '.$this->naturalGas["InteriorLighting"].'</td>
    </tr>
  <tr>
    <td align="right">Heat Recovery</td>
    <td align="right"> '.$this->naturalGas["HeatRecovery"].'</td>
    <td align="right">Exterior Lighting</td>
    <td align="right"> '.$this->naturalGas["ExteriorLighting"].'</td>
    </tr>
  <tr>
    <td align="right">Water Systems</td>
    <td align="right"> '.$this->naturalGas["WaterSystems"].'</td>
    <td align="right">Interior Equipment</td>
    <td align="right">        '.$this->naturalGas["InteriorEquipment"].'</td>
    </tr>
  <tr>
    <td align="right">Refrigeration</td>
    <td align="right"> '.$this->naturalGas["Refrigeration"].'</td>
    <td align="right">Exterior Equipment</td>
    <td align="right">        '.$this->naturalGas["ExteriorEquipment"].'</td>
    </tr>
  <tr>
    <td align="right">Generators</td>
    <td align="right"> '.$this->naturalGas["Generators"].'</td>
    <td align="right">Fans</td>
    <td align="right">        '.$this->naturalGas["Fans"].'</td>
    </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">Total End Uses</td>
    <td align="right">       '.$this->naturalGas["TotalEndUses"].'</td>
    </tr>
</tbody></table>';



		$graph = new Graph();
		$result = $graph->pieChart($this->naturalGas, "Natural_Gas");
		
		echo $result;
	}
	
	public function displaySummary() {
		
		$sqlFile = $this->modelName.'.sql';
		$getSql=$this->rubyRun.' '.$this->getDataRuby.' '.
		$this->FilePath.$sqlFile;
		//echo $getSql;
		
		// calling the ruby to get the requested data from sql
		// get data from sql in ruby (This part is possible to be optimized)
		$totalSiteEnergy=floatval(shell_exec($getSql.' totalSiteEnergy'));
		$totalSourceEnergy=floatval(shell_exec($getSql.' totalSourceEnergy'));
		$naturalGasTotalEndUses=floatval(shell_exec($getSql.' naturalGasTotalEndUses'));
		$electricityTotalEndUses=floatval(shell_exec($getSql.' electricityTotalEndUses'));
		
		// Setting required data for the graph
		$this->totalSiteEnergy=$totalSiteEnergy;
		$this->totalSourceEnergy=$totalSourceEnergy;
		$this->naturalGasTotalEndUses=$naturalGasTotalEndUses;
		$this->electricityTotalEndUses=$electricityTotalEndUses;
		
        // create table thing 
        
        
        
		// Get Result
		$graph = new Graph();
		$result = $graph->barChart( $this->totalSiteEnergy,
									$this->totalSourceEnergy,
									$this->naturalGasTotalEndUses,
									$this->electricityTotalEndUses);
		echo $result;
	}
    
    public function displayMonthlyData($selectedZone) {
        $htmlFile = $this->modelName.'Table.html';
        // Test RetrieveMonthlyData
        $data= retriveMonthlyData($this->FilePath, $htmlFile,"title",2,5);
        
        // $data[$key.$zone.$selectColumn]
        //echo '<h1> Monthly Cooling Report: Zone '.$selectedZone.', SYSSENSIBLECOOLINGENERGY[J]</h1><br>';
        
        $month = array('January',
                         'February',
                         'March',
                         'April',
                         'May',
                         'June',
                         'July',
                         'August',
                         'September',
                         'October',
                         'November',
                         'December');
        
        
        // store the data to array
        $zone = $selectedZone;
        for($i=0; $i<12; $i++)
        {  
           $dataSet[$i] = ($data[$month[$i].'Zone'.$zone.'Column2']-0)/1000000000; 
       //    print 'zone: '.$zone.', '.$month[$i].'  >>  '.$data[$month[$i].'Zone'.$zone.'Column3']." [J]<br>";
        }
        
        
        echo '<div style="width: 50%; height: 50; float: right;">
        <h1> Monthly Cooling Load Report (Unit: GJ)</h1>

        <form action="result.php" method="GET">
        <label> ModelName: </label>
        <input tyle="hidden" name="modelName" value='.$_GET['modelName'].' /> </br>
        <label> Query Type: </label>
        <input tyle="hidden" name="queryType" value='.$_GET['queryType'].' /> </br>
        
        <h3> Please select your prefered zone for a single zone review </h3>
        
        <label> zone 0: </label>
        <select name="selected_zone_0" size="1">
            <option value="1"> Zone 1</option>
            <option value="2"> Zone 2</option>
            <option value="3"> Zone 3</option>
            <option value="4"> Zone 4</option>
            <option value="5"> Zone 5</option>
        </select>
        
        <input type="submit" value="Go">
</form></div>';

        $graph = new GRAPH();
        $result=$graph->pieMonthlyChart($dataSet);
        echo $result;
    }
    
    public function displayZoneMonthlyComparision($zone1, $zone2) {
        $htmlFile = $this->modelName.'Table.html';
        
        // Test RetrieveMonthlyData
        $data= retriveMonthlyData($this->FilePath, $htmlFile, "", 2, 5);
                
        $month = array('January',
                         'February',
                         'March',
                         'April',
                         'May',
                         'June',
                         'July',
                         'August',
                         'September',
                         'October',
                         'November',
                         'December');
        
        // store the data to array
        for($i=0; $i<12; $i++)
        {  
           $dataSet1[$i] = ($data[$month[$i].'Zone'.$zone1.'Column2']-0)/1000000000; 
           $dataSet2[$i] = ($data[$month[$i].'Zone'.$zone2.'Column2']-0)/1000000000; 
        }
        
        // selection for comparing different zones  
        echo '<div style="width: 50%; height: 50; float: right;">
        <h1> Monthly Cooling Load Report (Unit: GJ)</h1>
        <form action="result.php" method="GET">
        <label> ModelName: </label>
        <input tyle="hidden" name="modelName" value='.$_GET['modelName'].' /> </br>
        <label> Query Type: </label>
        <input tyle="hidden" name="queryType" value='.$_GET['queryType'].' /> </br>
        
        <h3> Please select your prefered zones for comparision</h3>
        
        <label> zone 1: </label>
        <select name="selected_zone_1" size="1">
            <option value="1"> Zone 1</option>
            <option value="2"> Zone 2</option>
            <option value="3"> Zone 3</option>
            <option value="4"> Zone 4</option>
            <option value="5"> Zone 5</option>
        </select>
        
        
        <label> zone 2: </label>
        <select name="selected_zone_2" size="1">
            <option value="1"> Zone 1</option>
            <option value="2"> Zone 2</option>
            <option value="3"> Zone 3</option>
            <option value="4"> Zone 4</option>
            <option value="5"> Zone 5</option>
        </select>
        <input type="submit" value="Go">
</form></div>';
        
        $graph = new GRAPH();
        $result=$graph->barMonthlyZoneChart($dataSet1, $dataSet2, $zone1, $zone2);
        echo $result;
    }
    
    public function refresh() {
        $graph = new GRAPH();
        echo $graph->refresh;
    }
}


?>
