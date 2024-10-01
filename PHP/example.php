<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Redesigned Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="../CSS/style.css">
    <style>
        #body::-webkit-scrollbar{
            display: none;
        }
        .main_container {
            margin-left: 50px;
        }

        /* Define styles for different sections */
        .hero-section {
            background-color: #f0f0f0;
            padding: 100px 0;
            text-align: center;
        }

        .team-section {
            background-color: #e6e6e6;
            padding: 80px 0;
        }

        .person-card {
            background-color: #fff;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
            height: 500px;
        }

        .img {
            height: 350px;
            width : 350px;
        }

        /* Responsive styles */
        @media (max-width: 768px) {
            .hero-section {
                padding: 80px 0;
            }

            .team-section {
                padding: 60px 0;
            }

            /* Adjust other styles for smaller screens if needed */
        }
    </style>
</head>

<body id="body">
    <?php include '../../NSS_NEW/partial/_header.php'; ?>
    <div class="main_container">
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="container">
                <h1>Welcome to Your NSS</h1>
                <p>This is a new, responsive layout designed for your website.</p>
            </div>
        </section>

        <!-- Team Section -->
        <section class="team-section">
            <div class="container text-center">
                <h2>Our Team</h2>

                <div class="row justify-content-center">
                    <div class="col-md-4">
                        <!-- Centered first card -->
                        <div class="person-card" style="height:400px;">
                            <img src="/NSS_NEW/Image/Principal.jpg" class="img-fluid rounded-circle img" alt="Principal">
                            <h3>Dr. Anita Kanwar</h3>
                            <p>Principal</p>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-md-4">
                        <!-- Three cards aligned in a row -->
                        <div class="person-card">
                            <img src="/NSS_NEW/Image/Vikas.png" class="img-fluid rounded-circle img" alt="Prof. Vikas Ware">
                            <h3>Prof. Vikas Ware</h3>
                            <p>Programme Officer</p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="person-card">
                            <img src="/NSS_NEW/Image/vaishnavi1.png" class="img-fluid rounded-circle img" alt="Dr. Vaishnavi Baguk">
                            <h3>Dr. Vaishnavi Baguk</h3>
                            <p>Programme Officer</p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="person-card">
                            <img src="/NSS_NEW/Image/Sujit.png" class="img-fluid rounded-circle img" alt="Mr. Sujit Chavan">
                            <h3>Mr. Sujit Chavan</h3>
                            <p>Programme Officer</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="person-card">
                            <img src="/NSS_NEW/Image/Kunal.png" class="img-fluid rounded-circle img" alt="Mr. Kunalkumar Shelar">
                            <h3>Mr. Kunalkumar Shelar</h3>
                            <p>Teacher Incharge</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="person-card">
                            <img src="/NSS_NEW/Image/Shradhha.png" class="img-fluid rounded-circle img" alt="Ms. Shraddha warang">
                            <h3>Ms. Shraddha warang</h3>
                            <p>Teacher Incharge</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="person-card">
                            <img src="/NSS_NEW/Image/Divya.png" class="img-fluid rounded-circle img" alt="Ms. Divya Shetty">
                            <h3>Ms. Divya Shetty</h3>
                            <p>Teacher Incharge</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="person-card">
                            <img src="/NSS_NEW/Image/Preeti.png" class="img-fluid rounded-circle img" alt="Ms. Preeti Matharu">
                            <h3>Ms. Preeti Matharu</h3>
                            <p>Teacher Incharge</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="person-card">
                            <img src="/NSS_NEW/Image/Sonal.png" class="img-fluid rounded-circle img" alt="Ms. Sonal Saki">
                            <h3>Ms. Sonal Saki</h3>
                            <p>Teacher Incharge</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
    <!-- Additional Sections -->
    <!-- Add more sections with different content as required -->

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>

</html>