<?php include 'head.php'; ?>
<?php
if (isset($_POST['remove'])) {
  $item_id_to_remove = mysqli_real_escape_string($conn, $_POST['item_id']);

  // Get the Mastercart_id associated with the item and user
  $select = mysqli_query($conn, "SELECT Mastercart_id FROM tbl_cart_child WHERE Item_id = '$item_id_to_remove' AND Mastercart_id IN (SELECT Mastercart_id FROM tbl_cart_master WHERE Customer_id = '$user_id' AND Cart_status = 'N')");
  $masid = mysqli_fetch_assoc($select)['Mastercart_id'];

  // Perform the item removal using SQL DELETE statement for cartitem
  $delete_item_query = mysqli_query($conn, "DELETE FROM tbl_cart_child WHERE Mastercart_id = '$masid' AND Item_id = '$item_id_to_remove'");

  // Check if all cartitems for the cartmaster have been removed
  $remaining_items_query = mysqli_query($conn, "SELECT COUNT(*) as count FROM tbl_cart_child WHERE Mastercart_id = '$masid'");
  $remaining_items = mysqli_fetch_assoc($remaining_items_query)['count'];

  if ($remaining_items == 0) {
    // If no remaining items, delete the cartmaster entry as well
    $delete_cartmaster_query = mysqli_query($conn, "DELETE FROM tbl_cart_master WHERE Mastercart_id = '$masid'");
  }

  // Reload the page using JavaScript only once
  echo '<script>window.location.href = "cart.php";</script>';
}

if (isset($_POST['payment'])) {
  $cartWithinStockLimit = true; // Initialize the flag as true

  $select = mysqli_query($conn, "SELECT * FROM tbl_cart_master WHERE Customer_id = '$user_id' AND Cart_status = 'N'");
  if (mysqli_num_rows($select) > 0) {
    while ($master = mysqli_fetch_assoc($select)) {
      $masterid = $master['Mastercart_id'];
      $selectt = mysqli_query($conn, "SELECT * FROM tbl_cart_child WHERE Mastercart_id = $masterid");
      while ($child = mysqli_fetch_assoc($selectt)) {
        $item = $child['Item_id'];
        $quantity = $child['qty'];
        $select_price = mysqli_query($conn, "SELECT stock,Price FROM tbl_purchasechild WHERE Item_id = '$item'");
        $var = mysqli_fetch_assoc($select_price);
        $stock = $var['stock'];

        if ($quantity > $stock) {
          $cartWithinStockLimit = false; // Set the flag to false
          break; // Exit the inner loop as soon as one item exceeds stock
        }
      }
    }
  }

  if ($cartWithinStockLimit) {
    if (isset($_POST['totalPrice'])) {
      $_SESSION['price'] = $_POST['totalPrice'];
    } else {
      $_SESSION['price'] = 0;
    }
    // Redirect to another page or continue processing
    echo '<script>window.location.href = "payment.php";</script>';
  } else if ($stock == '0') {

  } else {
    echo '<p class="msgg">Sorry, the quantity in your cart exceeds the available stock. Please update your cart.</p>';
  }
}

if (isset($_POST['item_id'], $_POST['master_id'], $_POST['quantity'])) {
  $itemId = $_POST['item_id'];
  $masterId = $_POST['master_id'];
  $newQuantity = intval($_POST['quantity']);


  // Perform the database update here
  $result = mysqli_query($conn, "UPDATE tbl_cart_child SET qty = $newQuantity WHERE Item_id = '$itemId' AND Mastercart_id = '$masterId'");

  if ($result) {
    echo '<script>window.location.href = "cart.php";</script>';
  } else {
    echo "Error updating quantity: " . mysqli_error($conn);
  }
}
?>


<html>

