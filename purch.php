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
session_start();

if (!empty($_SESSION['userid'])) {
  $user_id = $_SESSION['userid'];
}
if (isset($_POST['purch'])) {
    $item = mysqli_real_escape_string($conn, $_POST['item_id']);
    $qty = mysqli_real_escape_string($conn, $_POST['qty']);
    $todayDate = date("Y-m-d");

    $selectt = mysqli_query($conn, "SELECT * FROM tbl_item WHERE Item_id = '$item'");
    $row = mysqli_fetch_assoc($selectt);
    $price = $row['price'];
    $vendor = $row['Vendor_id'];

    // Check if the item with the same Item_id already exists in purchasechild
    $existingItem = mysqli_query($conn, "SELECT * FROM tbl_purchasechild WHERE Masterpurch_id IN (SELECT Masterpurch_id FROM tbl_purchasemaster WHERE Vendor_id = '$vendor' AND Staff_id = '$user_id' AND Purchase_Date = '$todayDate') AND Item_id = '$item'");
    $existingRow = mysqli_fetch_assoc($existingItem);

    if ($existingRow) {
        // If the item already exists, update the stock and quantity
        $existingStock = $existingRow['stock'];
        $newStock = $existingStock + $qty;
        $existingQty = $existingRow['qty'];
        $newQty = $existingQty + $qty;

        $update = mysqli_query($conn, "UPDATE tbl_purchasechild SET stock = '$newStock', qty = '$newQty' WHERE Masterpurch_id IN (SELECT Masterpurch_id FROM tbl_purchasemaster WHERE Vendor_id = '$vendor' AND Staff_id = '$user_id' AND Purchase_Date = '$todayDate') AND Item_id = '$item'");
    
        if ($update) {
            $update = mysqli_query($conn, "UPDATE tbl_item SET qty = qty - '$qty' WHERE Item_id = '$item'");
        }
    } else {
        // If the item doesn't exist, insert a new entry in purchasechild
        $master = mysqli_query($conn, "INSERT INTO tbl_purchasemaster (Vendor_id, Staff_id, Purchase_Date) VALUES ('$vendor', '$user_id', '$todayDate')");
        $master_id = mysqli_insert_id($conn);

        $child = mysqli_query($conn, "INSERT INTO tbl_purchasechild (Masterpurch_id, Item_id, Price, qty, stock) VALUES ('$master_id', '$item', '$price', '$qty', '$qty')");

        if ($master && $child) {
            $update = mysqli_query($conn, "UPDATE tbl_item SET qty = qty - '$qty' WHERE Item_id = '$item'");
        }
    }
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
            top: 85px;
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
        .qty{
            width:90px;
            height: 25px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h3>Product Purchase</h3>
        </div>
        <div class="table">
            <table>
                <colgroup>
                    <col width="6%">
                    <col width="25%">
                    <col width="30%">
                    <col width="25%">
                    <col width="10%">
                    <col width="10%">
                </colgroup>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Vendor Name</th>
                        <th>Item Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    $qry = mysqli_query($conn, "SELECT * FROM tbl_item WHERE qty != 0");
                    while ($row = mysqli_fetch_assoc($qry)):

                        $id = $row['Item_id'];
                        $venid = $row['Vendor_id'];
                        $stock = $row['qty'];
                        $price = $row['price'];
                        $for_price = number_format($price);

                        $selectt = mysqli_query($conn, "SELECT * FROM tbl_vendor WHERE Vendor_id  = '$venid'");
                        $vendor = mysqli_fetch_assoc($selectt);

                        foreach ($row as $k => $v) {
                            $row[$k] = trim(stripslashes($v));
                        }
                        ?>
                        <tr>
                            <td class="text-center">
                                <?php echo $i++; ?>
                            </td>
                            <?php
                            echo '<td>' . $vendor['Vendor_Fname'] . ' ' . $vendor['Vendor_Mname'] . '</td>';
                            ?>
                            <td>
                                <?php echo $row['Item_name'] ?>
                            </td>
                            <td>₹
                                <?php echo $for_price ?>
                            </td>
                            <form method="POST" action="">
                                <input type="hidden" name="item_id" value="<?php echo $id; ?>">
                                <td>
                                    <input type="number" class ="qty" name="qty" min='1' max="<?php echo $stock ?>" required="">
                                </td>
                                <td align="center">
                                    <button type="submit" class="dpbtn" name="purch">Purchase</button>
                                </td>
                            </form>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>