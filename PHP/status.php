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
$showAlert = true;

// Check if all events are done
$allEventsDone = false;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["event_name"]) && isset($_POST["event_date"])) {
    $eventName = $_POST["event_name"];
    $eventDate = $_POST["event_date"];

    // Update the status to "done" for the selected event and date
    $updateQuery = "UPDATE events SET status = 'done' WHERE Name = '$eventName' AND Date = '$eventDate'";
    if (mysqli_query($conn, $updateQuery)) {
        $showAlert = false; // Set to false after marking one event as done
    } else {
        echo "Error updating status: " . mysqli_error($conn);
    }
}
require '../../NSS_NEW/PHP/new3.php';
// echo $T_incharge;
// Fetch events with status "In Progress" from the event table
$query = "SELECT * FROM events WHERE status = 'In Progress' AND Teacher_Incharge = '$T_incharge'";
$result = mysqli_query($conn, $query);

// Check if there are any events in progress
$inProgressEventsExist = (mysqli_num_rows($result) > 0);

// Check if all events are done
$queryAllDone = "SELECT COUNT(*) as count FROM events WHERE status = 'In Progress' AND Teacher_Incharge = '$T_incharge'";
$resultAllDone = mysqli_query($conn, $queryAllDone);
$row = mysqli_fetch_assoc($resultAllDone);
if ($row['count'] == 0) {
    $allEventsDone = true;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Include Bootstrap and other necessary CSS/JS libraries -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="../CSS/style.css">
    <style>
        #body::-webkit-scrollbar{
            display: none;
        }
        .custom-card {
            margin: 10px;
            border: 1px solid #ccc;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .custom-card .card-body {
            padding: 15px;
        }
        table.table thead th {
        background-color: #007BFF;
        color: white;
    }

    /* Style the table rows */
    table.table tbody tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    /* Style the "Done Events" heading */
    h3.mt-4 {
        color: #007BFF;
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
        <?php if ($allEventsDone) { ?>
        <!-- Card for "All events are done" -->
        <div class="card custom-card">
            <div class="card-body">
                <h5 class="card-title">All Events Are Done</h5>
                <p>All events have been marked as done.</p>
            </div>
        </div>
        <?php } else if ($inProgressEventsExist) { ?>
        <!-- Card for updating the status -->
        <div class="row">
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <div class="col-md-6">
                <div class="card custom-card">
                    <div class="card-body">
                        <h5 class="card-title">Event Details</h5>
                        <p><strong>Event Name:</strong> <?php echo $row['Name']; ?></p>
                        <p><strong>Date:</strong> <?php echo $row['Date']; ?></p>
                        <p><strong>Level</strong> <?php echo $row['Level']; ?></p>
                        <p><strong>Teacher in Charge:</strong> <?php echo $row['Teacher_Incharge']; ?></p>
                        <form method="post">
                            <input type="hidden" name="event_name" value="<?php echo $row['Name']; ?>">
                            <input type="hidden" name="event_date" value="<?php echo $row['Date']; ?>">
                            <button type="submit" class="btn btn-primary">Mark as Done</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
        <?php } ?>
    </div>

  
<hr>

<?php
// Fetch events with status "done" from the event table
$queryDoneEvents = "SELECT * FROM events WHERE status = 'done'";
$resultDoneEvents = mysqli_query($conn, $queryDoneEvents);
?>

<!-- Table for "Done" Events -->
<div class="container mt-5">
    <h3 class="mt-4">Done Events</h3>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Event Name</th>
                    <th>Date</th>
                    <th>Teacher In Charge</th>
                    <th>Level</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($resultDoneEvents)) { ?>
                    <tr>
                        <td><?php echo $row['Name']; ?></td>
                        <td><?php echo $row['Date']; ?></td>
                        <td><?php echo $row['Teacher_Incharge']; ?></td>
                        <td><?php echo $row['Level']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<?php

    include '../../NSS_NEW/partial/_footer.php';

    ?>

</body>

</html>
