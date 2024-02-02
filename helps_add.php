<?php

include('includes/config.php');
include('includes/database.php');
include('includes/functions.php');
secure();

if (isset($_POST['title'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $author = $_SESSION['user_id'];

    // Check if an image file was uploaded
    if (isset($_FILES['img']) && !empty($_FILES['img']['name'])) {
        $img_tmp_name = $_FILES['img']['tmp_name'];
        $img_error = $_FILES['img']['error'];

        // Check for file errors
        if ($img_error === 0) {
            // Specify the directory where the image will be stored
            $upload_dir = 'images/';

            // Generate a unique filename to avoid conflicts
            $img_name = $_FILES['img']['name'];
            $img_destination = $upload_dir . $img_name;

            // Move the uploaded file to the desired directory
            if (move_uploaded_file($img_tmp_name, $img_destination)) {
                // File uploaded successfully
            } else {
                echo 'Error uploading file.';
                exit(); // Terminate the script
            }
        } else {
            echo 'File upload error.';
            exit(); // Terminate the script
        }
    } else {
        // No file uploaded, set a default image name
        $img_name = 'default.png';
    }

    // Update the INSERT query to include the uploaded image filename and color
    if ($stm = $connect->prepare('INSERT INTO helps (title, author, content, img) VALUES (?, ?, ?, ?)')) {
        $stm->bind_param('siss', $title, $author, $content, $img_name);
        if ($stm->execute()) {
            set_message("A new help " . $title . " has been added");
            $profileId = $_GET['profile_id']; 
            $selectedProfileName = $_GET['profile_name']; 
            header("Location: helps.php?profile_id=$profileId&profile_name=$selectedProfileName");
            $stm->close();
            die();
        } else {
            echo 'Error inserting data into the database.';
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
        <h1 class="display-1">Add Help Information</h1>

        <form method="post" enctype="multipart/form-data">
                <!-- Title input -->
                <div class="form-outline mb-4">
                    <input type="text" id="title" name="title" class="form-control" />
                    <label class="form-label" for="title">Title</label>
                </div>

                <!-- Content input -->
                <div class="form-outline mb-4">
                    <textarea type="text" id="content" name="content" class="form-control"></textarea>
                    <label class="form-label" for="content">Content</label>
                </div>

                <!-- Image input -->
                <div class="form mb-4">
                    <label for="img" class="form-label">Image</label>
                    <input class="form-control" type="file" id="img" name="img">
                </div>

                <!-- Submit button -->
                <button type="submit" class="btn btn-primary btn-block">Add Help Info</button>
        </form>
       

        </div>
    </div>
</div>


<?php
include('includes/footer.php');
?>