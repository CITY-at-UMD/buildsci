require 'openstudio'

OpenStudio::Application::instance()

localbcl = OpenStudio::LocalBCL::instance(OpenStudio::Path.new("/home/virtualpulse"))

bcl = OpenStudio::RemoteBCL.new
puts bcl.setProdAuthKey("xsxYuim9hvuuGdVFvhM5GBxNLPnDmNgE")
