require 'dbi'
require 'sqlite3'
require 'openstudio'
require 'VirtualPULSEModel'

#---------------------------------------- Retrieve Simulation Results ----------------------------------------#
	
	simulation_id = 0 
	electricity_end_uses = Hash.new
	stmt_attributes = ['Heating', 'Cooling', 'Interior Lighting', 'Exterior Lighting', 
		'Interior Equipment', 'Exterior Equipment', 'Fans', 'Pumps']
	
	# path of 'eplusout.sql'
	db_file_path = "./eplusout.sql"

	# connect to SQLite3 database
	db = SQLite3::Database.new(db_file_path)
	
	# electricity end uses #
	stmt_attributes.each do |attribute|
		electricity_end_uses["#{attribute}"] = db.execute("select value
from tabulardatawithstrings
where ReportName like 'AnnualBuildingUtilityPerformanceSummary'
and  TableName like 'End Uses'
and RowName like '#{attribute}'
and ColumnName like 'Electricity';" )[0][0].to_f
# the value returned by db.execute() is a two-dimension array which stores String objects
	end

#	electricity_end_uses.each do |key_pair|
#		puts key_pair
#	end

	 ----------------------------------------------------------------------------------------------------------- #

# --------------------------------------- INSERT RESULTS INTO OUTPUT DATABASE ------------------------------- #
	begin
    # connect to the MySQL server
    dbh = DBI.connect("DBI:Mysql:Output:127.0.0.1", 
	                    "root", "srebric10-11")
	# test connection 
	row = dbh.select_one("SELECT VERSION()")
	puts "Server version of the `Output` database: " + row[0]

	insert_stmt = "INSERT INTO ElectricityEndUses\
(SimulationID, Heating, Cooling, InteriorLighting, ExteriorLighting,\
InteriorEquipment, ExteriorEquipment, Fans, Pumps)\
VALUES (#{simulation_id}, \
#{electricity_end_uses['Heating']}, \
#{electricity_end_uses['Cooling']},
#{electricity_end_uses['Interior Lighting']}, \
#{electricity_end_uses['Exterior Lighting']}, \
#{electricity_end_uses['Interior Equipment']}, \
#{electricity_end_uses['Exterior Equipment']}, \
#{electricity_end_uses['Fans']}, \
#{electricity_end_uses['Pumps']} \
)"
	puts insert_stmt
	#
	dbh.do(insert_stmt)
	puts "Record has been created"
	#dbh.commit

	rescue DBI::DatabaseError => e
    puts "An error occurred"
    puts "Error code:    #{e.err}"
    puts "Error message: #{e.errstr}"
	ensure
    # disconnect from server
    dbh.disconnect if dbh
	end




