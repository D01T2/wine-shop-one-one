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
  <title>Impressum</title>
</head>
  <body>
    <!-- header section  -->
    <?php include 'header_and_footer/wine_header.php' ;?>

    <main>
      <section class="impressum">

        <h1>Impressum gemäß § 5 TMG:</h1>

        <strong>Französische Weine GmbH</strong><br>
        <b> Geschäftsführer:</b><br>
        Hans Mustermann <br>
        Musterstraße 123 <br>
        12345 Musterstadt, DE
        <h3>Kontakt:</h3>
        <a href="tel:030 1234567-8" target="_blank">Tel: 030 1234567-8</a><br>
        <a href="mailto:info@mustermann.de" target="www.mail.google.com">E-mail: info@mustermann.de</a><br>
        <b>Registereintrag:</b>Eintragung im Handelsregister.<br>
        <b>Registergericht: </b>Amtsgericht Musterstadt<br>
        <b>Registernummer:</b> HRB 12345</p>

        Umsatzsteuer-Identifikationsnummer gemäß §27a Umsatzsteuergesetz:<br>
        DE 123456789 <br>
        
        <b>Verantwortlich für den Inhalt nach § 55 Abs. 2 RStV: </b><br>
        Hans Mustermann <br>
        Musterstraße 123 <br>
        12345 Musterstadt <br>
        <a href="tel:030 1234567-8" target="_blank">Tel: 030 1234567-8</a><br>
        <a href="mailto:max@mustermann.de"target="_blank">E-mail: max@mustermann.de</a> <br>
        <b>Haftungsausschluss: </b><br>
        <p>Trotz sorgfältiger inhaltlicher Kontrolle übernehmen wir keine Haftung für die Inhalte externer Links. Für den Inhalt der verlinkten Seiten sind ausschließlich deren Betreiber verantwortlich.</p>
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