<head>
  <title>Cart</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  <style>
    .container {
      overflow: none;
      overflow-x: hidden;
      overflow-y: auto;

    }

    .msg {
      clip-path: polygon(0 0, 0 calc(100% - 20px), 20px 100%, 100% 100%, 100% 20px, calc(100% - 20px) 0);
      font-family: OstrichSansreg;
      margin-top: 20px;
      position: relative;
      left: 10vh;
      width: 60vh;
      max-height: 40px;
      padding: 8px 20px;
      color: #f2f2f2;
      text-align: center;
      font-size: 30px;
      background-color: #f9004d;
    }

    .msgg {
      clip-path: polygon(0 0, 0 calc(100% - 20px), 20px 100%, 100% 100%, 100% 20px, calc(100% - 20px) 0);
      font-family: OstrichSansreg;
      position: absolute;
      top: 22vh;
      left: 30vh;
      min-width: 130vh;
      max-width: 150vh;
      max-height: 40px;
      padding: 8px 20px;
      color: #f2f2f2;
      text-align: center;
      font-size: 25px;
      background-color: #f9004d;
    }

    .proceed {
      clip-path: polygon(0 0, 0 calc(100% - 20px), 20px 100%, 100% 100%, 100% 20px, calc(100% - 20px) 0);
      font-family: OstrichSansreg;
      margin-top: 20px;
      position: absolute;
      right: 10vh;
      bottom: 23vh;
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

    .products h1 {
      position: relative;
      left: 50px;
      top: 20px;
      text-transform: uppercase;
      font-family: 'OstrichSansreg';
      font-size: 50px;
      color: #fff;
      width: 180vh;
    }

    .products {
      border: #fff solid;
      padding-bottom: 30px;
      margin-top: 30px;
      min-height: 85vh;
      background-color: rgba(0, 0, 0, 0.9);
      border-radius: 20px;
    }

    /* Style the box container */
    .box-container {
      display: flex;
      flex-wrap: wrap;
    }

    /* Style the product box */
    .box {
      border-top: #f9004d solid;
      width: 130vh;
      height: 180px;
      margin-left: 30px;
      background-color: rgba(17, 11, 28, 0.8);
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
      border-radius: 4px;
    }

    .box img {
      border: #f9004d solid;
      width: 20%;
      height: 150px;
      border-radius: 5px;
      margin-top: 10px;
      margin-left: 25px;
    }

    .box .name {
      font-family: OstrichSansreg;
      color: #f9004d;
      margin-top: 10px;
      font-size: 30px;
      position: relative;
      left: 260px;
      bottom: 135px;
    }

    .box .price {
      font-family: OstrichSans;
      color: #f9004d;
      margin-top: 10px;
      font-size: 30px;
      position: relative;
      left: 260px;
      bottom: 135px;
    }

    .box .qty {
      z-index: 999;
      font-family: OstrichSansreg;
      color: #f9004d;
      margin-top: 10px;
      font-size: 30px;
      position: relative;
      left: 100vh;
      bottom: 30.6vh;
    }

    .box .btn {
      font-family: OstrichSansreg;
      position: relative;
      left: 820px;
      bottom: 200px;
      color: #f9004d;
      text-align: center;
      padding: 8px 20px;
      text-decoration: none;
      font-size: 25px;
      background-color: transparent;
      border-radius: 2px;
      border: 2px #f9004d solid;
    }

    .box .btn:hover {
      background-color: #ddd;
      color: #f9004d;
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

    .card-content p {
      font-family: "Candara", sans-serif;
      text-transform: uppercase;
      font-family: Candara;
      font-size: 22px;
      font-weight: 200px;
      text-align: justify;
      padding: 3 0px 0px 70px;
    }

    .total-price {
      font-family: OstrichSansreg;
      background-color: rgba(17, 11, 28, 0.8);
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
      position: absolute;
      right: 10vh;
      bottom: 34vh;
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

    .sold {
      clip-path: polygon(0 0, 0 calc(100% - 20px), 20px 100%, 100% 100%, 100% 20px, calc(100% - 20px) 0);
      z-index: 999;
      font-family: OstrichSansreg;
      color: #fff;
      margin-top: 10px;
      font-size: 30px;
      position: relative;
      top:12vh;
      right:80vh;
      max-height: 40px;
      padding: 5px 15px;
      background-color: #f9004d;
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

    input[type="number"] {
      font-family: OstrichSansreg;
      width: 50px;
      border: transparent;
      background: transparent;
      color: #fff;
      position: relative;
      font-size: 30px;
    }

    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }

    .bttn {

      width: 30px;
      height: 30px;
      background-color: #f9004d;
      /* Change to your desired button color */
      color: white;
      border: none;
      border-radius: 50%;
      font-size: 27px;
      position: relative;
      right: 25px;
    }

  </style>
</head>

<body>
<?php
$select = mysqli_query($conn, "SELECT * FROM tbl_cart_master WHERE Customer_id = '$user_id' AND Cart_status = 'N'");
if (mysqli_num_rows($select) > 0) {
  $exceededItems = array(); // Create an array to store exceeded item names
  while ($master = mysqli_fetch_assoc($select)) {
    $masterid = $master['Mastercart_id'];
    $selectt = mysqli_query($conn, "SELECT * FROM tbl_cart_child WHERE Mastercart_id = $masterid");
    while ($child = mysqli_fetch_assoc($selectt)) {
      $item = $child['Item_id'];
      $quantity = $child['qty'];
      $select_price = mysqli_query($conn, "SELECT stock,Price FROM tbl_purchasechild WHERE Item_id = '$item'");
      $var = mysqli_fetch_assoc($select_price);
      $stock = $var['stock'];
      
      if ($stock == '0') {
        // Handle when stock is zero if needed
      } else if ($quantity > $stock) {
        $sqlname = mysqli_query($conn, "SELECT * FROM tbl_Item WHERE Item_id = '$item'");
        $iname = mysqli_fetch_assoc($sqlname)['Item_name'];
        // Add the exceeded item name to the array
        $exceededItems[] = $iname;
        $select_price = mysqli_query($conn, "SELECT qty FROM tbl_purchasechild WHERE Item_id = '$item'");
        $var = mysqli_fetch_assoc($select_price);
        $qty = $var['qty'];
      } else {
        // Handle other conditions if needed
      }
    }
  }

  // Check if there are exceeded items and display the message
  if (!empty($exceededItems)) {
    $exceededItemsList = implode(', ', $exceededItems);
    echo '<p class="msgg">Sorry, ' . $exceededItemsList . ' exceed(s) the available stock. Please update your cart.</p>';
  }
}
?>

  <video autoplay loop muted>
    <source src="vid2.mp4" type="video/mp4">
  </video>
  <div class="container">
    <section class="products">
      <h1>Cart</h1>
      <div class="box-container">
        <?php
        $totalPrice = 0; // Initialize the total price
        $cartNotEmpty = false; // Flag to track if cart is not empty
        
        $select = mysqli_query($conn, "SELECT * FROM tbl_cart_master WHERE Customer_id = '$user_id' AND Cart_status = 'N'");
        if (mysqli_num_rows($select) > 0) {
          $cartNotEmpty = true; // Set the flag to true
          while ($master = mysqli_fetch_assoc($select)) {
            $masterid = $master['Mastercart_id'];
            $selectt = mysqli_query($conn, "SELECT * FROM tbl_cart_child WHERE Mastercart_id = $masterid");
            while ($child = mysqli_fetch_assoc($selectt)) {
              $item = $child['Item_id'];
              $quantity = $child['qty'];
              $select_products = mysqli_query($conn, "SELECT * FROM tbl_Item WHERE Item_id = '$item'");
              $row = mysqli_fetch_assoc($select_products);
              $id = $row['Item_id'];

              $select_price = mysqli_query($conn, "SELECT stock,Price FROM tbl_purchasechild WHERE Item_id = '$id'");
              $var = mysqli_fetch_assoc($select_price);
              $itemPrice = $var['Price'];
              $item_stock = $var['stock'];

              // Add the item price to the total price
              $totalPrice += $itemPrice * $quantity;


              ?>
              <div class="box">
                <a href="#" class="edit-link" data-item-id="<?php echo $id; ?>">
                  <div class="left-side">
                    <div class="image">
                      <img src="<?php echo $row['Item_img']; ?>" width="285" height="140">
                    </div>
                    <div class="name">
                      <?php echo $row['Item_name'] ?>
                    </div>
                    <div class="price">₹
                      <?php $pri = $itemPrice;
                      $for_price = number_format($pri);
                      echo $for_price; ?>
                    </div>
                  </div>
                </a>
                <form method="POST" action="">
                  <input type="hidden" name="item_id" value="<?php echo $id; ?>">
                  <input type="hidden" name="master_id" value="<?php echo $masterid; ?>">
                  <div class="qty">
                    <label for="quantity_<?php echo $id; ?>">Quantity:</label>
                    <?php
                    if ($item_stock == '0') {
                      echo '<input type="number" id="quantity_<?php echo $id; ?>" name="quantity" value="<?php echo $quantity; ?>">';
                    } else {
                      ?><input type="number" id="quantity_<?php echo $id; ?>" name="quantity"
                        value="<?php echo $quantity; ?>" min="1" max="<?php echo $item_stock ?>">';
                    <?php }
                    ?>
                    <button type="submit" class="bttn" onclick="decreaseQuantity('<?php echo $id; ?>')">-</button>
                    <button type="submit" class="bttn" onclick="increaseQuantity('<?php echo $id; ?>')">+</button>
                  </div>
                  <button type="submit" class="btn" name="remove">Remove</button>
                </form>
              </div>

              <?php
                            if ($item_stock == '0') {
                              echo '<p class="sold">Item is sold Please remove from cart.</p>';
                            } 
            }
          }
        } else {
          echo '<p class="msg">Empty Cart</p>';
        }
        ?>

        <div class="total-price">
          <div class="details">
            <h3>Price Details</h3>
          </div>
          <div class="price-details">
            <p>Price (
              <?php echo $cartrow ?> item) <pri>₹
                <?php
                $pri = $totalPrice;
                $for_price = number_format($pri);
                ?><spa><?php echo $for_price; ?></spa>
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
                ?><spa><?php echo $for_price; ?></spa>
              </pri>
            </h3>
          </div>
        </div>
        <form method="POST" action="">
          <?php if ($cartNotEmpty) { ?>
            <input type="hidden" name="item_id" value="<?php echo $id; ?>">
            <input type="hidden" name="master_id" value="<?php echo $masterid; ?>">
            <input type="hidden" name="totalPrice" value="<?php echo $totalPrice; ?>">
            <button type="submit" class="proceed" name="payment">Proceed To Buy</button>
          <?php } else { ?>
            <button type="button" class="proceed" disabled>Proceed To Buy</button>
          <?php } ?>
        </form>
      </div>

    </section>



  </div>


  <script>
    var editLinks = document.querySelectorAll('.edit-link');

    editLinks.forEach(function (editLink) {
      editLink.addEventListener('click', function (event) {
        event.preventDefault();

        var itemId = editLink.getAttribute('data-item-id');
        console.log(itemId); // Check if itemId has the correct value
        var url = 'item.php?id=' + itemId;
        window.location.href = url;

      });
    });

    function decreaseQuantity(itemId) {
      console.log("Decrease Quantity Clicked for Item ID: " + itemId);
      var quantityInput = document.getElementById("quantity_" + itemId);
      var currentValue = parseInt(quantityInput.value);

      if (currentValue > 1) {
        quantityInput.value = currentValue - 1;
      }
    }
    document.addEventListener("DOMContentLoaded", function () {
      var removeButtons = document.querySelectorAll('.btn[name="remove"]');

      removeButtons.forEach(function (removeButton) {
        removeButton.addEventListener('click', function (event) {
          if (!confirm('Delete this from tbl_cart?')) {
            event.preventDefault();
            return;
          }

        });
      });
    });
    function increaseQuantity(itemId) {
      console.log("Increase Quantity Clicked for Item ID: " + itemId);
      var quantityInput = document.getElementById("quantity_" + itemId);
      var currentValue = parseInt(quantityInput.value);
      var maxQuantity = parseInt(quantityInput.getAttribute("max"));

      if (currentValue < maxQuantity) {
        quantityInput.value = currentValue + 1;
      }
    }
    // Store the scroll position before reloading the page
    window.addEventListener("beforeunload", function () {
      localStorage.setItem("scrollPosition", window.scrollY);
    });

    // Restore the scroll position after the page reloads
    window.addEventListener("load", function () {
      const scrollPosition = localStorage.getItem("scrollPosition");
      if (scrollPosition !== null) {
        window.scrollTo(0, parseInt(scrollPosition));
      }
    });

  </script>
</body>

</html>