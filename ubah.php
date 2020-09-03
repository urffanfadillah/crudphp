<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

require("functions.php");
// ambil data di url
$id = $_GET["id"];
//query data mahasiswa berdasarkan id
$mhs    = query("SELECT * FROM mahasiswa WHERE id = $id")[0];

// cek tombol submit sudah di klik
if (isset($_POST["submit"])) {
    // cek apakah data sudah diubah/tidak
    if (ubah($_POST) > 0) {
        echo "
            <script>
                alert('Data berhasil di ubah!');
                document.location.href  = 'index.php';
            </script>
        ";
    }else {
        echo "
        <script>
            alert('Data gagal di ubah!');
            document.location.href  = 'ubah.php';
        </script>
        ";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Data Mahasiswa</title>
</head>
<body>
    
    <h1>Ubah Data Mahasiswa</h1>
    <form action="" method="POST" enctype="multipart/form-data">
        <ul>
            <input type="hidden" name="id" value="<?= $mhs["id"] ?>">
            <input type="hidden" name="gambarLama" value="<?= $mhs["gambar"] ?>">
            <li>
                <label for="nrp">NRP : </label>
                <input type="text" name="nrp" id="nrp" required value="<?= $mhs["nrp"] ?>">
            </li>
            <br>
            <li>
                <label for="nama">Nama : </label>
                <input type="text" name="nama" id="nama" required value="<?= $mhs["nama"] ?>">
            </li>
            <br>
            <li>
                <label for="email">Email : </label>
                <input type="text" name="email" id="email" required value="<?= $mhs["email"] ?>">
            </li>
            <br>
            <li>
                <label for="jurusan">Jurusan : </label>
                <input type="text" name="jurusan" id="jurusan" required value="<?= $mhs["jurusan"] ?>">
            </li>
            <br>
            <li>
                <label for="gambar">Gambar : </label> <br>
                <img src="img/<?= $mhs["gambar"]; ?>" width="80" height="80"> <br>
                <input type="file" name="gambar" id="gambar">
            </li>
            <br>
            <li>
                <button type="submit" name="submit">Ubah data</button>
            </li>
        </ul>
    </form>

</body>
</html>