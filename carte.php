<?php

require 'connection.php';
if(isset($_POST['submit']))
{
  //$sid = $_POST['staffid'];
  $fname = $_POST['firstname'];
  $lname = $_POST['lastname'];
  $uname = $_POST["username"];
  //$email = $_POST["email"];
  //$housename = $_POST["housename"];
  $city = $_POST["city"];
  $district = $_POST["district"];
  $street = $_POST["street"];
  $pincode = $_POST["pincode"];
  $dob = $_POST["dob"];
  $phonenumber = $_POST["phonenumber"];
  $join=$_POST["join"];
  $password = $_POST["password"];
  $confirm = $_POST["confirmpass"];
  $gender = $_POST["gender"];

  $insert= "INSERT INTO tbl_login(Username,	Login_pswd,	Type,Login_status) VALUES('$uname','$password','staff',1)";
  mysqli_query($conn,$insert);

  $query1 = "INSERT INTO tbl_staff(Username, Staff_fname, Staff_lname,Staff_pass, Staff_street,Staff_city, Staff_dist, Staff_pin, Staff_phno, Staff_gender, Staff_dob,Staff_join,Staff_status) VALUES ('$uname','$fname','$lname','$password','$street','$city','$district','$pincode','$phonenumber','$gender','$dob','$join',1)";

  mysqli_query($conn, $query1);
}
$query2 ="SELECT * FROM tbl_staff";
$result= mysqli_query($conn, $query2);
?>

<html>
    <head>
        <title>Edit Staff</title>
        
        <style>
/* Basic styling for the table */
table {
  border-collapse: collapse;
  width: 100%;
  margin-bottom: 20px;
  border: 10px solid #ccc;
  box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
}

/* Styling for table header cells */
th {
  background-color: #f2f2f2;
  text-align: left;
  padding: 12px;
  border: 5px;
  font-weight: bold;
  border-bottom: 5px solid #ddd;
}

/* Styling for table data cells */
td {
  padding: 12px;
  border-bottom: 1px solid #ddd;
}

/* Alternating row colors for better readability */
tr:nth-child(even) {
  background-color: #f2f2f2;
}

/* Hover effect for table rows */
tr:hover {
  background-color: #FFC0CB;
}

/* Adding some border to cells */
td, th {
  border: 1px solid #ccc;
}

/* Centering text in the header cells */
th {
  text-align: center;
}

/* Adding responsive styles for smaller screens */
@media (max-width: 600px) {
  table {
    border: 10px; /* Remove border */
    box-shadow: none; /* Remove box shadow */
    background-color: #00FFFF;
  }
  
  th, td {
    border: none; /* Remove cell borders */
    padding: 6px; /* Adjust padding */
    display: block;
    text-align: right; /* Align cell content to the right */
  }
  
  /* Center align header text */
  th {
    text-align: center;
  }
  
  /* Add background color to header cells */
  th {
    background-color: #f2f2f2;
  }
  
  /* Add alternating row background for better readability */
  tr:nth-child(even) {
    background-color: #FFC0CB;
  }
}

</style>
</head>
<body>
    <link rel="stylesheet" href="editstaffstyle.css">
    <div class="mainTable">
    <h1>Staff details</h1>
    <table id="table" border="1">
    <tr>
        <th>Staff_id</th>
        <th>Username</th>
        <th>Staff_fname</th>
        <th>Staff_lname</th>
        <th>Staff_pass</th>
        <th>Staff_street</th>
        <th>Staff_city</th>
        <th>Staff_dist</th>
        <th>Staff_pin</th>
        <th>Staff_phno</th>
        <th>Staff_gender</th>
        <th>Staff_dob</th>
        <th>Staff_join</th>
        <th>Staff_status</th>
</tr>
<?php while ($row= mysqli_fetch_assoc($result)){?>
<tr>
    <td><?php echo $row["Staff_id"]; ?> </td>
    <td><?php echo $row["Username"]; ?> </td>
    <td><?php echo $row["Staff_fname"]; ?> </td>
    <td><?php echo $row["Staff_lname"]; ?> </td>
    <td><?php echo $row["Staff_pass"]; ?> </td>
    <td><?php echo $row["Staff_street"]; ?> </td>
    <td><?php echo $row["Staff_city"]; ?> </td>
    <td><?php echo $row["Staff_dist"]; ?> </td>
    <td><?php echo $row["Staff_pin"]; ?> </td>
    <td><?php echo $row["Staff_phno"]; ?> </td>
    <td><?php echo $row["Staff_gender"]; ?> </td>
    <td><?php echo $row["Staff_dob"]; ?> </td>
    <td><?php echo $row["Staff_join"]; ?> </td>
    <td><?php echo $row["Staff_status"]; ?> </td>
</tr>
<?php
    
}?>
</table>

