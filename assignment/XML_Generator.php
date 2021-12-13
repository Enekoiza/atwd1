<?php

require_once "Config.php";

function generateFormattedOutput($from, $to, $amnt, $format)
{
    $xmlStorage = simplexml_load_file("XMLStore.xml");

    $from_data = $xmlStorage->xpath(sprintf('/store/currencies/currency[@code="%s"]', $from));
    $to_data = $xmlStorage->xpath(sprintf('/store/currencies/currency[@code="%s"]', $to));
    
    $final_amnt = ($amnt * $to_data[0]->rate) / $from_data[0]->rate;
    $rate_conv = $from_data[0]->rate * $to_data[0]->rate;

    if($format == "xml")
    {
        // $final_amnt = $amnt * $rate_conv;
    

        header('Content-Type:text/xml');
        $xml = new DOMDocument('1.0', 'utf-8');
        $xml_conv = $xml->createElement('conv');
    
        $xml->appendChild($xml_conv);
        $xml_at = $xml->createElement('at', getStoredTimestamp(true,true, $xmlStorage));
        $xml_conv->appendChild($xml_at);
        $xml_rate = $xml->createElement('rate', $rate_conv);
        $xml_conv->appendChild($xml_rate);
        $xml_from = $xml->createElement('from');
        $xml_conv->appendChild($xml_from);
        $xml_from_code = $xml->createElement('code', $from);
        $xml_from->appendChild($xml_from_code);
        $xml_from_curr = $xml->createElement('curr', $from_data[0]->name);
        $xml_from->appendChild($xml_from_curr);
        $xml_from_loc = $xml->createElement('loc', $from_data[0]->loc);
        $xml_from->appendChild($xml_from_loc);
        $xml_from_amnt = $xml->createElement('amnt', $amnt);
        $xml_from->appendChild($xml_from_amnt);
        $xml_to = $xml->createElement('to');
        $xml_conv->appendChild($xml_to);
        $xml_to_code = $xml->createElement('code', $to);
        $xml_to->appendChild($xml_to_code);
        $xml_to_curr = $xml->createElement('curr', $to_data[0]->name);
        $xml_to->appendChild($xml_to_curr);
        $xml_to_loc = $xml->createElement('loc', $to_data[0]->loc);
        $xml_to->appendChild($xml_to_loc);
        $xml_to_amnt = $xml->createElement('amnt', $final_amnt);
        $xml_to->appendChild($xml_to_amnt);
    
    
    
        echo $xml->saveXML();
    }
    elseif($format == "json")
    {

        $from_array = array(
                    "code" => $from,
                    "curr" => (string)$from_data[0]->name,
                    "loc" => (string)$from_data[0]->loc,
                    "amnt" => $amnt,
        );

        $to_array = array(
                    "code" => $to,
                    "curr" => (string)$to_data[0]->name,
                    "loc" => (string)$to_data[0]->loc,
                    "amnt" => $final_amnt,
        );


        $conv = array(
                    "at" => getStoredTimestamp(true,true, $xmlStorage),
                    "rate" => $rate_conv,
                    "from" => $from_array,
                    "to" => $to_array,

        );

        $final_array = array("conv" => $conv);

        header('Content-Type: application/json');
        $output = json_encode($final_array,JSON_PRETTY_PRINT);
        echo $output;

    }
}



function DeleteLiveValue($xml, $currency)
{
    header('Content-Type:text/xml');
    $xml = new DOMDocument('1.0', 'utf-8');
    $xml_action = $xml->createElement('action');
    $xml->appendChild($xml_action);
    $xml_at = $xml->createElement("at", getStoredTimestamp(true,false, $xml));
    $xml_code = $xml->createElement("code", $currency);
    $xml_action->appendChild($xml_at);
    $xml_action->appendChild($xml_code);
    $xml_action->setAttribute("type", "del");

    echo $xml->saveXML();


    return;


}

function PostLiveValue($xml, $currency)
{

    $rate = $xml->xpath('/store/currencies/currency[@code="' . $currency .'"]/rate');
    $name = $xml->xpath('/store/currencies/currency[@code="' . $currency .'"]/name');
    $loc = $xml->xpath('/store/currencies/currency[@code="' . $currency .'"]/loc');

    


    header('Content-Type:text/xml');
    $xml = new DOMDocument('1.0', 'utf-8');
    $xml_action = $xml->createElement('action');
    $xml->appendChild($xml_action);
    $xml_at = $xml->createElement('at', getStoredTimestamp(true,false, $xml));
    $xml_rate = $xml->createElement('rate', $rate[0]);
    $xml_curr = $xml->createElement('curr');
    $xml_action->appendChild($xml_at);
    $xml_action->appendChild($xml_rate);
    $xml_action->appendChild($xml_curr);
    $xml_curr_code = $xml->createElement('code', $currency);
    $xml_curr_name = $xml->createElement('name', $name[0]);
    $xml_curr_loc = $xml->createElement('loc', $loc[0]);
    $xml_curr->appendChild($xml_curr_code);
    $xml_curr->appendChild($xml_curr_name);
    $xml_curr->appendChild($xml_curr_loc);

    echo $xml->saveXML();

    return;
}

function PutLiveValue($xml, $currency, $old, $new)
{

    $name = $xml->xpath('/store/currencies/currency[@code="' . $currency .'"]/name');
    $loc = $xml->xpath('/store/currencies/currency[@code="' . $currency .'"]/loc');

    


    header('Content-Type:text/xml');
    $xml = new DOMDocument('1.0', 'utf-8');
    $xml_action = $xml->createElement('action');
    $xml->appendChild($xml_action);
    $xml_at = $xml->createElement('at', getStoredTimestamp(true,false, $xml));
    $xml_rate = $xml->createElement('rate', $new);
    $xml_oldrate = $xml->createElement('old_rate', $old[0]);
    $xml_curr = $xml->createElement('curr');
    $xml_action->appendChild($xml_at);
    $xml_action->appendChild($xml_oldrate);
    $xml_action->appendChild($xml_rate);
    $xml_action->appendChild($xml_curr);
    $xml_curr_code = $xml->createElement('code', $currency);
    $xml_curr_name = $xml->createElement('name', $name[0]);
    $xml_curr_loc = $xml->createElement('loc', $loc[0]);
    $xml_curr->appendChild($xml_curr_code);
    $xml_curr->appendChild($xml_curr_name);
    $xml_curr->appendChild($xml_curr_loc);

    echo $xml->saveXML();

    return;


}




?>
