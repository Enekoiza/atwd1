<?php

require_once "XML_Generator.php";


function checkErrors($from = 0, $to = 0, $amnt = 0, $format = 0)
    {
    
    if(($from == 0) and ($to == 0) and ($amnt == 0) and ($format == 0))
    {
        return errorFormat(1100, 'Parameter not recognized');
    }


    if((!isSet($from)) or (!isSet($to)) or (!isSet($amnt)))
    {
        return errorFormat(1000, 'Required parameter is missing');
    }

    if(!file_exists('XMLStore.xml'))
    {
        return errorFormat(1500, 'Error in service');
    }

    $xmlStorage = simplexml_load_file("XMLStore.xml");

    $fromCheck = $xmlStorage->xpath(sprintf('/store/currencies/currency[@code="%s"]', $from));

    $toCheck = $xmlStorage->xpath(sprintf('/store/currencies/currency[@code="%s"]', $to));


    if(($fromCheck == NULL) or ($toCheck == NULL))
    {

        return errorFormat(1200, "Currency type not recognized");

    }


    
    if(!is_numeric($amnt))
    {
        return errorFormat(1300, 'Currency amount must be a decimal number');
    }

    if(($format != 'json') and ($format != 'xml'))
    {
        return errorFormat(1400, 'Format must be xml or json');
    }
    

}


?>