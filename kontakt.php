<?php

// Include the database connection script.
include 'php/connect.php';

// Start a session.
session_start();

// Check if a user is logged in and store their user_id if available.
if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   // If no user is logged in, set user_id to an empty string.
   $user_id = '';
}

// Check if the "send" form has been submitted.
if (isset($_POST['send'])) {

   // Retrieve and sanitize user inputs for name, email, number, and message.
   $name = $_POST['name'];
   $name = htmlspecialchars(filter_var($name, FILTER_SANITIZE_STRING));
   $email = $_POST['email'];
   $email = htmlspecialchars(filter_var($email, FILTER_SANITIZE_STRING));
   $number = $_POST['number'];
   $number = htmlspecialchars(filter_var($number, FILTER_SANITIZE_STRING));
   $msg = $_POST['msg'];
   $msg = htmlspecialchars(filter_var($msg, FILTER_SANITIZE_STRING));

   // Check if a message with the same name, email, number, and message content already exists.
   $select_message = $conn->prepare("SELECT * FROM `messages` WHERE name = ? AND email = ? AND number = ? AND message = ?");
   $select_message->execute([$name, $email, $number, $msg]);

   // If a duplicate message is found, display an "already sent message" message.
   if ($select_message->rowCount() > 0) {
      $message[] = 'already sent message!';
   } else {

      // Insert a new message into the "messages" table in the database.
      $insert_message = $conn->prepare("INSERT INTO `messages`(user_id, name, email, number, message) VALUES(?,?,?,?,?)");
      $insert_message->execute([$user_id, $name, $email, $number, $msg]);

      // Add a "sent message successfully!" message to the $message array to display to the user.
      $message[] = 'sent message successfully!';

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
  <title>Kontakt</title>
</head>
  <body>
    <!-- header section  -->
    <?php include 'header_and_footer/wine_header.php' ;?>
 
    <main>
      <h1 class="main-title">Kontakt</h1>
      <section class="formular">
        <form action="" method="POST" class="contact">
            <label for="vorname">Name: *</label>
            <input type="text" name="name" placeholder="Name eintragen" required>
            <label for="email">E-Mail Addresse: *</label>
            <input type="text" name="email" placeholder="beispiel@beisiel.de" required>
            <label for="number">Telefon:</label>
            <input type="number" name="number" placeholder="Freiwilling Telephone">
            <label for="msg">Nachricht: *</label>
            <textarea type="text" name="msg" cols="30" rows="3" required>Bitte Nachricht eintragen.</textarea>
            <fieldset for="DSGVO" class="dataschultz">
              <input type="checkbox" id="dsgvo" name="dsvgo" required>
              Mit der Nutzung dieses Formulars erklären Sie sich mit der Speicherung und Verarbeitung Ihrer Daten durch diese Website einverstanden ( <a href="dataschultz.html" style="color: var(--clr-red)">Datenschutzerklärung</a> ).
            </fieldset>
            <div class="btncontact">
              <button type="submit" value="send message" name="send">Senden!</button>
            </div>
          </form>
          <div class="mapcontact">
            <iframe src="https://www.google.com/maps/embed?pb=!1m10!1m8!1m3!1d2914.032303766074!2d-79.0741629!3d43.0828162!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sro!2sro!4v1685601513169!5m2!1sro!2sro" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            <div class="mycontact">
              <div class="rowcontact">
                <img src="images/png/house.png" alt="address">
                <a href="https://www.google.com/maps" target="_blank">Musterstraße 123</a>
              </div>
              <div class="rowcontact">
                <img src="images/png/phone.png" alt="phone">
                <a href="tel:030 1234567-8" target="_blank">Tel: 030 1234567-8</a>
              </div>
              <div class="rowcontact">
                <img src="images/png/mail.png" alt="e-mail">
                <a href="mailto:max@mustermann.de"target="_blank">E-mail: max@mustermann.de</a>
              </div>
            </div>
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
