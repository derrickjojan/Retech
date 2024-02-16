<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$db = 'retech1';
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $db);
if ($conn->connect_error) {
    die("Connection failed:" . $conn->connect_error);
}


?>
<html>

<head>
    <style>
        body {
            background-color: white;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 5px;
            border: 1px solid #ccc;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .receipt p {
            font-family: 'Martian Mono', monospace;
            font-size: 20px;
        }

        .logo {
            margin-top: 30px;
            text-align: center;
            margin-bottom: 5px;

        }

        .receipt g {

            font-family: 'robo';
            font-size: 50px;
            font-weight: 10px;
            color: #f9004d;
        }

        .receipt {
            text-align: center;
            max-width: 190vh;
            min-height: 0vh;
            margin: 0 auto;
        }

        .list {
            font-family: 'Martian Mono', monospace;
            font-size: 20px;
        }

        .page-break {
            page-break-after: always;
        }

        .page {
            font-family: 'Martian Mono', monospace;
            position: relative;
            font-size: 20px;
            text-align: right;
            color: #333;
        }
        .date{
            position: absolute;
            right:0px;
            top:0px;
            font-size: 15px;

        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.0/xlsx.full.min.js"></script>

</head>

<body>
    <div class="container">
        <div class="receipt">
            <div class="logo">
                <img src='logo.jpeg' width='400' height='100'>
                <p>Your Trusted Source for Used Electronics</p>
            </div>
            <h3 class="list">Subcategory List</h3>
           <?php $date = date("Y-m-d"); 
           echo '<p class="date">Date:' . $date .'</p>' ?>
        </div>
        <?php
        $i = 1;
        $perPage = 20; // Number of entries per page
        $page = 1; // Initialize page number
        $qry = mysqli_query($conn, "SELECT * FROM `tbl_Subcategory`");
        $totalRows = mysqli_num_rows($qry);
        ?>
        <?php while ($row = mysqli_fetch_assoc($qry)): ?>
            <?php if ($i % $perPage === 1): ?>
                <?php if ($page > 1): ?>
                    </tbody>
                    </table>
                <?php endif; ?>
                <p class="page">Page:
                    <?php echo $page; ?>
                </p>
                <div class="table">
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
                                <?php echo $i; ?>
                            </td>
                            <td>
                                <?php echo $row['Subcategory_id']; ?>
                            </td>
                            <td>
                                <?php echo $row['Category_id']; ?>
                            </td>
                            <td>
                                <?php echo $row['Subcategory_name']; ?>
                            </td>
                            <td>
                                <?php echo $row['Subcategory_desc']; ?>
                            </td>
                        </tr>

                        <?php if ($i % $perPage === 0 || $i === $totalRows): ?>
                        </tbody>
                    </table>
                </div>
                <?php $page++; ?>
                <div class="page-break"></div>
            <?php endif; ?>
            <?php $i++; ?>
        <?php endwhile; ?>
    </div>
</body>

</html>