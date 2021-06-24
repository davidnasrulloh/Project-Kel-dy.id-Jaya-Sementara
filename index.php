<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("location: login.php");
}

require 'system/functions.php';
include("system/connection.php");
// function for active sidebar list
function getpage($pattern, $subject)
{
    $pattern = str_replace('%', '.*', preg_quote($pattern, '/'));
    return (bool) preg_match("/^{$pattern}$/i", $subject);
}
function activeList($list)
{
    if (isset($_GET['page'])) {
        $pagenow = $_GET['page'];
        if (getpage($pagenow, $list)) {
            echo "active";
        }
    }
}

$nama = $_SESSION['nama'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Dy.id Jaya Sementara</title>
    <link rel="stylesheet" href="css/styles2.css">
    <link rel="shortcut icon" href="images/ico.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
</head>

<body background="images/page-background.png">
    <!-- Sidebar -->
    <div class="sidenav">
        <div class="sidenav-header horizontal-center">
            <hr>
            <div style="display: flex; padding:0 0 0 20px;">
                <img src="images/ico.png" width="60px" alt="">
                <div style="padding-left: 20px;">
                    <h1 style="padding-top: 5px;">Menu</h1>
                </div>
            </div>
            <?php
            $id_admin = $_SESSION['id_admin'];
            $select = mysqli_query($connection, "SELECT * FROM tb_admin WHERE id_admin = '$id_admin'");
            $count_number = 0;
            while ($data = mysqli_fetch_array($select)) {
                $count_number++;
                echo "
                        <h6 style='padding-top:10px; font-size: 16px;'>" . $data["nama"] . " | Admin</h6>
                        <hr>
                    ";
            }
            ?>
        </div>
        <a href="index.php?page=home" class="<?= activeList('home') ?>"><i class="fas fa-home pr-15"></i></i> Home</a>
        <br>
        <a href="index.php?page=transaksi" class="<?= activeList('transaksi') ?>"><i class="fa fa-book pr-15"></i> Transaksi</a>
        <br>
        <a href="index.php?page=laporan" class="<?= activeList('laporan') ?>"><i class="fa fa-pencil pr-15"></i> Laporan</a>
        <br>
        <a href="index.php?page=tambah-barang" class="<?= activeList('tambah-barang') ?>"><i class="fa fa-plus pr-15"></i> Tambah Barang</a>
        <br>
        <a href="index.php?page=tambah-admin" class="<?= activeList('tambah-admin') ?>"><i class="fas fa-user-plus pr-15"></i> Tambah Admin</a>
        <br>
        <a href="logout.php" class="fixed-bottom my-4"><i class="fa fa-sign-out-alt pr-15"></i>Log out</a>
    </div>
    <!-- Konten -->
    <div class="konten">
        <div class="isi">
            <?php
            if (!isset($_GET["page"])) {
                include("page/home.php");
            } else {
                include("page/" . $_GET["page"] . ".php");
            }
            ?>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.min.js" integrity="sha384-lpyLfhYuitXl2zRZ5Bn2fqnhNAKOAaM/0Kr9laMspuaMiZfGmfwRNFh8HlMy49eQ" crossorigin="anonymous"></script>
<script src="js/javascript.js"></script>
<!-- Font Awesome -->
<script src="https://kit.fontawesome.com/3e7c653e94.js" crossorigin="anonymous"></script>

</html>