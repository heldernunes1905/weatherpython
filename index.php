<?php 

$directory = dirname(__FILE__);
$city = "London";
echo(shell_exec("$directory/weather.py $city")); //this will call python file and send the city name
?>