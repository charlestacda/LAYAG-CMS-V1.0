<?php
include('includes/config.php');
include('includes/database.php');
include('includes/functions.php');
secure();

if (isset($_POST['profile_name']) && isset($_POST['profile_desc'])) {
    $profileName = mysqli_real_escape_string($connect, $_POST['profile_name']);
    $profileDesc = mysqli_real_escape_string($connect, $_POST['profile_desc']);

    // Check if the profile name already exists
    $checkQuery = "SELECT * FROM profiles WHERE profile_name = '$profileName'";
    $checkResult = mysqli_query($connect, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        // Profile name already exists, return an error message
        echo "error|Profile name already taken";
    } else {
        // Insert a new profile into the database
        $insertQuery = "INSERT INTO profiles (profile_name, profile_desc) VALUES ('$profileName', '$profileDesc')";
        $insertResult = mysqli_query($connect, $insertQuery);

        if ($insertResult) {
            echo "success"; // Return success message to the AJAX call
        } else {
            echo "error|Error adding profile";
        }
    }
}
?>
