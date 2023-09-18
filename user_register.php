<?php
// Include the database connection file and start a session
include 'php/connect.php';
session_start();

// Check if the user is logged in and set the user_id variable accordingly
if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
}

// Check if the registration form has been submitted
if (isset($_POST['submit'])) {
   // Sanitize and retrieve the user's name, email, password, and confirm password from the form
   $name = $_POST['name'];
   $name = htmlspecialchars(filter_var($name, FILTER_SANITIZE_STRING));
   $email = $_POST['email'];
   $email = htmlspecialchars(filter_var($email, FILTER_SANITIZE_STRING));
   $pass = sha1($_POST['pass']);
   $pass = htmlspecialchars(filter_var($pass, FILTER_SANITIZE_STRING));
   $cpass = sha1($_POST['cpass']);
   $cpass = htmlspecialchars(filter_var($cpass, FILTER_SANITIZE_STRING));

   // Prepare and execute a database query to check if the provided email already exists
   $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
   $select_user->execute([$email]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);

   // Check if a user with the provided email already exists
   if ($select_user->rowCount() > 0) {
      $message[] = 'E-Mail existiert bereits!';
   } else {
      // Check if the provided password and confirm password match
      if ($pass != $cpass) {
         $message[] = 'Bestätigen Sie, dass das Passwort nicht übereinstimmt!';
      } else {
         // Insert a new user into the database with the provided name, email, and password
         $insert_user = $conn->prepare("INSERT INTO `users`(name, email, password) VALUES(?,?,?)");
         $insert_user->execute([$name, $email, $cpass]);
         $message[] = 'Erfolgreich registriert. Bitte melden Sie sich jetzt an.';
      }
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
  <title>Registrieren</title>
</head>
<body>
    
  <?php include 'header_and_footer/wine_header.php'; ?>

  <section class="form-container">

    <form action="" method="post">
        <h3>Registrieren</h3>
        <input type="text" name="name" required placeholder="Geben Sie Ihren Benutzernamen ein" maxlength="20"  class="box">
        <input type="email" name="email" required placeholder="geben sie ihre E-Mail Adresse ein" maxlength="50"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
        <input type="password" name="pass" required placeholder="Geben Sie Ihr Passwort ein" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
        <input type="password" name="cpass" required placeholder="bestätigen Sie Ihr Passwort" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
        <input type="submit" value="Registrieren" class="btn" name="submit">
        <p>Sie haben bereits ein Konto?</p>
        <a href="user_login.php" class="option-btn">Jetzt einloggen</a>
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