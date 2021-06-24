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
                    <div class="card-header" style="text-align: center;">
                        <h3>My Acount (Admin) | Setting Akun</h3>
                    </div>
                    <div class=" card-body">
                        <div style="padding: 10px 30px 20px 1px;">
                            <!-- <a type="button" href="cetak_lap_barang.php" target="_BLANK" class="btn btn-secondary"><i class="fas fa-print pr-15"></i>Cetak Laporan</a> -->
                        </div>
                        <table class="table table-hover table-dark" style="text-align: left;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Username</th>
                                    <th>Password</th>
                                    <th>Nama</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $id_admin = $_SESSION['id_admin'];
                                $select = mysqli_query($connection, "SELECT * FROM tb_admin WHERE id_admin = '$id_admin'");

                                // update barang
                                if (isset($_POST['submitUpdateAdmin'])) {
                                    $idadmin = $_POST['idadmin'];
                                    $username = $_POST['username'];
                                    $password = $_POST['password'];
                                    $nama = $_POST['nama'];
                                    $apakahUpdateBerhasil = mysqli_query($connection, "CALL update_admin('$idadmin', '$username', '$password', '$nama')");
                                    if (!$apakahUpdateBerhasil) {
                                        echo "<script> alert('Error!');</script>";
                                    } else {

                                        echo "<script> 
                                            alert('Update data admin berhasil!');
                                            document.location = window.location.href;
                                        </script>";
                                    }
                                }

                                // deleted barang
                                if (isset($_POST['submitdeleteadmin'])) {
                                    $idadmin = $_POST['idadmin'];
                                    // mysqli_query($connection, "DELETE FROM tb_admin WHERE id_admin = $idadmin");
                                    mysqli_query($connection, "CALL hapusadmin($idadmin)");
                                    echo "<script> document.location = window.location.href; </script>";
                                }


                                $count_number = 0;
                                while ($data = mysqli_fetch_array($select)) {
                                    $count_number++;
                                    echo "
                                        <tr role='row'>
                                            <td class='dtr-control' tabindex='0' style='border-right:1px solid white; text-align:center;'>" . $count_number . "</td>
                                            <td style='border-right:1px solid white;'>" . $data["username"] . "</td>
                                            <td style='border-right:1px solid white;'>" . $data["password_"] . "</td>
                                            <td style='border-right:1px solid white;'>" . $data["nama"] . "</td>
                                            <td style='text-align:center;' >
                                                <button type='button' style='width:90px;' class='btn btn-success' data-bs-toggle='modal' data-bs-target='#editadmin" . $data['id_admin'] . "'> <i class='far fa-edit pr-5'></i>Edit</button>
                                            </td>
                                        </tr>
                                    ";
                                ?>

                                    <!-- pop up EDIT -->
                                    <div class="modal" id="editadmin<?= $data['id_admin']; ?>" tabindex="-1" aria-labelledby="test12" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editbarang_label">Edit Data Admin : <?= $data['nama'] ?></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="" method="POST">
                                                    <div class="modal-body">
                                                        <label>ID Admin</label>
                                                        <input name="idadmin" value="<?= $data['id_admin'] ?>" hidden>
                                                        <input class="form-control" type="number" value="<?= $data['id_admin'] ?>" disabled>
                                                        <label>Username</label>
                                                        <input class="form-control" name="username" type="text" value="<?= $data['username'] ?>">
                                                        <label>Password</label>
                                                        <input class="form-control" name="password" type="text" value="<?= $data['password_'] ?>">
                                                        <label>Nama</label>
                                                        <input class="form-control" name="nama" type="text" value="<?= $data['nama'] ?>">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#hapusadmin<?= $data['id_admin']; ?>" class="btn btn-danger">Hapus Akun</button>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" name="submitUpdateAdmin" class="btn btn-primary">Simpan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div><!-- end of pop up EDIT -->

                                    <!-- pop up DELETE CONFIRMATION -->
                                    <div class="modal" id="hapusadmin<?= $data['id_admin']; ?>" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editadmin_label">Yakin Ingin Hapus Akun Admin : <?= $data['nama'] ?></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="" method="POST">
                                                    <div class="modal-footer">
                                                        <input type="number" name="idadmin" value="<?= $data['id_admin'] ?>" hidden>
                                                        <button type="submit" name="submitdeleteadmin" class="btn btn-danger">Hapus Admin</button>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div><!-- end of pop up DELETE CONFIRMATION -->
                                <?php } ?>
                                <!-- end of while -->
                            </tbody>
                            <!-- <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Username</th>
                                    <th>Password</th>
                                    <th>Nama</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot> -->
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