<?php

//!EXAMPLE
//?http://localhost:8080/atwd1/assignment/?from=EUR&to=GBP&amnt=12
//!-------

require_once "Config.php";
require_once "Error_Handling.php";
require_once "XML_Generator.php";

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


generateFormattedOutput($from, $to, $amnt, $format);


?>