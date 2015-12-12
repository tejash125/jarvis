<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');
include("charts_fusion.php");
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Jarvis</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
        <link rel="stylesheet" href="assets/css/main.css" />
        <link rel="stylesheet" href="assets/css/scroll.css" />
        <link rel="stylesheet" href="assets/css/jquery-ui.css" />
        <!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
    </head>
    <body style="background: #ffffff">
        <!-- Header -->
        <section id="header">
            <!--<div id="hello" style="height:50%;overflow-y: scroll">-->
            <header>
                <h1 id="title">Jarvis</h1>
                <!--<form>-->
                <input id="searchbox" type="text" style="width:600px" /><br>
                <!--</form>-->
                <div id="resultsCount"  style="float: right;">

                </div>
            </header>
            <div id="loader" > <img id="loadingicon" src='images/ripple.gif' style="display: none;padding-top: 10%" /> </div>
            <div id="filtersDiv" style="display:none;float: left; width: 13%;height: 400px;overflow-y: overlay; cursor: pointer">
                <ul class="collapsibleList" data-role="listview" >
                    <li id='personList'>
                        PERSON
                    </li>
                    <li id='locationList'>
                        LOCATION
                    </li>
                    <li id='orgList'>
                        ORGANIZATION
                    </li>
                </ul>
                <div style="float: left; width: 100%; cursor: pointer">
                    <button id="chartsBtn" >Charts </button>
                </div>
            </div>
            <br>

            <div id="resultsDiv" class="container box style3" style="display: none;background: #ffffff; overflow-y: scroll;height: 520px;color: #000000; float: right;margin-right: 10px;">

                <table border="1" id="resultsTbl" cellspacing="10" style="word-break: break-all;text-align: center">
                    <tr>
                        <td style="text-align: left; padding: 15px" >
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book 
                            <br> 
                        </td>
                        <td style="vertical-align: middle;  padding: 15px" > 
