
#getting the objects in the model already goes something like this:
model.getLights.each do |light|
  light.setWattsperSpaceFloorArea(5.0)
  light.setWattsperPerson(6.0)
end





#lighting

    lights_def = OpenStudio::Model::LightsDefinition.new($model)
    lights_def.setWattsperSpaceFloorArea(ip_to_si(lighting_per_area,"W/ft^2","W/m^2"))
    lights_def.setWattsperPerson(ip_to_si(lighting_per_person,"W/person","W/person"))

    #create the lighting instance and hook it up to the space type
    lights = OpenStudio::Model::Lights.new(lights_def)
    lights.setSpaceType(space_type)  

#ventilation

    #create the ventilation object and hook it up to the space type
    ventilation = OpenStudio::Model::DesignSpecificationOutdoorAir.new($model)
    space_type.setDesignSpecificationOutdoorAir(ventilation)
    ventilation.setOutdoorAirMethod("Sum")
    ventilation.setOutdoorAirFlowperFloorArea(ip_to_si(ventilation_per_area,"ft^3/min*ft^2","m^3/s*m^2"))
    ventilation.setOutdoorAirFlowperPerson(ip_to_si(ventilation_per_person,"ft^3/min*person","m^3/s*person"))
    ventilation.setOutdoorAirFlowAirChangesperHour(ventilation_ach)

#occupancy

    #create the people definition
    people_def = OpenStudio::Model::PeopleDefinition.new($model)
    people_def.setName("#{std} #{clim} #{ref_bldg_pri_spc_type} #{ref_bldg_sec_spc_type} People Definition")
    people_def.setPeopleperSpaceFloorArea(ip_to_si(occupancy_per_area/1000,"people/ft^2","people/m^2"))   
    
    #create the people instance and hook it up to the space type
    people = OpenStudio::Model::People.new(people_def)
    people.setSpaceType(space_type)
    default_sch_set.setNumberofPeopleSchedule(get_sch_from_lib(occupancy_sch))
  
#infiltration

    #create the infiltration object and hook it up to the space type
    infiltration = OpenStudio::Model::SpaceInfiltrationDesignFlowRate.new($model)
    infiltration.setSpaceType(space_type)
    infiltration.setFlowperExteriorSurfaceArea(ip_to_si(infiltration_per_area_ext,"ft^3/min*ft^2","m^3/s*m^2"))
    
    #get the infiltration schedule from the library and set as the default
    default_sch_set.setInfiltrationSchedule(get_sch_from_lib(infiltration_sch))

#electric equipment

    #create the electric equipment definition
    elec_equip_def = OpenStudio::Model::ElectricEquipmentDefinition.new($model)
    elec_equip_def.setWattsperSpaceFloorArea(ip_to_si(elec_equip_per_area,"W/ft^2","W/m^2"))
    
    #create the electric equipment instance and hook it up to the space type
    elec_equip = OpenStudio::Model::ElectricEquipment.new(elec_equip_def)
    elec_equip.setSpaceType(space_type)
    
    #get the electric equipment schedule from the library and set as the default
    default_sch_set.setElectricEquipmentSchedule(get_sch_from_lib(elec_equip_sch))
    
#gas equipment
  
    #create the gas equipment definition
    gas_equip_def = OpenStudio::Model::GasEquipmentDefinition.new($model)
    gas_equip_def.setWattsperSpaceFloorArea(ip_to_si(gas_equip_per_area,"Btu/hr*ft^2","W/m^2"))

    #create the gas equipment instance and hook it up to the space type
    gas_equip = OpenStudio::Model::GasEquipment.new(gas_equip_def)
    gas_equip.setSpaceType(space_type)
    
    #get the gas equipment schedule from the library and set as the default
    default_sch_set.setGasEquipmentSchedule(get_sch_from_lib(gas_equip_sch))