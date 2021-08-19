<?php include('partials/menu.php') ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Category</h1>

        <br><br>

        <?php

            //Check ID set or not
            if (isset($_GET['id'])) 
            {
                //Get the id and all other data
                $id = $_GET['id'];
                //Query for get data
                $sql = "SELECT * FROM tl_category WHERE id=$id";

                // Excute query
                $res = mysqli_query($conn, $sql);

                // Count roes to check id 
                $count = mysqli_num_rows($res);

                if ($count == 1) 
                {
                    // Get all the data
                    $row = mysqli_fetch_assoc($res);
                    $title = $row['title'];
                    $current_image = $row['image_name'];
                    $feature = $row['feature'];
                    $active = $row['active'];
                } 
                else 
                {
                    //Redirect to Manage category page with message
                    $_SESSION['no-category-found'] = "<div class='error'>Category Not Found.</div>";
                    header('location:' . SITEURL . 'admin/manage-category.php');
                }
            }
            else
            {
                //Ridirect to manage category
                header('location:' . SITEURL . 'admin/manage-category.php');
            }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">

                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Current Image: </td>
                    <td>
                        <?php
                            if ($current_image != "") 
                            {
                                //Display the image
                                ?>
                                <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image; ?>" width="150px">
                                <?php
                            } 
                            else 
                            {
                                //Display message
                                echo "<div class='error'>Image Not Added.</div>";
                            }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>New Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Feature: </td>
                    <td>
                        <input <?php if ($feature == "Yes") {echo "checked";} ?> type="radio" name="feature" value="Yes"> Yes

                        <input <?php if ($feature == "No") {echo "checked";} ?> type="radio" name="feature" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input <?php if ($active == "Yes") {echo "checked";} ?> type="radio" name="active" value="Yes"> Yes

                        <input <?php if ($active == "No") {echo "checked";} ?> type="radio" name="active" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="hidden" name="id" value="<?php echo $id ?>">
                        <input type="submit" name="submit" value="Update Category" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>

        <?php 

            if(isset($_POST['submit']))
            {
                //echo "clicked";
                //1. Get all the data from Form
                $id =  $_POST['id'];
                $title = mysqli_real_escape_string($conn, $_POST['title']);
                $current_image = $_POST['current_image'];
                $feature = $_POST['feature'];
                $active = $_POST['active'];

                //2. Update new image if selected
                //Check image is selected or not
                if(isset($_FILES['image']['name']))
                {
                    //Get the image details
                    $image_name = $_FILES['image']['name'];

                    //Check the image is available or not
                    if($image_name != "")
                    {
                        //Image is available
                        //A.Upload image

                        // Auto Rename Image
                        // Get Extension of image(jpg,png,etc)
                        $ext = end(explode('.', $image_name));

                        //Rename 
                        $image_name = "Food_Category_" . rand(000, 999) . '.' . $ext; //e.g. Food_Category_001.jpg

                        $source_path = $_FILES['image']['tmp_name'];

                        $destination_path = "../images/category/" . $image_name;

                        //upload image
                        $upload = move_uploaded_file($source_path, $destination_path);

                        //Check the image is uploaded or not
                        //if image is not uploaded then stop process and redirect with error message
                        if ($upload == false)
                        {
                            // Set a message
                            $_SESSION['upload'] = "<div class='error'>Failed To Update Image.</div>";
                            header('location:' . SITEURL . 'admin/manage-category.php');
                            // Stop process
                            die();
                        }

                        //B. Remove the current image
                        if($current_image != "")
                        {
                            $remove_path = "../images/category/".$current_image;
                            $remove = unlink($remove_path);

                            //Check the image is remove or not
                            //If failed to remove display message and stop
                            if($remove == false)
                            {
                                $_SESSION['failed-remove'] = "<div class='error'>Failed To Remove Current Image.</div>";
                                header('location:'.SITEURL.'admin/manage-category.php');
                                die();
                            }
                        }
                    }   
                    else
                    {
                        $image_name = $current_image;
                    }
                }
                else
                {
                    $image_name = $current_image;
                }

                //3. Update DB
                $sql2 = "UPDATE tl_category SET
                    title = '$title',
                    image_name = '$image_name',
                    feature = '$feature',
                    active = '$active'
                    WHERE id=$id
                ";

                // Excute Query
                $res2 = mysqli_query($conn, $sql2);

                //4. Redirect to manage category with message
                //Check is excuted or not
                if($res2 == true)
                {
                    //Updated
                    $_SESSION['update'] = "<div class='success'>Category Updated Successfully.</div>";
                    //Redirect to Category page
                    header('location:' . SITEURL . 'admin/manage-category.php');
                }
                else
                {
                    $_SESSION['update'] = "<div class='error'>Failed To Update Category.</div>";
                    //Redirect to Category page
                    header('location:' . SITEURL . 'admin/manage-category.php');
                }

            }

        ?>

    </div>
</div>

<?php include('partials/footer.php') ?>