<?php

include('includes/config.php');
include('includes/database.php');
include('includes/functions.php');
secure();

if (isset($_POST['content'])){

    if ($stm = $connect->prepare('INSERT INTO handbooks (title, content, status) VALUES (?, ?, ?)')){
        $stm->bind_param('ssi', $_POST['title'], $_POST['content'], $_POST['status']);
        $stm->execute();

        set_message("Handbook number " . $_POST['id'] . " has been added");
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

?>
<div class="container mt-5 pb-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h1 class="display-1">Add Handbook</h1>

            <form method="post">
                <!-- Title input -->
                <div class="form-outline mb-4">
                    <input type="title" id="title" name="title" class="form-control" />
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
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>

                <!-- Submit button -->
                <button type="submit" class="btn btn-primary btn-block">Add Handbook</button>
            </form>
        </div>
    </div>
</div>

<?php
include('includes/footer.php');
?>
