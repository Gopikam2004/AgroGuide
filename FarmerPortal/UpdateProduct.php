<?php
include("../Includes/db.php");
session_start();

if(isset($_SESSION['phonenumber'])) {
    if(isset($_POST['update_pro'])) {
        $product_id = $_POST['product_id'];
        $product_title = $_POST['product_title'];
        $product_cat = $_POST['product_cat'];
        $product_type = $_POST['product_type'];
        $product_stock = $_POST['product_stock'];
        $product_price = $_POST['product_price'];
        $product_expiry = $_POST['product_expiry'];
        $product_desc = $_POST['product_desc'];
        $product_keywords = $_POST['product_keywords'];
        $product_delivery = $_POST['product_delivery'];

        // Update the product in the database
        $update_query = "UPDATE products SET 
                        product_title = '$product_title',
                        product_cat = '$product_cat',
                        product_type = '$product_type',
                        product_stock = '$product_stock',
                        product_price = '$product_price',
                        product_expiry = '$product_expiry',
                        product_desc = '$product_desc',
                        product_keywords = '$product_keywords',
                        product_delivery = '$product_delivery'
                        WHERE product_id = '$product_id'";

        $run_update = mysqli_query($con, $update_query);

        if($run_update) {
            // Product updated successfully
            echo "<script>alert('Product updated successfully');</script>";
            echo "<script>window.open('MyProducts.php','_self');</script>"; // Redirect to products.php or any other page
        } else {
            // Error occurred while updating product
            echo "<script>alert('Failed to update product. Please try again.');</script>";
            echo "<script>window.open('edit_product.php?id=$product_id','_self');</script>"; // Redirect back to edit_product.php with product ID
        }
    }
}
?>
