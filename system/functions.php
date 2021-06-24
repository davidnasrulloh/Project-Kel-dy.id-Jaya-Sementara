<?php
require 'connection.php';

function tambahadmin($data)
{
    global $connection;
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    $nama = $_POST['nama'];

    $result = mysqli_query($connection, "SELECT username FROM tb_admin WHERE username = '$username'");
    // cek nim sama atau tidak
    if (mysqli_fetch_assoc($result)) {
        echo "
            <script>
                alert('username yang dimasukkan sudah terdaftar');
            </script>
            ";

        return false;
    }

    // cek konfirmasi password
    if ($password !== $password2) {
        echo "
            <script> 
                alert('Konfirmasi password tidak sesuai :(');
            </script>
        ";

        return false;
    }

    // query insert data
    // $query = "INSERT INTO tb_admin VALUES ('','$username', '$password', '$nama')";
    $query = "CALL tambah_admin('$username', '$password', '$nama')";

    mysqli_query($connection, $query);

    return mysqli_affected_rows($connection);
}
