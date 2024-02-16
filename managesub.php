<?php
session_start();

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$db = 'retech1';
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $result_displayValues = mysqli_query($conn, "SELECT * FROM tbl_Subcategory WHERE Subcategory_id = '$id'");
    $row_displayValues = mysqli_fetch_assoc($result_displayValues);

    $catname = $row_displayValues['Subcategory_name'];
    $catdesc = $row_displayValues['Subcategory_desc'];

    if (isset($_POST['cancel'])) {
        header('location:subcatlist.php');
        exit();
    }

    if (isset($_POST['submit'])) {
        $catname_fetched = $_POST['Subcategory'];
        $desc_fetched = $_POST['desc'];

        if (!empty($catname_fetched) && !empty($desc_fetched)) {
            $sql_update = "UPDATE tbl_Subcategory SET Subcategory_name='$catname_fetched', Subcategory_desc='$desc_fetched' WHERE Subcategory_id='$id'";

            if (mysqli_query($conn, $sql_update)) {
                echo "Record updated successfully";

                $result_displayValues = mysqli_query($conn, "SELECT * FROM tbl_Subcategory WHERE Subcategory_id = '$id'");
                $row_displayValues = mysqli_fetch_assoc($result_displayValues);

                $catname = $row_displayValues['Subcategory_name'];
                $catdesc = $row_displayValues['Subcategory_desc'];

                header('location:subcatlist.php');
                exit();
            } else {
                echo "Error updating record: " . mysqli_error($conn);
            }
        } else {
            $error = 'All fields are compulsory';
        }
    }
}
?>

<html>
<head>
    <title>Sub Category</title>
    <style>
              @font-face {
  font-family: 'OstrichSanss';
  src: url(fonts/OstrichSans-Bold.otf);
}
        body {
            font-family: sans-serif;
        }

        .container {
            position: relative;
            top: 150px;
            width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #FFFFFF;
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

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 2px solid #ccc;
        }

        textarea {
            width: 100%;
            height: 80px;
            padding: 10px;
            margin-bottom: 20px;
            border: 2px solid #ccc;
        }

        button {
            position: relative;
            left: 400px;
            width: 16%;
            padding: 10px;
            background-color: #000000;
            color: #fff;
            border: none;
        }
    </style>
</head>
<body background="6.png">
<div class="container">
    <h1>Edit Sub Category</h1>
    <form action="" method="POST">
        <label>Category Name</label>
        <input type="text" name="Subcategory" value="<?php echo $catname; ?>" required>
        <label>Description</label>
        <textarea rows="1" cols="30" name="desc" class="area" required><?php echo $catdesc; ?></textarea>
        <button type="submit" name="submit">Save</button>
        <button type="submit" name="cancel">Cancel</button>
    </form>
</div>
</body>
</html>
