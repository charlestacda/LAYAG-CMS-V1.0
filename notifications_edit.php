<?php

include('includes/config.php');
include('includes/database.php');
include('includes/functions.php');
secure();


if (isset($_POST['title'])) {

    if ($stm = $connect->prepare('UPDATE notifications set title = ?, description = ?, appear = ? WHERE notif_id = ?')) {
        $stm->bind_param('sssi', $_POST['title'], $_POST['description'], $_POST['appear'], $_GET['notif_id']);
        $stm->execute();

        $stm->close();


        set_message("Notification " . $_GET['notif_id'] . " has been updated");
        $profileId = $_GET['profile_id']; 
        $selectedProfileName = $_GET['profile_name']; 
        header("Location: notifications.php?profile_id=$profileId&profile_name=$selectedProfileName");
        die();


    } else {
        echo 'Could not prepare event update statement!';
    }




}

include('includes/header.php');

if (isset($_GET['notif_id'])) {
    if ($stm = $connect->prepare('SELECT * FROM notifications WHERE notif_id = ?')) {
        $stm->bind_param('i', $_GET['notif_id']);
        $stm->execute();

        $result = $stm->get_result();
        $notif = $result->fetch_assoc();

        if ($notif) {

            ?>
            <div class="container mt-5 pb-5">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <h1 class="display-1">Edit Notifications</h1>

                        <form method="post">
                            <div class="form-outline mb-4">
                                <input type="text" id="title" name="title" class="form-control"
                                    value="<?php echo $notif['title'] ?>" />
                                <label class="form-label" for="title">Title</label>
                            </div>

                            <div class="form-outline mb-4">
                                <textarea type="text" id="description" name="description"
                                    class="form-control"><?php echo $notif['description'] ?></textarea>
                                <label class="form-label" for="description">Description</label>
                            </div>

                            <div class="form-outline mb-4">
                                <input type="datetime-local" id="appear" name="appear" class="form-control"
                                    value="<?php echo $notif['appear'] ?>" />
                                <label class="form-label" for="appear">Appear Date and Time</label>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">Edit Notification</button>
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