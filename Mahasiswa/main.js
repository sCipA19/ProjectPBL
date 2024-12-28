document.addEventListener("DOMContentLoaded", function () {
    // Ambil elemen-elemen yang akan digunakan
    const messageIcon = document.getElementById("message-icon");
    const messagePopup = document.getElementById("message-popup");
    const messagePopupClose = document.getElementById("message-popup-close");
    const profileTrigger = document.getElementById("profile-trigger");
    const profilePopup = document.getElementById("profile-popup");
    const profilePopupClose = document.getElementById("close-popup");
    const chatList = document.getElementById("chatList");
    const notificationDetails = document.getElementById("notificationDetails");

    // Menampilkan popup ketika ikon pesan diklik
    if (messageIcon && messagePopup) {
        messageIcon.addEventListener("click", function () {
            messagePopup.style.display = "flex";
        });
    }

    // Menutup popup ketika tombol "Tutup" diklik
    if (messagePopupClose && messagePopup) {
        messagePopupClose.addEventListener("click", function () {
            messagePopup.style.display = "none";
        });
    }

    // Menampilkan popup ketika gambar profil diklik
    if (profileTrigger && profilePopup) {
        profileTrigger.addEventListener("click", function () {
            profilePopup.style.display = "flex";
        });
    }

    // Menutup popup ketika tombol "Tutup" diklik
    if (profilePopupClose && profilePopup) {
        profilePopupClose.addEventListener("click", function () {
            profilePopup.style.display = "none";
        });
    }

    // Menampilkan detail notifikasi
    window.showNotificationDetails = function (element) {
        if (!element || !notificationDetails || !chatList) return;

        const name = element.getAttribute("data-name") || "-";
        const message = element.getAttribute("data-message") || "-";
        const time = element.getAttribute("data-time") || "-";

        chatList.style.display = "none";
        notificationDetails.style.display = "block";

        const header = notificationDetails.querySelector(".header");
        const date = notificationDetails.querySelector(".header.date");
        const messageRow = notificationDetails.querySelector(".row .value");

        if (header) header.textContent = `To : ${name}`;
        if (date) date.textContent = time;
        if (messageRow) messageRow.textContent = message;
    };

    // Fungsi untuk kembali ke daftar notifikasi
    window.goBack = function () {
        if (chatList && notificationDetails) {
            chatList.style.display = "block";
            notificationDetails.style.display = "none";
        }
    };

    // Memastikan tombol profil bekerja dengan benar
    document.addEventListener('DOMContentLoaded', function () {
        const profileTrigger = document.getElementById('profile-trigger');
        const profilePopup = document.getElementById('profile-popup');
        const closePopup = document.getElementById('close-popup');
    
        // Tampilkan popup saat ikon profil diklik
        profileTrigger.addEventListener('click', function () {
            profilePopup.style.display = 'flex';
        });
    
        // Sembunyikan popup saat tombol tutup diklik
        closePopup.addEventListener('click', function () {
            profilePopup.style.display = 'none';
        });
    
        // Sembunyikan popup jika pengguna mengklik di luar popup
        window.addEventListener('click', function (event) {
            if (event.target === profilePopup) {
                profilePopup.style.display = 'none';
            }
        });
    });

    
    // Memastikan tombol titik tiga masih bisa diklik
    document.querySelectorAll('.btn-three-dots').forEach(button => {
        button.style.pointerEvents = 'auto';
    });

    // Memastikan tombol "Kembali ke Dashboard" dapat diklik
    document.querySelectorAll('.back-to-dashboard').forEach(button => {
        button.style.pointerEvents = 'auto';
    });
});
