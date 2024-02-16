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

if (!empty($_SESSION['userid'])) {
   $user_id = $_SESSION['userid'];

   if (isset($_POST['submit'])) {
      $email = mysqli_real_escape_string($conn, $_POST['email']);
      $password = mysqli_real_escape_string($conn, md5($_POST['password']));
      $phno = mysqli_real_escape_string($conn, $_POST['phno']);
      $name = mysqli_real_escape_string($conn, $_POST['name']);
      $dist = mysqli_real_escape_string($conn, $_POST['dist']);
      $city = mysqli_real_escape_string($conn, $_POST['city']);
      $pin = mysqli_real_escape_string($conn, $_POST['pin']);

      $select = mysqli_query($conn, "SELECT * FROM `tbl_courier` WHERE Cs_Username = '$email'") or die('query failed');

      if (mysqli_num_rows($select) > 0) {
         echo '<p class="msg">Courier already exists</p>';
      } else {


         $minDeliveryDate = $_POST['min_delivery_date'];
         $maxDeliveryDate = $_POST['max_delivery_date'];

         // Get the current date
         $currentDate = date('Y-m-d');

         // Compare the entered dates with the current date
         if ($maxDeliveryDate < $minDeliveryDate) {
            // Max date is before min date
            echo "<p class='msgg'>Maximum delivery date should be after the minimum delivery date.</p>";
         } else {

            $insertt = mysqli_query($conn, "INSERT INTO `tbl_Login`(Username, Password, User_type) VALUES ('$email','$password','Courier')");
            $insert = mysqli_query($conn, "INSERT INTO `tbl_Courier`(Courier_id,Cs_Username, Staff_id, Cs_phno, Cs_name, Cs_dist, Cs_city, Cs_pin,Cs_mindel,Cs_maxdel,Cs_status) VALUES (generate_courier_id(),'$email','$user_id','$phno','$name','$dist','$city','$pin','$minDeliveryDate','$maxDeliveryDate','1')") or die('query failed');

            if ($insert) {
               header('location: courierlist.php');
               exit();
            } else {
               echo '<p class="msg">failed!</p>';
            }
         }
      }
   }
}
?>

<html>

<head>

   <title>Add Courier</title>


   <style>
      .message {
         <?php echo $messageStyle; ?>
      }

      @font-face {
         font-family: 'OstrichSansreg';
         src: url(fonts/OstrichSans-Heavy.otf);
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
         top: 100px;
         max-width: 600px;
         margin: 0 auto;
         padding: 20px;
         background-color: #fff;
         border: 2px solid #ccc;
         border-radius: 10px;
      }

      .msg {
         clip-path: polygon(0 0, 0 calc(100% - 20px), 20px 100%, 100% 100%, 100% 20px, calc(100% - 20px) 0);
         font-family: OstrichSansreg;
         margin-top: 30px;
         position: absolute;
         left: 64vh;
         min-width: 40vh;
         max-height: 40px;
         padding: 8px 20px;
         color: #000;
         text-align: center;
         font-size: 30px;
         background-color: #fff;
      }

      .msgg {
         clip-path: polygon(0 0, 0 calc(100% - 20px), 20px 100%, 100% 100%, 100% 20px, calc(100% - 20px) 0);
         font-family: OstrichSansreg;
         margin-top: 30px;
         position: absolute;
         left: 55vh;
         min-width: 40vh;
         max-height: 40px;
         padding: 8px 20px;
         color: #000;
         text-align: center;
         font-size: 30px;
         background-color: #fff;
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

      p {
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
         top: 15px;
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
         <h1>Courier Registration</h1>
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
                  Courier Name:
                  <input type="text" placeholder="Courier Name" name="name" required="">
               </td>
               <td>
                  District:
                  <input type="text" placeholder="District Name" name="dist" required="">
               </td>
            </tr>
            <tr>
               <td>
                  City:
                  <input type="text" placeholder="City Name" name="city" required="">
               </td>
               <td>
                  Pin:
                  <input type="text" placeholder="Pin Code" pattern="[0-9]{6}" maxlength="6" name="pin" required="">
               </td>
            </tr>
            <tr>
               <td>
                  Contact:
                  <input type="tel" placeholder="Phone Number" pattern="[0-9]{10}" maxlength="10" name="phno"
                     required="">
               </td>
               <td>
                  Minimum Delivery Date:
                  <input type="text" name="min_delivery_date" placeholder="Minimum Number Of Days" maxlength='2'
                     required="">
               </td>
            </tr>
            <tr>
               <td>
                  Maximum Delivery Date:
                  <input type="text" name="max_delivery_date" placeholder="Maximum Number Of Days" maxlength='2'
                     required="">
               </td>
               <td>
                  Email:
                  <input type="email" placeholder="Email" name="email" required="">
               </td>
            </tr>
            <tr>
               <td>
                  Password:
                  <input type="password" placeholder="Password" name="password" required="">
               </td>

            </tr>
         </table>
         <input type="submit" name="submit" value="Register Now" class="button">
      </form>

   </div>

</body>

</html>