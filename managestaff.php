<?php
session_start();

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$db = 'retech1';
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $result_displayValues = mysqli_query($conn, "SELECT * FROM tbl_Staff WHERE Staff_id = '$id'");
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
    $title = $row_displayValues['S_Job_title'];
    $date = $row_displayValues['S_Start_date'];

    if (isset($_POST['cancel'])) {
        header('location:stafflist.php');
    }
    if (isset($_POST['submit'])) {
        $email_fetched = $_POST['email'];
        $fname_fetched = $_POST['fname'];
        $mname_fetched = $_POST['mname'];
        $lname_fetched = $_POST['lname'];
        $dist_fetched = $_POST['dist'];
        $city_fetched = $_POST['city'];
        $pin_fetched = $_POST['pin'];
        $gender_fetched = $_POST['gender'];
        $phno_fetched = $_POST['phno'];
        $title_fetched = $_POST['title'];
        $date_fetched = $_POST['date'];
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

            if (!empty($email_fetched) && !empty($fname_fetched) && !empty($mname_fetched) && !empty($lname_fetched) && !empty($phno_fetched) && !empty($dist_fetched) && !empty($city_fetched) && !empty($pin_fetched)) {

                $sql_check_isavail = "SELECT * FROM tbl_Staff WHERE Staff_id = '$id'";
                $result_check_isavail = mysqli_query($conn, $sql_check_isavail);

                if (mysqli_num_rows($result_check_isavail) == 1) {
                    $sql_update = "UPDATE tbl_Staff SET S_phno='$phno_fetched', S_fname='$fname_fetched', S_mname='$mname_fetched', S_lname='$lname_fetched', S_dist='$dist_fetched', S_city='$city_fetched', S_pin='$pin_fetched', S_Gender='$gender_fetched', S_Job_title='$title_fetched', S_Start_date='$date_fetched' WHERE Staff_id='$id'";

                    if (mysqli_query($conn, $sql_update)) {
                        header('location:stafflist.php');

                        $sql_displayValues = "SELECT * FROM tbl_Staff WHERE Staff_id = '$id'";
                        $result_displayValues = mysqli_query($conn, $sql_displayValues);

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
                        $title = $row_displayValues['S_Job_title'];
                        $date = $row_displayValues['S_Start_date'];
                    } else {
                        echo "Error updating record: " . mysqli_error($conn);
                    }
                }
            } else {
                $error = 'All fields are compulsory';
            }
        }
     else {
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
        .msg {
            position: relative;
            top:88vh;
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

        body {
            font-family: Segoe UI;
            background-color: #f2f2f2;
        }

        .container {
            position: absolute;
            left:60vh;
            bottom: 20px;
            max-width: 600px;
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

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            width: 50%;
            padding: 8px;
        }

        input {
            border: 0.5px #000 solid;
            width: 93%;
            padding: 8px;
            border-bottom: 3.5px solid #000;
            border-radius: 4px;
        }

        select {
            border: 1px #000 solid;
            width: 100%;
            padding: 8px;
            border-bottom: 3.5px solid #000;
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
        <h1 class="heading">Edit Staff Details</h1>
        <form action="" method="post">
            <table>
                <tr>
                    <td>
                        First Name:
                        <input type="text" value="<?php echo (isset($fname)) ? $fname : ''; ?>" name="fname"
                            required="">
                    </td>
                    <td>
                        Contact:
                        <input type="tel" value="<?php echo (isset($phno)) ? $phno : ''; ?>" name="phno" required="">
                    </td>
                </tr>
                <tr>
                    <td>
                        Middle Name:
                        <input type="text" value="<?php echo (isset($mname)) ? $mname : ''; ?>" name="mname"
                            required="">
                    </td>
                    <td>
                        District:
                        <input type="text" value="<?php echo (isset($dist)) ? $dist : ''; ?>" name="dist" required="">
                    </td>
                </tr>
                <tr>
                    <td>
                        Last Name:
                        <input type="text" placeholder="Last Name" value="<?php echo (isset($lname)) ? $lname : ''; ?>"
                            name="lname" required="">
                    </td>
                    <td>
                        City:
                        <input type="text" value="<?php echo (isset($city)) ? $city : ''; ?>" name="city" required="">
                    </td>
                </tr>
                <tr>
                    <td>
                        Gender:
                        <select name="gender" required="">
                            <option value="male" <?php if (isset($gender) && $gender == 'male')
                                echo 'selected'; ?>>Male
                            </option>
                            <option value="female" <?php if (isset($gender) && $gender == 'female')
                                echo 'selected'; ?>>
                                Female</option>
                            <option value="other" <?php if (isset($gender) && $gender == 'other')
                                echo 'selected'; ?>>
                                Other</option>
                        </select>
                    </td>
                    <td>
                        Pin:
                        <input type="text" value="<?php echo (isset($pin)) ? $pin : ''; ?>" name="pin" required="">
                    </td>
                </tr>
                <tr>
                    <td>
                        Start Date:
                        <input type="date" value="<?php echo (isset($date)) ? $date : ''; ?>" name="date" required="">
                    </td>
                    <td>
                        Email:
                        <input type="email" value="<?php echo (isset($email)) ? $email : ''; ?>" name="email"
                            required="">
                    </td>
                </tr>
                <tr>
                    <td>
                        Job title:
                        <select name="title" required="">
                            <option value="Staff" <?php if (isset($title) && $title == 'Staff')
                                echo 'selected'; ?>>staff
                            </option>
                        </select>
                    </td>
                    <td>
                        Password:
                        <input type="password" placeholder="Password" name="password" required>
                    </td>
                </tr>
                <tr>
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