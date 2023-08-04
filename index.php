
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
function sendcityname($name){
/*$directory = dirname(__FILE__);
$city = "London";
echo(shell_exec("$directory/weather.py $city")); //this will call python file and send the city name*/
$myObj = new stdClass();
$myObj->name = $name;
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

return $id;
}


?>
<script>
function getjsondata(idadd){
    
    var myData;

    fetch("./info.json")
    .then((res) => {
        return res.json();
    })
    .then((data) => {
        myData = data; 
        showdata(myData,idadd);
    });
}

function showdata(data,id){
    //console.log(id-1);
    ogid = id;
    id = id - 1;
    current = data[id];

    const object = JSON.parse(current[ogid]);
    const name = object["name"];
    const temp = object["temp"];
    const desc = object["desc"];
    const date = object["date"];
    
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
  $idadded = sendcityname($input);
  
  ?>
     <script>
        
        getjsondata(<?php echo $idadded ?>);
        
    </script> 
  <?php
}    
?>


