<?php
include '../../NSS_NEW/partial/_dbconnector.php';

session_start();

if (!isset($_SESSION['Admin_loggedin']) || $_SESSION['Admin_loggedin'] != true) {
    header("location: login.php");
    exit;
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Tracker</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="../CSS/style.css">
    <style>
        #body::-webkit-scrollbar {
            display: none;
        }
    </style>
</head>

<body id="body">
    <?php include '../../NSS_NEW/partial/_header.php'; ?><br><br>

    <div class="container mt-5">
        <!-- Card for Total Event Details -->
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <h2 class="card-title">Total Event Details</h2>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="myTable">
                        <thead>
                            <tr>
                                <th scope="col">S.No</th>
                                <th scope="col">Leader Name</th>
                                <th scope="col">Teacher Incharge</th>
                                <th scope="col">Total Events</th>
                                <th scope="col">Show Events</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include '../../NSS_NEW/partial/_dbconnector.php';

                            // Fetch data from the database
                            $query = "SELECT leader.LEAD_NO, leader.Name as leader_name, leader.T_incharge as teacher_incharge, COUNT(events.Name) as total_events
                                    FROM leader
                                    LEFT JOIN events ON leader.LEAD_NO = events.Lead_no
                                    GROUP BY leader.LEAD_NO";

                            $result = mysqli_query($conn, $query);

                            // Check if the query was successful
                            if ($result) {
                                echo '<tbody>';
                                $count = 1;
                                // Fetch associative array
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo '<tr>
                                         <td>' . $count . '</td>
                                         <td>' . $row['leader_name'] . '</td>
                                         <td>' . $row['teacher_incharge'] . '</td>
                                         <td>' . $row['total_events'] . '</td>
                                         <td><form action="leader_details.php" method="post">
                                                <input type="hidden" name="leader_id" value="' . $row['LEAD_NO'] . '" >
                                                <button type="submit" class="btn btn-primary">View Details</button>
                                        </form>
                                        </td>
                                        </tr>';
                                    $count++;
                                }
                                echo '</tbody>';
                            } else {
                                // Handle the case where the query fails
                                echo '<tr><td colspan="5">Error fetching data</td></tr>';
                            }

                            // Close the database connection
                            mysqli_close($conn);
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <br><br><br>

    <?php include '../../NSS_NEW/partial/_footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
