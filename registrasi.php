<?php
    require "functions.php";
    if (isset($_POST["register"])) {
        if (registrasi($_POST) > 0) {
            echo "<script>
                    alert('User baru berhasil di tambahkan!');
                  </script>";
        }else {
            mysqli_error($db);
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
    <style>
        label {
            display: block;
        }
    </style>
</head>
<body>
    <h1>Halaman Registrasi</h1>
    <form action="" method="post">
        <ul>
            <li>
                <label for="username">Username :</label>
                <input type="text" name="username" id="username">
            </li> <br>
            <li>
                <label for="password">Password :</label>
                <input type="password" name="password" id="password">
            </li> <br>
            <li>
                <label for="password2">Konfirmasi Password :</label>
                <input type="password" name="password2" id="password2">
            </li> <br>
            <li>
                <button type="submit" name="register">Daftar!</button>
            </li> <br>
        </ul>
    </form>
</body>
</html>