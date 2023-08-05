
<!DOCTYPE html>
<html>
    <body>
        <form action="" method="post">
            <input type="text" name="inputText"/>
            <input type="submit" name="SubmitButton"/>
        </form>  
        <p id="cityname"></p>
        <p id="temperature"></p>
        <p id="description"></p>
        <p id="date"></p>
    </body>
</html>


<?php

//function gets called if city is entered
function sendcityname($name){
/*$directory = dirname(__FILE__);
$city = "London";
echo(shell_exec("$directory/weather.py $city")); //this will call python file and send the city name*/
$myObj = new stdClass(); //create object
$myObj->name = $name;
//echo(json_encode($myObj));



$inp = file_get_contents('info.json');// open the json file and get the info and format it
$tempArray = json_decode($inp);
$search_size = count($tempArray);//number of elements in array

if($search_size == 0){//add new id to array, use size of array + 1, could be added to check if a specific id already exists then it goes to the next available one
    $id = 1;
}else{
    $id = $search_size + 1;
}

$data[$id] = json_encode($myObj);// create new object in array with id and name related to id

//print($id);

//print_r($tempArray);

//push the name into the current json array and modify the json file
array_push($tempArray, $data);
$jsonData = json_encode($tempArray);
file_put_contents('info.json', $jsonData);


//call python file that will call the api and get the data and add to json
$directory = dirname(__FILE__);
shell_exec("$directory/weather.py $id"); //will send the id that was inputted so it knows what to change

return $id;
}


?>
<script>
function getjsondata(idadd){
    
    var myData;
    //get info from json file and send to another function to show info
    fetch("./info.json") 
    .then((res) => {
        return res.json();
    })
    .then((data) => {
        myData = data; 
        showdata(myData,idadd);
    });
}

//will only show the data of the city input
function showdata(data,id){
    //console.log(id-1);
    ogid = id; //id of inputted data
    id = id - 1;//index of array
    current = data[id];

    const object = JSON.parse(current[ogid]);//get all the data into readable format
    const name = object["name"];
    const temp = object["temp"];
    const desc = object["desc"];
    const date = object["date"];
    

    //show all the data
    document.getElementById("cityname").textContent += "City: " + name;
    document.getElementById("temperature").textContent += "Temperature: " + temp;
    document.getElementById("description").textContent += "Description: " + desc;
    document.getElementById("date").textContent += "Date: " + date;

}

</script>
<?php


$message = "";
if(isset($_POST['SubmitButton'])){ //check if form was submitted
  $input = $_POST['inputText']; //get input text
  $idadded = sendcityname($input);//will get the name inputted and send to get the gata
  
  ?>
    <script>
        getjsondata(<?php echo $idadded ?>);//get the new data and show related info to the inputted city
    </script> 
  <?php
}    
?>


