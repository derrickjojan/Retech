<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$db = 'retech1';

$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['submit'])) {
    $item = mysqli_real_escape_string($conn, $_POST['item']);
    $subcat = mysqli_real_escape_string($conn, $_POST['subcategory']);
    $brand = mysqli_real_escape_string($conn, $_POST['brand']);
    $desc = mysqli_real_escape_string($conn, $_POST['desc']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);

    $select = mysqli_query($conn, "SELECT * FROM `tbl_Item` WHERE Item_name = '$item'") or die('Query failed');

    if (mysqli_num_rows($select) > 0) {
        $message[] = '*Item already exists*';
    } else {
        $subcatQuery = mysqli_query($conn, "SELECT Subcategory_id FROM `tbl_Subcategory` WHERE Subcategory_name = '$subcat'");
        if (mysqli_num_rows($subcatQuery) > 0) {
            $scat_id = mysqli_fetch_assoc($subcatQuery);
            $sid = $scat_id['Subcategory_id'];
        } else {
            $message[] = '*Unknown Subcategory*';
        }

        $brandQuery = mysqli_query($conn, "SELECT Brand_id FROM `tbl_Brand` WHERE Brand_name = '$brand'");
        if (mysqli_num_rows($brandQuery) > 0) {
            $bid = mysqli_fetch_assoc($brandQuery);
            $brid = $bid['Brand_id'];
        } else {
            $message[] = '*Unknown Brand*';
        }

        if (isset($sid) && isset($brid)) {
            $image_name = $_FILES['image']['name'];
            $image_tmp = $_FILES['image']['tmp_name'];

            
            $destination = 'uploads/' . $image_name;
            move_uploaded_file($image_tmp, $destination);

            $insert = mysqli_query($conn, "INSERT INTO `tbl_Item` (Subcategory_id, Brand_id, Mfg_date, Item_name, Item_desc, Item_img) VALUES ('$sid', '$brid', '$date', '$item', '$desc', '$image_name')") or die('Query failed');

            if ($insert) {
                header('location: itemlist.php');
            } else {
                $message[] = 'Addition failed!';
            }
        }
    }
}

$messageStyle = '
    position: absolute;
    left: 100px;
    top:480px;  
    background-color: #fff; 
    color: #000000; 
    font-family: Unispace; 
    width: 400px; 
    text-align:center; 
    padding: 10px; 
    border-radius: 5px; 
    font-size: 20px;
';
?>

<html>
<head>
    <title>Item</title>
    <style>
        .message {
            <?php echo $messageStyle; ?>
        }
        @font-face {
  font-family: 'OstrichSanss';
  src: url(fonts/OstrichSans-Bold.otf);
}
        body {
            font-family: Segoe UI;
            background-color: #f2f2f2;
        }

        .container {
            position: relative;
            top: 135px;
            max-width: 600px;
            height: 58%;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border: 2px solid #ccc;
            border-radius: 10px;
        }

        h1 {
  margin: 10px;
font-family: OstrichSanss;
font-weight: 800;
font-size: 50px;
text-align: center;
}


        form {
            margin-top: 20px;
        }

        p {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 8px;
        }

        input, select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        sp {
            position: relative;
            left: 120px;
        }

        sd {
            position: relative;
            bottom: 42px;
        }

        input[type="test"] {
            position: relative;
            bottom: 42px;
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="file"] {
            position: relative;
            left: 120px;
            width: 50%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        sa {
            position: relative;
            bottom: 80px;
        }

        input[type="date"] {
            position: relative;
            bottom: 80px;
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .button {
            position: relative;
            left: 150px;
            bottom: 40px;
            width: 50%;
            padding: 10px;
            background-color: #000000;
            color: white;
            border: none;
            border-radius: 4px;
        }

        textarea {
            width: 100%;
            height: 120px;
            padding: 10px;
            border: 1px solid #ccc;
        }
    </style>
</head>
<body background="6.png">
    <div class="container">
        <form action="" method="post" enctype="multipart/form-data">
            <h1>Add Item</h1>
            <?php
            if (isset($message)) {
                foreach ($message as $message) {
                    echo '<div class="message">' . $message . '</div>';
                }
            }
            ?>
            <sp>Image:</sp>
            <input type="file" name="image" accept="image/jpg, image/jpeg, image/png">
            <table>
                <tr>
                    <td width=50%>
                        Subcategory Name:
                        <input type="text" name="subcategory" required="">
                    </td>
                    <td>
                        Item Name:
                        <input type="text" name="item" required="">
                    </td>
                </tr>
                <tr>
                    <td>
                        <sd>Brand Name:</sd>
                        <input type="test" name="brand" required="">
                    </td>
                    <td>
                        Item Description
                        <textarea rows="1" cols="30" name="desc" class="area"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        <sa>MFG Date:</sa>
                        <input type="date" name="date" required="">
                    </td>
                </tr>
            </table>
            <input type="submit" name="submit" value="Submit" class="button">
        </form>
    </div>
</body>
