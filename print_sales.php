<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$db = 'retech1';
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $db);
if ($conn->connect_error) {
    die("Connection failed:" . $conn->connect_error);
}
$currentDate = date("Y-m-d");
?>
<html>

<head>
    <style>
               @font-face {
            font-family: 'robo';
            src: url(fonts/ROBOT.ttf);
        }
            body {
            background-color: white;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 5px;
            border: 1px solid #ccc;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .receipt {
            max-width: 190vh;
            min-height: 5vh;
            margin: 0 auto;
            margin-top: 45px;
        }

        .logo {
            text-align: center;
            margin-bottom: 30px;

        }

        .receipt f {
            font-family: 'Martian Mono', monospace;
            display: block;
            padding-top:10px;
            position: relative;
            font-size: 20px;
        }

        .receipt g {

            font-family: 'robo';
            font-size: 50px;
            color: #f9004d;
            font-weight: 10px;

        }
        .list{
            font-family: 'Martian Mono', monospace;
            font-size: 20px;
            margin-bottom:-10px;
        }
        .receipt h1 {
            font-family: 'BlenderPro';
            position: relative;
            bottom: 10px;
        }

        spa {
            font-family: 'robo';
            color: #000;

        }
    </style>

</head>

<body>
    <div class="container">
        <div class="receipt">
            <div class="logo">
                <img src='logo.jpeg' width='400' height='100'>
                <p>Your Trusted Source for Used Electronics</p>
            </div>
            <h3 class="list">Customer List</h3>
        </div>
        <p class="date">Date:
                        <?php echo $currentDate; ?>
                    </p>
        <?php
        $i = 1;
        $j=1;
        $perPage = 20; // Number of entries per page
        $page = 1; // Initialize page number
        $qry = mysqli_query($conn, "SELECT * FROM `tbl_Customer`");
        $totalRows = mysqli_num_rows($qry);
        ?>
        <?php while ($row = mysqli_fetch_assoc($qry)): ?>
            <?php if ($i % $perPage === 1): ?>
                <?php if ($page > 1): ?>
                    </tbody>
                    </table>
                <?php endif; ?>
                <div class="table">
                    <p class="page">Page
                        <?php echo $page; ?>
                    </p>
                    <table id="salesTable">
                        <colgroup>
                            <col width="5%">
                            <col width="10%">
                            <col width="10%">
                            <col width="25%">
                            <col width="25%">
                        </colgroup>
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Subcategory id</th>
                                <th>Category id</th>
                                <th>Subcategory Name</th>
                                <th>Subcategory Description</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php endif; ?>

                        <tr>
                            <td class="text-center">
                                <?php echo $j++; ?>
                            </td>
                            <td>
                                <?php echo $row['Customer_id'] ?>
                            </td>
                            <td>
                                <?php echo $row['Cust_Username'] ?>
                            </td>
                            <td>
                                <?php echo $row['Cust_Fname'] ?>
                                <?php echo $row['Cust_Mname'] ?>
                            </td>
                            <td>
                                <?php echo $row['Cust_Phno'] ?>
                            </td>
                        </tr>

                        <?php if ($i % $perPage === 0 || $i === $totalRows): ?>
                        </tbody>
                    </table>
                </div>
                <div class="page-break"></div>
                <?php $page++; ?>
            <?php endif; ?>
            <?php $i++; ?>
        <?php endwhile; ?>
    </div>
</body>

</html>