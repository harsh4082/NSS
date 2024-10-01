<?php
include '../../NSS_NEW/partial/_dbconnector.php';

session_start();

if (!isset($_SESSION['Admin_loggedin']) || $_SESSION['Admin_loggedin'] != true) {
    header("location: /NSS_NEW/PHP/login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["leader_id"])) {
    $leader_id = $_POST["leader_id"];
    
    // Retrieve volunteer details from the database based on the volunteer ID
    $query = "SELECT Name, 
                SUM(male + female) AS total_attendance,
                SUM(benificiaries) AS total_beneficiaries,
                SUM(CASE WHEN status != 'done' OR status2 != 'Done' OR benificiaries = 0 OR male = 0 OR female = 0 THEN 1 ELSE 0 END) AS pending_count
            FROM events
            WHERE Lead_no = '$leader_id'
            GROUP BY Name";  // Using GROUP BY Name to get information for each event

    $result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Statistics</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="website icon" type="png" href="/NSS_NEW/Image/NSS.png">
    <link rel="stylesheet" href="../CSS/style.css">
    <style>
        #body::-webkit-scrollbar {
            display: none;
        }

        .card {
            background-color: rgba(255, 255, 255, 0.9);
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        }

        .card-title {
            color: #333;
            /* Red font color */
        }

        .table {
            color: #333;
        }

        .table thead {
            background-color: #e74c3c;
            /* Red background for table header */
            color: #fff;
        }

        .table tbody tr:nth-child(odd) {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .table tbody tr:nth-child(even) {
            background-color: rgba(255, 255, 255, 0.2);
        }

        @media (max-width: 576px) {
            .card {
                width: 100%;
                margin-bottom: 20px;
            }
        }
    </style>
</head>

<body id="body">
    <br><br>
    <?php
    // include '../../NSS_NEW/partial/_header.php';
    require '../../NSS_NEW/partial/_dbconnector.php';
    ?>

    <div class="container mt-5">
        <!-- Card for Event Details -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Event Details</h2>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Event Name</th>
                                <th>Total Attendance</th>
                                <th>Total Beneficiaries</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Check if the query was successful
                            if ($result) {
                                // Fetch associative array
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo '<tr>';
                                    echo '<td>' . $row['Name'] . '</td>';
                                    echo '<td>' . $row['total_attendance'] . '</td>';
                                    echo '<td>' . $row['total_beneficiaries'] . '</td>';
                                    echo '<td>';
                                    
                                    if ($row['pending_count'] > 0) {
                                        echo 'Pending';
                                    } else {
                                        echo 'Completed';
                                    }

                                    echo '</td>';
                                    echo '</tr>';
                                }
                            } else {
                                // Handle the case where the query fails
                                echo '<tr><td colspan="4">Error fetching data: ' . mysqli_error($conn) . '</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <br><br><br><br>
    <!-- Your footer and script includes remain unchanged -->
    <?php
    include '../../NSS_NEW/partial/_footer.php';
    ?>

    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBv

KU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>
<?php
} else {
    echo "Invalid request.";
}
?>
