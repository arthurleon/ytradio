<?php
require_once '_app/config.inc.php';
// get the q parameter from URL
$q = filter_input(INPUT_GET, "q");

$songname = "";

// lookup all songnames from array if $q is different from "" 
if ($q !== "") {    
    $audioclips = new Read;
    $audioclips->ExeRead('audioclip', "WHERE url LIKE '%{$q}'");
    
    foreach ($audioclips->getResult() as $audioclip){       
        $songname = $audioclip['songname'];
    }    
}

// Output "couldn't get song name :(" if no songname was found or output correct values
// Need to use == instead of === because sometimes it's nill
echo $songname == "" ? "couldn't get song name :(" : $songname;