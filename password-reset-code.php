<?php
session_start();
include('includes/database.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function send_password_reset($get_name, $get_email, $token)
{
    $mail = new PHPMailer(true); // Initialize PHPMailer

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->Username = "lpuc.layag@gmail.com";
        $mail->Password = "wfqj zsvg bhpo ncmt";
        $mail->SMTPSecure = "tls";
        $mail->Port = 587;

        // Sender and recipient
        $mail->setFrom("lpuc.layag@gmail.com", $get_name);
        $mail->addAddress($get_email);

        // Email content
        $mail->isHTML(true);
        $mail->Subject = "Reset Password Notification";

        $email_template = "
            <h2>Hello</h2>
            <h3>You are receiving this email because we received a password reset request for your account.</h3>
            <br/><br/>
            <a href='http://charlestacda-layag_cms.mdbgo.io/password-change.php?token=$token&email=$get_email'> Click Me </a>
        ";
        $mail->Body = $email_template; // Assign email body

        $mail->send(); // Send email

        return true; // Email sent successfully
    } catch (Exception $e) {
        return $mail->ErrorInfo; // Return error message if sending fails
    }
}

if (isset($_POST['password_reset_link'])) {
    $email = mysqli_real_escape_string($connect, $_POST['email']);
    $token = md5(rand());

    $check_email = "SELECT email, username FROM users WHERE email='$email' LIMIT 1";
    $check_email_run = mysqli_query($connect, $check_email);

    if (mysqli_num_rows($check_email_run) > 0) {
        $row = mysqli_fetch_array($check_email_run);
        $get_name = $row['username'];
        $get_email = $row['email'];

        $update_token = "UPDATE users SET verify_token='$token' WHERE email='$get_email' LIMIT 1";
        $update_token_run = mysqli_query($connect, $update_token);

        if ($update_token_run) {
            $email_sent = send_password_reset($get_name, $get_email, $token);
            if ($email_sent === true) {
                $_SESSION['status'] = "We e-mailed you a password reset link";
            } else {
                $_SESSION['status'] = "Error sending email: " . $email_sent;
            }
            header("Location: password-reset.php");
            exit(0);
        } else {
            $_SESSION['status'] = "Something went wrong. #1";
        }
    } else {
        $_SESSION['status'] = "No Email Found";
        header("Location: password-reset.php");
        exit(0);
    }
}

if (isset($_POST['password_update'])) {
    $email = mysqli_real_escape_string($connect, $_POST['email']);
    $new_password = mysqli_real_escape_string($connect, $_POST['new_password']);
    $confirm_password = mysqli_real_escape_string($connect, $_POST['confirm_password']);
    $token = mysqli_real_escape_string($connect, $_POST['password_token']);

    if (!empty($token)) {
        if (!empty($token) && !empty($new_password) && !empty($confirm_password)) {
            // Checking if the Token is Valid
            $check_token = "SELECT verify_token FROM users WHERE verify_token='$token' LIMIT 1";
            $check_token_run = mysqli_query($connect, $check_token);

            if (mysqli_num_rows($check_token_run) > 0) {
                if ($new_password === $confirm_password) {
                    // Hash the new password using SHA1
                    $hashed_password = sha1($new_password);

                    // Update the user's password with the hashed password
                    $update_password = "UPDATE users SET password='$hashed_password' WHERE verify_token='$token' LIMIT 1";
                    $update_password_run = mysqli_query($connect, $update_password);

                    if ($update_password_run) {
                        $new_token = md5(rand()) . "funda";
                        $update_to_new_token = "UPDATE users SET verify_token='$new_token' WHERE verify_token='$token' LIMIT 1";
                        $update_to_new_token_run = mysqli_query($connect, $update_to_new_token);

                        $_SESSION['status'] = "New Password Successfully Updated";
                        header("Location: index.php");
                        exit(0);
                    } else {
                        $_SESSION['status'] = "Failed to update password. Something went wrong!";
                    }
                } else {
                    $_SESSION['status'] = "Password and Confirm Password do not match";
                }
            } else {
                $_SESSION['status'] = "Invalid Token";
            }
        } else {
            $_SESSION['status'] = "All fields are mandatory";
        }

        // Redirect to the password-change.php page with token and email parameters
        header("Location: password-change.php?token=$token&email=$email");
        exit(0);
    } else {
        $_SESSION['status'] = "No Token Available";
        header("Location: password-change.php");
        exit(0);
    }
}

