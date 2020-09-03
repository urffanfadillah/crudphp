<?php
    session_start();
    require "functions.php";
    // cek cookie
    if (isset($_COOKIE['id']) && isset($_COOKIE['key'])) {
        $id     = $_COOKIE['id'];
        $key    = $_COOKIE['key'];
        $result = mysqli_query($db, "SELECT username FROM user WHERE id = '$id'");
        $row    = mysqli_fetch_assoc($result);
        // cek cookie dan username
        if ($key === hash('sha256', $row["username"])) {
            $_SESSION['login'] = true;
        }
    }
    // cek session
    if (isset($_SESSION["login"])) {
        header("Location: index.php");
        exit;
    }
    if (isset($_POST["login"])) {
        $username   = $_POST["username"];
        $password   = $_POST["password"];
        $result     = mysqli_query($db, "SELECT * FROM user WHERE username = '$username'");
        // cek username sudah tersedia
        if (mysqli_num_rows($result) === 1) {
            // cek passwordnya
            $row    = mysqli_fetch_assoc($result);
            if (password_verify($password, $row["password"])) {
                // set session
                $_SESSION["login"] = true;
                // cek remember me
                if (isset($_POST["remember"])) {
                    // buat cookie
                    setcookie('id', $row['id'], time() + 60);
                    setcookie('key', hash('sha256', $row['username']), time() + 60);
                }
                header("Location: index.php");
                exit;
            }
        }
        $error      = true;

    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <?php if(isset($error)): ?>
        <i style="color: red;">Username / password salah!</i>
    <?php endif; ?>
    <form action="" method="post">
        <ul>
            <li>
                <label for="username">Username : </label>
                <input type="text" name="username" id="username">
            </li> <br>
            <li>
                <label for="password">Password : </label>
                <input type="password" name="password" id="password">
            </li> <br>
            <li>
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">Remember me </label>
            </li> <br>
            <li>
                <button type="submit" name="login">Masuk!</button>
            </li>
        </ul>
    </form>
</body>
</html>