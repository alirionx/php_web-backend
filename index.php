<?php

//---Some Globals and Initiators--------------------------------------------------------

session_start();
$curHost = $_SERVER['SERVER_NAME'];
$curUrl  = $_SERVER['REQUEST_URI'];
$curPath = parse_url($curUrl, PHP_URL_PATH);

//--------------------------------------------------------------------------------------


//---The URL Router---------------------------------------------------------------------

$pathArray = [
    '\/' => 'apiWelcome',
    '\/api\/table\/get\/(.*)' => 'tableGet',
];

$keys = array_map('strlen', array_keys($pathArray));
array_multisort($keys, SORT_DESC, $pathArray);

//--------------------

foreach($pathArray as $pathPat => $func){
    $matchCHK = false;
    if( preg_match('/'.$pathPat.'/i', $curPath, $matches, PREG_OFFSET_CAPTURE) ){
        unset($matches[0]);
        $varAry = [];
        foreach($matches as $var){
            array_push($varAry, $var[0]);
        }
        $func($varAry);
        $matchCHK = true;
        break;
    }
}
if( $matchCHK == false){
    echo "invalid path or path not found";
    header("HTTP/1.0 404 Not Found");
}
//--------------------------------------------------------------------------------------


//---Little Helpers---------------------------------------------------------------------

function arrayToJSON($array, $pretty=false){
    if($pretty == true){
        $resJSON = json_encode($array, JSON_PRETTY_PRINT);
    }
    else{
        $resJSON = json_encode($array);
    }
    return $resJSON;
}
//--------------------------------------------------------------------------------------


//---The Functions per Path-------------------------------------------------------------

function apiWelcome(){
    echo "Web Application Backend Frame incl. Rest API - written in PHP";
}

//--------------------

function tableGet($varAry){
    //echo"<pre>" . arrayToJSON($varAry, true);
    echo"<pre>".print_r($varAry,true)."</pre>";
}
//--------------------------------------------------------------------------------------


?>