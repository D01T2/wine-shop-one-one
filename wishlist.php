<?php
// Include the database connection file and start a session
include 'php/connect.php';
session_start();

// Check if the user is logged in, if not, redirect to the login page
if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}else{
    $user_id = '';
    header('location:user_login.php');
}

// Include the code to handle wishlist and cart functionality
include 'php/wishlist_cart.php';

// Check if the "delete" form has been submitted (to remove a single item from the wishlist)
if(isset($_POST['delete'])){
    $wishlist_id = $_POST['wishlist_id'];
    $delete_wishlist_item = $conn->prepare("DELETE FROM `wishlist` WHERE id = ?");
    $delete_wishlist_item->execute([$wishlist_id]);
}

// Check if the "delete_all" parameter is set (to remove all items from the wishlist)
if(isset($_GET['delete_all'])){
    $delete_wishlist_item = $conn->prepare("DELETE FROM `wishlist` WHERE user_id = ?");
    $delete_wishlist_item->execute([$user_id]);
    header('location:wishlist.php');
}
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
  <title>Wunschzettel</title>
</head>

<body>
   
  <?php include 'header_and_footer/wine_header.php'; ?>

  <section class="products">

    <h1 class="heading">Wunschzettel</h1>

    <div class="box-container">

      <?php
        // Initialize a variable to keep track of the grand total
        $grand_total = 0;

        // Prepare and execute a database query to select wishlist items for the logged-in user
        $select_wishlist = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
        $select_wishlist->execute([$user_id]);

        // Check if there are items in the wishlist
        if($select_wishlist->rowCount() > 0){
            // Loop through each item in the wishlist
            while($fetch_wishlist = $select_wishlist->fetch(PDO::FETCH_ASSOC)){
                // Calculate the grand total by adding the price of the current wishlist item
                $grand_total += $fetch_wishlist['price'];
        ?>
            <form action="" method="post" class="box">
                <input type="hidden" name="pid" value="<?= $fetch_wishlist['pid']; ?>">
                <input type="hidden" name="wishlist_id" value="<?= $fetch_wishlist['id']; ?>">
                <input type="hidden" name="name" value="<?= $fetch_wishlist['name']; ?>">
                <input type="hidden" name="price" value="<?= $fetch_wishlist['price']; ?>">
                <input type="hidden" name="image" value="<?= $fetch_wishlist['image']; ?>">
                <img src="uploaded_img/<?= $fetch_wishlist['image']; ?>" alt="">
                <div class="name"><?= $fetch_wishlist['name']; ?></div>
                <div class="flex">
                    <div class="price">€<?= $fetch_wishlist['price']; ?></div>
                    <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">
                </div>
                <input type="submit" value="In den Warenkorb legen" class="btn" name="add_to_cart">
                <input type="submit" value="Element löschen" onclick="return confirm('Dies von der Wunschliste löschen?');" class="delete-btn" name="delete">
            </form>
        <?php
            }
        }else{
            // Display a message if the wishlist is empty
            echo '<p class="empty">Deine Wunschliste ist leer!</p>';
        }
      ?>

    </div>

    <div class="wishlist-total">
        <p>Summe : <span>€<?= $grand_total; ?></span></p>
        <a href="produkte.php" class="option-btn">Weiter Einkaufen</a>
        <a href="wishlist.php?delete_all" class="delete-btn <?= ($grand_total > 1)?'':'disabled'; ?>" onclick="return confirm('delete all from wishlist?');">Alle Elemente löschen</a>
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