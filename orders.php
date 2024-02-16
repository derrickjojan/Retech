<?php include 'head.php'; ?>
<?php
if (isset($_POST['save'])) {
  $masterid = mysqli_real_escape_string($conn, $_POST['master_id']);
  $pay = mysqli_query($conn, "SELECT * FROM tbl_payment WHERE Mastercart_id = $masterid");
  $date = mysqli_fetch_assoc($pay);
  $_SESSION['payid']=$date['Payment_id'];
      echo '<script>window.location.href = "oddreceipt.php";</script>';
}
?>
<html>

<head>
  <title>Orders</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  <style>
    .container {


      overflow-x: hidden;
      /* Disable horizontal scrolling */
      overflow-y: auto;
      /* Enable vertical scrolling */
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
      margin-top: 20px;
    }

    .products {
      border: #fff solid;
      padding-bottom: 30px;
      margin-top: 30px;
      min-height: 85vh;
      background-color: rgba(0, 0, 0, 0.9);
      border-radius: 20px;
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



    .header {
      clip-path: polygon(0 0, 0 calc(100% - 30px), 30px 100%, 100% 100%, 100% 30px, calc(100% - 30px) 0);
      border-top: #f9004d solid;
      width: 190vh;
      height: 50px;
      margin-left: 40px;
      margin-top: 2px;
      border-top: #f9004d solid;
      background-color: #f9004d;
      display: inline-flex;
      border-radius: 5px;
    }

    /* Style the product box */
    .box {
      clip-path: polygon(0 0, 0 calc(100% - 30px), 30px 100%, 100% 100%, 100% 30px, calc(100% - 30px) 0);
      border-top: #f9004d solid;
      width: 190vh;
      max-height: 180px;
      margin-left: 40px;
      margin-top: 2px;
      border-top: #f9004d solid;
      background-color: #f9004d;
      border-radius: 5px;
    }

    .box-wrapper {
      clip-path: polygon(0 0, 0 calc(100% - 30px), 30px 100%, 100% 100%, 100% 30px, calc(100% - 30px) 0);
      width: 190vh;
      max-height: 180px;
      background-color: rgba(17, 11, 28, 0.98);
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
      border-radius: 5px;
    }

    .box img {
      border: #f9004d solid;
      width: 15%;
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

    .total {
      font-family: OstrichSans;
      color: #fff;
      font-weight: bold;
      margin-top: 10px;
      font-size: 28px;
      position: relative;
      left: 25vh;
      bottom: 1px;
      min-width: 300px;
      max-width: 300px;
    }

    .date {
      font-family: OstrichSansreg;
      color: #fff;
      margin-top: 10px;
      font-size: 30px;
      position: relative;
      left: 5vh;
      bottom: 5px;
      max-width: 300px;
    }

    .del {
      position: relative;
      right: 180px;
    }

    .sdate {
      font-family: OstrichSansreg;
      color: #fff;
      margin-top: 10px;
      font-size: 30px;
      position: relative;
      left: 45vh;
      bottom: 5px;
      min-width: 500px;
      max-width: 500px;
    }

    .status {
      font-family: OstrichSansreg;
      color: #f9004d;
      margin-top: 10px;
      font-size: 30px;
      position: relative;
      left: 15vh;
      bottom: 7px;
      background-color: #fff;
      min-width: 210px;
      padding-left: 20px;
      padding-bottom: 10px;
      border-radius: 8px;
      border: #000 solid;

    }

    .box .price {
      font-family: OstrichSans;
      color: #f9004d;
      margin-top: 10px;
      font-size: 30px;
      position: relative;
      left: 90vh;
      bottom: 24vh;
    }

    .box .qty {
      font-family: OstrichSansreg;
      color: #f9004d;
      margin-top: 10px;
      font-size: 30px;
      position: relative;
      left: 160vh;
      bottom: 30.5vh;
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

    .save {
      background: transparent;
      border: none;
      color:#fff;
      font-size: 30px;
      position: relative;
      right: 11vh;
      top: 5px;
    }
  </style>
</head>

<body>
  <video autoplay loop muted>
    <source src="vid2.mp4" type="video/mp4">
  </video>
  <div class="container">
    <section class="products">
      <h1>Orders</h1>
      <div class="box-container">
        <?php
        $totalPrice = 0; // Initialize the total price
        
        $select = mysqli_query($conn, "SELECT * FROM tbl_cart_master WHERE Customer_id = '$user_id' AND Cart_status IN ('A', 'P', 'D','R','E') ORDER BY Mastercart_id DESC");

        if (mysqli_num_rows($select) > 0) {
          while ($master = mysqli_fetch_assoc($select)) {
            $masterid = $master['Mastercart_id'];
            $pay = mysqli_query($conn, "SELECT * FROM tbl_payment WHERE Mastercart_id = $masterid");
            $date = mysqli_fetch_assoc($pay);
            $selectt = mysqli_query($conn, "SELECT * FROM tbl_cart_child WHERE Mastercart_id = $masterid");
            $select_ddate = mysqli_query($conn, "SELECT Delivery_date FROM tbl_delivery WHERE Courierassign_id IN (SELECT Courierassign_id FROM tbl_Courierassignment WHERE Mastercart_id = '$masterid')");
            $ddate = mysqli_fetch_assoc($select_ddate);
            ?>
            <div class="header">
              <div class="date">Ordered On:
                <?php echo $date['Payment_date'] ?>
              </div>
              <div class="status">
                <?php
                if ($master['Cart_status'] == 'P') {
                  echo "Status: PAID";
                } elseif ($master['Cart_status'] == 'A') {
                  echo "Status: ASSIGNED";
                } elseif ($master['Cart_status'] == 'D') {
                  echo "Status: DELIVERED";
                } elseif ($master['Cart_status'] == 'R') {
                  echo "Status: Returned";
                } elseif ($master['Cart_status'] == 'E') {
                  echo "Status: Expired";
                }

                ?>
              </div>
              <div class="sdate">
                <?php
                if ($master['Cart_status'] == 'P') {
                  echo 'Paid On: ' . $date['Payment_date'];
                }
                if ($master['Cart_status'] == 'A') {
                  $select_cdate = mysqli_query($conn, "SELECT * FROM tbl_courierassignment WHERE Mastercart_id='$masterid'");
                  $cdate = mysqli_fetch_assoc($select_cdate);
                  $courierid = $cdate['Courier_id'];

                  $criddate = mysqli_query($conn, "SELECT Cs_mindel, Cs_maxdel FROM tbl_Courier WHERE Courier_id = '$courierid'");
                  $crdate = mysqli_fetch_assoc($criddate);

                  $assignmentDate = $cdate['Courierassign_date'];
                  $expectedMinDelivery = date('Y-m-d', strtotime("+$crdate[Cs_mindel] days", strtotime($assignmentDate)));
                  $expectedMaxDelivery = date('Y-m-d', strtotime("+$crdate[Cs_maxdel] days", strtotime($assignmentDate)));

                  echo '<div class="del">Expected delivery: ' . $expectedMinDelivery . ' - ' . $expectedMaxDelivery . '</div>';
                } elseif ($master['Cart_status'] == 'D') {
                  echo 'Delivered On: ' . $ddate['Delivery_date'];
                } elseif ($master['Cart_status'] == 'R') {
                  echo 'Returned';
                } elseif ($master['Cart_status'] == 'E') {
                  echo 'Delivery Expired';
                }
                ?>
              </div>

              <div class="total">Total Amount:
                <?php
                $pri = $date['Payment_amount'];
                $for_price = number_format($pri);
                echo $for_price ?>
              </div>
              <form action="" method="POST">
              <div class="save">
                 <input type="hidden" name="master_id" value="<?php echo $masterid; ?>">
                <button type="submit" class="save" name="save"><i class="fas fa-save"></i></button>
              </div>
              </form>
            </div>
            <?php
            while ($child = mysqli_fetch_assoc($selectt)) {
              $item = $child['Item_id'];
              $qty = $child['qty'];
              $select_products = mysqli_query($conn, "SELECT * FROM tbl_Item WHERE Item_id = '$item'");
              $row = mysqli_fetch_assoc($select_products);
              $id = $row['Item_id'];

              $select_price = mysqli_query($conn, "SELECT Price FROM tbl_purchasechild WHERE Item_id = '$id'");
              $var = mysqli_fetch_assoc($select_price);
              $itemPrice = $var['Price'];

              $select_cdate = mysqli_query($conn, "SELECT * FROM tbl_courierassignment WHERE Mastercart_id='$masterid'");
              $cdate = mysqli_fetch_assoc($select_cdate);



              // Add the item price to the total price
              $totalPrice += $itemPrice;
              ?>

              <div class="box">
                <div class="box-wrapper">
                  <img src="<?php echo $row['Item_img']; ?>" width="285" height="140">
                  <div class="name">
                    <?php echo $row['Item_name'] ?>
                  </div>
                  <div class="price">₹
                    <?php
                    $pri = $itemPrice;
                    $for_price = number_format($pri);
                    echo $for_price;
                    ?>
                  </div>
                  <div class="qty">Quantity:
                    <?php
                    echo $qty;
                    ?>
                  </div>
                </div>
              </div>
              <?php
            }
          }
        } else {
          echo '<p class="msg">Empty</p>';
        }
        ?>
      </div>
    </section>




  </div>
  <script>
    function printAndClose() {
      var printWindow = window.open("receipt.php", "_blank");
      printWindow.onload = function () {
        printWindow.print();
        printWindow.onafterprint = function () {
          printWindow.close();
        };
      };
    }
  </script>
</body>

</html>