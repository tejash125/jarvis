<!doctype html>
<html>
    <head>
        <title>Chart</title>
        <style>
            body{
                padding: 0;
                margin: 0;
            }
            #canvas-holder{
                width:30%;
            }
            .doughnut-legend{
                list-style: none;
            }
            .doughnut-legend li span{
                display: inline-block;
                width: 12px;
                height: 12px;
                margin-right: 5px;
            }
        </style>
    </head>
    <body>
        <script src="assets/js/jquery.min.js"></script>
        <script type="text/javascript" src="assets/js/fusioncharts/js/fusioncharts.js"></script>
        <script type="text/javascript" src="assets/js/fusioncharts/js/themes/fusioncharts.theme.fint.js"></script>

        <script>

//            $(document).ready(function () {

                $('#chart1').html("");
                $('#chart2').html("");
                $('#chart3').html("");
                $('#chart4').html("");

                function createCharts(queries) {

                    var query = queries;
                    var queries = "";
                    var sentiment1 = 1, sentiment2 = 1, sentiment3 = 1, sentiment4 = 1, sentiment5 = 1;
                    $.ajax({
                        type: "POST",
                        url: "translation.php",
                        data: {query: query},
                        dataType: "json",
                        success: function (data) {
//                        console.log(data);
                            var queryObj = data;
                            var host = "http://uckk1cc36336.cbrahmbh.koding.io";
                            var solr = ":8983/solr/jarvis";
                            var requestHandler = "/select";
                            var limit = "&start=0&rows=500";
                            var responseType = "&wt=json&json.wrf=?&indent=true";
                            var dismax = "&defType=dismax&qf=text_en+text_de+text_ru+text_fr+text_ar";
                            $.each(queryObj, function (key, val) {
                                if (key + 1 == queryObj.length)
                                    queries += val;
                                else
                                    queries += val + " OR ";
                            });

//                        queries += "&personTag:obama";
//                        console.log(host + solr + requestHandler + "?q=" + encodeURI(queries) + limit + responseType + dismax);
                            $.getJSON(host + solr + requestHandler + "?q=" + encodeURI(queries) + limit + responseType + dismax, function (resp) {
//                        $.getJSON('temp2.json', function (resp) {

                                var persons = new Array();
                                var locations = new Array();
                                var organizations = new Array();
                                var personsObject = new Object();
                                var locationObject = new Object();
                                var orgObject = new Object();
                                var cnt = new Object();
                                var chartData = new Object();
                                var chartDataArr = new Array();
                                var chartDataArr2 = new Array();
                                var chartDataArr3 = new Array();
                                var chart1data = new Object();

                                $.each(resp['response']['docs'], function (key1, val1) {

                                    /* Pie Chart */
                                    if (val1['sentiment'] == 0) {
                                        sentiment1 = sentiment1 + 1;
                                    }
                                    else if (val1['sentiment'] == 1) {
                                        sentiment2 = sentiment2 + 1;
                                    }
                                    else if (val1['sentiment'] == 2) {
                                        sentiment3++;
                                    }
                                    else if (val1['sentiment'] == 3) {
                                        sentiment4++;
                                    }
                                    else if (val1['sentiment'] == 4) {
                                        sentiment5++;
                                    }

                                    if ((key1 + 1) == resp['response']['docs'].length) {

                                        chart1data = [
                                            {
                                                "label": "Very Positive",
                                                "value": sentiment5
                                            },
                                            {
                                                "label": "Positive",
                                                "value": sentiment4
                                            },
                                            {
                                                "label": "Neutral",
                                                "value": sentiment3
                                            },
                                            {
                                                "label": "Negative",
                                                "value": sentiment2
                                            },
                                            {
                                                "label": "Very Negative",
                                                "value": sentiment1
                                            }
                                        ];


                                    }

                                    /* Column Chart */


                                    if (typeof (val1['personTag']) != "undefined") {

                                        $.each(val1['personTag'], function (key2, val2) {

                                            if ($.inArray(val2, persons)) {

                                                if (typeof (cnt[val2]) == 'undefined')
                                                    cnt[val2] = 1;
                                                cnt[val2] = cnt[val2] + 1;
                                                if (cnt[val2] > 5)
                                                    personsObject[val2] = cnt[val2];
                                            }
                                            persons.push(val2);
                                        });
                                    }

                                    if (typeof (val1['locationTag']) != "undefined") {

                                        $.each(val1['locationTag'], function (key2, val2) {

                                            if ($.inArray(val2, persons)) {

                                                if (typeof (cnt[val2]) == 'undefined')
                                                    cnt[val2] = 1;
                                                cnt[val2] = cnt[val2] + 1;
                                                if (cnt[val2] > 5)
                                                    locationObject[val2] = cnt[val2];
                                            }
                                            locations.push(val2);
                                        });
                                    }

                                    if (typeof (val1['organizationTag']) != "undefined") {

                                        $.each(val1['organizationTag'], function (key2, val2) {

                                            if ($.inArray(val2, persons)) {

                                                if (typeof (cnt[val2]) == 'undefined')
                                                    cnt[val2] = 1;
                                                cnt[val2] = cnt[val2] + 1;
                                                if (cnt[val2] > 5)
                                                    orgObject[val2] = cnt[val2];
                                            }
                                            organizations.push(val2);
                                        });
                                    }

                                });


                                createChart('doughnut2d', chart1data, 'chart1');

                                $.each(personsObject, function (key3, val3) {
                                    chartDataArr.push({"label": key3.charAt(0).toUpperCase() + key3.slice(1), "value": val3}); //, "anchorImageUrl":"http://static.fusioncharts.com/sampledata/userimages/1.png"
                                });
                                createChart('column2d', chartDataArr, 'chart2');

                                $.each(locationObject, function (key3, val3) {
                                    chartDataArr2.push({"label": key3.charAt(0).toUpperCase() + key3.slice(1), "value": val3}); //, "anchorImageUrl":"http://static.fusioncharts.com/sampledata/userimages/1.png"
                                });
                                createChart('column2d', chartDataArr2, 'chart3');

                                $.each(orgObject, function (key3, val3) {
                                    chartDataArr3.push({"label": key3.charAt(0).toUpperCase() + key3.slice(1), "value": val3}); //, "anchorImageUrl":"http://static.fusioncharts.com/sampledata/userimages/1.png"
                                });
                                createChart('column2d', chartDataArr3, 'chart4');
                            });
                        }
                    });
                    function createChart(typeChart, data, container) {
//                    console.log(data);    
                        if (container == 'chart2') {
                            colors = "#0075c2";
                            title = "Popular Personalities";
                        }
                        else if (container == 'chart3') {
                            colors = "#0075c2";
                            title = "Location of Tweets";
                        }
                        else if (container == 'chart4') {
                            colors = "#0075c2";
                            title = "Organizations";
                        }
                        else {
                            colors = "#13AE0B,#2DD924,#CDE304,#FF1E4B,#E30430";
                            title = "Sentimental Analysis on Query Results";
                        }


                        var revenueChart = new FusionCharts({
                            type: typeChart,
                            renderAt: container,
                            width: '450',
                            height: '450',
                            dataFormat: 'json',
                            dataSource: {
                                "chart": {
                                    "caption": title,
                                    "subCaption": "",
                                    "xAxisName": "",
                                    "yAxisName": "",
                                    "paletteColors": colors,
                                    "valueFontColor": "#000000",
                                    "baseFont": "Helvetica Neue,Arial",
                                    "captionFontSize": "14",
                                    "subcaptionFontSize": "14",
                                    "subcaptionFontBold": "1",
                                    "bgColor": "#ffffff",
                                    "borderAlpha": 0
//                                "placeValuesInside": "1",
//                                "rotateValues": "1",
//                                "showShadow": "0",
//                                "divlineColor": "#999999",
//                                "divLineIsDashed": "1",
//                                "divlineThickness": "1",
//                                "divLineDashLen": "1",
//                                "divLineGapLen": "1",
//                                "canvasBgColor": "#CDE304"
                                },
                                "data": data
                            }
                        }).render();
                    }

                }
//            });


        </script>
    </body>
</html>
