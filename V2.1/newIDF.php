<?php
	
	echo '<p>New building input file started. <p/>';
	$IDFfile = $building . $userID;
	
    chdir('../');
	$fileHandle = fopen('./Buildings/'.$IDFfile.'.idf', "w") or die("VirtualPULSE could not create a building input file.  Please start over.");
	$dataString = 	

"Version, 7.1.0;  \n".
"\n".
"Building,\n".
"  ".$building.",  !- Name \n".
"  0.0000,  !- North Axis [Sketchup Model North = True North]\n".
"  City,  !- Terrain [IDF Editor Default = City][Sketchup Default = Suburbs]\n".
"  0.0400,  !- Loads Convergence Tolerance Value [Watts]\n".
"  0.2000,  !- Temperature Convergence Tolerance Value [deg C]\n".
"  FullInteriorAndExterior,  !- Solar Distribution [Space must be convex for ext & int] \n".
"  25,  !- Max Number of Warmup Days \n".
"  6;  !- Min Number of Warmup Days \n".
"\n".
"GlobalGeometryRules,  !- Previously called SurfaceGeometry\n".
"  UpperLeftCorner,  !- Starting Vertex Position \n".
"  Counterclockwise,  !- Vertex Entry Direction \n".
"  Relative,  !- Coordinate System [IDF Editor Default = relative][Sketchup Default = WORLD]\n".
"  Relative;  !- Daylighting Reference Point Coordinate System \n".
"\n".
"!--SIMULATION--------------\n".
"Timestep,4;   !-Simulation Timestep = 60/4 = 15 minutes increments [Default = 4]\n".
"\n".
"SimulationControl,!- Previously called UseWeatherFile\n".
"  No,  !- Do Zone Sizing Calculation NEEDS Sizing:Zone\n".
"  No,  !- Do System Sizing Calculation NEEDS Sizing:System\n".
"  No,  !- Do Plant Sizing Calculation NEEDS Sizing:Plant\n".
"  No,  !- Run Simulation for Sizing Periods NEEDS SizingPeriod:DesignDay + SizingPeriod:WeatherFileDays + SizingPeriod:WeatherFileConditionType\n".
"  Yes;  !- Run Simulation for Weather File Run Periods NEEDS RunPeriod\n".
"  \n".
"RunPeriod,\n".
"  ,  !- Name [Default = weather file title]\n".
"  1,  !- Begin Month \n".
"  1,  !- Begin Day of Month \n".
"  12,  !- End Month \n".
"  31,  !- End Day of Month \n".
"  Sunday;  !- Day of Week for Start Day \n".
"\n".
"!--ZONE---------------------\n".
"Zone,\n".
"Zone1,                    !- Zone Name\n".
"0,                       !- Direction of Relative North {deg}\n".
"    0,                       !- X Origin {m}\n".
"    0,                       !- Y Origin {m}\n".
"    0,                       !- Z Origin {m}\n".
"    ,                       !- Type\n".
"    1,                       !- Multiplier\n".
"autocalculate,           !- Ceiling Height {m} \n".
"    autocalculate;           !- Volume {m3} \n".
"\n".
"!--GEOMETRY---------------------\n".
"!-West Wall\n".
"BuildingSurface:Detailed,\n".
"Zone1W,           !- User Supplied Surface Name\n".
"Wall,                    !- Surface Type\n".
"ExteriorWallConst,                  !- Construction Name of the Surface\n".
"Zone1,                !- Zone Name\n".
"Outdoors ,     !- Outside Boundary Condition\n".
" ,                        !- Outside Boundary Condition Object\n".
"SunExposed,              !- Sun Exposure\n".
"WindExposed,             !- Wind Exposure\n".
"0.5,                     !- View Factor to Ground\n".
"4,                       !- Number of Surface Vertex Groups -- Number of (X,Y,Z) groups in this surface\n".
"0,                       !- Vertex 1 X-coordinate {m}\n".
"5,                       !- Vertex 1 Y-coordinate {m}\n".
"3,                       !- Vertex 1 Z-coordinate {m}\n".
"0,                       !- Vertex 2 X-coordinate {m}\n".
"0,                       !- Vertex 2 Y-coordinate {m}\n".
"3,                       !- Vertex 2 Z-coordinate {m}\n".
"0,                       !- Vertex 3 X-coordinate {m}\n".
"0,                       !- Vertex 3 Y-coordinate {m}\n".
"0,                       !- Vertex 3 Z-coordinate {m}\n".
"0,                       !- Vertex 4 X-coordinate {m}\n".
"5,                       !- Vertex 4 Y-coordinate {m}\n".
"0;                       !- Vertex 4 Z-coordinate {m}\n".
"\n".
"!-South Wall\n".
"BuildingSurface:Detailed,\n".
"Zone1S,           !- User Supplied Surface Name\n".
"Wall,                    !- Surface Type\n".
"ExteriorWallConst,                  !- Construction Name of the Surface\n".
"Zone1,                !- Zone Name\n".
"Outdoors ,     !- Outside Boundary Condition\n".
" ,                        !- Outside Boundary Condition Object\n".
"SunExposed,              !- Sun Exposure\n".
"WindExposed,             !- Wind Exposure\n".
"0.5,                     !- View Factor to Ground\n".
"4,                       !- Number of Surface Vertex Groups -- Number of (X,Y,Z) groups in this surface\n".
"0,                       !- Vertex 1 X-coordinate {m}\n".
"0,                       !- Vertex 1 Y-coordinate {m}\n".
"3,                       !- Vertex 1 Z-coordinate {m}\n".
"10,                       !- Vertex 2 X-coordinate {m}\n".
"0,                       !- Vertex 2 Y-coordinate {m}\n".
"3,                       !- Vertex 2 Z-coordinate {m}\n".
"10,                       !- Vertex 3 X-coordinate {m}\n".
"0,                       !- Vertex 3 Y-coordinate {m}\n".
"0,                       !- Vertex 3 Z-coordinate {m}\n".
"0,                       !- Vertex 4 X-coordinate {m}\n".
"0,                       !- Vertex 4 Y-coordinate {m}\n".
"0;                       !- Vertex 4 Z-coordinate {m}\n".
"\n".
"!-East Wall-\n".
"BuildingSurface:Detailed,\n".
"Zone1E,           !- User Supplied Surface Name\n".
"Wall,                    !- Surface Type\n".
"ExteriorWallConst,                  !- Construction Name of the Surface\n".
"Zone1,                !- Zone Name\n".
"Outdoors ,     !- Outside Boundary Condition\n".
" ,                        !- Outside Boundary Condition Object\n".
"SunExposed,              !- Sun Exposure\n".
"WindExposed,             !- Wind Exposure\n".
"0.5,                     !- View Factor to Ground\n".
"4,                       !- Number of Surface Vertex Groups -- Number of (X,Y,Z) groups in this surface\n".
"10,                       !- Vertex 1 X-coordinate {m}\n".
"0,                       !- Vertex 1 Y-coordinate {m}\n".
"3,                       !- Vertex 1 Z-coordinate {m}\n".
"10,                       !- Vertex 2 X-coordinate {m}\n".
"5,                       !- Vertex 2 Y-coordinate {m}\n".
"3,                       !- Vertex 2 Z-coordinate {m}\n".
"10,                       !- Vertex 3 X-coordinate {m}\n".
"5,                       !- Vertex 3 Y-coordinate {m}\n".
"0,                       !- Vertex 3 Z-coordinate {m}\n".
"10,                       !- Vertex 4 X-coordinate {m}\n".
"0,                       !- Vertex 4 Y-coordinate {m}\n".
"0;                       !- Vertex 4 Z-coordinate {m}\n".
"\n".
"!-North Wall-\n".
"BuildingSurface:Detailed,\n".
"Zone1N,           !- User Supplied Surface Name\n".
"Wall,                    !- Surface Type\n".
"ExteriorWallConst,                  !- Construction Name of the Surface\n".
"Zone1,                !- Zone Name\n".
"Outdoors ,     !- Outside Boundary Condition\n".
" ,                        !- Outside Boundary Condition Object\n".
"SunExposed,              !- Sun Exposure\n".
"WindExposed,             !- Wind Exposure\n".
"0.5,                     !- View Factor to Ground\n".
"4,                       !- Number of Surface Vertex Groups -- Number of (X,Y,Z) groups in this surface\n".
"10,                       !- Vertex 1 X-coordinate {m}\n".
"5,                       !- Vertex 1 Y-coordinate {m}\n".
"3,                       !- Vertex 1 Z-coordinate {m}\n".
"0,                       !- Vertex 2 X-coordinate {m}\n".
"5,                       !- Vertex 2 Y-coordinate {m}\n".
"3,                       !- Vertex 2 Z-coordinate {m}\n".
"0,                       !- Vertex 3 X-coordinate {m}\n".
"5,                       !- Vertex 3 Y-coordinate {m}\n".
"0,                       !- Vertex 3 Z-coordinate {m}\n".
"10,                       !- Vertex 4 X-coordinate {m}\n".
"5,                       !- Vertex 4 Y-coordinate {m}\n".
"0;                       !- Vertex 4 Z-coordinate {m}\n".
"\n".
"!-Floor-\n".
"BuildingSurface:Detailed,\n".
"Zone1F,           !- User Supplied Surface Name\n".
"Floor,                    !- Surface Type\n".
"FloorConst,                  !- Construction Name of the Surface\n".
"Zone1,                !- Zone Name\n".
"Outdoors ,     !- Outside Boundary Condition\n".
" ,                        !- Outside Boundary Condition Object\n".
"SunExposed,              !- Sun Exposure\n".
"WindExposed,             !- Wind Exposure\n".
"0.5,                     !- View Factor to Ground\n".
"4,                       !- Number of Surface Vertex Groups -- Number of (X,Y,Z) groups in this surface\n".
"0,                       !- Vertex 1 X-coordinate {m}\n".
"0,                       !- Vertex 1 Y-coordinate {m}\n".
"0,                       !- Vertex 1 Z-coordinate {m}\n".
"10,                       !- Vertex 2 X-coordinate {m}\n".
"0,                       !- Vertex 2 Y-coordinate {m}\n".
"0,                       !- Vertex 2 Z-coordinate {m}\n".
"10,                       !- Vertex 3 X-coordinate {m}\n".
"5,                       !- Vertex 3 Y-coordinate {m}\n".
"0,                       !- Vertex 3 Z-coordinate {m}\n".
"0,                       !- Vertex 4 X-coordinate {m}\n".
"5,                       !- Vertex 4 Y-coordinate {m}\n".
"0;                       !- Vertex 4 Z-coordinate {m}\n".
"\n".
"!-Ceiling/Roof-\n".
"BuildingSurface:Detailed,\n".
"Zone1C,           !- User Supplied Surface Name\n".
"ceiling,                    !- Surface Type\n".
"RoofConst,                  !- Construction Name of the Surface\n".
"Zone1,                !- Zone Name\n".
"Outdoors ,     !- Outside Boundary Condition\n".
" ,                        !- Outside Boundary Condition Object\n".
"SunExposed,              !- Sun Exposure\n".
"WindExposed,             !- Wind Exposure\n".
"0.5,                     !- View Factor to Ground\n".
"4,                       !- Number of Surface Vertex Groups -- Number of (X,Y,Z) groups in this surface\n".
"10,                       !- Vertex 1 X-coordinate {m}\n".
"0,                       !- Vertex 1 Y-coordinate {m}\n".
"3,                       !- Vertex 1 Z-coordinate {m}\n".
"0,                       !- Vertex 2 X-coordinate {m}\n".
"0,                       !- Vertex 2 Y-coordinate {m}\n".
"3,                       !- Vertex 2 Z-coordinate {m}\n".
"0,                       !- Vertex 3 X-coordinate {m}\n".
"5,                       !- Vertex 3 Y-coordinate {m}\n".
"3,                       !- Vertex 3 Z-coordinate {m}\n".
"10,                       !- Vertex 4 X-coordinate {m}\n".
"5,                       !- Vertex 4 Y-coordinate {m}\n".
"3;                       !- Vertex 4 Z-coordinate {m}\n".
"\n".
"!-Window-\n".
"FenestrationSurface:Detailed,\n".
"ZNSwindow,                !- User Supplied Surface Name\n".
"WINDOW,                  !- Surface Type\n".
"WindowConst,             !- Construction Name of the Surface\n".
"Zone1S,                   !- Base Surface Name\n".
",                        !- OutsideFaceEnvironment Object\n".
"0.5,                     !- View Factor to Ground\n".
",                        !- Name of shading control\n".
",                        !- WindowFrameAndDivider Name\n".
"1,                       !- Multiplier\n".
"4,                       !- Number of Surface Vertex Groups -- Number of (X,Y,Z) groups in this surface\n".
"5.5,                     !- Vertex 1 X-coordinate {m}\n".
"0,                       !- Vertex 1 Y-coordinate {m}\n".
"3,                     !- Vertex 1 Z-coordinate {m}\n".
"6.5,                     !- Vertex 2 X-coordinate {m}\n".
"0,                       !- Vertex 2 Y-coordinate {m}\n".
"3,                     !- Vertex 2 Z-coordinate {m}\n".
"6.5,                     !- Vertex 3 X-coordinate {m}\n".
"0,                       !- Vertex 3 Y-coordinate {m}\n".
"2,                       !- Vertex 3 Z-coordinate {m}\n".
"5.5,                     !- Vertex 4 X-coordinate {m}\n".
"0,                       !- Vertex 4 Y-coordinate {m}\n".
"2;                       !- Vertex 4 Z-coordinate {m}\n".
"\n".
"!--CONSTRUCTION---------------------\n".
"!-Construction, Name, Outside Layer, Layer 2, Layer 3, etc.-\n".
"\n".
"Construction, ExteriorWallConst, Insulator - 5cm, HW Concrete - 20cm;\n".
"Construction, FloorConst, Insulator - 10cm, HW Concrete - 25cm;\n".
"Construction, RoofConst, Insulator - 5cm, HW Concrete - 20cm;\n".
"Construction, WindowConst, Glass:Simple - 6mm, WindowGas:Air - 1cm, Glass:Simple - 6mm;\n".
"\n".
"!--MATERIALS---------------------\n".
"Material,\n".
"    Insulator - 5cm,         !- Name\n".
"    VeryRough,               !- Roughness\n".
"    .05,                     !- Thickness {m}\n".
"    .04,                     !- Conductivity {W/m-K}\n".
"    32.03000    ,            !- Density {kg/m3}\n".
"    830.0000    ,            !- Specific Heat {J/kg-K}\n".
"    0.9000000    ,           !- Absorptance:Thermal\n".
"    0.5000000    ,           !- Absorptance:Solar\n".
"    0.5000000    ;           !- Absorptance:Visible\n".
"\n".
"Material,\n".
"    Insulator - 10cm,        !- Name\n".
"    VeryRough,               !- Roughness\n".
"    .1,                      !- Thickness {m}\n".
"    .04,                     !- Conductivity {W/m-K}\n".
"    32.03000    ,            !- Density {kg/m3}\n".
"    830.0000    ,            !- Specific Heat {J/kg-K}\n".
"    0.9000000    ,           !- Absorptance:Thermal\n".
"    0.5000000    ,           !- Absorptance:Solar\n".
"    0.5000000    ;           !- Absorptance:Visible\n".
"\n".
"Material,\n".
"    HW Concrete - 20cm,      !- Name\n".
"    MediumRough,             !- Roughness\n".
"    .2,                      !- Thickness {m}\n".
"    1.720000    ,            !- Conductivity {W/m-K}\n".
"    2242.580    ,            !- Density {kg/m3}\n".
"    830.0000    ,            !- Specific Heat {J/kg-K}\n".
"    0.9000000    ,           !- Absorptance:Thermal\n".
"    0.6500000    ,           !- Absorptance:Solar\n".
"    0.6500000    ;           !- Absorptance:Visible\n".
"\n".
"Material,\n".
"    HW Concrete - 25cm,      !- Name\n".
"    MediumRough,             !- Roughness\n".
"    .25,                     !- Thickness {m}\n".
"    1.720000    ,            !- Conductivity {W/m-K}\n".
"    2242.580    ,            !- Density {kg/m3}\n".
"    830.0000    ,            !- Specific Heat {J/kg-K}\n".
"    0.9000000    ,           !- Absorptance:Thermal\n".
"    0.6500000    ,           !- Absorptance:Solar\n".
"    0.6500000    ;           !- Absorptance:Visible\n".
"\n".
"Material,\n".
"    LW Concrete - 15cm,      !- Name\n".
"    Rough,                   !- Roughness\n".
"    .15,                     !- Thickness {m}\n".
"    0.5700000    ,           !- Conductivity {W/m-K}\n".
"    608.7000    ,            !- Density {kg/m3}\n".
"    830.0000    ,            !- Specific Heat {J/kg-K}\n".
"    0.9000000    ,           !- Absorptance:Thermal\n".
"    0.6500000    ,           !- Absorptance:Solar\n".
"    0.6500000    ;           !- Absorptance:Visible\n".
"\n".
"WindowMaterial:Glazing,\n".
"    Glass:Simple - 6mm,      !- Name\n".
"    SpectralAverage,         !- Optical Data Type\n".
"    ,                        !- Name of Window Glass Spectral Data Set\n".
"    .006,                    !- Thickness {m}\n".
"    .775,                    !- Solar Transmittance at Normal Incidence\n".
"    .071,                    !- Solar Reflectance at Normal Incidence: Front Side\n".
"    .071,                    !- Solar Reflectance at Normal Incidence: Back Side\n".
"    .881,                    !- Visible Transmittance at Normal Incidence\n".
"    .080,                    !- Visible Reflectance at Normal Incidence: Front Side\n".
"    .080,                    !- Visible Reflectance at Normal Incidence: Back Side\n".
"    .0,                      !- IR Transmittance at Normal Incidence\n".
"    .84,                     !- IR Hemispherical Emissivity: Front Side\n".
"    .84,                     !- IR Hemispherical Emissivity: Back Side\n".
"    .9;                      !- Conductivity {W/m-K}\n".
"\n".
"WindowMaterial:Gas,\n".
"    WindowGas:Air - 1cm,     !- Name\n".
"    AIR,                     !- Gas Type\n".
"    .01;                     !- Thickness {m}\n".
"\n".
"!--SCHEDULE-------------------------\n".
"ScheduleTypeLimits, !- Needed to validate Schedule Compact of Type Fraction\n".
"  Fraction,                !- Name\n".
"  0.0,                     !- Lower Limit Value\n".
"  1.0,                     !- Upper Limit Value\n".
"  CONTINUOUS;              !- Numeric Type\n".
"  \n".
"Schedule:Compact,\n".
"    Work9-17,                !- Name\n".
"    Fraction,                !- ScheduleType\n".
"    Through: 12/31,           !- Complex Field #1\n".
"    For: AllDays,            !- Complex Field #2\n".
"    Until: 8:00,             !- Complex Field #3\n".
"    0.0,                     !- Complex Field #4\n".
"    Until: 9:00,             !- Complex Field #5\n".
"    0.5,                     !- Complex Field #6\n".
"    Until: 17:00,            !- Complex Field #7\n".
"    1,                       !- Complex Field #8\n".
"    Until: 18:00,            !- Complex Field #9\n".
"    0.5,                     !- Complex Field #10\n".
"    Until: 24:00,            !- Complex Field #11\n".
"    0.0;                     !- Complex Field #12\n".
"\n".
"!--HVAC---------------------\n".
"\n".
"  HVACTemplate:Thermostat,\n".
"    Constant Setpoint Thermostat,  !- Name\n".
"    ,                        !- Heating Setpoint Schedule Name\n".
"    20,                      !- Constant Heating Setpoint {C}\n".
"    ,                        !- Cooling Setpoint Schedule Name\n".
"    25;                      !- Constant Cooling Setpoint {C}\n".
"\n".
"  HVACTemplate:Zone:IdealLoadsAirSystem, \n".
"    Zone1,          !- Zone Name \n".
"    Constant Setpoint Thermostat;               !- Thermostat Name\n".
"\n".
"!--LOADS------------------\n".
"!-People & Lights & Electrical-\n".
"\n".
"People,\n".
"  PeopleName,  !- Name \n".
"  Zone1,  !- Zone Name \n".
"  Work9-17,  !- Schedule Name \n".
"  People,  !- Number of People Calculation Method \n".
"  3.0269,  !- Number of People \n".
"  ,  !- People per Zone Area \n".
"  ,  !- Zone Area per Person \n".
"  0.3000,  !- Fraction Radiant \n".
"  AUTOCALCULATE,  !- User Specified Sensible Fraction \n".
"  Work9-17,  !- Activity Level Schedule Name \n".
"  3.82E-8,  !- Carbon Dioxide Generation Rate {m3/s-W}\n".
"  No,  !- Enable ASHRAE 55 Comfort Warnings \n".
"  ZoneAveraged,  !- MRT Calculation \n".
"  ,  !- Surface Name \n".
"  Work9-17,  !- Work Efficiency Schedule Name \n".
"  Work9-17,  !- Clothing Schedule Name \n".
"  Work9-17,  !- Air Velocity Schedule Name \n".
"  FANGER;  !- Thermal Comfort Report \n".
"  \n".
"Lights,\n".
"  LightsName,  !- Name \n".
"  Zone1,  !- Zone Name \n".
"  Work9-17,  !- Schedule Name \n".
"  LightingLevel,  !- Design Level Calculation Method \n".
"  832.9787,  !- Design Level {W}\n".
"  ,  !- Watts per Zone Area {W/m2}\n".
"  ,  !- Watts per Person {W/person}\n".
"  0.0000,  !- Return Air Fraction \n".
"  0.7000,  !- Fraction Radiant \n".
"  0.2000,  !- Fraction Visible \n".
"  1.0000,  !- Fraction Replaceable \n".
"  General,  !- End-Use Subcategory \n".
"  No;  !- Return Air Fraction is Calculated from Plenum Temperature \n".
"  \n".
"ElectricEquipment,\n".
"  ElectricEquipmentName,  !- Name \n".
"  Zone1,  !- Zone Name \n".
"  Work9-17,  !- Schedule Name \n".
"  EquipmentLevel,  !- Design Level Calculation Method \n".
"  624.7340,  !- Design Level {W}\n".
"  ,  !- Watts per Zone Floor Area {W/m2}\n".
"  ,  !- Watts per Person {W/person}\n".
"  0.0000,  !- Fraction Latent \n".
"  0.5000,  !- Fraction Radiant \n".
"  0.0000,  !- Fraction Lost \n".
"  PlugMisc;  !- End-Use Subcategory \n".
"\n".
"!--OUTPUT---------------------\n".
"OutputControl:Table:Style,\n".
"  TabAndHTML;                    !- Column Separator\n".
"\n".
"Output:Surfaces:Drawing,\n".
"  DXF;     !- Geometry\n".
"\n".
"Output:SQLite,\n".
"  SimpleAndTabular;  \n".
"\n".
"Output:Table:SummaryReports,\n".
"  AnnualBuildingUtilityPerformanceSummary,  !- Report Name\n".
"  InputVerificationandResultsSummary,  \n".
"  ClimaticDataSummary;\n";
	
	fwrite($fileHandle, $dataString);
	fclose($fileHandle);
	
	echo "<p>Building Input File: ". $IDFfile . ".idf [created successfully]<p/>";
?>