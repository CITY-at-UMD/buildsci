<html>
<script src="./amcharts.js" type="text/javascript"></script>

</html>


<?php
    
    // AMCHARTS(JAVASCRIPT) IN PHP FORM   
    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function pieMonthlyChart($dataSet) {
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
            <div id="pieMonthlyChartdiv" style="width: 50%; height: 50%"></div>';
            return  $pieMonthly;
    }
    
    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function barMonthlyZoneChart($dataSet1, $dataSet2, $zone1, $zone2) {
        $bar='         
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
                chart.write("asdf");
            });
        </script>

        <div id="asdf" style="width: 50%; height: 50%"></div>';
        return $bar;   
    }
    
    $data = array(
        "0" => "10",
        "1" => "10",
        "2" => "10",
        "3" => "10",
        "4" => "10",
        "5" => "10",
        "6" => "10",
        "7" => "10",
        "8" => "10",
        "9" => "10",
        "10" => "10",
        "11" => "10"
    );
    
    echo pieMonthlyChart($data);
    echo barMonthlyZoneChart($data, $data, 1, 2);
?>