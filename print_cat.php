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
            display: flex;
            position: relative;
            text-align: right;
            font-size: 14px;
            color: #333;
        }

        .date {
            display: flex;
            position: relative;
            text-align: right;
            font-size: 14px;
            color: #333;
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
            <h3 class="list">Category List</h3>
        </div>
        <p class="date">Date:
            <?php echo $currentDate; ?>
        </p>
        <?php
        $i = 1;
        $j = 1;
        $perPage = 20; // Number of entries per page
        $page = 1; // Initialize page number
        $qry = mysqli_query($conn, "SELECT * FROM `tbl_Category`");
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
                            <col width="5%">
                            <col width="10%">
                            <col width="10%">
                        </colgroup>
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Category id</th>
                                <th>Category Name</th>
                                <th>Category Description</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php endif; ?>

                        <tr>
                            <td class="text-center">
                                <?php echo $j++; ?>
                            </td>
                            <td>
                                <?php echo $row['Category_id'] ?>
                            </td>
                            <td>
                                <?php echo $row['Category_name'] ?>
                            </td>
                            <td>
                                <?php echo $row['Category_desc'] ?>
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