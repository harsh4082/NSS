<?php
include '../../NSS_NEW/partial/_dbconnector.php';
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: /NSS_NEW/PHP/login.php");
    exit;
}

// require "C:/xampp/htdocs/NSS_NEW/PHP/logout2.php";
?>

<?php
$showAlert = false;
$showError = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include '../../NSS_NEW/partial/_dbconnector.php';
    $eve_nm = $_POST["eve_nm"];
    $dt = $_POST["dt"];
    // $hour = $_POST["hour"];
    $t_incharge = $_POST["t_incharge"];
    $leader = $_POST["leader"];
    $level = $_POST["level"];
    $desc = $_POST["desc"];
    $status = "In Progress";
    $status2 = "Not Done";
    $Proj_name = $_POST["Proj_name"];
    $lead_id = $_POST["lead_id"];



    $male = 0;
    $female = 0;
    $sql = "INSERT INTO `events` (`Name`, `Date`,`Teacher_Incharge`,`leader`,`proj_name`,`Level`, `Desc`, `Status`,`status2`,`Time`, `male`, `female`,`Lead_no`) 
                VALUES ('$eve_nm', '$dt','$t_incharge','$leader','$Proj_name', '$level','$desc','$status','$status2',current_timestamp(),'$male','$female','$lead_id');";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $showAlert = true;
        header("location: /NSS_NEW/PHP/attend.php");
    } else {
        $showError = "Something is missing";
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="website icon" type="png" href="/NSS_NEW/Image/NSS.png">
    <title>Hello <?php echo $_SESSION['username'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="../CSS/style.css">
    <style>
        #body::-webkit-scrollbar{
            display: none;
        }
    </style>
</head>

<body id="body">
    <br><br><br>
    <?php
    include '../../NSS_NEW/partial/_header.php';
    require '../../NSS_NEW/partial/_dbconnector.php';
    ?>
    <h4 class="alert-heading text-center mt-3">Welcome - <?php echo $_SESSION['username'] ?></h4>

    <?php
    if ($showAlert) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Event Added Successfully</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
    if ($showError) {
        echo ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> ' . $showError . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true"></span>
            </button>
        </div> ';
    }

    ?>

    <div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="card shadow" style="width: 25rem; background-color: #f8f9fa; border: none; font-family: 'Arial, sans-serif';">
            <h1 class="card-header text-center" style="background-color: #007BFF; color: #fff; font-size: 24px; padding: 12px;">Add an Event</h1>
            <div class="card-body">

                <form action="/NSS_NEW/PHP/addEvent.php" method="post">
                    <div class="mb-3">
                        <label for="event" class="form-label">Name of Event</label>
                        <input type="text" class="form-control" id="event" name="eve_nm" aria-describedby="event" required autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="date" name="dt" aria-describedby="date" required autocomplete="off" min="<?php echo date('Y-m-d'); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="t_incharge" class="form-label">Teacher Incharge</label>
                        <select class="form-control" id="t_incharge" name="t_incharge" required autocomplete="off">
                            <option value="" disabled selected>Select Teacher Incharge</option>
                            <?php
                            $sql = "SELECT T_incharge FROM project;";
                            $result = mysqli_query($conn, $sql);

                            if ($result) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $t_incharge = $row['T_incharge'];
                                    echo "<option value='$t_incharge'>$t_incharge</option>";
                                }
                            } else {
                                echo "<option value=''>No projects found</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="t_incharge" class="form-label">Leader</label>
                        <!-- <input type="text" class="form-control" id="t_incharge" name="t_incharge" aria-describedby="t_incharge"> -->
                        <select class="form-control" id="leader" name="leader" required autocomplete="off">
                            <option value="" disabled selected>Select leader</option>
                            <?php
                            $sql = "SELECT Name FROM leader;";
                            $result = mysqli_query($conn, $sql);

                            if ($result) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $leader = $row['Name'];
                                    echo "<option value='$leader'>$leader</option>";
                                }
                            } else {
                                echo "<option value=''>No projects found</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="lead_id">Leader_id</label>
                        <?php
                        include 'C:/xampp/htdocs/NSS_NEW/PHP/new2.php';
                        ?>
                        <input required autocomplete="off" class="form-control" id="lead_id" name="lead_id"
                            value=<?php echo $lead_no; ?> readonly>
                    </div>
                    <div class="form-group">
                        <label for="project">Project Name</label>
                        <select class="form-control" id="project" name="Proj_name" required autocomplete="off">
                            <option value="" disabled selected>Select Project</option>
                            <?php
                            $sql = "SELECT Proj_name FROM project;";
                            $result = mysqli_query($conn, $sql);

                            if ($result) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $Proj_name = $row['Proj_name'];
                                    echo "<option value='$Proj_name'>$Proj_name</option>";
                                }
                            } else {
                                echo "<option value=''>No projects found</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="levelSelect">Select a level:</label>
                        <select class="form-control" id="levelSelect" name="level" required autocomplete="off">
                            <option value="College Level">College Level</option>
                            <option value="Area Level">Area Level</option>
                            <option value="District Level">District Level</option>
                            <option value="University Level">University Level</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="desc" class="form-label">Description of event</label>
                        <textarea class="form-control" id="desc" name="desc" rows="3" required autocomplete="off"></textarea>
                    </div>
                   
<br>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>


    <br><br>
    <?php
    include '../../NSS_NEW/partial/_footer.php';
    ?>
</body>

</html>