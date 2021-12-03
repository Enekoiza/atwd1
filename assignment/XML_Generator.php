<?php

//!EXAMPLE
//?http://localhost:8080/web-dev-project/XML_Generator.php?from=GBP&to=JPY&amount=10.35
//!-------

require_once "Config.php";
require_once "Error_Handling.php";

// $xml = simplexml_load_file("XMLStore.xml");

// $currency_code = $xml->xpath('/store/currencies/currency');
// foreach ($currency_code as $currency)
// {
//     echo $currency[0]->code;
//     echo '</br>';
// } 
$format = "xml";

extract($_GET);
if((isSet($format)) and (isSet($from)) and (isSet($to)) and (isSet($amnt)))
{
    checkErrors($from, $to, $amnt, $format);
}
else
{
    checkErrors();
}



// header('Content-Type:text/xml');
// $xml = new DOMDocument('1.0', 'utf-8');
// $conv = $xml->createElement('conv');

// $xml->appendChild($conv);
// $at = $xml->createElement('at', getStoredTimestamp(true));
// $conv->appendChild($at);
// $rate = $xml->createElement('rate');
// $conv->appendChild($rate);

// echo $xml->saveXML();





?>