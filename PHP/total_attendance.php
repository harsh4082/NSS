<?php
require '../../NSS_NEW/partial/_dbconnector.php';
session_start();
$show = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['Event_nm']) && isset($_POST['date'])) {
        $event_name = $_POST['Event_nm'];
        $date = $_POST['date'];

        $query_male = "SELECT COUNT(*) as male_count FROM attend WHERE Name = '$event_name' AND gen = 'Male' AND Date = '$date'";
        $result_male = mysqli_query($conn, $query_male);
        $row_male = mysqli_fetch_assoc($result_male);
        $male_count = $row_male['male_count'];

        $query_female = "SELECT COUNT(*) as female_count FROM attend WHERE Name = '$event_name' AND gen = 'Female' AND Date = '$date'";
        $result_female = mysqli_query($conn, $query_female);
        $row_female = mysqli_fetch_assoc($result_female);
        $female_count = $row_female['female_count'];

        $total = $male_count + $female_count;

        $show = true;
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="website icon" type="png" href="/NSS_NEW/Image/NSS.png">
    <title>Event Details Form</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="../CSS/style.css">

    <style>
        #body::-webkit-scrollbar{
            display: none;
        }
    </style>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
</head>

<body id="body">
    <?php
    include '../../NSS_NEW/partial/_header.php';
    require '../../NSS_NEW/partial/_dbconnector.php';
    ?>
    <br><br>
    <div class="container mt-5">
        <!-- Card for Total Event Details -->
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <h2 class="card-title">Total Event Details</h2>
            </div>
            <div class="card-body">
                <table class="table" id="myTable">
                    <thead>
                        <tr>
                            <th scope="col">S.No</th>
                            <th scope="col">Event Name</th>
                            <th scope="col">Teacher Incharge</th>
                            <th scope="col">Project</th>
                            <th scope="col">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require '../../NSS_NEW/PHP/new2.php';
                        $sql = "SELECT * FROM events where leader = '$name'";
                        $result = mysqli_query($conn, $sql);
                        $sno = 0;
                        while ($row = mysqli_fetch_assoc($result)) {
                            $sno = $sno + 1;
                            echo "
                                <tr>
                                    <td>" . $sno . "</td>
                                    <td>" . $row['Name'] . "</td>
                                    <td>" . $row['Teacher_Incharge'] . "</td>
                                    <td>" . $row['proj_name'] . "</td>
                                    <td>" . $row['Date'] . "</td>
                                </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header bg-danger text-white">
                <h2 class="card-title">Check total no. of participants</h2>
            </div>
            <div class="card-body">
                <form action="/NSS_NEW/PHP/total_attendance.php" method="POST">
                    <div class="form-group">
                        <label for="Event_nm">Event Name</label>
                        <input list="eventList" class="form-control" id="Event_nm" name="Event_nm">
                        <datalist id="eventList">
                            <?php
                            // Assuming you have already established a database connection $conn
                            $sql = "SELECT * FROM events"; // Modify this query as needed

                            $result = mysqli_query($conn, $sql);

                            if ($result) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $eventName = $row['Name'];
                                    echo "<option value='$eventName'>";
                                }
                            } else {
                                echo "<option value=''>No events found</option>";
                            }
                            ?>
                        </datalist>
                    </div>

                    <div class="form-group">
                        <label for="date">Date</label>
                        <input list="eventDates" class="form-control" id="date" name="date">
                        <datalist id="eventDates">
                            <?php
                            // Assuming you have already established a database connection $conn
                            $sql = "SELECT DISTINCT Date FROM events"; // Modify this query as needed

                            $result = mysqli_query($conn, $sql);

                            if ($result) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    // Use the event date as the option label
                                    $eventDate = $row['Date'];
                                    echo "<option value='$eventDate'>";
                                }
                            } else {
                                echo "<option value=''>No events found</option>";
                            }
                            ?>
                        </datalist>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <?php
    if ($show) {
        echo "<div class='container mt-5'>
                <div class='card shadow' style='max-width: 400px; margin: 0 auto;'>
                    <div class='card-header bg-primary text-white'>
                        <h2 class='card-title text-center'>Event Attendance Details</h2>
                    </div>
                    <div class='card-body'>
                        <div class='row mb-3'>
                            <div class='col'>
                                <h5 class='text-muted'>Event Name:</h5>
                                <p>$eventName</p>
                            </div>
                            <div class='col'>
                                <h5 class='text-muted'>Event Date:</h5>
                                <p>$eventDate</p>
                            </div>
                        </div>
                        <div class='row mb-3'>
                            <div class='col'>
                                <h5 class='text-muted'>Total Male Attendance:</h5>
                                <p>$male_count</p>
                            </div>
                            <div class='col'>
                                <h5 class='text-muted'>Total Female Attendance:</h5>
                                <p>$female_count</p>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col'>
                                <h5 class='text-muted'>Total Attendance:</h5>
                                <p>$total</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <br>";
    }
?>



    <!-- Bootstrap JS and jQuery (optional) -->
    <hr>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        let table = new DataTable('#myTable');
    </script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <?php

        include '../../NSS_NEW/partial/_footer.php';

?>
</body>

</html>
