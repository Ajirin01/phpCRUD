
<?php
session_start();
// $con=new mysqli("localhost","root","","login_data");
// $query="select * from login where id=1";
// $run=mysqli_query($con,$query);
// $result=mysqli_fetch_array($run);

// echo json_encode($result);

$password="12345678";
$h_passWord=password_hash($password,PASSWORD_DEFAULT);
echo $h_passWord.'<br><br>';
if(password_verify('12345678',$h_passWord)){
   $_SESSION['email']="olagoke@gmail.com";
   echo $_SESSION['email'];
}
?>