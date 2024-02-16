<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$db = 'retech1';
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $db);
if ($conn->connect_error) {
    die("Connection failed:" . $conn->connect_error);
}
$currentDate = date('Y-m-d H:i:s');
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
            <h3 class="list">Item List</h3>
        </div>
        <p class="date">Date:
            <?php echo $currentDate; ?>
        </p>
        <?php
        $i = 1;
        $j = 1;
        $perPage = 20; // Number of entries per page
        $page = 1; // Initialize page number
        $qry = mysqli_query($conn, "SELECT * FROM tbl_item WHERE item_id IN (SELECT item_id FROM tbl_purchasechild WHERE stock != 0)");
        $totalRows = mysqli_num_rows($qry);
        ?>
        <?php while ($row = mysqli_fetch_assoc($qry)): 
             $id = $row['Item_id'];

             $sid = $row['Subcategory_id'];
             $select = mysqli_query($conn, "SELECT Category_id FROM `tbl_Subcategory` WHERE Subcategory_id = '$sid'");
             $ss = mysqli_fetch_assoc($select);
             $cid = $ss['Category_id'];
 
             $select = mysqli_query($conn, "SELECT Subcategory_name FROM `tbl_Subcategory` WHERE Subcategory_id = '$sid'");
             $sd = mysqli_fetch_assoc($select);
             $scname = $sd['Subcategory_name'];
 
             $bran = $row['Brand_id'];
             $select = mysqli_query($conn, "SELECT Brand_name FROM `tbl_Brand` WHERE Brand_id = '$bran'");
             $br = mysqli_fetch_assoc($select);
             $bname = $br['Brand_name'];
 
 
             $selectt = mysqli_query($conn, "SELECT Category_name FROM `tbl_Category` WHERE Category_id = '$cid'");
             $cc = mysqli_fetch_assoc($selectt);
             $Catname = $cc['Category_name'];
 
             foreach ($row as $k => $v) {
                 $row[$k] = trim(stripslashes($v));
             }
             ?>
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
                        <col width="20%">
                        <col width="15%">
                        <col width="20%">
                        <col width="18%">
                        <col width="15%">
                    </colgroup>
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>Item Name</th>
                            <th>Brand Name</th>
                            <th>Category</th>
                            <th>SubCategory</th>
                            <th>Mfg Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php endif; ?>

                        <tr>
                            <td class="text-center">
                                <?php echo $j++; ?>
                            </td>
                            <td>
                                <?php echo $row['Item_name'] ?>
                            </td>
                            <td>
                                <?php echo $bname ?>
                            </td>
                            <td>
                                <?php echo $Catname ?>
                            </td>
                            <td>
                                <?php echo $scname ?>
                            </td>
                            <td>
                                <?php echo $row['Mfg_date'] ?>
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