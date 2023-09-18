<?php
// Include a PHP file named 'connect.php' located in the parent directory.
include '../php/connect.php';

// Start a PHP session or resume the current session.
session_start();

// Check if the 'submit' button in a form with the name 'submit' has been clicked.
if(isset($_POST['submit'])){
   // Retrieve the 'name' and 'pass' values from the submitted form.
   $name = $_POST['name'];
   $name = htmlspecialchars(filter_var($name, FILTER_SANITIZE_STRING)); // Sanitize and filter the 'name' input.
   $pass = sha1($_POST['pass']); // Hash the 'pass' (password) input using SHA-1.
   $pass = htmlspecialchars(filter_var($pass, FILTER_SANITIZE_STRING)); // Sanitize and filter the hashed password.

   // Prepare a SQL query to select an admin record with the given 'name' and 'password'.
   $select_admin = $conn->prepare("SELECT * FROM `admins` WHERE name = ? AND password = ?");
   
   // Execute the query with the 'name' and hashed 'pass' as parameters.
   $select_admin->execute([$name, $pass]);

   // Fetch the first matching admin record as an associative array.
   $row = $select_admin->fetch(PDO::FETCH_ASSOC);

   // Check if there is a matching admin record.
   if($select_admin->rowCount() > 0){
      // If a match is found, set the 'admin_id' session variable to the admin's 'id'.
      $_SESSION['admin_id'] = $row['id'];

      // Redirect the user to the 'dashboard.php' page.
      header('location:dashboard.php');
   }else{
      // If no match is found, add a message to the $message array indicating incorrect username or password.
      $message[] = 'incorrect username or password!';
   }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../styles/admin_style.css">

</head>
<body>

  <?php
  // Check if the 'message' array is set.
  if(isset($message)){
      // Iterate through each message in the 'message' array.
      foreach($message as $message){
        // Display a message with a close button.
        echo '
        <div class="message">
            <span>'.$message.'</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
        </div>
        ';
      }
  }
  ?>

  <section class="form-container">
      <form action="" method="post">
          <h3>login now</h3>
          <p>default username = <span>admin</span> & password = <span>111</span></p>
          <!-- Input field for entering the username -->
          <input type="text" name="name" required placeholder="enter your username" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
          <!-- Input field for entering the password -->
          <input type="password" name="pass" required placeholder="enter your password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
          <!-- Submit button for the login form -->
          <input type="submit" value="login now" class="btn" name="submit">
      </form>
  </section>

  <!-- Include a JavaScript file named 'admin_script.js' -->
  <script src="../scripts/admin_script.js"></script>

</body>
</html>