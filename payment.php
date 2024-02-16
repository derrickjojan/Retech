<?php include 'head.php'; ?>
<?php

if (isset($_POST['remove_card'])) {
  $card_id_to_remove = mysqli_real_escape_string($conn, $_POST['remove_card']);

  // Check if the card ID is used in the Payment table
  $check_payment_query = mysqli_query($conn, "SELECT Payment_id FROM tbl_Payment WHERE Card_id = '$card_id_to_remove'");

  if (mysqli_num_rows($check_payment_query) > 0) {
    // Card is used in payments, update card_status to 0
    $update_card_query = mysqli_query($conn, "UPDATE tbl_Card SET card_status = 0 WHERE Card_id = '$card_id_to_remove'");
  } else {
    // Card is not used in payments, delete the card entry
    $delete_query = mysqli_query($conn, "DELETE FROM tbl_Card WHERE Card_id = '$card_id_to_remove'");
  }

  // Reload the page using JavaScript only once
  echo '<script>window.location.href = "payment.php";</script>';
}


if (isset($_SESSION['price'])) {
  $totalPrice = $_SESSION['price'];
}
if (isset($_POST['payment'])) {
  if (isset($_POST['selectedCard'])) {
    $selectedCardID = mysqli_real_escape_string($conn, $_POST['selectedCard']);
    $enteredCVV = mysqli_real_escape_string($conn, $_POST['cvv_' . $selectedCardID]);

    $cvvCheckQuery = mysqli_query($conn, "SELECT Card_cvv, Expiry_date FROM tbl_Card WHERE Card_id = '$selectedCardID'");
    $cardrow = mysqli_fetch_assoc($cvvCheckQuery);
    $storedCVV = $cardrow['Card_cvv'];
    $cardExpiry = $cardrow['Expiry_date'];

    $currentDate = date("Y-m-d");
    if ($currentDate > $cardExpiry) {
      echo '<p class="msg">Card Expired</p>';
    } else {
      if ($enteredCVV === $storedCVV) {
        // CVV matches, proceed with payment
        // Your existing code to process the order and calculate total price

        // Get the Mastercart_id associated with the user
        $selectMastercart = mysqli_query($conn, "SELECT Mastercart_id FROM tbl_cart_master WHERE Customer_id = '$user_id'AND Cart_status = 'N'");
        $mastercartID = mysqli_fetch_assoc($selectMastercart)['Mastercart_id'];

        // Insert a record into the Payment table
        $paymentDate = date("Y-m-d H:i:s"); // Get the current date and time

        $sql = mysqli_query($conn, "SELECT generate_payment_id() AS new_payment_id");
        if ($sql) {
          $newpay = mysqli_fetch_assoc($sql)['new_payment_id'];
          $_SESSION['payid'] = $newpay;
        } else {
          // Handle the error
          echo "Error: " . $conn->error;
        }

        $paymentInsert = mysqli_query($conn, "INSERT INTO tbl_Payment (Payment_id,Mastercart_id, Card_id, Payment_amount, Payment_date) VALUES ('$newpay','$mastercartID', '$selectedCardID', '$totalPrice', '$paymentDate')");

        if ($paymentInsert) {
          // Update the Cart_status
          $updateCartStatus = mysqli_query($conn, "UPDATE tbl_cart_master SET Cart_status = 'P' WHERE Mastercart_id = '$mastercartID'");

          $child = mysqli_query($conn, "SELECT Item_id FROM tbl_cart_child WHERE Mastercart_id = '$mastercartID'");

          // Iterate through all items in the cart
          while ($row = mysqli_fetch_assoc($child)) {
            $item = $row['Item_id'];

            // Fetch the quantity for the current item
            $select_cart = mysqli_query($conn, "SELECT qty FROM tbl_Cart_child WHERE Item_id = '$item' AND Mastercart_id = '$mastercartID'");
            $qty = mysqli_fetch_assoc($select_cart)['qty'];

            // Update the stock for the current item
            $result = mysqli_query($conn, "UPDATE tbl_purchasechild SET stock = stock - '$qty' WHERE Item_id = '$item'");
          }

          if ($updateCartStatus) {
            echo '<script>window.location.href = "success.php";</script>';
          } else {
            echo "Cart status update failed.";
          }

        } else {
          echo "Payment record insertion failed.";
        }
      } else {
        echo '<p class="msg">CVV verification failed.</p>';
      }
    }
  } else {
    echo '<p class="msg">Please select a card.</p>';
  }
}


?>

<html>

