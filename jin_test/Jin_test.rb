equire 'openstudio'
require 'VirtualPULSEModel'
=begin
# data = ARGV[i] is depend on newIDF.php: shell_exec()

idf_name = ARGV[0].to_s+'.idf'
num_floors = Integer(ARGV[2])       	# the number of floors in the building
area =  ARGV[1].to_f / num_floors.to_f / 4.0    # area of the building
width = Math.sqrt(area)                 # the width of the building base on the building type
length = Math.sqrt(area)			       	# the length of the building base on the building type
wwr = ARGV[3].to_f / 100.0				# window %


=end

#puts "width: " + width.to_s + " ??"
#puts "length: " + length.to_s + " ??"

idf_name = "jin_test_building.idf" 
location = "USA_CA_San.Francisco.Intl.AP.724940_TMY3"
idf_save_directory = "#{Dir.pwd}/Buildings" 

#create a new model
model = VirtualPULSEModel.new

#add geometry (in this case a simple multi-story core/perimeter building)
model.add_geometry({"length" => 100,
                    "width" => 50,
                    "num_floors" => 2,
                    "floor_to_floor_height" => 4,
                    "plenum_height" => 1,
                    "perimeter_zone_depth" => 3})

#add windows at a given window-to-wall ratio
model.add_windows({"wwr" => 0.5,
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
model.add_design_days({"location" => location})
       
#save the OpenStudio model (.osm)
model.save_openstudio_osm({"osm_save_directory" => Dir.pwd,
                           "osm_name" => "exampleVirtualPULSEModel.osm"})
                           
#translate the OpenStudio model (.osm) to an EnergyPlus model (.idf)
model.translate_to_energyplus_and_save_idf({"idf_save_directory" => idf_save_directory,
                                            "idf_name" => idf_name})

                                       
    #modify the idf file so that we can ask eplus to output monthly data 
	idf_file = File.new("#{idf_save_directory}/#{idf_name}", "a")
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


	idf_file.write("\nOutput:Table:Monthly,
  End Use Energy Consumption Electricity Monthly,   ! Name
  3,                                      ! Digits After Decimal
  InteriorLights:Electricity,             ! Variable or Meter 1 Name
  SumOrAverage,                           ! Aggregation Type for Variable or Meter 1
  InteriorEquipment:Electricity,          ! Variable or Meter 2 Name
  SumOrAverage;                           ! Aggregation Type for Variable or Meter 2
")


	idf_file.close()                                

#run the EnergyPlus model (.idf)
VirtualPULSEModel::run_energyplus_simulation({"idf_directory" => idf_save_directory,
                                              "idf_name" => idf_name, 
                                              "location" => location})
