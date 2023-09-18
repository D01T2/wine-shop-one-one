<?php
// Include a PHP file named 'connect.php' located in the parent directory.
include '../php/connect.php';

// Start a PHP session or resume the current session.
session_start();

// Retrieve the 'admin_id' value from the session. This is likely set after a successful login.
$admin_id = $_SESSION['admin_id'];

// Check if 'admin_id' is not set in the session (admin is not logged in).
if (!isset($admin_id)) {
   // Redirect the user to the 'admin_login.php' page.
   header('location:admin_login.php');
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>dashboard</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="../styles/admin_style.css">
</head>
<body>

<?php include '../php/admin_header.php'; ?>

<section class="dashboard">

   <h1 class="heading">dashboard</h1>

   <div class="box-container">

<!-- Box displaying the admin's name and an 'update profile' link -->
<div class="box">
   <h3>welcome!</h3>
   <p><?= $fetch_profile['name']; ?></p>
   <a href="update_profile.php" class="btn">update profile</a>
</div>

<!-- Box displaying the total amount of pending orders -->
<div class="box">
   <?php
      $total_pendings = 0;
      // Prepare a query to select orders with 'payment_status' set to 'pending'
      $select_pendings = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
      $select_pendings->execute(['pending']);
      if($select_pendings->rowCount() > 0){
         while($fetch_pendings = $select_pendings->fetch(PDO::FETCH_ASSOC)){
            // Calculate the total price of pending orders
            $total_pendings += $fetch_pendings['total_price'];
         }
      }
   ?>
   <h3><span>€</span><?= $total_pendings; ?><span>/-</span></h3>
   <p>total pendings</p>
   <a href="placed_orders.php" class="btn">see orders</a>
</div>

<!-- Box displaying the total amount of completed orders -->
<div class="box">
   <?php
      $total_completes = 0;
      // Prepare a query to select orders with 'payment_status' set to 'completed'
      $select_completes = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
      $select_completes->execute(['completed']);
      if($select_completes->rowCount() > 0){
         while($fetch_completes = $select_completes->fetch(PDO::FETCH_ASSOC)){
            // Calculate the total price of completed orders
            $total_completes += $fetch_completes['total_price'];
         }
      }
   ?>
   <h3><span>€</span><?= $total_completes; ?><span>/-</span></h3>
   <p>completed orders</p>
   <a href="placed_orders.php" class="btn">see orders</a>
</div>

<!-- Box displaying the total number of orders placed -->
<div class="box">
   <?php
      // Prepare a query to select all orders
      $select_orders = $conn->prepare("SELECT * FROM `orders`");
      $select_orders->execute();
      // Get the number of rows (number of orders)
      $number_of_orders = $select_orders->rowCount()
   ?>
   <h3><?= $number_of_orders; ?></h3>
   <p>orders placed</p>
   <a href="placed_orders.php" class="btn">see orders</a>
</div>

<!-- Box displaying the total number of products added -->
<div class="box">
   <?php
      // Prepare a query to select all products
      $select_products = $conn->prepare("SELECT * FROM `products`");
      $select_products->execute();
      // Get the number of rows (number of products)
      $number_of_products = $select_products->rowCount()
   ?>
   <h3><?= $number_of_products; ?></h3>
   <p>products added</p>
   <a href="products.php" class="btn">see products</a>
</div>

<!-- Box displaying the total number of normal users -->
<div class="box">
   <?php
      // Prepare a query to select all normal users
      $select_users = $conn->prepare("SELECT * FROM `users`");
      $select_users->execute();
      // Get the number of rows (number of normal users)
      $number_of_users = $select_users->rowCount()
   ?>
   <h3><?= $number_of_users; ?></h3>
   <p>normal users</p>
   <a href="users_accounts.php" class="btn">see users</a>
</div>

<!-- Box displaying the total number of admin users -->
<div class="box">
   <?php
      // Prepare a query to select all admin users
      $select_admins = $conn->prepare("SELECT * FROM `admins`");
      $select_admins->execute();
      // Get the number of rows (number of admin users)
      $number_of_admins = $select_admins->rowCount()
   ?>
   <h3><?= $number_of_admins; ?></h3>
   <p>admin users</p>
   <a href="admin_accounts.php" class="btn">see admins</a>
</div>

<!-- Box displaying the total number of new messages -->
<div class="box">
   <?php
      // Prepare a query to select all new messages
      $select_messages = $conn->prepare("SELECT * FROM `messages`");
      $select_messages->execute();
      // Get the number of rows (number of new messages)
      $number_of_messages = $select_messages->rowCount()
   ?>
   <h3><?= $number_of_messages; ?></h3>
   <p>new messages</p>
   <a href="messages.php" class="btn">See messages</a>
</div>

</div>


</section>

<script src="../scripts/admin_script.js"></script>
   
</body>
</html>