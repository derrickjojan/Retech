<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$db = 'retech1';
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $db);
if ($conn->connect_error) {
    die("Connection failed:" . $conn->connect_error);
}
session_start();

$message = []; // Initialize an array to store messages

if (!empty($_SESSION['userid'])) {
    $user_id = $_SESSION['userid'];

    if (isset($_POST['submit'])) {
      $cnumber = mysqli_real_escape_string($conn, $_POST['number']);
      $cholder = mysqli_real_escape_string($conn, $_POST['holder']);
      $cdate = mysqli_real_escape_string($conn, $_POST['date']);
      $ccvv = mysqli_real_escape_string($conn, $_POST['cvv']);
      $formattedDate = date('Y-m-d', strtotime($cdate . '-01'));

      $select = mysqli_query($conn, "SELECT * FROM `Card` WHERE Card_number = '$cnumber' AND customer_id = '$user_id'");
  
      if (mysqli_num_rows($select) > 0) {
          $message[] = '*Card Already Exists*';
      } else {
          $insert = mysqli_query($conn, "INSERT INTO `Card`(Customer_id,Card_number, Card_holder, Expiry_date, Card_cvv) VALUES ('$user_id', '$cnumber', '$cholder', '$formattedDate', '$ccvv')");
  
          if ($insert) {
            header('location:payment.php');
              exit();
          } else {
              $message[] = 'Entry failed!';
          }
      }
  }
  
}

$messageStyle = '
position: relative;
left: 90px;
background-color: #000000;
color: #fff;
font-family: Unispace;
width: 400px;
text-align:center;
padding: 10px;
border-radius: 5px;
font-size: 20px;';
?>
  <!DOCTYPE html>
<html>
  <head>
  <title>Payment</title>
  </head>
  <style>
    @font-face {
  font-family: 'OstrichSanss';
  src: url(fonts/OstrichSans-Bold.otf);
}
@font-face {
        font-family: 'OstrichSansreg';
        src: url(fonts/OstrichSans-Heavy.otf);
      }
body {
  font-family: OstrichSansreg;
  font-size: 22px;
  position: absolute;
  bottom: 50px;
  right:35%;
}

.container {
  position: relative;
  bottom: 55px;
  height: 470px;
  width: 400px;
  margin: 0 auto;
  padding: 30px;
  background-color: #FFFFFF;
  border-radius: 10px;
  border: 2px solid #ccc;
}


h1 {
  margin: 10px;
font-family: OstrichSanss;
font-weight: 800;
font-size: 50px;
text-align: center;
}

form {
  margin-top: 20px;
}	
label{
 font-weight: bold;
}

p {
Position: absolute;
bottom: 75px;
right:20px;
color: #5A5A5A;
margin: 10px;
}

input[type="text"],input[type="month"],input[type="number"] {
  width: 95%;
  padding: 10px;
  margin-top: 5px;
  margin-bottom: 20px;
  border: 2px solid #ccc;
  border-radius: 10px;
}

input[type="tel"]
{
  width: 30%;
  padding: 10px;
  margin-top: 5px;
  margin-bottom: 10px;
  border: 2px solid #ccc;
  border-radius: 10px;
}
	 
button {
  position: relative; 
  top:60px;
  left: 130px;
  width: 30%;
  padding: 10px;
  background-color: #000000;
  border-radius: 10px;
  color: #fff;
  border: none;
 
}

</style>
<body background="6.png">
<div class="container">
    <h1>Card Details</h1>
    <form action="" method="post"> <!-- Corrected: One form for all input fields -->
        <label>Card Number:</label>
        <input type="text" name="number" placeholder="Enter Card Number" maxlength="16">
     <label>Card Holder Name:</label>
      <input type="text" name="holder" placeholder="Enter Card Holder Name" required="">
     <label>Expiry Date:</label>
      <input type="month" name="date" required="">
     <label>Cvv:</label>
      <br>
      <input type="tel" name="cvv" placeholder="Enter CVV" maxlength="3" minlength="3">
      <p>*3 digits in the back of the card*</p>
        <button type="submit" name="submit">Submit</button>
    </form>
</div>
</body>
</html>