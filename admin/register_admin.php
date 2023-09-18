<?php
// Include a PHP file named 'connect.php' located in the parent directory.
include '../php/connect.php';

// Start a PHP session or resume the current session.
session_start();

// Retrieve the 'admin_id' value from the session.
$admin_id = $_SESSION['admin_id'];

// Check if 'admin_id' is not set in the session (admin is not logged in).
if (!isset($admin_id)) {
   // Redirect the user to the 'admin_login.php' page.
   header('location:admin_login.php');
}

// Check if the 'submit' button in the registration form has been pressed.
if(isset($_POST['submit'])){
   // Retrieve the submitted values from the form.
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING); // Sanitize the 'name' input.
   
   // Hash the submitted password using SHA-1.
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING); // Sanitize the 'pass' input.
   
   // Hash the submitted confirm password using SHA-1.
   $cpass = sha1($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING); // Sanitize the 'cpass' input.

   // Prepare a query to check if the provided username already exists.
   $select_admin = $conn->prepare("SELECT * FROM `admins` WHERE name = ?");
   $select_admin->execute([$name]);

   // Check if a record with the provided username already exists.
   if($select_admin->rowCount() > 0){
      $message[] = 'username already exists!';
   } else {
      // Check if the provided password and confirm password match.
      if($pass != $cpass){
         $message[] = 'confirm password does not match!';
      } else {
         // Insert a new admin record into the 'admins' table.
         $insert_admin = $conn->prepare("INSERT INTO `admins`(name, password) VALUES(?,?)");
         $insert_admin->execute([$name, $cpass]);
         $message[] = 'new admin registered successfully!';
      }
   }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register admin</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="../styles/admin_style.css">
</head>
<body>

  <?php include '../php/admin_header.php'; ?>

  <section class="form-container">

  <form action="" method="post">
    <h3>Register Now</h3>
    <!-- Input field for entering the admin's username -->
    <input type="text" name="name" required placeholder="enter your username" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
    
    <!-- Input field for entering the admin's password -->
    <input type="password" name="pass" required placeholder="enter your password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
    
    <!-- Input field for confirming the admin's password -->
    <input type="password" name="cpass" required placeholder="confirm your password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
    
    <!-- Submit button for registering a new admin -->
    <input type="submit" value="register now" class="btn" name="submit">
  </form>


  </section>

  <script src="../scripts/admin_script.js"></script>
    
</body>
</html>