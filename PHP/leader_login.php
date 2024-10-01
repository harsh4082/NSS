<?php
require '../../NSS_NEW/partial/_dbconnector.php';
$registrationSuccess = false;
$userExists = false;
$errors = [];

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $leader_id = $_POST['leader_id'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $teacher_in_charge = $_POST['teacher'];

    // Validate password
    if (
        strlen($password) < 8 || // Password length less than 8
        !preg_match("/[0-9]+/", $password) || // No numeric digit
        !preg_match("/[!@#$%^&*()\-_=+{};:,<.>]+/", $password) || // No special character
        !preg_match("/[A-Z]+/", $password) // No uppercase letter
    ) {
        $errors['password'] = "Password does not meet requirements.";
    } elseif ($password !== $confirm_password) {
        $errors['confirm_password'] = "Passwords do not match.";
    }

    // Check if the leader ID exists
    $existSql = "SELECT * FROM `leader` WHERE Lead_id = '$leader_id'";
    $result = mysqli_query($conn, $existSql);
    $numExistRows = mysqli_num_rows($result);
    if ($numExistRows == 0) {
        $errors['leader_id'] = "Leader ID does not exist.";
    }

    // Check if the username already exists
    $userSql = "SELECT username FROM `leader` WHERE Lead_id = '$leader_id'";
    $userResult = mysqli_query($conn, $userSql);
    $userRow = mysqli_fetch_assoc($userResult);
    $existingUsername = $userRow['username'];

    if (!empty($existingUsername)) {
        $errors['username'] = "Username already exists.";
    }

    // Update username, teacher in charge, and password if the user doesn't exist and there are no errors
    if (empty($errors)) {
        $sql = "UPDATE `leader` SET username = '$username', T_incharge = '$teacher_in_charge', password = '$password' WHERE Lead_id = '$leader_id'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $registrationSuccess = true;
        } else {
            $errors['registration'] = "Error updating leader details.";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="website icon" type="png" href="/NSS_NEW/Image/NSS.png">
    <title>User Registration Form</title>
    <link rel="stylesheet" href="CSS/style.css">
    <style>
        #body {    
            background-color: #ebcc69;
            font-family: 'Arial', sans-serif;
            min-height: 100vh;
            margin: 0;
        }
        #body::-webkit-scrollbar{
            display: none;
        }
        /* Custom styles for the card */
        .custom-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease-in-out;
        }
        .custom-card:hover {
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.2);
        }
        /* Custom styles for form inputs */
        .form-group label {
            font-weight: bold;
        }
        /* Custom styles for checkbox */
        .form-check-label {
            font-weight: normal;
        }
    </style>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body id="body">
    <?php if ($userExists || $registrationSuccess) : ?>
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card custom-card">
                        <div class="card-body">
                            <h5 class="card-title text-center mb-4"><?php echo $userExists ? "You have already registered" : "Registration successful"; ?></h5>
                            <p class="text-center"><?php echo $userExists ? "Click <a href='login.php'>here</a> to log in." : "You have successfully registered. Click <a href='login.php'>here</a> to log in."; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php else : ?>
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card custom-card">
                        <div class="card-body">
                            <h5 class="card-title text-center mb-4">Leader Registration Form</h5>
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="leader_id">Leader ID:</label>
                                    <input type="text" id="leader_id" name="leader_id" class="form-control <?php echo isset($errors['leader_id']) ? 'is-invalid' : ''; ?>" required>
                                    <?php if (isset($errors['leader_id'])) : ?>
                                        <div class="invalid-feedback"><?php echo $errors['leader_id']; ?></div>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group">
                                    <label for="username">Username:</label>
                                    <input type="text" id="username" name="username" class="form-control <?php echo isset($errors['username']) ? 'is-invalid' : ''; ?>" required>
                                    <?php if (isset($errors['username'])) : ?>
                                        <div class="invalid-feedback"><?php echo $errors['username']; ?></div>
                                    <?php endif; ?>
                                </div>

                                
                                <div class="form-group">
                                    <label for="teacher" class="form-label">Teacher Incharge:</label>
                                    <select class="form-control <?php echo isset($errors['teacher']) ? 'is-invalid' : ''; ?>" id="teacher" name="teacher" required>
                                        <option value="" disabled selected>Select Teacher Incharge</option>
                                        <?php
                                        $sql = "SELECT T_incharge FROM project;";
                                        $result = mysqli_query($conn, $sql);
                                        
                                        if ($result) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $t_incharge = $row['T_incharge'];
                                                echo "<option value='$t_incharge'>$t_incharge</option>";
                                            }
                                        } else {
                                            echo "<option value=''>No projects found</option>";
                                        }
                                        ?>
                                    </select>
                                    <?php if (isset($errors['teacher'])) : ?>
                                        <div class="invalid-feedback"><?php echo $errors['teacher']; ?></div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="form-group">
                                    <label for="password">Password:</label>
                                    <input type="password" id="password" name="password" class="form-control <?php echo isset($errors['password']) ? 'is-invalid' : ''; ?>" title="Password must be 8 characters long and contain at least one number, one uppercase letter, and one special character" required>
                                    <?php if (isset($errors['password'])) : ?>
                                        <div class="invalid-feedback"><?php echo $errors['password']; ?></div>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group">
                                    <label for="confirm_password">Confirm Password:</label>
                                    <input type="password" id="confirm_password" name="confirm_password" class="form-control <?php echo isset($errors['confirm_password']) ? 'is-invalid' : ''; ?>" required>
                                    <?php if (isset($errors['confirm_password'])) : ?>
                                        <div class="invalid-feedback"><?php echo $errors['confirm_password']; ?></div>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group form-check">
                                    <input type="checkbox" id="showPassword" class="form-check-input"> 
                                    <label for="showPassword" class="form-check-label">Show Password</label>
                                </div>

                                <button type="submit" class="btn btn-primary btn-block">Register</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Bootstrap and other scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <!-- Script for showing/hiding password -->
    <script>
        document.getElementById("showPassword").addEventListener("change", function () {
            var passwordInput = document.getElementById("password");
            var confirmInput = document.getElementById("confirm_password");

            if (this.checked) {
                passwordInput.type = "text";
                confirmInput.type = "text";
            } else {
                passwordInput.type = "password";
                confirmInput.type = "password";
            }
        });
    </script>
</body>
</html>
