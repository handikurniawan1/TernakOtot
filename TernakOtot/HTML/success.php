<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,400i,700,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/success.css">
    <title>Document</title>
    <script>
        let countdown = 5; // Durasi countdown dalam detik

        // Fungsi untuk memperbarui hitungan mundur dan mengarahkan pengguna setelah selesai
        function updateCountdown() {
            countdown--;
            document.getElementById("countdown").textContent = countdown;

            if (countdown === 0) {
                window.location.href = "Home.php";
            } else {
                setTimeout(updateCountdown, 1000); // Memperbarui setiap 1 detik
            }
        }

        // Panggil fungsi updateCountdown saat halaman selesai dimuat
        window.onload = function() {
            updateCountdown();
        };
    </script>
</head>
<body>
  <div>
    <h1>Success</h1> 
    <p>We received your purchase request;<br/> we'll be in touch shortly!</p>
    <p>Auto Redirecting in <span id="countdown">5</span> sec</p>
  </div>
</body>
</html>
