<?php

$arrayFromCSV =  array_map('str_getcsv', 'https://smooth-winter-3239.herokuapp.com/test.csv');

print_r($arrayFromCSV);

?>
