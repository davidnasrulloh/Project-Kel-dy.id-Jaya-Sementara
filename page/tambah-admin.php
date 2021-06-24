<?php
$select_tbadmin = mysqli_query($connection, "SELECT * FROM tb_admin");
if (isset($_POST['submitadmin'])) {
    if (tambahadmin($_POST) > 0) {
        echo "
                        <script> 
                            alert('data admin berhasil ditambah :)');
                        </script>	
                    ";
    } else {
        echo "
                        <script> 
                            alert('data gagal ditambahkan :)');
                        </script>	
                    ";
    }
}
?>
<div class="main">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="card">
                    <div class="card-header" style="text-align:center; padding:20px">
                        <div style="display: flex;">
                            <div style="width:30%; text-align:left; padding-top:10px;">
                                <div>
                                    <a type="button" href="index.php?page=kelola-admin" target="" class="btn btn-secondary"><i class="fas fa-cogs pr-15"></i>Kelola My Acount</a>
                                </div>
                            </div>
                            <div style="width:60%; text-align: center;">
                                <h1>Tambah Admin Baru</h1>
                            </div>
                        </div>
                    </div>
                    <form class="col-10" style="padding-left:150px" action="" method="POST">
                        <div class="card-body">
                            <label style="padding-bottom: 10px;">Username</label>
                            <input name="username" class="form-control" type="text" placeholder="Masukkan username baru" required>
                            <br>
                            <label style="padding-bottom: 10px;">Password</label>
                            <input name="password" class="form-control" type="password" placeholder="Masukkan password" required>
                            <br>
                            <label style="padding-bottom: 10px;">Konfirmasi Password</label>
                            <input name="password2" class="form-control" type="password" placeholder="Masukkan konfirmasi password" required>
                            <br>
                            <label style="padding-bottom: 10px;">Nama</label>
                            <input name="nama" list="listadmin" class="form-control" placeholder="Masukkan nama admin baru" data-live-search="true" required>
                        </div>
                        <div class="col-12" style="text-align: center;">
                            <div style="padding: 20px; text-align:center;">
                                <button type="submit" name="submitadmin" class="btn btn-primary"><i class="fas fa-save pr-15"></i>Simpan</button>
                                <button type="reset" name="reset" class="btn btn-danger"><i class="fas fa-trash-restore pr-15"></i>Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>