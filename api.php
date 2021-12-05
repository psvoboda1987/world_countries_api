<?php

if ($_SERVER['REQUEST_METHOD'] != 'GET') return;

header("Content-Type:application/json");

require_once('../../init.php');

$country = strtolower($_GET['country']);

if (isset($_GET['capital']) and $_GET['capital'] !== '')
{
    $capital = strtolower(htmlentities($_GET['capital']));

    returnQuery($capital);
}
elseif (isset($_GET['country']) and $_GET['country'] !== '')
{
    $country = strtolower(htmlentities($_GET['country']));

    returnQuery($country);
}

function respond($country, $capital, $response_code, $response_desc)
{
    $response['country'] = $country;
    $response['capital'] = $capital;
    $response['response_code'] = $response_code;
    $response['response_desc'] = $response_desc;

    return json_encode($response);
}

function returnQuery(string $value)
{
    $key = implode(array_keys($_GET));

    $searched = $key === 'country' ? 'capital' : 'country';

    $query = "SELECT $searched FROM `country` WHERE $key = ?";

    $mysql = new Mysql(HOSTNAME, USERNAME, PASSWORD, DB);

    $result = $mysql->query($query, $value)->fetchArray();

    if (count($result) > 0)
    {
        echo respond($value, $result[$searched], 200, 'Result found');
    }
    else
    {
        echo respond($value, $result[$searched], 200, 'No result found');
    }
}