<?php

// This php script is based on amcharts.js
// More Information, please visit http://www.amcharts.com/
class Graph{
        // GRAPH FOR THE DISPLAY OF THE SOURCE ENERGY SUMMARY
		// CONVERTING THE AMCHARTS(JAVASCRIPT) IN PHP FORM 
		public function barChart($totalSiteEnergy, $totalSourceEnergy, $naturalGasTotalEndUses, $electricityTotalEndUses) {
		$bar=' 		<script type="text/javascript">
					    var barChart;
					    var barChartData = [{
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
					        barChart = new AmCharts.AmSerialChart();
					        barChart.dataProvider = barChartData;
					        barChart.categoryField = "title";
					        barChart.startDuration = 1;
					        barChart.rotate = true;

					        // AXES
					        // category
					        var barChartcategoryAxis = barChart.categoryAxis;
					        barChartcategoryAxis.gridPosition = "start";
					        barChartcategoryAxis.axisColor = "#DADADA";
					        barChartcategoryAxis.dashLength = 5;

					        // value
					        var barChartvalueAxis = new AmCharts.ValueAxis();
					        barChartvalueAxis.dashLength = 5;
					        barChartvalueAxis.axisAlpha = 0.2;
					        barChartvalueAxis.position = "top";
					        barChartvalueAxis.title = "[MJ/m2]";
					        barChart.addValueAxis(barChartvalueAxis);

					        // GRAPHS
					        // column graph
					        var barChartgraph1 = new AmCharts.AmGraph();
					        barChartgraph1.type = "column";
					        barChartgraph1.title = "Total Site Energy";
					        barChartgraph1.valueField = "total_site";
					        barChartgraph1.lineAlpha = 0;
					        barChartgraph1.fillColors = "#ADD981";
					        barChartgraph1.fillAlphas = 1;
					        barChart.addGraph(barChartgraph1);

					        // line graph
					        var barChartgraph2 = new AmCharts.AmGraph();
					        barChartgraph2.type = "line";
					        barChartgraph2.title = "Net Site Energy";
					        barChartgraph2.valueField = "net_site";
					        barChartgraph2.lineThickness = 2;
					        barChartgraph2.bullet = "round";
					        barChartgraph2.fillAlphas = 0;
					        barChart.addGraph(barChartgraph2);

					        // LEGEND
					        var barChartlegend = new AmCharts.AmLegend();
					        barChart.addLegend(barChartlegend);

					        // WRITE
					        barChart.write("bar_chartdiv");
					    });
					</script>

					<div id="bar_chartdiv" style="min-width: 480px; min-height: 360px; width: 50%; height: 50%"></div>';
		return $bar;
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////

	// GRAPH FOR THE DISPLAY OF THE ELECTRICITY AND NATURAL GAS ANNUAL USED
	// AMCHARTS(JAVASCRIPT) IN PHP FORM
    function pieChart($dataSet, $title) {
    
            $pie= ' <script type="text/javascript">
            var '.$title.'pieChart;

            var '.$title.'pieChartData = [{
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
                '.$title.'pieChart = new AmCharts.AmPieChart();

                // title of the chart
                '.$title.'pieChart.addTitle("Components Use Source '.$title.'[GJ] Summary", 16);

                '.$title.'pieChart.dataProvider = '.$title.'pieChartData;
                '.$title.'pieChart.titleField = "device";
                '.$title.'pieChart.valueField = "GJ";
                '.$title.'pieChart.sequencedAnimation = true;
                '.$title.'pieChart.startEffect = "elastic";
                '.$title.'pieChart.innerRadius = "30%";
                '.$title.'pieChart.startDuration = 2;
                '.$title.'pieChart.labelRadius = 15;

                // the following two lines makes the chart 3D
                '.$title.'pieChart.depth3D = 10;
                '.$title.'pieChart.angle = 15;

                // WRITE                                 
                '.$title.'pieChart.write("'.$title.'pie_chartdiv");
            });
        </script>
        
        <div id="'.$title.'pie_chartdiv" style="min-width: 480px; min-height: 360px; width: 50%; height: 50%"></div>';
		return $pie;
	}
    
    public function refresshPMC () {
        printf("pieMonthlyChart.validateData();");    
    
    }
    public function refresh() {
        return "pieMonthlyChart.validateData();";
        
    }
    
    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function pieMonthlyChart($dataSet) {
      $pieMonthly='       
            <script type="text/javascript">
                var pieMonthlyChart;
                var pieMonthlylegend;
                     
                var pieMonthlyChartData = [{
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
                    pieMonthlyChart = new AmCharts.AmPieChart();
                    pieMonthlyChart.dataProvider = pieMonthlyChartData;
                    pieMonthlyChart.titleField = "month";
                    pieMonthlyChart.valueField = "energy_consumption";
    
                    // LEGEND
                    pieMonthlylegend = new AmCharts.AmLegend();
                    pieMonthlylegend.align = "center";
                    pieMonthlylegend.markerType = "circle";
                    pieMonthlyChart.addLegend(pieMonthlylegend);
                    
                    // 3D
                    pieMonthlyChart.depth3D = 10;
                    pieMonthlyChart.angle = 10;
    
                    // WRITE
                    pieMonthlyChart.write("pieMonthlyChartdiv");
                }); 
            </script>
            <div id="pieMonthlyChartdiv" style="min-width: 480px; min-height: 360px; width: 50%; height: 50%"></div>';
            return  $pieMonthly;
    }
    
    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function barMonthlyZoneChart($dataSet1, $dataSet2, $zone1, $zone2) {
        $bar=' <script type="text/javascript">
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

        <div id="monthly_data_chartdiv" style="min-width: 480px; min-height: 360px; width: 50%; height: 50%"></div>';
        return $bar;   
    }
    
}

?>
