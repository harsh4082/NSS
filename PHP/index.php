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
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="website icon" type="png" href="/NSS_NEW/Image/NSS.png">
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

    .logo {
        margin-left: -300px;
    }

    .color {
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        background-color: red;
    }

    .d-block {
        width: 900px;
        height: auto;
        margin-left: 50px;
    }

    .card {
        background-color: #ABA7CC;
    }

    .card-title {
        color: #007bff;
        font-weight: bold;
    }

    .card-text {
        color: #495057;
    }

    .container {
        margin: auto;
        margin-top: 10px;
        max-width: 800px;
    }

    .carousel {
        border-radius: 15px;
    }

    .carousel-caption {
        background-color: rgba(0, 0, 0, 0.7);
        border-radius: 15px;
    }

    .carousel-caption h5 {
        color: white;
    }

    .carousel-caption p {
        color: #ffd700;
        /* Golden text color */
    }

    hr {
        border: 2px solid #333;
        width: 80%;
    }

    @keyframes scroll {
        0% {
            transform: translateY(0);
        }

        100% {
            transform: translateY(-100%);
        }
    }

    .event-list-container ul {
        padding: 0;
        margin: 0;
    }

    .event-list-container ul li {
        list-style: none;
    }

    .header {
        height: 40px;
        /* Set your desired header height */
        text-align: center;
    }

    .loader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.8);
        /* Semi-transparent white background */
        z-index: 9999;
        display: flex;
        justify-content: center;
        align-items: center;
        backdrop-filter: blur(8px);
        /* Apply blur effect to background */
    }

    @media (max-width: 786px) {
        .card {
            width: auto;
        }
    }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>

<body id="body">
    <?php include '../../NSS_NEW/partial/_header.php'; ?>

    <br>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4 mb-3 box1">
                <div class="card shadow" style="max-height: 200px; overflow: hidden; background-color:#FFF5FF;">
                    <div class="card-header">
                        <h5 class="card-title text-center">Upcoming Events</h5>
                    </div>
                    <div class="card-body">
                        <div class="event-list-container"
                            style="max-height: 100px; overflow: hidden; animation: scroll 10s linear infinite;">
                            <ul class="event-list" id="scrolling-events">
                                <?php
                                $sql = "SELECT Name, Date FROM events WHERE Status = 'In progress' ORDER BY Date ASC";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<li class="event-list-item">' . $row["Name"] . ' - ' . $row["Date"] . '</li>';
                                    }
                                } else {
                                    echo '
                                    <script>
                                    //document.getElementsByClassName("box1")[0].style="visibility:hidden";
                                    //document.getElementsByClassName("card")[0].style="visibility:hidden";
                                    //document.getElementsByClassName("box2")[0].style="width:1000px";
                                    </script>
                                    
                                    <li class="event-list-item">No upcoming events found.</li>
                    
                                    ';
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8 box2">
                <div class="card shadow" style="background-color: #FFF5FF;">
                    <div class="card-body">
                        <h5 class="card-title text-center">NSS MOTTO</h5>
                        <p class="card-text">
                            The Motto of NSS "Not Me But You," reflects the essence of democratic living and upholds the
                            need for selfless service. NSS helps the students develop an appreciation for other persons'
                            points of view and also shows consideration towards other living beings. The philosophy of
                            the NSS is a good doctrine in this motto, which underlines the belief that the welfare of an
                            individual is ultimately dependent on the welfare of society as a whole, and therefore, the
                            NSS volunteers shall strive for the well-being of the society.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <br><br>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow" style="background-color: #FFF5FF;">
                    <div class="card-body">
                        <div class="row">
                            <!-- First compartment for the image -->
                            <div class="col-md-6">
                                <img src="../NSS_NEW/Image/NSS.png" class="img-fluid" alt="NSS Logo"
                                    style="height:200px">
                            </div>
                            <!-- Second compartment for the content -->
                            <div class="col-md-6">
                                <h5 class="card-title text-center logo">NSS LOGO</h5>
                                <p class="card-text logo">
                                    The logo for the NSS has been based on the giant Rath Wheel of the world-famous
                                    Konark Sun Temple (The Black Pagoda) situated in Orissa, India. The Red & Blue
                                    colors contained in the logo motivate the NSS Volunteers to be active & energetic
                                    for the nation-building social activities. The wheel portrays the cycle of creation,
                                    preservation, and release and signifies the movement in life across time and space.
                                    The wheel thus stands for continuity as well as change and implies the continuous
                                    striving of NSS for social change.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <br><br>

    <!-- <div class="container mt-5">
        <div class="card shadow" style="background-color: #FFF5FF;">
            <div class="card-body">
                <h5 class="card-title text-center">NSS Objectives</h5>
                <ul>
                    <li>Understand the community in which they work.</li>
                    <li>Understand themselves about their community.</li>
                    <li>Identify the needs and problems of the community and involve them in the problem-solving
                        process.</li>
                    <li>Develop among them a sense of social and civic responsibility.</li>
                    <li>Utilize their knowledge in finding practical solutions to individual and community problems.
                    </li>
                    <li>Develop competence required for group-living and sharing of responsibilities.</li>
                    <li>Gain skills in mobilizing community participation.</li>
                    <li>Acquire leadership qualities and a democratic attitude.</li>
                    <li>Develop the capacity to meet emergencies and natural disasters.</li>
                    <li>Practice national integration and social harmony.</li>
                </ul>
            </div>
        </div>
    </div> -->
    <div class="container mt-5">
    <div class="card shadow" style="background-color: #FFF5FF;">
        <div class="card-body">
            <div class="row">
                <!-- First compartment for the image -->
                <div class="col-md-6">
                    <img src="Image/objectives.png" class="img-fluid" alt="NSS Objectives" style="height: 250px;">
                </div>
                <!-- Second compartment for the content -->
                <div class="col-md-6">
                    <h5 class="card-title text-center logo" >NSS Objectives</h5>
                    <ul class="logo">
                        <li>Understand the community in which they work.</li>
                        <li>Understand themselves about their community.</li>
                        <li>Identify the needs and problems of the community and involve them in the problem-solving process.</li>
                        <li>Develop among them a sense of social and civic responsibility.</li>
                        <li>Utilize their knowledge in finding practical solutions to individual and community problems.</li>
                        <li>Develop competence required for group-living and sharing of responsibilities.</li>
                        <li>Gain skills in mobilizing community participation.</li>
                        <li>Acquire leadership qualities and a democratic attitude.</li>
                        <li>Develop the capacity to meet emergencies and natural disasters.</li>
                        <li>Practice national integration and social harmony.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

    <br><br>
    <script>
    // JavaScript to hide the loader after 3 seconds
    window.addEventListener('load', function() {
        // Show the loader
        document.querySelector('.loader').style.display = 'flex';

        // Hide the loader after 3 seconds
        setTimeout(function() {
            // Hide the loader
            document.querySelector('.loader').style.display = 'none';
            // Show the main content
            document.getElementById('body').style.visibility = 'visible';
        }, 500); // 3000 milliseconds = 3 seconds
    });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-o3UDvTcfNRt53ckNUJ3Nt3tPc3vi1xaFy13RC1frQC5trGxn3ZkEdXv6PccU2Aaa" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>

    <?php include '../../NSS_NEW/partial/_footer.php'; ?>

</body>

</html>