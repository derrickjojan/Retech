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


if ($_SESSION['usertp'] === 'Admin' || $_SESSION['usertp'] === 'Staff') {
$cust = mysqli_query($conn, "SELECT COUNT(*) FROM tbl_Customer");
$rowcust = mysqli_fetch_array($cust);
$totalCustomers = $rowcust[0];

$staf = mysqli_query($conn, "SELECT COUNT(*) FROM tbl_Staff WHERE S_Job_title='Staff'");
$rowstaf = mysqli_fetch_array($staf);
$totalStaff = $rowstaf[0];

$ven = mysqli_query($conn, "SELECT COUNT(*) FROM tbl_Vendor");
$rowven = mysqli_fetch_array($ven);
$totalVendors = $rowven[0];

$items = mysqli_query($conn, "SELECT COUNT(*) FROM tbl_Item");
$rowitems = mysqli_fetch_array($items);
$totalItems = $rowitems[0];

$cour = mysqli_query($conn, "SELECT COUNT(*) FROM tbl_Courier");
$rowcour = mysqli_fetch_array($cour);
$totalCouriers = $rowcour[0];

$cat = mysqli_query($conn, "SELECT COUNT(*) FROM tbl_Category");
$rowcat = mysqli_fetch_array($cat);
$totalCategories = $rowcat[0];

$subcat = mysqli_query($conn, "SELECT COUNT(*) FROM tbl_Subcategory");
$rowsub = mysqli_fetch_array($subcat);
$totalSubcategories = $rowsub[0];

$Brands = mysqli_query($conn, "SELECT COUNT(*) FROM tbl_Brand");
$rowBrand = mysqli_fetch_array($Brands);
$totalBrands = $rowBrand[0];

$purch = mysqli_query($conn, "SELECT COUNT(*) FROM tbl_purchasemaster");
$rowpurch = mysqli_fetch_array($purch);
$totalPurchases = $rowpurch[0];

$pay = mysqli_query($conn, "SELECT COUNT(*) FROM tbl_payment");
$rowpurch = mysqli_fetch_array($pay);
$totalSales = $rowpurch[0];

$ass = mysqli_query($conn, "SELECT COUNT(*) FROM tbl_courierassignment");
$rowass = mysqli_fetch_array($ass);
$totalAssignments= $rowass[0];

$msg = mysqli_query($conn, "SELECT COUNT(*) FROM tbl_message");
$rowmsg = mysqli_fetch_array($msg);
$totalmsg= $rowmsg[0];
}
else {
    $assignedDeliveredQuery = "SELECT cm.* FROM tbl_cart_master cm
    JOIN tbl_courierassignment ca ON cm.Mastercart_id = ca.Mastercart_id
    WHERE ca.Courier_id = '$user_id' AND cm.Cart_status IN ('A', 'D') AND ca.Ca_status= '1'";


$combinedQuery = "$assignedDeliveredQuery";

$countQuery = mysqli_query($conn,"SELECT COUNT(*) AS total_count FROM ($combinedQuery) AS combined");
$rowpurch = mysqli_fetch_array($countQuery);
$totalSales = $rowpurch[0];
}

?>

<html>
<head>
    <title>Dashboard</title>
    <style>
                         @font-face {
        font-family: 'Blender';
        src: url(fonts/Blender-Pro-Bold.otf);
      }
.container {
    font-family: 'Blender';
            font-size: 17px;
			position:relative;
			left:17%;
			top:85px;
            width: 1199px;
            padding: 20px;

            background-color: #fff;
            border-radius: 2px;
            transition: left 0.9s ease;
        }
        #check:checked ~ .container {
            position:relative;
            left:100px;
        width: calc(92% - 120px);
      }
.dashboard-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
}

.dashboard-card {
    background-color: white;
    padding: 20px;
    border: 1px solid #000;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.dashboard-card h2 {
    margin: 0;
    font-size: 1.5rem;
    color: #333;
}

.dashboard-card p {
    margin: 10px 0;
    font-size: 20px;
    color: #000;
}

    </style>
</head>
<body>
<div class="container">
    <div class="dashboard-container">
        <div class="dashboard-card">
        <?php if ($_SESSION['usertp'] === 'Courier'){ ?>
            <div class="dashboard-card">
            <h2>Total Orders</h2>
            <p><?php echo $totalSales; ?></p>
        </div>
        <?php } else { ?> 

            <h2>Total Customers</h2>
            <p><?php echo $totalCustomers; ?></p>
        </div>
        <div class="dashboard-card">
            <h2>Total Staff</h2>
            <p><?php echo $totalStaff; ?></p>
        </div>
        <div class="dashboard-card">
            <h2>Total Vendors</h2>
            <p><?php echo $totalVendors; ?></p>
        </div>
        <div class="dashboard-card">
            <h2>Total Items</h2>
            <p><?php echo $totalItems; ?></p>
        </div>
        <div class="dashboard-card">
            <h2>Total Couriers</h2>
            <p><?php echo $totalCouriers; ?></p>
        </div>
        <div class="dashboard-card">
            <h2>Total Categories</h2>
            <p><?php echo $totalCategories; ?></p>
        </div>
        <div class="dashboard-card">
            <h2>Total Subcategories</h2>
            <p><?php echo $totalSubcategories; ?></p>
        </div>
        <div class="dashboard-card">
            <h2>Total Brands</h2>
            <p><?php echo $totalBrands; ?></p>
        </div>
        <div class="dashboard-card">
            <h2>Total Purchases</h2>
            <p><?php echo $totalPurchases; ?></p>
        </div>
        <div class="dashboard-card">
            <h2>Total Orders</h2>
            <p><?php echo $totalSales; ?></p>
        </div>
        <div class="dashboard-card">
            <h2>Total Assignments</h2>
            <p><?php echo $totalAssignments; ?></p>
        </div>
        <div class="dashboard-card">
            <h2>Total Messages</h2>
            <p><?php echo $totalmsg; ?></p>
        </div>
<?php } ?>
    </div>
</div>
</body>
</html>
