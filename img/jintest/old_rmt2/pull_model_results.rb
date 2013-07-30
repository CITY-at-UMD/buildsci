require 'openstudio'

#TODO - unit conversions
puts "***UNIT CONVERSIONS NOT YET IMPLEMENTED, ALL RESULTS IN GJ***"

#create an array to hold the paths to all the files
file_path =  "#{Dir.pwd}/abc.sql"

puts "starting #{file_path}"

#Open the sql file
  sql_path = OpenStudio::Path.new(file_path)
#if the sql file exists, load it into the variable sql
if OpenStudio::exists(sql_path)
  sql = OpenStudio::SqlFile.new(sql_path)
else 
  puts  "ERROR - #{file_path} couldn't be found; continuing to next file"
  exit #exit the script
end

#summary data
puts sql.totalSiteEnergy.get
puts sql.totalSourceEnergy.get
puts sql.naturalGasTotalEndUses.get
puts sql.electricityTotalEndUses.get  

#not all models have utility rates, so we double-check that the values exist before retrieving them from the pointers
puts sql.annualTotalCost(OpenStudio::FuelType.new(1)).get unless sql.annualTotalCost(OpenStudio::FuelType.new(1)).empty?  # 1 = gas
puts sql.annualTotalCost(OpenStudio::FuelType.new(1)).get unless sql.annualTotalCost(OpenStudio::FuelType.new(1)).empty? # 0 = electricity
puts sql.annualTotalUtilityCost.get unless sql.annualTotalUtilityCost.empty?

#end use breakdown; Electricity
puts "//======================== Electricity ====================//"
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
puts "//======================== Natural Gas ====================//"
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

puts "//======================== heating set_point ====================//"
heating_setpoint_unmet_query = "SELECT Value FROM TabularDataWithStrings WHERE (ReportName='SystemSummary') AND (ReportForString='Entire Facility') AND (TableName='Time Setpoint Not Met') AND (RowName = 'Facility') AND (ColumnName='During Heating')"

puts "//======================== cooling set_point ====================//"
cooling_setpoint_unmet_query = "SELECT Value FROM TabularDataWithStrings WHERE (ReportName='SystemSummary') AND (ReportForString='Entire Facility') AND (TableName='Time Setpoint Not Met') AND (RowName = 'Facility') AND (ColumnName='During Cooling')"  
  
#heating and cooling setpoint unmet hours
puts "//======================== print heating set point by hour ====================//"
puts sql.execAndReturnFirstDouble(heating_setpoint_unmet_query).get

puts "//======================== print cooling set point by hour ====================//"
puts sql.execAndReturnFirstDouble(cooling_setpoint_unmet_query).get

