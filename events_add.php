<?php
include('includes/config.php');
include('includes/database.php');
include('includes/functions.php');
secure();

if (isset($_POST['title'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $start_datetime = $_POST['start_datetime'];
    $end_datetime = $_POST['end_datetime'];
    $location = $_POST['location'];

    // Check if the user is logged in and has a valid user ID in the session
    if (isset($_SESSION['user_id']) && $_SESSION['user_id'] !== null) {
        $user_id = $_SESSION['user_id'];

        if ($stmt = $connect->prepare('INSERT INTO calendar_events (title, description, start_datetime, end_datetime, location, user_id) VALUES (?, ?, ?, ?, ?, ?)')) {
            $stmt->bind_param('sssssi', $title, $description, $start_datetime, $end_datetime, $location, $user_id);
            if ($stmt->execute()) {
                set_message("The event " . $_POST['title'] . " has been added");
                $profileId = $_GET['profile_id']; 
                $selectedProfileName = $_GET['profile_name']; 
                header("Location: events.php?profile_id=$profileId&profile_name=$selectedProfileName");
                $stm->close();
                die();
            } else {
                echo 'Error: ' . $stmt->error;
            }
        } else {
            echo 'Could not prepare statement!';
        }
    } else {
        echo 'User is not logged in or has an invalid user ID.';
    }
}

include('includes/header.php');
?>

<div class="container mt-5 pb-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h1 class="display-1">Add Event</h1>

            <!-- Display error message if there is one -->
            <?php if (!empty($error_message)): ?>
                <p>Error:
                    <?= $error_message ?>
                </p>
            <?php endif; ?>

            <form method="post">

                <div class="form-outline mb-4">
                    <input type="text" id="title" name="title" class="form-control" />
                    <label class="form-label" for="title">Title</label>
                </div>

                <div class="form-outline mb-4">
                    <textarea type="text" id="description" name="description" class="form-control"></textarea>
                    <label class="form-label" for="description">Description</label>
                </div>

                <div class="form-outline mb-4">
                    <?php
                    // Get the current date in the format required by datetime-local input
                    $currentDate = date('Y-m-d');

                    // Set the default start time to 8:00 AM and end time to 5:00 PM
                    $defaultStartTime = 'T07:00';
                    $defaultEndTime = 'T20:00';
                    ?>
                    <input type="datetime-local" id="start_datetime" name="start_datetime" class="form-control"
                        value="<?= $currentDate . $defaultStartTime ?>" />
                    <label class="form-label" for="start_datetime">Date and Time of Start</label>
                </div>

                <div class="form-outline mb-4">
                    <input type="datetime-local" id="end_datetime" name="end_datetime" class="form-control"
                        value="<?= $currentDate . $defaultEndTime ?>" />
                    <label class="form-label" for="end_datetime">Date and Time of End</label>
                </div>

                <div class="form-outline mb-4">
                    <input type="text" id="location" name="location" class="form-control" value="LPU - Cavite"/>
                    <label class="form-label" for="location">Location</label>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Add Event</button>

            </form>

        </div>
    </div>
</div>


<?php
include('includes/footer.php');
?>