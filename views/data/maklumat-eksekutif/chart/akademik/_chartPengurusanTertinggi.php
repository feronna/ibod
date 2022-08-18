<html>
<head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load("current", {
            packages: ["corechart"]
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                 ['Pengurusan Tertingii Akademik', 'Total'],
                <?php
                for ($i = 0; $i < count($array); $i++) {
                    echo "['" . $array[$i][0] . "'," . $array[$i][1] . "],";
                }
                ?>
            ]);

            var options = {
                title: 'PENGURUSAN TERTINGGI AKADEMIK',
                pieHole: 0.4,
                sliceVisibilityThreshold: 0.0001,
                width: '100%',
                height: '100%',
                pieSliceText: 'percentage',
                chartArea: {
                    right: "3%",
                    top: "10%",
                    height: "90%",
                    width: "90%"
                },
                pieStartAngle: 100,
            };

            var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
            chart.draw(data, options);
        }
    </script>
</head>

<body>
    <div id="donutchart" style="width: 900px; height: 500px;"></div>
</body>

</html>