<?php  
include '../../NSS_NEW/partial/_dbconnector.php';

// session_start();


$username = $_SESSION['username'];
$existSql = "SELECT * FROM `project` WHERE username = '$username'";
$result = mysqli_query($conn, $existSql);
$numExistRows = mysqli_num_rows($result);
if ($numExistRows == 1){
    $row = mysqli_fetch_assoc($result);
    $username = $row['username'];
    $Proj_name = $row['proj_name'];
    $T_incharge = $row['T_incharge'];
    $total_eve = $row['total_eve'];   
    $position = $row['Position'];  
}
// echo $position;


?>

