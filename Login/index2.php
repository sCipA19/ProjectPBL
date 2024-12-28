<?php
session_start();
include('../koneksi/kon.php'); // Pastikan path ini sesuai

// Proses login
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $role = $_POST["role"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $redirectUrl = ""; // URL untuk redirect setelah login berhasil

    // Query untuk login
    $query = "SELECT * FROM tb_login WHERE username = ? AND password = ?";
    $stmt = sqlsrv_prepare($conn, $query, array($username, $password));

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    if (sqlsrv_execute($stmt)) {
        // Ambil hasil eksekusi query
        $result = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

        // Cek apakah data ditemukan
        if ($result) {
            $_SESSION['username'] = $username;

            // Redirect berdasarkan peran
            if ($role === "admin") {
                $_SESSION['role'] = 'admin';
                $redirectUrl = "../Admin/beranda.php";
            } elseif ($role === "dosen") {
                $_SESSION['role'] = 'dosen';
                $redirectUrl = "../Dosen/dashbroad.php";
            } elseif ($role === "mahasiswa") {
                $_SESSION['role'] = 'mahasiswa';
                $redirectUrl = "../Mahasiswa/index.php";
            } else {
                $error = "Peran yang Anda pilih tidak valid!";
            }

            // Redirect jika URL valid
            if ($redirectUrl) {
                header("Location: $redirectUrl");
                exit();
            }
        } else {
            $error = "Username atau password salah!";
        }
    } else {
        $error = "Terjadi kesalahan saat mengeksekusi query.";
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
      const usernameInput = document.getElementById("username");

      // Mengubah placeholder berdasarkan role yang dipilih
      if (role === "admin") {
        usernameInput.placeholder = "Enter your email";
        usernameInput.setAttribute("type", "email");
      } else if (role === "dosen") {
        usernameInput.placeholder = "Enter your NIP";
        usernameInput.setAttribute("type", "text");
      } else if (role === "mahasiswa") {
        usernameInput.placeholder = "Enter your username";
        usernameInput.setAttribute("type", "text");
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
            <input type="text" id="username" name="username" placeholder="Enter your email" required>
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
