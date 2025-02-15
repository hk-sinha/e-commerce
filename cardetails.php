<?php
session_start();

include("config.php");
$product_id=$_GET['product_id'];
$email = $_SESSION['email'];

$sql="SELECT * FROM products WHERE product_id = '$product_id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();


if (isset($email) ){
    $sql = "SELECT * FROM user WHERE email = '$email'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $firstname = $row['FirstName'];
    $userid=$row['user_id'];
    /*echo "Welcome, " . $firstname;*/
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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="cardetail.css">
    <title>Product Detail</title>
</head>
<body>
    <h1></h1>
    <form method="post" >
        <div class="product-details">
            <div class="product-image">
            <img src="admin/image/<?php echo $row['product_img_main']; ?>" alt="" width="450px" height="auto">
    <img src="admin/image/<?php echo $row['img_url2']; ?>" alt="" width="450px" height="auto">
    <img src="admin/image/<?php echo $row['img_url3']; ?>" alt="" width="450px" height="auto">
    <img src="admin/image/<?php echo $row['img_url4']; ?>" alt="" width="450px" height="auto">
    <img src="admin/image/<?php echo $row['img_url5']; ?>" alt="" width="450px" height="auto">

            </div>
            <div class="product-info">
                <div class="product-title">
                <input type="text" id="car_name" name="car_name" value="<?php echo $row['product_name']; ?>" readonly>
                </div>
                <div class="product-price">
                    <span class="original-price"><input type="text" id="model_year" name="model_year" value="&#8377; <?php echo $row['pre_price']; ?>" readonly></span>
                    <span>        <input type="text" id="price_per_day" name="price_per_day" value="&#8377; <?php echo $row['price']; ?>" readonly>
                    </span>
                </div>
                <div class="product-description">
                    <input type="text" id="description" name="description" value="<?php echo $row['description'];?>">
                </div>
            </div>
        </div>
        <!-- <label for="car_img_main">Car Image:</label> -->
        <button type="submit" name="add_cart">Add to cart</button>
        <button type="submit" name="cancel_booking">Cancel</button>
    </form>
    
</body>
</html>