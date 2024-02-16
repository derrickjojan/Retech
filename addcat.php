<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass= '';
$db = 'Retech1';

$conn = mysqli_connect($dbhost,$dbuser,$dbpass,$db);
if ($conn->connect_error) 
{
die("Connection failed:" . $conn->connect_error);
}

session_start();
if(isset($_POST['cancel'])){

  header('location:catlist.php');
}
if(isset($_POST['save'])){

  $category=mysqli_real_escape_string($conn,$_POST['category']);
  $desc=mysqli_real_escape_string($conn,$_POST['desc']);

$insert = mysqli_query($conn,"INSERT INTO tbl_Category(Category_id,Category_name,Category_desc)VALUES(generate_category_id(),'$category','$desc')");
if ($insert)
{
  header('location:catlist.php');
}
else
{
echo "error:";
}
$conn->close();
}
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
  top:150px;
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
p{
text-align: center;
}

input[type="text"]
{
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
    <h1>+ Add New Category</h1>
    <form action="" method="POST">
      <label>Category Name</label>
      <input type="text" placeholder="" name="category">
      <label>Description</label>
      <textarea rows="1" cols="30" name="desc" class="area"></textarea>
      <button type="submit" name="save">Save</button>
     <button type="sumbit" name="cancel">Cancel</button></a>
    </form>
  </div>
</body>
</html>