<?php
include '../../NSS_NEW/partial/_dbconnector.php';
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header('location: login.php');
}
$username = $_SESSION['username'];


// Function to fetch records based on the year and order by class
function fetchRecordsByYear($year)
{
    global $conn;
    $selectQuery = "SELECT * FROM `Student` WHERE `year`='$year' AND NOT (Selection = 'Approved') ORDER BY `class` ASC";
    $result = mysqli_query($conn, $selectQuery);

    if ($result) {
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        return [];
    }
}

// Function to update selection status
function updateSelectionStatus($studentId, $status)
{
    global $conn;
    $updateQuery = "UPDATE `Student` SET `selection`='$status' WHERE `id`='$studentId'";
    mysqli_query($conn, $updateQuery);
}

// Fetch records for each year
$fyStudents = fetchRecordsByYear('FY');
$syStudents = fetchRecordsByYear('SY');
$tyStudents = fetchRecordsByYear('TY');

// Handle button click
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["updateSelection"])) {
    $studentId = $_POST["studentId"];
    $status = $_POST["status"];

    updateSelectionStatus($studentId, $status);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Data</title>
    <link rel="stylesheet" href="../CSS/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <style>
        #body::-webkit-scrollbar {
            display: none;
        }

        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
            padding: 10px 15px;
            font-weight: bold;
        }

        .table {
            width: 100%;
            margin-bottom: 0;
            background-color: #fff;
            border-collapse: collapse;
            padding-top: 10px;
        }
        
        .table th,
        .table td {
            padding: 10px;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }

        .table th {
            font-weight: bold;
            background-color: #f8f9fa;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .table tbody tr:hover {
            background-color: #e9ecef;
        }

        .btn-select,
        .btn-remove {
            padding: 5px 10px;
            font-size: 14px;
        }

        .btn-select {
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-select:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }

        .btn-remove {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-remove:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }
    </style>
</head>

<body id="body">
<?php include '../../NSS_NEW/partial/_header.php'; ?>
        <br>
    <div class="container mt-5">
        <h1 class="text-center">Student Data</h1>

        <!-- FY Card -->
        <?php if (!empty($fyStudents)) : ?>
            <div class="card my-4">
                <div class="card-header">
                    <h2 class="card-title text-center">FY Students</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="myTable1">
                            <thead>
                                <tr>
                                    <th>Sr. No</th>
                                    <th>First Name</th>
                                    <th>Surname</th>
                                    <th>Year of Joining</th>
                                    <th>Class</th>
                                    <th>Roll No.</th>
                                    <th>Hours</th>
                                    <th>Student ID</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $srNo = 1;
                                foreach ($fyStudents as $student) :
                                ?>
                                    <tr>
                                        <td><?php echo $srNo++; ?></td>
                                        <td><?php echo $student['fname']; ?></td>
                                        <td><?php echo $student['sname']; ?></td>
                                        <td><?php echo $student['yoj']; ?></td>
                                        <td><?php echo $student['class']; ?></td>
                                        <td><?php echo $student['roll_num']; ?></td>
                                        <td><?php echo $student['hours']; ?></td>
                                        <td><?php echo $student['student_id']; ?></td>
                                        <td>
                                            <?php if ($student['Selection'] == 'Not Selected') : ?>
                                                <button class="btn btn-success btn-select" data-id="<?php echo $student['id']; ?>">Select</button>
                                            <?php else : ?>
                                                <button class="btn btn-danger btn-remove" data-id="<?php echo $student['id']; ?>">Remove</button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- SY Card -->
        <?php if (!empty($syStudents)) : ?>
            <div class="card my-4">
                <div class="card-header">
                    <h2 class="card-title text-center">SY Students</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive table">
                        <table class="table table-bordered table-hover" id="myTable2">
                            <thead>
                                <tr>
                                    <th scope="col">Sr. No</th>
                                    <th scope="col">First Name</th>
                                    <th scope="col">Surname</th>
                                    <th scope="col">Year of Joining</th>
                                    <th scope="col">Class</th>
                                    <th scope="col">Roll No.</th>
                                    <th scope="col">Hours</th>
                                    <th scope="col">Student ID</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $srNo = 1;
                                foreach ($syStudents as $student) :
                                ?>
                                    <tr>
                                        <td><?php echo $srNo++; ?></td>
                                        <td><?php echo $student['fname']; ?></td>
                                        <td><?php echo $student['sname']; ?></td>
                                        <td><?php echo $student['yoj']; ?></td>
                                        <td><?php echo $student['class']; ?></td>
                                        <td><?php echo $student['roll_num']; ?></td>
                                        <td><?php echo $student['hours']; ?></td>
                                        <td><?php echo $student['student_id']; ?></td>
                                        <td>
                                            <?php if ($student['Selection'] == 'Not Selected') : ?>
                                                <button class="btn btn-success btn-select" data-id="<?php echo $student['id']; ?>">Select</button>
                                            <?php else : ?>
                                                <button class="btn btn-danger btn-remove" data-id="<?php echo $student['id']; ?>">Remove</button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- TY Card -->
        <?php if (!empty($tyStudents)) : ?>
            <div class="card my-4">
                <div class="card-header">
                    <h2 class="card-title text-center">TY Students</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="myTable3">
                            <thead>
                                <tr>
                                    <th>Sr. No</th>
                                    <th>First Name</th>
                                    <th>Surname</th>
                                    <th>Year of Joining</th>
                                    <th>Class</th>
                                    <th>Roll No.</th>
                                    <th>Hours</th>
                                    <th>Student ID</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $srNo = 1;
                                foreach ($tyStudents as $student) :
                                ?>
                                    <tr>
                                        <td><?php echo $srNo++; ?></td>
                                        <td><?php echo $student['fname']; ?></td>
                                        <td><?php echo $student['sname']; ?></td>
                                        <td><?php echo $student['yoj']; ?></td>
                                        <td><?php echo $student['class']; ?></td>
                                        <td><?php echo $student['roll_num']; ?></td>
                                        <td><?php echo $student['hours']; ?></td>
                                        <td><?php echo $student['student_id']; ?></td>
                                        <td>
                                            <?php if ($student['Selection'] == 'Not Selected') : ?>
                                                <button class="btn btn-success btn-select" data-id="<?php echo $student['id']; ?>">Select</button>
                                            <?php else : ?>
                                                <button class="btn btn-danger btn-remove" data-id="<?php echo $student['id']; ?>">Remove</button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#myTable1').DataTable();
            $('#myTable2').DataTable();
            $('#myTable3').DataTable();
        });

        $(document).ready(function () {
            // Handle Select button click
            $('.btn-select').click(function () {
                var studentId = $(this).data('id');
                updateSelection(studentId, 'Selected');
            });

            // Handle Remove button click
            $('.btn-remove').click(function () {
                var studentId = $(this).data('id');
                updateSelection(studentId, 'Not Selected');
            });

            // AJAX function to update selection status
            function updateSelection(studentId, status) {
                $.ajax({
                    type: 'POST',
                    url: 'NEP_students.php', // Replace with your PHP file
                    data: {
                        updateSelection: true,
                        studentId: studentId,
                        status: status
                    },
                    success: function (response) {
                        location.reload();
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            }
        });
    </script>
<?php include '../../NSS_NEW/partial/_footer.php'; ?>

</body>

</html>
