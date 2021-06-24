<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("location: login.php");
}

require 'system/functions.php';
include("system/connection.php");

$laporan = mysqli_query($connection, "SELECT * FROM tb_barang ORDER BY id_barang DESC");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="shortcut icon" href="images/ico.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Cetak laporan</title>
</head>

<body style="margin:0; padding:0;">
    <div class="container">
        <header style="text-align: center; padding: 50px 0px 0px 0px;">
            <div style="display: flex;">
                <div style="width: 20%;">
                    <img src="images/ico.png" width="100px" height="100px" alt="">
                </div>
                <div style="width: 60%; padding-top: 0px; ">
                    <h2>Toko Dy.id Jaya Sementara</h2>
                    <h4>Laporan Hasil Penjualan Toko</h4>
                </div>
                <div style="width: 20%;">
                    <img src="images/himasi.png" width="100px" height="100px" alt="">
                </div>
                <br>
            </div>
            <div style="text-align: center;" class="container">
                <div style="text-align:center; display:block; border-bottom: 4px solid black; padding: 10px;"></div>
            </div>
        </header>
        <main class="containerku" style="display: block; padding:20px 0 0 0;">
            <div class="container">
                <hr>
                <div id="container">
                    <div class="card-header">
                        <div class="card-body">
                            <table class="table table-hover table-dark">
                                <thead class="thead-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Barang</th>
                                        <th>Supplier</th>
                                        <th>Brand</th>
                                        <th>Harga</th>
                                        <th>Stok</th>
                                        <!-- <th style="width: 230px;">Action</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $count_number = 0;
                                    while ($data = mysqli_fetch_array($laporan)) {
                                        $id_brand = $data["id_brand"];
                                        $brand = mysqli_query($connection, "SELECT Namabrand('$id_brand')");
                                        $brand = mysqli_fetch_array($brand);
                                        $count_number++;
                                        echo "
                                            <tr role='row'>
                                                <td class='dtr-control' tabindex='0' style='border-right:1px solid white; text-align:center;'>" . $count_number . "</td>
                                                <td style='border-right:1px solid white;'>" . $data["nama_barang"] . "</td>
                                                <td style='border-right:1px solid white;'>" . $data["supplier"] . "</td>
                                                <td style='border-right:1px solid white;'>" . $brand[0] . "</td>
                                                <td style='border-right:1px solid white;'> Rp " . $data["harga"] . "</td>
                                                <td style='border-right:1px solid white;'>" . $data["stok"] . "</td>
                                            </tr>
                                        ";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div style=" display: block;">
                <div style="position: absolute; right: -980px; text-align:center; padding: 30px 100px; right:0;">
                    <p>Mengetahui</p>
                    <p>CEO Dy.id</p>
                    <br><br><br>
                    <p style="text-decoration:underline;">(Mr. Dave Code)</p>
                </div>
                <footer style="text-align: center; padding-top:250px;">
                    Copyright &copy; 2021 | Kelompok 6 | SMBD Kelas B
                </footer> <br> <br>
            </div>
            <script>
                window.print();
            </script>
    </div>
</body>

</html>