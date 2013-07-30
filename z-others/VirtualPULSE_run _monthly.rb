require 'openstudio'
require 'VirtualPULSEModel'

#create a new model
model = VirtualPULSEModel.new

#add geometry (in this case a simple multi-story core/perimeter building)
model.add_geometry({"length" => 100,
                    "width" => 50,
                    "num_floors" => 3,
                    "floor_to_floor_height" => 4,
                    "plenum_height" => 1,
                    "perimeter_zone_depth" => 3})

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
       
#save the OpenStudio model (.osm)
model.save_openstudio_osm({"osm_save_directory" => Dir.pwd,
                           "osm_name" => "exampleVirtualPULSEModel.osm"})
                           
#translate the OpenStudio model (.osm) to an EnergyPlus model (.idf)
model.translate_to_energyplus_and_save_idf({"idf_save_directory" => Dir.pwd,
                                            "idf_name" => "exampleVirtualPULSEModel.idf"})

#modify the idf file (append monthly data segments)
model.add_monthly_data()  

#run the EnergyPlus model (.idf)
VirtualPULSEModel::run_energyplus_simulation({"idf_directory" => Dir.pwd,
                                              "idf_name" => "exampleVirtualPULSEModel.idf"})
