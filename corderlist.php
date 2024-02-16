<?php include('admin.php') ?>
<?php
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
            display: inline-block;
            padding: 8px 20px;
            background-color: #000;
            color: #fff;
            font-size: 16px;
            position: absolute;
            top: 9px;
            right: 2vh;
            font-weight: bold;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .exp-dropdown {
            position: absolute;
            right: 30px;
            top: 8px;
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
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.0/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

</head>


<body>
    <div class="container">
        <div class="header">
            <h3>Order List</h3>

        </div>
        <div class="table">
            <table>
                <colgroup>
                    <col width="5%">
                    <col width="15%">
                    <col width="15%">
                    <col width="15%">
                    <col width="15%">
                    <col width="15%">
                    <col width="5%">
                </colgroup>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Ordered Date</th>
                        <th>Customer Name</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                        <th>Courier Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;

                    if ($_SESSION['usertp'] === 'Admin' || $_SESSION['usertp'] === 'Staff') {
                        $qry = mysqli_query($conn, "SELECT * FROM tbl_cart_master WHERE Cart_status IN ('A','P','D','R','E')");
                    } else {
                        $assignedDeliveredQuery = "SELECT cm.* FROM tbl_cart_master cm
        JOIN tbl_courierassignment ca ON cm.Mastercart_id = ca.Mastercart_id
        WHERE ca.Courier_id = '$user_id' AND cm.Cart_status IN ('A', 'D')";


                        $qry = mysqli_query($conn, "$assignedDeliveredQuery");
                    }

                    while ($row = mysqli_fetch_assoc($qry)):
                        $mid = $row['Mastercart_id'];

                        $item = mysqli_query($conn, "SELECT * FROM tbl_cart_child WHERE Mastercart_id = '$mid'");
                        $irow = mysqli_fetch_assoc($item);
                        $id = $irow['Item_id'];

                        $itemls = mysqli_query($conn, "SELECT * FROM tbl_Item WHERE Item_id = '$id'");
                        $idrow = mysqli_fetch_assoc($itemls);

                        $select = mysqli_query($conn, "SELECT * FROM tbl_cart_master WHERE Cart_status IN ('A','P','D') AND Mastercart_id = '$mid'");
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
                    
                        $courier = mysqli_query($conn, "SELECT Cs_name,Cs_Status FROM tbl_courier WHERE Courier_id IN (SELECT Courier_id FROM tbl_courierassignment WHERE Mastercart_id = '$mid' AND Ca_status='1')");
                        $crrow = mysqli_fetch_assoc($courier);

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
                                <?php echo $cust['Cust_Fname'] . ' ' . $cust['Cust_Mname'] ?>
                            </td>
                            <td>₹
                                <?php
                                $pri = $prow['Payment_amount'];
                                $for_price = number_format($pri);
                                echo $for_price; ?>
                            </td>
                            <td>
                                <?php
                                if ($crow['Cart_status'] === 'P') {
                                    echo 'Paid';
                                } elseif ($crow['Cart_status'] === 'A') {
                                    echo 'Assigned';
                                } elseif ($crow['Cart_status'] === 'D') {
                                    echo 'Delivered';
                                } elseif ($crow['Cart_status'] === 'R') {
                                    echo 'Returned';
                                } else {
                                    echo 'Expired';
                                }
                                ?>
                            </td>
                            </td>

                            <?php if ($crrow): ?>
                                <td>
                                    <?php echo $crrow['Cs_name'] ?>
                                </td>
                            <?php else: ?>
                                <td>Unassigned</td>
                            <?php endif; ?>
                            <td align="center">
                                <div class="dp">
                                    <button class="dpbtn">Action</button>
                                    <div class="dp-content">
                                        <?php
                                        $cart = mysqli_query($conn, "SELECT Cart_status FROM tbl_Cart_master WHERE Mastercart_id = '$mid'");
                                        $cartStatus = mysqli_fetch_assoc($cart)['Cart_status'];
                                        if ($cartStatus == 'A'|| $cartStatus == 'R'|| $cartStatus == 'E') {
                                            if ($crrow['Cs_Status'] == '0' && $cartStatus == 'E' || $cartStatus == 'R') { ?>
                                                <a href="#" class="assign-link" data-item-id="<?php echo $mid; ?>">Re assign</a>
                                            <?php }
                                        } ?>
                                        <a href="#" class="edit-link" data-item-id="<?php echo $mid; ?>">View order</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>

            </table>
        </div>
        <div class="exp-dropdown">
            <button class="exp-dropbtn">Export</button>
            <div class="exp-dropdown-content">
                <a href="#" onclick="printAndClose()">Print</a>
                <a href="#" id="exportToExcel" onclick="exportToExcel()">Export to Excel</a>
                <a href="#" onclick="exportToPDF()">Export to PDF</a>
            </div>
        </div>
    </div>
    <script>
        function printAndClose() {
            var printWindow = window.open("print_or.php", "_blank");
            printWindow.onload = function () {
                printWindow.print();
                printWindow.onafterprint = function () {
                    printWindow.close();
                };
            };
        }


        function exportToExcel() {
            fetch('viewor.php') // Fetch data from viewcust.php
                .then(response => response.text())
                .then(data => {
                    var wb = XLSX.utils.book_new();
                    var ws = XLSX.utils.table_to_sheet(new DOMParser().parseFromString(data, 'text/html').getElementById('salesTable'));
                    XLSX.utils.book_append_sheet(wb, ws, "Order Report");
                    var wscols = [
                        { wch: 10 }, /* Column A width */
                        { wch: 20 }, /* Column B width */
                        { wch: 25 }, /* Column C width */
                        { wch: 20 }, /* Column C width */
                        { wch: 20 }, /* Column C width */
                        { wch: 40 }, /* Column C width */
                        { wch: 20 }, /* Column C width */

                    ];
                    ws['!cols'] = wscols;
                    XLSX.writeFile(wb, 'Order_report.xlsx');
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }


        function exportToPDF() {
            var sunSoulHeading = `<style>

            body {
        font-family: 'times new roman', serif;
        font-size:14px;
    }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
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
        <div class="receipt">
            <div class="logo">
                <img src='logo.jpeg' width='400' height='100'>
                <p>Your Trusted Source for Used Electronics</p>
            </div>
            <h3 class="list">Order List</h3>
        </div>

        <?php
        $currentDate = date("Y-m-d");
        $i = 1;
        $j = 1;
        $perPage = 20; // Number of entries per page
        $page = 1; // Initialize page number
        $qry = mysqli_query($conn, "SELECT * FROM tbl_cart_master WHERE Cart_status IN ('A','P','D')");

        $totalRows = mysqli_num_rows($qry);
        ?>
                        <p class="date">Date:
                        <?php echo $currentDate; ?>
                    </p>
        <?php while ($row = mysqli_fetch_assoc($qry)): 
             $mid = $row['Mastercart_id'];

             $item = mysqli_query($conn, "SELECT * FROM tbl_cart_child WHERE Mastercart_id = '$mid'");
             $irow = mysqli_fetch_assoc($item);
             $id = $irow['Item_id'];
         
                 $itemls=mysqli_query($conn,"SELECT * FROM tbl_Item WHERE Item_id = '$id'");
                 $idrow=mysqli_fetch_assoc($itemls);
         
                 $select = mysqli_query($conn, "SELECT * FROM tbl_cart_master WHERE Cart_status IN ('A','P','D') AND Mastercart_id IN (SELECT Mastercart_id FROM tbl_cart_child WHERE Item_id = '$id')");
                 $crow=mysqli_fetch_assoc($select);
                 $custid = $crow['Customer_id'];
         
                 $pay = mysqli_query($conn, "SELECT * FROM tbl_payment WHERE Mastercart_id = $mid");
                 $date = mysqli_fetch_assoc($pay);
         
                 
                 $price=mysqli_query($conn,"SELECT * FROM tbl_purchasechild WHERE Item_id = '$id'");
                 $prrow=mysqli_fetch_assoc($price);
         
                 $selectt = mysqli_query($conn, "SELECT * FROM tbl_customer WHERE Customer_id = '$custid'");
                 $cust = mysqli_fetch_assoc($selectt);
         
                 $payment=mysqli_query($conn,"SELECT * FROM tbl_payment WHERE Mastercart_id = '$mid'");
                 $prow=mysqli_fetch_assoc($payment);
                 // Trim and sanitize item values
         
                 $courier = mysqli_query($conn, "SELECT Cs_name FROM tbl_courier WHERE Courier_id IN (SELECT Courier_id FROM tbl_courierassignment WHERE Mastercart_id = '$mid')");
                 $crrow = mysqli_fetch_assoc($courier);
                 
                 foreach ($row as $k => $v) {
                     $row[$k] = trim(stripslashes($v));
                 }?>
                        <?php if ($i % $perPage === 1): ?>
                                        <?php if ($page > 1): ?>
                                                        </tbody>
                                                        </table>
                                        <?php endif; ?>
                                        <div class="table">
                                <p class="page">Page <?php echo $page; ?></p>

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
        <td class="text-center"><?php echo $j++; ?></td>
        <td><?php echo $date['Payment_date'] ?></td>
        <td><?php echo $cust['Cust_Fname'] . ' ' . $cust['Cust_Mname'] ?></td>
        <td> ₹                           <?php
                            $pri = $prow['Payment_amount'];
                            $for_price = number_format($pri);
                            echo $for_price; ?> 
                        </td>
        <?php if ($crrow) : ?>
    <td><?php echo $crrow['Cs_name'] ?></td>
<?php else : ?>
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
        <?php endwhile; ?>`;

            var content = sunSoulHeading;

            var opt = {
                margin: 10,
                filename: 'Order_report.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' },
                html2pdf: {
                    content: content,
                    image: { type: 'jpeg', quality: 0.98 },
                }
            };
            html2pdf().from(content).set(opt).save();
        };



        var editLinks = document.querySelectorAll('.edit-link');

        editLinks.forEach(function (editLink) {
            editLink.addEventListener('click', function (event) {
                event.preventDefault();

                var itemId = editLink.getAttribute('data-item-id');
                console.log(itemId); // Check if itemId has the correct value
                var url = 'vieworder.php?id=' + itemId;
                window.location.href = url;

            });
        });
        var assignLinks = document.querySelectorAll('.assign-link');

        assignLinks.forEach(function (assignLink) {
            assignLink.addEventListener('click', function (event) {
                event.preventDefault();

                var itemId = assignLink.getAttribute('data-item-id');
                console.log(itemId); // Check if itemId has the correct value
                var url = 'reassign.php?id=' + itemId;
                window.location.href = url;
            });
        });
    </script>

</body>

</html>