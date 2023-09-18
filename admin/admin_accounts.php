<?php
// Include a PHP file named 'connect.php' located in the parent directory.
include '../php/connect.php';

// Start a PHP session or resume the current session.
session_start();

// Retrieve the 'admin_id' value from the session.
$admin_id = $_SESSION['admin_id'];

// Check if 'admin_id' is not set in the session (admin is not logged in).
if (!isset($admin_id)) {
   // Redirect the user to 'admin_login.php'.
   header('location:admin_login.php');
}

// Check if the 'delete' parameter is set in the URL (query string).
if (isset($_GET['delete'])) {
   // Retrieve the 'delete' parameter value from the URL.
   $delete_id = $_GET['delete'];

   // Prepare a SQL query to delete an admin record by ID.
   $delete_admins = $conn->prepare("DELETE FROM `admins` WHERE id = ?");

   // Execute the prepared query, passing the 'delete_id' as a parameter.
   $delete_admins->execute([$delete_id]);

   // Redirect the user to 'admin_accounts.php' after deleting the admin record.
   header('location:admin_accounts.php');
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>admin accounts</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../styles/admin_style.css">

</head>
<body>

<?php include '../php/admin_header.php'; ?>

<section class="accounts">

   <h1 class="heading">admin accounts</h1>

   <div class="box-container">
      <!-- Add new admin button -->
      <div class="box">
          <p>add new admin</p>
          <a href="register_admin.php" class="option-btn">register admin</a>
      </div>

      <?php
          // Prepare a SQL query to select all records from the 'admins' table.
          $select_accounts = $conn->prepare("SELECT * FROM `admins`");
          
          // Execute the query.
          $select_accounts->execute();
          
          // Check if there are rows in the result.
          if($select_accounts->rowCount() > 0){
            // Loop through the result set and fetch each admin account.
            while($fetch_accounts = $select_accounts->fetch(PDO::FETCH_ASSOC)){   
      ?>
      <!-- Display admin account information -->
        <div class="box">
            <p> admin id : <span><?= $fetch_accounts['id']; ?></span> </p>
            <p> admin name : <span><?= $fetch_accounts['name']; ?></span> </p>
            <div class="flex-btn">
              <!-- Delete admin account link with confirmation prompt -->
              <a href="admin_accounts.php?delete=<?= $fetch_accounts['id']; ?>" onclick="return confirm('delete this account?')" class="delete-btn">delete</a>
              <?php
                  // Check if the current admin account matches the logged-in admin's ID.
                  if($fetch_accounts['id'] == $admin_id){
                    // Display an 'update' button for the logged-in admin.
                    echo '<a href="update_profile.php" class="option-btn">update</a>';
                  }
              ?>
        </div>
      </div>
      <?php
            }
          } else {
            // Display a message if there are no admin accounts available.
            echo '<p class="empty">no accounts available!</p>';
          }
      ?>

    </div>


</section>

<script src="../scripts/admin_script.js"></script>
   
</body>
</html>