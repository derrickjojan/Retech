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

if (isset($_GET['id'])) {
    $gid = $_GET['id'];
}

if (isset($_POST['assign_courier'])) {
    // Get the selected courier and order IDs
    $selectedCourier = mysqli_real_escape_string($conn, $_POST['selectedCourier']);

    $existingCourierAssignment = mysqli_query($conn, "SELECT * FROM tbl_courierassignment WHERE Courier_id = '$selectedCourier' AND Mastercart_id = '$gid'");
    $existingAssignment = mysqli_fetch_assoc($existingCourierAssignment);
    if ($existingAssignment) {
        $courierAssignId = $existingAssignment['Courierassign_id'];
    } else {
        // Create a new entry in courierassignment table
        $assignmentDate = date("Y-m-d H:i:s");

        $courierInsert = mysqli_query($conn, "INSERT INTO tbl_courierassignment (Courierassign_id,Courier_id, Mastercart_id, Courierassign_date, Call_status,Ca_status) VALUES (generate_courierassignment_id(),'$selectedCourier', '$gid', '$assignmentDate','0','1')");
        if (!$courierInsert) {
            echo "Error inserting into tbl_courierassignment: " . mysqli_error($conn);
        }
        $courierAssignId = mysqli_insert_id($conn); // Get the ID of the newly inserted entry
    }

    // Update tbl_the cartmaster table with the new status
    $updateResult = mysqli_query($conn, "UPDATE tbl_cart_master SET Cart_status = 'A' WHERE Mastercart_id = '$gid'");

    if ($updateResult) {
        echo "Status updated successfully.";
        // Refresh the page to reflect the updated status
        echo '<script>window.location.href = "assignlist.php";</script>';
    } else {
        echo "Error updating status: " . mysqli_error($conn);
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

        .price p {
            margin-right: 50px;
            text-align: right;

        }

        .btn {
            position: relative;
            left: 135vh;
            font-family: 'Blender';
            padding: 10px 10px;
            background-color: #fff;
            border: #000 solid;
            color: #000;
            font-size: 20px;
            text-decoration: none;
            border-radius: 4px;

        }

        .bttn {
            position: relative;
            left: 36vh;
            bottom: 10vh;
            font-family: 'Blender';
            padding: 10px 10px;
            background-color: #fff;
            border: #000 solid;
            color: #000;
            font-size: 20px;
            text-decoration: none;
            border-radius: 4px;
        }

        sp {
            color: #5A5A5A;
        }

        #statusDropdown {
            position: absolute;
            right: 25vh;
            top: 33.5vh;
            min-width: 160px;
            z-index: 1;
        }

        .form-container {
            position: relative;
            left: 200px;
        }

        .boxxx {

            font-family: OstrichSansreg;
            position: relative;
            top: 15vh;
            right: 40vh;
            border-top: #000 solid;
            border-left: #000 solid;
            border-right: #000 solid;
            background-color: #fff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            border-radius: 4px;
            width: 500px;
        }

        .courier-option {
            padding-bottom: 5px;
            padding-left: 40px;
            display: block;
            font-family: OstrichSansreg;
            font-size: 25px;
            border-bottom: #000 solid;
        }

        .courier-option input[type="radio"] {
            position: relative;
            right: 15px;
            transform: scale(1.5);
        }

        .courier-address {
            font-family: OstrichSansreg;
            display: block;
            padding-left: 20px;
        }

        .courier-contact {
            font-family: OstrichSansreg;
            display: block;
            padding-left: 20px;
        }
    </style>
</head>

<body>
    <div class="container" id="container">
        <div class="header">
            <h3>Order Item List</h3>
        </div>
        <div class="table">
            <table>
                <colgroup>
                    <col width="6%">
                    <col width="20%">
                    <col width="10%">
                    <col width="20%">
                </colgroup>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Item Name</th>
                        <th>Quantity</th>
                        <th>Item Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    $custDetailsDisplayed = false; // Flag to track if customer details have been displayed
                    
                    $qry = mysqli_query($conn, "SELECT * FROM tbl_cart_child WHERE Mastercart_id = '$gid'");
                    while ($row = mysqli_fetch_assoc($qry)):
                        $id = $row['Item_id'];
                        $qty = $row['qty'];

                        $select = mysqli_query($conn, "SELECT * FROM tbl_cart_master WHERE Cart_status IN ('A','P','D') AND Mastercart_id = '$gid'");
                        $crow = mysqli_fetch_assoc($select);
                        $custid = $crow['Customer_id'];

                        $selectt = mysqli_query($conn, "SELECT * FROM tbl_customer WHERE Customer_id = '$custid'");
                        $cust = mysqli_fetch_assoc($selectt);

                        $item = mysqli_query($conn, "SELECT * FROM tbl_item WHERE Item_id = '$id'");
                        $irow = mysqli_fetch_assoc($item);

                        $price = mysqli_query($conn, "SELECT * FROM tbl_purchasechild WHERE Item_id = '$id'");
                        $prrow = mysqli_fetch_assoc($price);

                        $payment = mysqli_query($conn, "SELECT * FROM tbl_payment WHERE Mastercart_id = '$gid'");
                        $prow = mysqli_fetch_assoc($payment);

                        if (!$custDetailsDisplayed) {
                            // Display customer details only if not already displayed
                            echo '<div class="dtls">';
                            echo '<p>Customer Name: ' . $cust['Cust_Fname'] . ' ' . $cust['Cust_Mname'] . '</p>';
                            echo '<p>Delivery Address: ' . $cust['Cust_dist'] . ', ' . $cust['Cust_city'] . ', ' . $cust['Cust_pin'] . '</p>';
                            echo '</div>';
                            $custDetailsDisplayed = true; // Set the flag to true after displaying customer details
                        }
                        // Trim and sanitize item values
                        foreach ($row as $k => $v) {
                            $row[$k] = trim(stripslashes($v));
                        }
                        ?>
                        <tr>
                            <td class="text-center">
                                <?php echo $i++; ?>
                            </td>
                            <td>
                                <?php echo $irow['Item_name'] ?>
                            </td>
                            <td>
                                    <?php echo $qty ?>
                                </td>
                            <td>₹
                                <?php
                                $pri = $prrow['Price'];
                                $for_price = number_format($pri);
                                echo $for_price; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    <tr>
                        <td></td> <!-- Empty cell for spacing -->
                        <td></td> <!-- Empty cell for spacing -->
                        <td></td> <!-- Empty cell for spacing -->
                        <td><span style="font-weight: bold;">Total Amount: ₹</span>
                            <?php 
                            $pri = $prow['Payment_amount'];
                            $for_price = number_format($pri);
                            echo $for_price; ?>
                        </td> <!-- Total Amount -->

                    </tr>
                </tbody>


            </table>
        </div>
        <div class="price">
            <?php
            $status = mysqli_query($conn, "SELECT * FROM tbl_cart_master WHERE Mastercart_id = '$gid'");
            $row = mysqli_fetch_assoc($status);
            ?>
            <p> ORDER STATUS:
                <?php
                if ($row['Cart_status'] === 'P') {
                    echo 'Paid';
                } elseif ($row['Cart_status'] === 'A') {
                    echo 'Assigned';
                } elseif ($row['Cart_status'] === 'D') {
                    echo 'Delivered';
                } else {
                    echo 'Unknown';
                }
                ?>
            </p>
            <!-- Button to show/hide the dropdown -->
            <button id="statusButton" class="btn">Assign Courier</button>
            <!-- Dropdown menu (hidden by default) -->
            <div id="statusDropdown" style="display: none;">
                <div class="form-container">
                    <form method="post" action="">
                        <div class="boxxx" name="new_status">
                            <?php
                            $qry = mysqli_query($conn, "SELECT * FROM tbl_Courier WHERE Cs_Status='1'");
                            $courierOptions = '';
                            $courierOptions .= '<label class="courier-option">' . '<sp>List of couriers</sp>' . '</label>';
                            if (mysqli_num_rows($qry) > 0) {
                                while ($row = mysqli_fetch_assoc($qry)):
                                    $courierId = $row['Courier_id'];
                                    $courierOptions .= '<label class="courier-option">';
                                    $courierOptions .= '<input type="radio" name="selectedCourier" value="' . $courierId . '">' . '<sp>Courier Name: </sp>' . $row['Cs_name'] . " ";
                                    $courierOptions .= '<gh class="courier-address">' . '<sp>Address: </sp>' . $row['Cs_dist'] . ", " . $row['Cs_city'] . " " . $row['Cs_pin'] . '</gh>';
                                    $courierOptions .= '<gh class="courier-contact">' . '<sp>Phno: </sp>' . $row['Cs_Phno'] . '</gh>';
                                    $courierOptions .= '</label>';
                                endwhile;
                            } else {
                                $courierOptions .= '<p class="msg">No Couriers Available!</p>';
                            }

                            echo $courierOptions; // Output the courier options
                            ?>
                        </div>
                        <button type="submit" class="bttn" name="assign_courier">Select Courier</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>

        // JavaScript to toggle the visibility of the dropdown menu
        document.getElementById("statusButton").addEventListener("click", function () {
            var dropdown = document.getElementById("statusDropdown");
            if (dropdown.style.display === "none") {
                dropdown.style.display = "block";
            } else {
                dropdown.style.display = "none";
            }
        });

        document.addEventListener("DOMContentLoaded", function () {
            const statusButton = document.getElementById("statusButton");
            const statusDropdown = document.getElementById("statusDropdown");
            const container = document.getElementById("container");
            let isDropdownVisible = false; // Flag to track dropdown visibility

            statusButton.addEventListener("click", function () {
                if (!isDropdownVisible) {
                    statusDropdown.style.display = "block";

                    // Adjust the container's height to accommodate the expanded dropdown
                    container.style.height = container.scrollHeight + "px";

                    isDropdownVisible = true; // Set the flag to true
                } else {
                    statusDropdown.style.display = "none";

                    // Reset the container's height
                    container.style.height = "auto";

                    isDropdownVisible = false; // Set the flag to false
                }
            });
        });

    </script>
</body>

</html>