<head>
  <title>Payment</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

  <style>
    .container {
      overflow: none;

    }

    .card-content p {
      font-family: "Candara", sans-serif;
      text-transform: uppercase;
      font-family: Candara;
      font-size: 22px;
      font-weight: 200px;
      text-align: justify;
      padding: 4 0px 0px 70px;

    }

    .msg {
      clip-path: polygon(0 0, 0 calc(100% - 20px), 20px 100%, 100% 100%, 100% 20px, calc(100% - 20px) 0);
      font-family: OstrichSansreg;
      margin-top: 20px;
      position: absolute;
      left: 55vh;
      bottom: 31.5vh;
      width: 40vh;
      max-height: 40px;
      padding: 8px 20px;
      color: #f2f2f2;
      text-align: center;
      font-size: 30px;
      background-color: #f9004d;
    }

    .proceed {
      clip-path: polygon(0 0, 0 calc(100% - 20px), 20px 100%, 100% 100%, 100% 20px, calc(100% - 20px) 0);
      font-family: OstrichSansreg;
      margin-top: 20px;
      position: fixed;
      right: 10vh;
      bottom: 33vh;
      width: 54vh;
      max-height: 55px;
      padding: 8px 20px;
      color: #f9004d;
      font-size: 30px;
      background-color: #fff;
    }

    .proceed:hover {
      color: #000;
      background-color: #f9004d;
    }

    .products {
      border: #fff solid;
      padding-bottom: 30px;
      margin-top: 30px;
      min-height: 85vh;
      background-color: rgba(0, 0, 0, 0.9);
      border-radius: 20px;
    }


    video {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      z-index: -1;
    }

    .total-price {
      font-family: OstrichSansreg;
      background-color: rgba(17, 11, 28, 0.8);
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
      position: fixed;
      right: 10vh;
      bottom: 42.5vh;
      width: 400px;
      border: 3px #f9004d solid;
      border-radius: 4px;
      min-height: 230px;
      max-height: 230px;
    }

    .total-price h3 {

      position: relative;
      bottom: 10px;
      font-size: 30px;
      color: #f9004d;
      margin: 0px;
      margin-left: 25px;
      padding-top: 25px;
    }

    .details {
      border-bottom: 3px #f9004d solid;
      font-size: 29px;
      color: #f9004d;
      margin-bottom: 0px;
    }

    .total-price p {
      position: relative;
      font-size: 25px;
      color: #f9004d;
      margin: 0px;
      margin-left: 25px;
      padding-top: 15px;
    }

    .total-price pri {
      font-family: OstrichSans;

      position: absolute;
      right: 20px;
      bottom: 0px;
      display: flex;
      color: #fff;
      font-weight: bold;
    }

    .total {

      position: relative;
      top: 10px;
      border-top: 3px #f9004d solid;
      margin: 0px;
    }

    .total pri {
      text-align: right;
    }

    /* Style the box container */
    .box-container {
      display: flex;
      flex-wrap: wrap;
    }

    /* Style the product box */
    .box {
      border: #f9004d solid;
      width: 130vh;
      height: 140px;
      margin-top: 80px;
      margin-left: 30px;
      background-color: rgba(17, 11, 28, 0.8);
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
      border-radius: 4px;
    }

    .box h1 {
      font-family: OstrichSansreg;
      color: #fff;
      padding-left: 20px;
      font-size: 30px;
      margin-top: 10px;
      padding-bottom: 10px;
      border-bottom: #f9004d solid;

    }

    .box p {
      font-family: OstrichSansreg;
      color: #fff;
      font-size: 30px;
      padding-left: 20px;
      margin-top: 10px;
    }

    .boxx {
      border: #fff solid;
      width: 130vh;
      margin-top: 80px;
      margin-left: 30px;
      background-image: url("pe1.png");
      background-size: cover;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
      border-radius: 4px;

    }

    form {
      margin-top: 0em;
      margin-block-end: -3.9em;
    }

    .boxx h1 {
      position: relative;
      bottom: 10px;
      font-family: OstrichSansreg;
      color: #f9004d;
      padding-left: 20px;
      font-size: 30px;
      padding-bottom: 10px;
      border-bottom: #fff solid;
    }

    .bttn {
      font-family: OstrichSansreg;
      position: relative;
      bottom: 82px;
      left: 112vh;
      padding: 5px;
      border: #f9004d solid;
      color: #fff;
      padding-left: 10px;
      padding-right: 10px;
      font-size: 25px;
      text-decoration: none;
      border-radius: 10px;
    }

    .bttn:hover {
      color: #fff;
      background-color: #f9004d;
      border: #fff solid;
    }

    .btn {
      font-family: OstrichSansreg;
      position: absolute;
      bottom: 25px;
      left: 110vh;
      color: #f9004d;
      text-align: center;
      padding: 8px 20px;
      text-decoration: none;
      font-size: 25px;
      background-color: transparent;
      border-radius: 2px;
      border: 2px #f9004d solid;
    }

    .card-option {
      padding-left: 40px;
      display: block;
      font-family: OstrichSansreg;
      position: relative;
      bottom: 60px;
      font-size: 25px;
      padding-top: 25px;
      padding-bottom: 30px;
      border-bottom: #fff solid;
    }

    .card-option input[type="radio"] {
      position: relative;
      right: 15px;
      transform: scale(1.5);
    }

    .card-holder {
      color: #fff;
      font-family: OstrichSansreg;
      position: relative;
      left: 72vh;
    }

    .card-cvv {
      font-family: OstrichSansreg;
      display: block;
      position: relative;
      left: 130px;
      width: 120px;
      font-size: 20px;
      padding: 8px;

    }

    .cv {
      font-family: OstrichSansreg;
      position: relative;
      left: 3vh;
      display: block;
      top: 35px;
    }

    .credit {
      font-family: OstrichSansreg;
      display: block;
      font-size: 30px;
      position: absolute;
      left: 10vh;
      top: 62.5vh;
    }

    .spa {
      font-family: OstrichSansreg;
    }
  </style>
