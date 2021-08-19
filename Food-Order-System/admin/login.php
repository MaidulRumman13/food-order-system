<?php include('../config/constants.php'); ?>

<html>

<head>
    <title>Login - Good Food System</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>

<body>

    <div class="login">
        <h1 class="text-center">Login</h1>
        <br /><br />

        <?php
            if(isset($_SESSION['login']))
            {
                echo $_SESSION['login'];
                unset($_SESSION['login']);
            }

            if(isset($_SESSION['no-login-meggage']))
            {
                echo $_SESSION['no-login-meggage'];
                unset($_SESSION['no-login-meggage']);
            }
        ?>
        <br><br>

        <!--Login Starts Here -->
        <form action=""method="POST" class="text-center">
            Username: <br>
            <input type="text" name="username" placeholder="Enter Username">
            <br /><br />
            Password: <br>
            <input type="password" name="password" placeholder="Enter Password">
            <br /><br />
            <input type="submit" name="submit" value="Login" class="btn-primary">
            <br /><br />
        </form>
        <!--Login Ends Here -->

        <p class="text-center">Create By - <a href="#">Group 3</a></p>
    </div>

</body>

</html>

<?php

    if(isset($_POST['submit']))
    {
        //Process for loging
        //1. Get data from Form
        $username =mysqli_real_escape_string($conn, $_POST['username']);
        $password = md5($_POST['password']);
        

        //2. SQL to check username & password
        $sql = "SELECT * FROM tl_admin WHERE username='$username' AND password='$password'";

        //3. Excute Query
        $res =mysqli_query($conn, $sql);

        //4. Count rows for check user
        $count = mysqli_num_rows($res);

        if($count==1)
        {
            //Available & login
            $_SESSION['login'] = "<div class='success'>Login Successful</div>";
            $_SESSION['user'] =$username;//To check login or not
            //Redirect to home page 
            header('location:'.SITEURL.'admin/');
        }
        else
        {
            //Not available
            $_SESSION['login'] = "<div class='error text-center'>Login Failed</div>";
            //Redirect to home page 
            header('location:' . SITEURL . 'admin/login.php');
        }
    }

?>