<?php
// add_to_cart.php
session_start();
include 'config.php'; // Include the database connection
$email = $_SESSION['email'];

if (isset($email)) {
    $sql = "SELECT * FROM user WHERE email = '$email'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $firstname = $row['FirstName'];
    $userid = $row['user_id'];
} else {
    echo "";
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];

    // Check if the product is already in the cart
    $check_query = "SELECT * FROM cart WHERE user_id = '$userid' AND product_id = '$product_id'";
    $result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($result) > 0) {
        // If product exists, update quantity
        $update_query = "UPDATE cart SET quantity = quantity + 1 WHERE user_id = '$userid' AND product_id = '$product_id'";
        if (mysqli_query($conn, $update_query)) {
            echo "Product quantity updated";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        // If product doesn't exist, insert new row
        $insert_query = "INSERT INTO cart (user_id, product_id, quantity) VALUES ('$userid', '$product_id', 1)";
        if (mysqli_query($conn, $insert_query)) {
            echo "Item added to cart";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
} else {
    echo "Invalid request";
}
?>
