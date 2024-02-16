<!DOCTYPE html>
<html lang="en">
<head>

  <title>Payment Successful</title>
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
  top:25vh;
  margin-bottom: 20px;
}

.success-message h1 {
  font-family: 'BlenderPro';
  font-size: 36px;
  color: #f9004d;
  margin: 10px 0;
}

.success-message p {
  color: #fff;
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
  font-family: 'BlenderPro';
  display: inline-block;
  padding: 10px 20px;
  margin: 10px;
  background-color: #f9004d;
  border:#f9004d solid;
  color: #fff;
  text-decoration: none;
  border-radius: 5px;
  font-size: 18px;
}

.btn:hover {
  font-family: 'BlenderPro';
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body bgcolor="black">
<div class="container">
    <div class="success-message">
        <div class="verified-badge">
            <i class="fas fa-check"></i>
        </div>
        <h1>Payment Successful!</h1>
        <p>Your payment has been processed successfully.</p>
        <p>Thank you for choosing our services.</p>
        <div class="options">
            <a href="home.php" class="btn">Go to Home</a>
            <a href="orders.php" class="btn">Go to Orders</a>
            <button onclick="printAndClose()" class='btn'>Print Receipt</button>
        </div>
    </div>
</div>
<script>
  function printAndClose() {
    var printWindow = window.open("receipt.php", "_blank");
    printWindow.onload = function() {
      printWindow.print();
      printWindow.onafterprint = function() {
        printWindow.close();
      };
    };
  }
</script>
</body>
</html>
