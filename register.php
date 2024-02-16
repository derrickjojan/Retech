<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$db = 'retech1';

$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $db);
if ($conn->connect_error) {
    die("Connection failed:" . $conn->connect_error);
}
if (isset($_POST['submit'])) {


    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, md5($_POST['password']));
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $mname = mysqli_real_escape_string($conn, $_POST['mname']);
    if (!empty($mname)) {
        $mname = NULL;
    }
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $dist = mysqli_real_escape_string($conn, $_POST['dist']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $pin = mysqli_real_escape_string($conn, $_POST['pin']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $phno = mysqli_real_escape_string($conn, $_POST['phno']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);


    $select = mysqli_query($conn, "SELECT * FROM `tbl_Customer` WHERE Cust_Username = '$email'") or die('query failed');
    $qry = mysqli_query($conn, "SELECT * FROM tbl_Customer");
    $ph = mysqli_fetch_assoc($qry)['Cust_Phno'];
    if (mysqli_num_rows($select) > 0) {
        $message[] = '*User Already Exist*';
    } else if ($phno == $ph) {
        $message[] = '*Phone number already in use. Try another.*';
    } else {
        $date = date("Y-m-d");
        $insertt = mysqli_query($conn, "INSERT INTO `tbl_Login`(Username,Password,User_type,Date)VALUES('$email','$password','User','$date')");
        $insert = mysqli_query($conn, "INSERT INTO `tbl_Customer`(Customer_id,Cust_Username,Cust_Phno,Cust_Fname,Cust_Mname,Cust_Lname,Cust_DOB,Cust_Gender,Cust_dist,Cust_city,Cust_pin,Cust_status) VALUES(generate_customer_id(),'$email','$phno','$fname','$mname','$lname','$dob','$gender','$dist','$city','$pin','1')") or die('query failed');

        if ($insert) {
            header('location:login.php');
        } else {
            $message[] = 'registeration failed!';
        }
    }
    $messageStyle = '
                    position: relative;
                    left: 90px;
                    background-color: #f9004d; 
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

        @import url('https://fonts.googleapis.com/css2?family=Carter+One&family=Lato&family=Noto+Serif&family=Phudu&display=swap');

        @font-face {
            font-family: 'robo';
            src: url(fonts/ROBOT.ttf);
        }

        @font-face {
            font-family: 'OstrichSanss';
            src: url(fonts/OstrichSans-Bold.otf);
        }

        @font-face {
            font-family: 'OstrichSansreg';
            src: url(fonts/OstrichSans-Heavy.otf);
        }

        @font-face {
            font-family: 'Blender';
            src: url(fonts/Blender-Pro-Bold.otf);
        }

        body {
            font-family: Segoe UI;
            background-image: url("pe4.png");
            background-size: cover;
        }

        .container {
            position: relative;
            top: 40px;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            box-shadow: 0 0px 5px 2px #f9004d;
            background-color: rgba(0, 0, 0, 0.9);
            border-radius: 10px;
        }

        h1 {
            margin: 10px;
            font-family: OstrichSanss;
            font-weight: 800;
            font-size: 50px;
            text-align: center;
            color: #f9004d;
        }

        form {
            color: #fff;
            margin-top: 20px;
        }

        p {
            font-family: 'Phudu', cursive;
            color: #fff;
            text-align: center;
        }

        table {
            font-family: 'Phudu', cursive;
            color: #f9004d;
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 8px;
        }

        input {

            color: #fff;
            border: transparent;
            background: transparent;
            width: 100%;
            padding: 8px;
            border-bottom: 3.5px solid #f9004d;
            border-radius: 4px;
        }

        select {
            color: #fff;
            border: transparent;
            background: transparent;
            width: 100%;
            padding: 8px;
            border-bottom: 3.5px solid #f9004d;
            border-radius: 4px;
        }

        select option {
            background: black;
            color: #fff;
        }


        .button {
            font-family: 'Phudu', cursive;
            position: relative;
            top: 10px;
            left: 150px;
            width: 50%;
            padding: 5px;
            font-size: 20px;
            background-color: #f9004d;
            color: black;
            border: none;
            border-radius: 4px;

        }

        input::placeholder {
            font-size: 15px;
            font-family: 'Blender';
            color: #fff;
            /* Placeholder text color */
        }

        a {
            color: #f9004d;
        }
    </style>

</head>

<body>

    <div class="container">

        <form action="" method="post">
            <h1>Customer Registration</h1>
            <?php
            if (isset($message)) {
                foreach ($message as $message) {
                    echo '<div class="message">' . $message . '</div>';
                }
            }
            ?>
            <table>
                <tr>
                    <td width=50%>
                        First Name
                        <input type="text" placeholder="First Name" name="fname" required>
                    </td>
                    <td>
                        District
                        <input type="text" placeholder="District Name" name="dist" required="">
                    </td>
                </tr>
                <tr>
                    <td>
                        Middle Name
                        <input type="text" placeholder="Middle Name" name="mname">
                    </td>
                    <td>
                        City
                        <input type="text" placeholder="City Name" name="city" required="">
                    </td>
                </tr>
                <tr>
                    <td>
                        Last Name
                        <input type="text" placeholder="Last Name" name="lname" required="">
                    </td>
                    <td>
                        Pin
                        <input type="text" placeholder="Pin Code" pattern="[0-9]{6}" name="pin" required="">
                    </td>
                </tr>
                <tr>
                    <td>
                        Contact
                        <input type="tel" placeholder="Phone Number" pattern="[0-9]{10}" maxlength="10" name="phno"
                            required="">
                    </td>
                    <td>
                        Email
                        <input type="email" placeholder="Email" name="email" required="">
                    </td>
                </tr>
                <tr>
                    <td>
                        Gender
                        <select name="gender" required="">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </td>
                    <td>
                        Password
                        <input type="password" placeholder="Password" name="password" maxlength="10"required="">
                    </td>
                </tr>
                <tr>
                    <td width="50%">
                        Date Of Birth
                        <input type="date" placeholder="Date of Birth" name="dob" required=""
                            max="<?php echo date('Y-m-d'); ?>">
                    </td>

                </tr>
            </table>
            <input type="submit" name="submit" value="Register Now" class="button">
            <p>already have an account? <a href="login.php" style="text-decoration: none;"><span>Login Now</span></a>
            </p>
        </form>

    </div>

</body>

</html>