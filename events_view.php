<?php

include('includes/database.php');

// Initialize an array to store portal data
$eventsData = array();

if ($stm = $connect->prepare('SELECT * FROM calendar_events WHERE archived = 0')){
    $stm->execute();

    $result = $stm->get_result();

    if($result->num_rows > 0){
        // Loop through the rows and add them to the $tipsData array
        while($record = $result->fetch_assoc()) {
            $eventsData[] = array(
                'event_id' => $record['event_id'],
                'title' => $record['title'],
                'description' => $record['description'],
                'start_datetime' => $record['start_datetime'],
                'end_datetime' => $record['end_datetime'],
                'location' => $record['location'],
                'user_id' => $record['user_id'],
            );
        }

        // Output the JSON response
        header('Content-Type: application/json');
        echo json_encode($eventsData);
    } else {
        echo json_encode(array('message' => 'No events found'));
    }
    $stm->close();
} else {
    echo json_encode(array('message' => 'Could not prepare statement'));
}
?>
