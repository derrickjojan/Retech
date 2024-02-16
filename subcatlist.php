<?php include('admin.php') ?>
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
        }

        *::-webkit-scrollbar {
            height: .5rem;
            width: 10px;
        }

        *::-webkit-scrollbar-track {
            background-color: rgba(17, 11, 28, 0.9);
        }

        *::-webkit-scrollbar-thumb {
            background-color: black;
        }

        .container {
            font-family: 'Blender';
            font-size: 17px;
            box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
            position: relative;
            left: 17%;
            top: 85px;
            width: 1199px;
            padding: 20px;
            border-top: 3px solid #000;
            background-color: #fff;
            border-radius: 2px;
            transition: left 0.9s ease;


        }

        #check:checked~.container {
            position: relative;
            left: 100px;

            width: calc(91% - 120px);
        }



        .header {
            position: relative;
            right: 20px;
            bottom: 22px;
            width: 101.7%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #000000;
            margin-bottom: 10px;
            border-radius: 5px;

        }


        .header h3 {
            font-size: 30px;
            font-weight: bold;
            color: #000;
            margin: 0;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #000;
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #f9004d;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 7px;
            text-align: left;
            border: 1px solid #ccc;
        }

        th {

            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .dp {
            position: relative;
            display: inline-block;
        }

        .dpbtn {
            position: relative;
            left: 25px;
            background-color: #000;
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
        }

        .dp:hover .dropbtn {
            background-color: #f9004d;
        }

        .dp-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dp-content a {
            color: #333;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dp-content a:hover {
            background-color: #f9004d;
        }

        .dp:hover .dp-content {
            display: block;
        }

        .bttn {
            display: inline-block;
            padding: 8px 20px;
            background-color: #000;
            color: #fff;
            font-size: 16px;
            position: absolute;
            top: 9px;
            right: 18vh;
            font-weight: bold;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .exp-dropdown {
            position: absolute;
            right: 20vh;
            top: 8px;
        }

        .exp-dropdown-content {
            display: none;
            position: absolute;
            right: 0px;
            min-width: 130px;
            background-color: #f9f9f9;

        }

        .exp-dropdown:hover .exp-dropdown-content {
            display: block;

        }

        .exp-dropdown-content a {
            color: black;
            padding: 10px;
            text-decoration: none;
            display: block;
            border: 1px solid #ccc;
        }

        .exp-dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .exp-dropbtn {
            background-color: #000;
            color: #fff;
            border-radius: 4px;
            border: none;
            font-size: 16px;
            font-weight: bold;
            padding: 11px 20px;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.0/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>


</head>

<body>
    <div class="container">
        <div class="header">
            <h3>Subcategory List</h3>
            <div class="">
                <a href="addsub.php" class="btn"> Create New</a>
            </div>
        </div>
        <div class="table">
            <table id="salesTables">
                <colgroup>
                    <col width="5%">
                    <col width="15%">
                    <col width="15%">
                    <col width="20%">
                    <col width="20%">
                    <col width="10%" class="space">
                </colgroup>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Subcategory id</th>
                        <th>Category id</th>
                        <th>Subcategory Name</th>
                        <th>Subcategory Description</th>
                        <th class="no">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    $qry = mysqli_query($conn, "SELECT * FROM `tbl_Subcategory`");
                    while ($row = mysqli_fetch_assoc($qry)):

                        $id = $row['Subcategory_id'];

                        foreach ($row as $k => $v) {
                            $row[$k] = trim(stripslashes($v));
                        }
                        ?>
                        <tr>
                            <td class="text-center">
                                <?php echo $i++; ?>
                            </td>
                            <td>
                                <?php echo $row['Subcategory_id'] ?>
                            </td>
                            <td>
                                <?php echo $row['Category_id'] ?>
                            </td>
                            <td>
                                <?php echo $row['Subcategory_name'] ?>
                            </td>
                            <td>
                                <?php echo $row['Subcategory_desc'] ?>
                            </td>
                            <td align="center" class="no">
                                <div class="dp">
                                    <button class="dpbtn">Action</button>
                                    <div class="dp-content">
                                        <a href="#" class="edit-link" data-item-id="<?php echo $id; ?>">Edit</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <div class="exp-dropdown">
            <button class="exp-dropbtn">Export</button>
            <div class="exp-dropdown-content">
                <a href="#" onclick="printAndClose()">Print</a>
                <a href="#" id="exportToExcel" onclick="exportToExcel()">Export to Excel</a>
                <a href="#" onclick="exportToPDF()">Export to PDF</a>
            </div>
        </div>
    </div>
    <script>
        function printAndClose() {
            var printWindow = window.open("print_subcat.php", "_blank");
            printWindow.onload = function () {
                printWindow.print();
                printWindow.onafterprint = function () {
                    printWindow.close();
                };
            };
        }

        function exportToExcel() {
            fetch('viewsubcat.php') // Fetch data from viewcust.php
                .then(response => response.text())
                .then(data => {
                    var wb = XLSX.utils.book_new();
                    var ws = XLSX.utils.table_to_sheet(new DOMParser().parseFromString(data, 'text/html').getElementById('salesTable'));
                    XLSX.utils.book_append_sheet(wb, ws, "Subcat Report");
                    var wscols = [
                        { wch: 10 }, /* Column A width */
                        { wch: 15 }, /* Column B width */
                        { wch: 25 }, /* Column C width */
                        { wch: 25 }, /* Column C width */
                        { wch: 30 }, /* Column C width */

                    ];
                    ws['!cols'] = wscols;
                    XLSX.writeFile(wb, 'Subcat_report.xlsx');
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function exportToPDF() {
            var sunSoulHeading = `<style>

            body {
        font-family: 'times new roman', serif;
        font-size:14px;
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
        <div class="receipt">
            <div class="logo">
                <img src='logo.jpeg' width='400' height='100'>
                <p>Your Trusted Source for Used Electronics</p>
            </div>
            <h3 class="list">Subcategory List</h3>
        </div>

        <?php
        $currentDate = date("Y-m-d");
        $i = 1;
        $perPage = 20; // Number of entries per page
        $page = 1; // Initialize page number
        $qry = mysqli_query($conn, "SELECT * FROM `tbl_Subcategory`");
        $totalRows = mysqli_num_rows($qry);
        ?>
                        <p class="date">Date:
                        <?php echo $currentDate; ?>
                    </p>
        <?php while ($row = mysqli_fetch_assoc($qry)): ?>
                    <?php if ($i % $perPage === 1): ?>
                                <?php if ($page > 1): ?>
                                            </tbody>
                                            </table>
                                <?php endif; ?>
                                <div class="table">
                        <p class="page">Page <?php echo $page; ?></p>

                                    <table id="salesTable">
                                        <colgroup>
                                            <col width="5%">
                                            <col width="10%">
                                            <col width="10%">
                                            <col width="25%">
                                            <col width="25%">
                                            <col width="1%">
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
                                <div class="page-break"></div>
                                <?php $page++; ?>
                    <?php endif; ?>
                    <?php $i++; ?>
        <?php endwhile; ?>`;

            var content = sunSoulHeading;

            var opt = {
                margin: 10,
                filename: 'Subcat_report.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' },
                html2pdf: {
                    content: content,
                    image: { type: 'jpeg', quality: 0.98 },
                }
            };
            html2pdf().from(content).set(opt).save();
        };

        var editLinks = document.querySelectorAll('.edit-link');

        editLinks.forEach(function (editLink) {
            editLink.addEventListener('click', function (event) {
                event.preventDefault();

                var Subcategory_id = editLink.getAttribute('data-item-id');
                console.log(Subcategory_id); // Check if itemId has the correct value
                var url = 'managesub.php?id=' + Subcategory_id;
                window.location.href = url;

            });
        });
    </script>

</body>

</html>