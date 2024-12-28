<?php

session_start();

$users = [
    [
        'email' => 'mahasiswa@polinema.ac.id',
        'password' => 'password123',
        'role' => 'mahasiswa',
        'name' => 'Mahasiswa User'
    ],
    [
        'email' => 'dosen@polinema.ac.id',
        'password' => 'password456',
        'role' => 'dosen',
        'name' => 'Dosen User'
    ],
    [
        'email' => 'admin@polinema.ac.id',
        'password' => 'password789',
        'role' => 'admin',
        'name' => 'Admin User'
    ]
];

// Ambil data dari form
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$role = $_POST['role'] ?? '';

// Periksa apakah pengguna valid
foreach ($users as $user) {
    if ($user['email'] === $email && $user['password'] === $password && $user['role'] === $role) {
        // Simpan informasi pengguna ke session
        $_SESSION['user'] = [
            'name' => $user['name'],
            'email' => $user['email'],
            'role' => $user['role']
        ];
        
        // Redirect ke halaman dashboard
        header('Location: dashboard.php');
        exit;
    }
}

// Jika gagal login
header('Location: index.php?error=1');
exit;
?>
