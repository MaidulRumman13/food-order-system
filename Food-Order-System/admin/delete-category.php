<?php 
    include('../config/constants.php');
    //echo "Delete Category";
    //check id & image name is set or not
    if(isset($_GET['id'])AND isset($_GET['image_name']))
    {
        // Get the value and delete 
        //echo "Get value and delete";
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        // Remove image file is available
        if($image_name != "")
        {
            // Image available get the path and raemove it
            $path = "../images/category/".$image_name;
            //Remove
            $remove = unlink($path);
            
            // If failed to remove 
            if($remove == false)
            {
                // Set the session message
                $_SESSION['remove'] = "<div class='error'>Failed to Remove Category Image.</div>";

            // Redirect to Manage category page
            header('location:' . SITEURL . 'admin/manage-category.php');

                // Stop the process
                die();
            }
        }

        // Delete data from DB
        // Query for delete from DB
        $sql = "DELETE FROM tl_category WHERE id=$id";
        // Excute the Query
        $res = mysqli_query($conn, $sql);

        // Check the data is delete or not 
        if($res == true)
        {
            //Set message & Redirect
            $_SESSION['delete'] = "<div class='success'>Category Deleted Successfully.</div>";
            //Redirect
            header('location:' . SITEURL . 'admin/manage-category.php');
        }
        else
        {
            //Set failed message & Redirect
            $_SESSION['delete'] = "<div class='success'>Failed To Delete Category.</div>";
            //Redirect
            header('location:' . SITEURL . 'admin/manage-category.php');
        }

        // Redirect to the manage category page with message
    }
    else
    {
        // Redirect to Manage category page
        header('location:'.SITEURL.'admin/manage-category.php');
    }

?>