<?php
include '../../NSS_NEW/partial/_dbconnector.php';
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: /NSS_NEW/PHP/login.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Group Details</title>
    <link rel="website icon" type="png" href="/NSS_NEW/Image/NSS.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../CSS/style.css">
    <style>
        #body::-webkit-scrollbar{
            display: none;
        }
        .card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }
    </style>
</head>
<body id="body">
    <br><br>
<?php
    require '../../NSS_NEW/PHP/new2.php'; 
    include '../../NSS_NEW/partial/_header.php';
    require '../../NSS_NEW/partial/_dbconnector.php';
?>

<div class="container mt-5">
    <h4 class="alert-heading text-center mt-3">Welcome - <?php echo $_SESSION['username'] ?></h4>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title text-center"><?php echo $grp_nm; ?></h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>SR NO</th>
                        <th>Name</th>
                        <th>Vec No</th>
                        <th>Hours</th>
                        <th>Show details</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require '../../NSS_NEW/partial/_dbconnector.php';

                    $sql = "SELECT `Name`, `Vec_no`, `hours` FROM volunteer WHERE grp_nm = '$grp_nm'";
                    $result = $conn->query($sql);

                    $totalHours = 0;

                    if ($result->num_rows > 0) {
                        $sr_no = 1;
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>
                             <td> '. $sr_no . ' </td>
                             <td> '. $row["Name"] .' </td>
                             <td> '. $row["Vec_no"] .' </td>
                             <td> '. $row["hours"] .' </td>
                             <td>
                             <form action="volunteer_details.php" method="post">
                                 <input type="hidden" name="volunteer_id" value='.$row["Vec_no"].' >
                                 <button type="submit" class="btn btn-primary">View Details</button>
                             </form>
                         </td>
                        </tr>'
                             
                        ;
                        $sr_no =$sr_no + 1;
                        $totalHours += $row["hours"];
                        }
                        
                    } else {
                        echo '<tr><td colspan="3">No volunteers found for ' . $grp_nm . '</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
            <div class="text-center mt-3">
                <h1>Your group has contributed a total of <?php echo $totalHours; ?> hours.</h1>
            </div>

        </div>
    </div>
</div>
<br><br>

<?php include '../../NSS_NEW/partial/_footer.php'; ?>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
