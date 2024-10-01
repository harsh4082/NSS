<?php
$login = false;
$showError = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require '../../NSS_NEW/partial/_dbconnector.php';
    $username = $_POST["username"];
    $password = $_POST["password"];
    $exists = false;

    // Logic for volunteer login
    $sql_volunteer = "Select * from student where username='$username' AND password='$password'";
    $result_volunteer = mysqli_query($conn, $sql_volunteer);
    $num_volunteer = mysqli_num_rows($result_volunteer);

    // Logic for leader login
    $sql_leader = "Select * from leader where username='$username' AND password='$password'";
    $result_leader = mysqli_query($conn, $sql_leader);
    $num_leader = mysqli_num_rows($result_leader);

    // Logic for admin login
    $sql_teacher = "Select * from project where username='$username' AND password='$password'";
    $result_teacher = mysqli_query($conn, $sql_teacher);
    $num_teacher = mysqli_num_rows($result_teacher);

    if ($num_volunteer == 1) {
        $login = true;
        session_start();
        $_SESSION['vol_loggedin'] = true;
        $_SESSION['username'] = $username;
        header("location: /NSS_NEW/index.php");
    } elseif ($num_leader == 1) {
        $login = true;
        session_start();
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        header("location: /NSS_NEW/index.php");
    } elseif ($num_teacher == 1) {
        $login = true;
        session_start();
        $_SESSION['Admin_loggedin'] = true;
        $_SESSION['username'] = $username;
        header("location: /NSS_NEW/index.php");
    } else {
        $showError = "Invalid Credentials";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">

    <style>
        #body::-webkit-scrollbar{
            display: none;
        }
        .card {
            width: 100%;
            max-width: 25rem;
            padding: 1rem;
            box-shadow: 0 4px 8px 0 rgb(65, 102, 245);
            background-color: #d9d1ba;
            margin: auto;
        }

        .card-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100%;
        }

        .card-img-top {
            width: 10rem;
            max-width: 100%;
            height: auto;
            border-radius: 50%;
            margin-bottom: 1rem;
        }

        .form-control {
            width: 100%;
            max-width: 100%;
        }

        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }
        .input-group-append{
            margin: 8px;

        }

        .checkbox-container {
            display: flex;
            align-items: center;
        }

        .checkbox-label {
            margin-left: 5px;
        }
    </style>
</head>

<body id="body">
    <div class="container-fluid my-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8">
                <div class="card border-0">
                    <div class="card-content text-center">
                        <img src="/NSS_NEW/Image/LOGO.png" class="card-img-top" alt="Sample image">
                    </div>
                    <div class="card-body">
                        <form action="/NSS_NEW/PHP/login.php" method="post">
                            <div class="mb-3 position-relative">
                                <label for="emailid" class="form-label">USER ID</label>
                                <input type="text" class="form-control" id="emailid" name="username"
                                    aria-describedby="emailHelp" placeholder="Enter email" autocomplete="off">
                            </div>
                            <div class="mb-3 position-relative">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Password" autocomplete="off">
                                
                                
                                <div class="input-group-append">
                                        <div class="checkbox-container">
                                            <input type="checkbox" id="showPasswordCheckbox" onclick="togglePasswordVisibility()">
                                            <label class="checkbox-label" for="showPasswordCheckbox">Show Password</label>
                                </div>
                                </div>
                                </div>
                            <?php
                                if ($showError) {
                                    echo '<p class="error-message">' . $showError . '</p>';
                                }
                            ?>
                            <button type="submit" class="btn btn-primary">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/js/all.min.js"></script>
<script>
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById('password');
            var checkbox = document.getElementById('showPasswordCheckbox');
            var type = checkbox.checked ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
        }
    </script>
</body>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">

</body>

</html>
