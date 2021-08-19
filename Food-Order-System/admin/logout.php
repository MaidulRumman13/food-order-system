<?php
    include('../config/constants.php');
    //. Destroy the session 
    session_destroy();

    //2. Redirect to login page
    header('location:' . SITEURL . 'admin/login.php');
?>