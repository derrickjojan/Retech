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


$result_displayValues = mysqli_query($conn,"SELECT * FROM tbl_staff where Staff_id = '$user_id'");
$row_displayValues = mysqli_fetch_assoc($result_displayValues);

$email=$row_displayValues['S_Username'];
$fname = $row_displayValues['S_Fname'];
$mname = $row_displayValues['S_Mname'];
$lname = $row_displayValues['S_Lname'];
$dist = $row_displayValues['S_dist'];
$city = $row_displayValues['S_city'];
$pin = $row_displayValues['S_pin'];
$gender = $row_displayValues['S_Gender'];
$phno = $row_displayValues['S_Phno'];
$dob = $row_displayValues['S_DOB'];


if(isset($_REQUEST['submit'])){


    $fname_fetched = $_REQUEST['fname'];
    $mname_fetched = $_REQUEST['mname'];
    $lname_fetched = $_REQUEST['lname'];
    $dist_fetched = $_REQUEST['dist'];
    $city_fetched = $_REQUEST['city'];
    $pin_fetched = $_REQUEST['pin'];
    $gender_fetched = $_REQUEST['gender'];
    $phno_fetched = $_REQUEST['phno'];
    $dob_fetched = $_REQUEST['dob'];

  
    if(!empty($fname_fetched) && !empty($mname_fetched) && !empty($lname_fetched)&& !empty($phno_fetched)&& !empty($dist_fetched)&& !empty($city_fetched)&& !empty($pin_fetched)){


        
$sql_check_isavail = "SELECT * FROM tbl_staff where staff_id = '$user_id'";
$result_check_isavail = mysqli_query($conn, $sql_check_isavail);


if (mysqli_num_rows($result_check_isavail) == 1) {
    $sql_update = "UPDATE tbl_Staff SET S_phno='$phno_fetched', S_fname='$fname_fetched', S_mname='$mname_fetched', S_lname='$lname_fetched', S_dist='$dist_fetched', S_city='$city_fetched', S_pin='$pin_fetched'
      WHERE staff_id='$user_id'";

if (mysqli_query($conn, $sql_update)) {
  echo "Record updated successfully";
  
$sql_displayValues = "SELECT * FROM tbl_staff where staff_id = '$user_id'";
$result_displayValues = mysqli_query($conn, $sql_displayValues);

 $row_displayValues = mysqli_fetch_assoc($result_displayValues);

 $email=$row_displayValues['S_Username'];
 $fname = $row_displayValues['S_Fname'];
 $mname = $row_displayValues['S_Mname'];
 $lname = $row_displayValues['S_Lname'];
 $dist = $row_displayValues['S_dist'];
 $city = $row_displayValues['S_city'];
 $pin = $row_displayValues['S_pin'];
 $gender = $row_displayValues['S_Gender'];
 $phno = $row_displayValues['S_Phno'];
 $dob = $row_displayValues['S_DOB'];



} else {
  echo "Error updating record: " . mysqli_error($conn);
}

      
}
}
    else{
        $error = 'All fields are compulsory';
    }

}


?>
<head>
    <style>
body {
  font-family: Segoe UI;
  background-color: #f2f2f2;
}
.container {
  position: relative;
  top: 60px;
  max-width: 600px;
  margin: 0 auto;
  padding: 20px;
  background-color: #fff;
  border: 2px solid #ccc;
  border-radius: 10px;
}

h1 {
  font-family: Unispace;
  font-weight: 800;
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

button {
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



<div class="container">
<h1 class="heading">Edit Your Profile</h1>

<body background="6.png">
<form action="" method='post'>
<table>
                <tr>
                    <td width=50%>
                        First Name:
                        <input type="text" name="fname" value=<?php echo (isset($fname)) ? "$fname" : ""?>>

                    </td>
                    <td>
                        District:
                        <input type="text"  name="dist" value=<?php echo (isset($dist)) ? "$dist" : ""?>>
                    </td>
                </tr>
                <tr>
                    <td>
                        Middle Name:
                        <input type="text" name="mname" value=<?php echo (isset($mname)) ? "$mname" : ""?> >
                    </td>
                    <td>
                        City:
                        <input type="text" name="city"  value=<?php echo (isset($city)) ? "$city" : ""?>>
                    </td>
                </tr>
                <tr>
                    <td>
                        Last Name:
                        <input type="text" name="lname"  value=<?php echo (isset($lname)) ? "$lname" : ""?>>
                    </td>
                    <td>
                        Pin:
                        <input type="text" pattern="[0-9]{6}" name="pin"  value=<?php echo (isset($pin)) ? "$pin" : ""?>>
                    </td>
                </tr>
                <tr>
                    <td>
                        Contact:
                        <input type="tel"  pattern="[0-9]{10}" name="phno"  value=<?php echo (isset($phno)) ? "$phno" : ""?>>
                    </td>
                    <td>
                        Email:
                        <input type="email"  name="email"value=<?php echo (isset($email)) ? "$email" : ""?>  >
                    </td>
                </tr>
                <tr>
                    <td>
                        Gender:
                        <select name="gender" value=<?php echo (isset($gender)) ? "$gender" : ""?> >
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </td>
                    <td>
                        Password:
                        <input type="password" name="password" >
                    </td>
                </tr>
                <tr>
                    <td width=50%>
                        Date Of Birth:
                        <input type="date"  name="dob" value=<?php echo (isset($dob)) ? "$dob" : ""?> >
                    </td>
                </tr>
            </table>



  <button type="submit" name='submit' class="button">Submit</button>
</form>

</div>

