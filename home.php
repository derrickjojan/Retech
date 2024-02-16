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
      echo '<script>window.location.href = "home.php";</script>';
    } else {
      // Display an error message
      echo '<p class="msg">Oops! The requested quantity exceeds the available stock for this item.</p>';
    }
  } else {
    // Item is not in the cart, insert a new row with qty 1
    $insertt = mysqli_query($conn, "INSERT INTO tbl_cart_child (Mastercart_id, Item_id, qty) VALUES ('$master_id', '$item_id_to_add', '1')");
    echo '<script>window.location.href = "home.php";</script>';
  }

}

?>
<html>

<head>
  <title>homepage</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      color: #fff;
      margin: 0;
    }

    .container {
      overflow: none;
      padding-top: 35px;
      padding-left: 8%;
      padding-right: 8%;
    }


    span {
      font-family: 'OstrichSans';
      color: #f9004d;
    }

    spp {
      font-family: 'OstrichSans';
      color: #fff;
    }

    sp {
      font-family: OstrichSansreg;
      color: #f9004d;
    }

    .content {
      margin-top: 10%;
      margin-bottom: 60px;

    }

    .content h1 {
      position: relative;
      padding-top: 40px;
      font-family: OstrichSansreg;
      font-size: 45px;
      z-index: -1;

    }

    .content a {
      clip-path: polygon(0 0, 0 100%, calc(100% - 25px) 100%, 100% calc(100% - 25px), 100% 0);
      font-family: OstrichSansreg;
      position: relative;
      left: 378px;
      top: 30px;
      color: #f2f2f2;
      text-align: center;
      padding: 8px 50px;
      margin-right: 20px;
      text-decoration: none;
      font-size: 30px;
      background-color: #f9004d;
    }

    .box1 {

      clip-path: polygon(0 0, 0 100%, calc(100% - 25px) 100%, 100% calc(100% - 25px), 100% 0);
      font-family: OstrichSansreg;
      position: relative;
      left: 50.3vh;
      bottom: 2.4vh;
      padding: 30px;
      max-width: 260px;
      text-align: center;
      text-decoration: none;
      font-size: 30px;
      background-color: #fff;
      z-index: -1;
    }

    .box2 {

      clip-path: polygon(0 0, 0 100%, calc(100% - 25px) 100%, 100% calc(100% - 25px), 100% 0);
      font-family: OstrichSansreg;
      position: relative;
      left: 87.5vh;
      bottom: 10.5vh;
      padding: 30px;
      max-width: 219px;
      text-align: center;
      text-decoration: none;
      font-size: 30px;
      background-color: #fff;
      z-index: -1;
    }

    .content f {

      clip-path: polygon(0 0, 0 100%, calc(100% - 25px) 100%, 100% calc(100% - 25px), 100% 0);
      font-family: OstrichSansreg;
      position: relative;
      left: 18.2vh;
      bottom: 0vh;
      padding: 30px;
      width: 240px;
      text-align: center;
      text-decoration: none;
      font-size: 30px;
      background-color: #fff;
      z-index: -1;
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

    .empty {
      clip-path: polygon(0 0, 0 calc(100% - 20px), 20px 100%, 100% 100%, 100% 20px, calc(100% - 20px) 0);
      font-family: OstrichSansreg;
      padding: 8px 50px;
      color: #f2f2f2;
      text-align: center;
      font-size: 30px;
      background-color: #f9004d;
    }

    .content a:hover {
      background-color: #000;
      color: #f9004d;
    }

    h1 {
      font-family: OstrichSansreg;
      text-align: center;
      font-size: 60px;

    }

    a {
      text-decoration: none;
      color: #fff;
    }

    .link {
      margin-top: 30px;
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

    .products {
      padding: 80px 0;
      text-align: center;

    }

    /* Style the box container */
    .box-container {
      margin-top: 40px;
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
    }

    /* Style the product box */
    .box {
      clip-path: polygon(0 0, 0 calc(100% - 30px), 30px 100%, 100% 100%, 100% 30px, calc(100% - 30px) 0);
      width: 345px;
      height: 350px;
      margin: 15px;
      border: #f9004d solid;
      background-color: #f9004d;
      border-radius: 5px;
    }

    .box-wrapper {
      clip-path: polygon(0 0, 0 calc(100% - 30px), 30px 100%, 100% 100%, 100% 30px, calc(100% - 30px) 0);
      width: 340px;
      height: 345px;
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

    *::-webkit-scrollbar {
      height: .5rem;
      width: 10px;
    }

    *::-webkit-scrollbar-track {
      background-color: rgba(17, 11, 28, 0.9);
    }

    *::-webkit-scrollbar-thumb {
      background-color: black;
    }

    .cyber-razor-top {
      margin-bottom: 10px;
      position: relative;
      top: 50px;
    }


    .cyber-razor-top:before {
      content: " ";
      background-color: var(--bg);
      -webkit-mask-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="1920px" height="40px"><path d="M1827.156,15.021 L1827.129,14.994 L1833.785,14.994 L1833.759,15.021 L1827.156,15.021 ZM1824.965,24.036 L1835.969,24.036 L1830.461,18.558 L1833.759,15.021 L1920.000,15.021 L1920.000,39.075 L0.001,39.075 L0.001,15.013 L271.884,15.013 L279.537,6.930 L292.458,6.930 L308.426,24.036 L308.449,24.013 L308.467,24.036 L317.638,15.021 L463.241,15.021 L466.539,18.558 L461.031,24.036 L472.035,24.036 L466.539,18.558 L469.844,15.021 L551.557,15.021 L556.251,10.578 L565.497,1.358 L571.663,7.066 L602.910,7.055 L607.919,7.055 L620.578,19.983 L654.209,19.983 L661.448,12.957 L735.709,12.995 L741.480,18.554 L750.129,9.930 L753.020,12.995 L918.181,12.957 L930.942,0.066 L954.993,24.036 L955.000,24.024 L955.012,24.036 L964.064,15.013 L967.906,15.013 L970.005,17.106 L966.670,20.419 L973.326,20.419 L970.005,17.106 L972.067,15.055 L1050.000,15.023 L1050.000,15.013 L1064.030,15.017 L1072.000,15.013 L1072.000,15.019 L1225.933,15.055 L1227.994,17.106 L1224.674,20.419 L1231.331,20.419 L1227.994,17.106 L1230.094,15.013 L1233.936,15.013 L1242.989,24.036 L1243.000,24.024 L1243.007,24.036 L1267.058,0.066 L1279.819,12.957 L1368.980,12.995 L1371.871,9.930 L1380.520,18.554 L1386.290,13.057 L1635.552,13.019 L1642.790,19.983 L1676.422,19.983 L1689.080,6.992 L1725.337,7.003 L1731.502,1.358 L1740.749,10.578 L1745.443,15.021 L1827.156,15.021 L1830.461,18.558 L1824.965,24.036 ZM341.624,18.857 L339.889,18.857 L339.889,24.036 L341.624,24.036 L341.624,18.857 ZM344.248,18.857 L342.518,18.857 L342.518,24.036 L344.248,24.036 L344.248,18.857 ZM356.370,18.857 L354.640,18.857 L354.640,24.036 L356.370,24.036 L356.370,18.857 ZM377.168,18.857 L371.973,18.857 L371.973,24.036 L377.168,24.036 L377.168,18.857 ZM584.675,12.348 L582.941,12.348 L582.941,14.073 L584.675,14.073 L584.675,12.348 ZM591.316,12.348 L589.582,12.348 L589.582,17.526 L591.316,17.526 L591.316,12.348 ZM604.751,12.348 L603.017,12.348 L603.017,14.073 L604.751,14.073 L604.751,12.348 ZM604.751,15.802 L603.017,15.802 L603.017,17.526 L604.751,17.526 L604.751,15.802 ZM1693.983,12.348 L1692.249,12.348 L1692.249,14.073 L1693.983,14.073 L1693.983,12.348 ZM1693.983,15.802 L1692.249,15.802 L1692.249,17.526 L1693.983,17.526 L1693.983,15.802 ZM1707.418,12.348 L1705.683,12.348 L1705.683,17.526 L1707.418,17.526 L1707.418,12.348 ZM1714.059,12.348 L1712.324,12.348 L1712.324,14.073 L1714.059,14.073 L1714.059,12.348 ZM463.214,14.994 L469.871,14.994 L469.844,15.021 L463.241,15.021 L463.214,14.994 ZM754.222,5.976 L750.129,9.930 L746.025,5.976 L754.222,5.976 ZM1375.975,5.976 L1371.871,9.930 L1367.778,5.976 L1375.975,5.976 Z"/></svg>');
      -webkit-mask-repeat: repeat-x;
      -webkit-mask-position: top;
      mask-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="1920px" height="40px"><path d="M1827.156,15.021 L1827.129,14.994 L1833.785,14.994 L1833.759,15.021 L1827.156,15.021 ZM1824.965,24.036 L1835.969,24.036 L1830.461,18.558 L1833.759,15.021 L1920.000,15.021 L1920.000,39.075 L0.001,39.075 L0.001,15.013 L271.884,15.013 L279.537,6.930 L292.458,6.930 L308.426,24.036 L308.449,24.013 L308.467,24.036 L317.638,15.021 L463.241,15.021 L466.539,18.558 L461.031,24.036 L472.035,24.036 L466.539,18.558 L469.844,15.021 L551.557,15.021 L556.251,10.578 L565.497,1.358 L571.663,7.066 L602.910,7.055 L607.919,7.055 L620.578,19.983 L654.209,19.983 L661.448,12.957 L735.709,12.995 L741.480,18.554 L750.129,9.930 L753.020,12.995 L918.181,12.957 L930.942,0.066 L954.993,24.036 L955.000,24.024 L955.012,24.036 L964.064,15.013 L967.906,15.013 L970.005,17.106 L966.670,20.419 L973.326,20.419 L970.005,17.106 L972.067,15.055 L1050.000,15.023 L1050.000,15.013 L1064.030,15.017 L1072.000,15.013 L1072.000,15.019 L1225.933,15.055 L1227.994,17.106 L1224.674,20.419 L1231.331,20.419 L1227.994,17.106 L1230.094,15.013 L1233.936,15.013 L1242.989,24.036 L1243.000,24.024 L1243.007,24.036 L1267.058,0.066 L1279.819,12.957 L1368.980,12.995 L1371.871,9.930 L1380.520,18.554 L1386.290,13.057 L1635.552,13.019 L1642.790,19.983 L1676.422,19.983 L1689.080,6.992 L1725.337,7.003 L1731.502,1.358 L1740.749,10.578 L1745.443,15.021 L1827.156,15.021 L1830.461,18.558 L1824.965,24.036 ZM341.624,18.857 L339.889,18.857 L339.889,24.036 L341.624,24.036 L341.624,18.857 ZM344.248,18.857 L342.518,18.857 L342.518,24.036 L344.248,24.036 L344.248,18.857 ZM356.370,18.857 L354.640,18.857 L354.640,24.036 L356.370,24.036 L356.370,18.857 ZM377.168,18.857 L371.973,18.857 L371.973,24.036 L377.168,24.036 L377.168,18.857 ZM584.675,12.348 L582.941,12.348 L582.941,14.073 L584.675,14.073 L584.675,12.348 ZM591.316,12.348 L589.582,12.348 L589.582,17.526 L591.316,17.526 L591.316,12.348 ZM604.751,12.348 L603.017,12.348 L603.017,14.073 L604.751,14.073 L604.751,12.348 ZM604.751,15.802 L603.017,15.802 L603.017,17.526 L604.751,17.526 L604.751,15.802 ZM1693.983,12.348 L1692.249,12.348 L1692.249,14.073 L1693.983,14.073 L1693.983,12.348 ZM1693.983,15.802 L1692.249,15.802 L1692.249,17.526 L1693.983,17.526 L1693.983,15.802 ZM1707.418,12.348 L1705.683,12.348 L1705.683,17.526 L1707.418,17.526 L1707.418,12.348 ZM1714.059,12.348 L1712.324,12.348 L1712.324,14.073 L1714.059,14.073 L1714.059,12.348 ZM463.214,14.994 L469.871,14.994 L469.844,15.021 L463.241,15.021 L463.214,14.994 ZM754.222,5.976 L750.129,9.930 L746.025,5.976 L754.222,5.976 ZM1375.975,5.976 L1371.871,9.930 L1367.778,5.976 L1375.975,5.976 Z"/></svg>');
      mask-repeat: repeat-x;
      mask-position: top;
      position: absolute;
      left: 0;
      top: -30px;
      width: 100%;
      height: 30px;
      z-index: 1;
    }

    .bg-red {
      --bg: #f9004d;
      background-color: #f9004d;
    }

    .bg-black {
      --bg: black;
      background-color: black;
    }
    .cyber-button
{
    --button-border: 4px;
    --button-font-size: 1.4rem;
    --button-padding-v: 0.9rem;
    --button-padding-h: 2.5rem;

    --tag-font-size: 0.55rem;

    --button-cutout: 1.1rem;

    --button-shadow-primary: var(--cyan);
    --button-shadow-secondary: var(--yellow);
    --button-shimmy-distance: 5;

    --button-clip-1: polygon(0 2%, 100% 2%, 100% 95%, 95% 95%, 95% 90%, 85% 90%, 85% 95%, 8% 95%, 0 70%);
    --button-clip-2: polygon(0 78%, 100% 78%, 100% 100%, 95% 100%, 95% 90%, 85% 90%, 85% 100%, 8% 100%, 0 78%);
    --button-clip-3: polygon(0 44%, 100% 44%, 100% 54%, 95% 54%, 95% 54%, 85% 54%, 85% 54%, 8% 54%, 0 54%);
    --button-clip-4: polygon(0 0, 100% 0, 100% 0, 95% 0, 95% 0, 85% 0, 85% 0, 8% 0, 0 0);
    --button-clip-5: polygon(0 0, 100% 0, 100% 0, 95% 0, 95% 0, 85% 0, 85% 0, 8% 0, 0 0);
    --button-clip-6: polygon(0 40%, 100% 40%, 100% 85%, 95% 85%, 95% 85%, 85% 85%, 85% 85%, 8% 85%, 0 70%);
    --button-clip-7: polygon(0 63%, 100% 63%, 100% 80%, 95% 80%, 95% 80%, 85% 80%, 85% 80%, 8% 80%, 0 70%);

    --button-clip: polygon(0 0, 100% 0, 100% 100%, 95% 100%, 95% 90%, 80% 90%, 80% 100%, var(--button-cutout) 100%, 0 calc(100% - var(--button-cutout)));

    cursor: pointer;
    margin-left: 30px;
    background: transparent !important;
    text-transform: uppercase;
    font-size: var(--button-font-size);
    font-weight: 700;
    letter-spacing: 2px;
    padding: var(--button-padding-v) var(--button-padding-h);
    outline: transparent;
    position: relative;
    left:300px;
    top:50px;
    border: 0;
    transition: background 0.2s;
}

.cyber-button:hover
{
    filter: brightness(90%);
}

.cyber-button:after,
.cyber-button:before
{
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    clip-path: var(--button-clip);
    z-index: -1;
}

.cyber-button:before
{
    background: var(--button-shadow-primary);
    transform: translate(var(--button-border), 0);
}

.cyber-button:after
{
    background-color: var(--bg);
}

.cyber-button .tag
{
    position: absolute;
    letter-spacing: 1px;
    bottom: -5%;
    right: 6%;
    font-weight: normal;
    color: #000;
    font-size: var(--tag-font-size);
}


.cyber-button .glitchtext
{
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: var(--button-shadow-primary);
    text-shadow: 2px 2px var(--button-shadow-primary), -2px -2px var(--button-shadow-secondary);
    clip-path: var(--button-clip);
    animation: glitch 4s infinite;
    padding: var(--button-padding-v) var(--button-padding-h);
    display: none;
}

.cyber-button:hover .glitchtext
{
    display: block;
}

.cyber-button .glitchtext:before
{
    content: '';
    position: absolute;
    top: calc(var(--button-border) * 1);
    right: calc(var(--button-border) * 1);
    bottom: calc(var(--button-border) * 1);
    left: calc(var(--button-border) * 1);
    clip-path: var(--button-clip);
    background-color: var(--bg);
    z-index: -1;
}

@keyframes glitch {
    0%, 31%, 61%, 100% {
        clip-path: polygon(0 0, 100% 0, 100% 100%, 95% 100%, 95% 90%, 80% 90%, 80% 100%, 1.1rem 100%, 0 calc(100% - 1.1rem));
    }
    2%, 8%, 14%, 21%, 25%, 30%, 35%, 45%, 40% {
        clip-path: polygon(0 78%, 100% 78%, 100% 100%, 95% 100%, 95% 90%, 80% 90%, 80% 100%, 1.1rem 100%, 0 78%);
        transform: translate(calc(var(--button-shimmy-distance) * -1%), 0);
    }
    6%, 9%, 10%, 13%, 50% {
        clip-path: polygon(0 78%, 100% 78%, 100% 100%, 95% 100%, 95% 90%, 80% 90%, 80% 100%, 1.1rem 100%, 0 78%);
        transform: translate(calc(var(--button-shimmy-distance) * 1%), 0);
    }
    55%, 60% {
        clip-path: polygon(0 63%, 100% 63%, 100% 80%, 95% 80%, 95% 80%, 85% 80%, 85% 80%, 8% 80%, 0 70%);
        transform: translate(calc(var(--button-shimmy-distance) * 1%), 0);
    }
}

.cyber-button .tag
{
    position: absolute;
    bottom: -5%;
    right: 6%;
    font-weight: normal;
    color: #fff;
    font-size: 10px;
}

  </style>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</head>

<body>
  <?php
  $select = mysqli_query($conn, "SELECT * FROM tbl_cart_master WHERE Cart_status IN ('A','E')");

  if (mysqli_num_rows($select) > 0) {
    while ($master = mysqli_fetch_assoc($select)) {
      $masterid = $master['Mastercart_id'];
      if ($master['Cart_status'] == 'A' || $master['Cart_status'] == 'E') {
        $select_cdate = mysqli_query($conn, "SELECT * FROM tbl_courierassignment WHERE Mastercart_id='$masterid' AND Ca_status = '1'");
        $cdate = mysqli_fetch_assoc($select_cdate);
        $courierid = $cdate['Courier_id'];

        $criddate = mysqli_query($conn, "SELECT Cs_maxdel FROM tbl_Courier WHERE Courier_id = '$courierid'");
        $crdate = mysqli_fetch_assoc($criddate);

        $assignmentDate = $cdate['Courierassign_date'];
        $expectedMaxDelivery = date('Y-m-d', strtotime("+$crdate[Cs_maxdel] days", strtotime($assignmentDate)));

        $currentDate = date("Y-m-d");
        if ($currentDate > $expectedMaxDelivery) {
          // Check if the courier's status is not already '0'
          $selectCourierStatus = mysqli_query($conn, "SELECT Cs_status FROM tbl_Courier WHERE Courier_id = '$courierid'");
          $courierStatus = mysqli_fetch_assoc($selectCourierStatus);


          $updateResult = mysqli_query($conn, "UPDATE tbl_cart_master SET Cart_status = 'E' WHERE Mastercart_id IN (SELECT Mastercart_id FROM tbl_courierassignment WHERE Mastercart_id = '$masterid' AND Ca_status = '1') AND Cart_status != 'D'");

          $qry=mysqli_query($conn,"SELECT COUNT(*) AS total FROM tbl_courierassignment WHERE Courier_id = '$courierid' AND Mastercart_id IN (SELECT Mastercart_id FROM tbl_cart_master WHERE Cart_status= 'A') AND Ca_status = '1'");
          $orderCount = mysqli_fetch_assoc($qry)['total'];

          if ($orderCount == 0) {
          $change = mysqli_query($conn, "UPDATE tbl_Courier SET Cs_status = '0' WHERE Courier_id = '$courierid'");
          }
          // Update all assigned mastercarts to 'R'
        }
      }
    }
  }

  ?>
  <video autoplay loop muted>
    <source src="loop5.mp4" type="video/mp4">
  </video>
  <div class="container">
    <div class="content">
      <h1>
        <sp>Retech</sp> is your <sp>one-stop </sp>website to buy <sp>refurbished tech</sp> for easy <sp>money.</sp><br>
        <sp>you'll</sp>make money,<sp> save money </sp>and help reduce e-waste <sp>too!</sp>
      </h1>
      <button class="cyber-button bg-red fg-white" id="startShoppingButton">
        Start Shopping
        <span class="glitchtext">Start Shopping</span>
        <span class="tag">Buy</span>
      </button>
      <button class="cyber-button bg-red fg-white" id="learnMoreButton">
        Learn More
        <span class="glitchtext">Learn More</span>
        <span class="tag">More</span>
      </button>
    </div>

    <section class="products">
      <h1>latest products</h1>
      <div class="box-container">
        <?php
        $select_products = mysqli_query($conn, "SELECT * FROM tbl_item WHERE item_id IN (SELECT item_id FROM tbl_purchasechild WHERE stock != 0) ORDER BY item_id DESC LIMIT 6");
        if (mysqli_num_rows($select_products) > 0) {
          while ($row = mysqli_fetch_assoc($select_products)) {
            $id = $row['Item_id'];
            ?>
            <div class="box">
              <div class="box-wrapper">
                <a href="#" class="edit-link" data-item-id="<?php echo $id; ?>">
                  <?php
                  $select = mysqli_query($conn, "SELECT Price FROM tbl_purchasechild WHERE Item_id = '$id'");
                  if (mysqli_num_rows($select) > 0) {
                    $var = mysqli_fetch_assoc($select)['Price'];
                  } else {
                    // Handle the case where there are no results, e.g., set a default value
                    $var = 0; // You can change this default value as needed
                  }

                  ?>
                  <img src="<?php echo $row['Item_img']; ?>" width="285" height="140">
                  <div class="name">
                    <?php echo $row['Item_name'] ?>
                  </div>
                  <div class="price">₹
                    <?php
                    $pri = $var;
                    $for_price = number_format($pri);
                    echo $for_price; ?>
                  </div>
                </a>
                <form action="" method="post">
                  <input type="hidden" name="item_id" value="<?php echo $id; ?>"> <!-- Hidden input field for item ID -->
                  <?php if (!empty($_SESSION['userid'])) {
                    if ($_SESSION['usertp'] === 'Staff' || $_SESSION['usertp'] === 'Admin' || $_SESSION['usertp'] === 'Courier') {
                      echo '<a href="#" class="btn"><i class="fas fa-shopping-cart" style="margin-top:15px"></i></a>';
                    } else {
                      ?>
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
          echo '<p class="empty">no products added yet!</p>';
        }
        ?>
      </div>
    </section>

  </div>
  <?php include 'footer.php'; ?>

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
    document.getElementById("startShoppingButton").addEventListener("click", function() {
        window.location.href = "product.php"; // Redirect to products.php
    });

    document.getElementById("learnMoreButton").addEventListener("click", function() {
        window.location.href = "about.php"; // Redirect to about.php
    });
  </script>
</body>

</html>