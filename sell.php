<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$db = 'retech1';

$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();

if (!empty($_SESSION['userid'])) {
    $user_id = $_SESSION['userid'];
} else {
    header('location:login.php');
}
;


if (isset($_SESSION['usertp']) && $_SESSION['usertp'] === 'User') {

    $result_displayValues = mysqli_query($conn, "SELECT * FROM tbl_Customer where Customer_id = '$user_id'");
    $row_displayValues = mysqli_fetch_assoc($result_displayValues);


    $email = $row_displayValues['Cust_Username'];
    $fname = $row_displayValues['Cust_Fname'];
    $mname = $row_displayValues['Cust_Mname'];
    $lname = $row_displayValues['Cust_Lname'];
    $dist = $row_displayValues['Cust_dist'];
    $city = $row_displayValues['Cust_city'];
    $pin = $row_displayValues['Cust_pin'];
    $gender = $row_displayValues['Cust_Gender'];
    $phno = $row_displayValues['Cust_Phno'];
    $dob = $row_displayValues['Cust_DOB'];
}

if (isset($_POST['submit'])) {
    $item = mysqli_real_escape_string($conn, $_POST['item']);
    if (empty($_POST['subcategory'])) {
        echo '<p class="msg">Please Select a subcategory</p>';
    } else {
        $subcat = mysqli_real_escape_string($conn, $_POST['subcategory']);
    }
    $brand = mysqli_real_escape_string($conn, $_POST['brand']);
    $desc = mysqli_real_escape_string($conn, $_POST['desc']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $todayDate = date("Y-m-d");
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);

    $select = mysqli_query($conn, "SELECT * FROM `tbl_Item` WHERE Item_name = '$item'") or die('Query failed');

    if (!empty($_POST['subcategory'])) {
        $subcat = mysqli_real_escape_string($conn, $_POST['subcategory']);

        $subcatQuery = mysqli_query($conn, "SELECT Subcategory_id FROM `tbl_Subcategory` WHERE Subcategory_name = '$subcat'");

        if (mysqli_num_rows($subcatQuery) > 0) {
            $scat_id = mysqli_fetch_assoc($subcatQuery);
            $sid = $scat_id['Subcategory_id'];
        } else {
            echo '<p class="msg">Unknown subcategory</p>';
        }
    }

    $brandQuery = mysqli_query($conn, "SELECT Brand_id FROM `tbl_Brand` WHERE Brand_name = '$brand'");

    if (mysqli_num_rows($brandQuery) > 0) {
        $bid = mysqli_fetch_assoc($brandQuery);
        $newbrand = $bid['Brand_id'];
    } else {
        // Call the stored function and fetch the result
        $sql = mysqli_query($conn, "SELECT generate_brand_id() AS new_brand_id");
        if ($sql) {
            $newbrand = mysqli_fetch_assoc($sql)['new_brand_id'];
        } else {
            // Handle the error
            echo "Error: " . $conn->error;
        }



        $create = mysqli_query($conn, "INSERT INTO `tbl_Brand` (Brand_id,Brand_name) VALUES ('$newbrand','$brand')");
    }

    if (isset($sid) && isset($newbrand)) {
        $image_name = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];


        $destination = 'uploads/' . $image_name;
        move_uploaded_file($image_tmp, $destination);

        $existingVendorQuery = mysqli_query($conn, "SELECT Vendor_id FROM tbl_Vendor WHERE Customer_id = '$user_id'");

        if (mysqli_num_rows($existingVendorQuery) > 0) {
            $existingVendor = mysqli_fetch_assoc($existingVendorQuery);
            $newvendor = $existingVendor['Vendor_id'];
        } else {

            $sql = mysqli_query($conn, "SELECT generate_vendor_id() AS new_vendor_id");
            if ($sql) {
                $newvendor = mysqli_fetch_assoc($sql)['new_vendor_id'];
            } else {
                // Handle the error
                echo "Error: " . $conn->error;
            }

            $insertt = mysqli_query($conn, "INSERT INTO tbl_Vendor (Vendor_id,Customer_id, Vendor_Phno, Vendor_Fname, Vendor_Mname, Vendor_Lname, Vendor_dist, Vendor_city, Vendor_pin, Vendor_Status) VALUES ('$newvendor','$user_id', '$phno', '$fname', '$mname', '$lname', '$dist', '$city', '$pin', '1')");
        }

        $sql = mysqli_query($conn, "SELECT generate_item_id() AS new_item_id");
        if ($sql) {
            $newitem = mysqli_fetch_assoc($sql)['new_item_id'];
        } else {
            // Handle the error
            echo "Error: " . $conn->error;
        }


        $insert = mysqli_query($conn, "INSERT INTO `tbl_Item` (Item_id, Vendor_id, Subcategory_id, Brand_id, Mfg_date, price, qty, Item_name, Item_desc, Item_img) VALUES ('$newitem','$newvendor', '$sid', '$newbrand','$date', '$price', '$quantity', '$item', '$desc', '$image_name')") or die('Query failed');
        $item_id = mysqli_insert_id($conn); // Save item ID here

        if ($insert) {
            $_SESSION['itemid'] = $newitem;
            header('location: ads.php');
            exit(); // Always exit after a redirect
        } else {
            echo '<p class="msg">error</p>';


        }
    }
}
?>
<html>