<?php
$matches = array();
preg_match('/^(?:https?:\/\/)?(?:[^@\n]+@)?(?:www\.)?([^:\/\n]+)/', "https://exceljet.net/formula/get-domain-name-from-url", $matches);
?>
                            <a href="https://exceljet.net/formula/get-domain-name-from-url" > <img src="<?php echo $matches[0] . "/favicon.ico" ?>" /> 
                                <br>
                                https://exceljet.net/formula/get-domain-name-from-url
                            </a>
                        </td>
                    </tr>

                </table>

                <div id="chartsDiv">
                    <div id="chart1" style="float: left;"></div>
                    <div id="chart2" style="float: right;"></div>
                    <div id="chart3" style="float: left;"></div>
                    <div id="chart4" style="float: right;"></div>
                </div>

            </div>
            <div id="paging"  style="float: left;margin-top: -20px;" >

            </div>

        </section>

        <!-- Banner -->


        <!-- Scripts -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/jquery.scrolly.min.js"></script>
        <script src="assets/js/jquery.poptrox.min.js"></script>
        <!--<script src="assets/js/jquery.mobile-1.4.5.min.js"></script>-->
        <!--<script src="assets/js/jquery-ui.js"></script>-->
        <script src="assets/js/skel.min.js"></script>
        <script src="assets/js/util.js"></script>
        <!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
        <script src="assets/js/jquery.translate.js"/></script>
    <script src="assets/js/main.js"></script>
    <script type="text/javascript" src="assets/js/CollapsibleLists.js"></script>

    <script>

        $(document).ready(function () {

            CollapsibleLists.apply();
            $('#searchbox').focus();
            $('#header').css("padding", "0px !important");

            $('#searchbox').val("<?php echo!empty($_GET['query']) ? $_GET['query'] : ""; ?>");

            $('#title').click(function () {
                window.location = window.location.href.split("?")[0];
            });

//                var e1 = jQuery.Event( 'keypress', { which: 13 } );
//                $("#searchbox").trigger(e1);
            var stopwords = ["http", "a", "able", "about", "above", "abst", "accordance", "according", "accordingly", "across", "act", "actually", "added", "adj", "adopted", "affected", "affecting", "affects", "after", "afterwards", "again", "against", "ah", "all", "almost", "alone", "along", "already", "also", "although", "always", "am", "among", "amongst", "an", "and", "announce", "another", "any", "anybody", "anyhow", "anymore", "anyone", "anything", "anyway", "anyways", "anywhere", "apparently", "approximately", "are", "aren", "arent", "arise", "around", "as", "aside", "ask", "asking", "at", "auth", "available", "away", "awfully", "b", "back", "be", "became", "because", "become", "becomes", "becoming", "been", "before", "beforehand", "begin", "beginning", "beginnings", "begins", "behind", "being", "believe", "below", "beside", "besides", "between", "beyond", "biol", "both", "brief", "briefly", "but", "by", "c", "ca", "came", "can", "cannot", "can't", "cause", "causes", "certain", "certainly", "co", "com", "come", "comes", "contain", "containing", "contains", "could", "couldnt", "d", "date", "did", "didn't", "different", "do", "does", "doesn't", "doing", "done", "don't", "down", "downwards", "due", "during", "e", "each", "ed", "edu", "effect", "eg", "eight", "eighty", "either", "else", "elsewhere", "end", "ending", "enough", "especially", "et", "et-al", "etc", "even", "ever", "every", "everybody", "everyone", "everything", "everywhere", "ex", "except", "f", "far", "few", "ff", "fifth", "first", "five", "fix", "followed", "following", "follows", "for", "former", "formerly", "forth", "found", "four", "from", "further", "furthermore", "g", "gave", "get", "gets", "getting", "give", "given", "gives", "giving", "go", "goes", "gone", "got", "gotten", "h", "had", "happens", "hardly", "has", "hasn't", "have", "haven't", "having", "he", "hed", "hence", "her", "here", "hereafter", "hereby", "herein", "heres", "hereupon", "hers", "herself", "hes", "hi", "hid", "him", "himself", "his", "hither", "home", "how", "howbeit", "however", "hundred", "i", "id", "ie", "if", "i'll", "im", "immediate", "immediately", "importance", "important", "in", "inc", "indeed", "index", "information", "instead", "into", "invention", "inward", "is", "isn't", "it", "itd", "it'll", "its", "itself", "i've", "j", "just", "k", "keep", "keeps", "kept", "keys", "kg", "km", "know", "known", "knows", "l", "largely", "last", "lately", "later", "latter", "latterly", "least", "less", "lest", "let", "lets", "like", "liked", "likely", "line", "little", "'ll", "look", "looking", "looks", "ltd", "m", "made", "mainly", "make", "makes", "many", "may", "maybe", "me", "mean", "means", "meantime", "meanwhile", "merely", "mg", "might", "million", "miss", "ml", "more", "moreover", "most", "mostly", "mr", "mrs", "much", "mug", "must", "my", "myself", "n", "na", "name", "namely", "nay", "nd", "near", "nearly", "necessarily", "necessary", "need", "needs", "neither", "never", "nevertheless", "new", "next", "nine", "ninety", "no", "nobody", "non", "none", "nonetheless", "noone", "nor", "normally", "nos", "not", "noted", "nothing", "now", "nowhere", "o", "obtain", "obtained", "obviously", "of", "off", "often", "oh", "ok", "okay", "old", "omitted", "on", "once", "one", "ones", "only", "onto", "or", "ord", "other", "others", "otherwise", "ought", "our", "ours", "ourselves", "out", "outside", "over", "overall", "owing", "own", "p", "page", "pages", "part", "particular", "particularly", "past", "per", "perhaps", "placed", "please", "plus", "poorly", "possible", "possibly", "potentially", "pp", "predominantly", "present", "previously", "primarily", "probably", "promptly", "proud", "provides", "put", "q", "que", "quickly", "quite", "qv", "r", "ran", "rather", "rd", "re", "readily", "really", "recent", "recently", "ref", "refs", "regarding", "regardless", "regards", "related", "relatively", "research", "respectively", "resulted", "resulting", "results", "right", "run", "s", "said", "same", "saw", "say", "saying", "says", "sec", "section", "see", "seeing", "seem", "seemed", "seeming", "seems", "seen", "self", "selves", "sent", "seven", "several", "shall", "she", "shed", "she'll", "shes", "should", "shouldn't", "show", "showed", "shown", "showns", "shows", "significant", "significantly", "similar", "similarly", "since", "six", "slightly", "so", "some", "somebody", "somehow", "someone", "somethan", "something", "sometime", "sometimes", "somewhat", "somewhere", "soon", "sorry", "specifically", "specified", "specify", "specifying", "state", "states", "still", "stop", "strongly", "sub", "substantially", "successfully", "such", "sufficiently", "suggest", "sup", "sure", "t", "take", "taken", "taking", "tell", "tends", "th", "than", "thank", "thanks", "thanx", "that", "that'll", "thats", "that've", "the", "their", "theirs", "them", "themselves", "then", "thence", "there", "thereafter", "thereby", "thered", "therefore", "therein", "there'll", "thereof", "therere", "theres", "thereto", "thereupon", "there've", "these", "they", "theyd", "they'll", "theyre", "they've", "think", "this", "those", "thou", "though", "thoughh", "thousand", "throug", "through", "throughout", "thru", "thus", "til", "tip", "to", "together", "too", "took", "toward", "towards", "tried", "tries", "truly", "try", "trying", "ts", "twice", "two", "u", "un", "under", "unfortunately", "unless", "unlike", "unlikely", "until", "unto", "up", "upon", "ups", "us", "use", "used", "useful", "usefully", "usefulness", "uses", "using", "usually", "v", "value", "various", "'ve", "very", "via", "viz", "vol", "vols", "vs", "w", "want", "wants", "was", "wasn't", "way", "we", "wed", "welcome", "we'll", "went", "were", "weren't", "we've", "what", "whatever", "what'll", "whats", "when", "whence", "whenever", "where", "whereafter", "whereas", "whereby", "wherein", "wheres", "whereupon", "wherever", "whether", "which", "while", "whim", "whither", "who", "whod", "whoever", "whole", "who'll", "whom", "whomever", "whos", "whose", "why", "widely", "willing", "wish", "with", "within", "without", "won't", "words", "world", "would", "wouldn't", "www", "x", "y", "yes", "yet", "you", "youd", "you'll", "your", "youre", "yours", "yourself", "yourselves", "you've", "z", "zero"];
            $('#searchbox').keyup(function (e) {

//                    if ((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 96 && e.keyCode <= 111) || (e.keyCode >= 65 && e.keyCode <= 90) || e.keyCode == 8 || e.keyCode == 13)


                if (queryLength == 0) {
                    $("#loadingicon").hide();
                    $("#resultsDiv").hide();
                    $("#resultsCount").hide();
                    $("#filtersDiv").hide();
                }
                else {
                    if (e.keyCode == 13)
                    {
                        var query = $('#searchbox').val();
                        var queryLength = query.length;
                        var queries = "";
                        var cnt = 0;

                        var host = "http://uckk1cc36336.cbrahmbh.koding.io";
                        var solr = ":8983/solr/jarvis";
                        var requestHandler = "/select";
                        var limit = "&start=0&rows=500";
                        var responseType = "&wt=json&json.wrf=?&indent=true";
                        var dismax = "&defType=dismax&qf=text_en+text_de+text_ru";
                        var facet = "&facet=true&facet.field=personTag&facet.field=locationTag&facet.field=organizationTag&facet.method=enum";

                        $("#loadingicon").show();
                        $("#resultsDiv").hide();
                        $("#resultsTbl").show();
                        $("#resultsCount").hide();
                        $("#filtersDiv").hide();
                        $("#resultsCount").empty();
                        $("#resultsTbl").empty();
                        $("#topResults").empty();
                        $("#personList").empty();
                        $("#orgList").empty();
                        $("#locationList").empty();
//                            alert("ere");
                        $.ajax({
                            type: "POST",
                            url: "translation.php",
                            data: {query: query},
                            dataType: "json",
                            success: function (data) {

                                var queryObj = data;
                                // console.log(queryObj);
                                $.each(queryObj, function (key, val) {
                                    if (key + 1 == queryObj.length)
                                        queries += val;
                                    else
                                        queries += val + " OR ";
                                });
//                                    console.log(host + solr + requestHandler + "?q=" + encodeURI(queries) + limit + responseType + dismax + facet);
                                $.getJSON(host + solr + requestHandler + "?q=" + encodeURI(queries) + limit + responseType + dismax + facet,
//                                    $.getJSON('temp2.json',
                                        function (data) {

                                            var html = "<col width='20px' /> <col width='500px' />";
                                            var htmlTopResults = "";
                                            var facetsHtml = "<<thead>><td> <b>FILTERS</b> <br><br> </td></<thead>>";
                                            var orgLi = "ORGANIZATION";
                                            var personLi = "PERSON";
                                            var locationLi = "LOCATION";

                                            $.each(data['response']['docs'], function (key1, val1) {
                                                html += "<tr class='resultRow'>";
                                                cnt++;
//                                                    summaryhtml += "<tr>"; 
                                                $.each(val1, function (key2, val2) {
//                                                
                                                    if ((key2 == "text_en" || key2 == "text_de" || key2 == "text_ru") && val2 != "") {

                                                        html += "<td id='summarycol_" + cnt + "' colspan='5' width='100px' style='text-align: left; padding: 15px' >" + val2;

                                                        html += "<button class='translateBtns' lang='ar' id='btn_ar_" + cnt + "' style='background: url(\"images/button_ar.png\")' /> "
                                                                + "<button class='translateBtns' lang='fr' id='btn_fr_" + cnt + "' style='background: url(\"images/button_fr.png\")' /> "
                                                                + "<button class='translateBtns' lang='ru' id='btn_ru_" + cnt + "' style='background: url(\"images/button_ru.png\")' /> "
                                                                + "<button class='translateBtns' lang='de' id='btn_de_" + cnt + "' style='background: url(\"images/button_de.png\")' /> "
                                                                + "<button class='translateBtns' lang='en' id='btn_en_" + cnt + "' style='background: url(\"images/button_en.png\")' /> "
                                                    }
                                                    else if (key2 == "organizationTag" || key2 == "personTag" || key2 == "locationTag") {


                                                        html += "<br>";

                                                        var splitTags = val2.toString().split(",");
                                                        $.each(splitTags, function (tagI, tagV) {
                                                            html += "<a href='#' >" + tagV + "</a>";

                                                            if (tagI + 1 != splitTags.length) {
                                                                html += ",";
                                                            }

//                                                                if (key2 == "organizationTag") {
//                                                                    orgLi += "<li> " + tagV + "</li>";
//                                                                }
//                                                                else if (key2 == "personTag") {
//                                                                    personLi += "<li> " + tagV + "</li>";
//                                                                }
//                                                                else if (key2 == "locationTag") {
//                                                                    locationLi += "<li> " + tagV + "</li>";
//                                                                }
                                                        });

                                                        html += "</td>";

                                                    }
                                                    else if (key2 == "tweet_urls") {
                                                        var res = val2.toString().match(/^(?:https?:\/\/)?(?:[^@\n]+@)?(?:www\.)?([^:\/\n]+)/);
                                                        html += "<td colspan='2' width='20px' style='vertical-align: middle; padding: 15px' >"
                                                                + "<a href=" + val2 + " > <img width='20px' height='20px' src='" + res[0] + "/favicon.ico' /> <br>"
//                                                            + "<a href=" + val2 + " > <img src='https://twitter.com/favicon.ico' /> <br>"
                                                                + val2 + "</a>"
                                                                + "</td>";
                                                    }

                                                });

                                                html += "</tr>";
                                            });


                                            // Facets
                                            $.each(data['facet_counts']['facet_fields']['personTag'], function (key, val) {
                                                count = data['facet_counts']['facet_fields']['personTag'][key + 1];
                                                if (val.length > 3 && count >= 8 && stopwords.indexOf(val) == -1) {
                                                    personLi += "<li><a target='_blank' href='" + host + "/projc/WebContent/ui.php?query=" + query + " AND " + val + "' >" + val + " (" + count + ") </a></li>";
                                                }
                                            });
                                            $.each(data['facet_counts']['facet_fields']['locationTag'], function (key, val) {
                                                count = data['facet_counts']['facet_fields']['locationTag'][key + 1];
                                                if (val.length > 3 && count >= 8 && stopwords.indexOf(val) == -1) {
                                                    locationLi += "<li><a target='_blank' href='" + host + "/projc/WebContent/ui.php?query=" + query + " AND " + val + "' >" + val + " (" + count + ") </a></li>";
                                                }
                                            });
                                            $.each(data['facet_counts']['facet_fields']['organizationTag'], function (key, val) {
                                                count = data['facet_counts']['facet_fields']['organizationTag'][key + 1];
                                                if (val.length > 3 && count >= 8 && stopwords.indexOf(val) == -1) {
                                                    orgLi += "<li><a target='_blank' href='" + host + "/projc/WebContent/ui.php?query=" + query + " AND " + val + "' >" + val + " (" + count + ") </a></li>";
                                                }
                                            });


                                            // Paging
                                            pagesHtml = "<br><br>";
                                            var pages = Math.ceil(data['response']['numFound'] / 10);
                                            for (i = 1; i <= pages; i++) {
                                                pagesHtml += "<a href='#'> " + i + "</a> ";
                                            }
                                            pagesHtml += "<br><br>";
                                            $('#resultsCount').html("Total Results: " + data['response']['numFound']);
                                            $('#resultsCount').show();
                                            $("#resultsDiv").show();
                                            $("#filtersDiv").show();
                                            $("#loadingicon").hide();
                                            $(html).appendTo("#resultsTbl");
                                            $(htmlTopResults).appendTo("#topResults");
                                            $(facetsHtml).appendTo("#facetsTbl");
//                                            console.log(personLi);
                                            $("<ul>" + personLi + "</ul>").appendTo('#personList');
                                            $("<ul>" + locationLi + "</ul>").appendTo('#locationList');
                                            $("<ul>" + orgLi + "</ul>").appendTo('#orgList');
//                                                $(pagesHtml).appendTo("#paging");
                                        });
                            }
                        });

                        var htmlCol = new Array();
                        $('#resultsTbl').on('click', '.translateBtns', function () {

                            var eleId = $(this);
                            var lang = eleId.attr("lang");
                            var parentId = eleId.parent("td");
                            $.ajax({
                                type: "POST",
                                url: "translation.php",
                                data: {query: parentId.text(), to: lang},
                                dataType: "json",
                                success: function (data) {
                                    data += "<br> <a href ='#' > tags </a> "
                                            + "<button class='translateBtns' lang='ar' id='btn_ar_" + cnt + "' style='background: url(\"images/button_ar.png\")' /> "
                                            + "<button class='translateBtns' lang='fr' id='btn_fr_" + cnt + "' style='background: url(\"images/button_fr.png\")' /> "
                                            + "<button class='translateBtns' lang='ru' id='btn_ru_" + cnt + "' style='background: url(\"images/button_ru.png\")' /> "
                                            + "<button class='translateBtns' lang='de' id='btn_de_" + cnt + "' style='background: url(\"images/button_de.png\")' /> "
                                            + "<button class='translateBtns' lang='en' id='btn_en_" + cnt + "' style='background: url(\"images/button_en.png\")' /> "
                                            + "</td>";
                                    $(parentId).html(data);
                                }
                            });
                        });


                        $('#resultsTbl').on('mouseover', 'tr', function () {
                            $(this).children().children(".translateBtns").show();
                        });

                        $('#resultsTbl').on('mouseleave', 'tr', function () {
                            $(this).children().children(".translateBtns").hide();
                        });

                        
                        $('#chartsBtn').unbind('click').on('click', function () {
//                            alert("herer");
                            $('#chartsDiv').hide();
                            $.ajax({
                                url: "charts_fusion.php",
                                data: {query: queries},
                                success: function (dataNew) {
                                    $('#resultsTbl').hide();
                                    $('#chartsDiv').show();
                                    createCharts(queries);
                                }
                            });
                        });

                    }
                }
            });


        });


    </script>
</body>
</html>

