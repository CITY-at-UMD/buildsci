<?php

// This php script is based on amcharts.js
// More Information, please visit http://www.amcharts.com/
class Graph{
        // GRAPH FOR THE DISPLAY OF THE SOURCE ENERGY SUMMARY
		// CONVERTING THE AMCHARTS(JAVASCRIPT) IN PHP FORM 
		public function barChart($totalSiteEnergy, $totalSourceEnergy, $naturalGasTotalEndUses, $electricityTotalEndUses) {
		$bar='<script src="./amcharts.js" type="text/javascript"></script>         
					<script type="text/javascript">
					    var chart;

					    var chartData = [{
					        title: "Energy Per Total Site Energy [MJ/m2]",
					        total_site: '.$totalSiteEnergy.',
					        net_site: '.$totalSiteEnergy.'
					    }, {
					        title: "Energy Per Total Source Energy [MJ/m2]",
					        total_site: '.$totalSourceEnergy.',
					        net_site: '.$totalSourceEnergy.'
					    }, {
						title: "Energy Per Electricity Total EndUses [MJ/m2]",
					        total_site: '.$electricityTotalEndUses.',
					        net_site: '.$electricityTotalEndUses.'
					    }, {
						title: "Energy Per NaturalGas Total EndUses [MJ/m2]",
					        total_site: '.$naturalGasTotalEndUses.',
					        net_site: '.$naturalGasTotalEndUses.'
					    }];

					    AmCharts.ready(function () {
					        // SERIAL CHART
					        chart = new AmCharts.AmSerialChart();
					        chart.dataProvider = chartData;
					        chart.categoryField = "title";
					        chart.startDuration = 1;
					        chart.rotate = true;

					        // AXES
					        // category
					        var categoryAxis = chart.categoryAxis;
					        categoryAxis.gridPosition = "start";
					        categoryAxis.axisColor = "#DADADA";
					        categoryAxis.dashLength = 5;

					        // value
					        var valueAxis = new AmCharts.ValueAxis();
					        valueAxis.dashLength = 5;
					        valueAxis.axisAlpha = 0.2;
					        valueAxis.position = "top";
					        valueAxis.title = "[MJ/m2]";
					        chart.addValueAxis(valueAxis);

					        // GRAPHS
					        // column graph
					        var graph1 = new AmCharts.AmGraph();
					        graph1.type = "column";
					        graph1.title = "Total Site Energy";
					        graph1.valueField = "total_site";
					        graph1.lineAlpha = 0;
					        graph1.fillColors = "#ADD981";
					        graph1.fillAlphas = 1;
					        chart.addGraph(graph1);

					        // line graph
					        var graph2 = new AmCharts.AmGraph();
					        graph2.type = "line";
					        graph2.title = "Net Site Energy";
					        graph2.valueField = "net_site";
					        graph2.lineThickness = 2;
					        graph2.bullet = "round";
					        graph2.fillAlphas = 0;
					        chart.addGraph(graph2);

					        // LEGEND
					        var legend = new AmCharts.AmLegend();
					        chart.addLegend(legend);

					        // WRITE
					        chart.write("bar_chartdiv");
					    });
					</script>

					<div class="bottom" id="bar_chartdiv" style="width: 100%; height: 600px;"></div>';

		return $bar;
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////

	// GRAPH FOR THE DISPLAY OF THE ELECTRICITY AND NATURAL GAS ANNUAL USED
	// AMCHARTS(JAVASCRIPT) IN PHP FORM
	public function pieChart($dataSet, $title) {
	
    $pie='<script src="./amcharts.js" type="text/javascript"></script>         
         <script type="text/javascript">
            var chart;

            
            var chartData = [{
                device: "Heating",
                GJ: '.$dataSet["Heating"].'
            }, {
                device: "Cooling",
                GJ: '.$dataSet["Cooling"].'
            }, {
                device: "InteriorLighting",
                GJ: '.$dataSet["InteriorLighting"].'
            }, {
                device: "ExteriorLighting",
                GJ: '.$dataSet["ExteriorLighting"].'
            }
			, {
                device: "InteriorEquipment",
                GJ: '.$dataSet["InteriorEquipment"].'
            }, {
                device: "ExteriorEquipment",
                GJ: '.$dataSet["ExteriorEquipment"].'
            }
			, {
                device: "Fans",
                GJ: '.$dataSet["Fans"].'
            }, {
                device: "Pumps",
                GJ: '.$dataSet["Pumps"].'
            }, {
                device: "HeatRejection",
                GJ: '.$dataSet["HeatRejection"].'
            }
			, {
                device: "WaterSystems",
                GJ: '.$dataSet["WaterSystems"].'
            }, {
                device: "Refrigeration",
                GJ: '.$dataSet["Refrigeration"].'
            }];


            AmCharts.ready(function () {
                // PIE CHART
                chart = new AmCharts.AmPieChart();

                // title of the chart
                chart.addTitle("Components Use Source '.$title.'[GJ] Summary", 16);

                chart.dataProvider = chartData;
                chart.titleField = "device";
                chart.valueField = "GJ";
                chart.sequencedAnimation = true;
                chart.startEffect = "elastic";
                chart.innerRadius = "30%";
                chart.startDuration = 2;
                chart.labelRadius = 15;

                // the following two lines makes the chart 3D
                chart.depth3D = 10;
                chart.angle = 15;

                // WRITE                                 
                chart.write("pie_chartdiv");
            });
        </script>
        
        <div class="right" id="pie_chartdiv" style="width:100%; height:600px;"></div>';

		return $pie;
	}
    
    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function pieMonthlyChart($dataSet) {
      $pieMonthly=' <script src="./amcharts.js" type="text/javascript"></script>        
            <script type="text/javascript">
                var chart;
                var legend;
                     
                var chartData = [{
                    month: "January",
                    energy_consumption: '.$dataSet[0].'
                }, {
                    month: "February",
                    energy_consumption: '.$dataSet[1].'
                }, {
                    month: "March",
                    energy_consumption: '.$dataSet[2].'
                }, {
                    month: "April",
                    energy_consumption: '.$dataSet[3].'
                }, {
                    month: "May",
                    energy_consumption: '.$dataSet[4].'
                }, {
                    month: "June",
                    energy_consumption: '.$dataSet[5].'
                }, {
                    month: "July",
                    energy_consumption: '.$dataSet[6].'
                }, {
                    month: "August",
                    energy_consumption: '.$dataSet[7].'
                }, {
                    month: "September",
                    energy_consumption: '.$dataSet[8].'
                }, {
                    month: "October",
                    energy_consumption: '.$dataSet[9].'
                }, {
                    month: "November",
                    energy_consumption: '.$dataSet[10].'
                }, {
                    month: "December",
                    energy_consumption: '.$dataSet[11].'
                }];
    
                AmCharts.ready(function () {
                    // PIE CHART
                    chart = new AmCharts.AmPieChart();
                    chart.dataProvider = chartData;
                    chart.titleField = "month";
                    chart.valueField = "energy_consumption";
    
                    // LEGEND
                    legend = new AmCharts.AmLegend();
                    legend.align = "center";
                    legend.markerType = "circle";
                    chart.addLegend(legend);
                    
                    // 3D
                    chart.depth3D = 10;
                    chart.angle = 10;
    
                    // WRITE
                    chart.write("chartdiv");
                });
    
                // changes label position (labelRadius)
                function setLabelPosition() {
                    if (document.getElementById("rb1").checked) {
                        chart.labelRadius = 30;
                        chart.labelText = "[[title]]: [[value]]";
                    } else {
                        chart.labelRadius = -30;
                        chart.labelText = "[[percents]]%";
                    }
                    chart.validateNow();
                }
    
                // changes switch of the legend (x or v)
                function setSwitch() {
                    if (document.getElementById("rb5").checked) {
                        legend.switchType = "x";
                    } else {
                        legend.switchType = "v";
                    }
                    legend.validateNow();
                }
            </script>
    
            <div id="chartdiv" style="width: 100%; height: 800px;"></div>;';
            return  $pieMonthly;
    }
    
    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function barMonthlyZoneChart($dataSet1, $dataSet2, $zone1, $zone2) {
        $bar='   <script src="./amcharts.js" type="text/javascript"></script>         
        <script type="text/javascript">
            var chart;

            var chartData = [{
                month: "January",
                zone1: '.$dataSet1[0].',
                zone2: '.$dataSet2[0].',
            }, {
                month: "February",
                zone1: '.$dataSet1[1].',
                zone2: '.$dataSet2[1].',
            }, {
                month: "March",
                zone1: '.$dataSet1[2].',
                zone2: '.$dataSet2[2].',
            }, {
                month:"April",
                zone1: '.$dataSet1[3].',
                zone2: '.$dataSet2[3].',
            }, {
                month: "May",
                zone1: '.$dataSet1[4].',
                zone2: '.$dataSet2[4].',
            } , {
                month: "June",
                zone1: '.$dataSet1[5].',
                zone2: '.$dataSet2[5].',
            }, {
                month: "July",
                zone1: '.$dataSet1[6].',
                zone2: '.$dataSet2[6].',
            }, {
                month: "August",
                zone1: '.$dataSet1[7].',
                zone2: '.$dataSet2[7].',
            }, {
                month: "September",
                zone1: '.$dataSet1[8].',
                zone2: '.$dataSet2[8].',
            }, {
                month: "October",
                zone1: '.$dataSet1[9].',
                zone2: '.$dataSet2[9].',
            }, {
                month: "November",
                zone1: '.$dataSet1[10].',
                zone2: '.$dataSet2[10].',
            }, {
                month: "December",
                zone1: '.$dataSet1[11].',
                zone2: '.$dataSet2[11].',
            } ];


            AmCharts.ready(function () {
                // SERIAL CHART
                chart = new AmCharts.AmSerialChart();
                chart.dataProvider = chartData;
                chart.categoryField = "month";
                chart.startDuration = 1;
                chart.plotAreaBorderColor = "#DADADA";
                chart.plotAreaBorderAlpha = 1;
                // this single line makes the chart a bar chart          
                chart.rotate = true;

                // AXES
                // Category
                var categoryAxis = chart.categoryAxis;
                categoryAxis.gridPosition = "start";
                categoryAxis.gridAlpha = 0.1;
                categoryAxis.axisAlpha = 0;

                // Value
                var valueAxis = new AmCharts.ValueAxis();
                valueAxis.axisAlpha = 0;
                valueAxis.gridAlpha = 0.1;
                valueAxis.position = "top";
                chart.addValueAxis(valueAxis);

                // GRAPHS
                // first graph
                var graph1 = new AmCharts.AmGraph();
                graph1.type = "column";
                graph1.title = "zone '.$zone1.'";
                graph1.valueField = "zone1";
                graph1.balloonText = "zone1:[[value]]";
                graph1.lineAlpha = 0;
                graph1.fillColors = "#ADD981";
                graph1.fillAlphas = 1;
                chart.addGraph(graph1);

                // second graph
                var graph2 = new AmCharts.AmGraph();
                graph2.type = "column";
                graph2.title = "zone '.$zone2.'";
                graph2.valueField = "zone2";
                graph2.balloonText = "zone2:[[value]]";
                graph2.lineAlpha = 0;
                graph2.fillColors = "#81acd9";
                graph2.fillAlphas = 1;
                chart.addGraph(graph2);

                // LEGEND
                var legend = new AmCharts.AmLegend();
                chart.addLegend(legend);

                // WRITE
                chart.write("monthly_data_chartdiv");
            });
        </script>

    

        <div id="monthly_data_chartdiv" style="width: 100%; height: 600px;"></div>';
        return $bar;   
    }
    
}

?>
