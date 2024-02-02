<?php
include('includes/config.php');
include('includes/database.php');
include('includes/functions.php');
secure();

if (isset($_GET['delete'])) {
    if ($stm = $connect->prepare('DELETE FROM posts WHERE id = ?')) {
        $stm->bind_param('i', $_GET['delete']);
        $stm->execute();

        set_message("Post " . $_GET['delete'] . " has been deleted");
        $profileId = $_GET['profile_id'];
        $selectedProfileName = $_GET['profile_name'];
        header("Location: posts.php?profile_id=$profileId&profile_name=$selectedProfileName");
        $stm->close();
        die();
    } else {
        echo 'Could not prepare statement!';
    }
}

if ($stm = $connect->prepare('SELECT * FROM posts')) {
    $stm->execute();
    $result = $stm->get_result();

    include('includes/header.php');
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1 class="display-1">Posts Management</h1>
            <a href="posts_add.php?profile_id=<?php echo $profileId; ?>&profile_name=<?php echo $selectedProfileName; ?>" class="btn btn-success mb-3">Add New Post</a>
            <?php if ($result->num_rows > 0) { ?>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Author's ID</th>
                        <th>Content</th>
                        <th>Edit | Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($record = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $record['id']; ?></td>
                        <td><?php echo $record['title']; ?></td>
                        <td><?php echo $record['author']; ?></td>
                        <td><?php echo $record['content']; ?></td>
                        <td>
                            <a href="posts_edit.php?id=<?php echo $record['id']; ?>&profile_id=<?php echo $profileId; ?>&profile_name=<?php echo $selectedProfileName; ?>" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                            <a href="posts.php?delete=<?php echo $record['id']; ?>&profile_id=<?php echo $profileId; ?>&profile_name=<?php echo $selectedProfileName; ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php } else {
                echo '<p class="text-danger">No posts found</p>';
            } ?>
        </div>
    </div>
</div>

<?php
    $stm->close();
} else {
    echo 'Could not prepare statement!';
}
include('includes/footer.php');
?>
