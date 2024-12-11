<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lapor Pelanggaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to bottom, #e6f7f9, #577eae);
            height: 100vh;
        }
        .modal-header, .modal-body, .modal-footer {
            color: black;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#laporModal">Lapor Pelanggaran</button>
    </div>

    <!-- Modal Lapor Pelanggaran -->
    <div class="modal fade" id="laporModal" tabindex="-1" aria-labelledby="laporModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="laporModalLabel">Lapor Pelanggaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="reportForm">
                        <!-- Nama Mahasiswa -->
                        <div class="mb-3">
                            <label for="namaMahasiswa" class="form-label">Nama Mahasiswa</label>
                            <input type="text" class="form-control" id="namaMahasiswa" placeholder="Masukkan nama mahasiswa">
                        </div>

                        <!-- Kelas Mahasiswa -->
                        <div class="mb-3">
                            <label for="kelasMahasiswa" class="form-label">Kelas</label>
                            <select class="form-select" id="kelasMahasiswa">
                                <option value="" disabled selected>Pilih kelas</option>
                                <option value="TI-21-A">TI-21-A</option>
                                <option value="TI-21-B">TI-21-B</option>
                                <option value="TI-21-C">TI-21-C</option>
                                <!-- Tambahkan opsi lainnya sesuai kebutuhan -->
                            </select>
                        </div>

                        <!-- Nama Pelanggaran -->
                        <div class="mb-3">
                            <label for="namaPelanggaran" class="form-label">Nama Pelanggaran</label>
                            <select class="form-select" id="namaPelanggaran">
                                <option value="" disabled selected>Pilih pelanggaran</option>
                                <option value="Tidak memakai seragam">Tidak memakai seragam</option>
                                <option value="Datang terlambat">Datang terlambat</option>
                                <option value="Bermain gadget di kelas">Bermain gadget di kelas</option>
                                <!-- Tambahkan opsi lainnya sesuai kebutuhan -->
                            </select>
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-3">
                            <label for="deskripsiPelanggaran" class="form-label">Deskripsi Pelanggaran</label>
                            <textarea class="form-control" id="deskripsiPelanggaran" rows="3" placeholder="Deskripsikan pelanggaran"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="submitReport">Kirim Laporan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">Konfirmasi Laporan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted">Pelanggaran Mahasiswa pada tanggal <span id="currentDate"></span></p>
                    <p>Nama: <span id="namaOutput"></span></p>
                    <p>Kelas: <span id="kelasOutput"></span></p>
                    <p>Pelanggaran: <span id="pelanggaranOutput"></span></p>
                    <p>Deskripsi: <span id="deskripsiOutput"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Kirim</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById("submitReport").addEventListener("click", function() {
            // Ambil nilai dari form
            const nama = document.getElementById("namaMahasiswa").value;
            const kelas = document.getElementById("kelasMahasiswa").value;
            const pelanggaran = document.getElementById("namaPelanggaran").value;
            const deskripsi = document.getElementById("deskripsiPelanggaran").value;

            // Masukkan nilai ke modal konfirmasi
            document.getElementById("namaOutput").textContent = nama;
            document.getElementById("kelasOutput").textContent = kelas;
            document.getElementById("pelanggaranOutput").textContent = pelanggaran;
            document.getElementById("deskripsiOutput").textContent = deskripsi;

            // Tambahkan tanggal saat ini
            document.getElementById("currentDate").textContent = new Date().toLocaleDateString("id-ID");

            // Tampilkan modal konfirmasi
            const confirmationModal = new bootstrap.Modal(document.getElementById("confirmationModal"));
            confirmationModal.show();

            // Tutup modal input
            const laporModal = bootstrap.Modal.getInstance(document.getElementById("laporModal"));
            laporModal.hide();
        });
    </script>
</body>
</html>
