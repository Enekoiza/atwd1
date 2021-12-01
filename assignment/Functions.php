<?php


function getAPIValues(){
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

?>
