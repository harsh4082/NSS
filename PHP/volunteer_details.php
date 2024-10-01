<?php
// volunteer_details.php
include '../../NSS_NEW/partial/_dbconnector.php';
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: /NSS_NEW/PHP/leader_login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["volunteer_id"])) {
    $volunteer_id = $_POST["volunteer_id"];
    
    // Retrieve volunteer details from the database based on the volunteer ID
    $sql = "SELECT * FROM student WHERE student_id = '$volunteer_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $volunteer = $result->fetch_assoc();
        // Display volunteer details here
        $sr_no = $volunteer['id'];
        // Add more details as needed
    } else {
        echo "Volunteer not found.";
    }
} else {
    echo "Invalid request.";
}

include '../../NSS_NEW/partial/_dbconnector.php';

require 'new.php';

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
        #body::-webkit-scrollbar{
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

    <div class="container-fluid mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card p-4">
                    <h2 class="text-center card-title mb-4">Event Statistics</h2>

                    <div class="card mb-4">
                        <div class="card-body">
                            <h6 class="card-title"><strong>Name</strong> : <strong><?php echo  $volunteer['fname'] ; ?></strong> </h6>
                            <h6 class="card-title"><strong>ID</strong> : <strong><?php echo  $volunteer['student_id'] ; ?></strong> </h6>
                        </div>
                    </div>

                    <!-- Total Hours Card -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title"><strong>Total Hours</strong></h5>
                            <p class="card-text" style="font-size: large;"><strong> <?php echo  $volunteer['hours'] ; ?> Hours</strong>
                            </p>
                        </div>
                    </div>
                    <div class="card mb-4">
                           
                    <!-- Total Events Table -->
                    <div class="container mt-5">
                        <?php
                        $level = "College Level"; // Update this with the desired level
                        $sql = "SELECT DISTINCT p.Proj_name
            FROM attend a
            LEFT JOIN project p ON a.Proj_name = p.Proj_name
            WHERE a.Level = '$level' AND a.vec_no = '$sr_no'";
                        $result = mysqli_query($conn, $sql);

                        if ($result) {
                            // Create a single card to hold all project cards
                            echo "<div class='card mb-3'>
                <div class='card-body'>
                    <h5 class='card-title'>$level</h5>";

                            while ($row = mysqli_fetch_assoc($result)) {
                                $proj_name = $row['Proj_name'];

                                // Card for each project
                                echo "<div class='card mb-3'>
                    <div class='card-body'>
                        <h6 class='card-subtitle mb-2 text-muted'>Events in Project: $proj_name</h6>
                        <table class='table'>
                            <thead>
                                <tr>
                                    <th>sr no</th>
                                    <th>Date</th>
                                    <th>Event Name</th>
                                    <th>Hours</th>
                                </tr>
                            </thead>
                            <tbody>";

                                $proj_sql = "SELECT a.*, p.Proj_name
                         FROM attend a
                         LEFT JOIN project p ON a.proj_name = p.Proj_name
                         WHERE a.Level = '$level' AND a.vec_no = '$sr_no' AND a.Proj_name = '$proj_name'";
                                $proj_result = mysqli_query($conn, $proj_sql);

                                if ($proj_result) {
                                    if (mysqli_num_rows($proj_result) > 0) {
                                        $sno = 0;
                                        while ($proj_row = mysqli_fetch_assoc($proj_result)) {
                                            $sno = $sno + 1;
                                            echo "
                        <tr>
                            <td>" . $sno . "</td>
                            <td>" . $proj_row['Date'] . "</td> 
                            <td>" . $proj_row['Name'] . "</td>
                            <td>" . $proj_row['Hours'] . "</td>
                        </tr>";
                                        }
                                    } else {
                                        echo "No events found for Project: $proj_name.";
                                    }
                                } else {
                                    echo "Error fetching events: " . mysqli_error($conn);
                                }

                                echo "</tbody>
                  </table>
                  </div>
                  </div>";
                            }

                            // Close the single card that holds all project cards
                            echo "</div></div>";
                        } else {
                            echo "Error fetching projects: " . mysqli_error($conn);
                        }
                        ?>

                    </div>
                    <div class="container mt-5">
                        <?php
                        $level = "Area level"; // Update this with the desired level
                        $sql = "SELECT DISTINCT p.Proj_name
            FROM attend a
            LEFT JOIN project p ON a.Proj_name = p.Proj_name
            WHERE a.Level = '$level' AND a.vec_no = '$sr_no'";
                        $result = mysqli_query($conn, $sql);

                        if ($result) {
                            // Create a single card to hold all project cards
                            echo "<div class='card mb-3'>
                <div class='card-body'>
                    <h5 class='card-title'>$level</h5>";

                            while ($row = mysqli_fetch_assoc($result)) {
                                $proj_name = $row['Proj_name'];

                                // Card for each project
                                echo "<div class='card mb-3'>
                    <div class='card-body'>
                        <h6 class='card-subtitle mb-2 text-muted'>Events in Project: $proj_name</h6>
                        <table class='table'>
                            <thead>
                                <tr>
                                    <th>sr no</th>
                                    <th>Date</th>
                                    <th>Event Name</th>
                                    <th>Hours</th>
                                </tr>
                            </thead>
                            <tbody>";

                                $proj_sql = "SELECT a.*, p.Proj_name
                         FROM attend a
                         LEFT JOIN project p ON a.proj_name = p.Proj_name
                         WHERE a.Level = '$level' AND a.vec_no = '$sr_no' AND a.Proj_name = '$proj_name'";
                                $proj_result = mysqli_query($conn, $proj_sql);

                                if ($proj_result) {
                                    if (mysqli_num_rows($proj_result) > 0) {
                                        $sno = 0;
                                        while ($proj_row = mysqli_fetch_assoc($proj_result)) {
                                            $sno = $sno + 1;
                                            echo "
                        <tr>
                            <td>" . $sno . "</td>
                            <td>" . $proj_row['Date'] . "</td> 
                            <td>" . $proj_row['Name'] . "</td>
                            <td>" . $proj_row['Hours'] . "</td>
                        </tr>";
                                        }
                                    } else {
                                        echo "No events found for Project: $proj_name.";
                                    }
                                } else {
                                    echo "Error fetching events: " . mysqli_error($conn);
                                }

                                echo "</tbody>
                  </table>
                  </div>
                  </div>";
                            }

                            // Close the single card that holds all project cards
                            echo "</div></div>";
                        } else {
                            echo "Error fetching projects: " . mysqli_error($conn);
                        }
                        ?>
                    </div>
                    <div class="container mt-5">
                        <?php
                        $level = "District Level"; // Update this with the desired level
                        $sql = "SELECT DISTINCT p.Proj_name
            FROM attend a
            LEFT JOIN project p ON a.Proj_name = p.Proj_name
            WHERE a.Level = '$level' AND a.vec_no = '$sr_no'";
                        $result = mysqli_query($conn, $sql);

                        if ($result) {
                            // Create a single card to hold all project cards
                            echo "<div class='card mb-3'>
                <div class='card-body'>
                    <h5 class='card-title'>$level</h5>";

                            while ($row = mysqli_fetch_assoc($result)) {
                                $proj_name = $row['Proj_name'];

                                // Card for each project
                                echo "<div class='card mb-3'>
                    <div class='card-body'>
                        <h6 class='card-subtitle mb-2 text-muted'>Events in Project: $proj_name</h6>
                        <table class='table'>
                            <thead>
                                <tr>
                                    <th>sr no</th>
                                    <th>Date</th>
                                    <th>Event Name</th>
                                    <th>Hours</th>
                                </tr>
                            </thead>
                            <tbody>";

                                $proj_sql = "SELECT a.*, p.Proj_name
                         FROM attend a
                         LEFT JOIN project p ON a.proj_name = p.Proj_name
                         WHERE a.Level = '$level' AND a.vec_no = '$sr_no' AND a.Proj_name = '$proj_name'";
                                $proj_result = mysqli_query($conn, $proj_sql);

                                if ($proj_result) {
                                    if (mysqli_num_rows($proj_result) > 0) {
                                        $sno = 0;
                                        while ($proj_row = mysqli_fetch_assoc($proj_result)) {
                                            $sno = $sno + 1;
                                            echo "
                        <tr>
                            <td>" . $sno . "</td>
                            <td>" . $proj_row['Date'] . "</td> 
                            <td>" . $proj_row['Name'] . "</td>
                            <td>" . $proj_row['Hours'] . "</td>
                        </tr>";
                                        }
                                    } else {
                                        echo "No events found for Project: $proj_name.";
                                    }
                                } else {
                                    echo "Error fetching events: " . mysqli_error($conn);
                                }

                                echo "</tbody>
                  </table>
                  </div>
                  </div>";
                            }

                            // Close the single card that holds all project cards
                            echo "</div></div>";
                        } else {
                            echo "Error fetching projects: " . mysqli_error($conn);
                        }
                        ?>

                    </div>
                    <div class="container mt-5">
                        <?php
                        $level = "University Level"; // Update this with the desired level
                        $sql = "SELECT DISTINCT p.Proj_name
            FROM attend a
            LEFT JOIN project p ON a.Proj_name = p.Proj_name
            WHERE a.Level = '$level' AND a.vec_no = '$sr_no'";
                        $result = mysqli_query($conn, $sql);

                        if ($result) {
                            // Create a single card to hold all project cards
                            echo "<div class='card mb-3'>
                <div class='card-body'>
                    <h5 class='card-title'>$level</h5>";

                            while ($row = mysqli_fetch_assoc($result)) {
                                $proj_name = $row['Proj_name'];

                                // Card for each project
                                echo "<div class='card mb-3'>
                    <div class='card-body'>
                        <h6 class='card-subtitle mb-2 text-muted'>Events in Project: $proj_name</h6>
                        <table class='table'>
                            <thead>
                                <tr>
                                    <th>sr no</th>
                                    <th>Date</th>
                                    <th>Event Name</th>
                                    <th>Hours</th>
                                </tr>
                            </thead>
                            <tbody>";

                                $proj_sql = "SELECT a.*, p.Proj_name
                         FROM attend a
                         LEFT JOIN project p ON a.proj_name = p.Proj_name
                         WHERE a.Level = '$level' AND a.vec_no = '$sr_no' AND a.Proj_name = '$proj_name'";
                                $proj_result = mysqli_query($conn, $proj_sql);

                                if ($proj_result) {
                                    if (mysqli_num_rows($proj_result) > 0) {
                                        $sno = 0;
                                        while ($proj_row = mysqli_fetch_assoc($proj_result)) {
                                            $sno = $sno + 1;
                                            echo "
                        <tr>
                            <td>" . $sno . "</td>
                            <td>" . $proj_row['Date'] . "</td> 
                            <td>" . $proj_row['Name'] . "</td>
                            <td>" . $proj_row['Hours'] . "</td>
                        </tr>";
                                        }
                                    } else {
                                        echo "No events found for Project: $proj_name.";
                                    }
                                } else {
                                    echo "Error fetching events: " . mysqli_error($conn);
                                }

                                echo "</tbody>
                  </table>
                  </div>
                  </div>";
                            }

                            // Close the single card that holds all project cards
                            echo "</div></div>";
                        } else {
                            echo "Error fetching projects: " . mysqli_error($conn);
                        }
                        ?>
                    </div>

                </div>

            </div>
        </div>
    </div>
    </div>
                        
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Donut Chart -->


    <script>
    // Use PHP values to set data for the donut chart
    const hours = <?php echo $hours; ?>;
    let color, remainingHours;

    if (hours >= 120) {
        color = 'green';
        remainingHours = 0;
    } else if (hours > 100) {
        color = 'orange';
        remainingHours = 120 - hours;
    } else if (hours > 60) {
        color = 'blue';
        remainingHours = 120 - hours;
    } else {
        color = 'red';
        remainingHours = 120 - hours;
    }

    const donutData = {
        datasets: [{
            data: [hours, remainingHours],
            backgroundColor: [color, '#e0e0e0']
        }]
    };

    const donutCtx = document.getElementById('donutChart').getContext('2d');
    new Chart(donutCtx, {
        type: 'doughnut',
        data: donutData,
        options: {
            cutoutPercentage: 80,
            responsive: true,
            // maintainAspectRatio :true,
            aspectRatio : 3,
            legend: {
                display: false
            },
            title: {
                display: true,
                text: 'Volunteer Hours'
            }
        }
    });
    </script>
    <br><br><br><br>
    <!-- Your footer and script includes remain unchanged -->
    <?php
    include '../../NSS_NEW/partial/_footer.php';
    ?>

    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

</body>

</html>