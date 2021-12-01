<?php

require 'Config.php';
require 'Functions.php';


function DBUpdateLive($connection, $sqlStatement, $currency)
{

    $sth = $connection->prepare($sqlStatement);
    $sth->bindParam(':currency', $currency, PDO::PARAM_STR);
    $sth->execute();
    $connection->commit();
    $connection = null;
}

function DBGetValues($connection)
{
    $statement = $connection->prepare('SELECT * FROM Currency');
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    print_r($result);
    $connection = null;
    return $result;
}

function UpdateTimestamp($connection)
{
    $statement = $connection->prepare('SELECT * FROM Timestamp');
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    if (time() > ($result['Ts'] + 7200)) {
        $timestamp = getAPIValues()['query']['timestamp'];
        if ($result['Ts'] != $timestamp) {
            $statement = $connection->prepare('UPDATE Timestamp SET Ts = :timestamp');
            $statement->bindParam(':timestamp', $timestamp, PDO::PARAM_INT);
            $statement->execute();
            $connection->commit();
            $connection = null;
            return true;
        }
        $connection = null;
        return false;
    } else {
        return false;
    }
}

function CheckTimestamp($connection)
{
    $statement = $connection->prepare('SELECT * FROM Timestamp');
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    return $result['Ts'];
}

function UpdateCurrencyValues($connection, $tsValue)
{

    $tsUpdated = $tsValue;
    if ($tsUpdated == true) {
        $currencyValues = getAPIValues()['data'];
        $GBPValue = getAPIValues()['data']['GBP'];

        $statement1 = $connection->prepare('SELECT count(*) FROM Currency');
        $statement1->execute();
        $var = $statement1->fetch();
        if ($var[0] < 1) {
            echo 'Created </br>';
            foreach ($currencyValues as $key => $value) {
                $value = $value / $GBPValue;
                $statement = $connection->prepare('INSERT INTO Currency (CurrencyName, Value) VALUES (:currency, :value)');
                $statement->bindParam(':value', $value, PDO::PARAM_INT);
                $statement->bindParam(':currency', $key, PDO::PARAM_STR);
                $statement->execute();
            }
        } else {
            echo 'Updated </br>';

            foreach ($currencyValues as $key => $value) {
                $value = $value / $GBPValue;
                $sqlStatement = 'UPDATE Currency SET Value = :value WHERE CurrencyName = :currency';
                $statement = $connection->prepare($sqlStatement);
                $statement->bindParam(':value', $value, PDO::PARAM_STR);
                $statement->bindParam(':currency', $key, PDO::PARAM_STR);
                $statement->execute();
            }
        }
        $connection->commit();
    } else {
        echo 'Values are updated </br>';
    }
}

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


// DBUpdateLive(DBConnection($dbValues), $sql, $current);

Create_XML($currencies)

// UpdateCurrencyValues(DBConnection($dbValues), UpdateTimestamp(DBConnection($dbValues)));
?>