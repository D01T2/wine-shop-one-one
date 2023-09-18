<?php

include 'php/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

include 'php/wishlist_cart.php';

?>

<!DOCTYPE html>
<html lang="de" id="top">
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
  <title>Suchen</title>
</head>
<body>
   
  <?php include 'header_and_footer/wine_header.php'; ?>

  <section class="search-form">
    <h3 class="heading">Suchen...</h3>
    <form action="" method="post">
        <input type="text" name="search_box" placeholder="Finden Sie hier Ihren Wunschwein..." maxlength="100" class="box" required>
        <button type="submit" class="fas fa-search" name="search_btn"></button>
    </form>
  </section>

  <section class="products" style="margin-top: 1em; min-height:100vh;">

    <div class="box-container">

    <?php
        // Check if the search form has been submitted
        if (isset($_POST['search_box']) OR isset($_POST['search_btn'])) {
            // Get the search query from the form
            $search_box = $_POST['search_box'];

            // Prepare a database query to select products that match the search query
            $select_products = $conn->prepare("SELECT * FROM `products` WHERE name LIKE '%{$search_box}%'");
            $select_products->execute();

            // Check if any products matching the search query were found
            if ($select_products->rowCount() > 0) {
                while ($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)) {
        ?>
                    <form action="" method="post" class="box">
                        <!-- Hidden input fields to store product information -->
                        <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
                        <input type="hidden" name="name" value="<?= $fetch_product['name']; ?>">
                        <input type="hidden" name="price" value="<?= $fetch_product['price']; ?>">
                        <input type="hidden" name="image" value="<?= $fetch_product['image_01']; ?>">
                        <!-- Add to wishlist button -->
                        <button class="fas fa-heart" type="submit" name="add_to_wishlist"></button>
                        <!-- Link to view product details -->
                        <a href="quick_view.php?pid=<?= $fetch_product['id']; ?>" class="fas fa-eye"></a>
                        <!-- Product image -->
                        <img src="uploaded_img/<?= $fetch_product['image_01']; ?>" alt="">
                        <!-- Product name -->
                        <div class="name"><?= $fetch_product['name']; ?></div>
                        <div class="flex">
                            <!-- Product price -->
                            <div class="price"><span>€</span><?= $fetch_product['price']; ?></div>
                            <!-- Quantity input field -->
                            <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">
                        </div>
                        <!-- Add to cart button -->
                        <input type="submit" value="in den Warenkorb legen" class="btn" name="add_to_cart">
                    </form>
        <?php
                }
            } else {
                // Display a message if no products matching the search query are found
                echo '<p class="empty">No products found!</p>';
            }
        }
      ?>

    </div>

  </section>

  <!--the footer (the same like the navigation bar)-->
  <?php include 'header_and_footer/wine_footer.php' ;?>
  <!-- javaScript and jQuery links  -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
  <script src="scripts/script.js"></script>
</body>
</html>