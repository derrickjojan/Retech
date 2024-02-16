<?php include 'head.php'; ?>
<?php
if (isset($_POST['add_to_cart'])) {
  $todayDate = date("Y-m-d");
  $item_id_to_add = mysqli_real_escape_string($conn, $_POST['item_id']); // Get the item ID from tbl_the hidden input field

  // Check if an open mastercart_id exists for the customer
  $existingCartQuery = mysqli_query($conn, "SELECT Mastercart_id FROM tbl_cart_master WHERE Customer_id = '$user_id' AND Cart_status = 'N'");

  if (mysqli_num_rows($existingCartQuery) > 0) {
    // An open cart already exists, use the existing mastercart_id
    $existingCart = mysqli_fetch_assoc($existingCartQuery);
    $master_id = $existingCart['Mastercart_id'];
  } else {
    // No open cart found, create a new one
    $insert = mysqli_query($conn, "INSERT INTO tbl_cart_master (Customer_id, Cart_status, Cart_date) VALUES ('$user_id', 'N', '$todayDate')");
    $master_id = mysqli_insert_id($conn);
  }

  // Check if the item is already in the cart for the specific user
  $result = mysqli_query($conn, "SELECT * FROM tbl_cart_child WHERE Mastercart_id = '$master_id' AND Item_id = '$item_id_to_add'");
  if (mysqli_num_rows($result) > 0) {
    // Check if adding 1 to qty would exceed the stock
    $itemInfo = mysqli_query($conn, "SELECT stock FROM tbl_purchasechild WHERE Item_id = '$item_id_to_add'");
    $itemStock = mysqli_fetch_assoc($itemInfo)['stock'];
    $cartItem = mysqli_fetch_assoc($result);
    $newQty = $cartItem['qty'] + 1;

    if ($newQty <= $itemStock) {
      // Update the quantity if it doesn't exceed stock
      $updateQuantityQuery = mysqli_query($conn, "UPDATE tbl_cart_child SET qty = qty + '1' WHERE Mastercart_id = '$master_id' AND Item_id = '$item_id_to_add'");
      echo '<script>window.location.href = "product.php";</script>';
    } else {
      // Display an error message
      echo '<p class="msg">Oops! The requested quantity exceeds the available stock for this item.</p>';
    }
  } else {
    // Item is not in the cart, insert a new row with qty 1
    $insertt = mysqli_query($conn, "INSERT INTO tbl_cart_child (Mastercart_id, Item_id, qty) VALUES ('$master_id', '$item_id_to_add', '1')");
    echo '<script>window.location.href = "product.php";</script>';
  }

}

?>

<html>

