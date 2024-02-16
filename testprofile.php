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

session_start();

if (isset($_POST['cancel'])) {
  header('location:dashboard.php');
  exit();
}

$user_id = $_SESSION['userid'];
if (isset($_SESSION['usertp']) && $_SESSION['usertp'] === 'Staff') {

  $result_displayValues = mysqli_query($conn, "SELECT * FROM tbl_Staff where Staff_id = '$user_id'");
  $row_displayValues = mysqli_fetch_assoc($result_displayValues);


  $email = $row_displayValues['S_Username'];
  $fname = $row_displayValues['S_Fname'];
  $mname = $row_displayValues['S_Mname'];
  $lname = $row_displayValues['S_Lname'];
  $dist = $row_displayValues['S_dist'];
  $city = $row_displayValues['S_city'];
  $pin = $row_displayValues['S_pin'];
  $gender = $row_displayValues['S_Gender'];
  $phno = $row_displayValues['S_Phno'];
  $job= $row_displayValues['S_Job_title'];
}
elseif (isset($_SESSION['usertp']) && $_SESSION['usertp'] === 'Admin') {

  $result_displayValues = mysqli_query($conn, "SELECT * FROM tbl_Staff where Staff_id = '$user_id'");
  $row_displayValues = mysqli_fetch_assoc($result_displayValues);


  $email = $row_displayValues['S_Username'];
  $fname = $row_displayValues['S_Fname'];
  $mname = $row_displayValues['S_Mname'];
  $lname = $row_displayValues['S_Lname'];
  $dist = $row_displayValues['S_dist'];
  $city = $row_displayValues['S_city'];
  $pin = $row_displayValues['S_pin'];
  $gender = $row_displayValues['S_Gender'];
  $phno = $row_displayValues['S_Phno'];
  $job= $row_displayValues['S_Job_title'];
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Profile Card</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
  
  <style>
    /* Add your custom styles here */

/* Example styles to get you started */
@import url('https://fonts.googleapis.com/css2?family=Barlow:ital@1&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Karla:wght@300;400;500;600;700&display=swap');
@font-face {
        font-family: 'OstrichSansreg';
        src: url(fonts/OstrichSans-Heavy.otf);
      }

      @font-face {
        font-family: 'OstrichSans';
        src: url(fonts/OstrichSans-Bold.otf);
      }
body {
    font-family: OstrichSansreg;
  height: 100vh;
  background-color: #eee;
  display: flex;
  justify-content: center;
  align-items: center;
  margin: 0;
  padding: 0;
}

.card {
  width: 1400px;
  height: 600px;
  overflow: hidden;
  background-color: #fff;
  background-image: url('2.png'); /* Replace 'path/to/your/image.jpg' with the actual path to your image file */
  background-size: 1400px;
  background-position: center ;
  background-repeat: no-repeat;
  border-radius: 10px;
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
  display: flex;
  flex-direction: column;
}
.card-content {
  padding: 30px 20px;

}

.card h1 {
    font-family: OstrichSans;
    font-weight: bold;
  font-size: 60px;
  text-align: center;
  padding-right:50px;
  margin-top: 0;
  margin-bottom: 30px;
}

.container {
  margin: 100px;
  width: 80%;
}
label {
  display: block;
  font-size: 32px;
  margin-bottom: 45px;
 background-color: #fff;
 border-radius: 10px;
 padding-top: 18px;
 padding-left: 25px;
 font-weight: px;
 padding-right: 10px;
 padding-bottom: 20px;
}

label:last-of-type {
  margin-bottom: 0;
}

.first{
    text-transform: capitalize;
    position: relative;
    left:60%;
    max-width: 230px;
    bottom:90px;
}
.last{
    max-width: 220px;
    text-transform: capitalize;
    position: relative;
    left:85%;
    bottom:530px;
}
.curve{
background-color: #000000;
position:relative;

}
button {
            position: absolute;
            right:80px;
            bottom:30px;

            width: 16%;
            padding: 10px;
            background-color: #000000;
            color: #fff;
            border: none;
        }
</style>

  </head>
  <body>

    <div class="card">
      <div class="card-content">
        <h1> Profile</h1>
        <div class="container">
        <form action="" method='post'>
               <div class="first">
                     <label><?php echo $fname; ?> <?php echo $mname; ?></label>

                     <label><?php echo $dist; ?></label>

                     <label><?php echo $lname; ?></label>  
  
                     <label><?php echo $city; ?></label>                    
                </div>
                <div class="last">
                     <label><?php echo $phno; ?></label>              

                     <label><?php echo $pin; ?> </label>  

                     <label><?php echo $job; ?></label>

                    <label><?php if($gender='m'){
                        echo 'Male';
                    }
                    elseif($gender="f")
                    {
                        echo 'Female';
                    }
                    else
                    {
                        echo 'Other';
                    }
                    ?></label>
                </div>
    </div>
    <div class="curve">
        <label> asdas</label>
                </div>

    </div>
    <button type="submit" name="cancel">Cancel</button>

  </body>
</html>
      