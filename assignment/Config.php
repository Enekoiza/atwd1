<?php




$currencies = array('AUD', 'BRL', 'CAD', 'CHF', 'CNY', 'DKK', 'EUR', 'GBP', 'HKD', 'HUF', 'INR', 'JPY', 'MXN', 'MYR', 'NOK', 'NZD', 'PHP', 'RUB', 'SEK', 'SGD', 'THB', 'TRY', 'USD', 'ZAR');

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

//TODO creates the XML file
function Create_XML($defaultLiveValues)
{
    if (filesize("XMLStore.xml") == 0) {
        clearstatcache();
        $xml = new DOMDocument();
        $xml_store = $xml->createElement('store');
        $xml->appendChild($xml_store);
        $xml_ts = $xml->createElement("timestamp", getAPIValues()['query']['timestamp']);
        $xml_store->appendChild($xml_ts);
        $xml_currencies = $xml->createElement("currencies");
        $xml_store->appendChild($xml_currencies);
        $GBPValue = getAPIValues()['data']['GBP'];

        foreach (getAPIValues()['data'] as $key => $value) {
            $xml_currency = $xml->createElement("currency");
            $xml_currencies->appendChild($xml_currency);
            $xml_currencycode = $xml->createElement("code", $key);
            $xml_currency->appendChild($xml_currencycode);
            $xml_currencyrate = $xml->createElement('rate', ($value / $GBPValue));
            $xml_currency->appendChild($xml_currencyrate);
            if (in_array($key, $defaultLiveValues)) {
                $xml_live = $xml->createElement("live", 1);
            } else {
                $xml_live = $xml->createElement("live", 0);
            }
            $xml_currency->appendChild($xml_live);
        }
        $xml->save("XMLStore.xml");
    } else {
        echo 'Time to update';
    }
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




?>
