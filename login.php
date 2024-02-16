<?php include('header.php') ?>
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
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
   $pas = substr($pass, 0, 10);

   $emailResult = mysqli_query($conn, "SELECT Username FROM `tbl_Login` WHERE username = '$email'");
   $passResult = mysqli_query($conn, "SELECT Password FROM `tbl_Login` WHERE username = '$email'");

   if (mysqli_num_rows($emailResult) > 0) {
      $emailRow = mysqli_fetch_assoc($emailResult);
      $email = $emailRow['Username'];

      if (mysqli_num_rows($passResult) > 0) {
         $passRow = mysqli_fetch_assoc($passResult);
         $ps = $passRow['Password'];

         if ($ps !== $pas) {
            $message[] = '*Your password is incorrect*';
         } else {
            $selectt = mysqli_query($conn, "SELECT * FROM `tbl_Login` WHERE Username = '$email'");
            $user = mysqli_fetch_assoc($selectt);
            $user_type = $user['User_type'];

            if ($user_type == 'User') {
               $selectt = mysqli_query($conn, "SELECT * FROM `tbl_Customer` WHERE Cust_Username = '$email'");
               $user = mysqli_fetch_assoc($selectt);
               $status = $user['Cust_status'];
               if ($status == '1') {
                  $_SESSION['userid'] = $user['Customer_id'];
                  $_SESSION['usertp'] = 'User';
                  $status = $user['Cust_status'];
                  header('location:home.php');
               } else {
                  $msg[] = '*Your account has been Deactivated*';
               }
            } elseif ($user_type == 'Staff') {
               $selectt = mysqli_query($conn, "SELECT * FROM `tbl_Staff` WHERE S_Username = '$email'");
               $user = mysqli_fetch_assoc($selectt);
               $status = $user['S_Status'];
               if ($status == '1') {
                  $_SESSION['userid'] = $user['Staff_id'];
                  $_SESSION['usertp'] = 'Staff';
                  header('location:home.php');
               } else {
                  $msg[] = '*Your account has been Deactivated*';
               }
            } elseif ($user_type == 'Admin') {
               $selectt = mysqli_query($conn, "SELECT * FROM `tbl_Staff` WHERE S_Username = '$email'");
               $user = mysqli_fetch_assoc($selectt);
               $_SESSION['userid'] = $user['Staff_id'];
               $_SESSION['usertp'] = 'Admin';
               header('location:home.php');
            } elseif ($user_type == 'Courier') {
               $selectt = mysqli_query($conn, "SELECT * FROM `tbl_courier` WHERE 	Cs_Username  = '$email'");
               $user = mysqli_fetch_assoc($selectt);
               $status = $user['Cs_Status'];
               if ($status == '1') {
                  $_SESSION['userid'] = $user['Courier_id'];
                  $_SESSION['usertp'] = 'Courier';
                  header('location:dashboard.php');
               } else {
                  $msg[] = '*Your account has been Deactivated*';
               }
            }

         }
      }
   } else {
      $msg[] = '*We cannot find an account with that email address*';
   }
}
?>

<html>
<html>

<head>
   <title>login</title>
   <link rel="stylesheet" href="stile.css">
   <style>
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
         font-family: sans-serif;
         background-image: url("pe3.png");
         background-size: cover;
      }

      .container {
         box-shadow: 0 0px 5px 2px #f9004d;
         background-color: rgba(0, 0, 0, 0.3);
         position: relative;
         top: 110px;
         height: 550px;
         width: 400px;
         margin: 0 auto;
         padding: 20px;
         border-radius: 10px;
      }

      h1 {
         position: absolute;
         top: -10px;
         left: 40px;
         font-family: OstrichSanss;
         font-size: 70px;
         color: #f9004d;
         letter-spacing: 5px;
         font-weight: 100px;
         text-align: center;
      }

      form {

         margin-top: 20px;
      }

      p {
         font-family: 'OstrichSansreg';
         position: absolute;
         bottom: 15vh;
         left: 40px;
         color: #f9004d;
         text-align: center;
         font-size: 25px;
      }

      a {
         color: #fff;
      }

      input[type="text"],
      input[type="email"],
      input[type="password"] {
         position: relative;
         top: 18vh;
         font-family: 'Blender';
         font-size: 20px;
         width: 60%;
         padding: 10px;
         padding-left: 35px;
         color: #fff;
         margin-left: 20px;
         margin-bottom: 40px;
         background: transparent;
         border: transparent;
         border-bottom: 3.5px #f9004d solid;
      }

      .button {
         font-family: 'Phudu', cursive;
         position: absolute;
         bottom: 25vh;
         left: 35px;
         width: 70%;
         text-align: left;
         font-size: 25px;
         padding: 10px;
         background-color: #f9004d;
         color: #000;
         border: 3px #f9004d solid;
         border-radius: 15px;

      }

      .msg {
         position: absolute;
         left: 553px;
         bottom: 70px;
         background-color: #f9004d;
         color: #000000;
         font-family: Unispace;
         width: 400px;
         text-align: center;
         padding: 10px;
         border-radius: 5px;
         font-size: 20px;
      }

      .message {
         position: absolute;
         left: 553px;
         bottom: 80px;
         background-color: #f9004d;
         color: #000000;
         font-family: Unispace;
         width: 400px;
         text-align: center;
         padding: 10px;
         border-radius: 5px;
         font-size: 20px;
      }

      .email::placeholder,
      .pass::placeholder {
         font-size: 20px;
         font-family: 'Blender';
         color: #fff;
         /* Placeholder text color */
      }

      .user-icon {
         position: absolute;
         top: 24.5vh;
         left: 40px;
         font-size: 28px;
         color: #fff;
         /* Change color as needed */
         /* Add more styles here */
      }

      .password-icon {
         position: absolute;
         top: 36vh;
         left: 40px;
         font-size: 28px;
         color: #fff;
         /* Change color as needed */
         /* Add more styles here */
      }

      .fa-chevron-right {
         z-index: 999;
         position: absolute;
         bottom: 26.5vh;
         right: 15vh;
         font-size: 28px;
         color: #000;
         /* Change color as needed */
         /* Add more styles here */
      }
   </style>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

</head>

<body>
   <div class="container">

      <form action="" method="post">
         <h1>LOGIN</h1>
         <i class="fas fa-user user-icon"></i>
         <i class="fas fa-key password-icon"></i>
         <i class="fas fa-chevron-right"></i>

         <input type="email" placeholder="Username" name="email" class="email" required>
         <input type="password" placeholder="Password" name="password" class="pass" required>
         <input type="submit" name="submit" value="LOGIN" class="button">
         <p>Don't have an account? <a href="register.php" style="text-decoration: none;">Sign Up</a></p>
      </form>
   </div>
   <?php
   if (isset($message)) {
      foreach ($message as $message) {
         echo '<div class="message">' . $message . '</div>';
      }
   }
   ?>
   <?php
   if (isset($msg)) {
      foreach ($msg as $msg) {
         echo '<div class="msg">' . $msg . '</div>';
      }
   }
   ?>
</body>

</html>