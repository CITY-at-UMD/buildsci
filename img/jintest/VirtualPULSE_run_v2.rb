require 'openstudio'
require 'VirtualPULSEModel'

# number of simulations to run is passed from command-line argument
num_sim = ARGV.at(0).to_i
puts "We will run #{num_sim} times of simulations..."
count = 0

while count < num_sim do

	# open file and read all the parameters

	infile = File.new("params/params_#{count}.txt", "r")
	params = Hash.new

	# parse the text file to get parameters
	infile.each{
	    |i|
	    line = i
	    words = line.split(/ /)
	    puts "#{words[0]}"
	    puts "#{words[1]}"
	    
	    params.store("#{words[0]}", words[1])
	    }

	infile.close()

	# convert strings to float numbers
	length = params['length'].to_f
	width = params['width'].to_f
	num_floors = params['num_floors'].to_f
	floor_to_floor_height = params['floor_to_floor_height'].to_f
	plenum_height = params['plenum_height'].to_f
	perimeter_zone_depth = params['perimeter_zone_depth'].to_f

	#create a new model
	model = VirtualPULSEModel.new

	#add geometry (in this case a simple multi-story core/perimeter building)
	model.add_geometry({"length" => length,
		            "width" => width,
		            "num_floors" => num_floors,
		            "floor_to_floor_height" => floor_to_floor_height,
		            "plenum_height" => plenum_height,
		            "perimeter_zone_depth" => perimeter_zone_depth})

	#add windows at a given window-to-wall ratio
	model.add_windows({"wwr" => 0.4,
		          "offset" => 1,
		          "application_type" => "Above Floor"})
		
	#add HVAC - Packaged VAV w/ Reheat - DX Cooling, Hot Water heat and reheat
	model.add_hvac({"fan_eff" => 0.5,
		      "boiler_eff" => 0.66,
		      "boiler_fuel_type" => "Gasoline",
		      "coil_cool_rated_high_speed_COP" => 5.5,
		      "coil_cool_rated_low_speed_COP" => 6.6,
		      "economizer_type" => "Fixed Dry Bulb Temperature Limit",
		      "economizer_dry_bulb_temp_limit" => 30,
		      "economizer_enthalpy_limit" => 23})

	#add thermostats
	model.add_thermostats({"heating_setpoint" => 24,
		              "cooling_setpoint" => 28})
		      
	#assign constructions from a local library to the walls/windows/etc. in the model
	model.add_constructions({"construction_library_path" => "#{Dir.pwd}/VirtualPULSE_default_constructions.osm"})

	#add space type from a remote library (BCL) to the model
	model.add_space_type({"NREL_reference_building_vintage" => "ASHRAE_90.1-2004",
		            "Climate_zone" => "ClimateZone 1-8",
		            "NREL_reference_building_primary_space_type" => "SmallOffice",
		            "NREL_reference_building_secondary_space_type" => "WholeBuilding"})  

	#add design days to the model
	model.add_design_days()
	       
	postfix = "_trial#{count}"

	#save the OpenStudio model (.osm)
	model.save_openstudio_osm({"osm_save_directory" => Dir.pwd,
		                   "osm_name" => "osm/exampleVirtualPULSEModel#{postfix}.osm"})
		                   
	#translate the OpenStudio model (.osm) to an EnergyPlus model (.idf)
	model.translate_to_energyplus_and_save_idf({"idf_save_directory" => Dir.pwd,
		                                    "idf_name" => "idf/exampleVirtualPULSEModel#{postfix}.idf"})

	#modify the idf file so that we can ask eplus to output monthly data 
	idf_file = File.new("#{Dir.pwd}/idf/exampleVirtualPULSEModel#{postfix}.idf", "a")
	idf_file.write("Output:Table:Monthly,
  Building Monthly Cooling Load Report,   ! Name
  3,                                      ! Digits After Decimal
  Zone/Sys Sensible Cooling Energy,       ! Variable or Meter 1 Name
  SumOrAverage,                           ! Aggregation Type for Variable or Meter 1
  Zone/Sys Sensible Cooling Energy,       ! Variable or Meter 2 Name
  Maximum,                                ! Aggregation Type for Variable or Meter 2
  Outdoor Dry Bulb,                       ! Variable or Meter 3 Name
  ValueWhenMaxMin;
")

	idf_file.write("Output:Table:Monthly,
  End Use Energy Consumption Fuel Gasoline Monthly,   ! Name
  3,                                      ! Digits After Decimal
  Heating:Gasoline,                       ! Variable or Meter 1 Name
  SumOrAverage;                           ! Aggregation Type for Variable or Meter 1
")

	idf_file.write("\nOutput:Table:Monthly,
  End Use Energy Consumption Electricity Monthly,   ! Name
  3,                                      ! Digits After Decimal
  InteriorLights:Electricity,             ! Variable or Meter 1 Name
  SumOrAverage,                           ! Aggregation Type for Variable or Meter 1
  InteriorEquipment:Electricity,          ! Variable or Meter 2 Name
  SumOrAverage,                           ! Aggregation Type for Variable or Meter 2
  Cooling:Electricity,
  SumOrAverage,
  Fans:Electricity,
  SumOrAverage,
  Pumps:Electricity,
  SumOrAverage;
")

=begin
	idf_file.write("\nOutput:Table:Monthly,
  End Use Energy Consumption Electricity Monthly,   ! Name
  3,                                      ! Digits After Decimal
  InteriorLights:Electricity,             ! Variable or Meter 1 Name
  SumOrAverage,                           ! Aggregation Type for Variable or Meter 1
  InteriorEquipment:Electricity,          ! Variable or Meter 2 Name
  SumOrAverage;                           ! Aggregation Type for Variable or Meter 2
")
=end

	idf_file.close()

	#run the EnergyPlus model (.idf)
	VirtualPULSEModel::run_energyplus_simulation({"idf_directory" => Dir.pwd,
		                                      "idf_name" => "idf/exampleVirtualPULSEModel#{postfix}.idf"})

	ObjectSpace.garbage_collect

	count += 1
end 

=begin

=end

