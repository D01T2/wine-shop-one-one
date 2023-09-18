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

// Check if the 'delete' parameter is set in the URL (query string).
if (isset($_GET['delete'])) {
    // Retrieve the 'delete' parameter value from the URL.
    $delete_id = $_GET['delete'];
    
    // Prepare a SQL query to delete a message by its 'id'.
    $delete_message = $conn->prepare("DELETE FROM `messages` WHERE id = ?");
    
    // Check if the prepared statement was successfully created.
    if ($delete_message) {
        // Execute the prepared statement, passing the 'delete_id' as a parameter.
        if ($delete_message->execute([$delete_id])) {
            // Redirect the user to the 'messages.php' page after successfully deleting the message.
            header('location: messages.php');
        } else {
            // Display an error message if there was an issue executing the query.
            echo "Error deleting the message: " . implode(" ", $delete_message->errorInfo());
        }
    } else {
        // Display an error message if there was an issue preparing the delete statement.
        echo "Error preparing the delete statement.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>messages</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../styles/admin_style.css">

</head>
<body>

  <?php include '../php/admin_header.php'; ?>

  <section class="contacts">

    <h1 class="heading">messages</h1>

    <div class="box-container">

      <?php
      // Prepare a SQL query to select all records from the 'messages' table.
      $select_messages = $conn->prepare("SELECT * FROM `messages`");

      // Execute the query.
      $select_messages->execute();

      // Check if there are rows (messages) in the result.
      if ($select_messages->rowCount() > 0) {
          // Loop through the result set and fetch each message.
          while ($fetch_message = $select_messages->fetch(PDO::FETCH_ASSOC)) {
      ?>
      <div class="box">
          <p> user id : <span><?= $fetch_message['user_id']; ?></span></p>
          <p> name : <span><?= $fetch_message['name']; ?></span></p>
          <p> email : <span><?= $fetch_message['email']; ?></span></p>
          <p> number : <span><?= $fetch_message['number']; ?></span></p>
          <p> message : <span><?= $fetch_message['message']; ?></span></p>
          <!-- Delete message link with a confirmation prompt -->
          <a href="messages.php?delete=<?= $fetch_message['id']; ?>" onclick="return confirm('Delete this message?');" class="delete-btn">delete</a>
      </div>
      <?php
          }
      } else {
          // Display a message if there are no messages.
          echo '<p class="empty">you have no messages</p>';
      }
      ?>

    </div>

  </section>

  <script src="../scripts/admin_script.js"></script>
   
</body>
</html>