<head>

    <title>Post Your Ad</title>
    <style>
        @font-face {
            font-family: 'OstrichSansreg';
            src: url(fonts/Blender-Pro-Bold.otf);
        }

        body {
            font-family: 'OstrichSansreg';
            margin: 0;
            padding: 0;
        }

        .logo {
            position: absolute;
            top: 0px;
            min-width: 197.5vh;
        }

        .logo a {
            color: white;
            font-size: 20px;
            text-decoration: none;
        }

        main {
            color: white;
            max-width: 800px;
            margin: 150px auto;
            padding: 20px;
            background-color: #000;
            border-radius: 3px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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

        h1 {
            text-align: center;
            font-size: 35px;
            margin-bottom: 30px;
        }

        form {
            display: grid;
            gap: 10px;
        }

        label {
            margin-left: 30px;
            font-size: 18px;
        }

        select,
        input,
        textarea {
            font-family: 'OstrichSansreg';
            color: white;
            background-color: black;
            width: 50%;
            padding: 10px;
            margin-left: 30px;
            font-size: 16px;
            border: 3px solid #ccc;
            border-radius: 1px;
        }

        input:hover,
        textarea:hover {
            border: 3px #f9004d solid;
        }

        textarea {
            resize: vertical;
        }

        button {
            clip-path: polygon(0 0, 0 calc(100% - 20px), 20px 100%, 100% 100%, 100% 20px, calc(100% - 20px) 0);
            font-family: OstrichSansreg;
            color: #fff;
            text-align: center;
            font-size: 30px;
            background-color: #f9004d;
            width: 35%;
            padding: 6px;
            position: relative;
            left: 500px;
            top: 10px;
            cursor: pointer;
        }

        .button:hover {
            background-color: #fff;
            color: #f9004d;
        }

        nav {
            font-family: OstrichSansreg;
            display: flex;
            padding: 30px;
            align-items: center;
            justify-content: space-between;
            background-color: black;
        }


        .optgroup {
            margin-bottom: 10px;
            margin-left: 30px;

        }

        .category-label {
            display: flex;
            width: 300px;
            padding: 10px;
            border: 3px solid #ccc;
            font-weight: bold;
            justify-content: space-between;
            align-items: center;

        }

        .category-label:hover {
            border: 3px solid #f9004d;
            color: #f9004d;
            background-color: #fff;
        }

        .category-label i {
            margin-left: 10px;
        }

        .subcat {
            display: flex;
            align-items: center;
            padding: 5px;
            cursor: pointer;
        }

        .subcat-list {
            padding: 3px;
            border: 3px solid #ccc;
            width: 300px;
            display: none;
            margin-left: 350px;
            position: relative;

        }

        .category-label.active {
            position: absolute;
        }

        .category-label.active+.subcat-list {
            display: block;


        }

        .subcat input[type="radio"] {
            position: absolute;
            left: 170px;

            transform: scale(1.5);
        }


        .msg {
            clip-path: polygon(0 0, 0 calc(100% - 20px), 20px 100%, 100% 100%, 100% 20px, calc(100% - 20px) 0);
            font-family: OstrichSansreg;
            position: absolute;
            left: 80vh;
            top: 60px;
            padding: 8px 20px;
            max-width: 500px;
            color: #f2f2f2;
            text-align: center;
            font-size: 30px;
            background-color: #f9004d;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</head>

<body background="8.jpg">



    <main>
        <h1>POST YOUR AD</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <?php
            $qry = mysqli_query($conn, "SELECT C.Category_id, C.Category_name, S.Subcategory_name FROM tbl_Category C,tbl_Subcategory S WHERE C.Category_id=S.Category_id");
            $lastCategory = null;
            $categoryOptions = '';

            while ($row = mysqli_fetch_assoc($qry)):
                if ($lastCategory !== $row['Category_name']) {
                    if (!empty($categoryOptions)) {
                        $categoryOptions .= '</div></div>';
                    }
                    $categoryOptions .= '<div class="optgroup">';
                    $categoryOptions .= '<div class="category-label " >' . $row['Category_name'] . '<i class="fa fa-chevron-right"></i></div>';
                    $categoryOptions .= '<div class="subcat-list">';
                    $lastCategory = $row['Category_name'];
                }
                $categoryOptions .= '<label class="subcat"><input type="radio" name="subcategory" value="' . $row['Subcategory_name'] . '">' . $row['Subcategory_name'] . '</label>';
            endwhile;
            $categoryOptions .= '</div></div>';
            ?>
            <label for="category">CHOOSE A CATEGORY</label>
            <div class="cat">
                <?php echo $categoryOptions; ?>
            </div>
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    const categoryLabels = document.querySelectorAll(".category-label");
                    categoryLabels.forEach(label => {
                        label.addEventListener("click", function () {
                            categoryLabels.forEach(lbl => lbl.classList.remove("active"));
                            this.classList.toggle("active");
                        });
                    });
                });
            </script>
            <label for="brand">Brand:</label>
            <input type="test" placeholder="Brand Name..." name="brand" required="">

            <label for="item-name">Item Name:</label>
            <input type="text" placeholder="Item Name..." name="item" required="">

            <label for="item-description">Item Description:</label>
            <textarea rows="4" cols="30" name="desc" placeholder="Item Description..." class="area"></textarea>

            <label for="brand">SET A PRICE:</label>
            <input type="test" placeholder="Price..." name="price">

            <label for="brand">Quantity:</label>
            <input type="number" placeholder="Quantity..." min="1" max="100" name="quantity"
                oninput="this.value = this.value.slice(0, 3)" value="1">



            <label for="mfg-date">Manufacturing Date:</label>
            <input type="date" name="date" max="<?php echo date('Y-m-d'); ?>" required="">

            <label for="item-image">Item Image:</label>
            <input type="file" name="image" accept="image/jpg, image/jpeg, image/png">

            <button type="submit" name="submit" class="button">Submit</button>

        </form>
    </main>
</body>

</html>