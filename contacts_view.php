<?php

include('includes/database.php');

// Initialize an array to store portal data
$contactsData = array();

if ($stm = $connect->prepare('SELECT * FROM contacts WHERE archived = 0')){
    $stm->execute();

    $result = $stm->get_result();

    if($result->num_rows > 0){
        // Loop through the rows and add them to the $contactsData array
        while($record = $result->fetch_assoc()) {
            $contactsData[] = array(
                'contact_id' => $record['contact_id'],
                'unit_name' => $record['unit_name'],
                'unit_contact' => $record['unit_contact'],
                'unit_type' => $record['unit_type'],
            );
        }

        // Output the JSON response
        header('Content-Type: application/json');
        echo json_encode($contactsData);
    } else {
        echo json_encode(array('message' => 'No contact info found'));
    }
    $stm->close();
} else {
    echo json_encode(array('message' => 'Could not prepare statement'));
}
?>
