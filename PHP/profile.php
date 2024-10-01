<?php
include '../../NSS_NEW/partial/_dbconnector.php';

session_start();

if (!isset($_SESSION['vol_loggedin']) || $_SESSION['vol_loggedin'] != true) {
    header("location: login.php");
    exit;
}

?>
<?php
include '../../NSS_NEW/partial/_dbconnector.php';

session_start();

if (!isset($_SESSION['vol_loggedin']) || $_SESSION['vol_loggedin'] != true) {
    header("location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['newImage'])) {
    $image = $_FILES['newImage']['name'];
    $targetDir = "/NSS_NEW/Upload/";
    $targetFile = $_SERVER['DOCUMENT_ROOT'] . $targetDir . basename($image);

    // Check if the file is an image
    $check = getimagesize($_FILES['newImage']['tmp_name']);
    if ($check !== false) {
        // Delete the previous image file if it exists
        $oldImagePath = "/NSS_NEW/Upload/" . $_SESSION['previousImage'];
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . $oldImagePath)) {
            unlink($_SERVER['DOCUMENT_ROOT'] . $oldImagePath);
        }

        move_uploaded_file($_FILES['newImage']['tmp_name'], $targetFile);

        // Update the database with the new image name
        $updateImageSql = "UPDATE student SET Image = '$image' WHERE username = '{$_SESSION['username']}'";
        $conn->query($updateImageSql);

        // Store the new image name as the previous image
        $_SESSION['previousImage'] = $image;
        
        header("Location: profile.php"); // Redirect to the profile page
        exit;
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/NSS_NEW/Image/NSS.png">
    <title>Your Profile</title>
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <style>
    #body::-webkit-scrollbar {
        display: none;
    }

    /* Add this CSS for circular images and hover effect */
    .profile-container {
        position: relative;
        display: inline-block;
    }

    .profile-image {
        max-width: 250px;
        max-height: 200px;
        margin: 0 auto;
        border-radius: 50%;
        transition: transform 0.3s ease-in-out;
    }

    .profile-image:hover {
        transform: scale(1.1);
    }

    .update-icon {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        display: none;
        cursor: pointer;
    }

    .profile-container:hover .update-icon {
        display: block;
    }
    </style>
</head>

<body id="body">
    <!-- <br><br><br><br><br><br> -->

    <?php 
      include '../../NSS_NEW/partial/_header.php';
      require '../../NSS_NEW/partial/_dbconnector.php';
      include '../../NSS_NEW/PHP/new.php';
    ?>

    <div class="container d-flex justify-content-center align-items-center" style="height: 90vh;">
        <div class="card" style="width: 500px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
            <div class="card-body text-center"
                style="background-color: beige; background-size: cover; background-position: center; background-repeat: no-repeat;">

                <!-- Add an if condition to check if the image exists -->
                <div id="profileImageContainer" data-toggle="modal" data-target="#fullImageModal">
                    <?php
                $imagePath = "/NSS_NEW/Upload/" . $row['Image'];
                // $default = "/NSS_NEW/Upload/NSSnew.gif";
                if (file_exists($_SERVER['DOCUMENT_ROOT'] . $imagePath)) {
                    echo '<img src="' . $imagePath . '" class="img-thumbnail mb-3 profile-image" alt="My Image">';
                } 
                else if(!file_exists($_SERVER['DOCUMENT_ROOT'] . $imagePath)) {
                    echo '<img src="' . $default . '"class="img-thumbnail mb-3 profile-image" alt="Default Image">';
                }
                ?>
                </div>







                <h3 class="card-title"><?php echo $name; ?></h3>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><strong>Name:
                    </strong><?php echo $name ?></li>
                <!-- <li class="list-group-item"><strong>DOB: </strong><?php echo $dob; ?></li> -->
                <!-- <li class="list-group-item"><strong>Phone Number: </strong> <?php echo $phone_no; ?></li> -->
                <li class="list-group-item"><strong>Email: </strong> <?php echo $email; ?></li>
                <!-- <li class="list-group-item"><strong>Phone no.: </strong> <?php echo $phone_no; ?></li> -->
                <!-- <li class="list-group-item"><strong>Blood Group: </strong> <?php echo $bdgrp; ?></li> -->
                <li class="list-group-item"><strong>Gender: </strong> <?php echo  $gen; ?></li>
                <li class="list-group-item"><strong>Enrollment Number: </strong> <?php echo $vol_id ; ?></li>
                <li class="list-group-item"><strong>Year of Joining: </strong> <?php echo $yoj; ?></li>
                <li class="list-group-item"><strong>Department: </strong> <?php echo $class; ?></li>
                <!-- <li class="list-group-item"><strong>Name of Group: </strong> <?php echo $grp_nm; ?></li> -->
            </ul>
        </div>
    </div>
    <br><br><br>

    <!-- Button to open the modal -->
    <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#updateImageModal">
        Update Profile Image
    </button> -->



    <div class="modal fade" id="fullImageModal" tabindex="-1" role="dialog" aria-labelledby="fullImageModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="fullImageModalLabel">Full Profile Image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img src="<?php echo $imagePath; ?>" class="img-fluid" alt="Full NSS Image">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" data-toggle="modal"
                        data-target="#updateImageModal">Update Image</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for updating profile image -->
    <div class="modal fade" id="updateImageModal" tabindex="-1" role="dialog" aria-labelledby="updateImageModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateImageModalLabel">Update Profile Image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form for updating profile image -->
                    <form id="updateImageForm" action="profile.php" method="post" enctype="multipart/form-data">
                        <label for="newImage">Choose a new image:</label>
                        <input type="file" name="newImage" id="newImage" accept="image/*">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="submitUpdateImageForm()">Update
                        Image</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/d304e9faef.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://kit.fontawesome.com/d304e9faef.js" crossorigin="anonymous"></script> -->
    <script>
    function submitUpdateImageForm() {
        // Submit the form when the "Update Image" button in the modal is clicked
        document.forms["updateImageForm"].submit();
    }

    // Handle the shown.bs.modal event on the full image modal
    $('#fullImageModal').on('shown.bs.modal', function() {
        $('.update-icon').show(); // Show the upload icon
    });

    // Handle the hidden.bs.modal event on the full image modal
    $('#fullImageModal').on('hidden.bs.modal', function() {
        $('.update-icon').hide(); // Hide the upload icon
    });
    </script>

    <script>
    // function submitUpdateImageForm() {
    //     // Submit the form when the "Update Image" button in the modal is clicked
    //     document.forms["updateImageForm"].submit();
    // }

    // // Handle the click event on the profile image container
    // document.getElementById('profileImageContainer').addEventListener('click', function () {
    //     $('#fullImageModal').modal('show');
    // });
    </script>


    <!-- Your existing scripts -->

    <script>
    function submitUpdateImageForm() {
        // Submit the form when the "Update Image" button in the modal is clicked
        document.forms["updateImageForm"].submit();
    }
    </script>
    <br>


    <?php 
      include '../../NSS_NEW/partial/_footer.php';
    ?>

    <!-- Your existing scripts -->
</body>

</html>