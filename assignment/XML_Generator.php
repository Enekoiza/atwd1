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

//!---------------------------ERROR HANDLING---------------------------------
if((isSet($format)) and (isSet($from)) and (isSet($to)) and (isSet($amnt)))
{
    checkErrors($from, $to, $amnt, $format);
}
else
{
    checkErrors();
}
//!---------------------------ERROR HANDLING---------------------------------

$xmlStorage = simplexml_load_file("XMLStore.xml");

$from_data = $xmlStorage->xpath(sprintf('/store/currencies/currency[@code="%s"]', $from));
$to_data = $xmlStorage->xpath(sprintf('/store/currencies/currency[@code="%s"]', $to));

$rate_conv = $from_data[0]->rate * $to_data[0]->rate;
$final_amnt = $amnt * $rate_conv;



header('Content-Type:text/xml');
$xml = new DOMDocument('1.0', 'utf-8');
$xml_conv = $xml->createElement('conv');

$xml->appendChild($xml_conv);
$xml_at = $xml->createElement('at', getStoredTimestamp(true));
$xml_conv->appendChild($xml_at);
$xml_rate = $xml->createElement('rate', $rate_conv);
$xml_conv->appendChild($xml_rate);
$xml_from = $xml->createElement('from');
$xml_conv->appendChild($xml_from);
$xml_from_code = $xml->createElement('code', $from);
$xml_from->appendChild($xml_from_code);
$xml_from_curr = $xml->createElement('curr', $from_data[0]->name);
$xml_from->appendChild($xml_from_curr);
$xml_from_loc = $xml->createElement('loc', $from_data[0]->loc);
$xml_from->appendChild($xml_from_loc);
$xml_from_amnt = $xml->createElement('amnt', $amnt);
$xml_from->appendChild($xml_from_amnt);
$xml_to = $xml->createElement('to');
$xml_conv->appendChild($xml_to);
$xml_to_code = $xml->createElement('code', $to);
$xml_to->appendChild($xml_to_code);
$xml_to_curr = $xml->createElement('curr', $to_data[0]->name);
$xml_to->appendChild($xml_to_curr);
$xml_to_loc = $xml->createElement('loc', $to_data[0]->loc);
$xml_to->appendChild($xml_to_loc);
$xml_to_amnt = $xml->createElement('amnt', $final_amnt);
$xml_to->appendChild($xml_to_amnt);



echo $xml->saveXML();





?>