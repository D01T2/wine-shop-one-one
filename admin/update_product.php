<?php
// Include a PHP file named 'connect.php' located in the parent directory.
include '../php/connect.php';

// Start a PHP session or resume the current session.
session_start();

// Retrieve the 'admin_id' value from the session.
$admin_id = $_SESSION['admin_id'];

// Check if 'admin_id' is not set in the session (admin is not logged in).
if (!isset($admin_id)) {
   // Redirect the user to the 'admin_login.php' page.
   header('location:admin_login.php');
}

// Check if the 'update' button in the form has been pressed.
if(isset($_POST['update'])){
  // Retrieve the submitted values from the form.
  $pid = $_POST['pid'];
  $name = $_POST['name'];
  $name = filter_var($name, FILTER_SANITIZE_STRING); // Sanitize the 'name' input.
  $price = $_POST['price'];
  $price = filter_var($price, FILTER_SANITIZE_STRING); // Sanitize the 'price' input.
  $details = $_POST['details'];
  $details = filter_var($details, FILTER_SANITIZE_STRING); // Sanitize the 'details' input.

  // Prepare a query to update product information (name, price, details) in the 'products' table.
  $update_product = $conn->prepare("UPDATE `products` SET name = ?, price = ?, details = ? WHERE id = ?");
  $update_product->execute([$name, $price, $details, $pid]);

  // Add a success message to the 'message' array.
  $message[] = 'product updated successfully!';

  // Retrieve the old image filenames from the form.
  $old_image_01 = $_POST['old_image_01'];
  $old_image_02 = $_POST['old_image_02'];

  // Retrieve the new image filenames and related information from the file upload.
  $image_01 = $_FILES['image_01']['name'];
  $image_01 = filter_var($image_01, FILTER_SANITIZE_STRING); // Sanitize the 'image_01' filename.
  $image_size_01 = $_FILES['image_01']['size'];
  $image_tmp_name_01 = $_FILES['image_01']['tmp_name'];
  $image_folder_01 = '../uploaded_img/'.$image_01;

  // Check if 'image_01' is not empty (a new image has been selected).
  if (!empty($image_01)) {
      // Check if the new image size exceeds 2MB.
      if($image_size_01 > 2000000){
        $message[] = 'image size is too large!';
      } else {
        // Prepare a query to update 'image_01' in the 'products' table.
        $update_image_01 = $conn->prepare("UPDATE `products` SET image_01 = ? WHERE id = ?");
        $update_image_01->execute([$image_01, $pid]);
        // Move the uploaded image to the specified folder.
        move_uploaded_file($image_tmp_name_01, $image_folder_01);
        // Delete the old 'image_01' from the server.
        unlink('../uploaded_img/'.$old_image_01);
        // Add a success message for updating 'image_01'.
        $message[] = 'image 01 updated successfully!';
      }
  }

  // Similar logic is applied for 'image_02' update.
  // (Retrieve, sanitize, check size, update, move, delete old, and add success message.)

  $old_image_02 = $_POST['old_image_02'];
  $image_02 = $_FILES['image_02']['name'];
  $image_02 = filter_var($image_02, FILTER_SANITIZE_STRING);
  $image_size_02 = $_FILES['image_02']['size'];
  $image_tmp_name_02 = $_FILES['image_02']['tmp_name'];
  $image_folder_02 = '../uploaded_img/'.$image_02;

  if(!empty($image_02)){
      if($image_size_02 > 2000000){
        $message[] = 'image size is too large!';
      }else{
        $update_image_02 = $conn->prepare("UPDATE `products` SET image_02 = ? WHERE id = ?");
        $update_image_02->execute([$image_02, $pid]);
        move_uploaded_file($image_tmp_name_02, $image_folder_02);
        unlink('../uploaded_img/'.$old_image_02);
        $message[] = 'image 02 updated successfully!';
      }
  }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>update product</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="../styles/admin_style.css">
</head>
<body>

  <?php include '../php/admin_header.php'; ?>

  <section class="update-product">

    <h1 class="heading">update product</h1>

    <?php
      $update_id = $_GET['update']; // Get the product ID to be updated from the URL parameter.
      $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?"); // Prepare a query to retrieve product details based on the ID.
      $select_products->execute([$update_id]); // Execute the query with the provided product ID.
      if ($select_products->rowCount() > 0) {
          // If there are products found with the given ID, display the form for updating.
          while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
      ?>
      <form action="" method="post" enctype="multipart/form-data">
          <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>"> <!-- Include a hidden field for the product ID. -->
          <input type="hidden" name="old_image_01" value="<?= $fetch_products['image_01']; ?>"> <!-- Include hidden fields for old image filenames. -->
          <input type="hidden" name="old_image_02" value="<?= $fetch_products['image_02']; ?>">
          <div class="image-container">
              <div class="main-image">
                  <img src="../uploaded_img/<?= $fetch_products['image_01']; ?>" alt="">
              </div>
              <div class="sub-image">
                  <img src="../uploaded_img/<?= $fetch_products['image_01']; ?>" alt="">
                  <img src="../uploaded_img/<?= $fetch_products['image_02']; ?>" alt="">
              </div>
          </div>
          <span>update name</span>
          <input type="text" name="name" required class="box" maxlength="100" placeholder="enter product name" value="<?= $fetch_products['name']; ?>">
          <span>update price</span>
          <input type="number" name="price" required class="box" min="0" max="9999999999" placeholder="enter product price" onkeypress="if(this.value.length == 10) return false;" value="<?= $fetch_products['price']; ?>">
          <span>update details</span>
          <textarea name="details" class="box" required cols="30" rows="10"><?= $fetch_products['details']; ?></textarea>
          <span>update image 01</span>
          <input type="file" name="image_01" accept="image/jpg, image/jpeg, image/png, image/webp" class="box"> <!-- Input field for updating image 01. -->
          <span>update image 02</span>
          <input type="file" name="image_02" accept="image/jpg, image/jpeg, image/png, image/webp" class="box"> <!-- Input field for updating image 02. -->
          <div class="flex-btn">
              <input type="submit" name="update" class="btn" value="update"> <!-- Submit button for updating the product. -->
              <a href="products.php" class="option-btn">go back</a> <!-- Link to go back to the product list. -->
          </div>
      </form>
      <?php
          }
      } else {
          echo '<p class="empty">no product found!</p>'; // Display a message if no product is found with the given ID.
      }
    ?>

  </section>

  <script src="../scripts/admin_script.js"></script>
   
</body>
</html>