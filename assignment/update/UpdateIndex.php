<?php

//!-------------------EXAMPLE--------------------------
//?http://localhost:8080/atwd1/assignment/update/?cur=EUR&action=PUT
//!-----------------------------------------------------

require_once("Update_Error_Handling.php");

$xmlStorage = simplexml_load_file("../XMLStore.xml");



extract($_GET);


//!---------------------------ERROR HANDLING---------------------------------

if((isSet($action)) and (isSet($cur)))
{
    Update_Check_Errors($action, $cur);
}
elseif((isSet($action)) and (!isSet($cur)))
{
    Update_Check_Errors($action, NULL);
}
elseif((!isSet($action)) and (isSet($cur)))
{
    Update_Check_Errors(NULL, $cur);
}
else
{
    Update_Check_Errors(NULL, NULL);
}
//!---------------------------ERROR HANDLING---------------------------------



if($action == "DEL")
{
    $doc = new DOMDocument();
    $doc->load("../XMLStore.xml");

    $xpath = new DOMXPath($doc);

    $element = $xpath->query('/store/currencies/currency[@code="' . $cur . '"]/live');
    var_dump($element->item(0));
    $element->item(0)->nodeValue = 0;

    $DELOutput = $doc->save("../XMLStore.xml");


}

?>