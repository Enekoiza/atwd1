<?php



//!EXAMPLE
//?http://localhost:8080/atwd1/assignment/?from=EUR&to=GBP&amnt=12
//!-------

require_once "Config.php";
require_once "Error_Handling.php";
require_once "XML_Generator.php";


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