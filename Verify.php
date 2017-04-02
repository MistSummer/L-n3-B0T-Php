<?php
$access_token = 'GKKuFc6FcuRQG+7Slc8coI6X3CFubcL4fvfZTAot6lzD8ahVOeyJOF97pObyGon1Je61dHpXbFA/SXjNwJ+50ZEeDQS0dqSs5dkDY/vi6GAGUDmb5bbkFK5N0OQf22jQiyaQcMtsY7t/KSOpm6Ib7wdB04t89/1O/w1cDnyilFU=';

$url = 'https://api.line.me/v1/oauth/verify';

$headers = array('Authorization: Bearer ' . $access_token);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
curl_close($ch);

echo $result;
?>
