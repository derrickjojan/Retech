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

$item_id = null; // Initialize the variable

if (!empty($_SESSION['itemid'])) {
  $item_id = $_SESSION['itemid'];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Payment Successful</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <style>
           @font-face {
        font-family: 'BlenderPro';
        src: url(fonts/BlenderPro-Medium.woff);
      }
      @font-face {
        font-family: 'BlenderProt';
        src: url(fonts/BlenderPro-Thin.woff);
      }
      @font-face {
        font-family: 'robo';
        src: url(fonts/ROBOT.ttf);
      }

  /* Reset some default styling */
body, h1, p {
  margin: 0;
  padding: 0;
}

.container {
  display: flex;
  flex-direction: column;
  height: 100vh;

}

.success-message {
  text-align: center;
  position: relative;
  top:21vh;
  margin-bottom: 20px;
}

.success-message h1 {
  font-family: 'BlenderPro';
  font-size: 36px;
  color: #f9004d;
  margin: 10px 0;
}

.success-message p {
  color:#fff;
  font-family: 'BlenderProt';
  font-size: 30px;
  font-weight: bold;
  margin: 5px 0;
}

.options {
  font-family: 'BlenderPro';
  display: flex;
  justify-content: center;
}

.btn {
  position:absolute;
  top:40vh;
  left:85vh;
  padding: 10px 61px;
  margin: 10px;
  background-color: #f9004d;
  color: #fff;
  border: #f9004d solid;
  text-decoration: none;
  border-radius: 5px;
  font-size: 20px;
}
.bttn {
  position:absolute;
  top:47vh;
  left:85vh;
  display: inline-block;
  padding: 10px 62px;
  margin: 10px;
  background-color: #fff;
  border:#f9004d solid;
  color:#000;
  text-decoration: none;
  border-radius: 5px;
  font-size: 20px;
}
.btn:hover {
  background-color: #fff;
  border:#f9004d solid;
  color:#000;
    
}
.bttn:hover {
  background-color: #fff;
  border:#f9004d solid;
  color:#000;
    
}
/* Custom styling for the verified badge */
.verified-badge {
    display: inline-block;
    background-color: #3897f0;
    color: white;
    border-radius: 60%;
    padding: 0.30em;
    font-size:55px;
    box-shadow: 0 0px 0px rgba(0, 0, 0, 0.9);
}

  </style>
</head>
<body bgcolor="black">
  <div class="container">
    <div class="success-message">
      <div class="verified-badge">
        <i class="fas fa-check"></i>
      </div>
      <h1>Congratulations!</h1>
      <h1>Your Ad will go live shortly...</h1>
      <p>Your Ad has been Posted successfully.</p>
      <p>Thank you for choosing our services.</p>
      <div class="options">
        <a href="home.php" class="btn">Go to Home</a>
          <a href="#" class="bttn preview-link" data-item-id="<?php echo $item_id; ?>">Preview Ad</a>
      </div>
    </div>
  </div>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      var previewLink = document.querySelector('.preview-link');

      if (previewLink) {
        previewLink.addEventListener('click', function(event) {
          event.preventDefault();

          var itemId = previewLink.getAttribute('data-item-id');
          var url = 'item.php?id=' + itemId;
          window.location.href = url;
        });
      }
    });
  </script>
</body>
</html>
