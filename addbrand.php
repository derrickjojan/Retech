<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$db = 'Retech1';

$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $db);
if ($conn->connect_error) {
  die("Connection failed:" . $conn->connect_error);
}

session_start();

if (isset($_POST['cancel'])) {
  header('location:brandlist.php');
}

if (isset($_POST['save'])) {
  $brand = mysqli_real_escape_string($conn, $_POST['brand']);
  $desc = mysqli_real_escape_string($conn, $_POST['desc']);

  // Check if the brand already exists
  $checkBrandQuery = mysqli_prepare($conn, "SELECT Brand_id FROM `tbl_Brand` WHERE Brand_name = ?");
  mysqli_stmt_bind_param($checkBrandQuery, 's', $brand);
  mysqli_stmt_execute($checkBrandQuery);
  mysqli_stmt_store_result($checkBrandQuery);

  if (mysqli_stmt_num_rows($checkBrandQuery) > 0) {
    // Brand already exists
    header('location:brandlist.php');
  } else {
    // Brand doesn't exist, insert it
    $insertBrandQuery = mysqli_prepare($conn, "INSERT INTO tbl_brand (Brand_id, Brand_name, Brand_desc) VALUES (generate_brand_id(), ?, ?)");
    mysqli_stmt_bind_param($insertBrandQuery, 'ss', $brand, $desc);
    
    if (mysqli_stmt_execute($insertBrandQuery)) {
      header('location:brandlist.php');
    } else {
      echo "Error: " . mysqli_error($conn);
    }
  }

  // Close prepared statements
  mysqli_stmt_close($checkBrandQuery);
  mysqli_stmt_close($insertBrandQuery);
}

// Close the database connection
mysqli_close($conn);
?>


<html>
<html>

<head>
  <title>Brand</title>
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
    <h1>+ Add New Brand</h1>
    <form action="" method="POST">
      <label>Brand Name</label>
      <input type="text" placeholder="" name="brand" required>
      <label>Description</label>
      <textarea rows="1" cols="30" name="desc" class="area"></textarea>
      <button type="submit" name="save">Save</button>
      <button type="sumbit" name="cancel">Cancel</button></a>
    </form>
  </div>
</body>

</html>