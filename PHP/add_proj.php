<?php
include '../../NSS_NEW/partial/_dbconnector.php';

session_start();

if (!isset($_SESSION['Admin_loggedin']) || $_SESSION['Admin_loggedin'] != true) {
    header("location: admin_login.php");
    exit;
}

?>
<?php
require '../../NSS_NEW/partial/_dbconnector.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve project name and teacher name from the form
    $projectName = $_POST['projectName'];
    $teacherName = $_POST['teacherName'];
    $total_eve = 0;

    $sql = "INSERT INTO project (`Proj_name`, `T_incharge`,`total_eve`) VALUES ('$projectName', '$teacherName','$total_eve')";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("location: add_proj.php");
    } else {
       echo 'not done';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Add Project</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="website icon" type="png" href="/NSS_NEW/Image/NSS.png">
    <style>
        #body::-webkit-scrollbar{
            display: none;
        }
        .card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 150px;
        }
        .card-title {
            font-weight: bold;
        }
    </style>
  <link rel="stylesheet" href="../CSS/style.css">
</head>
<body id="body">
    <?php
        include '../../NSS_NEW/partial/_header.php';
    ?>
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="card" style="width: 400px;">
            <div class="card-body">
                <h2 class="card-title">Add a New Project</h2>
                <form method="post" action="add_proj.php">
                    <div class="form-group">
                        <label for="projectName">Project Name:</label>
                        <input type="text" class="form-control" name="projectName" required>
                    </div>
                    <div class="form-group">
                        <label for="teacherName">Teacher Incharge Name:</label>
                        <input type="text" class="form-control" name="teacherName" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap JS for form styling (optional) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
