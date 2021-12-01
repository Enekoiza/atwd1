<?php

//!EXAMPLE
//?http://localhost:8080/web-dev-project/XML_Generator.php?from=GBP&to=JPY&amount=10.35
//!-------




// $from = $_GET['from'];
// $to = $_GET['to'];
// $amount = $_GET['amount'];

// header('Content-Type:text/xml');
// $xml = new DOMDocument('1.0', 'utf-8');
// $conv = $xml->createElement('conv');

// $xml->appendChild($conv);
// $at = $xml->createElement('at', 12);
// $conv->appendChild($at);
// $rate = $xml->createElement('rate');
// $conv->appendChild($rate);


$xml = simplexml_load_file("XMLStore.xml");
$GBPValue = $xml->xpath('/store/currencies/currency');

print_r((string)$GBPValue[0]->code);

// echo $xml->saveXML();

?>