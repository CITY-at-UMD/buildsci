require 'openstudio'

# take the auguments
file_name = ARGV.at(0)
request_data_name = ARGV[1]

#create an array to hold the paths to all the files
file_path =  "#{Dir.pwd}/#{file_name}"

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
case request_data_name
when "totalSiteEnergy"
	puts sql.totalSiteEnergy.get
when "totalSourceEnergy"
	puts sql.totalSourceEnergy.get
when "naturalGasTotalEndUses"
	puts sql.naturalGasTotalEndUses.get
when "electricityTotalEndUses"
	puts sql.electricityTotalEndUses.get
#not all models have utility rates, so we double-check that the values exist before retrieving them from the pointers
when "annualTotalCost"
puts sql.annualTotalCost(OpenStudio::FuelType.new(1)).get unless sql.annualTotalCost(OpenStudio::FuelType.new(1)).empty?  # 1 = gas
puts sql.annualTotalCost(OpenStudio::FuelType.new(1)).get unless sql.annualTotalCost(OpenStudio::FuelType.new(1)).empty?  # 0 = electricity

when "annualTotalUtilityCost"
puts sql.annualTotalUtilityCost.get unless sql.annualTotalUtilityCost.empty?

#end use breakdown; Electricity
when "electricityHeating"
puts sql.electricityHeating.get
when "electricityCooling"
puts sql.electricityCooling.get
when "electricityInteriorLighting"
puts sql.electricityInteriorLighting.get
when "electricityExteriorLighting"
puts sql.electricityExteriorLighting.get
when "electricityInteriorEquipment"
puts sql.electricityInteriorEquipment.get
when "electricityExteriorEquipment"
puts sql.electricityExteriorEquipment.get
when "electricityFans"
puts sql.electricityFans.get
when "electricityPumps"
puts sql.electricityPumps.get
when "electricityHeatRejection"
puts sql.electricityHeatRejection.get
when "electricityWaterSystems"
puts sql.electricityWaterSystems.get
when "electricityRefrigeration"
puts sql.electricityRefrigeration.get

#end use breakdown; Natural Gas
when "naturalGasHeating"
puts sql.naturalGasHeating.get
when "naturalGasCooling"
puts sql.naturalGasCooling.get
when "naturalGasInteriorLighting"
puts sql.naturalGasInteriorLighting.get
when "naturalGasExteriorLighting"
puts sql.naturalGasExteriorLighting.get
when "naturalGasInteriorEquipment"
puts sql.naturalGasInteriorEquipment.get
when "naturalGasExteriorEquipment"
puts sql.naturalGasExteriorEquipment.get
when "naturalGasFans"
puts sql.naturalGasFans.get
when "naturalGasPumps"
puts sql.naturalGasPumps.get
when "naturalGasHeatRejection"
puts sql.naturalGasHeatRejection.get
when "naturalGasWaterSystems"
puts sql.naturalGasWaterSystems.get
when "naturalGasRefrigeration"
puts sql.naturalGasRefrigeration.get

when "execAndReturnFirstDouble"
#setup manual sql queries for queries not already built into OpenStudio
#Look at how this query is formed along side of the .htm report.  You should be able to see how the query is formed and modify to get other bits of information.
#heating and cooling setpoint unmet hours
heating_setpoint_unmet_query = "SELECT Value FROM TabularDataWithStrings WHERE (ReportName='SystemSummary') AND (ReportForString='Entire Facility') AND (TableName='Time Setpoint Not Met') AND (RowName = 'Facility') AND (ColumnName='During Heating')"
puts sql.execAndReturnFirstDouble(heating_setpoint_unmet_query).get
when "execAndReturnFirstDouble"
cooling_setpoint_unmet_query = "SELECT Value FROM TabularDataWithStrings WHERE (ReportName='SystemSummary') AND (ReportForString='Entire Facility') AND (TableName='Time Setpoint Not Met') AND (RowName = 'Facility') AND (ColumnName='During Cooling')"  
puts sql.execAndReturnFirstDouble(cooling_setpoint_unmet_query).get
end
