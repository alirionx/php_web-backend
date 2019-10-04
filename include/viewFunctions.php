<?php

//--------------------

function view_appFrame(){

    $frameHTML = file_get_contents("content/app.html");
    echo $frameHTML;
}

//--------------------



?>