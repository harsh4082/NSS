<?php
include '../../NSS_NEW/partial/_dbconnector.php';
session_start();
$num = 0;
$num1 = 0;

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
  $num = $num + 1;
}
if (!isset($_SESSION['vol_loggedin']) || $_SESSION['vol_loggedin'] != true) {
  $num1 = $num1 + 1;
}

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
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bootstrap demo</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <!-- <link rel="stylesheet" href="style.css"> -->
  <style>
    .item {
      margin: 50px;
    }

    .image {
      height: 200px;
    }

    .main_container {
      margin-left: 50px;
      padding: 20px;
    }

    @media (max-width: 768px) {
      .item {
        margin: 20px;
      }

      .image {
        height: 150px;
      }
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
  <link rel="website icon" type="png" href="/NSS_NEW/Image/NSS.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
  <!-- <link rel="stylesheet" href="style.css"> -->
  <link rel="stylesheet" href="../CSS/style.css">
  <style>
    #body::-webkit-scrollbar{
            display: none;
        }
  </style>
</head>

<body id="body">
  <!-- <?php //include '../../NSS_NEW/partial/_header.php'; ?> -->
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
  <?php

  require '../../NSS_NEW/partial/_dbconnector.php';
  ?>
  <br><br><br>
  <div class="main_container">
    <div class="main2">
      <div class="col-md-6 m-auto p-auto" id="box">
        <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow p-3 h-md-250 position-relative">
          <div class="col p-4 d-flex flex-column position-static">
            <strong class="d-inline-block mb-2 text-primary-emphasis">NSS</strong>
            <strong class="d-inline-block mb-2 text-success-emphasis">Dr. Anita Kanwar</strong>
            <h1 class="mb-0 text-success-emphasis">Principal</h1><br><br>
            <p class="card-text mb-auto text-warning-emphasis">This is a wider card with supporting text below as a natural lead-in to
              additional content.</p>
            </a>
          </div>
          <div class="col-auto d-none d-lg-block">
            <img class="bd-placeholder-img shadow p-3" style="border: 4px solid; border-color:white" width="250" height="250" src="/NSS_NEW/Image/Principal.jpg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false">
            <title>Placeholder</title>
            </img>
          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid">
      <div class="row">
        <div class="row mb-3 m-auto p-auto px-5">
          <div class="col-md-6">
            <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow p-3 h-md-250 position-relative">
              <div class="col p-4 d-flex flex-column position-static">
                <strong class="d-inline-block mb-2 text-primary-emphasis">NSS</strong>
                <strong class="d-inline-block mb-2 text-success-emphasis">Proff. Vikas Ware</strong>
                <h2 class="mb-0 text-success-emphasis">Programme Officer</h2><br><br>
                <p class="card-text mb-auto text-warning-emphasis">This is a wider card with supporting text below as a natural lead-in to
                  additional content.</p>
                </a>
              </div>
              <div class="col-auto d-none d-lg-block">
                <img class="bd-placeholder-img shadow p-3" style="border: 4px solid; border-color:white" width="250" height="250" src="/NSS_NEW/Image/Vikas.png" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false">
                <title>Placeholder</title>
                </img>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow p-3 h-md-250 position-relative">
              <div class="col p-4 d-flex flex-column position-static">
                <strong class="d-inline-block mb-2 text-success-emphasis">NSS</strong>
                <strong class="d-inline-block mb-2 text-success-emphasis">Dr. Vaishnavi Baguk</strong>
                <h2 class="mb-0 text-success-emphasis">Programme Officer</h2><br><br>
                <p class="mb-auto text-warning-emphasis">This is a wider card with supporting text below as a natural lead-in to additional
                  content.</p>
              </div>
              <div class="col-auto d-none d-lg-block">
                <img class="bd-placeholder-img shadow p-3" style="border: 4px solid; border-color:white" width="250" height="250" src="/NSS_NEW/Image/vaishnavi1.png" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false">
                <title>Placeholder</title>
                </img>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row mb-3 m-auto p-auto px-5">
      <div class="col-md-6">
        <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow p-3 h-md-250 position-relative">
          <div class="col p-4 d-flex flex-column position-static">
            <strong class="d-inline-block mb-2 text-primary-emphasis">NSS</strong>
            <strong class="d-inline-block mb-2 text-success-emphasis">Mr. Sujit Chavan</strong>
            <h2 class="mb-0 text-success-emphasis">Teacher Incharge</h2><br><br>
            <p class="card-text mb-auto text-warning-emphasis">This is a wider card with supporting text below as a natural lead-in to
              additional content.</p>
            </a>
          </div>
          <div class="col-auto d-none d-lg-block">
            <img class="bd-placeholder-img shadow p-3" style="border: 4px solid; border-color:white" width="250" height="250" src="/NSS_NEW/Image/Sujit.png" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false">
            <title>Placeholder</title>
            </img>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow p-3 h-md-250 position-relative">
          <div class="col p-4 d-flex flex-column position-static">
            <strong class="d-inline-block mb-2 text-success-emphasis">NSS</strong>
            <strong class="d-inline-block mb-2 text-success-emphasis">Mr. Kunalkumar Shelar</strong>
            <h2 class="mb-0 text-success-emphasis">Teacher Incharge</h2><br><br>
            <p class="mb-auto text-warning-emphasis">This is a wider card with supporting text below as a natural lead-in to additional
              content.</p>
          </div>
          <div class="col-auto d-none d-lg-block">
            <img class="bd-placeholder-img shadow p-3" style="border: 4px solid; border-color:white" width="250" height="250" src="/NSS_NEW/Image/Kunal.png" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false">
            <title>Placeholder</title>
            </img>
          </div>
        </div>
      </div>
    </div>

    <div class="row mb-3 m-auto p-auto px-5">
      <div class="col-md-6">
        <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow p-3 h-md-250 position-relative">
          <div class="col p-4 d-flex flex-column position-static">
            <strong class="d-inline-block mb-2 text-primary-emphasis">NSS</strong>
            <strong class="d-inline-block mb-2 text-success-emphasis">Ms. Shraddha warang</strong>
            <h2 class="mb-0 text-success-emphasis">Teacher Incharge</h2><br><br>
            <p class="card-text mb-auto text-warning-emphasis">This is a wider card with supporting text below as a natural lead-in to
              additional content.</p>
            </a>
          </div>
          <div class="col-auto d-none d-lg-block">
            <img class="bd-placeholder-img shadow p-3" style="border: 4px solid; border-color:white" width="250" height="250" src="/NSS_NEW/Image/Shradhha.png" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false">
            <title>Placeholder</title>
            </img>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow p-3 h-md-250 position-relative">
          <div class="col p-4 d-flex flex-column position-static">
            <strong class="d-inline-block mb-2 text-success-emphasis">NSS</strong>
            <strong class="d-inline-block mb-2 text-success-emphasis">Ms. Divya Shetty</strong>
            <h2 class="mb-0 text-success-emphasis">Teacher Incharge</h2><br><br>
            <p class="mb-auto text-warning-emphasis">This is a wider card with supporting text below as a natural lead-in to additional
              content.</p>
          </div>
          <div class="col-auto d-none d-lg-block">
            <img class="bd-placeholder-img shadow p-3" style="border: 4px solid; border-color:white" width="250" height="250" src="/NSS_NEW/Image/Divya.png" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false">
            <title>Placeholder</title>
            </img>
          </div>
        </div>
      </div>
    </div>

    <div class="row mb-3 m-auto p-auto px-5">
      <div class="col-md-6">
        <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow p-3 h-md-250 position-relative">
          <div class="col p-4 d-flex flex-column position-static">
            <strong class="d-inline-block mb-2 text-primary-emphasis">NSS</strong>
            <strong class="d-inline-block mb-2 text-success-emphasis">Ms. Preeti Matharu</strong>
            <h2 class="mb-0 text-success-emphasis">Teacher Incharge</h2><br><br>
            <p class="card-text mb-auto text-warning-emphasis">This is a wider card with supporting text below as a natural lead-in to
              additional content.</p>
            </a>
          </div>
          <div class="col-auto d-none d-lg-block">
            <img class="bd-placeholder-img shadow p-3" style="border: 4px solid; border-color:white" width="250" height="250" src="/NSS_NEW/Image/Preeti.png" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false">
            <title>Placeholder</title>
            </img>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow p-3 h-md-250 position-relative">
          <div class="col p-4 d-flex flex-column position-static">
            <strong class="d-inline-block mb-2 text-success-emphasis">NSS</strong>
            <strong class="d-inline-block mb-2 text-success-emphasis">Ms. Sonal Saki</strong>
            <h2 class="mb-0 text-success-emphasis">Teacher Incharge</h2><br><br>
            <p class="card-text mb-auto text-warning-emphasis">This is a wider card with supporting text below as a natural lead-in to additional
              content.</p>
          </div>

          <div class="col-auto d-none d-lg-block">
            <img class="bd-placeholder-img shadow p-3" style="border: 4px solid; border-color:white" width="250" height="250" src="/NSS_NEW/Image/Sonal.png" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false">
            <title>Placeholder</title>
            </img>
          </div>
        </div>
      </div>
    </div>

    
    <!-- <div class="container mt-4 mb-4">
      <div class="owl-carousel owl-theme">
        <div class="item">
          <div class="card" style="width: 18rem;">
            <img class="image" src="first.jpg" class="card-img-top" alt="Image 1">
            <div class="card-body">
              <h5 class="card-title">Card 1</h5>
              <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
          </div>
        </div>
        <div class="item">
          <div class="card" style="width: 18rem;">
            <img class="image" src="second.jpg" class="card-img-top" alt="Image 1">
            <div class="card-body">
              <h5 class="card-title">Card 1</h5>
              <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
          </div>
        </div>
        <div class="item">
          <div class="card" style="width: 18rem;">
            <img class="image" src="third.png" class="card-img-top" alt="Image 1">
            <div class="card-body">
              <h5 class="card-title">Card 1</h5>
              <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
          </div>
        </div>
        <div class="item">
          <div class="card" style="width: 18rem;">
            <img class="image" src="first.jpg" class="card-img-top" alt="Image 1">
            <div class="card-body">
              <h5 class="card-title">Card 1</h5>
              <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
          </div>
        </div>
        <div class="item">
          <div class="card" style="width: 18rem;">
            <img class="image" src="fifth.jpg" class="card-img-top" alt="Image 1">
            <div class="card-body">
              <h5 class="card-title">Card 1</h5>
              <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
          </div>
        </div>
        <div class="item">
          <div class="card" style="width: 18rem;">
            <img class="image" src="sixth.jpg" class="card-img-top" alt="Image 1">
            <div class="card-body">
              <h5 class="card-title">Card 1</h5>
              <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
          </div>
        </div>
        <div class="item">
          <div class="card" style="width: 18rem;">
            <img class="image" src="sixth.jpg" class="card-img-top" alt="Image 1">
            <div class="card-body">
              <h5 class="card-title">Card 1</h5>
              <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
          </div>
        </div>

        Add more card items here as needed 
      </div>
    </div> -->
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
  <script>
    $(document).ready(function() {
      $('.owl-carousel').owlCarousel({
        items: 3,
        loop: true,
        margin: 20,
        /* Adjusted margin for spacing */
        nav: true,
        navText: ["<i class='fas fa-chevron-circle-left fa-3x'></i>", "<i class='fas fa-chevron-circle-right fa-3x'></i>"],
        responsive: {
          0: {
            items: 1
          },
          768: {
            items: 2
          },
          992: {
            items: 3
          }
        }
      });
    });
  </script>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
  <?php

  include '../../NSS_NEW/partial/_footer.php';

  ?>
</body>

</html>