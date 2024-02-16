<?php

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$db = 'retech1';
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $result_displayValues = mysqli_query($conn, "SELECT * FROM tbl_courier WHERE Courier_id = '$id'");
    if ($row_displayValues = mysqli_fetch_assoc($result_displayValues)) {
        $email = $row_displayValues['Cs_Username'];
        $name = $row_displayValues['Cs_name'];
        $dist = $row_displayValues['Cs_dist'];
        $city = $row_displayValues['Cs_city'];
        $pin = $row_displayValues['Cs_pin'];
        $phno = $row_displayValues['Cs_Phno'];
        $min = $row_displayValues['Cs_mindel'];
        $max = $row_displayValues['Cs_maxdel'];
    }

    if (isset($_POST['cancel'])) {
        header('location:courierlist.php');
        exit();
    }
    if (isset($_POST['submit'])) {
        $email_fetched = $_POST['email'];
        $name_fetched = $_POST['name'];
        $dist_fetched = $_POST['dist'];
        $city_fetched = $_POST['city'];
        $pin_fetched = $_POST['pin'];
        $phno_fetched = $_POST['phno'];
        $min_fetched = $_POST['min'];
        $max_fetched = $_POST['max'];
        $pass = $_POST['password'];
        $ppass = mysqli_real_escape_string($conn, md5($pass));
        $pas = substr($ppass, 0, 10);
        $newpassword = $_REQUEST['newpassword'];


        
        $sql_check = mysqli_query($conn, "SELECT * FROM `tbl_Login` where Username = '$email_fetched'");
        $cpass = mysqli_fetch_assoc($sql_check)['Password'];
       
        if ($pas == $cpass) {

            if (!empty($newpassword)) {
                $newpass = mysqli_real_escape_string($conn, md5($newpassword));
                $newpas = substr($newpass, 0, 10);
                $passwrod_update = mysqli_query($conn, "UPDATE tbl_Login SET Password = '$newpas' WHERE Username = '$email_fetched'");
            }

        if (!empty($email_fetched)) {

            $sql_check_isavail = "SELECT * FROM tbl_courier WHERE courier_id = '$id'";
            $result_check_isavail = mysqli_query($conn, $sql_check_isavail);

            if (mysqli_num_rows($result_check_isavail) == 1) {
                $sql_update = "UPDATE tbl_courier SET Cs_phno='$phno_fetched', Cs_name='$name_fetched', Cs_dist='$dist_fetched', Cs_city='$city_fetched', Cs_pin='$pin_fetched',Cs_mindel = '$min_fetched', Cs_maxdel = '$max_fetched'  WHERE courier_id='$id'";

                if (mysqli_query($conn, $sql_update)) {
                    header('location:courierlist.php');

                    $result_displayValues = mysqli_query($conn,"SELECT * FROM tbl_courier WHERE courier_id = '$id'");
    if ($row_displayValues = mysqli_fetch_assoc($result_displayValues)) {
        $email = $row_displayValues['Cs_Username'];
        $name = $row_displayValues['Cs_name'];
        $dist = $row_displayValues['Cs_dist'];
        $city = $row_displayValues['Cs_city'];
        $pin = $row_displayValues['Cs_pin'];
        $phno = $row_displayValues['Cs_Phno'];
    }
                else {
                    echo "Error updating record: " . mysqli_error($conn);
                }
            }
        } 
        else 
        {
            $error = 'All fields are compulsory';
        }
    }
}else {
        echo '<p class="msg">' . 'Enter Correct Password' . '</p>';
    }
}
}
?>

<!DOCTYPE html>
<html>

<head>
    <style>
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
  top: 110px;
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
.msg {
            position: relative;
            top:85vh;
            left: 62vh;
            background-color: #000000;
            color: #fff;
            font-family: Unispace;
            width: 340px;
            text-align: center;
            padding: 10px;
            border-radius: 5px;
            font-size: 20px;
            z-index: 999;
        }
form {
  margin-top: 20px;
}

table {
  width: 100%;
  border-collapse: collapse;
}

td {
    width: 50%;
  padding: 8px;
}

input{
  width: 93%;
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
}
select{
    width: 100%;
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

button {
  position: relative;
  left: 395px;
  width: 16%;
  padding: 10px;
  background-color: #000000;
  color: #fff;
  border: none;
}


    </style>
</head>

<body background="6.png">
    <div class="container">
        <h1 class="heading">Edit Courier Details</h1>
        <form action="" method="post">
        <table>
                <tr>
                    <td width=50%>
                        Courier Name:
                        <input type="text" value="<?php echo (isset($name)) ? $name : ''; ?>" name="name" >
                    </td>
                    <td>
                        District:
                        <input type="text" value="<?php echo (isset($dist)) ? $dist : ''; ?>" name="dist" >
                    </td>
                </tr>
                <tr>
                    <td>
                        City:
                        <input type="text" value="<?php echo (isset($city)) ? $city : ''; ?>" name="city" >
                    </td>
                    <td>
                        Pin:
                        <input type="text" value="<?php echo (isset($pin)) ? $pin : ''; ?>" pattern="[0-9]{6}" maxlength="6" name="pin" >
                    </td>
                </tr>
                <tr>
                <td>
                        Contact:
                        <input type="tel" value="<?php echo (isset($phno)) ? $phno : ''; ?>" pattern="[0-9]{10}" maxlength="10" name="phno" >
                    </td>
                    <td>
                        Email:
                        <input type="email" value="<?php echo (isset($email)) ? $email : ''; ?>" name="email" >
                    </td>
                </tr>
                <tr>
                <td>
                  Minimum Delivery Date:
                  <input type="text" name="min" value="<?php echo (isset($min)) ? $min : ''; ?>"  maxlength='2'
                     required="">
               </td>
               <td>
                  Maximum Delivery Date:
                  <input type="text" name="max" value="<?php echo (isset($max)) ? $max : ''; ?>"  maxlength='2'
                     required="">
               </td>
                </tr>   
                <tr>
                    <td>
                        Password:
                        <input type="password" name="password" required>
                    </td>
                    <td>
                        New Password:
                        <input type="password" name="newpassword">
                    </td>
                </tr>
            </table>
            <button type="submit" class="button" name="submit">Update Now</button>
      <button type="cancel" class="button" name="cancel">Cancel</button></a>
        </form>
    </div>
</body>
</html>