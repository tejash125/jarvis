<!doctype html>
<html>
    <head>
        <title>Doughnut Chart</title>
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
        <div id="canvas-holder">
            <canvas id="chart-area" width="500" height="500"/>
        </div>

        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/Chart.js"></script>

        <script>

            $(document).ready(function () {


                var query = "ISIS";
                var queries = "";
                var sentiment1 = 1, sentiment2 = 1, sentiment3 = 1, sentiment4 = 1, sentiment5 = 1;
                $.ajax({
                    type: "POST",
                    url: "translation.php",
                    data: {query: query},
                    dataType: "json",
                    success: function (data) {
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
//                        console.log(host + solr + requestHandler + "?q=" + encodeURI(queries) + limit + responseType + dismax);
                        $.getJSON(host + solr + requestHandler + "?q=" + encodeURI(queries) + limit + responseType + dismax,
                                function (resp) {
                                    $.each(resp['response']['docs'], function (key1, val1) {
//                                        console.log(key1 + "=>" + val1['sentiment']);
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

                                        if (key1 + 1 == resp['response']['docs'].length) {
                                            createChart(sentiment1, sentiment2, sentiment3, sentiment4, sentiment5);
                                        }
                                    });
//                                    console.log("Sentiment1:"+sentiment1);
//                                }).then(createChart(sentiment1, sentiment2, sentiment3, sentiment4, sentiment5));
                                });
                    }
                });
                //                  
                function createChart() {

                    var doughnutData = [
                        {
                            value: sentiment1,
                            color: "#F7464A",
                            highlight: "#FF5A5E",
                            label: "Very Negative"
                        },
                        {
                            value: sentiment2,
                            color: "#46BFBD",
                            highlight: "#5AD3D1",
                            label: "Negative"
                        },
                        {
                            value: sentiment3,
                            color: "#FDB45C",
                            highlight: "#FFC870",
                            label: "Neutral"
                        },
                        {
                            value: sentiment4,
                            color: "#949FB1",
                            highlight: "#A8B3C5",
                            label: "Positive"
                        },
                        {
                            value: sentiment5,
                            color: "#949FB1",
                            highlight: "#A8B3C5",
                            label: "Very Positive"
                        }

                    ];

                    var ctx = document.getElementById("chart-area").getContext("2d");
                    myDoughnut = new Chart(ctx).Doughnut(doughnutData, {responsive: true});
                    var html = myDoughnut.generateLegend();
                    $(html).appendTo('#canvas-holder');

                }
            });
//            window.onload = function () {
//            };



        </script>
    </body>
</html>
