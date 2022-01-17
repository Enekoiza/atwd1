<?php

require_once("../Error_Handling.php");


function Update_Check_Errors($action, $cur)
{
    if((!isSet($action)) or (($action != "put") and ($action != "post") and ($action != "del")))
    {
        UpdateErrorFormat(2000, "Action not recognized or is missing",'NULL');
        exit();
    }
    if(!isSet($cur))
    {
        UpdateErrorFormat(2100, "Currency code in wrong format or is missing",$action);
        exit();
    }

    $xmlStorage = simplexml_load_file("../XMLStore.xml");

    $curCheck = $xmlStorage->xpath(sprintf('/store/currencies/currency[@code="%s"]', $cur));

    $liveCheck = $xmlStorage->xpath('/store/currencies/currency[@code="'. $cur . '"]/live');

    if((empty($curCheck)) or ($liveCheck[0] == 0 and $action == "put"))
    {
        UpdateErrorFormat(2200, "Currency code not found for update", $action);
        exit();
    }

    if($cur == "GBP")
    {
        UpdateErrorFormat(2400, "Cannot update the base currency", $action);
        exit();
    }


}



?>