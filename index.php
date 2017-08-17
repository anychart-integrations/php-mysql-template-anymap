<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>AnyChart PHP template</title>
    <script src="https://cdn.anychart.com/js/latest/anychart-bundle.min.js"></script>
    <script src="http://cdn.anychart.com/js/latest/data-adapter.min.js"></script>
    <script src="https://code.jquery.com/jquery-latest.min.js"></script>
    <link rel="stylesheet" href="https://cdn.anychart.com/css/latest/anychart-ui.min.css"/>
    <link rel="stylesheet" href="static/css/style.css"/>
</head>
<body>
<div id="container"></div>
<div class="buttons-container">
    <button id="save" class="btn" value="selected">Reserve a ticket</button>
    <button id="un-save" class="btn" value="unSelected">Cancel reservation</button>
</div>
<script>
    anychart.data.loadJsonFile('/data.php', function (response) {  // init and draw chart
        var chart;
        var data = response;

        anychart.onDocumentReady(function () {
            var stage = acgraph.create('container');

            // get svg file
            $.ajax({
                type: 'GET',
                url: 'https://cdn.anychart.com/svg-data/seat-map/boeing_737.svg',
                // The data that have been used for this sample can be taken from the CDN
                // load SVG image using jQuery ajax
                success: function (svgData) {
                    data.map(function (item) {
                        if (item.selected === 'true') {
                            item.fill = 'orange';
                            item.stroke = '#eee';
                            item.hoverFill = 'red';
                            item.hoverStroke = '#eee';
                        }

                        delete item['selected'];

                        return item
                    });

                    chart = anychart.seatMap(data);
                    // set svg data,
                    chart.geoData(svgData);
                    chart.padding([105, 0, 20, 0]);
                    // load svg-file how it looked(colors stroke/fill except for elements of series)
                    chart.unboundRegions('as-is');

                    var series = chart.getSeries(0);
                    // sets fill series
                    series.fill(function () {
                        var attrs = this.attributes;

                        return attrs ? attrs.fill : this.sourceColor;
                    });
                    // sets stroke series
                    series.stroke(function () {
                            var attrs = this.attributes;

                            return attrs ? attrs.stroke : this.sourceColor;
                        });

                    // sets fill on hover series and select series
                    series.hoverFill(returnColorHoverAndSelect);
                    series.selectFill(returnColorHoverAndSelect);

                    // Create chart tooltip own title
                    series.tooltip()
                        .titleFormat('Place')
                        .format('{%Id}');

                    // create label zoom
                    var zoomLabel = chart.label(0);
                    zoomLabel.text('2x Zoom.')
                        .background('#9E9E9E')
                        .fontColor('#fff')
                        .padding(5)
                        .position('CenterTop')
                        .offsetX(5)
                        .offsetY(60);

                    zoomLabel.listen('click', function () {
                        // zoom map in 2 times
                        chart.zoom(2);
                    });

                    // set color for label hover
                    zoomLabel.listen('mouseOver', mouseOverLabel);
                    zoomLabel.listen('mouseOut', mouseOutLabel);

                    // create label zoom to
                    var zoomToLabel = chart.label(1);
                    zoomToLabel.text('1x Zoom.')
                        .background('#9E9E9E')
                        .fontColor('#fff')
                        .position('CenterTop')
                        .padding(5)
                        .offsetX(-75)
                        .offsetY(60);

                    zoomToLabel.listen('click', function () {
                        // zoomTo map
                        chart.zoomTo(1);
                    });

                    // set color for label hover
                    zoomToLabel.listen('mouseOver', mouseOverLabel);
                    zoomToLabel.listen('mouseOut', mouseOutLabel);

                    // label info
                    var labelInfo = chart.label(2);
                    labelInfo.useHtml(true)
                        .padding(10)
                        .hAlign('left')
                        .position('topLeft')
                        .anchor('topLeft')
                        .offsetY(25)
                        .offsetX(20)
                        .width(270);
                    labelInfo.background({
                        fill: '#FCFCFC',
                        stroke: '#E1E1E1',
                        corners: 3,
                        cornerType: 'ROUND'
                    });
                    labelInfo.text("<span style='color: #545f69; font-size: 14px'><b>Please select a location." +
                        "</b><br><br>You can do this by clicking on the<br>desired location , so you can select" +
                        "<br>multiple locations with the aid<br>of a combination of keys:<br><b><i>shift/ctrl" +
                        " + target place</i></b>.</span>").useHtml(true);

                    // add pointsSelect listener to get select place info
                    chart.listen('pointsSelect', function (points) {
                        var placesInfo = points.seriesStatus[0].points;
                        var placesId = [];

                        if (chart.getSelectedPoints().length) {

                            for (var i = 0; i < placesInfo.length; i++) {
                                placesId.push(points.seriesStatus[0].points[i].id);
                            }
                        }
                    });

                    // set container id for the chart
                    chart.container(stage);
                    // initiate chart drawing
                    chart.draw();
                }
            });
        });

        function returnColorHoverAndSelect() {
            return '#64b5f6';
        }

        function mouseOverLabel() {
            this.background(anychart.color.darken('#9E9E9E', 0.35));
        }

        function mouseOutLabel() {
            this.background('#9E9E9E');
        }

        $('#save, #un-save').on('click', function () {
            var placesId = [];
            var selectedPoints = chart.getSelectedPoints();

            if (selectedPoints.length) {
                for (var i = 0; i < selectedPoints.length; i++) {
                    placesId.push(selectedPoints[i].getStat('id'));
                }
            }

            var sendData = {};
            sendData[$(this).val()] = placesId;

            $.ajax({
                type: 'POST',
                url: '/save-data.php',
                data: sendData,
                success: function () {
                    anychart.data.loadJsonFile('/data.php', function (data) {
                        data.map(function (item) {
                            if (item.selected === 'true') {
                                item.fill = 'orange';
                                item.stroke = '#eee';
                                item.hoverFill = 'red';
                                item.hoverStroke = '#eee';
                            } else {
                                delete item.fill;
                                delete item.hoverFill;
                                delete item.stroke;
                                delete item.hoverStroke;
                            }

                            delete item['selected'];

                            return item
                        });

                        var series = chart.getSeries(0);
                        // set data
                        series.data(data);
                        series.unselect();
                    });
                }
            });
        });
    });
</script>
</body>
</html>


