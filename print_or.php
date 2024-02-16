<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$db = 'retech1';
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $db);
if ($conn->connect_error) {
    die("Connection failed:" . $conn->connect_error);
}
$currentDate = date("Y-m-d");
?>
<html>

<head>
    <style>
        body {
            background-color: white;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 5px;
            border: 1px solid #ccc;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .receipt p {
            font-family: 'Martian Mono', monospace;
            font-size: 20px;
        }

        .logo {
            margin-top: 30px;
            text-align: center;
            margin-bottom: 5px;

        }

        .receipt g {

            font-family: 'robo';
            font-size: 50px;
            font-weight: 10px;
            color: #f9004d;
        }

        .receipt {
            text-align: center;
            max-width: 190vh;
            min-height: 0vh;
            margin: 0 auto;
        }

        .list {
            font-family: 'Martian Mono', monospace;
            font-size: 20px;
        }

        .page-break {
            page-break-after: always;
        }

        .page {
            display: flex;
            position: relative;
            text-align: right;
            font-size: 14px;
            color: #333;
        }

        .date {
            display: flex;
            position: relative;
            text-align: right;
            font-size: 14px;
            color: #333;
        }
    </style>

</head>

<body>
    <div class="container">
        <div class="receipt">
            <div class="logo">
                <img src='logo.jpeg' width='400' height='100'>
                <p>Your Trusted Source for Used Electronics</p>
            </div>
            <h3 class="list">Order List</h3>
        </div>
        <p class="date">Date:
            <?php echo $currentDate; ?>
        </p>
        <?php
        $i = 1;
        $j = 1;
        $perPage = 20; // Number of entries per page
        $page = 1; // Initialize page number
        $qry = mysqli_query($conn, "SELECT * FROM tbl_cart_master WHERE Cart_status IN ('A','P','D')");
        $totalRows = mysqli_num_rows($qry);
        ?>
        <?php while ($row = mysqli_fetch_assoc($qry)):
            $mid = $row['Mastercart_id'];

            $item = mysqli_query($conn, "SELECT * FROM tbl_cart_child WHERE Mastercart_id = '$mid'");
            $irow = mysqli_fetch_assoc($item);
            $id = $irow['Item_id'];

            $itemls = mysqli_query($conn, "SELECT * FROM tbl_Item WHERE Item_id = '$id'");
            $idrow = mysqli_fetch_assoc($itemls);

            $select = mysqli_query($conn, "SELECT * FROM tbl_cart_master WHERE Cart_status IN ('A','P','D') AND Mastercart_id IN (SELECT Mastercart_id FROM tbl_cart_child WHERE Item_id = '$id')");
            $crow = mysqli_fetch_assoc($select);
            $custid = $crow['Customer_id'];

            $pay = mysqli_query($conn, "SELECT * FROM tbl_payment WHERE Mastercart_id = $mid");
            $date = mysqli_fetch_assoc($pay);


            $price = mysqli_query($conn, "SELECT * FROM tbl_purchasechild WHERE Item_id = '$id'");
            $prrow = mysqli_fetch_assoc($price);

            $selectt = mysqli_query($conn, "SELECT * FROM tbl_customer WHERE Customer_id = '$custid'");
            $cust = mysqli_fetch_assoc($selectt);

            $payment = mysqli_query($conn, "SELECT * FROM tbl_payment WHERE Mastercart_id = '$mid'");
            $prow = mysqli_fetch_assoc($payment);
            // Trim and sanitize item values
        
            $courier = mysqli_query($conn, "SELECT Cs_name FROM tbl_courier WHERE Courier_id IN (SELECT Courier_id FROM tbl_courierassignment WHERE Mastercart_id = '$mid')");
            $crrow = mysqli_fetch_assoc($courier);

            foreach ($row as $k => $v) {
                $row[$k] = trim(stripslashes($v));
            } ?>
            <?php if ($i % $perPage === 1): ?>
                <?php if ($page > 1): ?>
                    </tbody>
                    </table>
                <?php endif; ?>
                <div class="table">
                    <p class="page">Page
                        <?php echo $page; ?>
                    </p>
                    <table id="salesTable">
                    <colgroup>
                    <col width="5%">
                    <col width="10%">
                    <col width="10%">
                    <col width="10%">
                    <col width="10%">
                    <col width="15%">
                    <col width="5%">
                </colgroup>
                        <thead>
                        <tr>
                        <th>No.</th>
                        <th>Ordered Date</th>
                        <th>Customer Name</th>
                        <th>Total Amount</th>
                        <th>Courier Name</th>
                        <th>Item Names</th>
                        <th>Status</th>
                    </tr>
                        </thead>
                        <tbody>
                        <?php endif; ?>

                        <tr>
                            <td class="text-center">
                                <?php echo $j++; ?>
                            </td>
                            <td>
                                <?php echo $date['Payment_date'] ?>
                            </td>
                            <td>
                                <?php echo $cust['Cust_Fname'] . ' ' . $cust['Cust_Mname'] ?>
                            </td>
                            <td> ₹
                                <?php
                                $pri = $prow['Payment_amount'];
                                $for_price = number_format($pri);
                                echo $for_price; ?>
                            </td>
                            <?php if ($crrow): ?>
                                <td>
                                    <?php echo $crrow['Cs_name'] ?>
                                </td>
                            <?php else: ?>
                                <td>Unassigned</td>
                            <?php endif; ?>
                            <td>
                                <?php
                                $itemNames = array(); // Create an array to store item names
                                $item = mysqli_query($conn, "SELECT * FROM tbl_cart_child WHERE Mastercart_id = '$mid'");
                                while ($irow = mysqli_fetch_assoc($item)) {
                                    $id = $irow['Item_id'];
                                    $itemls = mysqli_query($conn, "SELECT * FROM tbl_Item WHERE Item_id = '$id'");
                                    $idrow = mysqli_fetch_assoc($itemls);
                                    $itemNames[] = $idrow['Item_name']; // Add item names to the array
                                }

                                // Use implode() to concatenate item names with a separator
                                echo implode(', ', $itemNames);
                                ?>
                            </td>
                            <td>
                                <?php
                                if ($crow['Cart_status'] === 'P') {
                                    echo 'Paid';
                                } elseif ($crow['Cart_status'] === 'A') {
                                    echo 'Assigned';
                                } elseif ($crow['Cart_status'] === 'D') {
                                    echo 'Delivered';
                                } else {
                                    echo 'Unknown';
                                }
                                ?>
                            </td>
                            </td>
                        </tr>

                        <?php if ($i % $perPage === 0 || $i === $totalRows): ?>
                        </tbody>
                    </table>
                </div>
                <div class="page-break"></div>
                <?php $page++; ?>
            <?php endif; ?>
            <?php $i++; ?>
        <?php endwhile; ?>
    </div>
</body>

</html>