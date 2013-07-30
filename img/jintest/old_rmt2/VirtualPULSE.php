<?php
include 'Graph.php';
class VirtualPULSE
{	
	// idf file path  
	private $FilePath = './Buildings/ENERGYPLUS/';
	
	// default version of Ruby
	private $rubyRun = 'ruby1.8';
	
	// DUMMY RUBY SCRIPT FOR GETTING DATA FROM SQL
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
	
///////////////////////////// Print Out Input Data Information ///////////////////////////////

  public function testData() {
		$output = '
		<pre>
				####### Data For Simulation ##############
				idfFile:     '.$this->modelName.'
				area:     '.$this->area.'
				numFloors:     '.$this->numFloors.'
				wwr:     '.$this->wwr.'
				city:     '.$this->city.'
				
				########## Regular Data ##################
				buildingType:     '.$this->buildingType.'
				roof:     '.$this->roof.'
				wall:     '.$this->wall.'
				wwr:     '.$this->wwr.'
				userID:     '.$this->userID.'
				
				
		</pre>
				  ';
		print $output;
	}
    ///////////////////////////// Running Process //////////////////////////	
	
	// Run Energy Simulation
	// Calling the VirtualPULSE_run.rb 
	// Pass 5 Arguments for the simulation
	public function runSimulation() {
		echo '<p>New building input file started. <p/>';
		$rubyCmdCreateIDF = 'xvfb-run -a ruby1.8 VirtualPULSE_run.rb '.
							$this->modelName.' '.							# ARGV[0] = idf_name
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
	public function displayBasicInfo()
	{
	
	}
	
	
	// All Graphic should be called after finished running simulation
	public function displayElectricity() {
	
		$idfFile = $this->modelName.'.idf';
		$sqlFile = 'eplusout.sql';
		$getSql=$this->rubyRun.' '.$this->getDataRuby.' '.
		         $this->FilePath.$idfFile.'/EnergyPlus/'.$sqlFile;
	
		// Test Data for displayPieChart
		$this->electricity["Heating"]=floatval(shell_exec($getSql.' electricityHeating'));
		$this->electricity["Cooling"]=floatval(shell_exec($getSql.' electricityCooling'));                
		$this->electricity["InteriorLighting"]=floatval(shell_exec($getSql.' electricityInteriorLighting'));
		$this->electricity["ExteriorLighting"]=floatval(shell_exec($getSql.' electricityExteriorLighting'));
		$this->electricity["InteriorEquipment"]=floatval(shell_exec($getSql.' electricityInteriorEquipment'));
		$this->electricity["ExteriorEquipment"]=floatval(shell_exec($getSql.' electricityExteriorEquipment'));
		$this->electricity["Fans"]=floatval(shell_exec($getSql.' electricityFans'));
		$this->electricity["Pumps"]=floatval(shell_exec($getSql.' electricityPumps'));
		$this->electricity["HeatRejection"]=floatval(shell_exec($getSql.' electricityHeatRejection'));
		$this->electricity["WaterSystems"]=floatval(shell_exec($getSql.' electricityWaterSystems'));
		$this->electricity["Refrigeration"]=floatval(shell_exec($getSql.' electricityRefrigeration'));

		$graph = new Graph();
		$result = $graph->pieChart($this->electricity,"Electricity");
		
		print $result;
	}
	
	public function displayNaturalGas() {
	
		$idfFile = $this->modelName.'.idf';
		$sqlFile = 'eplusout.sql';
		$getSql=$this->rubyRun.' '.$this->getDataRuby.' '.
		         $this->FilePath.$idfFile.'/EnergyPlus/'.$sqlFile;
	
		//Test Data for displayPieChart
		$this->naturalGas["Heating"]=floatval(shell_exec($getSql.' naturalGasHeating'));
		$this->naturalGas["Cooling"]=floatval(shell_exec($getSql.' naturalGasCooling'));                
		$this->naturalGas["InteriorLighting"]=floatval(shell_exec($getSql.' naturalGasInteriorLighting'));
		$this->naturalGas["ExteriorLighting"]=floatval(shell_exec($getSql.' naturalGasExteriorLighting'));
		$this->naturalGas["InteriorEquipment"]=floatval(shell_exec($getSql.' naturalGasInteriorEquipment'));
		$this->naturalGas["ExteriorEquipment"]=floatval(shell_exec($getSql.' naturalGasExteriorEquipment'));
		$this->naturalGas["Fans"]=floatval(shell_exec($getSql.' naturalGasFans'));
		$this->naturalGas["Pumps"]=floatval(shell_exec($getSql.' naturalGasPumps'));
		$this->naturalGas["HeatRejection"]=floatval(shell_exec($getSql.' naturalGasHeatRejection'));
		$this->naturalGas["WaterSystems"]=floatval(shell_exec($getSql.' naturalGasWaterSystems'));
		$this->naturalGas["Refrigeration"]=floatval(shell_exec($getSql.' naturalGasRefrigeration'));

		$graph = new Graph();
		$result = $graph->pieChart($this->naturalGas,"Natural Gas");
		
		print $result;
		
	}
	
	public function displaySummary() {
		
		$idfFile = $this->modelName.'.idf';
		$sqlFile = 'eplusout.sql';
		$getSql=$this->rubyRun.' '.$this->getDataRuby.' '.
		         $this->FilePath.$idfFile.'/EnergyPlus/'.$sqlFile;
		
		// calling the ruby to get the requested data from sql
		// get data from sql in ruby (still thinking how to optimize this part)
		$totalSiteEnergy=floatval(shell_exec($getSql.' totalSiteEnergy'));
		$totalSourceEnergy=floatval(shell_exec($getSql.' totalSourceEnergy'));
		$naturalGasTotalEndUses=floatval(shell_exec($getSql.' naturalGasTotalEndUses'));
		$electricityTotalEndUses=floatval(shell_exec($getSql.' electricityTotalEndUses'));
		
		// Setting required data for the graph
		$this->totalSiteEnergy=$totalSiteEnergy;
		$this->totalSourceEnergy=$totalSourceEnergy;
		$this->naturalGasTotalEndUses=$naturalGasTotalEndUses;
		$this->electricityTotalEndUses=$electricityTotalEndUses;
		
		// Get Result
		$graph = new Graph();
		$result = $graph->barChart( $this->totalSiteEnergy,
									$this->totalSourceEnergy,
									$this->naturalGasTotalEndUses,
									$this->electricityTotalEndUses);
		
		print $result;
	}
}

?>
