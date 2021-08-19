<?php


include('../config/constants.php');

//  1. Get the ID of Admim for delete.
$id = $_GET['id'];

// 2. Create SQL Query to delete admin
$sql = "DELETE FROM tl_admin WHERE id=$id";

// Excute the Query
$res = mysqli_query($conn, $sql);

// Check Query is excuted successfully or not
if($res == true)
{
    // Success and delete
    //echo "Delete";
    //Create a Session veriable to display message
    $_SESSION['delete'] = "<div class = 'success'>Admin Deleted Sucessfully.</div>";
    //Redirect page to manage admin
    header("location:" . SITEURL . 'admin/manage-admin.php');
}
else
{
    // Failed
    //echo "Not Delete";
    //Create a Session veriable to display message
    $_SESSION['delete'] = "<div class = 'error'>Fialed to Delete Admin.</div>";
    //Redirect page to manage admin
    header("location:" . SITEURL . 'admin/manage-admin.php');
}

// 3. Redirect to manage admin page with admin 

?>