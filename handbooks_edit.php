<?php

include('includes/config.php');
include('includes/database.php');
include('includes/functions.php');
secure();

if (isset($_POST['title'])) {
    $title = $_POST['title'];
    $status = $_POST['status'];
    $id = $_GET['id']; // Get the ID from the URL query parameters

    // Check if an image file was uploaded
    if (!empty($_FILES['content']['name'])) {
        // Handle file upload
        $content_tmp_name = $_FILES['content']['tmp_name'];
        $content_error = $_FILES['content']['error'];

        // Check for file errors
        if ($content_error === 0) {
            // Specify the directory where the content will be stored
            $upload_dir = 'content/';

            // Generate a unique filename to avoid conflicts
            $content_name = $_FILES['content']['name'];
            $content_destination = $upload_dir . $content_name;

            // Move the uploaded file to the desired directory
            if (move_uploaded_file($content_tmp_name, $content_destination)) {
                // File uploaded successfully, update content with the new file
                if ($stm = $connect->prepare('UPDATE handbooks SET title = ?, content = ?, status = ? WHERE id = ?')) {
                    $stm->bind_param('ssii', $title, $content_name, $status, $id);
                    if ($stm->execute()) {
                        set_message("Handbook with ID " . $id . " has been updated");
                        $profileId = $_GET['profile_id']; 
                        $selectedProfileName = $_GET['profile_name']; 
                        header("Location: handbooks.php?profile_id=$profileId&profile_name=$selectedProfileName");
                        $stm->close();
                        die();
                    } else {
                        echo 'Error updating data in the database.';
                    }
                } else {
                    echo 'Could not prepare update statement!';
                }
            } else {
                echo 'Error uploading file.';
                exit(); // Terminate the script
            }
        } else {
            echo 'File upload error.';
            exit(); // Terminate the script
        }
    } else {
        // No file uploaded, update without changing content
        if ($stm = $connect->prepare('UPDATE handbooks SET title = ?, status = ? WHERE id = ?')) {
            $stm->bind_param('sii', $title, $status, $id);
            if ($stm->execute()) {
                set_message("Handbook with ID " . $id . " has been updated");
                $profileId = $_GET['profile_id']; 
                $selectedProfileName = $_GET['profile_name']; 
                header("Location: handbooks.php?profile_id=$profileId&profile_name=$selectedProfileName");
                $stm->close();
                die();
            } else {
                echo 'Error updating data in the database.';
            }
        } else {
            echo 'Could not prepare update statement!';
        }
    }
}

include('includes/header.php');

if (isset($_GET['id'])) {
    if ($stm = $connect->prepare('SELECT * FROM handbooks WHERE id = ?')) {
        $stm->bind_param('i', $_GET['id']);
        $stm->execute();

        $result = $stm->get_result();
        $handbook = $result->fetch_assoc();

        if ($handbook) {
            ?>
            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <h1 class="display-1">Edit Handbook</h1>

                        <form method="post" enctype="multipart/form-data">
                            <!-- Title input -->
                            <div class="form-outline mb-4">
                                <input type="title" id="title" name="title" class="form-control"
                                    value="<?php echo $handbook['title'] ?>" />
                                <label class="form-label" for="title">Title</label>
                            </div>

                            <!-- Content input -->
                            <div class="form mb-4">
                                <label for="content" class="form-label">Content</label>
                                <input class="form-control" type="file" id="content" name="content">
                            </div>

                            <!-- Status input -->
                            <div class="form-outline mb-4">
                                <select name="status" class="form-select" id="status">
                                    <option value="1" <?php echo ($handbook['status'] == 1) ? "selected" : ""; ?>>Active</option>
                                    <option value="0" <?php echo ($handbook['status'] == 0) ? "selected" : ""; ?>>Inactive</option>
                                </select>
                            </div>

                            <!-- Submit button -->
                            <button type="submit" class="btn btn-primary btn-block">Update Handbook</button>
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
    echo "No handbook selected";
    die();
}

include('includes/footer.php');
?>
