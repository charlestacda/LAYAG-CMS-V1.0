<?php

include('includes/database.php');

// Initialize an array to store portal data
$notifsData = array();

if ($stm = $connect->prepare('SELECT * FROM notifications WHERE archived = 0')){
    $stm->execute();

    $result = $stm->get_result();

    if($result->num_rows > 0){
        // Loop through the rows and add them to the $tipsData array
        while($record = $result->fetch_assoc()) {
            $notifsData[] = array(
                'notif_id' => $record['notif_id'],
                'title' => $record['title'],
                'description' => $record['description'],
                'appear' => $record['appear'],
            );
        }
        // Output the JSON response
        header('Content-Type: application/json');
        echo json_encode($notifsData);
    } else {
        echo json_encode(array('message' => 'No notification found'));
    }
    $stm->close();
} else {
    echo json_encode(array('message' => 'Could not prepare statement'));
}
?>
