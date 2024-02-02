<?php

include('includes/database.php');

// Initialize an array to store portal data
$handbooksData = array();

if ($stm = $connect->prepare('SELECT * FROM handbooks WHERE status = 1 AND archived = 0')){
    $stm->execute();

    $result = $stm->get_result();

    if($result->num_rows > 0){
        // Loop through the rows and add them to the $handbooksData array
        while($record = $result->fetch_assoc()) {
            $handbooksData[] = array(
                'id' => $record['id'],
                'title' => $record['title'],
                'content' => $record['content'],
                'status' => $record['status'],
            );
        }

        // Output the JSON response
        header('Content-Type: application/json');
        echo json_encode($handbooksData);
    } else {
        echo json_encode(array('message' => 'No handbooks found'));
    }
    $stm->close();
} else {
    echo json_encode(array('message' => 'Could not prepare statement'));
}
?>
