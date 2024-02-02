<?php

include('includes/database.php');

// Initialize an array to store portal data
$portalsData = array();

if ($stm = $connect->prepare('SELECT * FROM portals WHERE visible = 1 AND archived = 0')){
    $stm->execute();

    $result = $stm->get_result();

    if($result->num_rows > 0){
        // Loop through the rows and add them to the $portalsData array
        while($record = $result->fetch_assoc()) {
            $portalsData[] = array(
                'id' => $record['id'],
                'title' => $record['title'],
                'link' => $record['link'],
                'color' => $record['color'],
                'img' => $record['img']
            );
        }

        // Output the JSON response
        header('Content-Type: application/json');
        echo json_encode($portalsData);
    } else {
        echo json_encode(array('message' => 'No portals found'));
    }
    $stm->close();
} else {
    echo json_encode(array('message' => 'Could not prepare statement'));
}
?>
