<?php
  // Include the database connection and start the session
  include 'php/connect.php';
  session_start();

  // Check if the user is logged in and get their user_id
  if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
  }else{
    $user_id = '';
    // Redirect to the login page if the user is not logged in
    header('location:user_login.php');
  };

  // Check if the "order" form has been submitted
  if(isset($_POST['order'])){
    // Retrieve and sanitize the user's information from the form
    $name = $_POST['name'];
    $name = htmlspecialchars(filter_var($name, FILTER_SANITIZE_STRING));
    $number = $_POST['number'];
    $number = htmlspecialchars(filter_var($number, FILTER_SANITIZE_STRING));
    $email = $_POST['email'];
    $email = htmlspecialchars(filter_var($email, FILTER_SANITIZE_STRING));
    $method = $_POST['method'];
    $method = htmlspecialchars(filter_var($method, FILTER_SANITIZE_STRING));
    $address = 'flat no. '. $_POST['flat'] .', '. $_POST['street'] .', '. $_POST['city'] .', '. $_POST['state'] .', '. $_POST['country'] .' - '. $_POST['pin_code'];
    $address = htmlspecialchars(filter_var($address, FILTER_SANITIZE_STRING));
    $total_products = $_POST['total_products'];
    $total_price = $_POST['total_price'];

    // Check if the user has items in their cart
    $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
    $check_cart->execute([$user_id]);

    if($check_cart->rowCount() > 0){
        // Insert the order into the database
        $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price) VALUES(?,?,?,?,?,?,?,?)");
        $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $total_price]);

        // Delete the items from the user's cart
        $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
        $delete_cart->execute([$user_id]);

        // Add a success message
        $message[] = 'Bestellung erfolgreich aufgegeben!';
    }else{
        // Add a message if the user's cart is empty
        $message[] = 'Ihr Warenkorb ist leer!';
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
  <title>Deine Bestellungen</title>
</head>
<body>
   
<?php include 'header_and_footer/wine_header.php'; ?>

<section class="checkout-orders">

   <form action="checkout.php" method="POST" name="checkout">

   <h3>Deine Bestellungen</h3>

      <div class="display-orders">
        <?php
          // Check if the "add_to_cart" form has been submitted
          if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["add_to_cart"])) {
              // Retrieve product information from the form
              $productId = $_POST["pid"];
              $quantity = $_POST["quantity"];

              // Update the database to subtract the purchased quantity
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

          $grand_total = 0;
          $cart_items[] = '';
          $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
          $select_cart->execute([$user_id]);
          if($select_cart->rowCount() > 0){
              while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
                  // Calculate the sub-total for each cart item and update the total
                  $cart_items[] = $fetch_cart['name'].' ('.$fetch_cart['price'].' x '. $fetch_cart['quantity'].') - ';
                  $total_products = implode($cart_items);
                  $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
          ?>
                  <p> <?= $fetch_cart['name']; ?><span> = <?=$fetch_cart['price'];?> € x <?=$fetch_cart['quantity'] . ' bottles'; ?></span></p>
          <?php
              }
          }else{
              echo '<p class="empty">Ihr Warenkorb ist leer!</p>';
          }
        ?>

        <input type="hidden" name="total_products" value="<?= $total_products; ?>">
        <input type="hidden" name="total_price" value="<?= $grand_total; ?>" value="">
        <div class="grand-total">Total : <span><?= $grand_total; ?>€</span></div>
      </div>

      <h3>Geben Sie Ihre Bestellungen auf</h3>

      <div class="flex">
         <div class="inputBox">
            <span>Ihr Name :</span>
            <input type="text" name="name" placeholder="enter your name" class="box" maxlength="20" required>
         </div>
         <div class="inputBox">
            <span>Ihre Nummer :</span>
            <input type="number" name="number" placeholder="enter your number" class="box" min="0" max="9999999999" onkeypress="if(this.value.length == 10) return false;" required>
         </div>
         <div class="inputBox">
            <span>deine E-Mail :</span>
            <input type="email" name="email" placeholder="enter your email" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Bezahlverfahren :</span>
            <select name="method" class="box" required>
               <option value="cash on delivery">Barzahlung bei Lieferung</option>
               <option value="credit card">Kreditkarte</option>
               <option value="paypal">PayPal</option>
            </select>
         </div>
         <div class="inputBox">
            <span>Adresszeile 01 :</span>
            <input type="text" name="flat" placeholder="Addressstraße 01" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Adresszeile 02 :</span>
            <input type="text" name="street" placeholder="Addressstraße 02" class="box" maxlength="50">
         </div>
         <div class="inputBox">
            <span>Stadt :</span>
            <input type="text" name="city" placeholder="Leipzig" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Zustand :</span>
            <input type="text" name="state" placeholder="Saxony" class="box" maxlength="50">
         </div>
         <div class="inputBox">
            <span>Land :</span>
            <input type="text" name="country" placeholder="Germany" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Geheimzahl :</span>
            <input type="number" min="0" name="pin_code" placeholder="04154" min="0" max="999999" onkeypress="if(this.value.length == 6) return false;" class="box" required>
         </div>
      </div>

      <input type="submit" name="order" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>" value="Bestellung aufgeben">

   </form>

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