<div class="updateBtn">
<button onclick="editTableDisplay()">Update data</button>
</div>

<div class="editTable">

<div class="left">Username: </div><div><input type="text" name="username" id="username"></div><br>
<div class="left">Staff_fname: </div><div><input type="text" name="fname" id="fname"></div><br>
<div class="left">Staff_lname: </div><div><input type="text" name="lname" id="lname"></div><br>
<div class="left">Staff_pass: </div><div><input type="text" name="password" id="password"></div><br>
<div class="left">Staff_street: </div><div><input type="text" name="street" id="street"></div><br>
<div class="left">Staff_city: </div><div><input type="text" name="city" id="city"></div><br>
<div class="left">Staff_dist: </div><div><input type="text" name="district" id="district"></div><br>
<div class="left">Staff_pin: </div><div><input type="text" name="pincode" id="pincode"></div><br>
<div class="left">Staff_phno: </div><div><input type="text" name="phonenumber" id="phonenumber"></div><br>
<div class="left">Staff_gender: </div><div><input type="text" name="gender" id="gender"></div><br>
<div class="left">Staff_dob: </div><div><input type="text" name="dob" id="dob"></div><br>
<div class="left">Staff_join: </div><div><input type="text" name="join" id="join"></div><br>
<div class="left">Staff_status: </div><div><input type="text" name="status" id="status"></div><br>


<button onclick="editRow()" class="editRowBtn">Update</button><br>
</div>

<script src="editstaff.js"></script>

</body>
</html>
<script>
var table = document.getElementById("table"),rIndex;

 for (var i= 1; i < table.rows.length; i++){
    table.rows[i].onclick=function()
    {
        rIndex =this.rowIndex;
        console.log(rIndex);
        //document.getElementById("staff_id").value=this.cells[1].innerHTML;
        document.getElementById("username").value= this.cells[1].innerHTML;
        document.getElementById("fname").value=this.cells[2].innerHTML;
        document.getElementById("lname").value= this.cells[3].innerHTML;
        document.getElementById("password").value =this.cells[4].innerHTML;
        document.getElementById("street").value=this.cells[5].innerHTML;
        document.getElementById("city").value= this.cells[6].innerHTML;
        document.getElementById("district").value =this.cells[7].innerHTML;
        document.getElementById("pincode").value=this.cells[8].innerHTML;
        document.getElementById("phonenumber").value= this.cells[9].innerHTML;
        document.getElementById("gender").value =this.cells[10].innerHTML;
        document.getElementById("dob").value=this.cells[11].innerHTML;
        document.getElementById("join").value= this.cells[12].innerHTML;
        document.getElementById("status").value =this.cells[13].innerHTML;
        

    };

    }

    function editRow(){
    //table.rows[rIndex].cells[1].inneHTML= document.getElementById("staff_id").value;
    table.rows[rIndex].cells[1].inneHTML= document.getElementById("username").value;
    table.rows[rIndex].cells[2].inneHTML= document.getElementById("fname").value;
    table.rows[rIndex].cells[3].inneHTML= document.getElementById("lname").value;
    table.rows[rIndex].cells[4].inneHTML= document.getElementById("password").value;
    table.rows[rIndex].cells[5].inneHTML= document.getElementById("street").value;
    table.rows[rIndex].cells[6].inneHTML= document.getElementById("city").value;
    table.rows[rIndex].cells[7].inneHTML= document.getElementById("district").value;
    table.rows[rIndex].cells[8].inneHTML= document.getElementById("pincode").value;
    table.rows[rIndex].cells[9].inneHTML= document.getElementById("phonenumber").value;
    table.rows[rIndex].cells[10].inneHTML= document.getElementById("gender").value;
    table.rows[rIndex].cells[11].inneHTML= document.getElementById("dob").value;
    table.rows[rIndex].cells[12].inneHTML= document.getElementById("join").value;
    table.rows[rIndex].cells[13].inneHTML= document.getElementById("status").value;
                                         

    }
function editTableDisplay(){
    document.querySelector('.editTable').setAttribute('style', 'display: block;');
}
</script>