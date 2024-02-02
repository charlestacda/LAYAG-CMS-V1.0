<?php

include('includes/config.php');
include('includes/database.php');
include('includes/functions.php');
secure();


if (isset($_POST['title'])) {

    if ($stm = $connect->prepare('UPDATE calendar_events set title = ?, description = ?, start_datetime = ?, end_datetime = ?, location = ? WHERE event_id = ?')) {
        $stm->bind_param('sssssi', $_POST['title'], $_POST['description'], $_POST['start_datetime'], $_POST['end_datetime'], $_POST['location'], $_GET['event_id']);
        $stm->execute();

        $stm->close();


        set_message("Event " . $_GET['event_id'] . " has been updated");
        $profileId = $_GET['profile_id']; 
        $selectedProfileName = $_GET['profile_name']; 
        header("Location: events.php?profile_id=$profileId&profile_name=$selectedProfileName");
        die();


    } else {
        echo 'Could not prepare event update statement!';
    }




}

include('includes/header.php');

if (isset($_GET['event_id'])) {
    if ($stm = $connect->prepare('SELECT * FROM calendar_events WHERE event_id = ?')) {
        $stm->bind_param('i', $_GET['event_id']);
        $stm->execute();

        $result = $stm->get_result();
        $event = $result->fetch_assoc();

        if ($event) {

            ?>
            <div class="container mt-5 pb-5">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <h1 class="display-1">Edit Event</h1>

                        <form method="post">
                            <div class="form-outline mb-4">
                                <input type="text" id="title" name="title" class="form-control"
                                    value="<?php echo $event['title'] ?>" />
                                <label class="form-label" for="title">Title</label>
                            </div>

                            <div class="form-outline mb-4">
                                <textarea type="text" id="description" name="description"
                                    class="form-control"><?php echo $event['description'] ?></textarea>
                                <label class="form-label" for="description">Description</label>
                            </div>

                            <div class="form-outline mb-4">
                                <input type="datetime-local" id="start_datetime" name="start_datetime" class="form-control"
                                    value="<?php echo $event['start_datetime'] ?>" />
                                <label class="form-label" for="start_datetime">Date and Time of Start</label>
                            </div>

                            <div class="form-outline mb-4">
                                <input type="datetime-local" id="end_datetime" name="end_datetime" class="form-control"
                                    value="<?php echo $event['end_datetime'] ?>" />
                                <label class="form-label" for="end_datetime">Date and Time of End</label>
                            </div>

                            <div class="form-outline mb-4">
                                <input type="text" id="location" name="location" class="form-control"
                                    value="<?php echo $event['location'] ?>" />
                                <label class="form-label" for="location">Location</label>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">Edit Event</button>
                        </form>

                    </div>
                </div>
            </div>


            <?php
        }
        $stm->close();


    } else {
        echo 'Could not prepare statement!';
    }
} else {
    echo "No user selected";
    die();
}

include('includes/footer.php');
?>