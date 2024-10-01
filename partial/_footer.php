<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Include Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://kit.fontawesome.com/d304e9faef.js" crossorigin="anonymous"></script>

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: "Times New Roman", serif;
        }

        footer {
            background: linear-gradient(to left,#2D3250, #040D12 );
            color: #fff;
            padding: 15px 0;
            text-align: center;
            position: relative;
        }

        .footer-content {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            max-width: 800px;
            margin: auto;
            position: relative;
        }

        .contact-info {
            font-size: 16px;
            text-align: left;
            flex: 1 1 100%;
            margin-bottom: 20px; /* Added margin for better spacing */
        }

        .social-icons {
            text-align: right;
            flex: 1 1 100%;
        }

        .social-icons a {
            font-size: 24px;
            color: #fff;
            margin: 0 10px;
            text-decoration: none;
            transition: transform 0.4s, color 0.4s; /* Added color transition */
        }

        .social-icons a:hover {
            color: #007bff;
            transform: scale(1.3); /* Adjusted scale for better visibility */
        }

        .separator {
            display: none; /* Hide the separator on small screens */
        }

        @media screen and (min-width: 768px) {
            .footer-content {
                flex-wrap: nowrap;
            }

            .contact-info,
            .social-icons {
                flex: 1;
            }

            .separator {
                display: block; /* Show the separator on larger screens */
                position: static;
                border-left: none;
                width: 3px;
                height: 100%; /* Adjust height to match the content */
                margin: 0 20px; /* Add margin for better spacing */
            }
        }
    </style>
</head>

<body>
    <footer>
        <div class="container footer-content">
            <div class="contact-info">
            
            <img src="/NSS_NEW/Image/VES.png" alt="Bootstrap" width="50" height="50" style="margin-bottom: 10px; ">
            <img src="/NSS_NEW/Image/NSSnew.gif" alt="Bootstrap" width="50" height="50">
        
                <h3>Contact Us</h3>
                <p>Email: vesasc.nssunit@ves.ac.in</p>
                <p>Phone: 123-456-789</p>
            </div>
           
            <div class="separator"></div>
            <div class="social-icons">
                <a href="https://instagram.com/nssunit.vesasc?igshid=MzRlODBiNWFlZA==" target="_blank"><i class="fab fa-instagram fa-xl" style="color: #d12d10;"></i></a>
                <a href="https://twitter.com/NSS_VESASC?t=bPlCFRx7mKhVXk0VphjHAw&s=09" target="_blank"><i class="fab fa-twitter fa-xl" style="color: #ffffff;"></i></a>
            </div>
        </div>
    </footer>
    <script src="https://kit.fontawesome.com/d304e9faef.js" crossorigin="anonymous"></script>
</body>

</html>
