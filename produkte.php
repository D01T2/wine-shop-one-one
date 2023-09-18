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
  <title>Produkte</title>
</head>
  <body>
    <!-- header section  -->
    <?php include 'header_and_footer/wine_header.php' ;?>
    
    <main>

      <h1 class="main-title">Unseren Produkte</h1>
      
      <section class="products">
        <div class="product">
            <?php
            // Retrieve all products from the database
            $select_products = $conn->prepare("SELECT * FROM `products`");
            $select_products->execute();

            // Check if there are any products in the database
            if ($select_products->rowCount() > 0) {
                while ($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)) {
                    // Determine the color of the quantity indicator based on product availability
                    $quantity = $fetch_product['quantity'];
                    $color = "black"; // Default color
                    if ($quantity > 10) {
                        $color = "green"; // Green for products with more than 10 available
                    } elseif ($quantity >= 5) {
                        $color = "yellow"; // Yellow for products with 5 to 10 available
                    } else {
                        $color = "red"; // Red for products with less than 5 available
                    }
            ?>
                    <form action="" method="post" class="box">
                        <!-- Hidden input fields to store product information -->
                        <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
                        <input type="hidden" name="name" value="<?= $fetch_product['name']; ?>">
                        <input type="hidden" name="counting" value="<?= $fetch_product['quantity']; ?>">
                        <input type="hidden" name="price" value="<?= $fetch_product['price']; ?>">
                        <input type="hidden" name="image" value="<?= $fetch_product['image_01']; ?>">
                        <button class="fas fa-heart" type="submit" name="add_to_wishlist"></button>
                        <img src="uploaded_img/<?= $fetch_product['image_01']; ?>" alt="">
                        <div class="color-dot">
                            <!-- Display the quantity indicator with appropriate color -->
                            <span class="color-dot" style="color: <?= $color; ?>;"> &#11044; <?= $fetch_product['quantity'];?> Flaschen übrig</span>
                        </div>
                        <div class="name">
                            <!-- Link to view more details of the product -->
                            <a href="quick_view.php?pid=<?= $fetch_product['id']; ?>"><?= $fetch_product['name']; ?></a>
                        </div>
                        <div class="flex">
                            <div class="price"><span>€</span><?= $fetch_product['price']; ?></div>
                            <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">
                        </div>
                        <input type="submit" value="in den Warenkorb legen" class="btn" name="add_to_cart">
                    </form>
            <?php
                }
            } else {
                // Display a message if no products are found in the database
                echo '<p class="empty">Keine Produkte gefunden!</p>';
            }
            ?>
        </div>
      </section>

    </main>

  <!--the footer (the same like the navigation bar)-->
  <?php include 'header_and_footer/wine_footer.php' ;?>
  <!-- javaScript and jQuery links  -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
  <script src="scripts/script.js"></script>
  </body>
</html>
