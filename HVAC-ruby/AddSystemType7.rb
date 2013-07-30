######################################################################
#  Copyright (c) 2008-2010, Alliance for Sustainable Energy.
#  All rights reserved.
#
#  This library is free software; you can redistribute it and/or
#  modify it under the terms of the GNU Lesser General Public
#  License as published by the Free Software Foundation; either
#  version 2.1 of the License, or (at your option) any later version.
#
#  This library is distributed in the hope that it will be useful,
#  but WITHOUT ANY WARRANTY; without even the implied warranty of
#  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
#  Lesser General Public License for more details.
#
#  You should have received a copy of the GNU Lesser General Public
#  License along with this library; if not, write to the Free Software
#  Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
######################################################################

######################################################################
# == Synopsis 
#
#   Adds System Type 7 - VAV with Reheat to a model
#   One AHU for the model, and a terminal for each zone
#
# == Usage
#
#   ruby AssetRatingProcess.rb
#
# == Examples
#
#   ruby AssetRatingProcess.rb
#
######################################################################

class AddSystemType7 < OpenStudio::Ruleset::ModelUserScript

  # override name to return the name of your script
  def name
    return "Add A System Type 7 - VAV with Reheat to Model"
  end
  
  # return a vector of arguments
  def arguments(model)
    result = OpenStudio::Ruleset::UserScriptArgumentVector.new
    return result
  end

  def run(model, runner, arguments)
    #get the thermal zones in the model
    zones = model.getThermalZones
    
    #add a system type 7 - VAV with Reheat to the model and hook up
    #each zone to this system
    hvac = OpenStudio::Model::addSystemType7(model)
    hvac = hvac.to_AirLoopHVAC.get      
    zones.each do|zone|
      hvac.addBranchForZone(zone)      
    end
  end

end

AddSystemType7.new.registerWithSketchUp
