




<?php
require 'C:/xampp/htdocs/NSS_NEW/partial/_dbconnector.php';

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    $loggedin = true;
} else {
    $loggedin = false;
}

if (isset($_SESSION['vol_loggedin']) && $_SESSION['vol_loggedin'] == true) {
    $vol_loggedin = true;
} else {
    $vol_loggedin = false;
}

if (isset($_SESSION['Admin_loggedin']) && $_SESSION['Admin_loggedin'] == true) {
    require 'C:/xampp/htdocs/NSS_NEW/PHP/new3.php';
    $Admin_loggedin = true;
    // $position1 = $position;
} else {
    $Admin_loggedin = false;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
<style>
        .nav-item {
            position: relative;
            font-family: monospace;
        }

        .nav-item:after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background-color: white;
            transition: width 0.3s;
        }
        .navbar{
            background-color: #464555;
        }
        .nav-item:hover:after {
            width: 100%;
        }

        .navbar-nav .nav-link {
            color: #ffffff;
            text-decoration: none;
            transition: color 0.3s;
        }

        .navbar-nav .nav-item:hover .nav-link {
            color: #ffffff;
        }

        .navbar-nav .nav-link.active {
            font-weight: bold;
        }

        .navbar-nav .nav-link.active:after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            width: 80px;
            height: 2px;
            background-color: white;
        }

        .navbar {
            position: sticky;
            top: 0;
            z-index: 1030;
        }
        .close{
            width: 100px;
            height: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 15px;
            margin-right: 270px;
            border: 1px solid white;
            color: white;
            text-decoration: none;
        }
    .nav-item {
        position: relative;
        font-family: monospace;
    }

    .nav-item:after {
        content: "";
        position: absolute;
        bottom: 0;
        left: 0;
        width: 0;
        height: 2px;
        background-color: white;
        transition: width 0.3s;
    }

    .navbar {
        background-color: #464555;
    }

    .navbar-toggler {
        border: none;
        background: transparent !important;
        color: white !important;
        font-size: 1.5rem;
    }

    .navbar-toggler:focus {
        outline: none;
    }

    .navbar-toggler-icon {
        background-color: white;
        border-radius: 2px;
        height: 3px;
        width: 20px;
    }

    .navbar-toggler-icon::before,
    .navbar-toggler-icon::after {
        background-color: white;
        border-radius: 2px;
        content: '';
        display: block;
        height: 3px;
        width: 20px;
        transition: all 0.3s;
    }

    .navbar-toggler-icon::before {
        transform: translateY(-6px);
    }

    .navbar-toggler-icon::after {
        transform: translateY(3px);
    }

    .offcanvas {
        max-width: 200px;
        /* Set your desired width */
    }

    .offcanvas-body {
        padding-right: 10px;
        /* Adjust as needed */
    }

    .close {
        width: 100px;
        height: 50px;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 15px;
        margin-right: 170px;
        /* Adjust as needed */
        border: 1px solid white;
        color: white;
        text-decoration: none;
    }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dark Offcanvas Navbar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
</head>

<body>

    <nav class="navbar navbar-dark fixed-top" aria-label="Dark offcanvas navbar">
        <div class="container-fluid">
            <div style="display: flex;">
            <!-- <a href="C:/xampp/htdocs/NSS_NEW/index.php"> -->
                <img src="/NSS_NEW/Image/VES.png" alt="VES" width="50" height="50">
                <img src="/NSS_NEW/Image/NSSnew.gif" alt="NSS" width="50" height="50">
            <!-- </a> -->
        </div>
            <a class="navbar-brand" href="#">NSS</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasNavbarDark" aria-controls="offcanvasNavbarDark">
                <i class="fas fa-bars"></i>
            </button>

            <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasNavbarDark"
                aria-labelledby="offcanvasNavbarDarkLabel">
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/NSS_NEW/index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="/NSS_NEW/PHP/about.php">About US</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="/NSS_NEW/PHP/events.php">Events</a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link active" href="/NSS_NEW/PHP/enroll.php">Enroll Your self</a>
                        </li> -->
                        <div class="list-group mt-3">
                            <?php
                            if (!$loggedin && !$vol_loggedin && !$Admin_loggedin) {
                                echo '<li class="nav-item"><a class="nav-link active" href="/NSS_NEW/PHP/login.php">Login</a></li>
                                <li class="nav-item"><a class="nav-link active" href="/NSS_NEW/PHP/enroll.php">Enroll Your self</a></li>';
                            } elseif ($vol_loggedin && !$loggedin && !$Admin_loggedin) {
                                echo '
                                <li class="nav-item"><a class="nav-link active" href="/NSS_NEW/PHP/checkhrs.php">Check Hours</a></li>
                                <li class="nav-item"><a class="nav-link active" href="/NSS_NEW/PHP/profile.php">Profile</a></li>
                                <li class="nav-item"><a class="nav-link active" href="/NSS_NEW/PHP/logout.php">Logout</a></li>';
                            } elseif ($loggedin) {
                                echo '
                                <li class="nav-item"><a class="nav-link active" href="/NSS_NEW/PHP/attend.php">Attendance</a></li>
                                <li class="nav-item"><a class="nav-link active" href="/NSS_NEW/PHP/addEvent.php">Add Event</a></li>
                                <li class="nav-item"><a class="nav-link active" href="/NSS_NEW/PHP/total_attendance.php">Total Event</a></li>
                                <li class="nav-item"><a class="nav-link active" href="/NSS_NEW/PHP/download.php">Download</a></li>
                                <li class="nav-item"><a class="nav-link active" href="/NSS_NEW/PHP/status2.php">Status</a></li>
                                <li class="nav-item"><a class="nav-link active" href="/NSS_NEW/PHP/NEP_students.php">NEP Students</a></li>
                                <li class="nav-item"><a class="nav-link active" href="/NSS_NEW/PHP/logout.php">Logout</a></li>
                                ';
                            } elseif ($Admin_loggedin) {
                                echo '
                                <li class="nav-item"><a class="nav-link active" href="/NSS_NEW/PHP/status.php">Status</a></li>
                                <li class="nav-item"><a class="nav-link active" href="/NSS_NEW/PHP/add_proj.php">Add Project</a></li>';
                                
                                // Check if the user has the 'PO' position
                                if ($position == 'PO') {
                                    echo '<li class="nav-item"><a class="nav-link active" href="/NSS_NEW/PHP/check_expense.php">Expenses</a></li>
                                    <li class="nav-item"><a class="nav-link active" href="/NSS_NEW/PHP/reports.php">report</a></li>
                                    <li class="nav-item"><a class="nav-link active" href="/NSS_NEW/PHP/addLeader.php">Add Leader</a></li>
                                    <li class="nav-item"><a class="nav-link active" href="/NSS_NEW/PHP/del_leader.php">Remove Leader</a></li>
                                    <li class="nav-item"><a class="nav-link active" href="/NSS_NEW/PHP/approve.php">Aproove Volunteer</a></li>
                                    ';
                                }
                                
                                echo '<li class="nav-item"><a class="nav-link active" href="/NSS_NEW/PHP/logout.php">Logout</a></li>
                                ';
                            }
                            ?>
                        </div>
                    </ul>
                    <a class="close" data-bs-dismiss="offcanvas">Close</a>
                </div>
            </div>
        </div>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<!-- <li class="nav-item"><a class="nav-link active" href="/NSS_NEW/PHP/chk_grp_hrs.php">Check group</a></li> -->