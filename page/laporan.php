<?php
$select_terjual_from_tbriwayat = mysqli_query($connection, "SELECT * FROM tb_riwayat INNER JOIN tb_barang ON tb_riwayat.id_barang = tb_barang.id_barang WHERE perubahan_stok>0 AND nama_pembeli != '' ORDER BY waktu DESC");
$select_tbbarang = mysqli_query($connection, "SELECT * FROM tb_barang");
$count_stoktersedia = 0;
foreach ($select_tbbarang as $data) {
    $count_stoktersedia += $data['stok'];
}
// catalog & view
$catalog_jumlah_terjual = mysqli_query($connection, "SELECT view_definition FROM information_schema.views WHERE TABLE_NAME = 'jumlah_terjual'");
$view_jumlah_terjual;
foreach ($catalog_jumlah_terjual as $row) {
    $view_jumlah_terjual = $row['view_definition'];
}
$execute_view_jumlah_terjual = mysqli_query($connection, $view_jumlah_terjual);
$count_terjual = 0;
foreach ($execute_view_jumlah_terjual as $row) {
    $count_terjual = $row['jumlah_terjual'];
}
?>
<div class="main">
    <div class=" container-fluid">
        <div class="row">
            <div class="col-xl-5 col-md-4 mx-auto">
                <div class="card card-stats">
                    <!-- Card body -->
                    <div class="card-body col-12">
                        <div style="display:block">
                            <img src="./images/pc1.png" style="padding:20px;" class="card-img" alt="" style="width: 12rem;">
                            <!-- <i class="fas fa-laptop" style="width: 100px;"></i> -->
                            <div class="card-img-overlay" style="margin: 0; padding:0; position:absolute; left:-50px; text-align:center;">
                                <br>
                                <div style="padding-top: 200px;">
                                    <div class="row col-12">
                                        <div class="col-auto">
                                            <div style="padding-top: 10px;">

                                            </div>
                                            <h5 class="card-title text-uppercase text-muted mb-0">Total barang Terjual </h5>
                                            <span class="h2 font-weight-bold mb-0">
                                                <label id="periodBalance">
                                                    <?= $count_terjual ?>
                                                </label>
                                            </span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                                                <i class="ni ni-chart-bar-32"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-5 col-md-4 mx-auto">
                <div class="card card-stats">
                    <!-- Card body -->
                    <div class="card-body col-12">
                        <img src="./images/pc2.jpg" style="padding:20px; margin-bottom: 45px;" class="card-img" alt="" style="width: 12rem;">
                        <!-- <img src="./images/book.png" class="card-img" alt="" style="width: 9rem;"> -->
                        <div class="card-img-overlay" style="margin: 0; padding:0; position:absolute; left:-120px; text-align:center;">
                            <br>
                            <div style="padding-top: 200px;">
                                <div class="row">
                                    <div class="col">
                                        <div style="padding-top: 10px;">
                                        </div>
                                        <h5 class="card-title text-uppercase text-muted mb-0">Stok barang tersedia</h5>
                                        <span class="h2 font-weight-bold mb-0"><label id="balance"><?= $count_stoktersedia ?></label></span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
                                            <i class="ni ni-chart-pie-35"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="card">
                    <div style="padding: 30px 30px 10px 30px;">
                        <a type="button" href="cetak_lap.php" target="_BLANK" class="btn btn-secondary"><i class="fas fa-print pr-15"></i>Cetak Laporan</a>
                    </div>
                    <div class="card-header">
                        <div class="card-body">
                            <table class="table table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Waktu</th>
                                        <th scope="col">Nama barang</th>
                                        <th scope="col">Jumlah Terjual</th>
                                        <th scope="col">Nama Pembeli</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($select_terjual_from_tbriwayat as $data) {
                                    ?>
                                        <tr>
                                            <td>
                                                <?= $data['waktu'] ?>
                                            </td>
                                            <td>
                                                <?= $data['nama_barang'] ?>
                                            </td>
                                            <td>
                                                <?= $data['perubahan_stok'] ?>
                                            </td>
                                            <td>
                                                <?= $data['nama_pembeli'] ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer style="padding: 0 0 0 180px; color:white; background-color:black; height:60px; padding-top:17px; text-align:center;">
        Copyright &copy; 2021 | Dy.id Jaya Sementara | SMBD Kelas B
    </footer> <br>
</div>