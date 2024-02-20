<?php

session_start();

require_once ('../php/CreateDb.php');
require_once ('../php/component.php');


// create instance of Createdb class
$database = new CreateDb("Gymdb", "Gymtb");
if (isset($_POST['add'])){
    if (!isset($_SESSION['user'])) {
        // Jika tidak ada sesi pengguna terdeteksi, arahkan ke halaman login
        echo "<script>alert('Anda harus login terlebih dahulu')</script>";
        echo "<script>window.location = 'login.php'</script>";
        exit; // Hentikan eksekusi script setelah mengalihkan
    }
    if(isset($_SESSION['cart'])){
        $item_array_id = array_column($_SESSION['cart'], "gym_id");
        if(in_array($_POST['gym_id'], $item_array_id)){
            echo "<script>alert('Product is already added in the cart!')</script>";
        }
        else{
            $count = count($_SESSION['cart']);
            $item_array = array('gym_id' => $_POST['gym_id']);
            $_SESSION['cart'][$count] = $item_array;
            $id=$_POST['gym_id'];
            $total=$_POST['price'];
            $result = $database->UpDataId($id,$total);
            echo "<script>alert('Add Product Success!')</script>";
        }
    }
    else{
        $item_array = array(
                'gym_id' => $_POST['gym_id']
        );
        // Create new session variable
        $_SESSION['cart'][0] = $item_array;
            $id=$_POST['gym_id'];
            $total=$_POST['price'];
            $result = $database->UpDataId($id,$total);
            echo "<script>alert('Add Product Success!')</script>";
    }
}

if (isset($_POST['logout'])) {
    unset($_SESSION['user']);
    session_destroy();
    echo "<script>alert('You have been logged out!')</script>";
    echo "<script>window.location = 'home.php'</script>";
}

