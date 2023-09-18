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

// Check if the 'add_product' form has been submitted.
if(isset($_POST['add_product'])){
   // Retrieve product information from the submitted form.
   $name = $_POST['name'];
   $name = htmlspecialchars(filter_var($name, FILTER_SANITIZE_STRING)); // Sanitize the 'name' input.
   $price = $_POST['price'];
   $price = htmlspecialchars(filter_var($price, FILTER_SANITIZE_STRING)); // Sanitize the 'price' input.
   $details = $_POST['details'];
   $details = htmlspecialchars(filter_var($details, FILTER_SANITIZE_STRING)); // Sanitize the 'details' input.

   // Retrieve and sanitize the product image information.
   $image_01 = $_FILES['image_01']['name'];
   $image_01 = htmlspecialchars(filter_var($image_01, FILTER_SANITIZE_STRING));
   $image_size_01 = $_FILES['image_01']['size'];
   $image_tmp_name_01 = $_FILES['image_01']['tmp_name'];
   $image_folder_01 = '../uploaded_img/'.$image_01;

   $image_02 = $_FILES['image_02']['name'];
   $image_02 = htmlspecialchars(filter_var($image_02, FILTER_SANITIZE_STRING));
   $image_size_02 = $_FILES['image_02']['size'];
   $image_tmp_name_02 = $_FILES['image_02']['tmp_name'];
   $image_folder_02 = '../uploaded_img/'.$image_02;

   // Check if a product with the same name already exists in the database.
   $select_products = $conn->prepare("SELECT * FROM `products` WHERE name = ?");
   $select_products->execute([$name]);

   if($select_products->rowCount() > 0){
      $message[] = 'product name already exists!';
   }else{
      // Insert the new product into the 'products' table.
      $insert_products = $conn->prepare("INSERT INTO `products`(name, details, price, image_01, image_02) VALUES(?,?,?,?,?)");
      $insert_products->execute([$name, $details, $price, $image_01, $image_02]);

      if($insert_products){
         // Check if image sizes are too large (greater than 2MB).
         if($image_size_01 > 2000000 OR $image_size_02 > 2000000){
            $message[] = 'image size is too large!';
         }else{
            // Move the uploaded product images to the specified folder.
            move_uploaded_file($image_tmp_name_01, $image_folder_01);
            move_uploaded_file($image_tmp_name_02, $image_folder_02);
            $message[] = 'new product added!';
         }
      }
   }
}

// Check if the 'delete' parameter is set in the URL (query string).
if(isset($_GET['delete'])){
   // Retrieve the 'delete' parameter value from the URL.
   $delete_id = $_GET['delete'];
   
   // Prepare a query to select the product image filenames for deletion.
   $delete_product_image = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
   $delete_product_image->execute([$delete_id]);
   
   // Fetch the product image filenames.
   $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
   
   // Delete the product images from the server.
   unlink('../uploaded_img/'.$fetch_delete_image['image_01']);
   unlink('../uploaded_img/'.$fetch_delete_image['image_02']);
   
   // Prepare a query to delete the product from the 'products' table.
   $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
   $delete_product->execute([$delete_id]);
   
   // Prepare queries to delete related entries from the 'cart' and 'wishlist' tables.
   $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE pid = ?");
   $delete_cart->execute([$delete_id]);
   $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE pid = ?");
   $delete_wishlist->execute([$delete_id]);
   
   // Redirect the user to the 'products.php' page after deleting the product.
   header('location:products.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>products</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="../styles/admin_style.css">
</head>
<body>

<?php include '../php/admin_header.php'; ?>

<section class="add-products">

   <h1 class="heading">add product</h1>

   <form action="" method="post" enctype="multipart/form-data">
      <div class="flex">
         <div class="inputBox">
            <span>Product Name</span>
            <input type="text" class="box" required maxlength="100" placeholder="enter product name" name="name">
         </div>
         <div class="inputBox">
            <span>Product Price</span>
            <input type="number" min="0" class="box" required max="9999999999" placeholder="enter product price" onkeypress="if(this.value.length == 10) return false;" name="price">
         </div>
        <div class="inputBox">
            <span>Image 01</span>
            <input type="file" name="image_01" accept="image/jpg, image/jpeg, image/png, image/webp" class="box" required>
        </div>
        <div class="inputBox">
            <span>Image 02</span>
            <input type="file" name="image_02" accept="image/jpg, image/jpeg, image/png, image/webp" class="box" required>
        </div>
        <div class="inputBox">
          <span>Product Details</span>
          <textarea name="details" placeholder="enter product details" class="box" required maxlength="500" cols="30" rows="10"></textarea>
        </div>
      </div>
      
      <input type="submit" value="add product" class="btn" name="add_product">
   </form>

</section>

  <section class="show-products">

    <h1 class="heading">Products Added</h1>

    <div class="box-container">

      <?php
      // Prepare a SQL query to select all records from the 'products' table.
      $select_products = $conn->prepare("SELECT * FROM `products`");

      // Execute the query.
      $select_products->execute();

      // Check if there are rows (products) in the result.
      if ($select_products->rowCount() > 0) {
          // Loop through the result set and fetch each product.
          while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
      ?>
      <div class="box">
          <!-- Display product image from the 'uploaded_img' folder -->
          <img src="../uploaded_img/<?= $fetch_products['image_01']; ?>" alt="">
          <div class="name"><?= $fetch_products['name']; ?></div>
          <div class="price">$<span><?= $fetch_products['price']; ?></span>/-</div>
          <div class="details"><span><?= $fetch_products['details']; ?></span></div>
          <div class="flex-btn">
              <!-- Link to update the product, passing the product ID as a parameter -->
              <a href="update_product.php?update=<?= $fetch_products['id']; ?>" class="option-btn">update</a>
              <!-- Link to delete the product, with a confirmation prompt -->
              <a href="products.php?delete=<?= $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('delete this product?');">delete</a>
          </div>
      </div>
      <?php
          }
      } else {
          // Display a message if there are no products.
          echo '<p class="empty">no products added yet!</p>';
      }
      ?>

    </div>

  </section>

  <script src="../scripts/admin_script.js"></script>
   
</body>
</html>