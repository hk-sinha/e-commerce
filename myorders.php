<?php
session_start();
include 'config.php';

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

$email = $_SESSION['email'];

// Fetch user details
$userQuery = $conn->query("SELECT user_id, FirstName FROM user WHERE email = '$email'");
$user = $userQuery->fetch_assoc();
$userid = $user['user_id'];
$firstname = $user['FirstName'];

// Cancel order request
if (isset($_POST['cancel_order'])) {
    $orderId = $_POST['order_id'];
    $updateQuery = $conn->query("UPDATE orders SET order_status = 'Cancelled' WHERE order_id = $orderId AND user_id = $userid");

    if ($updateQuery) {
        $message = "Order cancelled successfully.";
    } else {
        $message = "Failed to cancel the order.";
    }
}

// Fetch orders and product details for the logged-in user
$ordersQuery = $conn->query("
    SELECT o.order_id, o.quantity, o.price, o.order_status, o.order_date, p.product_name, p.product_img_main 
    FROM orders o
    JOIN products p ON o.product_id = p.product_id
    WHERE o.user_id = $userid
    ORDER BY o.order_date DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <link rel="stylesheet" href="myorders.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <script src="https://kit.fontawesome.com/3efc37e746.js" crossorigin="anonymous"></script>


</head>
<body>
<header>
<div class="navbar">
        <a href="home.php" class="active">Home</a>
        <a href="home.php#about">About Us</a>
        <a href="services.php">Shop</a>
        <div class="tech-dropdown">
            <a href="#" id="dropdown-link">Categories</a>
            <div class="tech-content" id="tech-content">
                <a href="#">Women</a>
                <a href="#">Men</a>
                <a href="#">Kids</a>
                <a href="#">Jewellery</a>
            </div>
        </div>
</div>
<nav id="nav" class="nav">
<div class="user">
        <!-- Shopping Bag Icon with Count Badge -->
        <a href="cart.php" class="cart-link">
            <i class='bx bxs-shopping-bag-alt'></i>
            <!-- <span id="cart-count" class="cart-count">0</span> -->
        </a>
<div class="tech-dropdown">
            <a href="#" id="user-dropdown-link"><?php echo  "$firstname"; ?><i class="fa-solid fa-angle-down"></i></a>
            <div class="user-content" id="user-content">
                <a href="editprofile.php"><i class="fa-regular fa-user"></i>Edit Profile</a>
                <a href="updatepassword.php"><i class="fa-solid fa-key"></i>Change Password</a>
                <a href="myorders.php"><i class="fa-solid fa-book"></i>My Orders</a>
                <a href="index.php"><i class="fa-solid fa-right-from-bracket"></i>Logout</a>
            </div>
        </div>
</div>
</nav>
</header>
<!-- scroll effect for header -->
<script>
    window.addEventListener('scroll', function() {
        if (window.scrollY > 50) {
            document.body.classList.add('scrolled');
        } else {
            document.body.classList.remove('scrolled');
        }
    });
</script>

<!-- user-dropdown for technology -->
<script>
    const userdropdownLink = document.getElementById("user-dropdown-link");
    const userContent = document.getElementById("user-content");
    let usertimeId;
    
    userdropdownLink.addEventListener("mouseover", () => {
        clearTimeout(usertimeId);
        userContent.style.display = "block";
    
    });
    
    userdropdownLink.addEventListener("mouseout", () => {
        usertimeId = setTimeout(() => {
            userContent.style.display = "none";
            
        }, 300);
    });
    
    userContent.addEventListener("mouseover", () => {
        clearTimeout(usertimeId);
    });
    
    userContent.addEventListener("mouseout", (event) => {
        if (!event.toElement ||!userContent.contains(event.toElement)) {
            usertimeId = setTimeout(() => {
                userContent.style.display = "none";
            }, 300);
        }
    });
    
    const quickLinks = userContent.getElementsByTagName("a");
    
    for (let i = 0; i < quickLinks.length; i++) {
        quickLinks[i].addEventListener("mouseover", () => {
            clearTimeout(usertimeId);
        });
        quickLinks[i].addEventListener("mouseout", (event) => {
            if (!event.toElement ||!userContent.contains(event.toElement)) {
                usertimeId = setTimeout(() => {
                    userContent.style.display = "none";
                }, 300);
            }
        });
    }

</script>
<!-- dropdown for technology -->
<script>
    const dropdownLink = document.getElementById("dropdown-link");
    const techContent = document.getElementById("tech-content");
    let timeId;
    
    dropdownLink.addEventListener("mouseover", () => {
        clearTimeout(timeId);
        techContent.style.display = "block";
    
    });
    
    dropdownLink.addEventListener("mouseout", () => {
        timeId = setTimeout(() => {
            techContent.style.display = "none";
            
        }, 300);
    });
    
    techContent.addEventListener("mouseover", () => {
        clearTimeout(timeId);
    });
    
    techContent.addEventListener("mouseout", (event) => {
        if (!event.toElement ||!techContent.contains(event.toElement)) {
            timeId = setTimeout(() => {
                techContent.style.display = "none";
            }, 300);
        }
    });
    
    const hyperLinks = techContent.getElementsByTagName("a");
    
    for (let i = 0; i < hyperLinks.length; i++) {
        hyperLinks[i].addEventListener("mouseover", () => {
            clearTimeout(timeId);
        });
    
        hyperLinks[i].addEventListener("mouseout", (event) => {
            if (!event.toElement ||!techContent.contains(event.toElement)) {
                timeId = setTimeout(() => {
                    techContent.style.display = "none";
                }, 300);
            }
        });
    }
</script>

    <main>
        <h1>My Orders</h1>
        <?php if (isset($message)) { echo "<p class='message'>$message</p>"; } ?>
        
        <?php if ($ordersQuery->num_rows > 0) { ?>
            <table class="orders-table">
                <thead>
                    <tr>
                        <!-- <th>Order ID</th> -->
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($order = $ordersQuery->fetch_assoc()) { ?>
                        <tr>
                            <!-- <td><?php echo $order['order_id']; ?></td> -->
                            <td>
                                <img src="admin/image/<?php echo $order['product_img_main']; ?>" alt="<?php echo $order['product_name']; ?>" class="product-img">
                                <?php echo htmlspecialchars($order['product_name']); ?>
                            </td>
                            <td><?php echo $order['quantity']; ?></td>
                            <td>Rs. <?php echo $order['price']; ?></td>
                            <td><?php echo $order['order_status']; ?></td>
                            <td>
                                <?php if ($order['order_status'] !== 'Cancelled') { ?>
                                    <form method="post" style="display:inline;">
                                        <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                                        <button type="submit" name="cancel_order" class="cancel-btn">Cancel</button>
                                    </form>
                                <?php } else { ?>
                                    <span class="cancelled-text">Cancelled</span>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p>You have no orders.</p>
        <?php } ?>
    </main>
</body>
</html>
