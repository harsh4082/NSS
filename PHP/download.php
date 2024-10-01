<?php
include '../../NSS_NEW/partial/_dbconnector.php';
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: PHP/leader_login.php");
    exit;
}



?>
<?php
require '../../NSS_NEW/partial/_dbconnector.php';

$eventName = '';
$eventDate = '';
$data = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $eventName = isset($_POST["Event_nm"]) ? $_POST["Event_nm"] : '';
    $eventDate = isset($_POST["date"]) ? $_POST["date"] : '';

    // Use prepared statements to prevent SQL injection
    $query = "SELECT * FROM attend WHERE Name = ? AND Date = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ss", $eventName, $eventDate);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
    } else {
        echo "No data found for the selected event and date.";
    }
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Include Bootstrap and other necessary CSS/JS libraries -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="website icon" type="png" href="/NSS_NEW/Image/NSS.png">
    <link rel="stylesheet" href="../CSS/style.css">
    <style>
        #body::-webkit-scrollbar{
            display: none;
        }
    </style>
</head>

<body id="body">
    <br><br>
    <?php
    include '../../NSS_NEW/partial/_header.php';
    require '../../NSS_NEW/partial/_dbconnector.php';
    ?>
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">Fetch Data</h3>
                <form action="/NSS_NEW/PHP/export.php" method="post">
                <div class="form-group">
                        <label for="Event_nm">Event Name</label>
                        <input list="events" class="form-control" id="Event_nm" name="Event_nm" autocomplete="off">
                        <datalist id="events">
                            <?php
                            $sql = "SELECT Name FROM events";
                            $result = mysqli_query($conn, $sql);

                            if ($result) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $eventName = $row['Name'];
                                    echo "<option value='$eventName'>$eventName</option>";
                                }
                            }
                            ?>
                        </datalist>
                    </div>
                    <div class="form-group">
                        <label for="date">Date</label>
                        <input list="dates" class="form-control" id="date" name="date" autocomplete="off">
                        <datalist id="dates">
                            <?php
                            $sql = "SELECT DISTINCT Date FROM attend";
                            $result = mysqli_query($conn, $sql);

                            if ($result) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $eventDate = $row['Date'];
                                    echo "<option value='$eventDate'>$eventDate</option>";
                                }
                            }
                            ?>
                        </datalist>
                    </div>
                    <br>
                    <button type="submit" name="show_data" class="btn btn-primary">Download Data</button>
                </form>
            </div>
        </div>
    </div>
    <br><br><br>

    <?php include '../../NSS_NEW/partial/_footer.php'; ?>

</body>

</html>