<head>
  <title>Product page</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    .msg {
      clip-path: polygon(0 0, 0 calc(100% - 20px), 20px 100%, 100% 100%, 100% 20px, calc(100% - 20px) 0);
      font-family: OstrichSansreg;
      margin-top: 20px;
      position: relative;
      left: 75vh;
      top: 20px;
      width: 60vh;
      padding: 8px 20px;
      color: #f2f2f2;
      text-align: center;
      font-size: 30px;
      background-color: #f9004d;
    }

    body {
      color: #fff;
      margin: 0;
    }

    .card-content p {
      font-family: "Candara", sans-serif;
      text-transform: uppercase;
      font-family: Candara;
      font-size: 22px;
      font-weight: 200px;
      text-align: justify;
      padding: 2px;
      padding-left: 70px;
    }

    .products {
      padding: 40px 0;
      text-align: center;


    }

    /* Style the box container */
    .box-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;


    }

    /* Style the product box */
    .box {
      clip-path: polygon(0 0, 0 calc(100% - 30px), 30px 100%, 100% 100%, 100% 30px, calc(100% - 30px) 0);
      width: 350px;
      height: 354px;
      margin: 15px;
      border: #f9004d solid;
      background-color: #f9004d;
      border-radius: 5px;
    }

    .box-wrapper {
      clip-path: polygon(0 0, 0 calc(100% - 30px), 30px 100%, 100% 100%, 100% 30px, calc(100% - 30px) 0);
      width: 345px;
      height: 350px;
      background-color: rgba(17, 11, 28, 0.98);
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
      border-radius: 5px;
      text-align: center;
    }

    .box img {
      clip-path: polygon(0 0, 0 calc(100% - 0px), 0px 100%, 100% 100%, 100% 30px, calc(100% - 30px) 0);
      width: 100%;
      height: 200px;
      border-bottom: #f9004d solid;
    }

    .box .name {
      font-family: OstrichSansreg;
      color: #f9004d;
      font-size: 18px;
      margin-top: 15px;
      text-align: center;
      font-size: 30px;
    }

    .box .price {
      clip-path: polygon(0 0, 0 100%, calc(100% - 25px) 100%, 100% calc(100% - 70px), 100% 0);
      font-family: OstrichSans;

      position: absolute;
      background-color: #f9004d;
      color: #fff;
      font-size: 18px;
      padding: 10px;
      padding-left: 55px;
      margin-top: 25px;
      padding-right: 70px;
      font-size: 30px;
    }

    .box .btn {
      background-color: transparent;
      position: relative;
      left: 125px;
      top: 25px;
      margin-right: 10px;
      color: #f9004d;
      text-align: center;
      padding: 14px 16px;
      text-decoration: none;
      font-size: 25px;
      border-radius: 10px;
      border: #f9004d solid;

    }

    .box .btn:hover {
      background-color: #ddd;
      color: #f9004d;
    }

    .card-content p {
      font-family: "Candara", sans-serif;
      text-transform: uppercase;
      font-family: Candara;
      font-size: 22px;
      font-weight: 200px;
      text-align: justify;
      padding: 25px 0px 0px 70px;
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

    .empty {
      background-color: #ddd;
      color: #000000;
      font-family: OstrichSansreg;
      width: 400px;
      text-align: center;
      padding: 10px;
      border-radius: 5px;
      font-size: 20px;
    }

    .cyber-glitch-2 {
      font-family: OstrichSansreg;
      font-size: 30px;
      animation: cyber-glitch-2 4s linear infinite;
    }

    @keyframes cyber-glitch-2 {
      0% {
        clip-path: var(--og-clip-path);
        transform: translateX(0);
        text-shadow: none;
      }

      2% {
        clip-path: polygon(0 40%, 0 100%, 100% 100%, 100% 40%);
        transform: translateX(0);
        text-shadow: var(--cyan) 1px 1px, var(--yellow) -1px -1px;
      }

      4% {
        clip-path: polygon(0 40%, 0 100%, 100% 100%, 100% 40%);
        transform: translateX(-1rem);
        text-shadow: var(--cyan) 1px 1px, var(--yellow) -1px -1px;
      }

      6% {
        clip-path: polygon(0 40%, 0 100%, 100% 100%, 100% 40%);
        transform: translateX(1rem);
        text-shadow: var(--cyan) 1px 1px, var(--yellow) -1px -1px;
      }

      8% {
        clip-path: polygon(0 40%, 0 100%, 100% 100%, 100% 40%);
        transform: translateX(0);
        text-shadow: var(--cyan) 1px 1px, var(--yellow) -1px -1px;
      }

      12% {
        clip-path: polygon(0 10%, 0 40%, 100% 40%, 100% 10%);
        transform: translateX(0);
        text-shadow: var(--cyan) 1px 1px, var(--yellow) -1px -1px;
      }

      14% {
        clip-path: var(--og-clip-path);
        transform: translateX(0);
        text-shadow: none;
      }

      100% {
        clip-path: var(--og-clip-path);
        transform: translateX(0);
        text-shadow: none;
      }
    }

    .cyber-tile,
    .cyber-tile-small,
    .cyber-tile-big {
      --tile-width: 360px;
      --tile-height: 10px;
      --tile-padding: 4px;
      --tile-edges: 20px;
      --label-margins: calc(var(--tile-edges) - var(--tile-padding));
      --og-clip-path: polygon(0 0, 0 calc(100% - var(--tile-edges)), var(--tile-edges) 100%, 100% 100%, 100% var(--tile-edges), calc(100% - var(--tile-edges)) 0);
      width: var(--tile-width);

      clip-path: var(--og-clip-path);
      padding: var(--tile-padding);
      padding-bottom: var(--tile-edges);
    }

    .bg-red {
      --bg: var(--red);
      background-color: var(--red);
    }

    .fg-white {
      --fg: var(--white);
      color: var(--white) !important;
    }

    :root {
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

    .code-block {
      font-family: OstrichSansreg;
      width: 85%;
      border: none;
      margin-top: 10px;
      margin-left: 50px;
      font-size: 25px;
      color: #000;
      border-radius: 5px;
      clip-path: polygon(0 0, 0 100%, calc(100% - 20px) 100%, 100% calc(100% - 20px), 100% 0);
      display: block;
      padding: 10px 10px;
    }

    sp {
      font-family: OstrichSansreg;
      color: #f9004d;
    }
  </style>
</head>

<body>
  <video autoplay loop muted>
    <source src="loop5.mp4" type="video/mp4">
  </video>
  <div class="container">

    <section class="products">
      <div class="box-container">
        <?php
        $select_products = mysqli_query($conn, "SELECT * FROM tbl_item WHERE item_id IN (SELECT item_id FROM tbl_purchasechild WHERE stock != 0)");
        if (mysqli_num_rows($select_products) > 0) {
          while ($row = mysqli_fetch_assoc($select_products)) {
            $id = $row['Item_id'];
            ?>
            <div class="box">
              <div class="box-wrapper">
                <a href="#" class="edit-link" data-item-id="<?php echo $id; ?>">
                  <?php
                  $select_price = mysqli_query($conn, "SELECT Price FROM tbl_purchasechild WHERE Item_id = '$id'");
                  $var = mysqli_fetch_assoc($select_price);
                  ?>
                  <img src="<?php echo $row['Item_img']; ?>" width="285" height="140">
                  <div class="name">
                    <?php echo $row['Item_name'] ?>
                  </div>
                  <div class="price">₹
                    <?php $pri = $var['Price'];
                    $for_price = number_format($pri);
                    echo $for_price; ?>
                  </div>
                </a>
                <form method="POST">
                  <input type="hidden" name="item_id" value="<?php echo $id; ?>"> <!-- Hidden input field for item ID -->
                  <?php if (!empty($_SESSION['userid'])) {
                    if ($_SESSION['usertp'] === 'Staff' || $_SESSION['usertp'] === 'Admin' || $_SESSION['usertp'] === 'Courier') {
                      echo '<a href="#" class="btn"><i class="fas fa-shopping-cart" style="margin-top:15px"></i></a>';
                    } else { ?>
                      <button type="submit" class="btn" name="add_to_cart"><i class="fas fa-shopping-cart"></i></button>
                      <?php
                    }
                  } else {
                    echo '<a href="login.php" class="btn"><i class="fas fa-shopping-cart" style="margin-top:15px"></i></a>';
                  }
                  ?>
                </form>
              </div>
            </div>
            <?php
          }
        } else {
          ?>
          <div class="cyber-tile bg-red fg-white cyber-glitch-2">
            <label>
              No Items Available!
            </label>
          </div>
          <?php
        }
        ?>
      </div>
    </section>




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

    </script>

</body>

</html>