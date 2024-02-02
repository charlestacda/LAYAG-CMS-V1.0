<?php

function secure()
{
    if (!isset($_SESSION['user_id'])) {
        set_message("Please login first to view this page.");
        header('Location: /layag_cms');
        die();
    }
}

function set_message($message, $color = 'success') {
    $_SESSION['message'] = ['text' => $message, 'color' => $color];
}

function get_message() {
    if (isset($_SESSION['message'])) {
        $message = $_SESSION['message']['text'];
        $color = $_SESSION['message']['color'];
        echo "<script type='text/javascript'> showToast('" . $message . "','top right', '" . $color . "') </script>";
        unset($_SESSION['message']);
    }
}
