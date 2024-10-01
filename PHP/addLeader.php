<?php
include '../../NSS_NEW/partial/_dbconnector.php';

session_start();

if (!isset($_SESSION['Admin_loggedin']) || $_SESSION['Admin_loggedin'] != true) {
    header("location: login.php");
    exit;
}

// Assuming you have a database connection
require '../../NSS_NEW/partial/_dbconnector.php';
require 'C:/xampp/htdocs/NSS_NEW/PHP/new3.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Function to generate random password
function generatePassword($length = 8)
{
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $password .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $password;
}

// Fetch data based on the provided vec_no and insert leader details
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["fetchVolunteer"])) {
    $vec_no = $_POST["vec_no"];
    $leader_id = $_POST["leader_id"]; // Added leader ID field

    // Fetch volunteer details
    $sql_fetch_volunteer = "SELECT * FROM student WHERE student_id = '$vec_no'";
    $result_fetch_volunteer = $conn->query($sql_fetch_volunteer);
    require 'C:/xampp/htdocs/NSS_NEW/PHP/new3.php';
    if ($result_fetch_volunteer->num_rows > 0) {
        // Loop through each volunteer
        while ($row_fetch_volunteer = $result_fetch_volunteer->fetch_assoc()) {
            $Email = $row_fetch_volunteer["email"];
            $name = $row_fetch_volunteer["fname"];
            // $group = $row_fetch_volunteer["grp_nm"];
            //$teacher_incharge = $_SESSION['username']; // Assuming the session variable for teacher in charge is 'username'
            $teacher_incharge = $T_incharge; // Assuming the session variable for teacher in charge is 'username'

            // Generate random password
            $password = generatePassword();

            // Insert leader details into leader table
            $sql_insert_leader = "INSERT INTO leader (LEAD_NO, Lead_id, Name, Email, username, password, T_incharge, `grp_nm`) VALUES ('$vec_no', '$leader_id', '$name', '$Email', NULL, '$password',  '$teacher_incharge','$group')";
            if ($conn->query($sql_insert_leader) === TRUE) {
                // Load PHPMailer classes
                require '../../NSS_NEW/partial/Exception.php';
                require '../../NSS_NEW/partial/PHPMailer.php';
                require '../../NSS_NEW/partial/SMTP.php';

                // Create a PHPMailer instance
                $mail = new PHPMailer(true);

                try {
                    // Server settings
                    $mail->isSMTP();
                    $mail->Host       = 'smtp.gmail.com';
                    $mail->SMTPAuth   = true;
                    $mail->Username   = 'harshsolanki2804@gmail.com'; // Your Gmail email address
                    $mail->Password   = 'fgda xcrb mpee fvsr'; // Your Gmail password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                    $mail->Port       = 465;

                    // Set email parameters
                    $mail->setFrom('harshsolanki2804@gmail.com', 'Harsh'); // Your name and email address
                    $mail->addAddress($Email, $name); // Recipient email and name
                    $mail->isHTML(true);

                    // Email content
                    $mail->Subject = 'Congratulations on Becoming the Leader!';
                    $mail->Body    = "<p>Hi $name,</p>
                                    <p>Congratulations on being selected as the leader for our upcoming batch! 🌟 Your dedication and hard work have truly set you apart, and we are thrilled to have you in this leadership role.</p>
                                    <p>As a leader, you play a crucial role in shaping the experience for everyone in the group. Your enthusiasm and commitment are truly inspiring, and we are confident that you will lead with grace and make a positive impact.</p>
                                    <p>We look forward to seeing the amazing things you will accomplish in your new role. If you have any questions or need support, please feel free to reach out. Together, let's make this batch unforgettable!</p>
                                    <p>Your Leader ID: $leader_id</p>
                                    <p>Please <a href='http://localhost/NSS_NEW/PHP/leader_login.php'>click here</a> to make your username or password.</p>
                                    <p>Congratulations once again, and best of luck on this exciting journey!</p>
                                    <p>Warm regards,<br>NSS National Service Scheme</p>";

                    // Send email
                    $mail->send();

                    // Success message
                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Email sent successfully!</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                          </div>';
                } catch (Exception $e) {
                    // Error message
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            } else {
                echo "Error: " . $sql_insert_leader . "<br>" . $conn->error;
            }
        }
    } else {
        echo "No volunteer found with the provided Volunteer Number.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="website icon" type="png" href="/NSS_NEW/Image/NSS.png">
    <title>NSS</title>
    <link rel="stylesheet" href="CSS/style.css">
    <style>
        /* #body {    
            background-color: #ebcc69;
            font-family: 'Arial', sans-serif;
            min-height: 100vh;
            margin: 0;
        
        } */
        #body::-webkit-scrollbar {
            display: none;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>

<body id="body">
    <br><br>
    <?php include '../../NSS_NEW/partial/_header.php'; ?>
    <br>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <!-- Custom Gradient Card -->
                <div class="card custom-card" style="background-color: #FFCF81;">
                    <div class="card-header">
                        <h3 class="text-center">Add Leader</h3>
                    </div>
                    <div class="card-body">
                        <form action="/NSS_NEW/PHP/addLeader.php" method="POST">
                            <div class="form-group">
                                <label for="vec_no">Enter Volunteer ID:</label>
                                <input type="text" id="vecNoInput" class="form-control" name="vec_no" required list="volunteerIds" autocomplete="off">
                                <datalist id="volunteerIds">
                                    <!-- PHP code to fetch and display student IDs -->
                                    <?php
                                    $sql_fetch_volunteer = "SELECT * FROM student";
                                    $result_volunteer = mysqli_query($conn, $sql_fetch_volunteer);
                                    if (mysqli_num_rows($result_volunteer) > 0) {
                                        while ($row = mysqli_fetch_assoc($result_volunteer)) {
                                            echo '<option value="' . $row['student_id'] . '">';
                                        }
                                    }
                                    ?>
                                </datalist>
                            </div>

                            <div class="form-group">
                                <label for="leader_id">Enter Leader ID:</label>
                                <input type="text" id="leaderIdInput" class="form-control" name="leader_id" required>
                            </div>
                            <br>
                            <button type="submit" class="btn btn-primary" name="fetchVolunteer">Send Email</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br><br><br>
    <?php include '../../NSS_NEW/partial/_footer.php'; ?>
</body>

</html>