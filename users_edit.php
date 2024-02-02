<?php

include('includes/config.php');
include('includes/database.php');
include('includes/functions.php');
secure();



if (isset($_POST['username'])){

    if ($stm = $connect->prepare('UPDATE users SET username = ?, email = ?, active = ? WHERE user_id = ?')) {
        $stm->bind_param('sssi', $_POST['username'], $_POST['email'], $_POST['active'], $_GET['user_id']);
        $stm->execute();
        $stm->close();
    
        if (!empty($_POST['password'])) {
            // Check if the password field is not empty
            if ($stm = $connect->prepare('UPDATE users SET password = ? WHERE user_id = ?')) {
                $hashed = SHA1($_POST['password']);
                $stm->bind_param('si', $hashed, $_GET['user_id']);
                $stm->execute();
            } else {
                echo 'Could not prepare password update statement!';
            }
        }
    
        set_message("User " . $_GET['user_id'] . " has been updated");
        $profileId = $_GET['profile_id'];
        $selectedProfileName = $_GET['profile_name'];
        header("Location: users.php?profile_id=$profileId&profile_name=$selectedProfileName");
        die();
    } else {
        echo 'Could not prepare user update statement!';
    }


    
 
}

include('includes/header.php');

if (isset($_GET['user_id'])){
    if ($stm = $connect->prepare('SELECT * FROM users WHERE user_id = ?')){
        $stm->bind_param('i', $_GET['user_id']);
        $stm->execute();

        $result = $stm->get_result();
        $user = $result->fetch_assoc();

        if($user){






?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
        <h1 class="display-1">Edit User</h1>

        <form method="post">
                <!-- Username input -->
                <div class="form-outline mb-4">
                    <input type="username" id="username" name="username" class="form-control active" value="<?php echo $user['username'] ?>"/>
                    <label class="form-label" for="username">Username</label>
                </div>
        
                <!-- Email input -->
                <div class="form-outline mb-4">
                    <input type="email" id="email" name="email" class="form-control active" value="<?php echo $user['email'] ?>" />
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
                        <option <?php echo ($user['active']) ? "selected" : ""; ?> value="1">Active</option>
                        <option <?php echo ($user['active']) ? "" : "selected"; ?> value="0">Inactive</option>
                    </select>
                </div>

                <!-- Submit button -->
                <button type="submit" class="btn btn-primary btn-block">Update User</button>
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
    echo "No user selected";
    die();
}

include('includes/footer.php');
?>