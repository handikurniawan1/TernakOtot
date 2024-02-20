<?php
session_start();

require_once ('../php/CreateDb.php');
require_once ('../php/component.php');

$database = new CreateDb("Gymdb", "Gymtb");

$data = $database->getData();

$gymId = isset($_GET['gym_id']) ? $_GET['gym_id'] : null;

if (isset($_POST['add'])) {
    if (!isset($_SESSION['user'])) {
        // Jika tidak ada sesi pengguna terdeteksi, arahkan ke halaman login
        header("Location: login.php");
        exit(); // Berhenti menjalankan skrip setelah mengarahkan pengguna
    }

    if (isset($_SESSION['cart'])) {
        $item_array_id = array_column($_SESSION['cart'], "gym_id");
        if (in_array($_POST['gym_id'], $item_array_id)) {
            echo "<script>alert('Product is already added in the cart..!')</script>";
        } else {
            $count = count($_SESSION['cart']);
            $item_array = array('gym_id' => $_POST['gym_id']);
            $_SESSION['cart'][$count] = $item_array;
            $id = $_POST['gym_id'];
            $plan = $_POST['selected_plan'];
            $quan = $_POST['selected_quantity'];
            $total = $_POST['price'];
            if ($plan === "1") {
                $harga = $total * $quan;
            } else if ($plan === "3") {
                $harga = $total * $quan * 3 * 0.85;
            } else if ($plan === "6") {
                $harga = $total * $quan * 6 * 0.75;
            } else if ($plan === "12") {
                $harga = $total * $quan * 12 * 0.65;
            }
            $result = $database->UpDataById($id, $plan, $quan, $harga);
            echo "<script>alert('Add Product Success!')</script>";
        }
    } else {
        $item_array = array(
            'gym_id' => $_POST['gym_id']
        );
        $_SESSION['cart'][0] = $item_array;
        $id = $_POST['gym_id'];
        $plan = $_POST['selected_plan'];
        $quan = $_POST['selected_quantity'];
        $total = $_POST['price'];
        $harga = 0;
        if ($plan === "1") {
            $harga = $total * $quan;
        } else if ($plan === "3") {
            $harga = $total * $quan * 3 * 0.85;
        } else if ($plan === "6") {
            $harga = $total * $quan * 6 * 0.75;
        } else if ($plan === "12") {
            $harga = $total * $quan * 12 * 0.65;
        }
        $result = $database->UpDataById($id, $plan, $quan, $harga);
        echo "<script>alert('Add Product Success!')</script>";
    }
}

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
    <link rel="stylesheet" href="../CSS/detailproduct.css">
</head>

<body>
    <section id="header">
        <a href="#"><img src="../Image/Logo.png" class="logo" alt=""></a>
        
        <div>
            <ul id="navbar">
                <li><a href="Home.php">Home</a></li>
                <li><a class="active" href="shop.php">Shop</a></li>
                <li><a href="blog.php">Blog</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php" >Contact</a></li>
                <li id="lg-bag"><a href="Cart.php "><i class="fa-solid fa-bag-shopping"></i></a></li>
                <li id="lg-profile"><a class="fas fa-user-alt" onclick="togglemenu()"></a></li>
                <a href="#" id="close"><i class="fa-solid fa-xmark"></i></a>
            </ul>
            <div class="sub-menu-wrap" id="subMenu">
                <div class="sub-menu">
                    <div class="user-info">
                        <img src="../Image/profil.png">
                        <h3>Nama User</h3>
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
        
    </section>
    <section>
       <!--tambahkan disini product gymnya yang ada diatas--> 
       <?php
        if ($data && !empty($data)) {
            foreach ($data as $row) {
                $gymname = $row['gym_name'];
                $gymtag = $row['gym_tag'];
                $gymday = $row['gym_day'];
                $gymhour = $row['gym_hour'];
                $gymprice = $row['gym_price'];
                $gymimg = $row['gym_image'];
                $gymloc = $row['gym_location'];
                $gymdesc = $row['gym_desc'];
                $gymid = $row['id'];

                if ($gymid == $gymId) {
                    // Gunakan data yang diperoleh untuk menampilkan komponen HTML
                    detailproduk($gymimg, $gymname, $gymprice, $gymtag, $gymday, $gymhour, $gymloc, $gymdesc, $gymid);
                    break;
                }
            }
        } else {
            // Penanganan jika data tidak ditemukan
        }
        ?>
    </section>
    <br>
    <br>
    <br>
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

        // Ambil elemen tombol minus, tombol plus, dan elemen nilai jumlah
        var minusButton = document.querySelector('.quantity-button.minus');
        var plusButton = document.querySelector('.quantity-button.plus');
        var quantityValue = document.getElementById('quantity-value');

        // Tambahkan event listener untuk tombol minus
        minusButton.addEventListener('click', function() {
        var currentValue = parseInt(quantityValue.textContent);
        if (currentValue > 1) {
            quantityValue.textContent = currentValue - 1;
        }
        });

        // Tambahkan event listener untuk tombol plus
        plusButton.addEventListener('click', function() {
        var currentValue = parseInt(quantityValue.textContent);
        if (currentValue < 9999) {
            quantityValue.textContent = currentValue + 1;
        }
        });

        // Mengambil semua tombol pilihan bulan
        const monthButtons = document.querySelectorAll('.btn-group button');

        // Memberikan event listener pada setiap tombol pilihan bulan
        monthButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Menghapus kelas 'active' dari semua tombol pilihan bulan
            monthButtons.forEach(btn => btn.classList.remove('active'));
            // Menambahkan kelas 'active' pada tombol yang ditekan
            this.classList.add('active');
        });
        });
    </script>
    <script>
        // Fungsi untuk mengatur nilai-nilai yang akan dikirim saat formulir di-submit
        function setFormValues() {
          // Mendapatkan nilai dari elemen-elemen yang ingin dikirim
          var selectedQuantity = document.getElementById('quantity-value').innerText;
          var selectedPlan = document.querySelector('.btn-group .active').value;
        
          // Mengatur nilai-nilai ke atribut value pada elemen input tersembunyi
          document.getElementById('selected-quantity').value = selectedQuantity;
          document.getElementById('selected-plan').value = selectedPlan;
        }
    
        // Event listener pada saat formulir di-submit
        document.querySelector('form').addEventListener('submit', function (event) {
          setFormValues(); // Memanggil fungsi untuk mengatur nilai-nilai yang akan dikirim
          // event.preventDefault(); // Jika diperlukan untuk mencegah submit formulir secara default
        });
    
        function confirmLogout() {
            return confirm("Are you sure you want to log out?");
        }
    </script>
</body>
</html>