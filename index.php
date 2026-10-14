<?php
include "koneksi.php";
 
// simpan laporan kalau form dikirim (Create)
if (isset($_POST["kirim"])) {
    $nama_pelapor   = $_POST["nama_pelapor"];
    $nama_fasilitas = $_POST["nama_fasilitas"];
    $lokasi         = $_POST["lokasi"];
    $id_kategori    = $_POST["id_kategori"];
    $deskripsi      = $_POST["deskripsi"];
    $prioritas      = $_POST["prioritas"];
 
    $stmt = mysqli_prepare($koneksi, "INSERT INTO laporan_kerusakan
            (nama_pelapor, nama_fasilitas, lokasi, id_kategori, deskripsi, prioritas)
            VALUES (?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sssiss", $nama_pelapor, $nama_fasilitas, $lokasi, $id_kategori, $deskripsi, $prioritas);
    mysqli_stmt_execute($stmt);
 
    // kembali ke halaman ini supaya form tidak terkirim dua kali saat direfresh
    header("Location: index.php");
    exit;
}
 
// ambil semua laporan (Read)
$hasil = mysqli_query($koneksi, "SELECT * FROM laporan_kerusakan ORDER BY tanggal_laporan DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pelaporan Kerusakan Fasilitas Sekolah</title>
    <link rel="stylesheet" href="sts.css">
</head>
<body>
    <header>
        <h1>Sistem Pelaporan Kerusakan Fasilitas Sekolah</h1>
        <p>Catat dan pantau laporan kerusakan fasilitas sekolah.</p>
        <nav>
            <a href="#form-laporan">Buat Laporan</a>
            <a href="#daftar-laporan">Daftar Laporan</a>
        </nav>
    </header>
 
    <main>
        <section id="form-laporan">
            <h2>Form Pelaporan Kerusakan</h2>
 
            <form action="" method="post">
                <fieldset>
                    <legend>Data Pelaporan</legend>
 
                    <p>
                        <label for="nama_pelapor">Nama pelapor</label>
                        <input type="text" id="nama_pelapor" name="nama_pelapor" maxlength="100" required>
                    </p>
 
                    <p>
                        <label for="nama_fasilitas">Nama fasilitas</label>
                        <input type="text" id="nama_fasilitas" name="nama_fasilitas" maxlength="100" required>
                    </p>
 
                    <p>
                        <label for="lokasi">Lokasi kerusakan</label>
                        <input type="text" id="lokasi" name="lokasi" maxlength="100" required>
                    </p>
 
                    <p>
                        <label for="id_kategori">Kategori fasilitas</label>
                        <select id="id_kategori" name="id_kategori" required>
                            <option value="">-- Pilih kategori --</option>
                            <option value="1">Elektronik</option>
                            <option value="2">Furnitur</option>
                            <option value="3">Jaringan</option>
                            <option value="4">Peralatan Kelas</option>
                        </select>
                    </p>
 
                    <p>
                        <label for="deskripsi">Deskripsi kerusakan</label>
                        <textarea id="deskripsi" name="deskripsi" rows="4" required></textarea>
                    </p>
 
                    <p>
                        <label for="prioritas">Prioritas</label>
                        <select id="prioritas" name="prioritas" required>
                            <option value="">-- Pilih prioritas --</option>
                            <option value="Rendah">Rendah</option>
                            <option value="Sedang">Sedang</option>
                            <option value="Tinggi">Tinggi</option>
                        </select>
                    </p>
 
                    <p><button type="submit" name="kirim">Kirim Laporan</button></p>
                </fieldset>
            </form>
        </section>
 
        <section id="daftar-laporan">
            <h2>Daftar Laporan Kerusakan</h2>
 
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Fasilitas</th>
                        <th>Lokasi</th>
                        <th>Pelapor</th>
                        <th>Prioritas</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php while ($row = mysqli_fetch_assoc($hasil)) { ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo htmlspecialchars($row["nama_fasilitas"]); ?></td>
                        <td><?php echo htmlspecialchars($row["lokasi"]); ?></td>
                        <td><?php echo htmlspecialchars($row["nama_pelapor"]); ?></td>
                        <td><?php echo $row["prioritas"]; ?></td>
                        <td><?php echo $row["status"]; ?></td>
                        <td><?php echo date("d-m-Y H:i", strtotime($row["tanggal_laporan"])); ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </section>
    </main>
 
    <footer>
        <p>&copy; 2024 Sistem Pelaporan Kerusakan Fasilitas Sekolah.</p>
    </footer>
</body>
</html>
 