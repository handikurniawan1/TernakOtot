<?php
session_start();

require_once ('../php/CreateDb.php');
require_once ('../php/component.php');

$database = new CreateDb("Gymdb", "Gymtb");
$uniqueCode = mt_rand(1, 999);
if (!isset($_SESSION['user'])) {
    // Pengguna tidak login, alihkan ke halaman login atau tampilkan pesan kesalahan
    echo "<script>alert('Anda harus login terlebih dahulu')</script>";
    echo "<script>window.location = 'login.php'</script>";
    exit; // Hentikan eksekusi script setelah mengalihkan
}

if (isset($_GET['action']) && $_GET['action'] == 'remove' && isset($_GET['id'])) {
    foreach ($_SESSION['cart'] as $key => $value) {
        if ($value["gym_id"] == $_GET['id']) {
            unset($_SESSION['cart'][$key]);
            echo "<script>alert('Product has been Removed!')</script>";
            echo "<script>window.location = 'cart.php'</script>";
        }
    }
}

if (isset($_POST['clear'])) {
    unset($_SESSION['cart']);
    echo "<script>alert('Cart has been Cleared!')</script>";
    echo "<script>window.location = 'cart.php'</script>";
}

if (isset($_POST['logout'])) {
    unset($_SESSION['user']);
    session_destroy();
    echo "<script>alert('You have been logged out!')</script>";
    echo "<script>window.location = 'home.php'</script>";
}

function generateBarcode(){
    $barcode = "";
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $charactersLength = strlen($characters);

    for ($i = 0; $i < 20; $i++) {
        $barcode .= $characters[rand(0, $charactersLength - 1)];
    }

    return $barcode;
}
function generateCode(){
    $barcode = "";
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $numbers = '0123456789';
    $charactersLength = strlen($characters);
    $numbersLength = strlen($numbers);

    // Generate 3 random letters
    for ($i = 0; $i < 3; $i++) {
        $barcode .= $characters[rand(0, $charactersLength - 1)];
    }

    // Generate 3 random numbers
    for ($i = 0; $i < 3; $i++) {
        $barcode .= $numbers[rand(0, $numbersLength - 1)];
    }

    return $barcode;
}

