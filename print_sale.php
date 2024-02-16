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
if (!empty($_SESSION['search'])) {
    $customerSearch = $_SESSION['search'];
}
if (!empty($_SESSION['startdate'])) {
    $startDate = $_SESSION['startdate'];
}
if (!empty($_SESSION['enddate'])) {
    $endDate = $_SESSION['enddate'];
}
$currentDate = date("Y-m-d");

?>
<html>

<head>
    <style>
        @font-face {
            font-family: 'robo';
            src: url(fonts/ROBOT.ttf);
        }

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

        .list {
            text-align: center;
        }

        span {
            font-family: 'robo';
            color: #000;

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
            max-width: 190vh;
            min-height: 0vh;
            margin: 0 auto;
        }

        .container {
            min-height: 70vh;
            overflow-x: hidden;
            /* Disable horizontal scrolling */
            overflow-y: auto;
            /* Enable vertical scrolling */
        }

        .list {
            font-family: 'BlenderPro';
            font-size: 20px;
            text-align: center;
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
            <h3 class="list">Customer List</h3>
        </div>
        <p class="date">Date:
            <?php echo $currentDate; ?>
        </p>
        <?php
        $i = 1;
        $page = 1; // Initialize page number
        $perPage = 20;
        if ($i % $perPage === 1): ?>
            <?php if ($page > 1): ?>
                </tbody>
                </table>
            </div>
        <?php endif; ?>
        <div class="table">
        <p class="page">Page
                        <?php echo $page; ?>
                    </p>
            <table>
                <colgroup>
                    <col width="5%">
                    <col width="15%">
                    <col width="15%">
                    <col width="15%">
                    <col width="15%">
                    <col width="10%">
                </colgroup>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Ordered Date</th>
                        <th>Item Name</th>
                        <th>Customer Name</th>
                        <th>Courier Name</th>
                        <th>Total Amount</th>
                    </tr>
                </thead>
                <tbody>
                <?php endif; ?>
                <?php
                if (isset($_SESSION['search']) || isset($_SESSION['startdate']) || isset($_SESSION['enddate'])) {
                    $query = "SELECT * FROM tbl_cart_master WHERE Cart_status IN ('A','P','D')";
                    if (!empty($customerSearch)) {
                        // Sanitize the input
                        $customerSearch = mysqli_real_escape_string($conn, $customerSearch);

                        // Split the search term into individual words
                        $searchTerms = explode(" ", $customerSearch);

                        // Build conditions for each search term
                        $nameConditions = array();
                        $customerIds = array();
                        $courierIds = array();

                        foreach ($searchTerms as $term) {
                            $term = mysqli_real_escape_string($conn, $term);
                            $nameConditions[] = "Cust_Fname LIKE '%$term%' OR Cust_Mname LIKE '%$term%' OR Cust_Lname LIKE '%$term%'";

                            $courierConditions[] = "Cs_name LIKE '%$term%'";
                        }

                        $nameCondition = '(' . implode(' OR ', $nameConditions) . ')';

                        $qry = mysqli_query($conn, "SELECT Customer_id FROM tbl_customer WHERE $nameCondition");

                        while ($row = mysqli_fetch_assoc($qry)) {
                            $customerIds[] = $row['Customer_id'];
                        }

                        if (!empty($customerIds)) {
                            $customerIdsString = implode("','", $customerIds);
                            $query .= " AND Customer_id IN ('$customerIdsString')";

                            if (!empty($startDate)) {
                                $query .= " AND Mastercart_id IN (SELECT Mastercart_id FROM tbl_payment WHERE Payment_date >= '$startDate')";
                            }
                            if (!empty($endDate)) {
                                $query .= " AND Mastercart_id IN (SELECT Mastercart_id FROM tbl_payment WHERE Payment_date <= '$endDate')";
                            }

                        } else {
                            // If it's not a customer's name, try to find a courier's name
                            $sqry = mysqli_query($conn, "SELECT * FROM tbl_courier WHERE Cs_name LIKE '%$customerSearch%'");

                            if (mysqli_num_rows($sqry) > 0) {
                                // Fetch all courier names that match the search term
                                $courierNames = [];
                                while ($row = mysqli_fetch_assoc($sqry)) {
                                    $courierNames[] = $row["Cs_name"];
                                }

                                // Create an array to store cart_master_ids
                                $cartIds = [];

                                foreach ($courierNames as $courierName) {
                                    // Fetch cart_master_ids associated with each courier
                                    $cartIdsQuery = "SELECT Mastercart_id FROM tbl_courierassignment WHERE Courier_id = (SELECT Courier_id FROM tbl_courier WHERE Cs_name = '$courierName')";
                                    $cartIdsResult = mysqli_query($conn, $cartIdsQuery);

                                    while ($row = mysqli_fetch_assoc($cartIdsResult)) {
                                        $cartIds[] = $row['Mastercart_id'];
                                    }
                                }

                                if (!empty($cartIds)) {
                                    // Add the cart_master_ids to the main query
                                    $cartIdsString = implode(',', $cartIds);
                                    $query .= " AND Mastercart_id IN ($cartIdsString)";
                                    // Filter by courierassign_date
                                    if (!empty($startDate)) {
                                        $query .= " AND Mastercart_id IN (SELECT Mastercart_id FROM tbl_courierassignment WHERE Courier_id IN (SELECT Courier_id FROM tbl_courier WHERE Cs_name IN ('" . implode("','", $courierNames) . "')) AND Courierassign_date >= '$startDate')";
                                    }
                                    if (!empty($endDate)) {
                                        $query .= " AND Mastercart_id IN (SELECT Mastercart_id FROM tbl_courierassignment WHERE Courier_id IN (SELECT Courier_id FROM tbl_courier WHERE Cs_name IN ('" . implode("','", $courierNames) . "')) AND Courierassign_date <= '$endDate')";
                                    }
                                } else {
                                    // Handle case when no matching cart_master_ids are found
                                    $query .= " AND 0"; // This will ensure no results are returned
                                    echo "No matching records found.";
                                }
                            } else {
                                $query .= " AND 0";
                                echo "No matching records found.";
                            }
                        }
                    }
                    $result = mysqli_query($conn, $query);
                    $totalRows = mysqli_num_rows($result);

                    // Now, you can use the $result to display the filtered results in your table
                

                    // Display the filtered results in your table
                    while ($row = mysqli_fetch_assoc($result)) {

                        $mid = $row['Mastercart_id'];

                        $item = mysqli_query($conn, "SELECT * FROM tbl_cart_child WHERE Mastercart_id = '$mid'");
                        while ($irow = mysqli_fetch_assoc($item)) {
                            $id = $irow['Item_id'];
                        }

                        $itemls = mysqli_query($conn, "SELECT * FROM tbl_Item WHERE Item_id = '$id'");
                        $idrow = mysqli_fetch_assoc($itemls);

                        $select = mysqli_query($conn, "SELECT * FROM tbl_cart_master WHERE Cart_status IN ('A','P','D') AND Mastercart_id = '$mid'");
                        while ($crow = mysqli_fetch_assoc($select)) {
                            $custid = $crow['Customer_id'];
                        }
                        $pay = mysqli_query($conn, "SELECT * FROM tbl_payment WHERE Mastercart_id = $mid");
                        $date = mysqli_fetch_assoc($pay);


                        $selectt = mysqli_query($conn, "SELECT * FROM tbl_customer WHERE Customer_id = '$custid'");
                        $cust = mysqli_fetch_assoc($selectt);

                        $payment = mysqli_query($conn, "SELECT * FROM tbl_payment WHERE Mastercart_id = '$mid'");
                        $prow = mysqli_fetch_assoc($payment);
                        // Trim and sanitize item values
                
                        $courier = mysqli_query($conn, "SELECT Cs_name FROM tbl_courier WHERE Courier_id IN (SELECT Courier_id FROM tbl_courierassignment WHERE Mastercart_id = '$mid')");

                        if (mysqli_num_rows($courier) > 0) {
                            $crrow = mysqli_fetch_assoc($courier);
                            $cr = $crrow['Cs_name'];
                        } else {
                            $cr = "UNASSIGNED";
                        }

                        foreach ($row as $k => $v) {
                            $row[$k] = trim(stripslashes($v));
                        }
                        ?>
                        
                        <tr>
                            <td class="text-center">
                                <?php echo $i++; ?>
                            </td>
                            <td>
                                <?php echo $date['Payment_date'] ?>
                            </td>
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
                                <?php echo $cust['Cust_Fname'] . ' ' . $cust['Cust_Mname'] ?>
                            </td>
                            <td>
                                <?php echo $cr ?>
                            </td>
                            <td>₹
                                <?php
                                $pri = $prow['Payment_amount'];
                                $for_price = number_format($pri);
                                echo $for_price; ?>
                            </td>
                        </tr>
                        <?php if ($i % $perPage === 0 || $i === $totalRows): ?>
                            <div class="page-break"></div>
                            
                            <?php $page++; ?>
                        <?php endif; ?>
                        <?php
                    }
                    $_SESSION['search'] = '';
                    $_SESSION['startdate'] = '';
                    $_SESSION['enddate'] = '';

                } else {
                    // The form has not been submitted with filters, so fetch and display all results
                    $i = 1;

                    $qry = mysqli_query($conn, "SELECT * FROM tbl_cart_master WHERE Cart_status IN ('A','P','D')");
                    $totalRows = mysqli_num_rows($qry);
                    while ($row = mysqli_fetch_assoc($qry)):
                        $mid = $row['Mastercart_id'];

                        $item = mysqli_query($conn, "SELECT * FROM tbl_cart_child WHERE Mastercart_id = '$mid'");
                        while ($irow = mysqli_fetch_assoc($item)) {
                            $id = $irow['Item_id'];
                        }
                        $itemls = mysqli_query($conn, "SELECT * FROM tbl_Item WHERE Item_id = '$id'");
                        $idrow = mysqli_fetch_assoc($itemls);

                        $select = mysqli_query($conn, "SELECT * FROM tbl_cart_master WHERE Cart_status IN ('A','P','D') AND Mastercart_id = '$mid'");
                        while ($crow = mysqli_fetch_assoc($select)) {
                            $custid = $crow['Customer_id'];
                        }
                        $pay = mysqli_query($conn, "SELECT * FROM tbl_payment WHERE Mastercart_id = $mid");
                        $date = mysqli_fetch_assoc($pay);


                        $selectt = mysqli_query($conn, "SELECT * FROM tbl_customer WHERE Customer_id = '$custid'");
                        $cust = mysqli_fetch_assoc($selectt);

                        $payment = mysqli_query($conn, "SELECT * FROM tbl_payment WHERE Mastercart_id = '$mid'");
                        $prow = mysqli_fetch_assoc($payment);
                        // Trim and sanitize item values
                
                        $courier = mysqli_query($conn, "SELECT Cs_name FROM tbl_courier WHERE Courier_id IN (SELECT Courier_id FROM tbl_courierassignment WHERE Mastercart_id = '$mid')");

                        if (mysqli_num_rows($courier) > 0) {
                            $crrow = mysqli_fetch_assoc($courier);
                            $cr = $crrow['Cs_name'];
                        } else {
                            $cr = "UNASSIGNED";
                        }

                        foreach ($row as $k => $v) {
                            $row[$k] = trim(stripslashes($v));
                        }
                        ?>
                        <tr>
                            <td class="text-center">
                                <?php echo $i++; ?>
                            </td>
                            <td>
                                <?php echo $date['Payment_date'] ?>
                            </td>
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
                                <?php echo $cust['Cust_Fname'] . ' ' . $cust['Cust_Mname'] ?>
                            </td>
                            <td>
                                <?php echo $cr ?>
                            </td>
                            <td>₹
                                <?php
                                $pri = $prow['Payment_amount'];
                                $for_price = number_format($pri);
                                echo $for_price; ?>
                            </td>

                            </td>
                        </tr>
                        <?php if ($i % $perPage === 0 || $i === $totalRows): ?>
                            <div class="page-break"></div>
                            <?php $page++; ?>
                        <?php endif; ?>
                    <?php endwhile;
                } ?>

            </tbody>


        </table>
    </div>
    </div>

</body>

</html>