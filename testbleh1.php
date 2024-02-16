<?php

$dbhost='localhost';
$dbuser='root';
$dbpass='';
$db='retech';
$conn = mysqli_connect($dbhost,$dbuser,$dbpass,$db);
if ($conn->connect_error) 
{
    die("Connection failed:" . $conn->connect_error);
}


if (isset($_POST['login'])) {

  $email = $_POST['email'];
  $password = $_POST['password'];

  $sql = "SELECT * FROM tbl_login WHERE Username = '$email' AND Login_pswd = '$password'";
  $result = mysqli_query($conn, $sql);
  $num = mysqli_num_rows($result);

  if ($num == 1) {
    $row = mysqli_fetch_assoc($result);
    $user_type = $row['type'];

    if ($user_type == 'customer') {
      echo ('Customer');
      $sql1 = "SELECT Customer_id FROM tbl_customer WHERE Username = '$email'";
      $result1 = mysqli_query($conn, $sql1);

      if ($result1) {
        $user_id = mysqli_fetch_assoc($result1)['Customer_id'];
        $_SESSION['User_ID'] = $user_id;
        echo "<script>alert('Login successful!');</script>";
        header("Location: session1.php");
        exit(); // It's a good practice to add an exit after redirection.
      }
    } else if ($user_type == 'staff') {
      echo ('Staff');
      $sql1 = "SELECT Staff_id FROM tbl_staff WHERE Username = '$email'";
      $result1 = mysqli_query($conn, $sql1);

      if ($result1) {
        $user_id = mysqli_fetch_assoc($result1)['Staff_id'];
        $_SESSION['User_ID'] = $user_id;
        echo "<script>alert('Login successful!');</script>";
        header("Location: session1.php");
        exit(); // It's a good practice to add an exit after redirection.
      }
    } else if ($user_type == 'admin') {
      echo ('Admin');
      /*$sql1 = "SELECT Admin_id FROM tbl_admin WHERE Username = '$email'";
      $result1 = mysqli_query($conn, $sql1);

      if ($result1) {
        $user_id = mysqli_fetch_assoc($result1)['Admin_id'];*/
        $_SESSION['User_ID'] = $email;
        echo "<script>alert('Admin Login successful!');</script>";
        header("Location: adminnew.php");
        exit(); // It's a good practice to add an exit after redirection.
    //  }
    }
  } else {
    echo "<script>alert('Invalid Credentials!');</script>";
  }
}
?>


<html>
<head>
<title>PresentPerfect</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class ="main">
<div class ="navbar">
<div class ="icon">
<h2 class="logo">Present Perfect</h2>
</div>
<div class ="menu">

<ul>
<li><a href="#">HOME</a></li>
<li><a href="#">ABOUT</a></li>
<li><a href="#">CONTACT</a></li>
<li><a href="#"></a></li>
</ul>

</div>
<form action="#" method="POST">
<div class="form">
<h2>Login Here</h2>
<input type="email" name="email" placeholder="Enter email">
<input type="password" name="password" placeholder="Enter Password">
<button class="btn" name="login">Login</button>

<p class="link">Don't have an account..?<br>
<a href="custreg.php">Sign up here</a></p>
</div>
</div>
</div>
</form>
</body>
</html>