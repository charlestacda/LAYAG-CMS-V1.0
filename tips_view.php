<?php

include('includes/database.php');

// Initialize an array to store portal data
$tipsData = array();

if ($stm = $connect->prepare('SELECT * FROM tips WHERE status = 1 AND archived = 0')){
    $stm->execute();

    $result = $stm->get_result();

    if($result->num_rows > 0){
        // Loop through the rows and add them to the $tipsData array
        while($record = $result->fetch_assoc()) {
            $tipsData[] = array(
                'id' => $record['id'],
                'content' => $record['content'],
            );
        }

        // Output the JSON response
        header('Content-Type: application/json');
        echo json_encode($tipsData);
    } else {
        echo json_encode(array('message' => 'No tips found'));
    }
    $stm->close();
} else {
    echo json_encode(array('message' => 'Could not prepare statement'));
}
?>
