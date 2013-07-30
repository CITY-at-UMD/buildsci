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

					<div class="bottom" id="bar_chartdiv" style="width: 500px; height: 600px;"></div>';

		return $bar;
	}

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
        <div class="right" id="pie_chartdiv" style="width:600px; height:400px;"></div>';

		return $pie;
	}
}

?>
