<?php
$fname = ""; 
$mname = "";
$dist = "";
$city = "";
$pin = "";
$phno = "";



$dbhost='localhost';
$dbuser='root';
$dbpass='';
$db='retech1';
$conn = mysqli_connect($dbhost,$dbuser,$dbpass,$db);
if ($conn->connect_error) 
{
  die("Connection failed:" . $conn->connect_error);
}

session_start();

if(!empty($_SESSION['userid'])) {
  $user_id = $_SESSION['userid'];

  if (isset($_SESSION['usertp']) && $_SESSION['usertp'] === 'User') {

    $result_displayValues = mysqli_query($conn, "SELECT * FROM tbl_Customer where Customer_id = '$user_id'");
    $row_displayValues = mysqli_fetch_assoc($result_displayValues);
  

    $email = $row_displayValues['Cust_Username'];
    $fname = $row_displayValues['Cust_Fname'];
    $mname = $row_displayValues['Cust_Mname'];
    $lname = $row_displayValues['Cust_Lname'];
    $dist = $row_displayValues['Cust_dist'];
    $city = $row_displayValues['Cust_city'];
    $pin = $row_displayValues['Cust_pin'];
    $gender = $row_displayValues['Cust_Gender'];
    $phno = $row_displayValues['Cust_Phno'];
    $dob = $row_displayValues['Cust_DOB'];
  } 
  elseif (isset($_SESSION['usertp']) && $_SESSION['usertp'] === 'Staff') {

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
  }
  elseif (isset($_SESSION['usertp']) && $_SESSION['usertp'] === 'Admin') {
  }
  $select = mysqli_query($conn, "SELECT COUNT(*) AS cartrow FROM tbl_cart_child WHERE Mastercart_id IN (SELECT Mastercart_id FROM tbl_cart_master WHERE Customer_id = '$user_id' AND Cart_status = 'N')");
$row = mysqli_fetch_assoc($select);
$cartrow = $row['cartrow'];
}
$Vendor = mysqli_query($conn, "SELECT Vendor_id,Vendor_Status FROM `tbl_Vendor` WHERE Customer_id = '$user_id'");
if (mysqli_num_rows($Vendor) > 0) {
  $ven = mysqli_fetch_assoc($Vendor);
  $vendorid = $ven['Vendor_id'];
  $vendorstatus=$ven['Vendor_Status'];
} else {
  $vendorstatus = '1';
}

?>
<html>
<head>
<style>
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

body{
  color: #fff;
}
nav{
  font-family: OstrichSansreg;
  position: relative;
  left:25px;
  width:1450px;
  margin-left: 15px;
  padding-top: 25px;
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.logo a{
  position: relative;
  top:9px;
  font-family: 'robo';
  font-size: 50px;
  text-decoration: none;
}
.topnav {
  position:relative;
  top:5px;
  right: 33%;
}
.topnav a {

  color: #f2f2f2;

  padding: 14px 16px;
  text-decoration: none;
  font-size: 30px;
}
.top {
  position:absolute;
  top:30px;
  right:0px;
}
.top a {
  color: #f2f2f2;
  padding: 14px 10px;
  text-decoration: none;
  font-size: 30px;
}
.top a:hover{
  color: #f9004d;
}
.topnav a:hover {
  background-color: #ddd;
  color: #f9004d;
  border-radius: 5px;
}
.topnav .btn {

  color: #f9004d;
  text-align: center;
  padding: 8.5px 10px;
  text-decoration: none;
  font-size: 30px;
  border: none;
  border-radius: 5px;
}
.topnav .btn:hover {
  background-color: #2f2f2f;
  color: #f9004d;
  border-radius: 5px;
  border: none;
}
a{
  text-decoration: none;
  color:#fff;
}
span{
  font-family: 'OstrichSans';
  color: #f9004d;
}
sp{
  font-family: 'OstrichSansreg';
  color: #f9004d;
}
spn{
  font-family: 'robo';
  color: #f9004d;
}
*::-webkit-scrollbar{
   height: .5rem;
   width: 10px;
}

*::-webkit-scrollbar-track{
   background-color: rgba(17, 11, 28, 0.9);
}

*::-webkit-scrollbar-thumb{
   background-color: black;
}

div#overlay {
	display: none;
	background: #000;
	position: fixed;
	width: 100%;
	height: 100%;
	top: 0px;
	left: 0px;
  z-index: -1;

}
div#specialBox {
  width: 340px;
	display: none;
	position: absolute;
  top: 100px;
  right:100px;
	color: #000;
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
  z-index: 9999;
  
}

.card{
  width: 340px;
  height: 370px;
  background: #fff;
  border-radius: 10px;
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
  display: flex;
  flex-direction: column;
  z-index: 9999;
}

