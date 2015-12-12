<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

error_reporting(E_ALL);
// account : cdbdemo@gmail.com , password : c*********6#
//  print_r($_REQUEST);
//echo "php";
if (!empty($_REQUEST['query'])) {

    $detect = curl_init('http://ws.detectlanguage.com/0.2/detect?q=' . urlencode($_POST['query']) . '&key=a2bb2178f554fe9ae11f6e9dbc2a45c0');
    curl_setopt($detect, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($detect, CURLOPT_HEADER, false);

    $detectResponse = json_decode(curl_exec($detect));
    $langDetected = $detectResponse->data->detections[0]->language;
//    $langDetected = "fr";

    if (!empty($_REQUEST['to'])) {
        $translate = curl_init('http://www.worldlingo.com/S000.1/api?wl_srclang=auto&wl_trglang=' . $_REQUEST['to'] . '&wl_password=cdrao123456#&wl_mimetype=text%2Fhtml&wl_data=' . urlencode($_POST['query']));
        curl_setopt($translate, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($translate, CURLOPT_HEADER, false);
        $result = explode("\n", curl_exec($translate))[1];
    } else {

        $arrLang = ["en", "de", "fr", "ru", "ar"];

        $result[] = str_replace("#", "%23", $_POST['query']);
        $username = ["keval.goradia77@gmail.com","cdbdemo@gmail.com","cdbdemo1@gmail.com","cdbdemo1@gmail.com","cdbdem1o@gmail.com"];
        $password = ["cdrao123456#","cdrao123456#","cdrao123456#","cdrao123456#","cdrao123456#"];
        $fields_string = "";
        for ($i = 0; $i < 5; $i++) {

            if ($arrLang[$i] != $langDetected) {

                $url = 'http://www.frengly.com/';
                $fields = array(
                    'src' => 'en',
                    'dest' => 'fr',
                    'text' => urlencode($_POST['query']),
                    'outformat' => 'json',
//                    'email' => 'cdbdemo@gmail.com',
//                    'email' => 'keval.goradia77@gmail.com',
//                    'password' => 'cdrao123456#'
                    'email' => $username[$i],
                    'password' => $password[$i]
                );

//url-ify the data for the POST
                foreach ($fields as $key => $value) {
                    $fields_string .= $key . '=' . $value . '&';
                }
                rtrim($fields_string, '&');

//open connection
                $ch = curl_init();

//set the url, number of POST vars, POST data
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, count($fields));
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);


//                $translate[$i] = curl_init('http://www.worldlingo.com/S000.1/api?wl_srclang=auto&wl_trglang=' . $arrLang[$i] . '&wl_password=cdrao123456#&wl_mimetype=text%2Fhtml&wl_data=' . urlencode($_POST['query']));
//                $translate[$i] = curl_init('http://www.frengly.com/');
//                curl_setopt($translate[$i], CURLOPT_RETURNTRANSFER, true);
//                curl_setopt($translate[$i], CURLOPT_HEADER, false);
//                $result[] = str_replace("#", "%23", explode("\n", curl_exec($translate[$i]))[1]);
                $result[] = curl_exec($ch);
            }
        }
    }
//$result[5] = $langDetected;
//print_r($langDetected);
// echo 'hello';
    echo json_encode($result);
// print_r($result);
print_r($arrLang[0]);
}
?>