$loggedIn = isset($_SESSION['user']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ternakk Otot Website</title>
    <script src="https://kit.fontawesome.com/f812210b6b.js"></script>    
    <link rel="stylesheet" href="../CSS/style.css">
</head>

<body>
    <section id="header">
        <a href="#"><img src="../Image/Logo.png" class="logo" alt=""></a>
        <div>
            <ul id="navbar">
                <li><a class="active" href="Home.php">Home</a></li>
                <li><a href="shop.php">Shop</a></li>
                <li><a href="blog.php">Blog</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php" >Contact</a></li>
                <li id="lg-bag"><a href="Cart.php "><i class="fa-solid fa-bag-shopping"></i></a></li>
                <?php if ($loggedIn) { ?>
                <!-- Tombol lg-profile hanya ditampilkan jika ada sesi pengguna aktif -->
                <li id="lg-profile"><a class="fas fa-user-alt" onclick="togglemenu()"></a></li>
                <?php } ?>
                <a href="#" id="close"><i class="fa-solid fa-xmark"></i></a>
            </ul>
            <div class="sub-menu-wrap" id="subMenu">
                <div class="sub-menu">
                    <div class="user-info">
                        <img src="../Image/profil.png">
                        <h3><?php echo $_SESSION['user']?></h3>
                    </div>
                    <hr>
                    <a href="profil.php" class="sub-menu-link">
                        <img src="../Image/profil.png">
                        <p>Profil</p>
                        <span>></span>
                    </a>
                    <a href="history.php" class="sub-menu-link">
                        <img src="../Image/history.png">
                        <p>Transaction</p>
                        <span>></span>
                    </a>
                    <form id="logoutForm" action="" method="post" onsubmit="return confirmLogout()">
                        <button id="logout"type="submit" name="logout" class="sub-menu-link">
                            <img src="../Image/logout.png">
                            <p>Log Out</p>
                            <span>></span>
                        </button>
                    </form>

                </div>
            </div>
        </div>
        <div id="mobile">
            <a href="Cart.php "><i class="fa-solid fa-bag-shopping"></i></a>
            <i id="bar" class="fas fa-outdent"></i>
        </div>
    </section>

    <section id="hero">
        <h4>Special Price</h4>
        <h2>Super value deals</h2>
        <h1>All gym in your area</h1>
        <p>Save more with coupons up to <span>40% OFF</span></p>
        <button onclick="scrollToProducts()">Join Now</button>
    </section>

    <section id="feature" class="section-p1">
        <div class="fe-box">
            <img src="../Image/features/f1.png" alt="">
            <h6>Full Online</h6>
        </div>

        <div class="fe-box">
            <img src="../Image/features/f2.png" alt="">
            <h6>Time Efficient</h6>
        </div>
        <div class="fe-box">
            <img src="../Image/features/f3.png" alt="">
            <h6>Save Money</h6>
        </div>
        <div class="fe-box">
            <img src="../Image/features/f4.png" alt="">
            <h6>Promotion</h6>
        </div>
        <div class="fe-box">
            <img src="../Image/features/f5.png" alt="">
            <h6>Happy Sell</h6>
        </div>
        <div class="fe-box">
            <img src="../Image/features/f6.png" alt="">
            <h6>24/7 Support</h6>
        </div>
    </section>

    <section id="gym" class="section-p1">
        <h2>Featured Gym</h2>
        <p>Premium Gym With Excellent Gear</p>
        <div class="pro-container">
        <?php
            $result = $database->getData();
            $row_count = 0; // Variabel penunjuk baris
            while ($row = mysqli_fetch_assoc($result)){
                if ($row_count < 8) { // Hanya menjalankan kode jika baris kurang dari 8
                    component($row['gym_name'], $row['gym_price'], $row['gym_image'], $row['gym_star'], $row['gym_cat'], $row['id']);
                    $row_count++;
                } 
            else {
                break; // Keluar dari perulangan setelah baris ke-8
            }
            }
        ?>

        </div>
    </section>

    <section id="banner" class="section-m1">
        <h4>Big Sale</h4>
        <h2>Up to <span>50% OFF</span> - All Gym</h2>
        <button class="normal">Explore More</button>
    </section>

    <section id="gym" class="section-p1">
        <h2>New Arrivals</h2>
        <p>Rev up your routine with fresh options at New Arrivals Gym</p>
        <div class="pro-container">
            <?php
                $result = $database->getData();
                $row_count = 8; // Variabel penunjuk baris
                while ($row = mysqli_fetch_assoc($result)){
                    if ($row_count < 16) { // Hanya menjalankan kode jika baris kurang dari 8
                        component($row['gym_name'], $row['gym_price'], $row['gym_image'], $row['gym_star'], $row['gym_cat'], $row['id']);
                        $row_count++;
                    } 
                else {
                    break; // Keluar dari perulangan setelah baris ke-8
                }
            }
        ?>
        </div>
    </section>

    <section id="sm-banner" class="section-p1">
        <div class="banner-box">
            <h4>crazy deals</h4>
            <h2>buy 1 get 1 free</h2>
            <span>The best gym in your arena is on sale</span>
            <button class="white">Learn More</button>
        </div>
        <div class="banner-box banner-box2">
            <h4>spring/summer</h4>
            <h2>upcomming season</h2>
            <span>build your body for the next season</span>
            <button class="white">Learn More</button>
        </div>
    </section>

    <section id="banner3" >
        <div class="banner-box">
            <h2>SEASONAL SALE</h2>
            <h3>Spring Collection -30% OFF</h3>
        </div>
        <div class="banner-box banner-box2">
            <h2>NEW GYM COLLECTION</h2>
            <h3>Spring 2023</h3>
        </div>
        <div class="banner-box banner-box3">
            <h2>TOP RATED GYM</h2>
            <h3>5 <span>★</span> Gym Only</h3>
        </div>
    </section>

    <section id="newsletter" class="section-p1 section-m1">
        <div class="newstext">
            <h4>Sign Up For Newsletters</h4>
            <p>Get E-mail updates about our latest shop and <span>spesial Offers.</span></p>
        </div>
        <div class="form">
            <input type="text" placeholder="Your email address">
            <button class="normal">Sign Up</button>
        </div>
    </section>

    <footer class="section-p1">
        <div class="col">
            <img class="logo" src="../Image/Logo.png" alt="">
            <h4>Contact</h4>
            <p><strong>Address:</strong> Alfa Tower, Jalan Jalur Sutera Barat Kav. 7-9 Alam Sutera, Tangerang</p>
            <p><strong>Phone:</strong> 021 80821428/ +6285311135852</p>
            <p><strong>Hours:</strong> 20:00 - 18:00, Mon - Sat</p>
            <div class="follow">
                <h4>Follow Us</h4>
                <div class="icon">
                    <i class="fab fa-facebook-f"></i>
                    <i class="fab fa-twitter"></i>
                    <i class="fab fa-instagram"></i>
                    <i class="fab fa-pinterest-p"></i>
                    <i class="fab fa-youtube"></i>
                </div>
            </div>
        </div>

        <div class="col">
            <h4>About</h4>
            <a href="#">About us</a> 
            <a href="#">Delivery Information</a> 
            <a href="#">Privacy Policy</a> 
            <a href="#">Terms & Conditions</a> 
            <a href="#">Contact us</a>         
        </div>

        <div class="col">
            <h4>My Account</h4>
            <a href="#">Sign in</a> 
            <a href="#">View Cart</a> 
            <a href="#">My Wishlist</a> 
            <a href="#">Track My Order</a> 
            <a href="#">Help</a>         
        </div>

        <div class="col install">
            <h4>Install App</h4>
            <p>Form App Store or Google Play Store</p>
            <div class="row">
                <img src="../Image/pay/app.jpg" alt="">
                <img src="../Image/pay/play.jpg" alt="">
            </div>
            <p>Secured Payment Gateways</p>
            <img src="../Image/pay/pay.png" alt="">
        </div>

        <div class="copyright">
            <p>© 2023 Ternak Otot. All Rights Reserved</p>
        </div>
    </footer>

    <script src="../JavaScript/script.js"></script>
    <script>
        let subMenu = document.getElementById("subMenu");

        function togglemenu(){
            subMenu.classList.toggle("open-wrap");
            var profileLink = document.querySelector("#lg-profile a");
            profileLink.classList.toggle("active");
        }
        function confirmLogout() {
            return confirm("Are you sure you want to log out?");
        }
        function scrollToProducts() {
        var productsSection = document.getElementById("gym");
        productsSection.scrollIntoView({ behavior: 'smooth' });
    }
    </script>
</body>
</html>