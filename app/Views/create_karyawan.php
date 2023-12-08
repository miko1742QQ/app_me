<?= $this->extend('./templates/index'); ?>

<?= $this->section('page-content'); ?>

<div class="card shadow">
    <div class="row card-header p-2 m-0">
        <div class="col-lg-6 col-xl-6 col-md-6 col-xs-6 col-sm-6 col-6">
            <h4 class="mt-2">Tambah Data Karyawan</h4>
        </div>

        <div class="col-lg-6 col-xl-6 col-md-6 col-xs-6 col-sm-6 col-6" align="right">
            <a href="../daftar_karyawan" class="btn btn-success btn-sm btn-icon-split mt-2">
                <span class="icon text-white-50"><i class="fas fa-list"></i></span>
                <span class="text p-1">List</span>
            </a>
        </div>
    </div>

    <div class="card-body">
        <!-- Basic Layout -->
        <form method="POST" action="save_karyawan">
            <?= csrf_field(); ?>
            <div class="row pb-4">
                <div class="mb-2">
                    <label class="form-label" for="nik"><b>NIK</b></label>
                    <input type="text" id="nik" name="nik" maxlength="16" class="form-control <?php if (session('validation.nik')) : ?> is-invalid <?php endif ?>" autofocus placeholder="Masukan NIK Pasien" value="<?= old('nik'); ?>">
                    <div class="invalid-feedback">
                        <?= session('validation.nik'); ?>
                    </div>
                </div>

                <div class="mb-2">
                    <label class="form-label" for="nama"><b>Nama Karyawan</b></label>
                    <input type="text" id="nama" name="nama" maxlength="100" class="form-control <?php if (session('validation.nama')) : ?> is-invalid <?php endif ?>" placeholder="Masukan Nama Pasien" value="<?= old('nama'); ?>">
                    <div class="invalid-feedback">
                        <?= session('validation.nama'); ?>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</div>
<?= $this->endSection(); ?>