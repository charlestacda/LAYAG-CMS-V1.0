<?php

include('includes/config.php');
include('includes/database.php');
include('includes/functions.php');
secure();



if (isset($_POST['title'])){

    if ($stm = $connect->prepare('INSERT INTO posts (title, content, author, date) VALUES (?, ?, ?, ?)')){
        $stm->bind_param('ssis', $_POST['title'], $_POST['content'],$_SESSION['user_id'], $_POST['date']);
        $stm->execute();

        set_message("The post " . $_POST['title'] . " has been added");
        $profileId = $_GET['profile_id']; 
        $selectedProfileName = $_GET['profile_name']; 
        header("Location: posts.php?profile_id=$profileId&profile_name=$selectedProfileName");
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
        <h1 class="display-1">Add Post</h1>

        <form method="post">
                <!-- Title input -->
                <div class="form-outline mb-4">
                    <input type="text" id="title" name="title" class="form-control" />
                    <label class="form-label" for="title">Title</label>
                </div>

                <!-- Content input -->
                <div class="form-outline mb-4">
                    <label class="form-label" for="content">Content</label>
                    <textarea name="content" id="content"></textarea>
                </div>

                <!-- Date input -->
                <div class="form-outline mb-4">
                    <input type="date" id="date" name="date" class="form-control" value="<?php echo date('Y-m-d'); ?>"/>
                    <label class="form-label" for="date">Date</label>
                </div>

                <!-- Submit button -->
                <button type="submit" class="btn btn-primary btn-block">Add Post</button>
        </form>
       

        </div>
    </div>
</div>


<script src="js/tinymce/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector: '#content'
    });
</script>
<?php
include('includes/footer.php');
?>