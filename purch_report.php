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
            right: 15vh;
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
            width: 200px;
        }

        /* Label Styles */
        label {
            font-size: 16px;
            margin-right: 5px;
        }

        /* Button Styles */
        button[type="submit"] {
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
            right: 20px;
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
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>

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
            </div>
            <div class="exp-dropdown">
                <button class="exp-dropbtn">Export</button>
                <div class="exp-dropdown-content">
                <a href="#" onclick="printAndClose()">Print</a>
                    <a href="#" id="exportToExcel" onclick="exportToExcel()">Export to Excel</a>
                    <a href="generate_purch_pdf.php">Export to PDF</a>
                </div>
            </div>
        </form>
    </div>
    <script>

function printAndClose() {
            var printWindow = window.open("viewpurch.php", "_blank");
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

            XLSX.writeFile(wb, 'Purchase_report.xlsx');
        }

    </script>

</body>

</html>