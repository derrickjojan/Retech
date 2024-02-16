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
        <form method="POST" id="salesReportForm"> <!-- Wrap the table section in a form -->
            <div class="header">
                <h3>Purchase Report</h3>
                <div class="head">
                    <input type="text" name="customerSearch" placeholder="Search by Customer Name">
                    <label for="startDate">Start Date:</label>
                    <input type="date" name="startDate">
                    <label for="endDate">End Date:</label>
                    <input type="date" name="endDate">
                    <button type="submit" name="applyFilters">Apply Filters</button>
                </div>
            </div>
            <div class="table">
                <tbody>
                    <?php
                    // Initialize database connection here (e.g., $conn = mysqli_connect(...))
                    
                    // Check if the form has been submitted with filters
                    if (isset($_POST['applyFilters'])) {
                        $customerSearch = mysqli_real_escape_string($conn, $_POST['customerSearch']);
                        $_SESSION['search'] = $customerSearch;
                        $startDate = mysqli_real_escape_string($conn, $_POST['startDate']);
                        $_SESSION['startdate'] = $startDate;
                        $endDate = mysqli_real_escape_string($conn, $_POST['endDate']);
                        $_SESSION['enddate'] = $endDate;

                        $i = 1;
                        $query = "SELECT * FROM tbl_purchasemaster WHERE 1=1"; // Start with a true condition

                        // Add filters if they are provided
                        if (!empty($customerSearch)) {
                            $query .= " AND Vendor_id IN (SELECT Vendor_id FROM tbl_Vendor WHERE 
                            Vendor_Fname LIKE '%$customerSearch%' OR
                            Vendor_Mname LIKE '%$customerSearch%' OR
                            Vendor_Lname LIKE '%$customerSearch%'
                            )";
                        }
                        
                        if (!empty($startDate)) {
                            $query .= " AND Purchase_Date >= '$startDate'";
                        }
                        if (!empty($endDate)) {
                            $query .= " AND Purchase_Date <= '$endDate'";
                        }

                        // Execute the modified query to fetch the filtered results
                        $result = mysqli_query($conn, $query);

                        // Add headers to the CSV string
                        echo '<table id="salesTable">';
                        echo '<colgroup>';
                        echo '<col width="5%">';
                        echo '<col width="15%">';
                        echo '<col width="15%">';
                        echo '<col width="15%">';
                        echo '<col width="15%">';
                        echo '<col width="10%">';
                        echo '<col width="10%">';
                        echo '</colgroup>';
                        echo '<thead>';
                        echo '<tr>';
                        echo '<th>No.</th>';
                        echo '<th>Vendor Name</th>';
                        echo '<th>Staff Name</th>';
                        echo '<th>Purchase Date</th>';
                        echo '<th>Item Name</th>';
                        echo '<th>price</th>';
                        echo '<th>Quantity</th>';
                        echo '</tr>';
                        echo '</thead>';
                        echo '<tbody>';

                        // Add data to the table
                        while ($row = mysqli_fetch_assoc($result)):

                            $mid = $row['Masterpurch_id'];
                            $venid = $row['Vendor_id'];
                            $staff= $row['Staff_id'];

                            $staff_qry=mysqli_query($conn,"SELECT * FROM tbl_Staff WHERE Staff_id = '$staff'");
                            $staff_name=mysqli_fetch_assoc($staff_qry);


                            $item = mysqli_query($conn, "SELECT * FROM tbl_purchasechild WHERE Masterpurch_id = '$mid'");
                            $irow = mysqli_fetch_assoc($item);
                            $id = $irow['Item_id'];
                            $price = $irow['Price'];
                            $for_price = number_format($price);
                            $qty = $irow['qty'];


                            $itemls = mysqli_query($conn, "SELECT * FROM tbl_Item WHERE Item_id = '$id'");
                            $idrow = mysqli_fetch_assoc($itemls);


                            $pay = mysqli_query($conn, "SELECT * FROM tbl_payment WHERE Mastercart_id = $mid");
                            $date = mysqli_fetch_assoc($pay);


                            $selectt = mysqli_query($conn, "SELECT * FROM tbl_vendor WHERE Vendor_id  = '$venid'");
                            $vendor = mysqli_fetch_assoc($selectt);

                            $itemNames = array(); // Create an array to store item names
                            $item = mysqli_query($conn, "SELECT * FROM tbl_cart_child WHERE Mastercart_id = '$mid'");
                            while ($irow = mysqli_fetch_assoc($item)) {
                                $id = $irow['Item_id'];
                                $itemls = mysqli_query($conn, "SELECT * FROM tbl_Item WHERE Item_id = '$id'");
                                $idrow = mysqli_fetch_assoc($itemls);
                                $itemNames[] = $idrow['Item_name']; // Add item names to the array
                            }


                            foreach ($row as $k => $v) {
                                $row[$k] = trim(stripslashes($v));
                            }
                            // Output the table rows with data
                            echo '<tr>';
                            echo '<td class="text-center">' . $i++ . '</td>';
                            echo '<td>' . $vendor['Vendor_Fname'] . ' ' . $vendor['Vendor_Mname'] . '</td>';
                            echo '<td>' . $staff_name['S_Fname'] . ' ' . $staff_name['S_Mname'] . '</td>';
                            echo '<td>' . $row['Purchase_Date'] . '</td>';
                            echo '<td>' . $idrow['Item_name'] . '</td>';
                            echo '<td>₹' . $for_price . '</td>';
                            echo '<td>' . $qty . '</td>';
                            ?>
                            <?php
                            echo '</tr>';
                        endwhile;

                        echo '</tbody>';
                        echo '</table>';
                    } else {
                        // The form has not been submitted with filters, so fetch and display all results
                        $i = 1;

                        $qry = mysqli_query($conn, "SELECT * FROM tbl_purchasemaster");

                        echo '<table id="salesTable">';
                        echo '<colgroup>';
                        echo '<col width="5%">';
                        echo '<col width="15%">';
                        echo '<col width="15%">';
                        echo '<col width="15%">';
                        echo '<col width="15%">';
                        echo '<col width="10%">';
                        echo '<col width="10%">';
                        echo '</colgroup>';
                        echo '<thead>';
                        echo '<tr>';
                        echo '<th>No.</th>';
                        echo '<th>Vendor Name</th>';
                        echo '<th>Staff Name</th>';
                        echo '<th>Purchase Date</th>';
                        echo '<th>Item Name</th>';
                        echo '<th>price</th>';
                        echo '<th>Quantity</th>';
                        echo '</tr>';
                        echo '</thead>';
                        echo '<tbody>';

                        while ($row = mysqli_fetch_assoc($qry)):
                            $mid = $row['Masterpurch_id'];
                            $venid = $row['Vendor_id'];
                            $staff= $row['Staff_id'];

                            $staff_qry=mysqli_query($conn,"SELECT * FROM tbl_Staff WHERE Staff_id = '$staff'");
                            $staff_name=mysqli_fetch_assoc($staff_qry);



                            $item = mysqli_query($conn, "SELECT * FROM tbl_purchasechild WHERE Masterpurch_id = '$mid'");
                            $irow = mysqli_fetch_assoc($item);
                            $id = $irow['Item_id'];
                            $price = $irow['Price'];
                            $for_price = number_format($price);
                            $qty = $irow['qty'];


                            $itemls = mysqli_query($conn, "SELECT * FROM tbl_Item WHERE Item_id = '$id'");
                            $idrow = mysqli_fetch_assoc($itemls);


                            $pay = mysqli_query($conn, "SELECT * FROM tbl_payment WHERE Mastercart_id = $mid");
                            $date = mysqli_fetch_assoc($pay);


                            $selectt = mysqli_query($conn, "SELECT * FROM tbl_vendor WHERE Vendor_id  = '$venid'");
                            $vendor = mysqli_fetch_assoc($selectt);

                            $itemNames = array(); // Create an array to store item names
                            $item = mysqli_query($conn, "SELECT * FROM tbl_cart_child WHERE Mastercart_id = '$mid'");
                            while ($irow = mysqli_fetch_assoc($item)) {
                                $id = $irow['Item_id'];
                                $itemls = mysqli_query($conn, "SELECT * FROM tbl_Item WHERE Item_id = '$id'");
                                $idrow = mysqli_fetch_assoc($itemls);
                                $itemNames[] = $idrow['Item_name']; // Add item names to the array
                            }


                            foreach ($row as $k => $v) {
                                $row[$k] = trim(stripslashes($v));
                            }
                            // Output the table rows with data
                            echo '<tr>';
                            echo '<td class="text-center">' . $i++ . '</td>';
                            echo '<td>' . $vendor['Vendor_Fname'] . ' ' . $vendor['Vendor_Mname'] . '</td>';
                            echo '<td>' . $staff_name['S_Fname'] . ' ' . $staff_name['S_Mname'] . '</td>';
                            echo '<td>' . $row['Purchase_Date'] . '</td>';
                            echo '<td>' . $idrow['Item_name'] . '</td>';
                            echo '<td>₹' . $for_price . '</td>';
                            echo '<td>' . $qty . '</td>';
                            ?>
                            <?php
                            echo '</tr>';
                        endwhile;

                        echo '</tbody>';
                        echo '</table>';
                    }
                    ?>
                </tbody>
        </table>
    </div>
    </div>

</body>

</html>