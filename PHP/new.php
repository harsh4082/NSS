<?php  
include '../../NSS_NEW/partial/_dbconnector.php';

// session_start();
// $username = $_SESSION['username'];
// $existSql = "SELECT * FROM `volunteer` WHERE Email = '$username'";
// $result = mysqli_query($conn, $existSql);
// $numExistRows = mysqli_num_rows($result);
// if ($numExistRows == 1){
//     $row = mysqli_fetch_assoc($result);
//     $sr_no = $row['Sr.No'];
//     $vol_id = $row['Vec_no'];
//     $gen = $row['Gender'];  
//     $cast = $row['Caste'];
//     $name = $row['Name'];
//     $dob = $row['DOB'];
//     $phone_no = $row['phone_no'];
//     $email = $row['Email'];
//     $bdgrp = $row['BG'];
//     $yoj = $row['YOJ'];
//     $class = $row['CLASS'];
//     $password = $row['Password'];
//     $hours = $row['hours'];
//     $grp_nm = $row['grp_nm'];
//     $img = $row['Image'];
        
// }

$username = $_SESSION['username'];
$existSql = "SELECT * FROM `student` WHERE username = '$username'";
$result = mysqli_query($conn, $existSql);
$numExistRows = mysqli_num_rows($result);
if ($numExistRows == 1){
    $row = mysqli_fetch_assoc($result);
    $sr_no = $row['id'];
    $vol_id = $row['student_id'];
    $gen = $row['gender'];  
    // $cast = $row['Caste'];
    $name = $row['fname'].' '.$row['sname'];
    // $dob = $row['DOB'];
    // $phone_no = $row['phone_no'];
    $email = $row['email'];
    // $bdgrp = $row['BG'];
    $yoj = $row['year'];
    $class = $row['class'];
    // $password = $row['Password'];
    $hours = $row['hours'];
    // $grp_nm = $row['grp_nm'];
    // $img = $row['Image'];
        
}


?>

