
<?php
session_start();
?>
<?php
$dbhost='localhost';
$dbuser='root';
$dbpass='';
$db='retech1';
$conn = mysqli_connect($dbhost,$dbuser,$dbpass,$db);
if ($conn->connect_error) 
{
die("Connection failed:" . $conn->connect_error);
}


$user_id = $_SESSION['userid'];


$result_displayValues = mysqli_query($conn,"SELECT * FROM tbl_Customer where Customer_id = '$user_id'");
$row_displayValues = mysqli_fetch_assoc($result_displayValues);

$email=$row_displayValues['Cust_Username'];
$fname = $row_displayValues['Cust_Fname'];
$mname = $row_displayValues['Cust_Mname'];
$lname = $row_displayValues['Cust_Lname'];
$dist = $row_displayValues['Cust_dist'];
$city = $row_displayValues['Cust_city'];
$pin = $row_displayValues['Cust_pin'];
$gender = $row_displayValues['Cust_Gender'];
$phno = $row_displayValues['Cust_Phno'];
$dob = $row_displayValues['Cust_DOB'];

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
    <title>Profile Card</title>
    <style>
      body{
  position:absolute;
  left: 70%;
  top:100px;
  padding: 0;
  height: 300px;  
  background: #eee;
}

.card{
  font-family: "Candara", sans-serif;
  width: 340px;
  background: #fff;
  border-radius: 10px;
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
  display: flex;
  flex-direction: column;
}

.card-image img{
  position: relative;

  width: 100%;
  height: 90px;
  border-top-left-radius: 10px;
  border-top-right-radius: 10px;
  object-fit: cover;
  
}

.card-content h3{
  padding-top:5px;
  font-size: 30px;
  text-align: center;
  margin: 0;
}
.card-content p{
  text-transform: uppercase;
  font-family: Candara;
  font-size: 22px;
  font-weight: 200px;
  text-align: justify;
  padding: 0 0px 0px 70px;
}
.card-content i.fa::before {
  font-size: 24px; 

  
}
.card-content i.fa-users::before {
 position:absolute;
 top:158px;
 left:10%;
}
.card-content i.fa-address-card::before {
  position:absolute;
  top:208px;
 left:10%;
}
.card-content i.fa-phone-square::before {
  position:absolute;
  top:309px;
 left:12%;
}
.button {
  font-family: Candara;
    position: relative;
    left: 170px;
    top: 40px;
    width: 50%;
    padding: 10px;
    background-color:#fff;
    color: #EF1325;
    border: none;
    border-radius: 4px;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);

}


      </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
  </head>
  <body>

    <!--Profile card start-->
    <div class="card">
      <div class="card-image">
        <img src="103.png" alt="">
      </div>

      <div class="card-content">
        <h3>Profile</h3>
        <form>
        <p><i class="fa fa-users" aria-hidden="true"></i><?php echo $fname; ?> <?php echo $mname; ?></p>
        <p><i class="fa fa-address-card" aria-hidden="true"></i><?php echo $dist; ?></p>
        <p><?php echo $city; ?>,<?php echo $pin; ?></p> 
        <p><i class="fa fa-phone-square" aria-hidden="true"></i><?php echo $phno; ?></p>              
      </div>
      <button type="submit" name='submit' class="button">Submit</button>
</body>
</html>
      