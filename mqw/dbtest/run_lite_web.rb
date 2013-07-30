# modified for E+ 7.2
# sql result location has been changed to: 
#		file_path = "#{Dir.pwd}/ENERGYPLUS/idf/exampleVirtualPULSEModel_trial_#{file_sn}.idf/EnergyPlusPreProcess/EnergyPlus-0/eplusout.sql"
# April 9, 2013

# updated June 12, 2013
# updated June 27, 2013 based on run.rb (June 12, 2013)
# updated July 1, 2013 based on run_lite.rb (June 27, 2013)

#!/usr/bin/ruby -w
 
require 'dbi'
require 'openstudio'
require 'VirtualPULSEModel'
require 'AddIDFTables'
require 'sqlite3'

#---------------------------------------- Read Input Parameters ----------------------------------------#
	

	# ------------ Command-line Parameters ------------- #
	in_username = ARGV.at(0).to_s
	in_email = ARGV.at(1).to_s
	in_building_name = ARGV.at(2).to_s 
	in_city = ARGV.at(3).to_s
	in_state = ARGV.at(4).to_s
	
	in_space_type = ARGV.at(5).to_s # no spaces
	in_num_floors = ARGV.at(6).to_i
	in_total_floor_area = ARGV.at(7).to_f

	in_roof_material_name = ARGV.at(8).to_s
	in_wall_material_name = ARGV.at(9).to_s
	in_wwr = ARGV.at(10).to_f

	in_principle_heating = 'NaturalGas' # no spaces
#-------------------------------------------------------------------------------------------------------#

	length = 20#(Math.sqrt(in_total_floor_area/in_num_floors)).to_f
	#puts length
	width = length
	num_floors = in_num_floors
	floor_to_floor_height = 3
	plenum_height = 1
	perimeter_zone_depth = 3

	wwr = in_wwr
	offset = 1
	application_type = 'Above Floor'
	
	fan_eff = 0.5
	boiler_eff = 0.66
	boiler_fuel_type = in_principle_heating
	coil_cool_rated_high_speed_COP = 5.5
	coil_cool_rated_low_speed_COP = 6.6
	economizer_type = 'Fixed Dry Bulb Temperature Limit'
	economizer_dry_bulb_temp_limit = 30
	economizer_enthalpy_limit = 23

	heating_setpoint = 24
	cooling_setpoint = 28

	_NREL_reference_building_vintage = 'ASHRAE_90.1-2004'
	_Climate_zone = 'ClimateZone 1-8'

	_NREL_reference_building_primary_space_type = in_space_type
	_NREL_reference_building_secondary_space_type = 'WholeBuilding'

#---------------------------------------- Insert Input into Database ---------------------------------------#

	begin
    # connect to the MySQL server
    dbh = DBI.connect("DBI:Mysql:VirtualPULSE:127.0.0.1", 
	                    "root", "srebric10-11")
	# test connection 
	row = dbh.select_one("SELECT VERSION()")
	puts "`VirtualPULSE` database connected. Server version: " + row[0]
# ----------------------------------------
	stmt_insert_submissions = "INSERT INTO Submissions (SubmissionTimeStamp, UserName) \
VALUES (NOW(), '#{in_username}');"
	puts "#{stmt_insert_submissions}" # for debug purpose
	sth = dbh.prepare(stmt_insert_submissions)
    sth.execute
# ----------------------------------------
	submission_id = (dbh.select_one("SELECT Max(SubmissionID) FROM `Submissions`"))[0].to_i 
	puts "\nsubmission_id: #{submission_id}"

	stmt_insert_buildings = "INSERT INTO In_Buildings (SubmissionID, City, State, BuildingName, SpaceType, NumFloors, TotalFloorArea, \
WindowWallRatio, RoofMaterialName, PrincipleHeating, WallMaterialName)\
VALUES (#{submission_id}, '#{in_city}', '#{in_state}', '#{in_building_name}', '#{in_space_type}', #{in_num_floors}, #{in_total_floor_area}, #{in_wwr}, '#{in_roof_material_name}', \
'#{in_principle_heating}', '#{in_wall_material_name}');"
	puts "\n#{stmt_insert_buildings}"
    sth = dbh.prepare(stmt_insert_buildings)
	sth.execute

# ----------------------------------------
	location_weather_filename = (dbh.select_one("SELECT WeatherFileName FROM `Ref_Locations` WHERE City = '#{in_city}' and State = '#{in_state}'"))[0].to_s

