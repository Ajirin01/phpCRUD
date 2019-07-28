<?php
// connection to the data base
 $connetion= mysqli_connect("localhost","root","","phpCRUD");
//  checking if method button has been clicked and if the value parameter has been set
if(isset($_GET['method']) && isset($_GET['value']) )
{
    $method=$_GET['method'];
    $value=$_GET['value'];
    echo "method is ".$method . "<br><br>"." and value is Get ".$value;
}
//  checking if submit button has been clicked and if the username parameter has been set
else if(isset($_POST['submit']) && isset($_POST['username']) && isset($_POST['email'])){
    echo "hello <br><br>";

    echo "username = ".$_POST['username'] ."  and <br><br> "."email = ". $_POST['email'];
}
//  checking if delete button has been clicked and if the id parameter has been set
//then we can delete the record whose id was set
else if(isset($_GET["delete"]) && isset($_GET["id"])){
    echo  "the id to delete is:   
    " . $_GET["id"];
}
//  checking if update button has been clicked and if the id parameter has been set
//then we can update the record whose id was set
else if(isset($_GET["update"]) && isset($_GET["id"])){
    echo  "the id to update is:   
    " . $_GET["id"];
}
//  checking if show button has been clicked and if the id parameter has been set
//then we can show record by id
else if(isset($_GET["show"]) && isset($_GET["id"])){
    echo  "the id to show is:   
    " . $_GET["id"];
}

//image(single) file upload with other useful details for the image

//checking whether the upload  button has beenc clicked
//if yes, the following codes would be ran
else if(isset($_POST["upload"])){
    
        
      //obtaining the image credentials
       $image_name=$_FILES['image']['name'];//for image name
       $image_tmp=$_FILES['image']['tmp_name'];//image temporary name
    //    echo "One file has been chosen!<br><br>"; 
    //    echo $image_name ."<br><br>";

    // echo $image_tmp;
    move_uploaded_file($image_tmp,"images/$image_name");//move the uploaded image the desired location
    
    
    
}

//this section uploads multiple images and upload the image name to the mysqli database as a json data
//******checking if the submit button(upload_files) has been activated
//and if yes, this following lines of codes would be ran
if(isset($_POST['upload_files'])){
    // $connetion= mysqli_connect("localhost","root","","phpCRUD");
    $itemName=$_POST['itemName'];// the item Name
    $query="select id from `crud` where itemName = '$itemName'";//create the query to 
    //check whether record already exists
    $run=mysqli_query($connetion,$query);
    $row=mysqli_num_rows($run);
    
   
    // echo $row."<br>";
    if($row > 0){// if record aleady exists
        echo "<h1>Ops!<h1>"."<h3>record already exists<h3>";
    }else{ // and if is doesnt, run the following codes
        
$images=$_FILES['image']['name'];//get the array of images name which we will convert to
//json object and store to the database
     echo count($images)." files has been chosen!<br><br>";//display how many items chosen  
  $image_name=$_FILES['image']['name'];//gets the ith name index of the images array
    $image_tmp=$_FILES['image']['tmp_name'];//gets the ith temporary name index of the images array
   for($i=0; $i<count($images);$i++){//a looping through the image array and move one at a time

    $img_name=$image_name[$i];
    $img_tmp=$image_tmp[$i];
   
    move_uploaded_file($img_tmp,'images/'.$img_name);

   }
    
echo json_encode($image_name) ."<br><br>";

 echo json_encode($image_tmp)."<br><br>";
$image_json=json_encode($image_name);
//inserting the record into the database
 $query="insert into `crud` ( `images`,`itemName`) values('$image_json','$itemName')";
 $run_query=mysqli_query($connetion,$query);
 if($run_query){
     echo "success!<br>new record created";
     
 }}
}

//getting the image by id
if(isset($_GET['id'])){

    $id=$_GET['id'];

    $query_select_by_id="select * from  `crud` where id='$id'";
    $run_query_select_by_id=mysqli_query($connetion,$query_select_by_id);

    $result=mysqli_fetch_assoc($run_query_select_by_id);
    echo json_encode($result);
    
}

//getting all records from the database
if(isset($_GET['all'])){
//running the query that selects all the records
    $query_select_all="select * from  crud";
    $run_query_select_all=mysqli_query($connetion,$query_select_all);
    $result=array();//creating an empty array to store the data from database
for($i=0;$i<mysqli_num_rows($run_query_select_all);$i++){
    $result[$i]=mysqli_fetch_assoc($run_query_select_all);// using for loop to fetch and accumilate the data
}
    echo json_encode($result);//the json data to be sent out
}


