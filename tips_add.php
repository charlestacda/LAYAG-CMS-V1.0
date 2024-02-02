<?php

include('includes/config.php');
include('includes/database.php');
include('includes/functions.php');
secure();


if (isset($_POST['content'])){

    if ($stm = $connect->prepare('INSERT INTO tips (content, status) VALUES (?, ?)')){
        $stm->bind_param('si', $_POST['content'], $_POST['status']);
        $stm->execute();

        set_message("Tip number " . $_POST['id'] . " has been added");
        $profileId = $_GET['profile_id']; 
        $selectedProfileName = $_GET['profile_name']; 
        header("Location: tips.php?profile_id=$profileId&profile_name=$selectedProfileName");
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
        <h1 class="display-1">Add Tips</h1>

        <form method="post">
                <!-- Content input -->
                <div class="form-outline mb-4">
                    <input type="content" id="content" name="content" class="form-control" />
                    <label class="form-label" for="content">Content</label>
                </div>

                <!-- Status input -->
                <div class="form-outline mb-4">
                    <select name="status" class="form-select" id="status">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
        
                <!-- Submit button -->
                <button type="submit" class="btn btn-primary btn-block">Add Tip</button>
            </form>
       

        </div>
    </div>
</div>


<?php
include('includes/footer.php');
?>