<?php
if (isset($message)) {
    foreach ($message as $message) {
        echo '
        <div class="message">
            <span>' . $message . '</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
        </div>
        ';
    }
}
?>

<header>
  <!-- logo  -->
  <div class="logo">
    <h1>m.e.</h1>
  </div>
  <!-- menu  -->
  <nav class="navi-menu">
    <ul class="navi-list">
      <li class="list-item"><a href="index.php" class="active">Home</a></li>
      <li class="list-item"><a href="abonnieren.php">Abonnieren</a></li>
      <li class="list-item"><a href="produkte.php">Produkte</a></li>
      <li class="list-item"><a href="veranstaltungen.php">Veranstaltungen</a></li>
      <li class="list-item"><a href="kontakt.php">Kontakt</a></li>
    </ul>
  </nav>
  <div class="profile-icons">
      <!-- profile section  -->
  <div class="profile">
    <?php
      // Prepare and execute a database query to fetch user profile information
      $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
      $select_profile->execute([$user_id]);
      
      // Check if a user profile was found
      if ($select_profile->rowCount() > 0) {
        // Fetch the user's profile information
        $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
      ?>
      <!-- Display the user's username -->
      <p class="username"><?= $fetch_profile["name"]; ?></p>
      
      <!-- Buttons and links for the user when logged in -->
      <a href="update_user.php" class="btn">Profil aktualisieren</a>
      <a href="user_register.php" class="option-btn">Registrieren</a>
      <a href="user_login.php" class="option-btn">Anmeldung</a>
      
      <!-- Logout link with a confirmation prompt -->
      <a href="php/user_logout.php" class="delete-btn" onclick="return confirm('Von der Website abmelden?');">Ausloggen</a>
      
      <?php
        } else {
          // Display options for users who are not logged in
      ?>
      <a href="user_register.php" class="option-btn">Registrieren</a>
      <a href="user_login.php" class="option-btn">login</a>
      <?php
        }
      ?>
    </div>

    <!-- icons for the wishlist, cart and user  -->
    <div class="icons">
      <?php
        // Count the number of items in the user's wishlist
        $count_wishlist_items = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
        $count_wishlist_items->execute([$user_id]);
        $total_wishlist_counts = $count_wishlist_items->rowCount();

        // Count the number of items in the user's cart
        $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
        $count_cart_items->execute([$user_id]);
        $total_cart_counts = $count_cart_items->rowCount();
      ?>
      <!-- Link to the search page -->
      <a href="search_page.php"><i class="fas fa-search"></i></a>
      
      <!-- Link to the wishlist page with the total wishlist item count -->
      <a href="wishlist.php"> <i class="fas fa-heart"> </i><span>  <?= $total_wishlist_counts; ?>  </span></a>
      
      <!-- Link to the cart page with the total cart item count -->
      <a href="cart.php"><i class="fas fa-shopping-cart"></i><span>  <?= $total_cart_counts; ?>  </span></a>
    </div>
  </div>
  <h2 class="sign-menu">menu &#10148;</h2>
  <!-- wine bottle button  -->
  <div class="menu-btn" onclick="toggleNav(this)">
    
    <div class="bar1"></div>
    <div class="bar2"></div>
    <div class="bar3"></div>
  </div>
</header>

