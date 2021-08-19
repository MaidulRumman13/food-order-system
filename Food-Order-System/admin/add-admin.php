<?php include('partials/menu.php') ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>

        <br /><br />

        <?php
        if (isset($_SESSION['add'])) //Checking session (set or not)
        {
            echo $_SESSION['add']; // Display message
            unset($_SESSION['add']); //Removing message
        }
        ?>

        <br /><br />

        <form action="" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>Full Name: </td>
                    <td>
                        <input type="text" name="full_name" placeholder="Enter Your Name">
                    </td>
                </tr>

                <tr>
                    <td>Username: </td>
                    <td>
                        <input type="text" name="username" placeholder="Enter Your Username">
                    </td>
                </tr>

                <tr>
                    <td>Password: </td>
                    <td>
                        <input type="password" name="password" placeholder="Enter Your Password">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="Submit" value="Add Admin" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>
    </div>
</div>

<?php include('partials/footer.php') ?>

<?php
// Process the value from Form and save it in Database.

// Check whether the submit is click or not.

if (isset($_POST['Submit'])) {
    //button clicked
    //echo  "Clicked";

    //1. Get the data from the form
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = md5($_POST['password']); //md5 is a encryption function.

    //2. SQL Query to save data into database
    $sql = "INSERT INTO tl_admin SET
        full_name= '$full_name',
        username= '$username',
        password= '$password'
       ";

    //3. Excuting Query and saving Data into Database

    /*$host = "localhost";
       $dbUsername = "root";
       $dbPassword = "";
       $dbname = "food-order-sys";
       $conn = mysqli_connect('localhost', 'root', '') or die(mysqli_error()); //Database connection.
       $db_select = mysqli_select_db($conn,'food-order-sys') or die(mysqli_error()); //Selecting Database.*/

    $res = mysqli_query($conn, $sql) or die(mysqli_error());

    //4. Check whather the(query is executed) data is inserted or not and display message.
    if ($res == TRUE) {
        //Data inserted
        //echo "Data inserted";
        //Create a Session veriable to display message
        $_SESSION['add'] = "<div class = 'success'>Admin Added Sucessfully.</div>";
        //Redirect page to manage admin
        header("location:" . SITEURL . 'admin/manage-admin.php');
    } else {
        //Failed to insert data
        //echo "Failed to insert data";
        //Create a veriable to display message
        $_SESSION['add'] = "<div class = 'error'>Fialed to Add Admin.</div>";
        //Redirect page to Add admin
        header("location:" . SITEURL . 'admin/add-admin.php');
    }
}

?>