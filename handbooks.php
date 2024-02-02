<?php
include('includes/config.php');
include('includes/database.php');
include('includes/functions.php');
secure();

if (isset($_GET['delete'])) {
    if ($stm = $connect->prepare('UPDATE handbooks SET archived = 1 WHERE id = ?')) {
        $stm->bind_param('i', $_GET['delete']);
        $stm->execute();

        set_message("Handbook " . $_GET['delete'] . " has been deleted");
        $profileId = $_GET['profile_id'];
        $selectedProfileName = $_GET['profile_name'];
        header("Location: handbooks.php?profile_id=$profileId&profile_name=$selectedProfileName");
        $stm->close();
        die();
    } else {
        echo 'Could not prepare statement!';
    }
}

include('includes/header.php');

if ($stm = $connect->prepare('SELECT * FROM handbooks WHERE archived = 0')) {
    $stm->execute();
    $result = $stm->get_result();

    if ($result->num_rows > 0) {
?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1 class="display-1">Handbooks Management</h1>
            <a href="handbooks_add.php?profile_id=<?php echo $profileId; ?>&profile_name=<?php echo $selectedProfileName; ?>" class="btn btn-success mb-3">Add New Handbook</a>
            <?php if ($result->num_rows > 0) { ?>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Content</th>
                        <th>Status</th>
                        <th>Edit | Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($record = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $record['id']; ?></td>
                        <td><?php echo $record['title']; ?></td>
                        <td><?php echo $record['content']; ?></td>
                        <td><?php echo ($record['status'] == 1) ? 'Active' : 'Inactive'; ?></td>
                        <td>
                            <a href="handbooks_edit.php?id=<?php echo $record['id']; ?>&profile_id=<?php echo $profileId; ?>&profile_name=<?php echo $selectedProfileName; ?>" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                            <a href="handbooks.php?delete=<?php echo $record['id']; ?>&profile_id=<?php echo $profileId; ?>&profile_name=<?php echo $selectedProfileName; ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php } else {
                echo '<p class="text-danger">No handbooks found</p>';
            } ?>
        </div>
    </div>
</div>

<?php
    } else {
        echo 'No handbooks found';
    }
    $stm->close();
} else {
    echo 'Could not prepare statement!';
}
include('includes/footer.php');
?>
