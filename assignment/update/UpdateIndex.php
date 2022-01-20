<?php



//!-------------------EXAMPLE--------------------------
//?http://localhost:8080/atwd1/assignment/update/?cur=EUR&action=del
//!-----------------------------------------------------

require_once("../Config.php");
require_once("Update_Error_Handling.php");
require_once("../XML_Generator.php");

$xmlStorage = simplexml_load_file("../XMLStore.xml");


//Get the values from the URL
extract($_GET);

//Condition that must be surpassed, if not an error output will be generated as xml and it will kill the program
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


//Different types of updates
if($action == "del")
{

    $rqstedCur = $xmlStorage->xpath('/store/currencies/currency[@code="' . $cur . '"]');
    $rqstedCur[0]->live = 0;

    $xmlStorage->saveXML("../XMLStore.xml");


    echo DeleteLiveValue($xmlStorage, $cur);

}
else if($action == "post")
{
    $rqstedCur = $xmlStorage->xpath('/store/currencies/currency[@code="' . $cur . '"]');
    $rqstedCur[0]->live = 1;
    
    $xmlStorage->saveXML("../XMLStore.xml");

    echo PostLiveValue($xmlStorage, $cur);

}
else
{
    $rqstedCur = $xmlStorage->xpath('/store/currencies/currency[@code="' . $cur . '"]');
    $oldRate = $rqstedCur[0]->rate;

    $newRate = getAPIValues()['data'][$cur];
    $GBPRate = getAPIValues()['data']['GBP'];
    $newRate = $newRate/$GBPRate;

    $rqstedCur[0]->rate = $newRate;
    $xmlStorage->saveXML("../XMLStore.xml");

    echo PutLiveValue($xmlStorage, $cur, $oldRate, $newRate);
    

}

?>