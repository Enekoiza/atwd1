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
function getStoredTimestamp($format = false, $stored = false, $xml)
{
    // $xml = simplexml_load_file("XMLStore.xml");
    
    if($format == true and $stored == true)
    {
        return gmdate("Y-M-d H:i:s",(string)$xml->xpath('/store/timestamp')[0]);
    }
    else if($format == true and $stored == false)
    {
        return gmdate("Y-M-d H:i:s",time());
    
    }

    return (string)$xml->xpath('/store/timestamp')[0];
}





?>
