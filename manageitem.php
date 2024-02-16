<?php
session_start();
?>
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

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $result_displayValues = mysqli_query($conn,"SELECT * FROM tbl_Item WHERE Item_id = '$id'");
    $row_displayValues = mysqli_fetch_assoc($result_displayValues);

    $sid = $row_displayValues['Subcategory_id'];
    $bid = $row_displayValues['Brand_id'];
    $tname = $row_displayValues['Item_name'];
    $desc = $row_displayValues['Item_desc'];
    $mfg = $row_displayValues['Mfg_date'];
    $img = $row_displayValues['Item_img'] ?? ''; // Set a default value if the image is not available

    $select = mysqli_query($conn,"SELECT Subcategory_name FROM tbl_Subcategory WHERE Subcategory_id='$sid'");
    $fetch = mysqli_fetch_assoc($select);
    $sname = $fetch['Subcategory_name'];

    $selectt = mysqli_query($conn,"SELECT Brand_name FROM tbl_Brand WHERE Brand_id='$bid'");
    $fetchh = mysqli_fetch_assoc($selectt);
    $bname = $fetchh['Brand_name'];

    if (isset($_POST['submit'])) {
        $tname_fetched = mysqli_real_escape_string($conn, $_POST['tname']);
        $desc_fetched = mysqli_real_escape_string($conn, $_POST['desc']);
        $mfg_fetched = mysqli_real_escape_string($conn, $_POST['date']);
    
        if (!empty($tname_fetched) && !empty($desc_fetched) && !empty($mfg_fetched)) {
            // Check if the item with the given ID exists
            $sql_check_isavail = "SELECT * FROM tbl_Item WHERE Item_id = '$id'";
            $result_check_isavail = mysqli_query($conn, $sql_check_isavail);
    
            if (mysqli_num_rows($result_check_isavail) == 1) {
                // Update item details
    
                $img_fetched = $img; // Initialize with the existing image name
    
                if ($_FILES['img']['error'] === 0) {
                    $img_file = $_FILES['img']['tmp_name'];
                    $img_fetched = mysqli_real_escape_string($conn, $_FILES['img']['name']);
                    move_uploaded_file($img_file, $img_fetched);
                }
    
                $qry = "UPDATE tbl_Item SET Item_name = '$tname_fetched', Item_desc = '$desc_fetched', Item_img = '$img_fetched', Mfg_date = '$mfg_fetched' WHERE Item_id = '$id'";
    
                if (mysqli_query($conn, $qry)) {
                    echo "Record updated successfully";
    
                    // Redirect to the item list page
                    header('Location: itemlist.php');
                    exit;
                } else {
                    echo "Error updating record: " . mysqli_error($conn);
                }
            }
        } else {
            $error = 'All fields are compulsory';
        }
    }
    
}
?>
<head>
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
            top: 60px;
            max-width: 600px;
            height: 75%;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border: 3px solid #ccc;
            border-radius: 10px;
        }

        h1 {        
            position:relative;
            right:20px;
            top:15px;
            border-bottom: 3px solid black;
            padding-bottom: 10px;
            font-family: OstrichSanss;
            font-weight: 800;
            font-size: 50px;
            margin: 10px 0px;
            text-align: center;
            width: 640px;
        }

        form {    
            position: relative;
            bottom:25px;
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
            padding: 6px;
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
            left: 50%;
            bottom: 60px;
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

        .pic {
            position:relative;
            top: 30px;
        }
    </style>
</head>
<body background="6.png">
    <div class="container">
        <form action="" method="post" enctype="multipart/form-data">
            <h1>Edit Item</h1>
            <?php
            if (isset($message)) {
                foreach ($message as $message) {
                    echo '<div class="message">' . $message . '</div>';
                }
            }
            ?>
            <div class="pic">
                <?php
                echo "<img src='$img' width='285' height='140'>";
                ?>
            </div>

            <input type="file" name="img" accept="image/jpg, image/jpeg, image/png">

            <table>
                <tr>
                    <td width=50%>
                        Subcategory Name:
                        <input type="text" name="subcategory" value=<?php echo (isset($sname)) ? "$sname" : ""?>>
                    </td>
                    <td>
                        Item Name:
                        <input type="text" name="tname" value="<?php echo (isset($tname)) ? $tname : ""; ?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        <sd>Brand Name:</sd>
                        <input type="test" name="brand" value=<?php echo (isset($bname)) ? "$bname" : ""?> >
                    </td>
                    <td>
                        Item Description
                        <textarea rows="1" cols="30" name="desc" class="area"><?php echo (isset($desc)) ? $desc : ""?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        <sa>MFG Date:</sa>
                        <input type="date" name="date" value=<?php echo (isset($mfg)) ? "$mfg" : ""?>>
                    </td>
                </tr>
            </table>
            <input type="submit" name="submit" value="Submit" class="button">
        </form>
    </div>
</body>
