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

// Check if the profile update form has been submitted
if (isset($_POST['submit'])) {
   // Sanitize and retrieve the user's name and email from the form
   $name = $_POST['name'];
   $name = htmlspecialchars(filter_var($name, FILTER_SANITIZE_STRING));
   $email = $_POST['email'];
   $email = htmlspecialchars(filter_var($email, FILTER_SANITIZE_STRING));

   // Prepare and execute a database query to update the user's name and email
   $update_profile = $conn->prepare("UPDATE `users` SET name = ?, email = ? WHERE id = ?");
   $update_profile->execute([$name, $email, $user_id]);

   // Set an empty password string for comparison
   $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';

   // Retrieve and sanitize the previous password, old password, new password, and confirm password from the form
   $prev_pass = $_POST['prev_pass'];
   $old_pass = sha1($_POST['old_pass']);
   $old_pass = htmlspecialchars(filter_var($old_pass, FILTER_SANITIZE_STRING));
   $new_pass = sha1($_POST['new_pass']);
   $new_pass = htmlspecialchars(filter_var($new_pass, FILTER_SANITIZE_STRING));
   $cpass = sha1($_POST['cpass']);
   $cpass = htmlspecialchars(filter_var($cpass, FILTER_SANITIZE_STRING));

   // Check if the old password is empty
   if ($old_pass == $empty_pass) {
      $message[] = 'Please enter the old password!';
   } elseif ($old_pass != $prev_pass) {
      $message[] = 'Old password does not match!';
   } elseif ($new_pass != $cpass) {
      $message[] = 'Confirm password does not match!';
   } else {
      // Check if the new password is not empty
      if ($new_pass != $empty_pass) {
         // Prepare and execute a database query to update the user's password
         $update_admin_pass = $conn->prepare("UPDATE `users` SET password = ? WHERE id = ?");
         $update_admin_pass->execute([$cpass, $user_id]);
         $message[] = 'Password updated successfully!';
      } else {
         $message[] = 'Please enter a new password!';
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
  <title>Wine-Shop</title>
</head>
<body>
   
<?php include 'header_and_footer/wine_header.php'; ?>

<section class="form-container">

   <form action="" method="post">
      <h3>Jetzt aktualisieren</h3>
      <input type="hidden" name="prev_pass" value="<?= $fetch_profile["password"]; ?>">
      <input type="text" name="name" required placeholder="Geben Sie Ihren Benutzernamen ein" maxlength="20"  class="box" value="<?= $fetch_profile["name"]; ?>">
      <input type="email" name="email" required placeholder="geben sie ihre E-Mail Adresse ein" maxlength="50"  class="box" oninput="this.value = this.value.replace(/\s/g, '')" value="<?= $fetch_profile["email"]; ?>">
      <input type="password" name="old_pass" placeholder="Geben Sie Ihr altes Passwort ein" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="new_pass" placeholder="Gib dein neues Passwort ein" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="cpass" placeholder="Bestätigen Sie Ihr neues Passwort" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="Jetzt aktualisieren" class="btn" name="submit">
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