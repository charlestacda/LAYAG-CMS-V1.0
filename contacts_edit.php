<?php

include('includes/config.php');
include('includes/database.php');
include('includes/functions.php');
secure();


if (isset($_POST['unit_contact'])){

    if ($stm = $connect->prepare('UPDATE contacts set unit_name = ?, unit_contact = ?, unit_type = ? WHERE contact_id = ?')){
        $stm->bind_param('sssi', $_POST['unit_name'], $_POST['unit_contact'], $_POST['unit_type'], $_GET['contact_id']);
        $stm->execute();

        $stm->close();
        
        set_message("Contact Info number" . $_GET['contact_id'] . " has been updated");
        $profileId = $_GET['profile_id']; 
        $selectedProfileName = $_GET['profile_name']; 
        header("Location: contacts.php?profile_id=$profileId&profile_name=$selectedProfileName");
        die();


    } else {
        echo 'Could not prepare  user update statement!';
    }

}

include('includes/header.php');


if (isset($_GET['contact_id'])){
    if ($stm = $connect->prepare('SELECT * FROM contacts WHERE contact_id = ?')){
        $stm->bind_param('i', $_GET['contact_id']);
        $stm->execute();

        $result = $stm->get_result();
        $contacts = $result->fetch_assoc();

        if($contacts){






?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
        <h1 class="display-1">Edit Contact Info</h1>

        <form method="post">
                <!-- Name input -->
                <div class="form-outline mb-4">
                    <input type="text" id="unit_name" name="unit_name" class="form-control" value="<?php echo $contacts['unit_name'] ?>"/>
                    <label class="form-label" for="unit_name">Unit Name</label>
                </div>

                <!-- Contact input -->
                <div class="form-outline mb-4">
                    <textarea type="text" id="unit_contact" name="unit_contact" class="form-control"><?php echo $contacts['unit_contact'] ?></textarea>
                    <label class="form-label" for="unit_contact">Unit Contact</label>
                </div>

                <!-- Type input -->
                <div class="form-outline mb-4">
                    <select name="unit_type" class="form-select" id="unit_type">
                        <option <?php echo ($contacts['unit_type']) ? "selected" : ""; ?> value="Academic">Academic</option>
                        <option <?php echo ($contacts['unit_type']) ? "" : "selected"; ?> value="Administrative">Administrative</option>
                    </select>
                </div>
        

                <!-- Submit button -->
                <button type="submit" class="btn btn-primary btn-block">Update Contact Information</button>
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