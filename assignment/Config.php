<?php





//!------------------------------FUNCTIONS----------------------------------------

//TODO Get the result from the currencies API as JSON file
function getAPIValues()
{
    $curl = curl_init();
    
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://freecurrencyapi.net/api/v2/latest?apikey=b27ddc90-4ba2-11ec-b5e3-3b0f15a88d0e",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_POSTFIELDS => "",
      CURLOPT_HTTPHEADER => array(
         "Content-Type: application/json",
         "cache-control: no-cache"
      ),
    ));
    
    $response = curl_exec($curl);
    
    curl_close($curl);
    
    $data = json_decode($response, true);
    
    
    return $data;
}

//TODO Returns the timestamp stored in the XML file
//TODO If passed true it will return the value formatted
function getStoredTimestamp($format = false)
{
    $xml = simplexml_load_file("XMLStore.xml");
    
    if($format == true)
    {
        return gmdate("Y-m-d H:i:s",(string)$xml->xpath('/store/timestamp')[0]);
    }

    return (string)$xml->xpath('/store/timestamp')[0];
}

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

$month = 20120;

echo date('M', strtotime($month . '06'));

?>
