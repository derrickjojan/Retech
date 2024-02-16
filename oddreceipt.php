<?php

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$db = 'retech1';
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $db);
if ($conn->connect_error) {
    die("Connection failed:" . $conn->connect_error);
}

session_start();

if (!empty($_SESSION['payid'])) {
    $pid = $_SESSION['payid'];
}
?>
<html lang="en">

<head>
    <title>Receipt</title>
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

        /* Add your CSS styles here */
        .container {

            border: 2px #ccc solid;
            overflow-x: hidden;
            /* Disable horizontal scrolling */
            overflow-y: auto;
            /* Enable vertical scrolling */
        }

        body {
            font-family: Arial, sans-serif;
        }

        .receipt {
            max-width: 190vh;
            min-height: 80vh;
            margin: 0 auto;
            margin-top: 45px;
            padding: 20px;
        }

        .logo {
            text-align: center;
            margin-bottom: 30px;

        }

        .receipt f {
            font-family: 'BlenderPro';
            display: block;
            position: relative;
            font-size: 20px;
        }

        .receipt g {

            font-family: 'robo';
            font-size: 50px;
            color: #f9004d;
            font-weight: 10px;

        }

        .receipt h1 {
            font-family: 'BlenderPro';
            position: relative;
            bottom: 10px;
        }

        spa {
            font-family: 'robo';
            color: #000;

        }

        .receipt table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .receipt th,
        .receipt td {

            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ccc;
        }

        .receipt tfoot {
            font-weight: bold;
        }

        table {
            position: relative;
            top: 25px;
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 7px;
            text-align: left;
            border: 1px solid #ccc;
        }

        th {

            font-weight: bold;
        }

        .order-details {
            display: flex;
            justify-content: space-between;
            /* This will separate the two divs as much as possible */
        }

        .dtls,
        .sum {

            width: 48%;
            /* Adjust the width as needed to leave some space between the divs */
            padding: 10px;
            border: 1px solid #ccc;
        }

        @font-face {
            font-family: 'robo';
            src: url(fonts/ROBOT.ttf);
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="receipt">
            <div class="logo">
                <g>Re<spa>Tech</spa></g>
                <f>Your Trusted Source for Used Electronics <br> Ph No: +123-456-7890, +111-222-3333</f>
                <h1>Receipt</h1>
            </div>

            <div class="table">
                <table>
                    <colgroup>
                        <col width="6%">
                        <col width="20%">
                        <col width="10%">
                        <col width="20%">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Item Name</th>
                            <th>Quantity</th>
                            <th>Item Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $custDetailsDisplayed = false; // Flag to track if customer details have been displayed
                        
                        $select = mysqli_query($conn, "SELECT Mastercart_id FROM tbl_Payment WHERE Payment_id = '$pid' ");
                        $gid = mysqli_fetch_assoc($select)['Mastercart_id'];

                        $qry = mysqli_query($conn, "SELECT * FROM tbl_cart_child WHERE Mastercart_id = '$gid'");
                        while ($row = mysqli_fetch_assoc($qry)):
                            $id = $row['Item_id'];
                            $qty = $row['qty'];

                            $select = mysqli_query($conn, "SELECT * FROM tbl_cart_master WHERE Cart_status IN ('A','P','D') AND Mastercart_id IN (SELECT Mastercart_id FROM tbl_cart_child WHERE Item_id = '$id')");
                            $crow = mysqli_fetch_assoc($select);
                            $custid = $crow['Customer_id'];

                            $selectt = mysqli_query($conn, "SELECT * FROM tbl_customer WHERE Customer_id = '$custid'");
                            $cust = mysqli_fetch_assoc($selectt);

                            $item = mysqli_query($conn, "SELECT * FROM tbl_item WHERE Item_id = '$id' ");
                            $irow = mysqli_fetch_assoc($item);

                            $price = mysqli_query($conn, "SELECT * FROM tbl_purchasechild WHERE Item_id = '$id'");
                            $prrow = mysqli_fetch_assoc($price);

                            $payment = mysqli_query($conn, "SELECT * FROM tbl_payment WHERE Mastercart_id = '$gid'");
                            $prow = mysqli_fetch_assoc($payment);

                            $currentDate = date("Y-m-d");

                            $pri = $prow['Payment_amount'];
                            $for_price = number_format($pri);


                            if (!$custDetailsDisplayed) {
                                // Display customer details only if not already displayed
                                echo '<div class="order-details">';
                                echo '<div class="dtls">';
                                echo '<h3>Customer Details ' . '</h3>';
                                echo '<p>Customer Name: ' . $cust['Cust_Fname'] . ' ' . $cust['Cust_Mname'] . '</p>';
                                echo '<p>Delivery Address: ' . $cust['Cust_dist'] . ', ' . $cust['Cust_city'] . ', ' . $cust['Cust_pin'] . '</p>';
                                echo '<p>Date: ' . $currentDate . '</p>';
                                echo '</div>';
                                echo '<div class="sum">';
                                echo '<h3>Order Summary ' . '</h3>';
                                echo '<p>Item(s) Subtotal: ' . ' ₹' . $for_price . '</p>';
                                echo '<p>Shipping:  ₹0.00' . '</p>';
                                echo '<p>Total Amount:' . ' ₹' . $for_price . '</p>';
                                echo '</div>';
                                echo '</div>';
                                $custDetailsDisplayed = true; // Set the flag to true after displaying customer details
                            }


                            // Trim and sanitize item values
                            foreach ($row as $k => $v) {
                                $row[$k] = trim(stripslashes($v));
                            }
                            ?>
                            <tr>
                                <td class="text-center">
                                    <?php echo $i++; ?>
                                </td>
                                <td>
                                    <?php echo $irow['Item_name'] ?>
                                </td>
                                <td>
                                    <?php echo $qty ?>
                                </td>
                                <td>
                                    ₹
                                    <?php $price = $prrow['Price']; // Your price
                                    
                                        // Format the price with commas
                                        $formatted_price = number_format($price);

                                        echo $formatted_price; ?>

                                </td>
                            </tr>
                        <?php endwhile; ?>
                        <tr>
                            <td></td> <!-- Empty cell for spacing -->
                            <td></td> <!-- Empty cell for spacing -->
                            <td></td> <!-- Empty cell for spacing -->
                            <td><span style="font-weight: bold;">Total Amount: </span>
                                ₹
                                <?php $price = $prow['Payment_amount']; // Your price
                                
                                // Format the price with commas
                                $formatted_price = number_format($price);

                                echo $formatted_price; ?>
                            </td> <!-- Total Amount -->

                        </tr>
                    </tbody>


                </table>
            </div>
        </div>
    </div>
    <script>
    // Function to print the page when it loads
    window.onload = function () {
        // Add an event listener for afterprint
        window.addEventListener('afterprint', function () {
            // User canceled the print dialog, redirect them to orders.php
            window.location.href = 'orders.php';
        });

        // Print the page
        window.print();
    };
</script>

</body>

</html>