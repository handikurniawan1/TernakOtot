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
                <li><a class="active" href="blog.php">Blog</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php" >Contact</a></li>
                <li id="lg-bag"><a href="cart.php "><i class="fa-solid fa-bag-shopping"></i></a></li>
                <?php if ($loggedIn) { ?>
                <!-- Tombol lg-profile hanya ditampilkan jika ada sesi pengguna aktif -->
                <li id="lg-profile"><a class="fas fa-user-alt " onclick="togglemenu()"></a></li>
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
            <h2>READ MORE</h2>
            <p>Read all about healty life</p>
        </div>
        <div class="blog-header"></div>
    </section>

    <section id="blog">
        <div class="blog-box">
            <div class="blog-img">
                <img src="../Image/blog/b1.jpg">
            </div>
            <div class="blog-details">
                <h4>Manfaat Memakan Makanan Sehat</h4>
                <p style="text-align: justify;">Makanan sehat dibutuhkan tubuh untuk menjaga fungsi organ 
                    dan memastikan kinerjanya. Secara umum, jenis makanan yang tergolong 
                    dalam kelompok makanan sehat mengandung berbagai nutrisi. Syarat makanan 
                    yang sehat (4 sehat 5 sempurna), yaitu bersih, memiliki...</p>
                <a href="https://www.halodoc.com/kesehatan/makanan-sehat">Continue reading</a>
            </div>
            <h1>01/01</h1>
        </div>

        <div class="blog-box">
            <div class="blog-img">
                <img src="../Image/blog/b2.jpg">
            </div>
            <div class="blog-details">
                <h4>Manfaat Rutin Berolahraga</h4>
                <p style="text-align: justify;">Dengan rutin berolahraga, banyak manfaat olahraga yang bisa langsung Anda dapatkan. 
                    Selain itu, banyak juga manfaat olahraga yang bisa Anda dapatkan di kemudian hari 
                    dalam jangka panjang. Olahraga merupakan suatu gerakan olah tubuh yang memberikan...</p>
                <a href="https://rsudkajen.id/beragam-manfaat-olahraga/">Continue reading</a>
            </div>
            <h1>01/02</h1>
        </div>

        <div class="blog-box">
            <div class="blog-img">
                <img src="../Image/blog/b3.jpg">
            </div>
            <div class="blog-details">
                <h4>10 Jenis Olahraga Yang Dapat Dilakukan Dirumah</h4>
                <p style="text-align: justify;">Olahraga secara teratur memang sangat penting untuk menjaga 
                    kesehatan tubuh. Meski jadwal kegiatan Anda super padat, tidak ada alasan bagi Anda untuk 
                    tidak berolahraga. Rumah pun bisa menjadi tempat yang asyik berolahraga bersama anggota 
                    keluarga yang lain. Berikut adalah 10 olahraga yang dapat Anda lakukan di rumah tanpa 
                    bantuan alat...</p>
                <a href="https://summareconbekasi.com/whatson/detail/10-jenis-olahraga-yang-dapat-dilakukan-dirumah">Continue reading</a>
            </div>
            <h1>01/03</h1>
        </div>

        <div class="blog-box">
            <div class="blog-img">
                <img src="../Image/blog/b4.jpg">
            </div>
            <div class="blog-details">
                <h4>Hidup Sehat</h4>
                <p style="text-align: justify;">Semua orang pasti ingin selalu sehat dan terhindar dari berbagai penyakit. Sebab, 
                    dengan tubuh dan pikiran yang selalu sehat, kesejahteraan dan kualitas hidup tentunya juga dapat meningkat.
                     Menjaga kesehatan pun nyatanya tidak sesulit yang dibayangkan, salah satunya adalah...</p>
                <a href="https://www.halodoc.com/kesehatan/hidup-sehat">Continue reading</a>
            </div>
            <h1>01/04</h1>
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