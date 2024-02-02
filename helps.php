<?php
include('includes/config.php');
include('includes/database.php');
include('includes/functions.php');
secure();

if (isset($_GET['delete'])) {
    if ($stm = $connect->prepare('UPDATE helps SET archived = 1 WHERE help_id = ?')) {
        $stm->bind_param('i', $_GET['delete']);
        $stm->execute();

        set_message("Help Information " . $_GET['delete'] . " has been deleted");
        $profileId = $_GET['profile_id'];
        $selectedProfileName = $_GET['profile_name'];
        header("Location: helps.php?profile_id=$profileId&profile_name=$selectedProfileName");
        $stm->close();
        die();
    } else {
        echo 'Could not prepare statement!';
    }
}

include('includes/header.php');

if ($stm = $connect->prepare('SELECT * FROM helps WHERE archived = 0')) {
    $stm->execute();
    $result = $stm->get_result();

    if ($result->num_rows > 0) {
?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1 class="display-1">Help Information Management</h1>
            <a href="helps_add.php?profile_id=<?php echo $profileId; ?>&profile_name=<?php echo $selectedProfileName; ?>" class="btn btn-success mb-3">Add New Help Information</a>
            <?php if ($result->num_rows > 0) { ?>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Author's ID</th>
                        <th>Content</th>
                        <th>Image</th>
                        <th>Edit | Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($record = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $record['help_id']; ?></td>
                        <td><?php echo $record['title']; ?></td>
                        <td><?php echo $record['author']; ?></td>
                        <td><?php echo $record['content']; ?></td>
                        <td>
                            <img src="https://charlestacda-layag_cms.mdbgo.io/images/<?php echo $record['img']; ?>"
                                width="200" title="<?php echo $record['img']; ?>">
                        </td>
                        <td>
                            <a href="helps_edit.php?help_id=<?php echo $record['help_id']; ?>&profile_id=<?php echo $profileId; ?>&profile_name=<?php echo $selectedProfileName; ?>"class="btn btn-primary"><i class="fas fa-edit"></i></a>
                            <a href="helps.php?delete=<?php echo $record['help_id']; ?>&profile_id=<?php echo $profileId; ?>&profile_name=<?php echo $selectedProfileName; ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php } else {
                echo '<p class="text-danger">No help information found</p>';
            } ?>
        </div>
    </div>
</div>

<?php
    } else {
        echo 'No help information found';
    }
    $stm->close();
} else {
    echo 'Could not prepare statement!';
}
include('includes/footer.php');
?>
