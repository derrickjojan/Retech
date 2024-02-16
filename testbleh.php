<?php
session_start();
$dbhost='localhost';
$dbuser='root';
$dbpass='';
$db='retech';
$conn = mysqli_connect($dbhost,$dbuser,$dbpass,$db);
if ($conn->connect_error) 
{
    die("Connection failed:" . $conn->connect_error);
}


if(isset($_POST['submit']))
{
  //$sid = $_POST['staffid'];
  $name = $_POST['name'];
 // $lname = $_POST['lastname'];
  //$uname = $_POST["username"];
$email = $_POST["email"];
  //$housename = $_POST["housename"];
  $city = $_POST["city"];
  $district = $_POST["district"];
  $state = $_POST["state"];
  $pincode = $_POST["pincode"];
 $factno= $_POST["factno"];
 $phonenumber = $_POST["phonenumber"];
  $userid = $_SESSION['User_ID'];
  echo $userid;

  /*$insert= "INSERT INTO tbl_login(Username,Login_pswd,Type,Login_status) VALUES('$uname','$password','staff',1)";
  mysqli_query($conn,$insert);

  $query1 = "INSERT INTO tbl_vendor(Vendor_name, Vendor_email,Vendor_phno,Vendor_city, Vendor_district,Vendor_state, Vendor_pin,Vendor_factno,Vendor_status) VALUES ('$name','$email','$phonenumber','$city','$district',$state','$pincode','$factno',1)";
*/
$query1 = "INSERT INTO tbl_vendor(Staff_id,Vendor_name, Vendor_email, Vendor_phno, Vendor_city, Vendor_district, Vendor_state, Vendor_pin, Vendor_factno, Vendor_stats) VALUES ('$userid','$name', '$email', '$phonenumber', '$city', '$district', '$state', '$pincode', '$factno', 1)";

if(mysqli_query($conn, $query1))
{
    echo '<script>alert("New record entered");</script>';
}
else
{
    echo '<script>alert("Error: ' . mysqli_error($conn) . '")</script>';
}
}
?>
<html>
<head>
    <title>Vendor Registration</title>
    <link rel="stylesheet" href="stylevendor.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
</head>
<body>
  <div class="container">
    <div class="title">Vendor Details</div>
    <form action=" " method="POST">
        <div class="user-details">
            <div class="input-box">
                <span class="details">Vendor Name</span>
                <input type="text" name="name" placeholder="Enter first name" required>
            </div>
           
            
            <div class="input-box">
                <span class="details">Email</span>
                <input type="email" name="email" placeholder="Enter email" required>
            </div>
            
            <div class="input-box">
                <span class="details">City</span>
                <input type="text" name="city" placeholder="Enter city" required>
            </div>
            <div class="input-box">
                <span class="details">District</span>
                <input type="text" name="district" placeholder="Enter district" required>
            </div>
            <div class="input-box">
                <span class="details">Pincode</span>
                <input type="text" name="pincode" placeholder="Enter pincode" required>
            </div>

            <div class="input-box">
                <span class="details">Factory Number</span>
                <input type="text" name="factno" placeholder="Enter factory number" required>
            </div>

            <div class="input-box">
                <span class="details">State</span>
                <input type="text" name="state" placeholder="Enter state" required>
            </div>
            
            <div class="input-box">
                <span class="details">PhoneNumber</span>
                <input type="text" name="phonenumber" placeholder="Enter your number" required>
            </div>
           
           
        </div>
        
     
        <div class="button">
            <input type="submit" name="submit" value="Register">
        </div>
    </form>
</div>
</body>
</html>