require 'openstudio'
require 'VirtualPULSEModel'

# data = ARGV[i] is depend on newIDF.php: shell_exec()
idf_name = ARGV[0].to_s+'.idf'
area =  Integer(ARGV[1])       		# area of the building
width = Math.sqrt(area)           # the width of the building base on the building type
length = area / width			       	# the length of the building base on the building type
num_floors = Integer(ARGV[2])   		# the number of floors in the building
wwr = Float(ARGV[3]) / 100				  # window %
idf_save_directory = "#{Dir.pwd}/Buildings" 
location = ARGV[4].to_s

# Test the inputs
puts "<br>####### idf_name: "
puts idf_name
puts "<br>####### area: "
puts area
puts "<br>####### num_floors: "
puts num_floors
puts "<br>####### wwr: "
puts wwr
puts "<br>####### location: "
puts location
puts "<br>"

#create a new model
model = VirtualPULSEModel.new

#add geometry (in this case a simple multi-story core/perimeter building)
model.add_geometry({"length" => length,
                    "width" => width,
                    "num_floors" => num_floors,
                    "floor_to_floor_height" => 4,
                    "plenum_height" => 1,
                    "perimeter_zone_depth" => 3})

#add windows at a given window-to-wall ratio
model.add_windows({"wwr" => wwr,
                  "offset" => 1,
                  "application_type" => "Above Floor"})
        
#add HVAC - Packaged VAV w/ Reheat - DX Cooling, Hot Water heat and reheat
model.add_hvac({"fan_eff" => 0.5,
              "boiler_eff" => 0.66,
              "boiler_fuel_type" => "NaturalGas",
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
  
#run the EnergyPlus model (.idf)
VirtualPULSEModel::run_energyplus_simulation({"idf_directory" => idf_save_directory,
                                              "idf_name" => idf_name, 
                                              "location" => location})
