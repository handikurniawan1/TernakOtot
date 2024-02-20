<?php
session_start();
$loggedIn = isset($_SESSION['user']);

if (isset($_POST['logout'])) {
    unset($_SESSION['user']);
    session_destroy();
    echo "<script>alert('You have been logged out!')</script>";
    echo "<script>window.location = 'home.php'</script>";
}
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
                <li><a href="Home.php">Home</a></li>
                <li><a href="shop.php">Shop</a></li>
                <li><a href="blog.php">Blog</a></li>
                <li><a href="about.php">About</a></li>
                <li><a class="active" href="contact.php" >Contact</a></li>
                <li id="lg-bag"><a href="cart.php"><i class="fa-solid fa-bag-shopping"></i></a></li>
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
            <a href="cart.php"><i class="fa-solid fa-bag-shopping"></i></a>
            <a href="profile.php"><i class="fas fa-user-alt"></i></a>
            <i id="bar" class="fas fa-outdent"></i>
        </div>


        
    </section>

    <section class="">
        <div class="text-container">
            <h2>CONTACT US</h2>
            <p>Keep In Touch</p>
        </div>
        <div class="contact-header"></div>
    </section>

    <section id="contact-details" class="section-p1">
        <div class="details">
            <span>GET IN TOUCH</span>
            <h2>Visit our office locations or contact us today</h2>
            <h3>Head Office</h3>
            <div>
                <li>
                    <i class="fas fa-map"></i>
                    <p>Alam Sutera, Jl. Jalur Sutera Bar. No.kav.7-9, Kota Tangerang, Banten 15143</p>
                </li>
                <li>
                    <i class="far fa-envelope"></i>
                    <p>s31200044@gmail.com</p>
                </li>
                <li>
                    <i class="fas fa-phone-alt"></i>
                    <p>(021) 80821428</p>
                </li>
                <li>
                    <i class="far fa-clock"></i>
                    <p>Monday to Friday: 07.30 - 17.00</p>
                </li>
            </div>
        </div>
        <div class="map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15865.139091607498!2d106.6573986!3d-6.2261341!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69fbdee841bfc3%3A0x873ac50f7969399c!2sUniversitas%20Bunda%20Mulia%20Kampus%20Serpong!5e0!3m2!1sid!2sid!4v1684835301405!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </section>


    <section id="form-details">
        <form action="">
            <span>LEAVE A MESSAGE</span>
            <h2>We love to hear from you</h2>
            <input type="text" placeholder="Your name">
            <input type="text" placeholder="Email">
            <input type="text" placeholder="Subject">
            <textarea name="" id="" cols="30" rows="10" placeholder="Your Message"></textarea>
            <button class="normal">Submit</button>
        </form>
        <div class="people">
            <div>
                <img src="../Image/contact/p3-modified.png">
                <p><span>Handi Kurniawan</span>CFO & Founder Ternak Otot<br>Phone: +62123456789<br>
                Email: s31200044@student.ubm.ac.id</p>
            </div>
            <div>
                <img src="../Image/contact/p4-modified.png">
                <p><span>Davin</span>CTO & Founder Ternak Otot<br>Phone: +62123456789<br>
                Email: s31200046@student.ubm.ac.id</p>
            </div>
            <div>
                <img src="../Image/contact/p2-modified.png">
                <p><span>Oliver Kenzo</span>CEO & Founder Ternak Otot<br>Phone: +62123456789<br>
                Email: s31200101@student.ubm.ac.id</p>
            </div>
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
    </script>

</body>
</html>