# ---------------------------------------- 
    sth.finish
	
	rescue DBI::DatabaseError => e
    puts "An error occurred"
    puts "Error code:    #{e.err}"
    puts "Error message Input stage: #{e.errstr}"
	ensure
    # disconnect from server
    dbh.disconnect if dbh
	end
puts "At line 109 ... #{Time.now()}"
#---------------------------------------- Create Simulation Model and Run ----------------------------------#

	#create a new model
	model = VirtualPULSEModel.new

	#add geometry (in this case a simple multi-story core/perimeter building)
	model.add_geometry({"length" => length,
		            	"width" => width,
		            	"num_floors" => num_floors,
		            	"floor_to_floor_height" => floor_to_floor_height,
		            	"plenum_height" => plenum_height,
		            	"perimeter_zone_depth" => perimeter_zone_depth})
puts "At line 122 ... #{Time.now()}"
	#add windows at a given window-to-wall ratio
	model.add_windows({	"wwr" => wwr,
		          		"offset" => offset,
		          		"application_type" => application_type  #string
						})
		
	#add HVAC - Packaged VAV w/ Reheat - DX Cooling, Hot Water heat and reheat
	model.add_hvac({"fan_eff" => fan_eff,
		      "boiler_eff" => boiler_eff,
		      "boiler_fuel_type" => boiler_fuel_type,		# string
		      "coil_cool_rated_high_speed_COP" => coil_cool_rated_high_speed_COP,
		      "coil_cool_rated_low_speed_COP" => coil_cool_rated_low_speed_COP,
		      "economizer_type" => economizer_type,			# string
		      "economizer_dry_bulb_temp_limit" => economizer_dry_bulb_temp_limit,
		      "economizer_enthalpy_limit" => economizer_enthalpy_limit})
puts "At line 138 ... #{Time.now()}"
	#add thermostats
	model.add_thermostats({"heating_setpoint" => heating_setpoint,
		              "cooling_setpoint" => cooling_setpoint})
		      
	#assign constructions from a local library to the walls/windows/etc. in the model
	model.add_constructions({"construction_library_path" => "#{Dir.pwd}/VirtualPULSE_default_constructions.osm"})

	#add space type from a remote library (BCL) to the model
	model.add_space_type({"NREL_reference_building_vintage" => _NREL_reference_building_vintage,
		            "Climate_zone" => _Climate_zone,
		            "NREL_reference_building_primary_space_type" => _NREL_reference_building_primary_space_type,
		            "NREL_reference_building_secondary_space_type" => _NREL_reference_building_secondary_space_type})  

	#add design days to the model
	model.add_design_days({"loc_filename" => location_weather_filename})

	#save the OpenStudio model (.osm)
	model.save_openstudio_osm({"osm_save_directory" => Dir.pwd,
		                   "osm_name" => "osm/Simulation_#{submission_id}.osm"})
		                   
	#translate the OpenStudio model (.osm) to an EnergyPlus model (.idf)
	model.translate_to_energyplus_and_save_idf({"idf_save_directory" => Dir.pwd,
		                                    "idf_name" => "idf/Simulation_#{submission_id}.idf"})


	#modify the idf file so that we can ask eplus to output monthly data 
	idf_file = File.new("#{Dir.pwd}/idf/Simulation_#{submission_id}.idf", "a")
	add_monthly_electricity(idf_file)
	add_monthly_gasoline(idf_file)	
# solve this on July 2 		
	#add_monthly_naturalgas(idf_file) # not displaying (maybe because the entries in this table are all zeros)
	#add_monthly_diesel(idf_file)	# not displaying (same reason)

	#add_emission_report(idf_file)
	#add_dict(idf_file)
	idf_file.close
puts "At line 175 ... #{Time.now()}"
	#run the EnergyPlus model (.idf)
	VirtualPULSEModel::run_energyplus_simulation({"idf_directory" => Dir.pwd,
		                                      	"idf_name" => "idf/Simulation_#{submission_id}.idf",
												"epw_filename" => location_weather_filename,
												"seq_num" => "#{submission_id}"})
puts "At line 181 ... #{Time.now()}"
#---------------------------------------- Retrieve Simulation Results ----------------------------------------#

	electricity_end_uses = Hash.new
	natural_gas_end_uses = Hash.new
	stmt_attributes = ['Heating', 'Cooling', 'Interior Lighting', 'Exterior Lighting', 
		'Interior Equipment', 'Exterior Equipment', 'Fans', 'Pumps']
	#puts stmt_attributes