if (isset($_POST['checkout'])) {
    $gymid = array_column($_SESSION['cart'], 'gym_id');
    $user = $_SESSION['user'];
    $date = date("Y-m-d");
    $kd = generateCode();

    foreach ($gymid as $id) {
        $result = $database->getDataById($id);
        $row = mysqli_fetch_assoc($result);
        
        $gym_name = $row['gym_name'];
        $gym_image = $row['gym_image'];
        $gym_price = $row['gym_price'];
        $stat = 'Unpaid';
        $qty = $row['qty'];
        $month = $row['month'];
        $harga = $row['total'];
        $barcode = generateBarcode();
        $start_at = date("Y-m-d");
        $total = $_POST['tot'];
        
        // Insert data transaksi ke tabel transaksi
        $query = "INSERT INTO transaksi (username, kd, barcode, gym_name, gym_image, gym_price, stat, start_at, gym_qty, gym_month, total) VALUES ('$user','$kd','$barcode','$gym_name', '$gym_image', '$gym_price',  '$stat', '$start_at','$qty','$month', '$harga')";
        if (mysqli_query($database->con, $query)) {
            $query = "INSERT INTO history (kd, username,stat,total) VALUES ('$kd','$user', '$stat', '$total')";
            mysqli_query($database->con, $query);
            unset($_SESSION['cart']);
        } else {
            echo "Error: " . mysqli_error($database->con);
        }
    }
    echo "<script>alert('Checkout successful!')</script>";
    echo "<script>window.location = 'payment.php?tot=" . $_POST['tot'] . "&code=" . $_POST['code'] . "'</script>";
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
    <script src="path/to/jquery.min.js"></script> 
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
                <li><a href="about .php">About</a></li>
                <li><a href="contact.php" >Contact</a></li>
                <li id="lg-bag"><a class="active"  href="Cart.php "><i class="fa-solid fa-bag-shopping"></i></a></li>
                <li id="lg-profile"><a class="fas fa-user-alt" onclick="togglemenu()"></a></li>
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
    
    <section id="cart" class="section-p1">
        <table width="100%">
            <thead>
                <tr>
                    <td>Remove</td>
                    <td>Image</td>
                    <td>Product</td>
                    <td>Price</td>
                    <td>Quantity</td>
                    <td>Month</td>
                    <td>Subtotal</td>
                </tr>
            </thead>
            <tbody>
            <?php
            $total = 0;
            if (isset($_SESSION['cart'])) {
                $gymid = array_column($_SESSION['cart'], 'gym_id');
                $result = $database->getData();
                while (($row = mysqli_fetch_assoc($result))) {
                    foreach ($gymid as $id) {
                        if ($row['id'] == $id) {
                            cartElement($row['gym_name'], $row['gym_price'], $row['gym_image'], $row['id'], $row['month'], $row['qty'], $row['total'],);
                            $total = $total + (int)$row['total'];
                        }
                    }
                }
            } 
            ?>
            </tbody>
        </table>
        <?php
        if (empty($_SESSION['cart'])) {
            echo "<h5>Cart is empty</h5>";
        }
        ?>
    </section>

    <section id="cart-add" class="section-p1">
        <div id="coupon">
            <h3>Apply Coupon</h3>
            <div class=kupon>
                <input type="text" placeholder="Enter Your Coupon">
                <button class="normal">Apply</button>
            </div>
        </div>
        <div id="subtotal">
            <h3>Cart Total</h3>
            <table>
                <?php if (!empty($_SESSION['cart'])) : ?>
                    <tr>
                        <td>Subtotal</td>
                        <td id="total">Rp <?php echo number_format($total, 0, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <td>Unique Code</td>
                        <td id="uniqueCode">Rp <?php echo $uniqueCode; ?></td>
                    </tr>
                    <tr>
                        <td><strong>Total</strong></td>
                        <td><strong id="lata">Rp <?php echo number_format($total + $uniqueCode, 0, ',', '.'); ?></strong></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div id="button-container">
                                <form action="" method="post" onsubmit="return confirmCheckout()">
                                    <button name="check" class="normal ck">Checkout</button>
                                </form>
                                <form action="" method="post" onsubmit="return confirmClearCart()">
                                    <button class="normal cl" name="clear">Clear Cart</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php else : ?>
                    <tr>
                        <td>Subtotal</td>
                        <td id="total">Rp 0</td>
                    </tr>
                    <tr>
                        <td>Unique Code</td>
                        <td id="uniqueCode">Rp 0</td>
                    </tr>
                    <tr>
                        <td><strong>Total</strong></td>
                        <td><strong id="lata">Rp 0</strong></td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
        <div id="myModal" class="modal">
            <div class="modal-content">
                <h3>MEMBERSHIP T&C</h3>
                <div class="isi" style="overflow: auto;">
                <p>Harap diperhatikan bahwa dengan melakukan pembelian membership, Anda setuju untuk mematuhi syarat dan ketentuan yang berlaku.</p>
                <p>Beberapa ketentuan yang perlu diperhatikan:</p>
                <ol>
                    <li>Pembelian membership bersifat final dan tidak dapat dibatalkan atau diganggu gugat.</li>
                    <li>Membership hanya berlaku untuk pemiliknya dan tidak dapat dipindahtangankan atau dijual kepada pihak lain.</li>
                    <li>Anda bertanggung jawab untuk menjaga kerahasiaan informasi login dan tidak mengizinkan orang lain untuk menggunakan akun membership Anda.</li>
                    <li>Kami berhak untuk membatasi atau mengakhiri akses Anda ke fasilitas dan layanan yang terkait dengan membership jika terjadi pelanggaran terhadap syarat dan ketentuan yang ditetapkan.</li>
                    <li>Segala informasi dan materi yang diberikan sebagai bagian dari membership adalah milik eksklusif dari pihak kami dan tidak boleh disebarkan, disalin, atau digunakan tanpa izin tertulis.</li>
                    <li>Kami tidak bertanggung jawab atas kerugian atau cedera yang mungkin terjadi selama penggunaan fasilitas dan layanan yang terkait dengan membership.</li>
                </ol>
                </div>
                <p>Dengan menekan tombol "Accept", Anda menyatakan bahwa Anda telah membaca, memahami, dan setuju dengan semua syarat dan ketentuan yang tercantum dalam disclaimer ini.</p>
                <div class="modal-buttons">
                    <form action="" method="post" >
                    <input type='hidden' id="code" name="code" value=<?php echo $uniqueCode; ?>>
                    <input type='hidden' id="tot" name="tot" value=<?php echo $total + $uniqueCode; ?>>
                    <button id="acceptBtn" class="normal ck" name="checkout">Accept</button>
                    </form>
                    <form action="" method="post" >
                    <button id="denyBtn" class="normal cl">Deny</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section id="newsletter" class="section-p1 section-m1">
        <div class="newstext">
            <h4>Sign Up For Newsletters</h4>
            <p>Get E-mail updates about our latest shop and <span>special Offers.</span></p>
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
        function updateHarga(element, gymprice) {
          var hargaElement = element.parentNode.parentNode.querySelector('.harga');
          var num = parseInt(element.value);
          var dropdown = element.parentNode.nextElementSibling.querySelector('select');
          var dropdownValue = parseInt(dropdown.value);
          var harga = 0;
          if (dropdownValue === 1) {
            harga = gymprice * num;
          } else if (dropdownValue === 3) {
            harga = gymprice * num * 3 * 0.85;
          } else if (dropdownValue === 6) {
            harga = gymprice * num * 6 * 0.75;
          } else if (dropdownValue === 12) {
            harga = gymprice * num * 12 * 0.65;
          }
      
          var formattedHarga = formatPrice(harga);
          hargaElement.textContent = formattedHarga;
          updateTotal();
        }

        function formatPrice(price) {
          var formatted = new Intl.NumberFormat('id-ID').format(price);
          return 'Rp ' + formatted;
        }

        function updateHargaDropdown(dropdown, gymprice) {
          var selectedValue = dropdown.value;
          var row = dropdown.closest('tr');
          var numInput = row.querySelector('.num');
          updateHarga(numInput, gymprice);
        }

        function updateTotal() {
          var total = 0;
          var hargaElements = document.querySelectorAll('.harga');
        
          hargaElements.forEach(function (hargaElement) {
            var price = parseFloat(hargaElement.textContent.replace('Rp ', '').replace(/\./g, '').replace(',', '.'));
            total += price;
          });
      
          var formattedTotal = formatPrice(total);
          document.getElementById('total').textContent = formattedTotal;
          updateLata();
          updatetot()
        }

        function updateLata() {
          var total = parseFloat(document.getElementById('total').textContent.replace('Rp ', '').replace('.', '').replace(',', '.'));
          var uniqueCode = parseFloat(document.getElementById('uniqueCode').textContent.replace('Rp ', '').replace('.', '').replace(',', '.'));
          var lata = total + uniqueCode;
          var formattedLata = formatPrice(lata);
          document.getElementById('lata').textContent = formattedLata;
        }
        function updatetot() {
          var total = parseFloat(document.getElementById('total').textContent.replace('Rp ', '').replace('.', '').replace(',', '.'));
          var uniqueCode = parseFloat(document.getElementById('uniqueCode').textContent.replace('Rp ', '').replace('.', '').replace(',', '.'));
          var lata = total + uniqueCode;
          var formattedLata = lata;
          document.getElementById('tot').textContent = formattedLata;
        }
    </script>

    <script>
        function confirmClearCart() {
            return confirm("Are you sure you want to clear the cart?");
        }

        function confirmCheckout() {
        var modal = document.getElementById('myModal');
        var acceptBtn = document.getElementById('acceptBtn');
        var denyBtn = document.getElementById('denyBtn');

        modal.style.display = "block";

        acceptBtn.onclick = function() {
            // Proses pembelian membership
            // ...

            // Tutup modal
            modal.style.display = "none";
            return true;
        }

        denyBtn.onclick = function() {
            // Tutup modal
            modal.style.display = "none";
            return false;
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                // Tutup modal jika diklik di area di luar modal
                modal.style.display = "none";
            }
        }
        
        return false;
    }
    </script>
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
