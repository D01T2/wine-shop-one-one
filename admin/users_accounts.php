<?php
include '../php/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    
    // Delete the user from the 'users' table.
    $delete_user = $conn->prepare("DELETE FROM `users` WHERE id = ?");
    $delete_user->execute([$delete_id]);

    // Delete orders associated with the user from the 'orders' table.
    $delete_orders = $conn->prepare("DELETE FROM `orders` WHERE user_id = ?");
    $delete_orders->execute([$delete_id]);

    // Delete messages associated with the user from the 'messages' table.
    $delete_messages = $conn->prepare("DELETE FROM `messages` WHERE user_id = ?");
    $delete_messages->execute([$delete_id]);

    // Delete cart items associated with the user from the 'cart' table.
    $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
    $delete_cart->execute([$delete_id]);

    // Delete wishlist items associated with the user from the 'wishlist' table.
    $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE user_id = ?");
    $delete_wishlist->execute([$delete_id]);

    // Redirect to the users_accounts.php page after deleting the user and associated data.
    header('location:users_accounts.php');
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>users accounts</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="../styles/admin_style.css">

</head>
<body>

  <?php include '../php/admin_header.php'; ?>

  <section class="accounts">

    <h1 class="heading">user accounts</h1>

    <div class="box-container">
      <?php
      $select_accounts = $conn->prepare("SELECT * FROM `users`");
      $select_accounts->execute();

      // Check if there are user accounts in the database.
      if ($select_accounts->rowCount() > 0) {
          while ($fetch_accounts = $select_accounts->fetch(PDO::FETCH_ASSOC)) {
              // Loop through each user account and display their information.
      ?>
              <div class="box">
                  <p> user id : <span><?= $fetch_accounts['id']; ?></span> </p>
                  <p> username : <span><?= $fetch_accounts['name']; ?></span> </p>
                  <p> email : <span><?= $fetch_accounts['email']; ?></span> </p>
                  
                  <!-- Create a link to delete the user account -->
                  <a href="users_accounts.php?delete=<?= $fetch_accounts['id']; ?>" onclick="return confirm('delete this account? the user-related information will also be deleted!')" class="delete-btn">delete</a>
              </div>
      <?php
          }
      } else {
          // Display a message if no user accounts are available.
          echo '<p class="empty">no accounts available!</p>';
      }
    ?>

    </div>

  </section>

  <script src="../scripts/admin_script.js"></script>
   
</body>
</html>