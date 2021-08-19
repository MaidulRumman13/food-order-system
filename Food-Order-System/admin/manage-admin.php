<?php include('partials/menu.php') ?>
<!--Main Content Section Starts -->
<div class="main-content">
    <div class="wrapper">
        <h1>Manage Admin</h1>

        <br /><br />

        <?php
        if (isset($_SESSION['add'])) 
        {
            echo $_SESSION['add']; // Display message
            unset($_SESSION['add']); //Removing message
        }

        if (isset($_SESSION['delete'])) 
        {
            echo $_SESSION['delete']; // Display message
            unset($_SESSION['delete']); //Removing message
        }

        if (isset($_SESSION['update'])) 
        {
            echo $_SESSION['update']; // Display message
            unset($_SESSION['update']); //Removing message
        }

        if (isset($_SESSION['user-not-found'])) 
        {
            echo $_SESSION['user-not-found']; // Display message
            unset($_SESSION['user-not-found']); //Removing message 
        }

        if (isset($_SESSION['password-not-match'])) 
        {
            echo $_SESSION['password-not-match']; // Display message
            unset($_SESSION['password-not-match']); //Removing message password-not-match
        }

        if (isset($_SESSION['change'])) 
        {
            echo $_SESSION['change']; // Display message
            unset($_SESSION['change']); //Removing message password-not-match
        }
        ?>

        <br /><br /><br />

        <!-- Button to Add Admin -->
        <a href="add-admin.php" class="btn-primary">Add Admin</a>

        <br /><br /><br />

        <table class="tbl-full ">
            <tr>
                <th>S.N</th>
                <th>ID</th>
                <th>Full Name</th>
                <th>Username</th>
                <th>Actions</th>
            </tr>


            <?php
            //get all admin from db query
            $sql = "SELECT * FROM tl_admin";
            //excute the query
            $res = mysqli_query($conn, $sql);

            //Check Query is excuted or not
            if ($res == TRUE) {
                //Count rows to check for data
                $count = mysqli_num_rows($res); // get the number of rows

                $sn = 1; //variable for serial number

                // check then number of rows
                if ($count > 0) {
                    //Data in db
                    while ($rows = mysqli_fetch_assoc($res)) {
                        //Using while loop to get all data from db.
                        //And this loop will run as long as we have datain db.

                        // Get individual data
                        $id = $rows['id'];
                        $full_name = $rows['full_name'];
                        $username = $rows['username'];

                        //DFisplay the values in table
                    ?>
                        <tr>
                            <td><?php echo $sn++; ?></td>
                            <td><?php echo $id; ?></td>
                            <td><?php echo $full_name; ?></td>
                            <td><?php echo $username; ?></td>
                            <td>
                                <a href="<?php echo SITEURL; ?>admin/update-password.php?id=<?php echo $id; ?>" class="btn-primary">Change Password</a>
                                <a href="<?php echo SITEURL; ?>admin/update-admin.php?id=<?php echo $id; ?>" class="btn-secondary">Update Admin</a>
                                <a href="<?php echo SITEURL; ?>admin/delete-admin.php?id=<?php echo $id; ?>" class="btn-danger">Delete Admin</a> <!-- passing the valo of id -->
                            </td>
                        </tr>
                    <?php

                    }
                } 
                else 
                {
                    //NO data in db
                }
            }

            ?>

        </table>
    </div>
</div>
<!--Main Content Section End -->
<?php include('partials/footer.php') ?>