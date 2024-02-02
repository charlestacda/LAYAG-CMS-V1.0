<?php
include('includes/config.php');
include('includes/database.php');
include('includes/functions.php');
secure();

if (isset($_GET['delete'])) {
    if ($stm = $connect->prepare('UPDATE portals SET archived = 1 WHERE id = ?')) {
        $stm->bind_param('i', $_GET['delete']);
        $stm->execute();

        set_message("Portal " . $_GET['delete'] . " has been deleted");
        $profileId = $_GET['profile_id'];
        $selectedProfileName = $_GET['profile_name'];
        header("Location: portals.php?profile_id=$profileId&profile_name=$selectedProfileName");
        $stm->close();
        die();
    } else {
        echo 'Could not prepare statement!';
    }
}

include('includes/header.php');

if ($stm = $connect->prepare('SELECT * FROM portals WHERE archived = 0')) {
    $stm->execute();
    $result = $stm->get_result();

    if ($result->num_rows > 0) {
?>
<div class="container mt-5">
    <h1 class="display-1 text-center">Portals Management</h1>
    <a href="portals_add.php?profile_id=<?php echo $profileId; ?>&profile_name=<?php echo $selectedProfileName; ?>" class="btn btn-success mb-3">Add New Portal</a>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Link</th>
                    <th>Color</th>
                    <th>Status</th>
                    <th>Image</th>
                    <th>Edit | Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($record = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $record['id']; ?></td>
                    <td><?php echo $record['title']; ?></td>
                    <td><?php echo $record['link']; ?></td>
                    <td><?php echo $record['color']; ?></td>
                    <td><?php echo ($record['visible'] == 1) ? 'Visible' : 'Invisible'; ?></td>
                    <td>
                        <img src="https://charlestacda-layag_cms.mdbgo.io/images/<?php echo $record['img']; ?>" width="200" title="<?php echo $record['img']; ?>">
                    </td>
                    <td>
                        <a href="portals_edit.php?id=<?php echo $record['id']; ?>&profile_id=<?php echo $profileId; ?>&profile_name=<?php echo $selectedProfileName; ?>" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                        <a href="portals.php?delete=<?php echo $record['id']; ?>&profile_id=<?php echo $profileId; ?>&profile_name=<?php echo $selectedProfileName; ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<?php
    } else {
        echo '<p class="text-danger text-center">No portals found</p>';
    }
    $stm->close();
} else {
    echo 'Could not prepare statement!';
}
include('includes/footer.php');
?>
