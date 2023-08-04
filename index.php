<?php 

/*$directory = dirname(__FILE__);
$city = "London";
echo(shell_exec("$directory/weather.py $city")); //this will call python file and send the city name*/
$myObj = new stdClass();
$myObj->name = "Lisbon";

//echo(json_encode($myObj));



$inp = file_get_contents('info.json');
$tempArray = json_decode($inp);
$search_size = count($tempArray);

if($search_size == 0){
    $id = 1;
}else{
    $id = $search_size + 1;
}

$data[$id] = json_encode($myObj);

//print($id);

//print_r($tempArray);

array_push($tempArray, $data);
$jsonData = json_encode($tempArray);
file_put_contents('info.json', $jsonData);

$directory = dirname(__FILE__);
shell_exec("$directory/weather.py $id"); //will send the id that was inputted so it knows what to change


?>


