<?php
include '../../NSS_NEW/partial/_dbconnector.php';
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header('location: leader_login.php');
}

?>

<?php
require '../../NSS_NEW/partial/_dbconnector.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["Event_nm"], $_POST["date"], $_POST["level"], $_POST["hour"], $_POST["inputString"], $_POST["lead_id"])) {
        $eventName = $_POST["Event_nm"];
        $eventDate = $_POST["date"];
        $eventLevel = $_POST["level"];
        $eventHour = $_POST["hour"];
        $vecNumbers = explode(",", $_POST["inputString"]);
        $lead_id = $_POST["lead_id"];   
        $Proj_name = $_POST["Proj_name"];

        if ($conn) {
            $insertAttendQuery = "INSERT INTO attend (Name, Date, proj_name , Level, Hours, vec_no, lead_id, gen) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($insertAttendQuery);

            $updateVolunteerQuery = "UPDATE volunteer SET hours = hours + ? WHERE `Sr.No` = ?";
            $updateStmt = $conn->prepare($updateVolunteerQuery);

            // Initialize counts
            $maleCount = 0;
            $femaleCount = 0;

            foreach ($vecNumbers as $vecNumber) {
                // Fetch gender from the volunteer table based on Sr.No
                $genderQuery = "SELECT gender FROM volunteer WHERE `Sr.No` = ?";
                $genderStmt = $conn->prepare($genderQuery);
                $genderStmt->bind_param("s", $vecNumber);
                $genderStmt->execute();
                $genderResult = $genderStmt->get_result();
                
                // Check if gender is fetched successfully
                if ($genderRow = $genderResult->fetch_assoc()) {
                    $gender = $genderRow["gender"];
                    
                    // Validate gender values and assign appropriate counts
                    if ($gender === "M" || $gender === "F") {
                        if ($gender === "M") {
                            $maleCount++;
                        } elseif ($gender === "F") {
                            $femaleCount++;
                        }
                    } else {
                        // Handle invalid gender values
                        echo "Invalid gender value for volunteer with Sr.No: $vecNumber<br>";
                        continue; // Skip to the next volunteer
                    }

                    // Insert attendance record
                    $stmt->bind_param("ssssdsss", $eventName, $eventDate, $Proj_name, $eventLevel, $eventHour, $vecNumber, $lead_id, $gender);
                    if ($stmt->execute()) {
                        // Update volunteer hours
                        $updateStmt->bind_param("ds", $eventHour, $vecNumber);
                        $updateStmt->execute();
                    } else {
                        echo "Error inserting record into the database: " . $stmt->error . "<br>";
                    }
                } else {
                    // Handle errors in fetching gender
                    echo "Error fetching gender for volunteer with Sr.No: $vecNumber<br>";
                }
            }

            // Update the event table with the total counts
            $updateEventQuery = "UPDATE events SET male = male + ?, female = female + ? WHERE Name = ? AND Date = ?";
            $updateEventStmt = $conn->prepare($updateEventQuery);
            $updateEventStmt->bind_param("iiss", $maleCount, $femaleCount, $eventName, $eventDate);
            $updateEventStmt->execute();
        } else {
            echo "Database connection failed.";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hello</title>

    <!-- Include Bootstrap CSS and Google Fonts -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <!-- Custom CSS for styling -->
    <link rel="stylesheet" href="../CSS/style.css">
    <style>  
    #body::-webkit-scrollbar{
            display: none;
        }      
        .card {
            margin: 0 auto;
            margin-top: 20px;
            max-width: 800px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            border-radius: 20px;
        }

        .card-title {
            font-size: 24px;
            padding: 20px;
            color: black;
        }

        .form-group label {
            font-weight: 700;
        }

        .form-control {
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
    <link rel="website icon" type="png" href="/NSS_NEW/Image/NSS.png">
</head>

<body id="body">
    <?php
    include '../..//NSS_NEW/partial/_header.php';
    include '../../NSS_NEW/partial/_dbconnector.php';
    require 'new2.php';
    ?>
    <br><br>
    <div class="box container mt-5">
        <div class="card">
            <div class="card-header" style="background-color: #007bff; color: #fff; text-align: center;">
                <h2 class="card-title">Attendance of Volunteers</h2>
            </div>
            <div class="card-body">
                <form method="post" action="/NSS_NEW/PHP/attend.php">
                    <div class="form-group">
                        <label for="Event_nm">Event Name</label>
                        <input list="events" class="form-control" id="Event_nm" name="Event_nm">
                        <datalist id="events">
                            <?php
                            $sql = "SELECT Name FROM events WHERE status = 'done'";
                            $result = mysqli_query($conn, $sql);

                            if ($result) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $eventName = $row['Name'];
                                    echo "<option value='$eventName'>$eventName</option>";
                                }
                            } else {
                                echo "<option value=''>No events found</option>";
                            }
                            ?>
                        </datalist>
                    </div>

                    <div class="form-group">
                        <label for="date">Date</label>
                        <input list="dates" class="form-control" id="date" name="date">
                        <datalist id="dates">
                            <?php
                            $sql = "SELECT Date FROM events WHERE status = 'done'";
                            $result = mysqli_query($conn, $sql);

                            if ($result) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $eventDate = $row['Date'];
                                    echo "<option value='$eventDate'>$eventDate</option>";
                                }
                            } else {
                                echo "<option value=''>No events found</option>";
                            }
                            ?>
                        </datalist>
                    </div>
                    <div class="form-group">
                        <label for="project">Project Name</label>
                        <select class="form-control" id="project" name="Proj_name">
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
                        <select class="form-control" id="levelSelect" name="level">
                            <option value="College Level">College Level</option>
                            <option value="Area Level">Area Level</option>
                            <option value="District Level">District Level</option>
                            <option value="University Level">University Level</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="hour">Hours</label>
                        <input type="number" class="form-control" id="hours" name="hour" value="0">
                    </div>
                    <div class="form-group">
                        <label for="hour">Volunteer details</label>
                        <textarea class="form-control" id="inputString" name="inputString"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="lead_id">Leader_id</label>
                        <?php
                        include 'new2.php';
                        ?>
                        <input class="form-control" id="lead_id" name="lead_id" value=<?php echo $lead_no; ?> readonly>
                    </div>

                    <br>
                    <hr>
                    <button type='submit' class='btn btn-primary'>Submit</button>
                </form>
            </div>
        </div>
    </div>
    <br><br>
    
    <?php include '../../NSS_NEW/partial/_footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.5.2/dist/js/bootstrap.min.js"></script>
</body>

</html>
