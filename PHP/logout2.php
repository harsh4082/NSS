<?php
// Start or resume the session
// session_start();

// // Set the session timeout (in seconds)
// $sessionTimeout = 60; // 6 hours

// // Check if the user is logged in
// if (isset($_SESSION['timestamp']) && time() - $_SESSION['timestamp'] > $sessionTimeout) {
//     // Session has expired, destroy the session
//     session_unset();
//     session_destroy();
//     echo json_encode(['status' => 'session_expired']);
//     exit();
// }

// // Update the timestamp to the current time on each page load
// $_SESSION['timestamp'] = time();

// // Check if a logout request is received
// if (isset($_POST['action']) && $_POST['action'] === 'logout') {
//     // Perform the logout
//     session_unset();
//     session_destroy();
//     echo json_encode(['status' => 'success']);
//     exit();
// }
?>
<?php
include '../../NSS_NEW/partial/_dbconnector.php';

session_start();

if (!isset($_SESSION['Admin_loggedin']) || $_SESSION['Admin_loggedin'] != true) {
    header("location: PHP/login.php");
    exit;
}

?>

<?php

$showAlert = false;
$showError = false;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['fetchVolunteer'])) {
    $vec_no = $_POST['vec_no'];

    $existSql = "SELECT * FROM `volunteer` WHERE Vec_no = '$vec_no'";
    $result = mysqli_query($conn, $existSql);
    $numExistRows = mysqli_num_rows($result);

    if ($numExistRows > 0) {
        $showAlert = true;
        $volunteerData = mysqli_fetch_assoc($result);
    } else {
        $showError = "Volunteer ID not found.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Add your head content here -->
</head>

<body id="body">
    <br><br>
    <?php include '../../NSS_NEW/partial/_header.php'; ?>
    <br>

    <?php
    if ($showAlert) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Data fetched successfully!</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
    }
    if ($showError) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> ' . $showError . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
    }
    ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <!-- Custom Gradient Card -->
                <div class="card custom-card" style="background-color : #FFCF81;">
                    <div class="card-header">
                        <h3 class="text-center">Add Leader</h3>
                    </div>
                    <div class="card-body">
                        <form action="/NSS_NEW/PHP/index.php" method="POST">
                            <div class="form-group">
                                <label for="vec_no">Volunteer ID:</label>
                                <input type="text" class="form-control" id="vec_no" name="vec_no" required>
                            </div>
                            <button type="submit" class="btn btn-primary" name="fetchVolunteer">Fetch Volunteer Data</button>
                        </form>

                        <?php
                        if ($showAlert && isset($volunteerData)) {
                            // Display volunteer data here
                            echo '<div class="alert alert-info mt-3">
                                    <strong>Volunteer Data:</strong><br>
                                    Name: ' . $volunteerData['FULL NAME'] .  '<br>
                                    Email: ' . $volunteerData['Email'] . '<br>
                                    Vec code: ' . $volunteerData['Vec_no'] . '<br>
                                    group: ' . $volunteerData['grp_nm'] . '<br>
                                    Phone: ' . $volunteerData['phone_no'] . '
                                  </div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br><br>
    <?php include '../../NSS_NEW/partial/_footer.php'; ?>
</body>

</html>
<?php
// //Import PHPMailer classes into the global namespace
// //These must be at the top of your script, not inside a function
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\SMTP;
// use PHPMailer\PHPMailer\Exception;

// require '../../NSS_NEW/partial/Exception.php';
// require '../../NSS_NEW/partial/PHPMailer.php';
// require '../../NSS_NEW/partial/SMTP.php';

// //Load Composer's autoloader
// // require 'vendor/autoload.php';

// //Create an instance; passing `true` enables exceptions
// $mail = new PHPMailer(true);

// try {
//     //Server settings
//     $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
//     $mail->isSMTP();                                            //Send using SMTP
//     $mail->Host       = 'smtp.gmail.com.';                     //Set the SMTP server to send through
//     $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
//     $mail->Username   = 'harshsolanki2804@gmail.com';                     //SMTP username
//     $mail->Password   = 'fgda xcrb mpee fvsr';                               //SMTP password
//     $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
//     $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

//     //Recipients
//     $mail->setFrom('harshsolanki2804@gmail.com', 'Harsh');
//     $mail->addAddress('harsh.solanki.17767@ves.ac.in', 'harsh');     //Add a recipient
//     // $mail->addAddress('ellen@example.com');               //Name is optional
//     // $mail->addReplyTo('info@example.com', 'Information');
//     // $mail->addCC('cc@example.com');
//     // $mail->addBCC('bcc@example.com');

//     //Attachments
//     // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
//     // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

//     //Content
//     $mail->isHTML(true);                                  //Set email format to HTML
//     $mail->Subject = 'Email';
//     $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
//     // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

//     $mail->send();
//     echo 'Message has been sent';
// } catch (Exception $e) {
//     echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
// }
?>

