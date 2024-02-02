<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMS </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <!-- Google Fonts Roboto -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" />
    <!-- MDB -->
    <link rel="stylesheet" href="css/mdb.min.css" />
    <link rel="stylesheet" href="css/styles.css" />

    <!-- Bootstrap JS (Popper included) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>
<style>
    .hero {
        width: 100%;
        height: 100vh;
        background-image: linear-gradient(rgba(66, 45, 161, 0.3), rgba(119, 105, 184, 0.3));
        position: relative;
        padding: 0 5%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .back-video {
        position: absolute;
        right: 0;
        bottom: 0;
        z-index: -1;
        width: 100%;
        height: 100%;
        object-fit: cover;
        /* Ensures the video covers the entire container */
    }


    .content h1 {
        font-size: 160px;
        color: #fff;
        font-weight: 600;

    }

    .content a {
        text-decoration: none;
        display: flex;
        justify-content: center;
        /* Center horizontally */
        align-items: center;
        /* Center vertically */
        color: #fff;
        font-size: 24px;
        border: 2px solid #fff;
        padding: 14px 20px;
        /* Reduced padding */
        border-radius: 50px;
        margin-top: 20px;
        width: 150px;
        /* Set a specific width */
        margin: 0 auto;
        /* Center the button horizontally within its container */
    }

    .initial-content {
        transition: opacity 0.3s ease;
        /* Smooth transition for opacity */
    }

    .login-form {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 100%;
        /* Ensure the form takes full width within its container */
    }

    .form-outline .form-control {
        border-top-color: #fff;
        border-bottom-color: #fff;
        border-left-color: #fff;
        border-right-color: #fff;
        background: #fff;
        border: 20px;
    }


    .custom-text {
        font-size: 70px;
        /* Adjust the font size as needed */
        color: #fff;
        /* Set the text color to white */
        font-weight: bold;
        /* Make the text bold */
        font-family: "Your Font", sans-serif;
        /* Use the desired font family */
        text-align: center;
        /* Center the text horizontally */
    }

    .text-container {
        text-align: center;
        /* Center the content horizontally */
        position: relative;
        /* Enable positioning */
        top: -110px;
        /* Move the content up by 30 pixels (adjust as needed) */
    }

    .custom-form {
        margin-top: -110px;
        /* Move the form up by 30 pixels (adjust as needed) */
    }

    .custom-form .mdb-required {
        color: black;
        /* Change the color to black */
    }

    .login-butt {
        background-color: transparent !important;
        border: 2px solid #fff;
        /* Add a border for better visibility */
        color: #fff;
        /* Set the text color to black or your preferred color */
        transition: border-color 0.3s ease;
        /* Add a smooth transition for a better user experience */
    }

    .login-butt:hover {
        border-color: #fff;
        /* Set the border color for the hover state */
    }


    .profile-button-container {
        border: 2px solid white;
        /* Adds a white border around the container */
        border-radius: 10px;
        /* Adds rounded corners */
        display: flex;
        /* Ensures the elements inside are in a row */
        align-items: center;
        /* Vertically aligns content */
        padding: 3px;
        /* Adds padding inside the border */
    }

    .profile-logo {
        width: 30px;
        /* Adjust the width as needed */
        height: 30px;
        /* Adjust the height as needed */
        margin-right: 10px;
        /* Adds space between the logo and the text */
    }

    .profile-link {
        color: white;
        /* Sets the text color to white */
        text-decoration: none;
        /* Removes the default underline */
    }

    /* Adjust the vertical alignment of the "Logout" button */
    ul.navbar-nav.d-flex.flex-row.me-1 li.nav-item:nth-child(2) {
        display: flex;
        align-items: center;
    }

    /* Ensure the "Logout" button text is vertically centered */
    ul.navbar-nav.d-flex.flex-row.me-1 li.nav-item:nth-child(2) a.nav-link {
        margin-top: 0;
        /* Reset the top margin */
        margin-bottom: 0;
        /* Reset the bottom margin */
    }

    body {
        background-color: #fbfbfb;
    }

    @media (min-width: 991.98px) {
        main {
            padding-left: 240px;
        }
    }


    /* Sidebar */
    .sidebar {
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        padding: 58px 0 0;
        /* Height of navbar */
        box-shadow: 0 2px 5px 0 rgb(0 0 0 / 5%), 0 2px 10px 0 rgb(0 0 0 / 5%);
        width: 250px;
        z-index: 600;
    }

    @media (max-width: 991.98px) {
        .sidebar {
            width: 100%;
        }
    }

    .sidebar .active {
        border-radius: 5px;
        box-shadow: 0 2px 5px 0 rgb(0 0 0 / 16%), 0 2px 10px 0 rgb(0 0 0 / 12%);
    }

    .sidebar-sticky {
        position: relative;
        top: 0;
        height: calc(100vh - 48px);
        padding-top: 0.5rem;
        overflow-x: hidden;
        overflow-y: auto;
        /* Scrollable contents if viewport is shorter than content. */
    }

    .custom-logo {
        padding: 0;
        /* Remove padding */
        margin: 0;
        /* Remove margin */
        max-height: 80px;
        /* Adjust the max height to make the logo larger */
    }

    .custom-nav {
        max-height: 30px;
        /* Adjust the max height to make the logo larger */
    }
</style>

<body>
    <?php
    if (isset($_GET['profile_id'])) {
        $profileId = $_GET['profile_id'];
    } else {

    }

    if (isset($_GET['profile_name'])) {
        $selectedProfileName = urldecode($_GET['profile_name']);
    } else {
        // Set a default profile name here if needed
        $selectedProfileName = "Default Profile";
    }
    ?>

    <?php
    if (isset($_SESSION['user_id']) && basename($_SERVER['PHP_SELF']) !== 'profile.php') {
        // User is logged in, so display the navbar
        ?>

        <!-- Sidebar -->
        <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse bg-white">
            <div class="position-sticky">
                <div class="list-group list-group-flush mx-3 mt-4">
                    <a href="dashboard.php?profile_id=<?php echo $profileId; ?>&profile_name=<?php echo $selectedProfileName; ?>"
                        class="list-group-item list-group-item-action py-2 ripple" aria-current="true">
                        <i class="fas fa-dharmachakra fa-fw me-3"></i><span>Main dashboard</span>
                    </a>
                    <a href="users.php?profile_id=<?php echo $profileId; ?>&profile_name=<?php echo $selectedProfileName; ?>"
                        class="list-group-item list-group-item-action py-2 ripple"><i
                            class="fas fa-users fa-fw me-3"></i><span>Users</span></a>
                    <a href="portals.php?profile_id=<?php echo $profileId; ?>&profile_name=<?php echo $selectedProfileName; ?>"
                        class="list-group-item list-group-item-action py-2 ripple"><i
                            class="fas fa-anchor fa-fw me-3"></i><span>Portals</span></a>
                    <a href="tips.php?profile_id=<?php echo $profileId; ?>&profile_name=<?php echo $selectedProfileName; ?>"
                        class="list-group-item list-group-item-action py-2 ripple"><i
                            class="fas fa-circle-info fa-fw me-3"></i><span>Tips</span></a>
                    <a href="handbooks.php?profile_id=<?php echo $profileId; ?>&profile_name=<?php echo $selectedProfileName; ?>"
                        class="list-group-item list-group-item-action py-2 ripple"><i
                            class="fas fa-book-open fa-fw me-3"></i><span>Handbooks</span></a>
                    <a href="events.php?profile_id=<?php echo $profileId; ?>&profile_name=<?php echo $selectedProfileName; ?>"
                        class="list-group-item list-group-item-action py-2 ripple"><i
                            class="fas fa-calendar-check fa-fw me-3"></i><span>Events</span></a>
                    <a href="notifications.php?profile_id=<?php echo $profileId; ?>&profile_name=<?php echo $selectedProfileName; ?>"
                        class="list-group-item list-group-item-action py-2 ripple"><i
                            class="fas fa-bell fa-fw me-3"></i><span>Notifications</span></a>
                    <a href="payments.php?profile_id=<?php echo $profileId; ?>&profile_name=<?php echo $selectedProfileName; ?>"
                        class="list-group-item list-group-item-action py-2 ripple"><i
                            class="fas fa-money-bill-wave k fa-fw me-3"></i><span>Payment Channels</span></a>
                    <a href="contacts.php?profile_id=<?php echo $profileId; ?>&profile_name=<?php echo $selectedProfileName; ?>"
                        class="list-group-item list-group-item-action py-2 ripple"><i
                            class="fas fa-address-book fa-fw me-3"></i><span>Contact Info</span></a>
                    <a href="helps.php?profile_id=<?php echo $profileId; ?>&profile_name=<?php echo $selectedProfileName; ?>"
                        class="list-group-item list-group-item-action py-2 ripple"><i
                            class="fas fa-circle-question fa-fw me-3"></i><span>Help Info</span></a>
                </div>
            </div>
        </nav>
        <!-- Sidebar -->

        <nav id="main-navbar" class="navbar navbar-expand-lg navbar-dark fixed-top" style="background-color: #b84444;">
            <div class="container-fluid">
                <!-- Toggle button -->
                <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#sidebarMenu"
                    aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                </button>
                <a class="navbar-brand custom-nav"
                    href="dashboard.php?profile_id=<?php echo $profileId; ?>&profile_name=<?php echo $selectedProfileName; ?>">
                    <img class="custom-logo" src="images/layag_logo.png" alt="LAYAG Logo">
                </a>

                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                </ul>

                <ul class="navbar-nav d-flex flex-row me-1">
                    <!-- Profile Logo and Button -->
                    <li class="nav-item me-3 me-lg-0">
                        <div class="profile-button">
                            <div class="profile-button-container">
                                <a class="nav-link profile-link" href="profile.php">
                                    <img src="images/profile_white.png" alt="Profile Logo" class="profile-logo">
                                    <?php echo $selectedProfileName; ?>
                                </a>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item me-3 me-lg-0">
                        <a class="nav-link profile-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
            </div>
        </nav>

        <div class="container-fluid" style="padding: 40px;">
            <div class="row">

                <!-- Main content -->
                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

                    <?php
    }
    ?>