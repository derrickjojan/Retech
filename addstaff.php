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
if(isset($_POST['Register'])){


   $email = mysqli_real_escape_string($conn,$_POST['email']);
   $password = mysqli_real_escape_string($conn,md5($_POST['password']));
   $fname=mysqli_real_escape_string($conn,$_POST['fname']);
   $mname=mysqli_real_escape_string($conn,$_POST['mname']);
   $lname=mysqli_real_escape_string($conn,$_POST['lname']);
   $dist=mysqli_real_escape_string($conn,$_POST['dist']);
   $city=mysqli_real_escape_string($conn,$_POST['city']);
   $pin=mysqli_real_escape_string($conn,$_POST['pin']);
   $gender=mysqli_real_escape_string($conn,$_POST['gender']);
   $phno=mysqli_real_escape_string($conn,$_POST['phno']);
   $date=mysqli_real_escape_string($conn,$_POST['date']);
   $title=mysqli_real_escape_string($conn,$_POST['jobtitle']);
 

   $select = mysqli_query($conn, "SELECT * FROM `tbl_Staff` WHERE S_Username = '$email'") or die('query failed');
   $selectt = mysqli_query($conn, "SELECT * FROM `tbl_Login` WHERE username = '$email'") or die('query failed');
   if (mysqli_num_rows($select) > 0 && mysqli_num_rows($selectt) > 0) {
    $message[] = '*User Already Exist*'; 
 }
 
   else
   {
      $insertt = mysqli_query($conn, "INSERT INTO `tbl_Login`(Username,Password,User_type)VALUES('$email','$password','Staff')");
      $insert = mysqli_query($conn, "INSERT INTO `tbl_Staff`(Staff_id,S_Username,S_Phno,S_Fname,S_Mname,S_Lname,S_Start_date,S_Gender,S_dist,S_city,S_pin,S_Job_title,S_Status) VALUES(generate_staff_id(),'$email','$phno','$fname','$mname','$lname','$date','$gender','$dist','$city','$pin','$title','1')") or die('query failed'); 
       
         if($insert){
            header('location:stafflist.php');
         }else{
            $message[] = 'registeration failed!';
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
}

?>

<html>
<head>

   <title>register</title>



   <style>
      .message {
         <?php echo $messageStyle; ?>
      }
      @font-face {
  font-family: 'OstrichSanss';
  src: url(fonts/OstrichSans-Bold.otf);
}
      body {
  font-family: Segoe UI;
  background-color: #f2f2f2;
}
.container {
  position: relative;
  top: 40px;
  max-width: 600px;
  margin: 0 auto;
  padding: 20px;
  background-color: #fff;
  border: 2px solid #ccc;
  border-radius: 10px;
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
p{
text-align: center;
}
table {
    width: 100%;
    border-collapse: collapse;
}

td {
    padding: 8px;
}

input,
select {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.button {
    position: relative;
    left: 150px;
    width: 50%;
    padding: 10px;
    background-color: #000000;
    color: white;
    border: none;
    border-radius: 4px;

}

      </style>

</head>
<body background="6.png">
   
<div class="container">

   <form action="" method="post">
      <h1>Staff Registration</h1>
      <?php
      if(isset($message)){
         foreach($message as $message){
            echo '<div class="message">'.$message.'</div>';
         }
      }
      ?>
            <table>
                <tr>
                    <td width=50%>
                        First Name:
                        <input type="text" placeholder="First Name" name="fname" required="">
                    </td>
                    <td>
                    Contact:
                        <input type="tel" placeholder="Phone Number" pattern="[0-9]{10}" maxlength="10" name="phno" required="">
                    </td>
                </tr>
                <tr>
                    <td>
                        Middle Name:
                        <input type="text" placeholder="Middle Name" name="mname" required="">
                    </td>
                    <td>
                        District:
                        <input type="text" placeholder="District Name" name="dist" required="">
                    </td>
                </tr>
                <tr>
                    <td>
                        Last Name:
                        <input type="text" placeholder="Last Name" name="lname" required="">
                    </td>
                    <td>
                        City:
                        <input type="text" placeholder="City Name" name="city" required="">
                    </td>
                </tr>
                <tr>
                    <td>
                        Gender:
                        <select name="gender" required="">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </td>
                    <td>
                        Pin:
                        <input type="text" placeholder="Pin Code" pattern="[0-9]{6}" name="pin" required="">
                    </td>
                </tr>
                <tr>
                    <td>
                       Start Date:
                        <input type="date" placeholder="Start Date" name="date" required="">
                    </td>
                    <td>
                        Email:
                        <input type="email" placeholder="Email" name="email" required="">
                    </td>
                </tr>
                <tr>
                    <td width=50%>
                        Job title:
                        <select name="jobtitle" required="">
                            <option value="Staff">staff</option>    
                        </select>
                    </td>
                    <td>
                        Password:
                        <input type="password" placeholder="Password" name="password" required="">
                    </td>
                </tr>
            </table>
            <input type="submit" name="Register" value="register now" class="button">
   </form>
    </div>
</body>
</html>
