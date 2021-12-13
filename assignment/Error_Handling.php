<?php

require_once "Config.php";


function errorFormat($errorCode, $errorMessage)
{
    header('Content-Type:text/xml');
    $xml = new DOMDocument('1.0', 'utf-8');
    $conv = $xml->createElement('conv');

    $xml->appendChild($conv);
    $xml_error = $xml->createElement('error');
    $conv->appendChild($xml_error);
    $xml_code = $xml->createElement('code', $errorCode);
    $xml_msg = $xml->createElement('msg', $errorMessage);
    $xml_error->appendChild($xml_code);
    $xml_error->appendChild($xml_msg);

    echo $xml->saveXML();
    
}

function UpdateErrorFormat($errorCode, $errorMessage, $act)
{
    header('Content-Type:text/xml');
    $xml = new DOMDocument('1.0', 'utf-8');
    $action = $xml->createElement('action');

    $xml->appendChild($action);
    $xml_error = $xml->createElement('error');
    $action->appendChild($xml_error);
    $xml_code = $xml->createElement('code', $errorCode);
    $xml_msg = $xml->createElement('msg', $errorMessage);
    $xml_error->appendChild($xml_code);
    $xml_error->appendChild($xml_msg);

    $action->setAttribute('type', $act);

    echo $xml->saveXML();
    
}


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

    if((!file_exists('XMLStore.xml')) or ($from == $to))
    {
        errorFormat(1500, 'Error in service');
        exit();
    }

    $xmlStorage = simplexml_load_file("XMLStore.xml");

    $fromCheck = $xmlStorage->xpath(sprintf('/store/currencies/currency[@code="%s"]', $from));

    $toCheck = $xmlStorage->xpath(sprintf('/store/currencies/currency[@code="%s"]', $to));

    $fromLiveCheck = $xmlStorage->xpath(sprintf('/store/currencies/currency[@code="%s"]/live', $from));

    $toLiveCheck = $xmlStorage->xpath(sprintf('/store/currencies/currency[@code="%s"]/live', $to));


    if((($fromCheck == NULL) or ($toCheck == NULL)) or (($fromLiveCheck[0] == 0) or ($toLiveCheck[0] == 0)))
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