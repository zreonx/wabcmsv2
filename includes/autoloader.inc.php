<?php 
//built in php method to load classes
spl_autoload_register('autoLoader');

//create a function that will get the path of the classes as well as it names and extentions
function autoLoader ($className){
    $path = "../classes/";
    $ext = ".php"; 
    $fullPath = $path . $className . $ext;
    
    //check if the file exist
    if(!file_exists($fullPath)){
        return false;
    }

    //include once to prevent muliple classes paths
    include_once $fullPath;
}

?>