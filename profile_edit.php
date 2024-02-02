<?php
include('includes/config.php');
include('includes/database.php');

secure();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $profileId = $_POST['profile_id'];
    $profileName = mysqli_real_escape_string($connect, $_POST['profile_name']);
    $profileDesc = mysqli_real_escape_string($connect, $_POST['profile_desc']);

    // Check if the new profile name already exists (excluding the current profile)
    $checkQuery = "SELECT * FROM profiles WHERE profile_name = '$profileName' AND profile_id != '$profileId'";
    $checkResult = mysqli_query($connect, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        // Profile name already exists, echo an error message
        echo "error|Profile name already exists";
    } else {
        // Perform the SQL update operation
        $updateQuery = "UPDATE profiles SET profile_name = '$profileName', profile_desc = '$profileDesc' WHERE profile_id = '$profileId'";
        $updateResult = mysqli_query($connect, $updateQuery);

        if ($updateResult) {
            echo "success|Profile updated successfully";
        } else {
            echo "error|Error updating profile";
        }
    }
}
?>
