<?php
session_start();
$orderPrice = $_GET['tot'] - $_GET['code'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../CSS/pay.css">
  <script src="https://kit.fontawesome.com/f812210b6b.js"></script>   
  <title>Payment</title>
</head>
<body>
  <main class="container">
    <div class="main">
      <a href="history.php" class="back-icon"><i class="fas fa-chevron-left"></i></a>
      <div id="countdown"><h2></h2></div>
      <!-- Payment Method Section for bca  -->
      <section id="paymentMethodbca" class="payment_method">
        <h2 class="ship_head">Payment Method</h2>
        <div class="card_info">
          <div class="card_head">
            <div class="card_types">
              <img class="card_img bca-btn" src="../Image/bca-modified.png" alt=""/>
            </div>
            <h2 class="card_title">Payment Methods</h2>
          </div>
          <form action="">
            <input style="color: rgb(255, 162, 0);" type="text" name="virtual rekening" id="virtualRekening" value="0411459194" placeholder="0411459194" maxlength="60" readonly/>
            <input style="font-weight: bold;" type="text" name="Number" value="" placeholder="PT Ternak Otot" maxlength="16" readonly/>
            <div class="transparent-div">
              <input style="font-weight: bold;" type="text" name="Name" value="" placeholder="BCA" maxlength="4" readonly/>
              <input type="text" name="Name" value="" placeholder="Online" maxlength="3" readonly/>
            </div>
          </form>
          <span class="save_card" onclick="copyVirtualAccount()">Copy</span>
          <span class="save_card1" onclick="refreshVirtualAccount()" disabled>Refresh</span>
        </div>
      </section>
      <!-- Order Summary Section  -->
      <section class="order_summary">
        <h2 class="order_head">Order Summary</h2>
        <div class="order_price">
          <hr />
          <div class="price">
            <p>Username :</p>
            <p><?php echo $_SESSION['user']?></p>
          </div>
          <div class="price">
            <p>Products:</p>
            <p>Membership</p>
          </div>
          <div class="price">
            <p>Order price:</p>
            <p>Rp <?php echo number_format($orderPrice, 0, ',', '.');?></p>
          </div>
          <div class="price">
            <p>Unique Code:</p>
            <p>Rp <?php echo $_GET['code']?></p>
          </div>
          <br>
          <hr />
          <div class="total_price">
            <p class="dark">Total:</p>
            <p class="dark">Rp <?php echo number_format($_GET['tot'], 0, ',', '.');?></p>
          </div>
        </div>
        <img class="logo_qris" src="../Image/qris.png" alt="" />
        <img class="qr_code" src="https://cdn-icons-png.flaticon.com/512/714/714390.png" alt="" />
        <p class="condition">
          Pay Order by QR Code Using <b>QRIS</b>
        </p>
      </section>
      <small class="project_by"><b>Powered by<span>Ternak Otot</span></b></small>
    </div>
  </main>
  <script>
    
    var targetDate = new Date();
    targetDate.setDate(targetDate.getDate() + 1); // Tambahkan 1 hari

    function countdown() {
      var currentDate = new Date();
      var difference = targetDate - currentDate;


      var hours = Math.floor(difference / (1000 * 60 * 60));
      var minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
      var seconds = Math.floor((difference % (1000 * 60)) / 1000);


      document.getElementById("countdown").innerHTML = hours + ":" + minutes + ":" + seconds + "";


      setTimeout(countdown, 1000);
    }


    countdown();

    function copyVirtualAccount() {
        const virtualRekeningInput = document.getElementById('virtualRekening');
        const virtualRekeningPlaceholder = virtualRekeningInput.getAttribute('placeholder');
      
        if (navigator.clipboard) {
          navigator.clipboard.writeText(virtualRekeningPlaceholder)
            .then(() => {
              const refreshButton = document.querySelector('.save_card1');
              refreshButton.removeAttribute('disabled');
              alert('Virtual Account copied to clipboard');
            })
            .catch((error) => {
              console.error('Failed to copy Virtual Account: ', error);
            });
        }
      }
      
      function refreshVirtualAccount() {
        const refreshButton = document.querySelector('.save_card1');
      
        if (refreshButton.hasAttribute('disabled')) {

          return;
        }
      
        window.location.href = 'success.php';
      }
       
  </script>
</body>
</html>