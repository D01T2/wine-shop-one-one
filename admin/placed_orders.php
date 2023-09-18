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

// Check if the 'update_payment' form has been submitted.
if(isset($_POST['update_payment'])){
   // Retrieve the 'order_id' and 'payment_status' values from the submitted form.
   $order_id = $_POST['order_id'];
   $payment_status = $_POST['payment_status'];
   $payment_status = filter_var($payment_status, FILTER_SANITIZE_STRING); // Sanitize the 'payment_status' input.
   
   // Prepare a SQL query to update the payment status of an order by 'id'.
   $update_payment = $conn->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");
   
   // Execute the prepared query, passing 'payment_status' and 'order_id' as parameters.
   $update_payment->execute([$payment_status, $order_id]);
   
   // Add a success message to the $message array.
   $message[] = 'payment status updated!';
}

// Check if the 'delete' parameter is set in the URL (query string).
if(isset($_GET['delete'])){
   // Retrieve the 'delete' parameter value from the URL.
   $delete_id = $_GET['delete'];
   
   // Prepare a SQL query to delete an order by 'id'.
   $delete_order = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
   
   // Execute the prepared query, passing 'delete_id' as a parameter.
   $delete_order->execute([$delete_id]);
   
   // Redirect the user to the 'placed_orders.php' page after deleting the order.
   header('location:placed_orders.php');
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>placed orders</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="../styles/admin_style.css">

</head>
<body>

  <?php include '../php/admin_header.php'; ?>

  <section class="orders">

    <h1 class="heading">placed orders</h1>

    <div class="box-container">

      <?php
      // Prepare a SQL query to select all records from the 'orders' table.
      $select_orders = $conn->prepare("SELECT * FROM `orders`");

      // Execute the query.
      $select_orders->execute();

      // Check if there are rows (orders) in the result.
      if ($select_orders->rowCount() > 0) {
          // Loop through the result set and fetch each order.
          while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
      ?>
      <div class="box">
          <p> placed on : <span><?= $fetch_orders['placed_on']; ?></span> </p>
          <p> name : <span><?= $fetch_orders['name']; ?></span> </p>
          <p> number : <span><?= $fetch_orders['number']; ?></span> </p>
          <p> address : <span><?= $fetch_orders['address']; ?></span> </p>
          <p> total products : <span><?= $fetch_orders['total_products']; ?></span> </p>
          <p> total price : <span>$<?= $fetch_orders['total_price']; ?>/-</span> </p>
          <p> payment method : <span><?= $fetch_orders['method']; ?></span> </p>
          <form action="" method="post">
              <!-- Hidden input field to store the order ID -->
              <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
              <!-- Dropdown to select and update the payment status -->
              <select name="payment_status" class="select">
                  <option selected disabled><?= $fetch_orders['payment_status']; ?></option>
                  <option value="pending">pending</option>
                  <option value="completed">completed</option>
              </select>
              <div class="flex-btn">
                  <!-- Submit button to update payment status -->
                  <input type="submit" value="update" class="option-btn" name="update_payment">
                  <!-- Delete order link with a confirmation prompt -->
                  <a href="placed_orders.php?delete=<?= $fetch_orders['id']; ?>" class="delete-btn" onclick="return confirm('delete this order?');">delete</a>
              </div>
          </form>
      </div>
      <?php
          }
      } else {
          // Display a message if there are no orders.
          echo '<p class="empty">no orders placed yet!</p>';
      }
      ?>

    </div>

  </section>

  <script src="../scripts/admin_script.js"></script>
    
</body>
</html>