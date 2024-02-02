<?php

include('includes/config.php');
include('includes/database.php');
include('includes/functions.php');
secure();


if (isset($_POST['username'])){

    if ($stm = $connect->prepare('INSERT INTO users (username, email, password, active) VALUES (?, ?, ?, ?)')){
        $hashed = SHA1($_POST['password']);
        $stm->bind_param('ssss', $_POST['username'], $_POST['email'], $hashed, $_POST['active']);
        $stm->execute();

        set_message("A new user " . $_POST['username'] . " has been added");
        $profileId = $_GET['profile_id']; 
        $selectedProfileName = $_GET['profile_name']; 
        header("Location: users.php?profile_id=$profileId&profile_name=$selectedProfileName");
        $stm->close();
        die();


    } else {
        echo 'Could not prepare statement!';
    }


    
}

include('includes/header.php');


?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
        <h1 class="display-1">Add User</h1>

        <form method="post">
                <!-- Username input -->
                <div class="form-outline mb-4">
                    <input type="username" id="username" name="username" class="form-control" />
                    <label class="form-label" for="username">Username</label>
                </div>
        
                <!-- Email input -->
                <div class="form-outline mb-4">
                    <input type="email" id="email" name="email" class="form-control" />
                    <label class="form-label" for="email">Email address</label>
                </div>

                <!-- Password input -->
                <div class="form-outline mb-4">
                    <input type="password" id="password" name="password" class="form-control" />
                    <label class="form-label" for="password">Password</label>
                </div>

                <!-- Active input -->
                <div class="form-outline mb-4">
                    <select name="active" class="form-select" id="active">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>

                <!-- Submit button -->
                <button type="submit" class="btn btn-primary btn-block">Add User</button>
            </form>
       

        </div>
    </div>
</div>



<?php
include('includes/footer.php');
?>