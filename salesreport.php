<?php include('admin.php') ?>
<?php
$customerSearch = '';
$startDate = '';
$endDate = '';


$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$db = 'retech1';
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $db);
if ($conn->connect_error) {
    die("Connection failed:" . $conn->connect_error);
}
?>

<html>

<head>
    <style>
        @font-face {
            font-family: 'OstrichSansreg';
            src: url(fonts/OstrichSans-Heavy.otf);
        }

        body {
            background-color: white;
            overflow-x: hidden;
            /* Disable horizontal scrolling */
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

        .container {
            font-family: 'Blender';
            font-size: 17px;
            box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
            position: relative;
            left: 17%;
            top: 130px;
            width: 1199px;
            padding: 20px;
            border-top: 3px solid #000;
            background-color: #fff;
            border-radius: 2px;
            transition: left 0.9s ease;
        }

        #check:checked~.container {
            position: relative;
            left: 100px;

            width: calc(91% - 120px);
        }

        .head {
            position: relative;
            right: 18vh;
        }


        /* Input Styles */
        input[type="text"],
        input[type="date"] {
            width: 150px;
            padding: 5px;
            margin: 5px;
            border: 2px solid #000;
            border-radius: 3px;
            font-size: 16 px;
        }

        input[type="text"] {
            width: 230px;
        }

        /* Label Styles */
        label {
            font-size: 16px;
            margin-right: 5px;
        }

        /* Button Styles */
        .apply {
            font-weight: bold;
            padding: 11px 20px;
            background-color: #000;
            color: #fff;
            border: none;
            margin-left: 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .header {
            position: relative;
            right: 20px;
            bottom: 22px;
            width: 101.7%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #000000;
            margin-bottom: 10px;
            border-radius: 2px;

        }


        .header h3 {
            font-size: 30px;
            font-weight: bold;
            color: #000;
            margin: 0;
        }

        .btn {

            display: inline-block;
            padding: 10px 20px;
            background-color: #000;
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #f9004d;
        }

        table {
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

        .text-center {
            text-align: center;
        }

        .dp {
            position: relative;
            display: inline-block;
        }

        .dpbtn {
            background-color: #000;
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            border: none;
            padding: 8px 16px;
            border-radius: 3px;
            cursor: pointer;
        }

        .dp:hover .dropbtn {
            background-color: #0056b3;
        }

        .dp-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dp-content a {
            color: #333;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dp-content a:hover {
            background-color: #f2f2f2;
        }

        .dp:hover .dp-content {
            display: block;
        }

        .bttn {
            border: none;
            display: inline-block;
            padding: 11px 20px;
            background-color: #000;
            color: #fff;
            font-size: 16px;
            position: absolute;
            top: 8.5px;
            right: 1vh;
            font-weight: bold;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .exp-dropdown {
            position: absolute;
            right: 30px;
            top: 8px;
            z-index: 100;
        }

        .exp-dropdown-content {
            display: none;
            position: absolute;
            right: 0px;
            min-width: 130px;
            background-color: #f9f9f9;

        }

        .exp-dropdown:hover .exp-dropdown-content {
            display: block;

        }

        .exp-dropdown-content a {
            color: black;
            padding: 10px;
            text-decoration: none;
            display: block;
            border: 1px solid #ccc;
        }

        .exp-dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .exp-dropbtn {
            background-color: #000;
            color: #fff;
            border-radius: 4px;
            border: none;
            font-size: 16px;
            font-weight: bold;
            padding: 11px 20px;
        }

        .excel {
            color: black;
            padding: 10px;
            text-decoration: none;
            display: block;
            border: 1px solid #ccc;
        }

        .save {
            border: none;
            background-color: white;
            color: #000;
            font-size: 20px;
            position: relative;
            top: 2px;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.0/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

</head>

<body>
    <div class="container">
        <form method="POST" id="salesReportForm"> <!-- Wrap the table section in a form -->
            <div class="header">
                <h3>Sales Report</h3>
                <div class="head">
                    <input type="text" name="customerSearch" placeholder="Search by Customer Or Courier Name">
                    <label for="startDate">Start Date:</label>
                    <input type="date" name="startDate">
                    <label for="endDate">End Date:</label>
                    <input type="date" name="endDate">
                    <button type="submit" class="apply" name="applyFilters">Apply Filters</button>
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

                        // Add headers to the CSV string
                        echo '<table id="salesTable">';
                        echo '<colgroup>';
                        echo '<col width="5%">';
                        echo '<col width="15%">';
                        echo '<col width="15%">';
                        echo '<col width="15%">';
                        echo '<col width="15%">';
                        echo '<col width="10%">';
                        echo '</colgroup>';
                        echo '<thead>';
                        echo '<tr>';
                        echo '<th>No.</th>';
                        echo '<th>Ordered Date</th>';
                        echo '<th>Item Name</th>';
                        echo '<th>Customer Name</th>';
                        echo '<th>Courier Name</th>';
                        echo '<th>Total Amount</th>';
                        echo '</tr>';
                        echo '</thead>';
                        echo '<tbody>';

                        // Add data to the table
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
                            echo '<td>' . $date['Payment_date'] . '</td>';
                            echo '<td>' . implode(', ', $itemNames) . '</td>';
                            ?>
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
                            <?php
                            echo '</tr>';

                        }

                        echo '</tbody>';
                        echo '</table>';
                    } else {
                        // The form has not been submitted with filters, so fetch and display all results
                        $i = 1;

                        $qry = mysqli_query($conn, "SELECT * FROM tbl_cart_master WHERE Cart_status IN ('A','P','D')");

                        echo '<table id="salesTable">';
                        echo '<colgroup>';
                        echo '<col width="5%">';
                        echo '<col width="15%">';
                        echo '<col width="15%">';
                        echo '<col width="15%">';
                        echo '<col width="15%">';
                        echo '<col width="10%">';
                        echo '</colgroup>';
                        echo '<thead>';
                        echo '<tr>';
                        echo '<th>No.</th>';
                        echo '<th>Ordered Date</th>';
                        echo '<th>Item Name</th>';
                        echo '<th>Customer Name</th>';
                        echo '<th>Courier Name</th>';
                        echo '<th>Total Amount</th>';
                        echo '</tr>';
                        echo '</thead>';
                        echo '<tbody>';

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
                            echo '<td>' . $date['Payment_date'] . '</td>';
                            echo '<td>' . implode(', ', $itemNames) . '</td>';
                            ?>
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
                            <?php
                            echo '</tr>';
                        endwhile;

                        echo '</tbody>';
                        echo '</table>';
                    }
                    ?>
                </tbody>
            </div>
            <div class="exp-dropdown">
                <button class="exp-dropbtn">Export</button>
                <div class="exp-dropdown-content">
                <a href="#" onclick="printAndClose()">Print</a>
                    <a href="#" id="exportToExcel" onclick="exportToExcel()">Export to Excel</a>
                    <a href="generate_pdf.php">Export to PDF</a>
                </div>
            </div>
        </form>
    </div>
    <script>
                function printAndClose() {
            var printWindow = window.open("print_sale.php", "_blank");
            printWindow.onload = function () {
                printWindow.print();
                printWindow.onafterprint = function () {
                    printWindow.close();
                };
            };
        }
 
        function exportToExcel() {
            var table = document.getElementById('salesTable');

            var wb = XLSX.utils.book_new();
            var ws = XLSX.utils.table_to_sheet(table);

            /* Add worksheet to the workbook */
            XLSX.utils.book_append_sheet(wb, ws, "Sales Report");

            var wscols = [
                { wch: 10 }, /* Column A width */
                { wch: 15 }, /* Column B width */
                { wch: 40 }, /* Column C width */
                { wch: 20 }, /* Column C width */
                { wch: 15 }, /* Column C width */
            ];
            ws['!cols'] = wscols;

            XLSX.writeFile(wb, 'sales_report.xlsx');
        }

    </script>

</body>

</html>