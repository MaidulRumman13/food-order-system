<?php include('partials/menu.php'); ?>
<div class="main-content">
    <div class="wrapper">
        <h1>Change Password</h1>
        <br><br>

        <?php
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
        }
        ?>

        <form action="" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>Old Password:</td>
                    <td>
                        <input type="password" name="current_password" placeholder="Current Password">
                    </td>
                </tr>

                <tr>
                    <td>New Password:</td>
                    <td>
                        <input type="password" name="new_password" placeholder="New Password">
                    </td>
                </tr>

                <tr>
                    <td>Confirm Password:</td>
                    <td>
                        <input type="password" name="confirm_password" placeholder="Confirm Password">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="Submit" value="Change Password" class="btn-secondary">

                        </td>
                </tr>
            </table>

        </form>

    </div>
</div>


<?php
    //check
    if(isset($_POST['Submit']))
    {
        //echo "yes";
        //1. Get the data from form
        $id = $_POST['id'];
        $current_password = md5($_POST['current_password']);
        $new_password = md5($_POST['new_password']);
        $confirm_password = md5($_POST['confirm_password']);

        //2. Check id and current password
        $sql =  "SELECT * FROM tl_admin WHERE id=$id AND password='$current_password'";

        // Excute Query
        $res = mysqli_query($conn, $sql);

        if($res == true)
        {
            // Check Data available or not
            $count = mysqli_num_rows($res);

            if($count == 1)
            {
                // Exists
                //echo "found";
                if($new_password == $confirm_password)
                {
                    // Update it
                    //echo "yes";
                    $sql2 = "UPDATE tl_admin SET
                        password = '$new_password' 
                        WHERE id = $id
                    ";
                    // Excute Query
                    $res2 = mysqli_query($conn, $sql2);

                    // Check excute or not
                    if ($res2 == TRUE)
                    {
                        //Change
                        $_SESSION['change'] = "<div class = 'success'>Password Changed Sucessfully.</div>";
                        //Redirect page to manage admin
                        header("location:" . SITEURL . 'admin/manage-admin.php');
                    }
                    else
                    {
                        //Failed to updated
                        $_SESSION['change'] = "<div class = 'error'>Fialed to Change Password.</div>";
                        //Redirect page to Add admin
                        header("location:" . SITEURL . 'admin/manage-admin.php');
                    }
                    
                }
                else
                {
                    // Redirect to Manage Admin with error message
                    $_SESSION['password-not-match'] = "<div class = 'error'>New Password Did Not Match.</div>";
                    //Redirect page to manage admin
                    header("location:" . SITEURL . 'admin/manage-admin.php');
                }
            }
            else
            {
                // Not exists
                $_SESSION['user-not-found'] = "<div class = 'error'>User Not Found.</div>";
                //Redirect page to manage admin
                header("location:" . SITEURL . 'admin/manage-admin.php');
            }
        }
        //3. Check new password and confirm password aer match

        //4. Change password 
    }
?>


<?php include('partials/footer.php'); ?>