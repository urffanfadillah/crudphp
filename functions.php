<?php
$db = mysqli_connect("localhost", "root", "", "phpdasar");

function query($query) {
    global $db;
    $result = mysqli_query($db, $query);
    $rows   = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[]   = $row;
    }
    return $rows;
}

function tambah($data) {
    global $db;
    // ambil data di tiap form
    $nama       = htmlspecialchars($data["nama"]);
    $nrp        = htmlspecialchars($data["nrp"]);
    $email      = htmlspecialchars($data["email"]);
    $jurusan    = htmlspecialchars($data["jurusan"]);
    // upload gambar
    $gambar     = upload();
    if (!$gambar) {
        return false;
    }

    // insert query
    $query      = "INSERT INTO mahasiswa VALUE(
        '', '$nama', '$nrp', '$email', '$jurusan', '$gambar'
    )";
    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}

function upload() {
    $namaFile   = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error      = $_FILES['gambar']['error'];
    $tmpName    = $_FILES['gambar']['tmp_name'];

    // cek apakah tidak ada gambar yang di upload
    if ($error === 4) {
        echo "<script>
                alert('Silahkan pilih gambar!');
              </script>";
        return false;
    }
    // cek apakah yang di upload adalah gambar
    $ekstensiGambarValid    = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar     = explode('.', $namaFile);
    $ekstensiGambar     = strtolower(end($ekstensiGambar));
    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "<script>
                alert('Yang anda upload bukan gambar!');
              </script>";
        return false;
    }
    // cek jika ukuran gambar terlalu besar
    if ($ukuranFile > 1000000) {
        echo "<script>
                alert('Gambar yang anda upload terlalu besar!');
              </script>";
        return false;
    }
    // lolos pengecekan, siap di upload
    // generate nama gambar baru
    $namaFileBaru   = uniqid();
    $namaFileBaru  .= '.';
    $namaFileBaru  .= $ekstensiGambar;

    move_uploaded_file($tmpName, 'img/' . $namaFileBaru);
    return $namaFileBaru;
}

function hapus($id) {
    global $db;
    mysqli_query($db, "DELETE FROM mahasiswa WHERE id = $id");

    return mysqli_affected_rows($db);
}

function ubah($data) {
    global $db;
    // ambil data di tiap form
    $id         = $data["id"];
    $nama       = htmlspecialchars($data["nama"]);
    $nrp        = htmlspecialchars($data["nrp"]);
    $email      = htmlspecialchars($data["email"]);
    $jurusan    = htmlspecialchars($data["jurusan"]);
    $gambarLama = htmlspecialchars($data["gambarLama"]);
    // cek apakah user pilih gambar baru atau tidak
    if ($_FILES['gambar']['error'] === 4) {
        $gambar = $gambarLama;
    }else {
        $gambar     = upload();
    }

    // insert query
    $query      = "UPDATE mahasiswa SET
        nrp     = '$nrp',
        nama    = '$nama',
        email   = '$email',
        jurusan = '$jurusan',
        gambar  = '$gambar'
        WHERE id = $id
    ";
    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}
function cari($keyword){
    $query  = "SELECT * FROM mahasiswa
                WHERE
              nama LIKE '%$keyword%' OR
              nrp LIKE '%$keyword%' OR
              email LIKE '%$keyword%' OR
              jurusan LIKE '%$keyword%'
    ";
    return query($query);
}

function registrasi($data){
    global $db;
    $username   = strtolower(stripslashes($data["username"]));
    $password   = mysqli_real_escape_string($db, $data["password"]);
    $password2  = mysqli_real_escape_string($db, $data["password2"]);
    // cek apakah username sudah tersedia
    $result = mysqli_query($db, "SELECT username FROM user WHERE username='$username'");
    if (mysqli_fetch_assoc($result)) {
        echo "<script>
                alert('Username sudah tersedia!');
              </script>";
        return false;
    }
    // cek konfirmasi password
    if ($password !== $password2) {
        echo "<script>
                alert('Konfirmasi password tidak sama!');
            </script>";
        return false;
    }
    // enkripsi password
    $password   = password_hash($password, PASSWORD_DEFAULT);
    // tambahkan user ke database
    mysqli_query($db, "INSERT INTO user VALUES(
        '', '$username', '$password'
    )");
    return mysqli_affected_rows($db);
}

?>