<?php
session_start();
include 'config.php';
// $email=$_SESSION['email'];

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $sql = "SELECT * FROM user WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $firstname = $row['FirstName'];
        $userid = $row['user_id'];
    // $row = $result->fetch_assoc();
    // $firstname = $row['FirstName'];
    // $userid=$row['user_id'];
    /*echo "Welcome, " . $firstname;*/
} else {
    echo "";
}
}else{
    echo "You are not logged in";
}
// Pagination logic
$limit = 2; // Number of products per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page number
$offset = ($page - 1) * $limit; // Calculate offset

// Get total number of products
$totalResult = mysqli_query($conn, "SELECT COUNT(*) as total FROM products");
$totalRow = mysqli_fetch_assoc($totalResult);
$totalProducts = $totalRow['total'];
$totalPages = ceil($totalProducts / $limit); // Total number of pages

// Fetch products for the current page
$res = mysqli_query($conn, "SELECT * FROM products LIMIT $limit OFFSET $offset");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link rel="stylesheet" href="detail.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->

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
                <a href="#"><i class="fa-solid fa-book"></i>My Orders</a>
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

<div class="home" id="home">
    <div class="container" id="container">

    <?php
    // session_start();
    // include 'config.php';
        $conn = new mysqli("localhost", "root", "", "deno");
        $product_id = $_GET['product_id'];

$email=$_SESSION['email'];
$pro = "SELECT product_id FROM products";
$res2 = mysqli_query($conn, $pro);

        
        $query = "
            SELECT p.*, s.size_name 
            FROM products p
            LEFT JOIN product_sizes ps ON p.product_id = ps.product_id
            LEFT JOIN sizes s ON ps.size_id = s.size_id
            WHERE p.product_id = $product_id
        ";
        
        $result = $conn->query($query);
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            ?>
            
            <div class="product-details">
                <div class="product-image">
                    <img src="admin/image/<?php echo $row['product_img_main']; ?>" alt="">
                    <div class="product-image-slider">
                    <img src="admin/image/<?php echo $row['img_url2']; ?>" alt="">
                    <img src="admin/image/<?php echo $row['img_url3']; ?>" alt="">
                    <img src="admin/image/<?php echo $row['img_url3']; ?>" alt="">
                    <img src="admin/image/<?php echo $row['img_url4']; ?>" alt="">
        </div>

                    <!-- Additional images -->
                </div>
                <div class="product-info">
    <div class="product-title"><?php echo $row['product_name']; ?></div>
    <div class="product-price"><span class="original-price">Rs. <?php echo $row['pre_price']; ?></span><span class="price">Rs. <?php echo $row['price']; ?></span>
    <p>Tax Included*</p>
</div>
    
    <form method="post" action="checkout.php">
        <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
        <input type="hidden" name="user_id" value="<?php echo $userid; ?>">
        <input type="number" name="quantity" value="1" min="1" required>
        <div class="buttons">
            <button class="add-to-cart" data-id="<?php echo $row['product_id']; ?>">Add to cart</button>
            <button data-id="<?php echo $row['product_id']; ?>" class="buy-now" >Buy it now</button>
        </div>
    </form>
    <div class="product-description"><?php echo $row['description']; ?></div>
</div>  
            </div>
            <?php
        } else {
            echo "<p>Product not found!</p>";
        }
        ?>
            </div>
    </div>



    <script>
    document.querySelectorAll('.add-to-cart').forEach((button) => {
    button.addEventListener('click', function (event) {
        event.preventDefault(); // Prevent default link behavior
        const productId = this.getAttribute('data-id');

        fetch('add_to_cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `product_id=${productId}`,
        })
            .then((response) => response.text())
            .then((message) => {
                alert(message); // Show the message from the server
            })
            .catch((error) => {
                console.error('Error:', error);
            });
    });
});

document.querySelectorAll('.buy-now').forEach((button) => {
    button.addEventListener('click', function (event) {
        event.preventDefault(); // Prevent default link behavior
        const productId = this.getAttribute('data-id');

        fetch('add_to_cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `product_id=${productId}`,
        })
            .then((response) => response.text())
            .then((message) => {
                alert(message); // Show the message from the server
                // Redirect to cart page
                window.location.href = 'cart.php';
            })
            .catch((error) => {
                console.error('Error:', error);
            });
    });
});


</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function addToCart(productId) {
        $.ajax({
            type: "POST",
            url: "add_to_cart.php",
            data: { product_id: productId },
            dataType: "json",
            success: function(response) {
                if (response.cart_count !== undefined) {
                    // Update the cart count displayed on the page
                    $('#cart-count').text(response.cart_count);
                } else {
                    console.error(response.error);
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error: " + status + error);
            }
        });
    }
</script>
</body>
</html>