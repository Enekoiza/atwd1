<?php



//!EXAMPLE
//?http://localhost:8080/atwd1/assignment/?from=EUR&to=GBP&amnt=12
//!-------

require_once "Config.php";
require_once "Error_Handling.php";
require_once "XML_Generator.php";

//The default format is xml
$format = "xml";

//Extracting the value from the URL
extract($_GET);

//A condition that must be surpassed to see the correct output, if it does not pass it will print the correct xml and kill the program
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

//Check if the timestamp has less than 2h difference from the current time if true update all the values and change ts in the xml file, if not just return
checkAndUpdate($xml);

//Once the error handling is surpassed create the xml or json output.
generateFormattedOutput($from, $to, $amnt, $format);

?>