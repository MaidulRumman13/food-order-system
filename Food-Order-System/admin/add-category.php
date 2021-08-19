<?php include('partials/menu.php') ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>

        <br><br>

        <?php

        if (isset($_SESSION['add']))
        {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }

        if (isset($_SESSION['upload'])) 
        {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }

        ?>
        <br><br>

        <!--Add Category Start-->
        <form action="" method="POST" enctype="multipart/form-data"> <!--enctype for file upload -->
            <table class="tbl-30">

                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Category Title">
                    </td>
                </tr>

                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Feature: </td>
                    <td>
                        <input type="radio" name="feature" value="Yes"> Yes
                        <input type="radio" name="feature" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" value="Yes"> Yes
                        <input type="radio" name="active" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>

        <?php

        //Check submit button
        if (isset($_POST['submit'])) {
            //echo "Yes";

            //1. Get the value from the Form
            $title = mysqli_real_escape_string($conn, $_POST['title']);

            // For radio input type check that the button is selected or not
            if (isset($_POST['feature'])) {
                //Get the value from Form
                $feature = $_POST['feature'];
            } else {
                //Set default value
                $feature = "No";
            }

            if (isset($_POST['active'])) {
                //Get the value from Form
                $active = $_POST['active'];
            } else {
                //Set default value
                $active = "No";
            }

            // Check image is selected or not set valo image name accordingly
            //print_r($_FILES['image']);//print_r for array type display
            //die();//Break the code here

            if(isset($_FILES['image']['name']))
            {
                //Upload 
                //need image name, source path & destination path
                $image_name = $_FILES['image']['name'];
                // Upload image only if image is selected
                if($image_name != "")
                {
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
                    if ($upload == false) {
                        // Set a message
                        $_SESSION['upload'] = "<div class='error'>Failed To Upload Image.</div>";
                        header('location:' . SITEURL . 'admin/add-category.php');
                        // Stop process
                        die();
                    }
                }
            }   
            else
            {
                //Failed & set blank
                $image_name ="";
            }

            //2. SQL Query for DB
            $sql = "INSERT INTO tl_category SET
                    title = '$title',
                    image_name = '$image_name',
                    feature = '$feature',
                    active = '$active'
                ";

            //3. Excute the Query
            $res = mysqli_query($conn, $sql);

            //4. Check Query excuted or not
            if ($res == true) {
                //Excuted
                $_SESSION['add'] = "<div class='success'>Category Added Successfully.</div>";
                //Redirect to Category page
                header('location:' . SITEURL . 'admin/manage-category.php');
            } else {
                //Failed 
                $_SESSION['add'] = "<div class='error'>Failed to Add Category Or This Category Already Added.</div>";
                //Redir'ect to Category page
                header('location:' . SITEURL . 'admin/add-category.php');
            }
        }

        ?>
        <!--Add Category End-->

    </div>
</div>

<?php include('partials/footer.php') ?>