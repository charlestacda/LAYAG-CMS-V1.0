<?php
include('includes/config.php');
include('includes/database.php');
include('includes/functions.php');
secure();

if (isset($_GET['delete'])) {
    if ($stm = $connect->prepare('UPDATE calendar_events SET archived = 1 WHERE event_id = ?')) {
        $stm->bind_param('i', $_GET['delete']);
        $stm->execute();

        set_message("Event " . $_GET['delete'] . " has been deleted");
        $profileId = $_GET['profile_id'];
        $selectedProfileName = $_GET['profile_name'];
        header("Location: events.php?profile_id=$profileId&profile_name=$selectedProfileName");
        $stm->close();
        die();
    } else {
        echo 'Could not prepare statement!';
    }
}

include('includes/header.php');

if ($stm = $connect->prepare('SELECT * FROM calendar_events WHERE archived = 0')) {
    $stm->execute();
    $result = $stm->get_result();

    if ($result->num_rows > 0) {
?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1 class="display-1">Events Management</h1>
            <a href="events_add.php?profile_id=<?php echo $profileId; ?>&profile_name=<?php echo $selectedProfileName; ?>" class="btn btn-success mb-3">Add New Event</a>
            <?php if ($result->num_rows > 0) { ?>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Start Date/Time</th>
                        <th>End Date/Time</th>
                        <th>Location</th>
                        <th>User ID</th>
                        <th>Edit | Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($record = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $record['event_id']; ?></td>
                        <td><?php echo $record['title']; ?></td>
                        <td><?php echo $record['description']; ?></td>
                        <td><?php echo $record['start_datetime']; ?></td>
                        <td><?php echo $record['end_datetime']; ?></td>
                        <td><?php echo $record['location']; ?></td>
                        <td><?php echo $record['user_id']; ?></td>
                        <td>
                            <a href="events_edit.php?event_id=<?php echo $record['event_id']; ?>&profile_id=<?php echo $profileId; ?>&profile_name=<?php echo $selectedProfileName; ?>" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                            <a href="events.php?delete=<?php echo $record['event_id']; ?>&profile_id=<?php echo $profileId; ?>&profile_name=<?php echo $selectedProfileName; ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php } else {
                echo '<p class="text-danger">No events found</p>';
            } ?>
        </div>
    </div>
</div>

<?php
    } else {
        echo 'No events found';
    }
    $stm->close();
} else {
    echo 'Could not prepare statement!';
}
include('includes/footer.php');
?>
