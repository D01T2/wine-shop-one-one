<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["add_to_cart"])) {
    // Retrieve product information from the form
    $productId = $_POST["pid"];
    $quantity = $_POST["qty"];

    // Update the database to subtract the purchased quantity
    $updateQuery = $conn->prepare("UPDATE products SET quantity = quantity - :quantity WHERE id = :pid");
    $updateQuery->bindParam(':quantity', $quantity, PDO::PARAM_INT);
    $updateQuery->bindParam(':pid', $productId, PDO::PARAM_INT);

    // Execute the query
    if ($updateQuery->execute()) {
        // Product purchased successfully
        echo "Produkt gekauft!";
    } else {
        // Handle the error if the query fails
        echo "Fehler beim Kauf des Produkts.";
    }
}
?>