# path of 'eplusout.sql'
	db_file_path = "#{Dir.pwd}/ENERGYPLUS/\
idf/Simulation_#{submission_id}.idf/EnergyPlusPreProcess/EnergyPlus-0/eplusout.sql"

	db = SQLite3::Database.new(db_file_path)
	
	# electricity end uses #
	stmt_attributes.each do |attribute|
		electricity_end_uses["#{attribute}"] = db.execute("select value
from tabulardatawithstrings
where ReportName like 'AnnualBuildingUtilityPerformanceSummary'
and  TableName like 'End Uses'
and RowName like '#{attribute}'
and ColumnName like 'Electricity';" )[0][0].to_f

	natural_gas_end_uses["#{attribute}"] = db.execute("select value
from tabulardatawithstrings
where ReportName like 'AnnualBuildingUtilityPerformanceSummary'
and  TableName like 'End Uses'
and RowName like '#{attribute}'
and ColumnName like 'Natural Gas';" )[0][0].to_f
# the value returned by db.execute() is a two-dimension array which stores String objects
	end

#puts natural_gas_end_uses

# total site energy

	total_site_energy = db.execute("select value from TabularDataWithStrings 
where ReportName='AnnualBuildingUtilityPerformanceSummary'
and ReportForString='Entire Facility'
and TableName='Site and Source Energy'
and RowName='Total Site Energy'
and ColumnName='Total Energy'")[0][0].to_f
	puts "total site energy = #{total_site_energy}"

# total source energy
	total_source_energy = db.execute("select value from tabulardatawithstrings
where reportname='AnnualBuildingUtilityPerformanceSummary'
and reportforstring='Entire Facility'
and TableName='Site and Source Energy'
and RowName='Total Source Energy'
and ColumnName='Total Energy'")[0][0].to_f
	puts "total source energy = #{total_source_energy}"

#	electricity_end_uses.each do |key_pair|
#		puts key_pair
#	end


	
# ----------------------------------------------------------------------------------------------------------- #

# --------------------------------------- INSERT RESULTS INTO OUTPUT DATABASE ------------------------------- #
	begin
    # connect to the MySQL server
    dbh = DBI.connect("DBI:Mysql:VirtualPULSE:127.0.0.1", 
	                    "root", "srebric10-11")
	# test connection 
	row = dbh.select_one("SELECT VERSION()")
	puts "Connected to VirtualPULSE database\nServer version: " + row[0]
=begin
	insert_stmt_electricity = "INSERT INTO Out_ElectricityUses\
(SubmissionID, TotalSiteEnergy, TotalSourceEnergy, \
Heating, Cooling, FanPump, ServiceHotWater, \
ExteriorLighting, InteriorLighting,\
Process)\
VALUES (#{submission_id}, 0, 0,\
#{electricity_end_uses['Heating']}, \
#{electricity_end_uses['Cooling']},\
#{electricity_end_uses['Fans']+electricity_end_uses['Pumps']}, 0,\
#{electricity_end_uses['Exterior Lighting']}, \
#{electricity_end_uses['Interior Lighting']}, \
#{electricity_end_uses['Interior Equipment']});"
#	puts insert_stmt_electricity
=end

	insert_stmt_annualtotal = "INSERT INTO Out_AnnualEnergyUses\
(SubmissionID, TotalSiteEnergy, TotalSourceEnergy, \
Heating, Cooling, FanPump, ServiceHotWater, \
ExteriorLighting, InteriorLighting,\
Process)\
VALUES (#{submission_id}, #{total_site_energy}, #{total_source_energy},\
#{natural_gas_end_uses['Heating']},\
#{electricity_end_uses['Cooling']},\
#{electricity_end_uses['Fans']+electricity_end_uses['Pumps']}, 0,\
#{electricity_end_uses['Exterior Lighting']}, \
#{electricity_end_uses['Interior Lighting']}, \
#{electricity_end_uses['Interior Equipment']});"


	#dbh.do(insert_stmt_electricity)
	dbh.do(insert_stmt_annualtotal)

#	puts "Record has been created"
	

	dbh.commit

	rescue DBI::DatabaseError => e
    puts "An error occurred"
    puts "Error code:    #{e.err}"
    puts "Error message: #{e.errstr}"
	ensure
    # disconnect from server
    dbh.disconnect if dbh
	end




