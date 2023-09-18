<?php

include 'php/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

?>

<!DOCTYPE html>
<html lang="de" id="top">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Bestellungen aufgegeben</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header_and_footer/wine_header.php'; ?>

<section class="orders">

   <h1 class="heading">Bestellungen aufgegeben</h1>

   <div class="box-container">

    <?php
        // Check if the user is not logged in.
        if ($user_id == '') {
            // Display a message to prompt the user to log in to see their orders.
            echo '<p class="empty">Bitte melden Sie sich an, um Ihre Bestellungen anzuzeigen</p>';
        } else {
            // The user is logged in, so retrieve their orders.
            $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ?");
            $select_orders->execute([$user_id]);

            // Check if there are any orders for the user.
            if ($select_orders->rowCount() > 0) {
                while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
                    // Display order details for each order.
            ?>
                    <div class="box">
                        <p>Platziert auf : <span><?= $fetch_orders['placed_on']; ?></span></p>
                        <p>Name : <span><?= $fetch_orders['name']; ?></span></p>
                        <p>E-mail : <span><?= $fetch_orders['email']; ?></span></p>
                        <p>Number : <span><?= $fetch_orders['number']; ?></span></p>
                        <p>Adresse : <span><?= $fetch_orders['address']; ?></span></p>
                        <p>Bezahlverfahren : <span><?= $fetch_orders['method']; ?></span></p>
                        <p>deine Bestellungen : <span><?= $fetch_orders['total_products']; ?></span></p>
                        <!-- It seems that $fetch_cart is not defined in this loop. You might need to use $fetch_orders instead. -->
                        <p>Ihre Menge: <span> <?= $fetch_cart['quantity']; ?></span></p>
                        <p>Gesamtpreis: <span>€<?= $fetch_orders['total_price']; ?></span></p>
                        <p>Zahlungsstatus : <span style="color:<?php if ($fetch_orders['payment_status'] == 'pending') {
                            echo 'red';
                        } else {
                            echo 'green';
                        }; ?>"><?= $fetch_orders['payment_status']; ?></span></p>
                    </div>
            <?php
                }
            } else {
                // Display a message indicating that no orders have been placed yet.
                echo '<p class="empty">Noch keine Bestellungen aufgegeben!</p>';
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