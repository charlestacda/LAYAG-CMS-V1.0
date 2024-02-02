<?php

include('includes/config.php');
include('includes/database.php');
include('includes/functions.php');
secure();


if (isset($_POST['unit_contact'])){

    if ($stm = $connect->prepare('INSERT INTO contacts (unit_name, unit_contact, unit_type) VALUES (?, ?, ?)')){
        $stm->bind_param('sss', $_POST['unit_name'], $_POST['unit_contact'], $_POST['unit_type']);
        $stm->execute();

        set_message("Contact number " . $_POST['contact_id'] . " has been added");
        $profileId = $_GET['profile_id']; 
        $selectedProfileName = $_GET['profile_name']; 
        header("Location: contacts.php?profile_id=$profileId&profile_name=$selectedProfileName");
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
        <h1 class="display-1">Add Contact Info</h1>

        <form method="post">
                <!-- Name input -->
                <div class="form-outline mb-4">
                    <input type="text" id="unit_name" name="unit_name" class="form-control" />
                    <label class="form-label" for="unit_name">Unit Name</label>
                </div>

                <!-- Contact input -->
                <div class="form-outline mb-4">
                    <textarea type="text" id="unit_contact" name="unit_contact" class="form-control"></textarea>
                    <label class="form-label" for="unit_contact">Unit Contact</label>
                </div>

                <!-- Type input -->
                <div class="form-outline mb-4">
                    <select name="unit_type" class="form-select" id="unit_type">
                        <option value="Academic">Academic</option>
                        <option value="Administrative">Administrative</option>
                    </select>
                </div>
        
                <!-- Submit button -->
                <button type="submit" class="btn btn-primary btn-block">Add Contact Information</button>
            </form>
       

        </div>
    </div>
</div>


<?php
include('includes/footer.php');
?>