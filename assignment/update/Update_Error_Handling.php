<?php

require_once("../Error_Handling.php");


function Update_Check_Errors($action, $cur)
{
    if((!isSet($action)) or (($action != "PUT") and ($action != "POST") and ($action != "DEL")))
    {
        errorFormat(2000, "Action not recognized or is missing");
        exit();
    }
    if(!isSet($cur))
    {
        errorFormat(2100, "Currency code in wrong format or is missing");
        exit();
    }

    $xmlStorage = simplexml_load_file("../XMLStore.xml");

    $curCheck = $xmlStorage->xpath(sprintf('/store/currencies/currency[@code="%s"]', $cur));

    if(empty($curCheck))
    {
        errorFormat(2200, "Currency code not found for update");
        exit();
    }

    if($cur == "GBP")
    {
        errorFormat(2400, "Cannot update the base currency");
        exit();
    }


}



?>