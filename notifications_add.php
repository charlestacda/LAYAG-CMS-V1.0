<?php
include('includes/config.php');
include('includes/database.php');
include('includes/functions.php');
secure();

if (isset($_POST['title'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $appear = $_POST['appear'];

        if ($stmt = $connect->prepare('INSERT INTO notifications (title, description, appear) VALUES (?, ?, ?)')) {
            $stmt->bind_param('sss', $title, $description, $appear);
            if ($stmt->execute()) {
                set_message("The notification " . $_POST['title'] . " has been added");
                $profileId = $_GET['profile_id']; 
                $selectedProfileName = $_GET['profile_name']; 
                header("Location: notifications.php?profile_id=$profileId&profile_name=$selectedProfileName");
                $stm->close();
                die();
            } else {
                echo 'Error: ' . $stmt->error;
            }
        } else {
            echo 'Could not prepare statement!';
        }
}

include('includes/header.php');
?>

<div class="container mt-5 pb-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h1 class="display-1">Add Notification</h1>

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
                date_default_timezone_set('Asia/Manila'); 

                $currentDateTime = date('Y-m-d\TH:i', time());
                ?>
                    <input type="datetime-local" id="appear" name="appear" class="form-control" value="<?= $currentDateTime ?>" />
                    <label class="form-label" for="appear">Apear Date/Time</label>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Add Notification</button>

            </form>

        </div>
    </div>
</div>


<?php
include('includes/footer.php');
?>