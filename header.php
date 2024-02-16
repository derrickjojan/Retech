<?php 
session_start();
?>

<html>
<html>
<head>
   <title>login</title>
   <link rel="stylesheet" href="stile.css">
   <style>

      @font-face {
        font-family: 'OstrichSans';
        src: url(fonts/OstrichSans-Bold.otf);
      }
      @font-face {
        font-family: 'OstrichSansreg';
        src: url(fonts/OstrichSans-Heavy.otf);
      }
      @font-face {
        font-family: 'robo';
        src: url(fonts/ROBOT.ttf);
      }

body{
  font-family:OstrichSans;

  
}
span{
  font-family: 'robo';
  color: #fff;

}
nav{
  box-shadow: 0 0px 5px 2px red;
  position: absolute;
  left:0px;
  top:0px;
  width:1388px;
  padding: 20px 70px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  background-color: rgba(0, 0, 0, 0.9); 
}
.logo a{
   position:relative;
   right:30px;
   font-family: 'robo';
   font-size: 50px;
  color:#f9004d;
  text-decoration: none;
}
.topnav {
  position:absolute;
  right:10px;
  overflow: hidden;
}

.topnav a {
  float: left;
  color: #f2f2f2;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 40px;
  font-family:OstrichSansreg;
}

.topnav a:hover {
  background-color: #ddd;
  color: #f9004d;
}

      </style>

</head>
 <nav>
      <div class="logo">
        <a href="home.php">Re<span>Tech</span></a>
      </div>
	<div class="topnav">
        <?php
        if(isset($_SESSION['userid']))
          {
        ?> 	
           <a href="home.php">Home</a>
           <a href="about.php">About</a>
        <a href="logout.php">Logout</a>
        <?php
          }
          else
          {
        ?>
           <a href="home.php">Home</a>
          <a href="login.php">Login</a>
          <a href="register.php">Sign Up</a>
        <?php
          }
        ?>  
    </div>
    </nav>
</body>
</html>