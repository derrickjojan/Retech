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
      $cnumber=str_replace(" ", "",$_POST['number']);
      $cholder = mysqli_real_escape_string($conn, $_POST['holder']);
      $cdate = mysqli_real_escape_string($conn, $_POST['date']);
      $ccvv = mysqli_real_escape_string($conn, $_POST['cvv']);
      $formattedDate = date('Y-m-d', strtotime($cdate . '-01'));

      $select = mysqli_query($conn, "SELECT * FROM `tbl_Card` WHERE Card_number = '$cnumber' AND customer_id = '$user_id'");
  
      if (mysqli_num_rows($select) > 0) {
        $update_card_query = mysqli_query($conn, "UPDATE tbl_Card SET card_status = 1 WHERE Card_number = '$cnumber' AND customer_id = '$user_id'");
        header('location:payment.php');
      } else {
          $insert = mysqli_query($conn, "INSERT INTO `tbl_card`(Card_id,Customer_id,Card_number, Card_holder, Expiry_date, Card_cvv,Card_status) VALUES (	generate_card_id(),'$user_id', '$cnumber', '$cholder', '$formattedDate', '$ccvv','1')");
  
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
<html>
  <head>
    <title>Add Card</title>
<style>
    /* Import Google Font - Poppins */
    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap");
    @import url('https://fonts.googleapis.com/css2?family=Barlow:ital@1&display=swap');
    @font-face {
        font-family: 'Blender';
        src: url(fonts/Blender-Pro-Bold.otf);
      }
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Blender';
    }
body {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  background-image: url("pe1.png");
  background-size: cover;
  position: relative; /* Add relative positioning to the body */
}

/* Create a semi-transparent overlay */
body::before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.1); /* Adjust the opacity (0.5 is 50%) */
  z-index: -1; /* Place the overlay behind the content */
}

    
    .container {
      position: relative;
      background-image: url("bg1.png");
      background-size: cover;
      padding: 25px;
      border-radius: 60px;
      width: 800px;
      height: 500px;
      box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
    }

    .logo {
      display: flex;
      align-items: center;
    }
    /* Add these styles to your existing CSS code */
.logo a {
    margin-left: 20px;
  color: #fff; /* Link color */
  text-decoration: none; /* Remove underline */
  display: flex; /* Align items horizontally */
  align-items: center; /* Vertically center items */
}
.credit{
    color:#fff;
    position: relative;
    left:1vh;
    font-size: 45px;
    font-family: 'Blender';
}
.logo i {
  font-size: 70px; /* Adjust the icon size */
  margin-right: 5px; /* Space between icon and text */
}

    .logo img {
        position:absolute;
      width: 125px;
      right:40px;
      top:80px;
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
.number {
  position: absolute;
    color:#fff;
    font-size: 40px;
  width: 95%;
  padding: 10px;
  margin-top: 50px;
  margin-bottom: 20px;
  border: transparent;
  background: transparent;
}
.name {
  width: 55%;
  padding: 10px;
  position: absolute;
  bottom:35px;
  right:35px;
  border: transparent;
  background: transparent;
  color:#fff;
  font-size: 35px;
}
.exdate-container {
    position: relative;
    top:20vh;
    left:45vh;
    width: 100px;
    
  }
  .exdate {
    opacity: 0;
    position: absolute;
    top: 0;
    left: 0;
    width:115%;
    background: transparent;
    font-size: 30px;
  }
  #formatted-exdate {
    color:#fff;
    border: none;
    background: transparent;
    font-size: 35px;
  }
.cvv{
  width: 21%;
  padding: 10px;
 position: absolute;
 left:80px;
 bottom:17vh;
 color:#fff;
 font-size: 35px;
  border: 2px solid #ccc;
  border-radius: 10px;
  border: transparent;
  background: transparent;
}
	 
button {
  position: relative;
  top: 48vh;
  left: 72vh;
  width: 30%;
  padding: 10px;
  border-radius: 10px;
  color: #fff;
  border: none;
  background-image: url("bg1.png"); /* Add this line to set the background image */
  background-size: cover; /*  the background size as needed */
  background-repeat: no-repeat; /* Prevent the background image from repeating */
}
/* Style placeholder for input fields */
.number::placeholder,
.name::placeholder,
.cvv::placeholder,
#formatted-exdate::placeholder {
  color: #fff; /* Placeholder text color */
}

  </style>    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
  <body >
      <div class="container">
      <div class="logo">
            <a href="#"><i class="fa fa-rebel"></i></a>
            <h1 class= "credit">Credit/Debit Card</h1>
          <img src="chip.png" alt="" class="chip" />
      </div>
      <form action="" method="post"> <!-- Corrected: One form for all input fields -->

      <input type="text" name="number" id='expiry'class="number" placeholder="Enter Card Number" maxlength="19">


        <input type="text" name="holder" class='name' placeholder="Enter Card Holder Name" required="">
        <div class="exdate-container">
    <input type="text" id="formatted-exdate" placeholder="MM/YY">
    <input type="month" id="expiry-month" class="exdate" name="date" required>
  </div>
<script>
  var formattedExdate = document.getElementById("formatted-exdate");
  var expiryMonth = document.getElementById("expiry-month");

  formattedExdate.addEventListener("click", function() {
    formattedExdate.style.display = "none";
    expiryMonth.style.opacity = "1";
    expiryMonth.focus();
  });

  expiryMonth.addEventListener("blur", function() {
    if (!expiryMonth.value) {
      formattedExdate.style.display = "block";
      expiryMonth.style.opacity = "0";
    }
  });

  expiryMonth.addEventListener("change", function() {
    var selectedMonth = expiryMonth.value;
    var formattedMonth = selectedMonth.replace("-", "/");
    formattedExdate.value = formattedMonth;
  });
</script>

<script>
    var currentDate = new Date();
    
    // Get the current year and month in the format "YYYY-MM"
    var currentYearMonth = currentDate.toISOString().slice(0, 7);
    
    // Set the minimum value for the input field to the current year and month
    document.getElementById("expiry-month").min = currentYearMonth;
</script>




      <input type="tel" name="cvv" class='cvv'placeholder="Enter CVV" maxlength="3" minlength="3">
        <button type="submit" name="submit">Submit</button>
    </form>
    </div>
    <script>

document.querySelector('.number').addEventListener('input', function (e) {
    var input = e.target;
    var value = input.value.replace(/\s+/g, '').replace(/(\d{4})/g, '$1 ').trim();
    input.value = value;
});
    
</script>
  </body>
</html>
