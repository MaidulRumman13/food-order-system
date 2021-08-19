<?php include('partials/menu.php') ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Admin</h1>

        <br><br>

        <?php
        //1. Get id 
        $id = $_GET['id'];

        //2. Create SQL Query to get details
        $sql = "SELECT * FROM tl_admin WHERE id=$id";

        // Excute the Query
        $res = mysqli_query($conn, $sql);

        // Check Query 
        if ($res == true) {
            // Check Data
            $count = mysqli_num_rows($res);

            // Check Admin
            if ($count == 1) {
                // Get the details
                // Success and Available
                //echo "Available";
                $row = mysqli_fetch_assoc($res);

                $full_name = $row['full_name'];
                $username = $row['username'];
            } else {
                // Redirect to Manage Admin page.
                header("location:" . SITEURL . 'admin/manage-admin.php');
            }
        }
        ?>

        <form action="" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>Full Name</td>
                    <td>
                        <input type="text" name="full_name" value="<?php echo $full_name; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Username</td>
                    <td>
                        <input type="text" name="username" value="<?php echo $username; ?>">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="Submit" value="Update Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>

        </form>
    </div>

</div>

<?php
// Check submit or not
if (isset($_POST['Submit'])) {
    //echo "Yes";
    // Get value from form
    $id = $_POST['id'];
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);

    // Cerate query to update
    $sql = "UPDATE tl_admin SET
    full_name = '$full_name',
    username = '$username'
    WHERE id ='$id'
    ";

    // Excute query
    $res = mysqli_query($conn, $sql);

    //Check whather the(query is executed) data is updated or not and display message.
    if ($res == TRUE) 
    {
        //Data updated
        $_SESSION['update'] = "<div class = 'success'>Admin Updated Sucessfully.</div>";
        //Redirect page to manage admin
        header("location:" . SITEURL . 'admin/manage-admin.php');
    } else 
    {
        //Failed to updated
        $_SESSION['update'] = "<div class = 'error'>Fialed to update Admin.</div>";
        //Redirect page to Add admin
        header("location:" . SITEURL . 'admin/manage-admin.php');
    }
}
?>

<?php include('partials/footer.php') ?>