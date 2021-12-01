<?php

//!EXAMPLE
//?http://localhost:8080/web-dev-project/XML_Generator.php?from=GBP&to=JPY&amount=10.35
//!-------

require "Config.php";
require "database.php";



$from = $_GET['from'];
$to = $_GET['to'];
$amount = $_GET['amount'];

header('Content-Type:text/xml');
$xml = new DOMDocument('1.0', 'utf-8');
$conv = $xml->createElement('conv');

$xml->appendChild($conv);
$at = $xml->createElement('at', gmdate("Y-m-d H:i:s", CheckTimestamp(DBConnection($dbValues))));
$conv->appendChild($at);
$rate = $xml->createElement('rate');
$conv->appendChild($rate);


echo $xml->saveXML();



?>
