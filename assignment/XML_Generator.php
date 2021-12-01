<?php

//!EXAMPLE
//?http://localhost:8080/web-dev-project/XML_Generator.php?from=GBP&to=JPY&amount=10.35
//!-------

require "database.php";

$xml = simplexml_load_file("XMLStore.xml");

$currency_code = $xml->xpath('/store/currencies/currency');
foreach ($currency_code as $currency)
{
    echo $currency[0]->code;
    echo '</br>';
} 



// $from = $_GET['from'];
// $to = $_GET['to'];
// $amount = $_GET['amount'];

// header('Content-Type:text/xml');
// $xml = new DOMDocument('1.0', 'utf-8');
// $conv = $xml->createElement('conv');

// $xml->appendChild($conv);
// $at = $xml->createElement('at', getStoredTimestamp(true));
// $conv->appendChild($at);
// $rate = $xml->createElement('rate');
// $conv->appendChild($rate);




// print_r($timestamp);

// print_r((string)$currency_code[0]->code);

echo $xml->saveXML();

?>