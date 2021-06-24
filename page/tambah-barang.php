<?php
$select_tbbrand = mysqli_query($connection, "SELECT * FROM tb_brand");
if (isset($_POST['submitbarang'])) {
    $nama_barang = $_POST['namabarang'];
    $nama_supplier = $_POST['namasupplier'];
    $nama_brand = $_POST['selectbrand'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    $cek_brand = mysqli_query($connection, "SELECT * FROM tb_brand WHERE nama_brand = '$nama_brand'");
    $count_brand = 0;
    foreach ($cek_brand as $data) {
        $count_brand++;
    }
    if (!empty($cek_brand)) {
        foreach ($cek_brand as $data) {
            $cek_brand = $data['id_brand'];
        }
        if ($count_brand == 1) {
            mysqli_query($connection, "CALL tambah_barang('$cek_brand', '$nama_barang', '$nama_supplier', $harga, $stok)");
        } else {
            $id_brand = mysqli_query($connection, "SELECT id_brand FROM tb_brand ORDER BY id_brand DESC LIMIT 1");
            foreach ($id_brand as $data) {
                $id_brand = $data['id_brand'];
            }
            $id_brand = (int) filter_var($id_brand, FILTER_SANITIZE_NUMBER_INT);
            $id_brand++;
            $id_brand = strval("C" . $id_brand);
            mysqli_begin_transaction($connection);
            mysqli_query($connection, "INSERT INTO tb_brand VALUES('$id_brand', '$nama_brand')");
            mysqli_query($connection, "CALL tambah_barang('$id_brand', '$nama_barang', '$nama_supplier', $harga, $stok)");
            if (mysqli_commit($connection)) {
                echo "<script> alert('Berhasil menambahkan barang dengan nama : " . $nama_barang . "');</script>";
            } else {
                mysqli_rollback($connection);
                echo "<script> alert('Gagal menambahkan barang!');</script>";
            }
        }
    }
}
?>
<div class="main">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="card">
                    <div class="card-header" style="text-align:center; padding:20px">
                        <h1>Tambah Barang</h1>
                    </div>
                    <form class="col-10" style="padding-left:150px" action="" method="POST">
                        <div class="card-body">
                            <label style="padding-bottom: 10px;">Nama barang</label>
                            <input name="namabarang" class="form-control" type="text" placeholder="Masukkan nama barang baru" required>
                            <br>
                            <label style="padding-bottom: 10px;">Supplier</label>
                            <input name="namasupplier" class="form-control" type="text" placeholder="Masukkan nama supplier" required>
                            <br>
                            <label style="padding-bottom: 10px;">Brand</label>
                            <input name="selectbrand" list="listbrand" class="form-control" placeholder="Masukkan nama brand" data-live-search="true" required>
                            <datalist id="listbrand">
                                <?php foreach ($select_tbbrand as $data) { ?>
                                    <option value="<?= $data['nama_brand'] ?>"><?= $data['nama_brand'] ?></option>
                                <?php } ?>
                            </datalist>
                            <br>
                            <label style="padding-bottom: 10px;">Harga</label>
                            <input name="harga" class="form-control" type="text" placeholder="contoh : 9000000" required>
                            <br>
                            <label style="padding-bottom: 10px;">Stok</label>
                            <input name="stok" type="text" class="form-control" required>
                        </div>
                        <div class="col-12" style="text-align: center;">
                            <div style="padding: 20px; text-align:center;">
                                <button type="submit" name="submitbarang" class="btn btn-primary"><i class="fas fa-save pr-15"></i>Simpan</button>
                                <button type="reset" name="reset" class="btn btn-danger"><i class="fas fa-trash-restore pr-15"></i>Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>