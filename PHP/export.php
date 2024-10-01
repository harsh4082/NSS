<?php
require '../../NSS_NEW/partial/_dbconnector.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["Event_nm"]) && isset($_POST["date"])) {
    $eventName = $_POST["Event_nm"];
    $eventDate = $_POST["date"];

    // $query = "SELECT a.Name, a.Date, a.Level, a.vec_no, v.First_name, v.Vec_no FROM attend a
    // LEFT JOIN volunteer v ON a.vec_no = v.`Sr.No`
    // WHERE a.Name = ? AND a.Date = ?
    // ";
    $query = "SELECT a.Name, a.Date, a.Level, a.vec_no, s.fname AS volunteer_name, s.student_id 
    FROM attend a
    LEFT JOIN student s ON a.vec_no = s.`id`
    WHERE a.Name = ? AND a.Date = ?";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ss", $eventName, $eventDate);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        $data = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        if (!empty($data)) {
            $csvFilename = str_replace(' ', '_', $eventName) . '_' . date('Y-m-d_H-i-s') . '.csv';

            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $csvFilename . '"');

            $output = fopen('php://output', 'w');

            // Define CSV header
            fputcsv($output, array('Name', 'Date', 'Level', 'Vec_no', 'First_name' , 'Vec_no'));

            // Write data to CSV
            foreach ($data as $row) {
                fputcsv($output, $row);
            }

            fclose($output);
            exit;
        } else {
            echo "No data available for download.";
        }
    } else {
        echo "No data found for the selected event and date.";
    }
} else {
    echo "Invalid request.";
}
