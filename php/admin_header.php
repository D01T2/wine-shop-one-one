<?php
   if(isset($message)){
      foreach($message as $message){
         echo '
         <div class="message">
            <span>'.$message.'</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';
      }
   }
?>

<header class="header">

   <section class="flex">

      <a href="../admin/dashboard.php" class="logo">Admin<span>Panel</span></a>

      <nav class="navbar">
        <ul class="navi-list">
          <li class="list-item"><a href="../admin/dashboard.php">home</a></li>
          <li class="list-item"><a href="../admin/products.php">products</a></li>
          <li class="list-item"><a href="../admin/placed_orders.php">orders</a></li>
          <li class="list-item"><a href="../admin/admin_accounts.php">admins</a></li>
          <li class="list-item"><a href="../admin/users_accounts.php">users</a></li>
          <li class="list-item"><a href="../admin/messages.php">messages</a></li>
        </ul>
      </nav>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="user-btn" class="fas fa-user"></div>
      </div>

      <div class="profile">
        <?php
            // Select the admin's profile information from the database using their ID
            $select_profile = $conn->prepare("SELECT * FROM `admins` WHERE id = ?");
            $select_profile->execute([$admin_id]);

            // Fetch the profile data as an associative array
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
        ?>
        <!-- Display the admin's name -->
        <p><?= $fetch_profile['name']; ?></p>

        <!-- Link to update the admin's profile -->
        <a href="../admin/update_profile.php" class="btn">update profile</a>

        <!-- Links for admin-related actions (register, login) -->
        <div class="flex-btn">
            <a href="../admin/register_admin.php" class="option-btn">register</a>
            <a href="../admin/admin_login.php" class="option-btn">login</a>
        </div>

        <!-- Link to log out the admin with a confirmation dialog -->
        <a href="../php/admin_logout.php" class="delete-btn" onclick="return confirm('logout from the website?');">logout</a> 
      </div>

   </section>

</header>