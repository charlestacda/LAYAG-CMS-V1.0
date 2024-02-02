<?php

include('includes/config.php');
include('includes/database.php');
include('includes/functions.php');
secure();


if (isset($_POST['content'])){

    if ($stm = $connect->prepare('UPDATE tips set content = ?, status = ? WHERE id = ?')){
        $stm->bind_param('sii', $_POST['content'], $_POST['status'], $_GET['id']);
        $stm->execute();

        $stm->close();
        
        set_message("Tip number" . $_GET['id'] . " has been updated");
        $profileId = $_GET['profile_id']; 
        $selectedProfileName = $_GET['profile_name']; 
        header("Location: tips.php?profile_id=$profileId&profile_name=$selectedProfileName");
        die();


    } else {
        echo 'Could not prepare  user update statement!';
    }

}

include('includes/header.php');


if (isset($_GET['id'])){
    if ($stm = $connect->prepare('SELECT * FROM tips WHERE id = ?')){
        $stm->bind_param('i', $_GET['id']);
        $stm->execute();

        $result = $stm->get_result();
        $tips = $result->fetch_assoc();

        if($tips){






?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
        <h1 class="display-1">Edit Tips</h1>

        <form method="post">
                <!-- Content input -->
                <div class="form-outline mb-4">
                    <input type="content" id="content" name="content" class="form-control" value="<?php echo $tips['content'] ?>"/>
                    <label class="form-label" for="content">Content</label>
                </div>

                <!-- Status input -->
                <div class="form-outline mb-4">
                    <select name="status" class="form-select" id="status">
                        <option <?php echo ($tips['status']) ? "selected" : ""; ?> value="1">Active</option>
                        <option <?php echo ($tips['status']) ? "" : "selected"; ?> value="0">Inactive</option>
                    </select>
                </div>
        

                <!-- Submit button -->
                <button type="submit" class="btn btn-primary btn-block">Update Tip</button>
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
}else{
    echo "No tip selected";
    die();
}

include('includes/footer.php');
?>