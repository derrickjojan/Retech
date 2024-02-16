<?php include 'head.php'; ?>
<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$db = 'retech1';
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $db);
if ($conn->connect_error) {
    die("Connection failed:" . $conn->connect_error);
}
if (!empty($_SESSION['userid'])) {
    $user_id = $_SESSION['userid'];
} else {
    $user_id = '0';
}
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $result_displayValues = mysqli_query($conn, "SELECT * FROM tbl_Item WHERE Item_id = '$id'");
    $row_displayValues = mysqli_fetch_assoc($result_displayValues);

    $sid = $row_displayValues['Subcategory_id'];
    $bid = $row_displayValues['Brand_id'];
    $tname = $row_displayValues['Item_name'];
    $desc = $row_displayValues['Item_desc'];
    $mfg = $row_displayValues['Mfg_date'];
    $item_pr = $row_displayValues['price'];
    $item_sto = $row_displayValues['qty'];
    $img = $row_displayValues['Item_img'] ?? ''; // Set a default value if the image is not available

    $qry = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tbl_purchasechild WHERE Item_id = '$id'");
    $orderCount = mysqli_fetch_assoc($qry)['total'];

    if ($orderCount == 0) {
        $flag = 0;
    } else {
        $flag = 1;
    }

    $select = mysqli_query($conn, "SELECT Subcategory_name FROM tbl_Subcategory WHERE Subcategory_id='$sid'");
    $fetch = mysqli_fetch_assoc($select);
    $sname = $fetch['Subcategory_name'];

    $selectt = mysqli_query($conn, "SELECT Brand_name FROM tbl_Brand WHERE Brand_id='$bid'");
    $fetchh = mysqli_fetch_assoc($selectt);
    $bname = $fetchh['Brand_name'];

    $select_price = mysqli_query($conn, "SELECT stock, Price FROM tbl_purchasechild WHERE Item_id = '$id'");
    $var = mysqli_fetch_assoc($select_price);

    if ($var) {
        // Check if 'Price' exists in the result
        $itemPrice = isset($var['Price']) ? $var['Price'] : 'default_price_value';

        // Check if 'stock' exists in the result
        $stock = isset($var['stock']) ? $var['stock'] : 'default_stock_value';
    } else {

        $itemPrice = $item_pr;
        $stock = $item_sto;
    }

    $item_qty = '0'; // Correct variable name


    $cresult = mysqli_query($conn, "SELECT * FROM tbl_cart_child WHERE Item_id = '$id' AND Mastercart_id IN (SELECT Mastercart_id FROM tbl_cart_master WHERE Customer_id = '$user_id' AND Cart_status='N')");

    if (mysqli_num_rows($cresult) > 0) {
        while ($qty = mysqli_fetch_assoc($cresult)) {
            $item_qty += $qty['qty'];
        }
    }
    $max_qty = $stock - $item_qty;

    if (isset($_POST['add_to_cart'])) {
        $todayDate = date("Y-m-d");
        $item_id_to_add = mysqli_real_escape_string($conn, $_POST['item_id']); // Get the item ID from tbl_the hidden input field
        $quantity_to_add = mysqli_real_escape_string($conn, $_POST['quantity']); // Get the quantity from tbl_the form

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
            $cartItem = mysqli_fetch_assoc($result);
            $newQty = $cartItem['qty'] + 1;
            $chresult = mysqli_query($conn, "SELECT * FROM tbl_purchasechild WHERE Item_id = '$item_id_to_add'");
            $itemstock = mysqli_fetch_assoc($chresult);
            $item_Stock = $itemstock['stock'];
            if ($newQty <= $item_Stock) {
                // Update the quantity if it doesn't exceed stock
                $updateQuantityQuery = mysqli_query($conn, "UPDATE tbl_cart_child SET qty = qty + '$quantity_to_add' WHERE Mastercart_id = '$master_id' AND Item_id = '$item_id_to_add'");
                echo '<script>window.location.href = "cart.php";</script>';
            } else {
                // Display an error message
                echo '<p class="msg">Oops! The requested quantity exceeds the available stock for this item.</p>';
            }
        } else {
            // Item is not in the cart, insert a new row with qty 1
            $insertt = mysqli_query($conn, "INSERT INTO tbl_cart_child (Mastercart_id, Item_id, qty) VALUES ('$master_id', '$item_id_to_add', '$quantity_to_add')");
            echo '<script>window.location.href = "cart.php";</script>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Item Page</title>
    <style>
        @font-face {
            font-family: 'OstrichSansreg';
            src: url(fonts/OstrichSans-Heavy.otf);
        }

        @font-face {
            font-family: 'OstrichSans';
            src: url(fonts/OstrichSans-Bold.otf);
        }

        .container {
            overflow: none;
            padding-top: 30px;
        }

        .details {
            border: #f9004d solid;
            border-radius: 40px;
            background-color: rgba(0, 0, 0, 0.9);
            padding-top: 30px;
            padding-left: 20px;
            padding-bottom: 30px;
            font-family: OstrichSansreg;
            font-size: 30px;
            display: flex;
            margin: 20px;
        }

        .image {

            border: #fff solid 4px;
        }

        .info {
            padding-left: 60px;
        }

        .info h1 {
            font-size: 50px;
            margin-bottom: 10px;
        }

        .info p {
            margin-bottom: 15px;
            width: 400px;
        }

        .msg {
            clip-path: polygon(0 0, 0 calc(100% - 20px), 20px 100%, 100% 100%, 100% 20px, calc(100% - 20px) 0);
            font-family: OstrichSansreg;
            margin-top: 20px;
            position: absolute;
            left: 135vh;
            bottom: 8vh;
            width: 60vh;
            padding: 8px 20px;
            color: #f9004d;
            text-align: center;
            font-size: 30px;
            background-color: #fff;
        }

        .btn {

            clip-path: polygon(0 0, 0 100%, calc(100% - 25px) 100%, 100% calc(100% - 25px), 100% 0);
            font-family: OstrichSansreg;
            color: #f2f2f2;
            text-align: center;
            padding: 6px 25px;
            margin-right: 20px;
            text-decoration: none;
            font-size: 25px;
            background-color: #f9004d;
        }

        .add-to-cart-btn:hover,
        .add-to-wishlist-btn:hover {
            background-color: #d7003a;
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

        .qty {
            position: relative;
            bottom: 8px;
        }

        .price {
            font-family: OstrichSans;
        }
    </style>
</head>

<body background="pic3.png">

    <div class="container">
        <section class="details">
            <div class="image">
                <?php
                echo "<img src='$img' width='900'height='550'>";
                ?>
            </div>
            <div class="info">
                <h1>
                    <?php echo (isset($tname)) ? $tname : ""; ?>
                </h1>
                <p class="price">Price:₹
                    <?php
                    $pri = $itemPrice;
                    $for_price = number_format($pri);
                    echo $for_price; ?>
                </p>
                <p>Brand:
                    <?php echo (isset($bname)) ? "$bname" : "" ?>
                </p>
                <p>Mfg:
                    <?php echo (isset($mfg)) ? "$mfg" : "" ?>
                </p>
                <div class="qty">
                    <label for="quantity">Quantity:</label>
                    <input type="number" id="quantity" name="quantity" value="1" min="1" max="<?php echo $max_qty ?>">
                    <button type="button" onclick="decreaseQuantity()" class="bttn">-</button>
                    <button type="button" onclick="increaseQuantity()" class="bttn">+</button>
                </div>
                <p>Description:<br>
                    <?php echo (isset($desc)) ? $desc : "" ?>
                </p>
                <form action="" method="post">
                    <input type="hidden" id="hiddenQuantity" name="quantity" value="1">
                    <!-- Use this hidden field to store the quantity -->
                    <input type="hidden" name="item_id" value="<?php echo $id; ?>">
                    <?php if (!empty($_SESSION['userid'])) {
                        if ($_SESSION['usertp'] === 'Staff' || $_SESSION['usertp'] === 'Admin' || $_SESSION['usertp'] === 'Courier') {
                            echo '<a href="#" class="btn">ADD TO CART</a>';
                        } else if($flag== '0'){
                            echo '<a href="home.php" class="btn">ADD TO CART</a>';
                        }else { ?>
                            <button type="submit" class="btn" name="add_to_cart">ADD TO CART</button>
                            <?php
                        }
                    } else {
                        echo '<a href="login.php" class="btn">ADD TO CART</a>';
                    }
                    ?>
                </form>
            </div>
        </section>
    </div>
    <?php include 'footer.php'; ?>
    <script>
        function decreaseQuantity() {
            var quantityInput = document.getElementById("quantity");
            var hiddenQuantityInput = document.getElementById("hiddenQuantity");
            var currentQuantity = parseInt(quantityInput.value);

            if (currentQuantity > 1) {
                quantityInput.value = currentQuantity - 1;
                hiddenQuantityInput.value = currentQuantity - 1; // Update the hidden field
            }
        }

        function increaseQuantity() {
            var quantityInput = document.getElementById("quantity");
            var hiddenQuantityInput = document.getElementById("hiddenQuantity");
            var currentQuantity = parseInt(quantityInput.value);
            var maxQuantity = parseInt(quantityInput.getAttribute("max"));

            if (currentQuantity < maxQuantity) {
                quantityInput.value = currentQuantity + 1;
                hiddenQuantityInput.value = currentQuantity + 1; // Update the hidden field
            }
        }
    </script>


</body>

</html>