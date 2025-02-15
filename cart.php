<?php
session_start();
include 'config.php';

if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit;
}

$email = $_SESSION['email'];

// Fetch user ID from session
$userQuery = "SELECT user_id, FirstName FROM user WHERE email = '$email'";
$userResult = $conn->query($userQuery);
$userRow = $userResult->fetch_assoc();
$userid = $userRow['user_id'];
$firstname = $userRow['FirstName'];

// Fetch cart items for the user
$cartQuery = "
    SELECT c.cart_id, c.quantity, p.product_name, p.product_img_main, p.price, p.description 
    FROM cart c
    JOIN products p ON c.product_id = p.product_id
    WHERE c.user_id = $userid
";
$cartResult = $conn->query($cartQuery);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Cart</title>
    <link rel="stylesheet" href="cart.css">
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
    <div class="cart-container">
        <?php if ($cartResult->num_rows > 0) { ?>
            <table class="cart-table">
                <thead>
                    <tr>
                        <!-- <th>Image</th> -->
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($cartRow = $cartResult->fetch_assoc()) { ?>
                        <tr>
                        <td class="product-info">
                <img src="admin/image/<?php echo $cartRow['product_img_main']; ?>" alt="Product Image">
                <span><?php echo $cartRow['product_name']; ?></span>
            </td>
                            
                            <td>
                                <!-- Update form -->
                                <div class="quantity-control">
                                <button class="decrement" onclick="updateQuantity(<?php echo $cartRow['cart_id']; ?>, 'decrement')">-</button>
                                <input type="number" id="quantity-<?php echo $cartRow['cart_id']; ?>" value="<?php echo $cartRow['quantity']; ?>" min="1" readonly>
                                <button class="increment" onclick="updateQuantity(<?php echo $cartRow['cart_id']; ?>, 'increment')">+</button>
                </div>
                            </td>
                            <td>Rs. <?php echo $cartRow['price']; ?></td>
                            <td>Rs. <?php echo $cartRow['price'] * $cartRow['quantity']; ?></td>
                            <td>
                                <!-- Remove form -->
                                <form method="post" action="delete_cart_item.php" class="remove-form">
                                    <input type="hidden" name="cart_id" value="<?php echo $cartRow['cart_id']; ?>">
                                    <button type="submit" class="remove-btn"><i class='bx bxs-trash-alt'></i></button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <!-- Checkout form -->
            <form method="post" action="checkout.php">
                <?php
                // Add cart IDs as hidden fields to submit all items for checkout
                $cartResult->data_seek(0); // Reset result pointer to fetch data again
                while ($cartRow = $cartResult->fetch_assoc()) {
                    echo '<input type="hidden" name="cart_items[]" value="' . $cartRow['cart_id'] . '">';
                }
                ?>
                <button type="submit" name="buy_now" class="buy-now-btn">PLACE ORDER NOW</button>
                <!-- <button type="submit" name="clear" class="buy-now-btn">Clear Cart</button> -->
            </form>
        <?php } else { ?>
            <div class="empty">
            <p>Your cart is empty.</p>
            <a href="home.php"><i class='bx bx-log-out' ></i> Go to home</a>
            </div>
            
            
            
        <?php } ?>
    </div>
</main>

<script>
function updateQuantity(cartId, action) {
    const quantityInput = document.getElementById(`quantity-${cartId}`);
    let currentQuantity = parseInt(quantityInput.value);

    if (action === 'increment') {
        currentQuantity += 1;
    } else if (action === 'decrement' && currentQuantity > 1) {
        currentQuantity -= 1;
    }

    quantityInput.value = currentQuantity;

    // Send the updated quantity to the server via AJAX
    fetch('update_cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `cart_id=${cartId}&quantity=${currentQuantity}`
    })
    .then(response => response.text())
    .then(message => {
        console.log(message); // Debugging purposes
        location.reload();
    })
    .catch(error => {
        console.error("Error:", error);
    });
}
</script>


</body>
</html>

