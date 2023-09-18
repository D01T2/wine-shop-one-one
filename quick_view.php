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
  <title>Schnellansicht</title>
</head>
<body>
   
  <?php include 'header_and_footer/wine_header.php'; ?>

  <section class="quick-view">

    <h1 class="heading">Schnellansicht</h1>

    <?php
      // Get the product ID from the URL parameter
      $pid = $_GET['pid'];

      // Prepare a database query to select the product by its ID
      $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
      $select_products->execute([$pid]);

      // Check if the query returned any results
      if ($select_products->rowCount() > 0) {
          while ($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)) {
      ?>
          <form action="" method="post" class="box">
              <!-- Hidden input fields to store product information -->
              <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
              <input type="hidden" name="name" value="<?= $fetch_product['name']; ?>">
              <input type="hidden" name="price" value="<?= $fetch_product['price']; ?>">
              <input type="hidden" name="image" value="<?= $fetch_product['image_01']; ?>">
              <div class="row">
                  <div class="image-container">
                      <div class="main-image">
                          <img src="uploaded_img/<?= $fetch_product['image_01']; ?>" alt="">
                      </div>
                      <div class="sub-image">
                          <img src="uploaded_img/<?= $fetch_product['image_01']; ?>" alt="">
                          <img src="uploaded_img/<?= $fetch_product['image_02']; ?>" alt="">
                      </div>
                  </div>
                  <div class="content">
                      <div class="name"><?= $fetch_product['name']; ?></div>
                      <div class="flex">
                          <div class="price"><span>€</span><?= $fetch_product['price']; ?></div>
                          <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">
                      </div>
                      <div class="details"><?= $fetch_product['details']; ?></div>
                      <div class="flex-btn">
                          <input type="submit" value="in den Warenkorb legen" class="btn" name="add_to_cart">
                          <input class="option-btn" type="submit" name="add_to_wishlist" value="zur Wunschliste hinzufügen">
                      </div>
                  </div>
              </div>
          </form>
      <?php
          }
      } else {
          // Display a message if no product with the given ID is found
          echo '<p class="empty">Keine Produkte gefunden!</p>';
      }
    ?>

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