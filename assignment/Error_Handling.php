<?php

require_once "XML_Generator.php";


function checkErrors($from = 0, $to = 0, $amnt = 0, $format = 0)
    {
    
    if(($from == 0) and ($to == 0) and ($amnt == 0) and ($format == 0))
    {
        errorFormat(1100, 'Parameter not recognized');
        exit();
    }


    if((!isSet($from)) or (!isSet($to)) or (!isSet($amnt)))
    {
        errorFormat(1000, 'Required parameter is missing');
        exit();
    }

    if(!file_exists('XMLStore.xml'))
    {
        errorFormat(1500, 'Error in service');
        exit();
    }

    $xmlStorage = simplexml_load_file("XMLStore.xml");

    $fromCheck = $xmlStorage->xpath(sprintf('/store/currencies/currency[@code="%s"]', $from));

    $toCheck = $xmlStorage->xpath(sprintf('/store/currencies/currency[@code="%s"]', $to));


    if(($fromCheck == NULL) or ($toCheck == NULL))
    {
        errorFormat(1200, "Currency type not recognized");
        exit();
    }


    
    if(!is_numeric($amnt))
    {
        errorFormat(1300, 'Currency amount must be a decimal number');
        exit();
    }

    if(($format != 'json') and ($format != 'xml'))
    {
        errorFormat(1400, 'Format must be xml or json');
        exit();
    }
    

}


?>