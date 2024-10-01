<?php
include '../../NSS_NEW/partial/_dbconnector.php';
session_start();

if (!isset($_SESSION['Admin_loggedin']) || $_SESSION['Admin_loggedin'] != true) {
    header("location: login.php");
    exit;
}
// Function to fetch records based on the year and order by class
function fetchRecordsByYear($year)
{
    global $conn;
    $selectQuery = "SELECT * FROM `Student` WHERE `year`='$year' AND `Selection`='Selected' ORDER BY `class` ASC";
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
    $updateQuery = "UPDATE `Student` SET `Selection`='$status' WHERE `student_id`='$studentId'";
    mysqli_query($conn, $updateQuery);
}

// Handle button click
if (isset($_POST["updateSelection"])) {
    $studentIds = $_POST["studentIds"];
    $status = $_POST["status"];
    
    foreach ($studentIds as $studentId) {
        updateSelectionStatus($studentId, $status);
    }

    // Output success message
    echo "Records updated successfully";
    exit; // We don't need to output anything else, so we exit here.
}

// Fetch records for each year
$fyStudents = fetchRecordsByYear('FY');
$syStudents = fetchRecordsByYear('SY');
$tyStudents = fetchRecordsByYear('TY');
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
        <br><br>
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
                        <form method="post" id="fyForm">
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
                                        <th>Select</th>
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
                                            <td><input type="checkbox" name="studentIds[]" value="<?php echo $student['student_id']; ?>"></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <!-- Hidden input field for status -->
                            <input type="hidden" name="status" value="Approved">
                            <button type="submit" name="updateSelection" class="btn btn-success">Approve</button>
                        </form>
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
                    <div class="table-responsive">
                        <form method="post" id="syForm">
                            <table class="table table-bordered table-hover" id="myTable2">
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
                                        <th>Select</th>
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
                                            <td><input type="checkbox" name="studentIds[]" value="<?php echo $student['student_id']; ?>"></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <!-- Hidden input field for status -->
                            <input type="hidden" name="status" value="Approved">
                            <button type="submit" name="updateSelection" class="btn btn-success">Approve</button>
                        </form>
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
                        <form method="post" id="tyForm">
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
                                        <th>Select</th>
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
                                            <td><input type="checkbox" name="studentIds[]" value="<?php echo $student['student_id']; ?>"></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <!-- Hidden input field for status -->
                            <input type="hidden" name="status" value="Approved">
                            <button type="submit" name="updateSelection" class="btn btn-success">Approve</button>
                        </form>
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

            // AJAX form submission
            $('#fyForm, #syForm, #tyForm').submit(function (event) {
                event.preventDefault(); // Prevent default form submission
                var studentIds = $(this).find('input[name="studentIds[]"]:checked').map(function () {
                    return $(this).val();
                }).get();
                var status = $(this).find('input[name="status"]').val(); // Get the status value from the hidden input field
                updateSelection(studentIds, status);
            });

            // AJAX function to update selection status
            function updateSelection(studentIds, status) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo $_SERVER["PHP_SELF"]; ?>', // Send the AJAX request to the same PHP file
                    data: {
                        updateSelection: true,
                        studentIds: studentIds,
                        status: status
                    },
                    success: function (response) {
                        alert(response); // Display success message
                        location.reload(); // Reload the page on success
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            }
        });
    </script>
</body>

</html>
