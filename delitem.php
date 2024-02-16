
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

    // Perform the deletion
    $delete = mysqli_query($conn,"DELETE FROM tbl_Item WHERE Item_id='$id'");

    // Check if the deletion was successful
    if ($delete) {
        // Deletion successful
        header('location:itemlist.php');
    } else {
        // Deletion failed
        echo "Error deleting item.";
    }
} else {
    // Item_id is not provided in the request
    echo "Invalid request.";
}
?>
