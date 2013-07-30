require 'openstudio'

request = ARGV.at(0)

#TODO - unit conversions
puts "***UNIT CONVERSIONS NOT YET IMPLEMENTED, ALL RESULTS IN Giga Joule***"

#create an array to hold the paths to all the files
file_path =  "#{Dir.pwd}/eplusout_test.sql"

#Open the sql file
  sql_path = OpenStudio::Path.new(file_path)
#if the sql file exists, load it into the variable sql
if OpenStudio::exists(sql_path)
  sql = OpenStudio::SqlFile.new(sql_path)
else 
  puts  "ERROR - #{file_path} couldn't be found; continuing to next file"
  exit #exit the script
end

#Create a table object to store the monthly data
#table = OpenStudio::openstudio.monthlyEndUsesTable(sql, OpenStudio::EndUseFuelType.new(1))

#summary data
case request
when "total_site_energy"
	puts "total site energy: " + "#{sql.totalSiteEnergy.get}"
when "total_source_energy"
	puts "#{sql.totalSourceEnergy.get}"
when "natural_gas_total_end_uses"
	puts "natural gas total end uses: " + "#{sql.naturalGasTotalEndUses.get}"
when "electricity_total_end_uses: "
	puts "electricity total end uses: " + "#{sql.electricityTotalEndUses.get}"  
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
=end

