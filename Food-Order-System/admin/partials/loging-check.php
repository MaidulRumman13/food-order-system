<?php
    //Authorization - Access Control
    // Check the user id logged in or not
    if(!isset($_SESSION['user'])) // If user session ids not det
    {
        //User is not loging
        //Redirect to loging page with massage
        $_SESSION['no-login-meggage'] = "<div class='error text-center'>Please Login to Access.</div>";
        header('location:' . SITEURL . 'admin/login.php');
    }

?>