.card-image img{
  position: relative;
  width: 100%;
  height: 90px;
  border-top-left-radius: 10px;
  border-top-right-radius: 10px;
  object-fit: cover;
  
}

.card-content h3{
  font-family: "Candara", sans-serif;
  padding-top:10px;
  font-size: 30px;
  text-align: center;
  margin: 0;
}
.card-content p{
  font-family: "Candara", sans-serif; 
  text-transform: uppercase;
  font-family: Candara;
  font-size: 22px;
  font-weight: 200px;
  text-align: justify;
  padding: 25 0px 0px 70px;
  
}
.card-content i.fa::before {
  font-size: 24px; 

  
}
.card-content i.fa-users::before {
 position:absolute;
 top:162px;
 left:10%;
}
.card-content i.fa-address-card::before {
  position:absolute;
  top:215px;
 left:10%;
}
.card-content i.fa-phone-square::before {
  position:absolute;
  top:323px;
 left:12%;
}
.button {
  font-family: 'karla', sans-serif;
    position: absolute;
    left: 165px;
    top:103%;
    width: 50%;
    padding: 10px;
    background-color:#fff;
    color: #EF1325;
    border: none;
    border-radius: 4px;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
    text-decoration: none;
    text-align: center;

}
.lbutton {
  font-family: 'karla', sans-serif;
    position: absolute;
    right:185px;
    top:103%;
    width: 45%;
    padding: 10px;
    background-color:#fff;
    color: #EF1325;
    border: none;
    border-radius: 4px;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
    text-decoration: none;
    text-align: center;

}
.cyber-glitch-2
{
  padding: 1px 1px;
    animation: cyber-glitch-2 3s linear infinite;
    
}

@keyframes cyber-glitch-2 
{
    0% {clip-path: var(--og-clip-path); transform: translateX(0); text-shadow: none;}
    2% {clip-path: polygon(0 40%, 0 100%, 100% 100%, 100% 40%); transform: translateX(0); text-shadow: var(--cyan) 1px 1px, var(--yellow) -1px -1px;}
    4% {clip-path: polygon(0 40%, 0 100%, 100% 100%, 100% 40%); transform: translateX(-1rem); text-shadow: var(--cyan) 1px 1px, var(--yellow) -1px -1px;}
    6% {clip-path: polygon(0 40%, 0 100%, 100% 100%, 100% 40%); transform: translateX(1rem); text-shadow: var(--cyan) 1px 1px, var(--yellow) -1px -1px;}
    8% {clip-path: polygon(0 40%, 0 100%, 100% 100%, 100% 40%); transform: translateX(0); text-shadow: var(--cyan) 1px 1px, var(--yellow) -1px -1px;}
    12% {clip-path: polygon(0 10%, 0 40%, 100% 40%, 100% 10%); transform: translateX(0); text-shadow: var(--cyan) 1px 1px, var(--yellow) -1px -1px;}
    14% {clip-path: var(--og-clip-path); transform: translateX(0); text-shadow: none;}
    100% {clip-path: var(--og-clip-path); transform: translateX(0); text-shadow: none;}
}
.cyber-tile,
.cyber-tile-small,
.cyber-tile-big
{
    --tile-width: 150px;
    --tile-height: 10px;
    --tile-padding: 4px;
    --tile-edges: 20px;
    --label-margins: calc(var(--tile-edges) - var(--tile-padding));
    --og-clip-path: polygon(0 0, 0 calc(100% - var(--tile-edges)), var(--tile-edges) 100%, 100% 100%, 100% var(--tile-edges), calc(100% - var(--tile-edges)) 0);
    width: var(--tile-width);
    clip-path: var(--og-clip-path);
    padding: var(--tile-padding);

}

