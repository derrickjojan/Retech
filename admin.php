<?php
$fname = "";
$mname = "";
$dist = "";
$city = "";
$pin = "";
$phno = "";


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
  } elseif (isset($_SESSION['usertp']) && $_SESSION['usertp'] === 'Admin') {

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
  } elseif (isset($_SESSION['usertp']) && $_SESSION['usertp'] === 'User') {

    echo '<script>window.location.href = "home.php";</script>';
  }
}

?>
<!DOCTYPE html>
<html>

<head>
  <title>Admin panel</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


  <style>
    @import url('https://fonts.googleapis.com/css2?family=Barlow:ital@1&display=swap');

    @font-face {
      font-family: 'OstrichSansreg';
      src: url(fonts/OstrichSans-Heavy.otf);
    }

    @font-face {
      font-family: 'OstrichSans';
      src: url(fonts/OstrichSans-Bold.otf);
    }

    @font-face {
      font-family: 'robo';
      src: url(fonts/ROBOT.ttf);
    }

    @font-face {
      font-family: 'Blender';
      src: url(fonts/Blender-Pro-Bold.otf);
    }

    body {
      padding-top: 85px;
      margin: 0;
      padding: 0;
      font-family: 'OstrichSansreg';
      font-size: 20px;
    }

    header {
      overflow: auto;
      position: fixed;
      background: #000000;
      padding: 20px;
      width: 100%;
      height: 30px;
      z-index: 100;
    }

    .sidebar {
      background: #000000;
      margin-top: 70px;
      padding-top: 10px;
      position: fixed;
      left: 0;
      width: 200px;
      height: 100%;
      transition: 0.9s;
      transition-property: left;

    }

    .sidebar a {
      color: #fff;
      display: block;
      width: 100%;
      line-height: 40px;
      text-decoration: none;
      padding-left: 30px;
      box-sizing: border-box;
      transition: 0.5s;
      transition-property: background;
    }

    .sidebar a:hover {
      background: #19B3D3;
    }

    .sidebar i {
      padding-right: 10px;
    }

    label #sidebar_btn {
      position: absolute;
      top: 25px;
      left: 180px;
      color: #fff;
      font-size: 20px;
      margin: 5px 0;
    }

    label #sidebar_btn:hover {
      color: #19B3D3;
    }

    #check:checked~.sidebar {
      left: -130px;
    }

    #check:checked~.sidebar a span {
      display: none;
    }

    #check:checked~.sidebar a {
      font-size: 20px;
      margin-left: 123px;
      width: 77px;
    }

    #check {
      display: none;
    }

    .dropdown {
      position: fixed;
      right: 50px;
      top: 18px;
      z-index: 100;
    }

    .dropdown-content {
      display: none;
      position: absolute;
      right: 0px;
      min-width: 130px;
      background-color: #f9f9f9;

    }

    .dropdown:hover .dropdown-content {
      display: block;

    }

    .dropdown-content a {
      color: black;
      padding: 10px;
      text-decoration: none;
      display: block;
      border: 1px solid #ccc;
    }

    .dropdown-content a:hover {
      background-color: #f1f1f1;
    }

    .dropbtn {
      font-family: 'OstrichSansreg';
      background-color: transparent;
      color: white;
      font-size: 30px;
      border: none;
    }

    .logo a {

      font-family: 'robo';
      font-size: 35px;
      color: #fff;
      text-decoration: none;
    }

    spa {
      font-family: 'robo';
      font-size: 35px;
      color: #f9004d;
    }

    .content.active {
      margin-left: 200px;
      transition: margin-left 0.5s ease;
      width: calc(100% - 200px);
      padding: 20px;
    }
  </style>
</head>

<body>
  <input type="checkbox" id="check">
  <header>
    <div class="logo">
      <a href="home.php">Re<spa>Tech</spa></a>
    </div>
    <label for="check">
      <i class="fas fa-bars" id="sidebar_btn"></i>
    </label>
  </header>
  <div class="sidebar">
    <?php if ($_SESSION['usertp'] === 'Courier') { ?>
      <a href="dashboard.php"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a>
      <a href="orderlist.php"><i class="fas fa-file"></i><span>Assign Orders</span></a>
    <?php } else { ?>
      <a href="dashboard.php"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a>
      <a href="custlist.php"><i class="fa fa-users"></i><span>Customer List</span></a>
      <?php if ($_SESSION['usertp'] === 'Admin'): ?>
        <a href="stafflist.php"><i class="fa fa-users"></i><span>Staff List</span></a>
      <?php endif; ?>
      <a href="courierlist.php"><i class="fa fa-truck"></i><span>Courier List</span></a>
      <a href="vendorlist.php"><i class="fas fa-clipboard-list"></i><span>Vendor List</span></a>
      <a href="itemlist.php"><i class="fa fa-rebel"></i><span>Item List</span></a>
      <a href="corderlist.php"><i class="fa fa-rebel"></i><span>Order List</span></a>
      <a href="purch.php"><i class="fa fa-truck"></i><span>Purchase</span></a>
      <a href="assignlist.php"><i class="fa fa-archive"></i><span>Assign order</span></a>
      <a href="purch_report.php"><i class="fa fa-file"></i><span>Purchase Report</span></a>
      <a href="salesreport.php"><i class="fa fa-file"></i><span>Sales Report</span></a>
      <a href="catlist.php"><i class="fas fa-th-list"></i><span>Category List</span></a>
      <a href="subcatlist.php"><i class="fas fa-th-list"></i><span>Sub Category List</span></a>
      <a href="brandlist.php"><i class="fas fa-th-list"></i><span>Brand List</span></a>
      <a href="messages.php"><i class="fas fa-clipboard-list"></i><span>Messages</span></a>
    <?php } ?>
  </div>
  <div class="dropdown">
    <?php if ($_SESSION['usertp'] === 'Courier'): ?>
      <button class="dropbtn">Courier</button>
      <div class="dropdown-content">
        <a href="alogout.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a>
      </div>
    </div>
  <?php endif; ?>
  <?php if ($_SESSION['usertp'] === 'Admin'): ?>
    <button class="dropbtn">Administrator</button>
    <div class="dropdown-content">
      <a href="alogout.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a>
    </div>
    </div>
  <?php endif; ?>
  <?php if ($_SESSION['usertp'] === 'Staff'): ?>
    <button class="dropbtn">Staff</button>
    <div class="dropdown-content">
      <a href="testprofile.php"><i class="fa fa-users" aria-hidden="true"></i> My Account</a>
      <a href="alogout.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a>
    </div>
    </div>
  <?php endif; ?>


</body>

</html>