<?php

include('includes/database.php');

// Initialize an array to store portal data
$helpsData = array();

if ($stm = $connect->prepare('SELECT * FROM helps WHERE archived = 0')){
    $stm->execute();

    $result = $stm->get_result();

    if($result->num_rows > 0){
        // Loop through the rows and add them to the $portalsData array
        while($record = $result->fetch_assoc()) {
            $helpsData[] = array(
                'help_id' => $record['help_id'],
                'title' => $record['title'],
                'content' => $record['content'],
                'img' => $record['img']
            );
        }

        // Output the JSON response
        header('Content-Type: application/json');
        echo json_encode($helpsData);
    } else {
        echo json_encode(array('message' => 'No help infos found'));
    }
    $stm->close();
} else {
    echo json_encode(array('message' => 'Could not prepare statement'));
}
?>
