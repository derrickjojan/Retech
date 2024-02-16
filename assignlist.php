<?php include('admin.php') ?>
<?php
$dbhost='localhost';
$dbuser='root';
$dbpass='';
$db='retech1';
$conn = mysqli_connect($dbhost,$dbuser,$dbpass,$db);
if ($conn->connect_error) 
{
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
        }
        
        *::-webkit-scrollbar{
   height: .5rem;
   width: 10px;
}

*::-webkit-scrollbar-track{
   background-color: rgba(17, 11, 28, 0.9);
}

*::-webkit-scrollbar-thumb{
   background-color: black;
}

        .container {
            font-family: 'Blender';
            font-size: 17px;
            box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
			position:relative;
			left:17%;
			top:130px;
            width: 1199px;
            padding: 20px;
            border-top: 3px solid #000;
            background-color: #fff;
            border-radius: 2px;
            transition: left 0.9s ease;
        }
        #check:checked ~ .container {
            position:relative;
            left:100px;

        width: calc(91% - 120px);
      }


        
        .header {
            position:relative;
            right:20px;
            bottom:22px;
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
        
        th, td {
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
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h3>Assign Order</h3>

        </div>
             <div class="table">
                <table>
                     <colgroup>
                        <col width="6%">
                        <col width="20%">
                        <col width="20%">
                        <col width="20%">
                        <col width="20%">
                        <col width="10%">
                     </colgroup>
                 <thead>
                     <tr>
                         <th>No.</th>
                         <th>Ordered Date</th>
                         <th>Customer Name</th>
                         <th>Total Amount</th>
					     <th>Status</th>
                         <th>Action</th>
                      </tr>
                 </thead>
                 <tbody>
                 <?php
$i = 1;

if ($_SESSION['usertp'] === 'Admin' || $_SESSION['usertp'] === 'Staff') {
    $qry = mysqli_query($conn, "SELECT * FROM tbl_cart_master WHERE Cart_status ='P'");
} else {
    $assignedDeliveredQuery = "SELECT cm.* FROM tbl_cart_master cm
        JOIN tbl_courierassignment ca ON cm.Mastercart_id = ca.Mastercart_id
        WHERE ca.Courier_id = '$user_id' AND cm.Cart_status IN ('A', 'D')";

    $pendingQuery = "SELECT * FROM tbl_cart_master WHERE Cart_status = 'P'";

    $qry = mysqli_query($conn, "$assignedDeliveredQuery UNION $pendingQuery");
}

while ($row = mysqli_fetch_assoc($qry)):
    $mid = $row['Mastercart_id'];

    $item = mysqli_query($conn, "SELECT * FROM tbl_cart_child WHERE Mastercart_id = '$mid'");
    $irow = mysqli_fetch_assoc($item);
    $id = $irow['Item_id'];

        $itemls=mysqli_query($conn,"SELECT * FROM tbl_Item WHERE Item_id = '$id'");
        $idrow=mysqli_fetch_assoc($itemls);

        $select = mysqli_query($conn, "SELECT * FROM tbl_cart_master WHERE Cart_status IN ('A', 'P', 'D') AND Mastercart_id = '$mid'");
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
        foreach ($row as $k => $v) {
            $row[$k] = trim(stripslashes($v));
        }
    ?>
    <tr>
        <td class="text-center"><?php echo $i++; ?></td>
        <td><?php echo $date['Payment_date'] ?></td>
        <td><?php echo $cust['Cust_Fname'] . ' ' . $cust['Cust_Mname'] ?></td>
        <td>₹<?php $pri = $prow['Payment_amount']; 
                            $for_price = number_format($pri);
                            echo $for_price; ?></td>
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

        <td align="center">
            <div class="dp">
                <button class="dpbtn">Action</button>
                <div class="dp-content">
                    <a href="#" class="edit-link" data-item-id="<?php echo $mid; ?>">View order</a>
                </div>
            </div>
        </td>
    </tr>
    <?php endwhile; ?>
</tbody>

                 </table>
                </div>
    </div>

<script>
var editLinks = document.querySelectorAll('.edit-link');

editLinks.forEach(function(editLink) {
    editLink.addEventListener('click', function(event) {
        event.preventDefault();

        var itemId = editLink.getAttribute('data-item-id');
        console.log(itemId); // Check if itemId has the correct value
        var url = 'assignorder.php?id=' + itemId;
        window.location.href = url;

    });
});

</script>

</body>
</html>
