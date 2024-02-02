<?php

include('includes/config.php');
include('includes/database.php');
include('includes/functions.php');
secure();

if (isset($_POST['title'])) {
    $title = $_POST['title'];
    $link = $_POST['link'];
    $color = $_POST['color'];
    $visible = $_POST['visible'];
    $id = $_GET['id']; // Get the ID from the URL query parameters

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
            $upload_dir = 'images/';

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
        if ($stm = $connect->prepare('UPDATE portals SET title = ?, link = ?, color = ?, visible = ?, img = ? WHERE id = ?')) {
            $stm->bind_param('sssisi', $title, $link, $color, $visible, $img_destination, $id);
            if ($stm->execute()) {
                set_message("Portal with ID " . $id . " has been updated");
                $profileId = $_GET['profile_id']; 
                $selectedProfileName = $_GET['profile_name']; 
                header("Location: portals.php?profile_id=$profileId&profile_name=$selectedProfileName");
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
        if ($stm = $connect->prepare('UPDATE portals SET title = ?, link = ?, color = ?, visible = ? WHERE id = ?')) {
            $stm->bind_param('sssii', $title, $link, $color, $visible, $id);
            if ($stm->execute()) {
                set_message("Portal with ID " . $id . " has been updated");
                $profileId = $_GET['profile_id']; 
                $selectedProfileName = $_GET['profile_name']; 
                header("Location: portals.php?profile_id=$profileId&profile_name=$selectedProfileName");
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
    if ($stm = $connect->prepare('SELECT * FROM portals WHERE id = ?')) {
        $stm->bind_param('i', $_GET['id']);
        $stm->execute();

        $result = $stm->get_result();
        $portal = $result->fetch_assoc();

        if ($portal) {
            ?>
            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <h1 class="display-1">Edit Portal</h1>

                        <form method="post" enctype="multipart/form-data">
                            <!-- Username input -->
                            <div class="form-outline mb-4">
                                <input type="title" id="title" name="title" class="form-control"
                                    value="<?php echo $portal['title'] ?>" />
                                <label class="form-label" for="title">Title</label>
                            </div>

                            <!-- Link input -->
                            <div class="form-outline mb-4">
                                <input type="text" id="link" name="link" class="form-control"
                                    value="<?php echo $portal['link'] ?>" />
                                <label class="form-label" for="link">Link</label>
                            </div>

                            <!-- Color input -->
                            <div class="form mb-4">
                                <label for="color" class="form-label">Color</label>
                                <input type="color" class="form-control form-control-color" id="color"
                                    value="<?php echo $portal['color'] ?>" title="color" name="color">
                            </div>

                            <!-- Visible input -->
                            <div class="form-outline mb-4">
                                <select name="visible" class="form-select" id="visible">
                                    <option <?php echo ($portal['visible']) ? "selected" : ""; ?> value="1">Visible</option>
                                    <option <?php echo ($portal['visible']) ? "" : "selected"; ?> value="0">Invisible</option>
                                </select>
                            </div>

                            <!-- Image input -->
                            <div class="form mb-4">
                                <label for="img" class="form-label">Image</label>
                                <input class="form-control" type="file" id="img" name="img" value="<?php echo $portal['img'] ?>">
                            </div>

                            <!-- Submit button -->
                            <button type="submit" class="btn btn-primary btn-block">Update Portal</button>
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