</head>

<body>
  <video autoplay loop muted>
    <source src="loop5.mp4" type="video/mp4">
  </video>
  <div class="container">
    <section class="products">
      <div class="box">
        <h1> Delivery Address</h1>
        <p>
          <spa>
            <?php echo $fname; ?>
            <?php echo $mname; ?>
          </spa>,
          <?php echo $dist; ?>,
          <?php echo $city; ?> -
          <?php echo $pin; ?>
        </p>
      </div>
      <div class="boxx">
        <h1> Credit & Debit Cards</h1>
        <div class="cards">
          <a href="cardc.php" class="bttn"> Add A Card</a>
        </div>
        <form action="" method="post" enctype="multipart/form-data">
          <?php
          $qry = mysqli_query($conn, "SELECT * FROM tbl_Card WHERE Card_status = '1' AND Customer_id = '$user_id'");
          $cardOptions = '';

          if (mysqli_num_rows($qry) > 0) {
            while ($row = mysqli_fetch_assoc($qry)):
              $lastCard = $row['Card_id'];
              $lastCardNumber = substr($row['Card_number'], -4);

              $cardOptions .= '<label class="card-option">';
              $cardOptions .= '<input type="radio" name="selectedCard" value="' . $row['Card_id'] . '">' . 'Credit Card Ending in' . " " . $lastCardNumber . " ";
              $cardOptions .= '<span class="card-holder">' . $row['Card_holder'] . '</span>';
              $cardOptions .= '<span class="cv">Enter CVV: </span>';
              $cardOptions .= '<input type="tel" name="cvv_' . $row['Card_id'] . '" class="card-cvv" placeholder="Enter CVV" maxlength="3" minlength="3">';
              $cardOptions .= '<input type="hidden" name="card_id" value="' . $lastCard . '">'; // Include the card_id as a hidden input
              $cardOptions .= '<button type="submit" class="btn" name="remove_card" value="' . $lastCard . '">Remove</button>';
              $cardOptions .= '</label>';
            endwhile;
          } else {
            $cardOptions .= '<p class="msg">No Cards Added!</p>';
          }

          echo $cardOptions; // Output the card options
          ?>

          <div class="total-price">
            <div class="details">
              <h3>Order Summary</h3>
            </div>
            <div class="price-details">
              <p>Price (
                <?php echo $cartrow ?> item) <pri>₹
                <?php
                $pri = $totalPrice;
                $for_price = number_format($pri);
                echo $for_price; ?>
                </pri>
              </p>
              <p>Delivery Charges <pri>Free</pri>
              </p>
            </div>
            <div class="total">
              <h3>Total Amount: <pri>₹
              <?php
                $pri = $totalPrice;
                $for_price = number_format($pri);
                echo $for_price; ?>
                </pri>
              </h3>
            </div>
          </div>

          <!-- Hidden input to store the selected card ID -->
          <input type="hidden" name="card_id" id="selectedCardID" value="">

          <button type="submit" class="proceed" name="payment">Place Order</button>
        </form>


      </div>
      </form>
    </section>
  </div>
  <script>
    function setSelectedCardID() {
      const selectedCardRadio = document.querySelector('input[name="selectedCard"]:checked');
      if (selectedCardRadio) {
        const selectedCardID = selectedCardRadio.value;
        document.getElementById('selectedCardID').value = selectedCardID;
      }
    }
  </script>
</body>

</html>