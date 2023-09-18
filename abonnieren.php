<?php
  // Include the 'connect.php' file to establish a database connection
  include 'php/connect.php';

  // Start a PHP session
  session_start();

  // Check if a user is logged in by verifying the existence of 'user_id' in the session
  if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
  }else{
    $user_id = '';
  };

  // Include the 'wishlist_cart.php' file for additional functionality related to wishlists and carts
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
  <title>Abonnieren</title>
</head>
  <body>
    <!-- header section  -->
    <?php include 'header_and_footer/wine_header.php' ;?>
  
    <section class="abonnieren">
      <h1 class="main-title">Online-Abonnement</h1>
      
      <div class="subscription">
        <img src="images/abo.jpg" alt="A photo of bottles on the shelf." title="Wine bottles on the shelf in the celler">
        <div class="txt">
          <h2>Abonnieren</h3>
          <p>Wählen Sie Ihre Farbe und Ihren Stil oder Ihre Region und wir kümmern uns jede Woche oder jeden Monat um den Rest, ganz nach Ihrer Wahl.<br>Mit einer großen Auswahl an Weinen können unsere Sommeliers auch die härtesten Kunden zufriedenstellen, mit nur 50 Euro pro Woche oder 150 Euro pro Monat kümmert sich unser Team um Ihren ganz neuen Geschmack, damit Sie eine tolle Zeit mit Ihren Lieben genießen können.<br>Verschwenden Sie keine Zeit damit, in Weinhandlungen zu gehen, sondern sagen Sie uns, was Sie möchten, und Sie müssen sich keine Sorgen mehr um Wein machen. Wir kümmern uns darum.<br></p>
          <form action="kontakt.php" method="post" class="abonnieren">
            <button type="submit" class="weiter">Weiterhin Kontakt aufnehmen</button>
          </form>
        </div>
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
