<?php
include('includes/config.php');
include('includes/database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $profileId = $_POST['profile_id'];

    // Perform the SQL delete operation
    $deleteQuery = "UPDATE profiles SET archived = 1 WHERE profile_id = '$profileId'";
    $deleteResult = mysqli_query($connect, $deleteQuery);

    if ($deleteResult) {
        echo "success"; // Return a success message
    } else {
        echo "error"; // Return an error message
    }
}
?>
