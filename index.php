<?php
include ('config.php');
$sql = "SELECT product_id, product_name, product_img_main, pre_price, price FROM products ORDER BY product_id DESC LIMIT 5";
$result = mysqli_query($conn, $sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vishwanath Dagdoba Gadam</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>
<body>
    <header class="header">
    <a href="index.php">VISHWANATH DAGDOBA GADAM</a>
    <div class="bx bx-menu" id="menu-icon"></div>
    <i class="bx bx-x" style="display: none;"></i>
    <nav id="navbar" class="navbar">
        <a href="#home" class="active">Home</a>
        <a href="#about">About Us</a>
        <a href="#latest">Shop</a>
        <div class="tech-dropdown">
            <a href="#" id="dropdown-link">Categories</a>
            <div class="tech-content" id="tech-content">
                <a href="login.php">Women</a>
                <a href="login.php">Men</a>
                <a href="login.php">Kids</a>
                <a href="login.php">Jewellery</a>
            </div>
        </div>
        
        
        <a href="login.php"><span>Sign In</span></a>
    </nav>

        <!-- <div class="btn-box">
            <a href="#contact" class="btn">Book Demo</a>
        </div> -->
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
<!-- dropdown for technology -->
<script>const dropdownLink = document.getElementById("dropdown-link");
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
    
    const quickLinks = techContent.getElementsByTagName("a");
    
    for (let i = 0; i < quickLinks.length; i++) {
        quickLinks[i].addEventListener("mouseover", () => {
            clearTimeout(timeId);
        });
    
        quickLinks[i].addEventListener("mouseout", (event) => {
            if (!event.toElement ||!techContent.contains(event.toElement)) {
                timeId = setTimeout(() => {
                    techContent.style.display = "none";
                }, 300);
            }
        });
    }</script>

<!-- Dropdwon script -->
<script>const projectsLink = document.getElementById("projects-link");
const projectsDropdown = document.getElementById("projects-dropdown");
let timeoutId;

projectsLink.addEventListener("mouseover", () => {
    clearTimeout(timeoutId);
    projectsDropdown.style.display = "block";

});

projectsLink.addEventListener("mouseout", () => {
    timeoutId = setTimeout(() => {
        projectsDropdown.style.display = "none";
        
    }, 500);
});

projectsDropdown.addEventListener("mouseover", () => {
    clearTimeout(timeoutId);
});

projectsDropdown.addEventListener("mouseout", (event) => {
    if (!event.toElement ||!projectsDropdown.contains(event.toElement)) {
        timeoutId = setTimeout(() => {
            projectsDropdown.style.display = "none";
        }, 500);
    }
});

const dropdownLinks = projectsDropdown.getElementsByTagName("a");

for (let i = 0; i < dropdownLinks.length; i++) {
    dropdownLinks[i].addEventListener("mouseover", () => {
        clearTimeout(timeoutId);
    });

    dropdownLinks[i].addEventListener("mouseout", (event) => {
        if (!event.toElement ||!projectsDropdown.contains(event.toElement)) {
            timeoutId = setTimeout(() => {
                projectsDropdown.style.display = "none";
            }, 500);
        }
    });
}</script>
<!-- HOME SECTION -->
    <section class="home" id="home">
    <div class="home-content">
    <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
    <div class="carousel-inner">
    <div class="carousel-item active">
        <img src="image/Slide1.png" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
        <img src="image/Slide2.png" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
        <img src="image/Slide3.png" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
        <img src="image/Slide4.png" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
        <img src="image/Slide5.png" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
        <img src="image/Slide6.png" class="d-block w-100" alt="...">
    </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
    </button>
</div>
    </section>

<!-- ABOUT SECTION -->

    <section class="latest" id="latest">
        <div class="heading">
            <h1>Latest Products</h1>
        </div>
        <div class="services-container">
            <?php while($rs = mysqli_fetch_assoc($result)) { ?>
            <div class="box">
                <a href="login.php">
                <div class="box-img">
                    <img src="admin/image/<?php echo $rs['product_img_main']; ?>" alt="">
                </div>
                <p>Sale</p>
                <h3><?php echo $rs['product_name']; ?></h3>
                <h4 id="pre_price">₹ <?php echo $rs['pre_price']; ?></h4>
                <h2>₹ <?php echo $rs['price']; ?></h2>
                <!-- <a href="login.php" class="btn">Buy Now </a> -->
            </div>
            </a>
            <?php
            }
            ?>
    </section>
    
    <section class="about" id="about">
    <div class="heading">
            <h1>About Us</h1>
        </div>
        <div class="about-img">
            <img src="image/shop1.jpg" alt="">
            <span class="circle-spin"></span>
        </div>
        <div class="about-content">
            <p>Welcome to <span>VISHWANATH DAGDOBA GADAM</span>, your one-stop destination for the latest Women’s and Kids’ Wear! Our journey began with a vision to bring you a wide variety of fashionable and functional apparel that caters to every taste and occasion. Over the years, we’ve grown and evolved, learning exactly how to blend high quality, comfort, and affordability in every product we offer.

                <br><br>Our collection is carefully curated to ensure that it reflects the latest trends while maintaining timeless elegance. Whether it’s chic outfits for women or adorable and durable clothing for kids, we strive to provide something special for everyone in the family.
        </div>
    </section>
    <!--end of about section-->

    <section class="reviews" id="reviews">
        <div class="heading">
            <h1>What Our Customer Says</h1>
        </div>
        <div id="testimonial-section">
    <!-- Testimonials will be dynamically inserted here -->
</div>
    </section>

    <section>
        <form method="post">
        <section class="newsletter">
            <!-- <h2>Subscribe To Newsletter</h2> -->
            <div class="box">
                <input class="txtbox" type="text" name="newsletter" placeholder="Enter your Email...">
                <button type="submit" name="subscribe" class="btn">Subscribe</button>
                
            </div>
</form>
        </section>
        <section id="contact">
    <footer>
        <div class="fcontainer">
            <div class="sec">
            <h2>About Us</h2>
            <p>"At VISHWANATH DAGDOBA GADAM, customer satisfaction is at the heart of everything we do. From the moment you explore our collection to the time your purchase reaches your doorstep, we are dedicated to offering an exceptional shopping experience. We value your trust and are committed to delivering products that exceed your expectations, all while keeping them budget-friendly."</p>
            <ul class="sci">
                <!-- <li><a href=""><i class='bx bxl-facebook-circle' ></i></a></li> -->
                <li><a href=""><i class='bx bxl-instagram' ></i></a></li>
                <li><a href="https://www.youtube.com/@greencloudisoft2399"><i class='bx bxl-youtube'></i></a></li>
                <!-- <li><a href=""><i class='bx bxl-linkedin-square' ></i></a></li> -->
            </ul>
        </div>
        <div class="sec quickLinks">
            <h2>Get In Touch</h2>
            <ul>
                <li><a >FAQs</a></li>
                <li><a >Partner With Us</a></li>
                <li><a >Support</a></li>
                <li><a >Terms & Condition</a></li>
            </ul>
        </div>
        <div class="sec contact">
            <h2>Contact Us</h2>
            <ul class="info">
                <li>
                    <span><i class='bx bxs-map' aria-hidden="true"></i></span>
                    <span>E/72, GIDC Electronic Estate,<br>Sector 26,Gandhinagar,
                        Gujarat 382026</span>
                </li>
                <li>
                    <span><i class='bx bxs-phone' aria-hidden="true" ></i></span>
                    <p><a href="tel:+91-8793696921">+91-87936 96921</a></p>
                    
                </li>
                <li>
                    <span><i class='bx bxl-gmail' aria-hidden="true" ></i></span>
                    <p><a href="mailto:abhishekgadam2@gmail.com">abhishekgadam2@gmail.com</a></p>
                </li>
            </ul>
        </div>
    </div>
    
    </footer>

<!-- <div class="places">
    <p>Gandhinagar Ahmedabad Surat Baroda Ajmer Jaipur Pune Mumbai Anand</p>
</div> -->
<div class="copyright">
    <p>Copyright © 2024 VISHWANATH DAGDOBA GADAM. All rights reserved.</p>
</div>
<!-- </section>
        <div class="Copyright">
            <p>&#169; Himanshu Kumar Sinha All Rights Reserved</p>
            <div class="social">
                <a href="https://www.facebook.com/profile.php?id=100017126389124"><i class='bx bxl-facebook'></i></a>
                <a href="#"><i class='bx bxl-twitter'></i></a>
                <a href="https://www.instagram.com/himanshu_9142/"><i class='bx bxl-instagram'></i></a>
            </div>
        </div>
    </section> -->
    <?php
    if(isset($_POST['subscribe'])){
        $newsletter=$_POST['newsletter'];
        $res1=mysqli_query($conn,"insert into newsletter (email) values ('$newsletter')");
        
    
        if($res1){
            echo"<script>
            alert('Subscribed successfully');
            window.location.href='index.php';
            </script>";
        }
        else{
            echo"<script>
            alert('Enter Valid Email');
            window.location.href='index.php';
            </script>";
        }
    }
    
    ?>
    <script src="https://unpkg.com/typed.js@2.1.0/dist/typed.umd.js">//autotype</script>
<script>
        var typed= new Typed(".auto-type",{
            strings:["Where convenience meets innovation.","Make your home work for you with automation","Simplify your life with smart home technology."],
                typeSpeed:40,
                backSpeed:30,
                Delay:500,
                loop:true,
                cursorChar:""
        });
        //prevent right click
        document.addEventListener("contextmenu", function(event){
    event.preventDefault();
}, false);
    </script>
    <script>
fetch('fetch_testimonials.php')
    .then(response => response.json())
    .then(data => {
        const testimonialSection = document.getElementById('testimonial-section');
        data.forEach(testimonial => {
            const card = document.createElement('div');
            card.classList.add('testimonial-card');

            card.innerHTML = `
                <img src="admin/image/${testimonial.img_user}" alt="">
                <h3>${testimonial.name}</h3>
                <p>${testimonial.comments}</p>
            `;
            testimonialSection.appendChild(card);
        });
    })
    .catch(error => console.error('Error fetching testimonials:', error));
</script>

    <script src="main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>