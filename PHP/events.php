<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="website icon" type="png" href="/NSS_NEW/Image/NSS.png">
    <link rel="stylesheet" href="../CSS/style.css">
    <style>
        #body::-webkit-scrollbar {
            display: none;
        }

        .card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            background-color: #f8f9fa; /* Light gray background */
            padding: 25px;
            margin-bottom: 30px;
            border: none;
            border-radius: 10px;
        }

        .card-title {
            background-color: #007bff; /* Blue background */
            color: #fff; /* White text */
            padding: 10px;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            margin-bottom: 20px;
        }

        .table {
            background-color: #fff; /* White background */
            border-radius: 10px;
        }

        .table th,
        .table td {
            border: none; /* Remove table borders */
        }

        .table thead th {
            background-color: #007bff; /* Blue background for table header */
            color: #fff; /* White text */
        }

        .left {
            text-align: left;
            font-size: large;
            font-weight: bold;
        }
    </style>
</head>

<body id="body">
    <?php
    include '../../NSS_NEW/partial/_header.php';
    require '../../NSS_NEW/partial/_dbconnector.php';
    ?>
    <br><br><br>
    <?php
    require '../../NSS_NEW/partial/_dbconnector.php';

    $sql = "SELECT DISTINCT proj_name, Level FROM events ORDER BY proj_name, Level";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $projectName = $row["proj_name"];
            $level = $row["Level"];

            // Query to count the total number of events for this project and level
            $countSql = "SELECT COUNT(*) as total FROM events WHERE proj_name = '$projectName' AND Level = '$level'";
            $countResult = $conn->query($countSql);
            $countRow = $countResult->fetch_assoc();
            $totalEvents = $countRow['total'];

            echo '<div class="container mt-5">
            <div class="card">
                <div class="card-title text-center">' . $projectName . ' - Level ' . $level . '</div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Event Name</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>';

            $innerSql = "SELECT Name, Date FROM events WHERE proj_name = '$projectName' AND Level = '$level' ORDER BY Date";
            $innerResult = $conn->query($innerSql);

            if ($innerResult->num_rows > 0) {
                while ($innerRow = $innerResult->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . $innerRow["Name"] . '</td>';
                    echo '<td>' . $innerRow["Date"] . '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="2">No events found for ' . $projectName . ' - Level ' . $level . '</td></tr>';
            }

            echo '</tbody></table>';
            // Display the total number of events
            echo '<p class="left">Total Events in ' . $projectName . ': ' . $totalEvents . '</p>';
            echo '</div></div></div>';
        }
    } else {
        echo '<div class="container mt-5">
        <div class="card">
            <div class="card-title text-center">No events found.</div>
        </div>
    </div>';
    }
    ?>
    <br><br><br><br><br><br>
    <?php
    include '../../NSS_NEW/partial/_footer.php';
    ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