.bg-red { --bg: var(--red); background-color: var(--red); }
.fg-white { --fg: var(--white); color: var(--white) !important; }
:root 
{
    --root-font-size: 18px;

    --yellow: #f8ef02;
    --cyan: #00ffd2;
    --red: #ff003c;
    --blue: #136377;
    --green: #446d44;
    --purple: purple;
    --black: #000;
    --white: #fff;
    --dark: #333;
}
</style>
<script>
function toggleOverlay(){
	var overlay = document.getElementById('overlay');
	var specialBox = document.getElementById('specialBox');
	overlay.style.opacity = .8;
	if(overlay.style.display == "block"){
		overlay.style.display = "none";
		specialBox.style.display = "none";
	} else {
		overlay.style.display = "block";
		specialBox.style.display = "block";
	}
}
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</head>
<body>
<header>
<nav>
      <div class="logo">
        <a href="home.php" class="fg-white cyber-glitch-2"  >Re<spn>Tech</spn></a>
      </div>
	<div class="topnav">
    <a class="active" href="home.php">Home</a>
    <a class="active" href="product.php">Products</a>
    <?php if(!empty($_SESSION['userid'])) {
  if ($_SESSION['usertp'] === 'Staff' || $_SESSION['usertp'] === 'Admin' || $_SESSION['usertp'] === 'Courier') {
    echo '<a href="home.php" class="active">Orders</a>';
  }else
  {?>
     <a href="orders.php" class="active">Orders</a>
<?php
    }
  }else{
     echo '<a href="login.php" class="active">Orders</a>';
}
?>
    <a class="active" href="about.php">About</a>
    <?php if(!empty($_SESSION['userid'])) {
  if ($_SESSION['usertp'] === 'Staff' || $_SESSION['usertp'] === 'Admin'|| $_SESSION['usertp'] === 'Courier') {
    echo '<a href="home.php" class="active">Contact Us</a>';
  }else
  {?>
     <a href="contacts.php" class="active">Contact Us</a>
<?php
    }
  }else{
     echo '<a href="contacts.php" class="active">Contact Us</a>';
}
?>
  </div>
  <div class="top">
    <?php
  if (isset($_SESSION["userid"])) {
    if ($_SESSION['usertp'] === 'User' || $_SESSION['usertp'] === 'Staff') {
        echo '<a onmousedown="toggleOverlay()" id="user-btn" class="fas fa-user"></a>';
    } elseif ($_SESSION['usertp'] === 'Admin'||$_SESSION['usertp'] === 'Courier') {
      echo '<a id="user-btn" class="fas fa-user" href="dashboard.php"></a>';
    }
  } else 
  {
    echo '<a id="user-btn" class="fas fa-user" href="login.php"></a>';
  }
    ?>
     <a href="search_page.php" class="fas fa-search"></a>
<?php if(!empty($_SESSION['userid'])) {
  if ($_SESSION['usertp'] === 'Staff' || $_SESSION['usertp'] === 'Admin' || $_SESSION['usertp'] === 'Courier') {
    echo '<a href="home.php"><i class="fas fa-shopping-cart"></i></a>';
  }else
  {?>
     <a href="cart.php"><i class="fas fa-shopping-cart"></i><sp>(<?php echo $cartrow ?>)</sp></a>
<?php
    }
  }else{
     echo '<a href="login.php"><i class="fas fa-shopping-cart"></i></a>';
}
?>

<?php if(!empty($_SESSION['userid'])) {
  if ($_SESSION['usertp'] === 'Staff' || $_SESSION['usertp'] === 'Admin' ||$_SESSION['usertp'] === 'Courier') {
    echo '<a href="home.php" class="cyber-tile bg-red fg-white cyber-glitch-2" class="back" style="padding: 8px 17px;">+ SELL</a>';
  }else if($vendorstatus == '0'){?>
    <a href="#" class="delete-link" data-item-id="<?php echo $id; ?>">+ Sell</a>
    <?php
  }else 
  {?>
      <a href="sell.php" class="cyber-tile bg-red fg-white cyber-glitch-2" class="back" style="padding: 8px 17px;">+ SELL</a>
<?php
    }
  }else{
     echo '<a href="login.php" class="cyber-tile bg-red fg-white cyber-glitch-2" class="back" style="padding: 8px 17px;">+ SELL</a>';
}
?>

  </div>
    </nav>
</header>
<div id="overlay" onclick="toggleOverlay()"></div>
  <div id="specialBox">
    <div class="card">
      <div class="card-image">
            <img src="103.png" alt="">
      </div>

      <div class="card-content">
            <h3>Profile</h3>
            <p><i class="fa fa-users" aria-hidden="true"></i><?php echo $fname; ?> <?php echo $mname; ?></p>
            <p><i class="fa fa-address-card" aria-hidden="true"></i><?php echo $dist; ?></p>
            <p><?php echo $city; ?>,<?php echo $pin; ?></p> 
            <p><i class="fa fa-phone-square" aria-hidden="true"></i><?php echo $phno; ?></p> 
      </div>
        <?php if ($_SESSION['usertp'] === 'User'): ?>
            <a href="udateprofile.php" class="button">Update</a>
        <?php endif; ?>
        <?php if ($_SESSION['usertp'] === 'Staff'): ?>
            <a href="dashboard.php" class="button">Panel</a>
        <?php endif; ?>
        <a href="logout.php" class="lbutton">Logout</a>
    </div>
  </div>
</div>
 </body>
 <script>
          var deleteLinks = document.querySelectorAll('.delete-link');

deleteLinks.forEach(function (deleteLink) {
    deleteLink.addEventListener('click', function (event) {
        event.preventDefault();
        var alert = confirm('Permission Denied, Please Contact Admin');
       
    });
});
</script>