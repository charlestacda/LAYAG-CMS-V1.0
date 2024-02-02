<?php

include('includes/config.php');
include('includes/database.php');
include('includes/functions.php');
secure();

if (isset($_POST['title'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $help_id = $_GET['help_id']; 

    // Initialize img_destination to null
    $img_destination = null;

    // Handle file upload
    if (isset($_FILES['img'])) {
        $img_name = $_FILES['img']['name'];
        $img_tmp_name = $_FILES['img']['tmp_name'];
        $img_size = $_FILES['img']['size'];
        $img_error = $_FILES['img']['error'];

        // Check for file errors
        if ($img_error === 0) {
            // Specify the directory where the image will be stored
            $upload_dir = '';

            // Generate a unique filename to avoid conflicts
            $img_destination = $upload_dir . $img_name;

            // Move the uploaded file to the desired directory
            if (move_uploaded_file($img_tmp_name, $img_destination)) {
                // File uploaded successfully
            } else {
                echo 'Error uploading file.';
                exit(); // Terminate the script
            }
        } 
    }

    // Check if an image was uploaded and update accordingly
    if (!empty($img_destination)) {
        if ($stm = $connect->prepare('UPDATE helps SET title = ?, content = ?, img = ? WHERE help_id = ?')) {
            $stm->bind_param('sssi', $title, $content, $img_destination, $help_id);
            if ($stm->execute()) {
                set_message("Help Info with ID " . $help_id . " has been updated");
                $profileId = $_GET['profile_id']; 
                $selectedProfileName = $_GET['profile_name']; 
                header("Location: helps.php?profile_id=$profileId&profile_name=$selectedProfileName");
                $stm->close();
                die();
            } else {
                echo 'Error updating data in the database.';
            }
        } else {
            echo 'Could not prepare update statement!';
        }
    } else {
        // No file uploaded, update without changing the image
        if ($stm = $connect->prepare('UPDATE helps SET title = ?, content = ? WHERE help_id = ?')) {
            $stm->bind_param('ssi', $title, $content, $help_id);
            if ($stm->execute()) {
                set_message("Help Info with ID " . $help_id . " has been updated");
                $profileId = $_GET['profile_id']; 
                $selectedProfileName = $_GET['profile_name']; 
                header("Location: helps.php?profile_id=$profileId&profile_name=$selectedProfileName");
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


if (isset($_GET['help_id'])) {
    if ($stm = $connect->prepare('SELECT * FROM helps WHERE help_id = ?')) {
        $stm->bind_param('i', $_GET['help_id']);
        $stm->execute();

        $result = $stm->get_result();
        $help = $result->fetch_assoc();

        if ($help) {
            ?>
            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <h1 class="display-1">Edit Help Information</h1>

                        <form method="post" enctype="multipart/form-data">
                            <!-- Title input -->
                            <div class="form-outline mb-4">
                                <input type="text" id="title" name="title" class="form-control" value="<?php echo $help['title'] ?>"/>
                                <label class="form-label" for="title">Title</label>
                            </div>

                            <!-- Content input -->
                            <div class="form-outline mb-4">
                                <textarea type="text" id="content" name="content"
                                    class="form-control"><?php echo $help['content'] ?></textarea>
                                <label class="form-label" for="content">Content</label>
                            </div>

                            <!-- Image input -->
                            <div class="form mb-4">
                                <label for="img" class="form-label">Image</label>
                                <input class="form-control" type="file" id="img" name="img" value="<?php echo $help['img'] ?>">
                            </div>

                            <!-- Submit button -->
                            <button type="submit" class="btn btn-primary btn-block">Update Help Info</button>
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
?>


<?php



include('includes/footer.php');
?>
