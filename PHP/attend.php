<?php
include '../../NSS_NEW/partial/_dbconnector.php';
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header('location: login.php');
}
$username = $_SESSION['username'];


$errors = array();  // Initialize an array to store validation errors

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate inputString
    if (isset($_POST["inputString"])) {
        $inputString = $_POST["inputString"];

        // Validate double comma and space
        if (strpos($inputString, ",,") !== false || strpos($inputString, "  ") !== false) {
            $errors[] = "Volunteer details cannot contain double commas or consecutive spaces.";
        }

        // Check for repeated numbers
        $vecNumbers = explode(",", $inputString);
        $uniqueVecNumbers = array_unique($vecNumbers);
        if (count($vecNumbers) != count($uniqueVecNumbers)) {
            $errors[] = "Volunteer details cannot contain repeated numbers.";
        }

        // Check if there are any validation errors related to commas, spaces, or repeated numbers
        if (empty($errors)) {
            // Proceed to check for other validations and processing
            $eventName = $_POST["Event_nm"];
            $position = $_POST["position"];
            $eventDate = $_POST["date"];
            $eventLevel = $_POST["level"];
            $eventHour = $_POST["hour"];
            $lead_id = $_POST["lead_id"];
            $Proj_name = $_POST["Proj_name"];

            if ($conn) {
                $insertAttendQuery = "INSERT INTO attend (Name,Position ,Date, proj_name , Level, Hours, vec_no, lead_id, gen) VALUES (?,?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($insertAttendQuery);
    
                $updateVolunteerQuery = "UPDATE student SET hours = hours + ? WHERE `id` = ?";
                $updateStmt = $conn->prepare($updateVolunteerQuery);
    
                // Initialize counts
                $maleCount = 0;
                $femaleCount = 0;
    
                foreach ($vecNumbers as $vecNumber) {
                    // Fetch gender from the volunteer table based on Sr.No
                    $genderQuery = "SELECT gender FROM student WHERE `id` = ?";
                    $genderStmt = $conn->prepare($genderQuery);
                    $genderStmt->bind_param("s", $vecNumber);
                    $genderStmt->execute();
                    $genderResult = $genderStmt->get_result();
                    $genderRow = $genderResult->fetch_assoc();
                    $gender = $genderRow["gender"];
    
                    $stmt->bind_param("sssssdsss", $eventName,$position, $eventDate,$Proj_name, $eventLevel, $eventHour, $vecNumber, $lead_id, $gender);
                    if ($stmt->execute()) {
                        // Inserted successfully, now update volunteer hours
                        $updateStmt->bind_param("ds", $eventHour, $vecNumber);
                        $updateStmt->execute();
    
                        // Update counts based on gender
                        if ($gender === "Male") {
                            $maleCount++;
                        } elseif ($gender === "Female") {
                            $femaleCount++;
                        }
                    } else {
                        echo "Error inserting record into the database: " . $stmt->error . "<br>";
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
    <link rel="website icon" type="png" href="/NSS_NEW/Image/NSS.png">

    <!-- Custom CSS for styling -->
    <link rel="stylesheet" href="../CSS/style.css">
    <style>
    #body::-webkit-scrollbar {
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
</head>

<body id="body">
    <?php
     include '../../NSS_NEW/partial/_header.php';
    include '../../NSS_NEW/partial/_dbconnector.php';
    require '../../NSS_NEW/PHP/new2.php';

    // Display validation errors after the header
    if (!empty($errors)) {
        echo "<br><br><br><br>";
        echo "<div class='container mt-3'>";
        echo "<div class='alert alert-danger'>";
        foreach ($errors as $error) {
            echo "<p>{$error}</p>";
        }
        echo "</div>";
        echo "</div>";
    }
    ?>
    <br>
    <br><br>
    <div class="box container">
        <div class="card">
            <div class="card-header" style="background-color: #4D4C7D; color: #fff; text-align: center;">
                <h2 class="card-title">Attendance of Volunteers</h2>
            </div>
            <div class="card-body">
                <form id="attendanceForm" method="post" action="/NSS_NEW/PHP/attend.php" onsubmit="showLoader()">
                    <div class="form-group">
                        <label for="Event_nm">Event Name</label>
                        <select required list="events" class="form-control" id="Event_nm" name="Event_nm">
                            <option value="" disabled selected>Select Event</option>

                            <?php
                            $sql = "SELECT Name FROM events WHERE Status = 'done' AND status2 = 'Not Done'";
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
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="position">Position</label>
                        <select required class="form-control" id="position" name="position">
                            <option value="" disabled selected>Select Position</option>
                            <option value="Participaints">Participants</option>
                            <option value="Organizing Team">Organizing Team</option>
                        </select>
                    </div>


                    <div class="form-group">
                        <label for="date">Date</label>
                        <select required autocomplete="off" list="dates" class="form-control" id="date" name="date">
                            <option value="" disabled selected>Select Date</option>
                            <?php
                            $sql = "SELECT Date FROM events WHERE Status = 'done' AND status2 = 'Not Done'";
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
                        </select>
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
                            <option value="" disabled selected>Select level</option>
                            <option value="College Level">College Level</option>
                            <option value="Area Level">Area Level</option>
                            <option value="District Level">District Level</option>
                            <option value="University Level">University Level</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="hour">Hours</label>
                        <input required autocomplete="off" type="number" class="form-control" id="hours" name="hour"
                            value="">
                    </div>
                    <div class="form-group">
                        <label for="hour">Volunteer details</label>
                        <textarea class="form-control" id="inputString" name="inputString"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="lead_id">Leader_id</label>
                        <?php
                        // include 'C:/xampp/htdocs/NSS_NEW/PHP/new2.php';
                        ?>
                        <input required autocomplete="off" class="form-control" id="lead_id" name="lead_id"
                            value=<?php echo $lead_no; ?> readonly>
                    </div>

                    <button type='submit' class='btn btn-warning'>Submit</button>
                </form>
                <div id="loader" style="display: none;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <p class="mt-2">Processing...</p>
                </div>
                <div id="message" style="display: none;"></div>
            </div>
        </div>
    </div>
    <br><br>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- <script>
    $(document).ready(function() {
        $('#attendanceForm').on('submit', function(e) {
            e.preventDefault();
            //console.log(e); // Check if the form submission is triggered
            $('#loader').show();
            $('#message').hide();

            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: function(response) {
                    console.log("Success:", response); // Inspect the response
                    $('#loader').hide();
                    $('#message').removeClass('alert-danger').addClass('alert-success')
                        .html(response).show();
                },
                error: function(error) {
                    console.log("Error:",
                    error); // Check if there's an error in the AJAX request
                    $('#loader').hide();
                    $('#message').removeClass('alert-success').addClass('alert-danger')
                        .html('Error occurred. Please try again.').show();
                }
            });
        });
    });
    </script> -->
    <script>
        function showLoader() {
            document.getElementById('loader').style.display = 'block';
            document.getElementById('message').style.display = 'none';
        }
    </script>

    <?php include '../../NSS_NEW/partial/_footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.5.2/dist/js/bootstrap.min.js"></script>
</body>

</html>