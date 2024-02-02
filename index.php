<?php
include('includes/config.php');
include('includes/database.php');
include('includes/functions.php');

if (isset($_SESSION['user_id'])) {
    header('Location: profile.php');
    die();
}

if (isset($_POST['email'])) {
    if ($stm = $connect->prepare('SELECT * FROM users WHERE email = ?')) {
        $stm->bind_param('s', $_POST['email']);
        $stm->execute();

        $result = $stm->get_result();
        $user = $result->fetch_assoc();

        if ($user) {
            if ($user['active'] == 1) {
                // Email found and account is active, check password
                $hashed = SHA1($_POST['password']);
                if ($hashed === $user['password']) {
                    // Password is correct, set session and redirect to profile
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['username'] = $user['username'];

                    set_message("You have successfully logged in " . $_SESSION['username'], "success");
                    header('Location: profile.php');
                    die();
                } else {
                    // Password is incorrect
                    set_message("Password is incorrect", "error");
                }
            } else {
                // Account is inactive
                set_message("The account you are trying to access is inactive", "error");
            }
        } else {
            // Email not found in the database
            set_message("Account is not registered", "error");
        }
        $stm->close();
    } else {
        echo 'Could not prepare statement!';
    }
}

include('includes/header.php');
?>
<div class="hero">

    <audio loop autoplay>
        <source src="audios/ocean_bg.mp3" type="audio/mpeg">

    </audio>

    <video autoplay loop muted plays-inline class="back-video">
        <source src="images/ocean.mp4" type="video/mp4">
    </video>

    

    <div class="initial-content">
    <div class="content">
        <h1>LAYAG</h1>
        <a href="#" id="showLoginForm">Log in</a>
    </div>
    </div>

<div class="login-form container mt-5" style="display: none;">
    <div class="row justify-content-center">
        <div class="col-md-6">
        <div class="text-container">
            <!-- Text with custom style -->
            <p class="custom-text">LOG IN</p>
        </div>
            <form method="post" class="custom-form ">
                <!-- Email input -->
                <div class="form-outline mb-4">
                    <input type="email" id="email" name="email" class="form-control mdb-required" />
                    <label class="form-label" for="email" style="color: #000000;">Email address</label>
                </div>

                <!-- Password input -->
                <div class="form-outline mb-4">
                    <input type="password" id="password" name="password" class="form-control mdb-required" />
                    <label class="form-label" for="password" style="color: #000000;">Password</label>
                </div>

                <!-- 2 column grid layout for inline styling -->
                <div class="row mb-4">
                    <div class="col">
                        <!-- Simple link -->
                        <a href="password-reset.php" style="color: #fff;">Forgot password?</a>
                    </div>
                </div>

                <!-- Submit button -->
                <button type="submit" class="btn btn-primary btn-block login-butt">Log in</button>
            </form>
        </div>
    </div>
</div>


</div>

<script>
    document.getElementById("showLoginForm").addEventListener("click", function () {
    var loginForm = document.querySelector(".login-form");
    var initialContent = document.querySelector(".initial-content");
    
    if (initialContent.style.opacity === "1" || initialContent.style.opacity === "") {
        initialContent.style.opacity = "0";
        setTimeout(function () {
            loginForm.style.display = "block";
        }, 300); // Wait for the opacity transition to complete
    } else {
        loginForm.style.display = "none";
        setTimeout(function () {
            initialContent.style.opacity = "1";
        }, 300); // Wait for the opacity transition to complete
    }
});

</script>

<?php
include('includes/footer.php');
?>