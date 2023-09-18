<?php
// Include the database connection file
include 'php/connect.php';

// Start a new or resume the existing session
session_start();

// Check if the user is logged in by checking if 'user_id' is set in the session
if(isset($_SESSION['user_id'])){
   // If the user is logged in, store their user ID in the variable $user_id
   $user_id = $_SESSION['user_id'];
}else{
   // If the user is not logged in, set $user_id to an empty string
   $user_id = '';
}

// Include the 'wishlist_cart.php' file, which may contain functions and code related to wishlists and carts
include 'php/wishlist_cart.php';
?>


<!DOCTYPE html>
<html lang="en" id="top">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- custom css file -->
  <link rel="stylesheet" href="styles/style.css">
  <!-- swiper cdn link -->
  <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" >
  <!-- font awesome cdn link  -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- wine glass icon link -->
  <link rel="icon" type="image/x-icon" href="images/wine-glass.png">
  <title>Kategorie</title>
</head>
<body>
    
  <?php include 'header_and_footer/wine_header.php'; ?>

  <section class="products">

    <h1 class="heading">Kategorie</h1>

    <div class="box-container">

      <?php
        // Get the category from the URL query parameter
        $category = $_GET['category'];

        // Prepare and execute a database query to select products that match the category
        $select_products = $conn->prepare("SELECT * FROM `products` WHERE name LIKE '%{$category}%'"); 
        $select_products->execute();

        // Check if there are products matching the category in the database
        if($select_products->rowCount() > 0){
            // Loop through the fetched products and display them
            while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
                ?>
                <form action="" method="post" class="box">
                    <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
                    <input type="hidden" name="name" value="<?= $fetch_product['name']; ?>">
                    <input type="hidden" name="price" value="<?= $fetch_product['price']; ?>">
                    <input type="hidden" name="image" value="<?= $fetch_product['image_01']; ?>">
                    <button class="fas fa-heart" type="submit" name="add_to_wishlist"></button>
                    <a href="quick_view.php?pid=<?= $fetch_product['id']; ?>" class="fas fa-eye"></a>
                    <img src="uploaded_img/<?= $fetch_product['image_01']; ?>" alt="">
                    <div class="name"><?= $fetch_product['name']; ?></div>
                    <div class="flex">
                        <div class="price"><span>€</span><?= $fetch_product['price']; ?><span></span></div>
                        <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">
                    </div>
                    <input type="submit" value="add to cart" class="btn" name="add_to_cart">
                </form>
                <?php
            }
        }else{
            // Display a message if no products were found in the category
            echo '<p class="empty">No products found!</p>';
        }
      ?>

    </div>

  </section>

  <?php include 'header_and_footer/wine_footer.php'; ?>

  <script src="scripts/script.js"></script>

</body>
</html>