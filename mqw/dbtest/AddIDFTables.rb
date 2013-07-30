# functions in this file are used to modify the idf file
#	such that monthly data are included in the reports
# Mujing Wang 
# April 10th, 2013

# No longer needed as of June 12th., 2013

def add_monthly_electricity(idf_file)
	idf_file.write("\nOutput:Table:Monthly,
  End Use Energy Consumption Electricity Monthly,   ! Name
  3,                                                ! Digits After Decimal
  Cooling:Electricity,                              ! Variable or Meter 1 Name
  SumOrAverage,                                     ! Aggregation Type for Variable or Meter 1
  InteriorLights:Electricity,
  SumOrAverage,
  Heating:Electricity,
  SumOrAverage;
")
end

def add_monthly_gasoline(idf_file)
	idf_file.write("\nOutput:Table:Monthly,
  End Use Energy Consumption Gasoline Monthly,   ! Name
  3,                                                ! Digits After Decimal
  Cooling:Gasoline,                              ! Variable or Meter 1 Name
  SumOrAverage,                                     ! Aggregation Type for Variable or Meter 1
  InteriorLights:Gasoline,
  SumOrAverage,
  Heating:Gasoline,
  SumOrAverage;
")
end

def add_monthly_naturalgas(idf_file)
	idf_file.write("\nOutput:Table:Monthly,
  End Use Energy Consumption Natural Gas Monthly,   ! Name
  3,                                                ! Digits After Decimal
  Cooling:Gas,                              ! Variable or Meter 1 Name
  SumOrAverage,                                     ! Aggregation Type for Variable or Meter 1
  InteriorLights:Gas,
  SumOrAverage,
  Heating:Gas,
  SumOrAverage;
")
end

def add_monthly_diesel(idf_file)
	idf_file.write("\nOutput:Table:Monthly,
  End Use Energy Consumption Diesel Monthly,   ! Name
  3,                                                ! Digits After Decimal
  Cooling:Diesel,                              ! Variable or Meter 1 Name
  SumOrAverage,                                     ! Aggregation Type for Variable or Meter 1
  InteriorLights:Diesel,
  SumOrAverage,
  Heating:Diesel,
  SumOrAverage;
")
end
 
=begin
def add_emission_report(idf_file)
	idf_file.write("\nZoneAirContaminantBalance,
	Yes,
	Outdoor C02 Schedule,
	Yes,
	Generic Contaminant Schedule;")
end 
=end

def add_dict(idf_file)
	idf_file.write("\nOutput:VariableDictionary, IDF;
! Program Version,EnergyPlus-Linux-OMP-32 7.2.0.006, YMD=2013.04.17 15:37,IDD_Version 7.2.0.006
! Output:Meter Objects (applicable to this run)
Output:Meter,Electricity:Facility,hourly; !- [J]
Output:Meter:Cumulative,Electricity:Facility,hourly; !- [J]
Output:Meter,Electricity:Building,hourly; !- [J]
Output:Meter:Cumulative,Electricity:Building,hourly; !- [J]
Output:Meter,Electricity:Zone:THERMAL ZONE 1,hourly; !- [J]
Output:Meter:Cumulative,Electricity:Zone:THERMAL ZONE 1,hourly; !- [J]
Output:Meter,InteriorLights:Electricity,hourly; !- [J]
Output:Meter:Cumulative,InteriorLights:Electricity,hourly; !- [J]
Output:Meter,InteriorLights:Electricity:Zone:THERMAL ZONE 1,hourly; !- [J]
Output:Meter:Cumulative,InteriorLights:Electricity:Zone:THERMAL ZONE 1,hourly; !- [J]
Output:Meter,General:InteriorLights:Electricity,hourly; !- [J]
Output:Meter:Cumulative,General:InteriorLights:Electricity,hourly; !- [J]
Output:Meter,Electricity:Zone:THERMAL ZONE 2,hourly; !- [J]
Output:Meter:Cumulative,Electricity:Zone:THERMAL ZONE 2,hourly; !- [J]
Output:Meter,InteriorLights:Electricity:Zone:THERMAL ZONE 2,hourly; !- [J]
Output:Meter:Cumulative,InteriorLights:Electricity:Zone:THERMAL ZONE 2,hourly; !- [J]
Output:Meter,Electricity:Zone:THERMAL ZONE 3,hourly; !- [J]
Output:Meter:Cumulative,Electricity:Zone:THERMAL ZONE 3,hourly; !- [J]
Output:Meter,InteriorLights:Electricity:Zone:THERMAL ZONE 3,hourly; !- [J]
Output:Meter:Cumulative,InteriorLights:Electricity:Zone:THERMAL ZONE 3,hourly; !- [J]
Output:Meter,Electricity:Zone:THERMAL ZONE 4,hourly; !- [J]
Output:Meter:Cumulative,Electricity:Zone:THERMAL ZONE 4,hourly; !- [J]
Output:Meter,InteriorLights:Electricity:Zone:THERMAL ZONE 4,hourly; !- [J]
Output:Meter:Cumulative,InteriorLights:Electricity:Zone:THERMAL ZONE 4,hourly; !- [J]
Output:Meter,Electricity:Zone:THERMAL ZONE 5,hourly; !- [J]
Output:Meter:Cumulative,Electricity:Zone:THERMAL ZONE 5,hourly; !- [J]
Output:Meter,InteriorLights:Electricity:Zone:THERMAL ZONE 5,hourly; !- [J]
Output:Meter:Cumulative,InteriorLights:Electricity:Zone:THERMAL ZONE 5,hourly; !- [J]
Output:Meter,InteriorEquipment:Electricity,hourly; !- [J]
Output:Meter:Cumulative,InteriorEquipment:Electricity,hourly; !- [J]
Output:Meter,InteriorEquipment:Electricity:Zone:THERMAL ZONE 1,hourly; !- [J]
Output:Meter:Cumulative,InteriorEquipment:Electricity:Zone:THERMAL ZONE 1,hourly; !- [J]
Output:Meter,General:InteriorEquipment:Electricity,hourly; !- [J]
Output:Meter:Cumulative,General:InteriorEquipment:Electricity,hourly; !- [J]
Output:Meter,InteriorEquipment:Electricity:Zone:THERMAL ZONE 2,hourly; !- [J]
Output:Meter:Cumulative,InteriorEquipment:Electricity:Zone:THERMAL ZONE 2,hourly; !- [J]
Output:Meter,InteriorEquipment:Electricity:Zone:THERMAL ZONE 3,hourly; !- [J]
Output:Meter:Cumulative,InteriorEquipment:Electricity:Zone:THERMAL ZONE 3,hourly; !- [J]
Output:Meter,InteriorEquipment:Electricity:Zone:THERMAL ZONE 4,hourly; !- [J]
Output:Meter:Cumulative,InteriorEquipment:Electricity:Zone:THERMAL ZONE 4,hourly; !- [J]
Output:Meter,InteriorEquipment:Electricity:Zone:THERMAL ZONE 5,hourly; !- [J]
Output:Meter:Cumulative,InteriorEquipment:Electricity:Zone:THERMAL ZONE 5,hourly; !- [J]
Output:Meter,EnergyTransfer:Facility,hourly; !- [J]
Output:Meter:Cumulative,EnergyTransfer:Facility,hourly; !- [J]
Output:Meter,EnergyTransfer:Building,hourly; !- [J]
Output:Meter:Cumulative,EnergyTransfer:Building,hourly; !- [J]
Output:Meter,EnergyTransfer:Zone:THERMAL ZONE 2,hourly; !- [J]
Output:Meter:Cumulative,EnergyTransfer:Zone:THERMAL ZONE 2,hourly; !- [J]
Output:Meter,Heating:EnergyTransfer,hourly; !- [J]
Output:Meter:Cumulative,Heating:EnergyTransfer,hourly; !- [J]
Output:Meter,Heating:EnergyTransfer:Zone:THERMAL ZONE 2,hourly; !- [J]
Output:Meter:Cumulative,Heating:EnergyTransfer:Zone:THERMAL ZONE 2,hourly; !- [J]
Output:Meter,Cooling:EnergyTransfer,hourly; !- [J]
Output:Meter:Cumulative,Cooling:EnergyTransfer,hourly; !- [J]
Output:Meter,Cooling:EnergyTransfer:Zone:THERMAL ZONE 2,hourly; !- [J]
Output:Meter:Cumulative,Cooling:EnergyTransfer:Zone:THERMAL ZONE 2,hourly; !- [J]
Output:Meter,EnergyTransfer:Zone:THERMAL ZONE 4,hourly; !- [J]
Output:Meter:Cumulative,EnergyTransfer:Zone:THERMAL ZONE 4,hourly; !- [J]
Output:Meter,Heating:EnergyTransfer:Zone:THERMAL ZONE 4,hourly; !- [J]
Output:Meter:Cumulative,Heating:EnergyTransfer:Zone:THERMAL ZONE 4,hourly; !- [J]
Output:Meter,Cooling:EnergyTransfer:Zone:THERMAL ZONE 4,hourly; !- [J]
Output:Meter:Cumulative,Cooling:EnergyTransfer:Zone:THERMAL ZONE 4,hourly; !- [J]
Output:Meter,EnergyTransfer:Zone:THERMAL ZONE 3,hourly; !- [J]
Output:Meter:Cumulative,EnergyTransfer:Zone:THERMAL ZONE 3,hourly; !- [J]
Output:Meter,Heating:EnergyTransfer:Zone:THERMAL ZONE 3,hourly; !- [J]
Output:Meter:Cumulative,Heating:EnergyTransfer:Zone:THERMAL ZONE 3,hourly; !- [J]
Output:Meter,Cooling:EnergyTransfer:Zone:THERMAL ZONE 3,hourly; !- [J]
Output:Meter:Cumulative,Cooling:EnergyTransfer:Zone:THERMAL ZONE 3,hourly; !- [J]
Output:Meter,EnergyTransfer:Zone:THERMAL ZONE 5,hourly; !- [J]
Output:Meter:Cumulative,EnergyTransfer:Zone:THERMAL ZONE 5,hourly; !- [J]
Output:Meter,Heating:EnergyTransfer:Zone:THERMAL ZONE 5,hourly; !- [J]
Output:Meter:Cumulative,Heating:EnergyTransfer:Zone:THERMAL ZONE 5,hourly; !- [J]
Output:Meter,Cooling:EnergyTransfer:Zone:THERMAL ZONE 5,hourly; !- [J]
Output:Meter:Cumulative,Cooling:EnergyTransfer:Zone:THERMAL ZONE 5,hourly; !- [J]
Output:Meter,EnergyTransfer:Zone:THERMAL ZONE 1,hourly; !- [J]
Output:Meter:Cumulative,EnergyTransfer:Zone:THERMAL ZONE 1,hourly; !- [J]
Output:Meter,Heating:EnergyTransfer:Zone:THERMAL ZONE 1,hourly; !- [J]
Output:Meter:Cumulative,Heating:EnergyTransfer:Zone:THERMAL ZONE 1,hourly; !- [J]
Output:Meter,Cooling:EnergyTransfer:Zone:THERMAL ZONE 1,hourly; !- [J]
Output:Meter:Cumulative,Cooling:EnergyTransfer:Zone:THERMAL ZONE 1,hourly; !- [J]
Output:Meter,ElectricityPurchased:Facility,hourly; !- [J]
Output:Meter:Cumulative,ElectricityPurchased:Facility,hourly; !- [J]
Output:Meter,ElectricityPurchased:Plant,hourly; !- [J]
Output:Meter:Cumulative,ElectricityPurchased:Plant,hourly; !- [J]
Output:Meter,Cogeneration:ElectricityPurchased,hourly; !- [J]
Output:Meter:Cumulative,Cogeneration:ElectricityPurchased,hourly; !- [J]
Output:Meter,ElectricitySurplusSold:Facility,hourly; !- [J]
Output:Meter:Cumulative,ElectricitySurplusSold:Facility,hourly; !- [J]
Output:Meter,ElectricitySurplusSold:Plant,hourly; !- [J]
Output:Meter:Cumulative,ElectricitySurplusSold:Plant,hourly; !- [J]
Output:Meter,Cogeneration:ElectricitySurplusSold,hourly; !- [J]
Output:Meter:Cumulative,Cogeneration:ElectricitySurplusSold,hourly; !- [J]
Output:Meter,ElectricityNet:Facility,hourly; !- [J]
Output:Meter:Cumulative,ElectricityNet:Facility,hourly; !- [J]
Output:Meter,ElectricityNet:Plant,hourly; !- [J]
Output:Meter:Cumulative,ElectricityNet:Plant,hourly; !- [J]
Output:Meter,Cogeneration:ElectricityNet,hourly; !- [J]
Output:Meter:Cumulative,Cogeneration:ElectricityNet,hourly; !- [J]
Output:Meter,EnergyTransfer:HVAC,hourly; !- [J]
Output:Meter:Cumulative,EnergyTransfer:HVAC,hourly; !- [J]
Output:Meter,HeatingCoils:EnergyTransfer,hourly; !- [J]
Output:Meter:Cumulative,HeatingCoils:EnergyTransfer,hourly; !- [J]
Output:Meter,PlantLoopHeatingDemand:Facility,hourly; !- [J]
Output:Meter:Cumulative,PlantLoopHeatingDemand:Facility,hourly; !- [J]
Output:Meter,PlantLoopHeatingDemand:HVAC,hourly; !- [J]
Output:Meter:Cumulative,PlantLoopHeatingDemand:HVAC,hourly; !- [J]
Output:Meter,HeatingCoils:PlantLoopHeatingDemand,hourly; !- [J]
Output:Meter:Cumulative,HeatingCoils:PlantLoopHeatingDemand,hourly; !- [J]
Output:Meter,CoolingCoils:EnergyTransfer,hourly; !- [J]
Output:Meter:Cumulative,CoolingCoils:EnergyTransfer,hourly; !- [J]
Output:Meter,Electricity:HVAC,hourly; !- [J]
Output:Meter:Cumulative,Electricity:HVAC,hourly; !- [J]
Output:Meter,Cooling:Electricity,hourly; !- [J]
Output:Meter:Cumulative,Cooling:Electricity,hourly; !- [J]
Output:Meter,Fans:Electricity,hourly; !- [J]
Output:Meter:Cumulative,Fans:Electricity,hourly; !- [J]
Output:Meter,General:Fans:Electricity,hourly; !- [J]
Output:Meter:Cumulative,General:Fans:Electricity,hourly; !- [J]
Output:Meter,EnergyTransfer:Plant,hourly; !- [J]
Output:Meter:Cumulative,EnergyTransfer:Plant,hourly; !- [J]
Output:Meter,Boilers:EnergyTransfer,hourly; !- [J]
Output:Meter:Cumulative,Boilers:EnergyTransfer,hourly; !- [J]
Output:Meter,Gasoline:Facility,hourly; !- [J]
Output:Meter:Cumulative,Gasoline:Facility,hourly; !- [J]
Output:Meter,Gasoline:Plant,hourly; !- [J]
Output:Meter:Cumulative,Gasoline:Plant,hourly; !- [J]
Output:Meter,Heating:Gasoline,hourly; !- [J]
Output:Meter:Cumulative,Heating:Gasoline,hourly; !- [J]
Output:Meter,Boiler:Heating:Gasoline,hourly; !- [J]
Output:Meter:Cumulative,Boiler:Heating:Gasoline,hourly; !- [J]
Output:Meter,Electricity:Plant,hourly; !- [J]
Output:Meter:Cumulative,Electricity:Plant,hourly; !- [J]
Output:Meter,Heating:Electricity,hourly; !- [J]
Output:Meter:Cumulative,Heating:Electricity,hourly; !- [J]
Output:Meter,Boiler Parasitic:Heating:Electricity,hourly; !- [J]
Output:Meter:Cumulative,Boiler Parasitic:Heating:Electricity,hourly; !- [J]
Output:Meter,Pumps:Electricity,hourly; !- [J]
Output:Meter:Cumulative,Pumps:Electricity,hourly; !- [J]
Output:Meter,Carbon Equivalent:Facility,hourly; !- [kg]
Output:Meter:Cumulative,Carbon Equivalent:Facility,hourly; !- [kg]
Output:Meter,CarbonEquivalentEmissions:Carbon Equivalent,hourly; !- [kg]
Output:Meter:Cumulative,CarbonEquivalentEmissions:Carbon Equivalent,hourly; !- [kg]
")

end
