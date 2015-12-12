<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

error_reporting(E_ALL);
// account : cdbdemo@gmail.com , password : c*********6#
//  print_r($_REQUEST);

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

        for ($i = 0; $i < 5; $i++) {
            
            if ($arrLang[$i] != $langDetected) {
                $translate[$i] = curl_init('http://www.worldlingo.com/S000.1/api?wl_srclang=auto&wl_trglang=' . $arrLang[$i] . '&wl_password=cdrao123456#&wl_mimetype=text%2Fhtml&wl_data=' . urlencode($_POST['query']));
                curl_setopt($translate[$i], CURLOPT_RETURNTRANSFER, true);
                curl_setopt($translate[$i], CURLOPT_HEADER, false);
                $result[] = str_replace("#", "%23", explode("\n", curl_exec($translate[$i]))[1]);
            }
        }
    }
//$result[5] = $langDetected;
//print_r($langDetected);
// echo 'hello';
    echo json_encode($result);
// print_r($result);
//print_r($arrLang[0]);
}
?>

