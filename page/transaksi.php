<?php
// require '../system/connection.php';
include("system/connection.php");
?>
<div class="main">
    <div class="container" style="margin: 0; padding: 0 0 0 260px; display:block; text-align:center;">
        <div class="wrapper" style="display: flex;">
            <div class="sideleft">
                <img src="images/dyid.png" width="200px" alt="">
            </div>
            <div class="right" style="padding:75px 0 0 40px;">
                <h2 style="font-weight:bold;">Toko Dy.id Jaya Sementara</h2>
            </div>
            <div style="padding:75px 0 0 130px;">
                <a href="logout.php"><button class="btn btn-danger"> <i class="fas fa-sign-out-alt"></i> Logout</button></a>
            </div>
        </div>
        <div class="line" style="border-bottom: 2px solid black;"></div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="card">
                    <div class="card-header" style="display: flex;">
                        <div style="padding: 10px 0 10px 0;">
                            <form class="search" action="" method="POST">
                                <input class="float-end" style="height: 40px;" type="text" placeholder="Search.." name="search">
                                <button type="submit"><i class="fa fa-search"></i></button>
                            </form>
                            <?php if (isset($_POST['search'])) { ?>
                                <form action="" method="POST">
                                    <button button type="submit" name="resetsearch" class="btn btn-danger">Reset</button>
                                </form>
                            <?php } ?>
                        </div>
                        <br>
                        <div style="padding: 10px 0px 0px 25px;" class="align-items-center">
                            <form action="" method="POST">
                                <?php if (isset($_POST['submitfilter'])) { ?>
                                    <button type="submit" name="resetfilter" class="btn btn-danger float-end mx-1">Reset</button>
                                <?php } else { ?>
                                    <button type="submit" name="submitfilter" style="height: 40px; width:120px;" class="btn btn-primary float-end mx-1"><i class="fas fa-filter pr-15"></i>Filter</button>
                                <?php } ?>

                                <input style="height: 40px;" type="number" name="numbervalue" placeholder="10" class="float-end mx-1">
                                <select style="height: 40px; width:100px;" name="sort" id="" class="float-end mx-1">
                                    <option value=">">Lebih dari</option>
                                    <option value="<">Kurang dari</option>
                                </select>
                                <select style="height: 40px; width:100px;" name="filtertype" id="filter" class="float-end mx-1">
                                    <option value="Harga">Harga</option>
                                    <option value="Stok">Stok</option>
                                </select>
                                <!-- <label class="float-end mx-2" style="padding-top: 10px;">Filter :</label> -->
                            </form>
                        </div>
                    </div>
                    <div class="card-body">
                        <div style="padding: 10px 30px 20px 1px;">
                            <a type="button" href="cetak_lap_barang.php" target="_BLANK" class="btn btn-secondary"><i class="fas fa-print pr-15"></i>Cetak Laporan</a>
                        </div>
                        <table class="table table-hover table-striped table-warning" style="text-align: left;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    <th>Supplier</th>
                                    <th>Brand</th>
                                    <th>Harga</th>
                                    <th>Stok</th>
                                    <th style="width: 230px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $select = mysqli_query($connection, "SELECT * FROM tb_barang ORDER BY id_barang DESC");

                                // update barang
                                if (isset($_POST['submitUpdateBarang'])) {
                                    $idbarang = $_POST['idbarang'];
                                    $hargabarang = $_POST['hargabarang'];
                                    $stokbarang = $_POST['stokbarang'];
                                    $apakahUpdateBerhasil = mysqli_query($connection, "CALL update_barang($idbarang, $hargabarang, $stokbarang)");
                                    if (!$apakahUpdateBerhasil) {
                                        echo "<script> alert('Error!');</script>";
                                    } else {
                                        echo "<script> document.location = window.location.href </script>";
                                    }
                                }

                                // deleted barang
                                if (isset($_POST['submitdeletebarang'])) {
                                    $idbarang = $_POST['idbarang'];
                                    mysqli_query($connection, "DELETE FROM tb_barang WHERE id_barang = $idbarang");
                                    echo "<script> document.location = window.location.href; </script>";
                                }
                                if (isset($_POST['search'])) {
                                    $search = $_POST['search'];
                                    $select = mysqli_query($connection, "SELECT * FROM tb_barang WHERE nama_barang LIKE '%$search%'");
                                }


                                if (isset($_POST['submitfilter'])) {
                                    if (!empty($_POST['numbervalue'])) {
                                        $number_value = $_POST['numbervalue'];
                                        $filtertype = $_POST['filtertype'];
                                        $sort = $_POST['sort'];
                                        echo "<h4>Results for $filtertype $sort $number_value :</h4>";
                                        $select = mysqli_query($connection, "SELECT * FROM tb_barang WHERE $filtertype $sort $number_value");
                                    } else {
                                        echo "<script> document.location = window.location.href; </script>";
                                    }
                                }

                                if (isset($_POST['submitorder'])) {
                                    $idbarang = $_POST['order_idbarang'];
                                    $namapembeli = $_POST['order_namapembeli'];
                                    $jumlahbeli = $_POST['order_jumlahbeli'];
                                    mysqli_query($connection, "CALL order_barang($idbarang, $jumlahbeli, '$namapembeli')");
                                    echo "<script> document.location = window.location.href; </script>";
                                }

                                $count_number = 0;
                                while ($data = mysqli_fetch_array($select)) {
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
                                            <td>
                                                <button type='button' style='width:90px;' class='btn btn-success' data-bs-toggle='modal' data-bs-target='#editbarang" . $data['id_barang'] . "'> <i class='far fa-edit pr-5'></i>Edit</button> | 
                                                <button type='button' style='width:100px;' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#orderbarang" . $data['id_barang'] . "'> <i class='fas fa-shopping-cart pr-5'></i> Order</button>
                                            </td>
                                        </tr>
                                    ";
                                ?>
                                    <!-- Pop up ORDER -->
                                    <div class="modal" id="orderbarang<?= $data['id_barang']; ?>" tabindex="-1" aria-labelledby="test12" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="mymodallabel">Order Barang : <?= $data['nama_barang']; ?></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="" method="POST">
                                                    <div class="modal-body">
                                                        <input class="form-control" name="order_idbarang" type="number" value="<?= $data['id_barang'] ?>" aria-label="input example" hidden>
                                                        <label>Nama Pembeli</label>
                                                        <input type="text" name="order_namapembeli" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" required>
                                                        <label>Jumlah Beli</label>
                                                        <input type="number" name="order_jumlahbeli" class="form-control" required>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" name="submitorder" class="btn btn-primary">Order</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div> <!-- end of pop up order -->

                                    <!-- pop up EDIT -->
                                    <div class="modal" id="editbarang<?= $data['id_barang']; ?>" tabindex="-1" aria-labelledby="test12" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editbarang_label">Edit Barang : <?= $data['nama_barang'] ?></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="" method="POST">
                                                    <div class="modal-body">
                                                        <label>ID Barang</label>
                                                        <input name="idbarang" value="<?= $data['id_barang'] ?>" hidden>
                                                        <input class="form-control" type="number" value="<?= $data['id_barang'] ?>" disabled>
                                                        <label>Nama Barang</label>
                                                        <input class="form-control" type="text" placeholder="<?= $data['nama_barang'] ?>" disabled>
                                                        <label>Supplier</label>
                                                        <input class="form-control" type="text" placeholder="<?= $data['supplier'] ?>" disabled>
                                                        <label>Brand</label>
                                                        <input class="form-control" type="text" placeholder="<?= $brand[0] ?>" disabled>
                                                        <label>Harga</label>
                                                        <input class="form-control" name="hargabarang" type="number" value="<?= $data['harga'] ?>">
                                                        <label>Stock</label>
                                                        <input type="number" class="form-control input-stok" name="stokbarang" value="<?= $data['stok'] ?>">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#hapusbarang<?= $data['id_barang']; ?>" class="btn btn-danger">Hapus Barang</button>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" name="submitUpdateBarang" class="btn btn-primary">Simpan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div><!-- end of pop up EDIT -->
                                    <!-- pop up DELETE CONFIRMATION -->
                                    <div class="modal" id="hapusbarang<?= $data['id_barang']; ?>" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editbarang_label">Yakin Ingin Hapus Barang : <?= $data['nama_barang'] ?></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="" method="POST">
                                                    <div class="modal-footer">
                                                        <input type="number" name="idbarang" value="<?= $data['id_barang'] ?>" hidden>
                                                        <button type="submit" name="submitdeletebarang" class="btn btn-danger">Hapus Barang</button>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div><!-- end of pop up DELETE CONFIRMATION -->
                                <?php } ?>
                                <!-- end of while -->
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    <th>Supplier</th>
                                    <th>Brand</th>
                                    <th>Harga</th>
                                    <th>Stok</th>
                                    <th style="width: 230px;">Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container" style="margin-left:190px;">
        <footer style="color:white; background-color:black; height:60px; width:1000px; padding-top:17px; text-align:center;">
            Copyright &copy; 2021 | Dy.id Jaya Sementara | SMBD Kelas B
        </footer>
        <br><br>
    </div>
</div>