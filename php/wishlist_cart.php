<?php

// Check if the "add_to_wishlist" form is submitted
if(isset($_POST['add_to_wishlist'])){

   // Check if the user is logged in (user_id is not empty)
   if($user_id == ''){
      header('location:user_login.php'); // Redirect to the login page if not logged in
   }else{

      // Get product information from the submitted form
      $pid = $_POST['pid'];
      $pid = htmlspecialchars(filter_var($pid, FILTER_SANITIZE_STRING));
      $name = $_POST['name'];
      $name = htmlspecialchars(filter_var($name, FILTER_SANITIZE_STRING));
      $price = $_POST['price'];
      $price = htmlspecialchars(filter_var($price, FILTER_SANITIZE_STRING));
      $image = $_POST['image'];
      $image = htmlspecialchars(filter_var($image, FILTER_SANITIZE_STRING));

      // Check if the product is already in the user's wishlist
      $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
      $check_wishlist_numbers->execute([$name, $user_id]);

      // Check if the product is already in the user's cart
      $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
      $check_cart_numbers->execute([$name, $user_id]);

      // If the product is in the wishlist, display a message
      if($check_wishlist_numbers->rowCount() > 0){
         $message[] = 'Bereits zur Wunschliste hinzugefügt!';
      }elseif($check_cart_numbers->rowCount() > 0){
         // If the product is in the cart, display a message
         $message[] = 'Bereits zum Warenkorb hinzugefügt!';
      }else{
         // If the product is not in the wishlist or cart, insert it into the wishlist
         $insert_wishlist = $conn->prepare("INSERT INTO `wishlist`(user_id, pid, name, price, image) VALUES(?,?,?,?,?)");
         $insert_wishlist->execute([$user_id, $pid, $name, $price, $image]);
         $message[] = 'Zur Wunschliste hinzugefügt!';
      }
   }
}

// Check if the "add_to_cart" form is submitted
if(isset($_POST['add_to_cart'])){

   // Check if the user is logged in (user_id is not empty)
   if($user_id == ''){
      header('location:user_login.php'); // Redirect to the login page if not logged in
   }else{

      // Get product information from the submitted form
      $pid = $_POST['pid'];
      $pid = htmlspecialchars(filter_var($pid, FILTER_SANITIZE_STRING));
      $name = $_POST['name'];
      $name = htmlspecialchars(filter_var($name, FILTER_SANITIZE_STRING));
      $price = $_POST['price'];
      $price = htmlspecialchars(filter_var($price, FILTER_SANITIZE_STRING));
      $image = $_POST['image'];
      $image = htmlspecialchars(filter_var($image, FILTER_SANITIZE_STRING));
      $qty = $_POST['qty'];
      $qty = htmlspecialchars(filter_var($qty, FILTER_SANITIZE_STRING));

      // Check if the product is already in the user's cart
      $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
      $check_cart_numbers->execute([$name, $user_id]);

      // If the product is in the cart, display a message
      if($check_cart_numbers->rowCount() > 0){
         $message[] = 'Bereits zum Warenkorb hinzugefügt!';
      }else{

         // Check if the product is in the user's wishlist
         $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
         $check_wishlist_numbers->execute([$name, $user_id]);

         // If the product is in the wishlist, remove it from the wishlist
         if($check_wishlist_numbers->rowCount() > 0){
            $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE name = ? AND user_id = ?");
            $delete_wishlist->execute([$name, $user_id]);
         }

         // Insert the product into the cart
         $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES(?,?,?,?,?,?)");
         $insert_cart->execute([$user_id, $pid, $name, $price, $qty, $image]);
         $message[] = 'Zum Warenkorb hinzugefügt!';
      }
   }
}

?>
