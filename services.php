<?php
session_start();
include 'config.php';
$email=$_SESSION['email'];

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
// Pagination logic
$limit = 20; // Number of products per page
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
    <title>Vishwanath Dagdoba Gadam</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="home.css">
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
    
    <section class="services" id="services">
        <div class="heading">
            <!-- <span>Best Services</span> -->
            <h1>Explore Out Top Deals <br> From Top Rated Dealers</h1>
        </div>
        
        <div class="services-container">
            <?php
            // $res=mysqli_query($conn,"select * from products");
            while($rs=mysqli_fetch_array($res)){
                ?>
            
            <div href="" class="box">
                <div href="productdetail.php?product_id=<?php echo $rs['product_id'];?>" class="box-img">
                    <img src="admin/image/<?php echo $rs['product_img_main']; ?>" alt="">
                </div>
                <h3><?php echo $rs['product_name']; ?></h3>
                <h4 id="pre_price">₹ <?php echo $rs['pre_price']; ?></h4>
                <h2>&#8377; <?php echo $rs['price']; ?></h2>
                <a href="productdetail.php?product_id=<?php echo $rs['product_id'];?>" class="btn">Buy Now</a>
            </div>
            <?php
            }
            ?>
            </div>

            <div class="pagination">
    <?php if ($page > 1): ?>
        <a href="services.php?page=<?php echo $page - 1; ?>" class="btn"><i class='bx bx-left-arrow-alt' ></i></a>
        <?php else: ?>
            <a href="#" class="btn disabled"><i class='bx bx-left-arrow-alt' ></i></a>
    <?php endif; ?>
    
    <div class="page-numbers">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="services.php?page=<?php echo $i; ?>" class="<?php echo ($i === $page) ? 'active' : ''; ?>">
                <?php echo $i; ?>
            </a>
        <?php endfor; ?>
    </div>

    <?php if ($page < $totalPages): ?>
        <a href="services.php?page=<?php echo $page + 1; ?>" class="btn"><i class='bx bx-right-arrow-alt' ></i></a>
        <?php else: ?>
            <a href="#" class="btn disabled"><i class='bx bx-right-arrow-alt' ></i></a>
    <?php endif; ?>
</div>
            
    </section>

<script>
document.querySelectorAll('.add-to-cart').forEach((button) => {
    button.addEventListener('click', function (event) {
        event.preventDefault(); // Prevent default link behavior
        const productId = this.getAttribute('data-id');

        // Check if user is logged in
        const isLoggedIn = <?php echo json_encode(isset($_SESSION['email'])); ?>; // PHP check

        if (!isLoggedIn) {
            alert('You must be logged in to add items to the cart.');
            window.location.href = 'login.php'; // Redirect to login page
            return;
        }

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


</script>

    <script src="main.js"></script>
</body>
</html>