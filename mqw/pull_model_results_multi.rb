# Auther: Andrew
# Modified by: Mujing Wang
# Date: Jan. 26th, 2013

require 'openstudio'

num_sim = ARGV.at(0).to_i
file_array = Array.new(num_sim)

puts "We will pull results of #{num_sim} simulations..."

num_file=0

while num_file<num_sim do
	#file_array is an array consists of File objects
    file_array[num_file] = File.new("#{Dir.pwd}/sql_results/sql_result_#{num_file}.txt", "w")	# initialize elements in file array
    num_file += 1
	puts "#{num_file}"
end

#TODO - unit conversions
puts "***UNIT CONVERSIONS NOT YET IMPLEMENTED, ALL RESULTS IN GIGAJOULE***"

#create an array to hold the paths to all the files
file_path = Array.new(num_sim)

num_path=0

while num_path<num_sim do
	file_path[num_path] = "#{Dir.pwd}/ENERGYPLUS/idf/exampleVirtualPULSEModel_trial#{num_path}.idf/EnergyPlus/eplusout.sql"
	num_path += 1
end

i = 0

while i<num_sim do
	puts "starting #{file_path[i]}"

	#Open the sql file
	  sql_path = OpenStudio::Path.new(file_path[i])
	#if the sql file exists, load it into the variable sql
	if OpenStudio::exists(sql_path)
	  sql = OpenStudio::SqlFile.new(sql_path)
	else 
	  puts  "ERROR - #{file_path} couldn't be found; continuing to next file"
	  exit #exit the script
	end

#Create a table object to store the monthly data
table = sql.monthlyEndUsesTable.get
puts table.print(OpenStudio::TableFormat.new())

#summary data
=begin
puts "total site energy: "
puts sql.totalSiteEnergy.get
puts "total source energy: "
puts sql.totalSourceEnergy.get
puts "natural gas total end uses: "
puts sql.naturalGasTotalEndUses.get
puts "electricity total end uses: "
puts sql.electricityTotalEndUses.get  
=end

	file_array[i].write("total_site_energy #{sql.totalSiteEnergy.get}\n")
	file_array[i].write("total_source_energy #{sql.totalSourceEnergy.get}\n")
	file_array[i].write("natural_gas_total_end_uses #{sql.naturalGasTotalEndUses.get}\n")
	file_array[i].write("electricity_total_end_uses #{sql.electricityTotalEndUses.get}\n")

	i += 1
end


=begin
#not all models have utility rates, so we double-check that the values exist before retrieving them from the pointers
puts sql.annualTotalCost(OpenStudio::FuelType.new(1)).get unless sql.annualTotalCost(OpenStudio::FuelType.new(1)).empty?  	# 1 = gas
puts sql.annualTotalCost(OpenStudio::FuelType.new(1)).get unless sql.annualTotalCost(OpenStudio::FuelType.new(1)).empty? 	# 0 = electricity
puts sql.annualTotalUtilityCost.get unless sql.annualTotalUtilityCost.empty?

#end use breakdown; Electricity
puts sql.electricityHeating.get
puts sql.electricityCooling.get
puts sql.electricityInteriorLighting.get
puts sql.electricityExteriorLighting.get
puts sql.electricityInteriorEquipment.get
puts sql.electricityExteriorEquipment.get
puts sql.electricityFans.get
puts sql.electricityPumps.get
puts sql.electricityHeatRejection.get
puts sql.electricityWaterSystems.get
puts sql.electricityRefrigeration.get

#end use breakdown; Natural Gas
puts sql.naturalGasHeating.get
puts sql.naturalGasCooling.get
puts sql.naturalGasInteriorLighting.get
puts sql.naturalGasExteriorLighting.get
puts sql.naturalGasInteriorEquipment.get
puts sql.naturalGasExteriorEquipment.get
puts sql.naturalGasFans.get
puts sql.naturalGasPumps.get
puts sql.naturalGasHeatRejection.get
puts sql.naturalGasWaterSystems.get
puts sql.naturalGasRefrigeration.get

#setup manual sql queries for queries not already built into OpenStudio
#Look at how this query is formed along side of the .htm report.  You should be able to see how the query is formed and modify to get other bits of information.
heating_setpoint_unmet_query = "SELECT Value FROM TabularDataWithStrings WHERE (ReportName='SystemSummary') AND (ReportForString='Entire Facility') AND (TableName='Time Setpoint Not Met') AND (RowName = 'Facility') AND (ColumnName='During Heating')"
cooling_setpoint_unmet_query = "SELECT Value FROM TabularDataWithStrings WHERE (ReportName='SystemSummary') AND (ReportForString='Entire Facility') AND (TableName='Time Setpoint Not Met') AND (RowName = 'Facility') AND (ColumnName='During Cooling')"  
  
#heating and cooling setpoint unmet hours
puts sql.execAndReturnFirstDouble(heating_setpoint_unmet_query).get
puts sql.execAndReturnFirstDouble(cooling_setpoint_unmet_query).get
=end




