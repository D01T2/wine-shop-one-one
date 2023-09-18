<?php
// Include the 'connect.php' file to establish a database connection
include 'php/connect.php';

// Start a PHP session
session_start();

// Check if 'user_id' is set in the session to determine if a user is logged in
if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   // If 'user_id' is not set, set 'user_id' to an empty string and redirect to the user login page
   $user_id = '';
   header('location:user_login.php');
}

// Handle deleting a single item from the cart
if(isset($_POST['delete'])){
   $cart_id = $_POST['cart_id'];
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE id = ?");
   $delete_cart_item->execute([$cart_id]);
}

// Handle deleting all items from the cart
if(isset($_GET['delete_all'])){
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
   $delete_cart_item->execute([$user_id]);
   header('location:cart.php');
}

// Handle updating the quantity of items in the cart
if(isset($_POST['update_qty'])){
   $cart_id = $_POST['cart_id'];
   $qty = $_POST['qty'];
   $qty = filter_var($qty, FILTER_SANITIZE_STRING);
   $update_qty = $conn->prepare("UPDATE `cart` SET quantity = ? WHERE id = ?");
   $update_qty->execute([$qty, $cart_id]);
   $message[] = 'Cart quantity updated';
}

// Handle adding items to the cart
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["add_to_cart"])) {
   // Retrieve product information from the form
   $productId = $_POST["pid"];
   $quantity = $_POST["qty"];

   // Update the database to subtract the purchased quantity from product stock
   $updateQuery = $conn->prepare("UPDATE products SET quantity = quantity - :quantity WHERE id = :productId");
   $updateQuery->bindParam(':quantity', $quantity, PDO::PARAM_INT);
   $updateQuery->bindParam(':productId', $productId, PDO::PARAM_INT);

   // Execute the query
   if ($updateQuery->execute()) {
       // Product purchased successfully
       echo "Produkt gekauft!";
   } else {
       // Handle the error if the query fails
       echo "Fehler beim Kauf des Produkts.";
   }
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
  <title>Einkaufswagen</title>
</head>
<body>
    <!-- header section  -->
<?php include 'header_and_footer/wine_header.php'; ?>

<section class="products shopping-cart">

   <h3 class="heading">Einkaufswagen</h3>

   <div class="box-container">
    <?php
      // Initialize the 'grand_total' variable to 0
      $grand_total = 0;

      // Prepare and execute a query to select items in the cart for the current user
      $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
      $select_cart->execute([$user_id]);

      // Check if there are items in the cart
      if($select_cart->rowCount() > 0){
        // Iterate through each item in the cart
        while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
        ?>
        <!-- Display each cart item in a form -->
        <form action="" method="post" class="box">
            <!-- Hidden input to store the cart item ID -->
            <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
            <!-- Link to view more details about the product -->
            <a href="quick_view.php?pid=<?= $fetch_cart['pid']; ?>"></a>
            <!-- Display the product image -->
            <img src="uploaded_img/<?= $fetch_cart['image']; ?>" alt="">
            <!-- Display the product name -->
            <div class="name"><?= $fetch_cart['name']; ?></div>
            <div class="flex">
              <!-- Display the product price and input field for quantity -->
              <div class="price">€<?= $fetch_cart['price']; ?></div>
              <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="<?= $fetch_cart['quantity']; ?>">
            </div>
            <!-- Display the subtotal for the item -->
            <div class="sub-total">Sub total : <span>€<?= $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?></span> </div>
            <!-- Submit button to delete the item from the cart -->
            <input type="submit" value="Delete item" onclick="return confirm('Diesen Artikel aus dem Warenkorb löschen?');" class="delete-btn" name="delete">
        </form>
        <?php
        // Calculate the 'grand_total' by adding the subtotal of the current item
        $grand_total += $sub_total;
            }
        }else{
            // Display a message if the cart is empty
            echo '<p class="empty">Ihr Warenkorb ist leer!</p>';
        }
    ?>

   </div>

   <div class="cart-total">
      <p>grand total : <span>€<?= $grand_total; ?></span></p>
      <a href="produkte.php" class="option-btn">Weiter Einkaufen</a>
      <a href="cart.php?delete_all" class="delete-btn <?= ($grand_total > 1)?'':'disabled'; ?>" onclick="return confirm('delete all from cart?');">Alle Elemente löschen</a>
      <a href="checkout.php" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>">Zur Kasse</a>
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