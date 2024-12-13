<?php
session_start();
include('../koneksi/kon.php'); // Pastikan path ini sesuai

// Proses login
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $role = $_POST["role"];
    $username = $_POST["username"];
    $password = $_POST["password"];

    if ($role === "admin") {
        // Query untuk SQL Server
        $query = "SELECT * FROM tb_login WHERE username = ? AND password = ?";
        
        // Persiapkan dan eksekusi query menggunakan SQLSRV
        $stmt = sqlsrv_prepare($conn, $query, array($username, $password));
        
        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }
        
        if (sqlsrv_execute($stmt)) {
            // Ambil hasil eksekusi query
            $result = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
            
            // Cek apakah ada hasil yang ditemukan
            if ($result) {
                $_SESSION['username'] = $username;
                $_SESSION['role'] = 'admin';
                header("Location: ../Admin/beranda.php");
                exit();
            } else {
                $error = "Username atau password salah!";
            }
        } else {
            $error = "Terjadi kesalahan saat mengeksekusi query.";
        }
    } else {
        $error = "Hanya admin yang dapat login saat ini.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="style.css">
  <script>
    function updatePlaceholder() {
      const role = document.getElementById("role").value;
      const emailInput = document.getElementById("email");

      if (role === "admin") {
        emailInput.placeholder = "Enter your email";
        emailInput.setAttribute("type", "email");
      } else if (role === "dosen") {
        emailInput.placeholder = "Enter your NIP";
        emailInput.setAttribute("type", "text");
      } else if (role === "mahasiswa") {
        emailInput.placeholder = "Enter your username";
        emailInput.setAttribute("type", "text");
      }
    }
  </script>
</head>
<body>
  <div class="login-container">
    <!-- Left Section with Image -->
    <div class="login-left">
      <img src="./img/polinema.jpg" alt="Background Image" class="background-image">
      <div class="overlay">
        <h1>ANUKRAMA</h1>
        <p>Selamat datang di Anukrama, sistem tata tertib berbasis nilai dan keteraturan. 
        Masuklah untuk mengakses panduan aturan yang dirancang mendukung disiplin dan keteraturan 
        dalam kegiatan Anda. Dengan login, Anda dapat terhubung ke sumber informasi tata tertib yang 
        mudah diakses dan mendukung ketertiban bersama.</p>
      </div>
    </div>

    <div class="login-right">
      <div class="wrapper">
        <form method="POST" action="">
          <!-- Login Title -->
          <div class="login-title">
            <img src="./img/logo.png" alt="Login Icon" class="login-icon">
          </div>
          <!-- Role Selection -->
          <div class="input-field">
            <select id="role" name="role" onchange="updatePlaceholder()">
              <option value="admin">Admin</option>
              <option value="dosen">Dosen</option>
              <option value="mahasiswa">Mahasiswa</option>
            </select>
          </div>
          <div class="input-field">
            <input type="text" id="username"  name="username" placeholder="Enter your email" required>
          </div>
          <div class="input-field">
            <input type="password" name="password" placeholder="Enter your password" required>
          </div>
          <div class="forget">
            <label for="remember">
              <input type="checkbox" id="remember">
              <span>Remember me</span>
            </label>
            <a href="#">Forgot password?</a>
          </div>
          <button type="submit">Log In</button>
          <div class="register">
            <p>Don't have an account? <a href="#">Register</a></p>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
