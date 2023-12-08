<?= $this->extend('./templates/index'); ?>

<?= $this->section('page-content'); ?>

<div class="card shadow">
    <div class="row card-header p-2 m-0">
        <div class="col-lg-6 col-xl-6 col-md-6 col-xs-6 col-sm-6 col-6">
            <h4 class="mt-2">Tambah Data Poli</h4>
        </div>

        <div class="col-lg-6 col-xl-6 col-md-6 col-xs-6 col-sm-6 col-6" align="right">
            <a href="../daftar_poli" class="btn btn-success btn-sm btn-icon-split mt-2">
                <span class="icon text-white-50"><i class="fas fa-list"></i></span>
                <span class="text p-1">List</span>
            </a>
        </div>
    </div>

    <div class="card-body">
        <!-- Basic Layout -->
        <form method="POST" action="save_poli">
            <?= csrf_field(); ?>
            <div class="row pb-4">
                <div class="mb-2">
                    <label class="form-label" for="kode_poli"><b>Kode Poli</b></label>
                    <input type="text" id="kode_poli" name="kode_poli" maxlength="16" class="form-control <?php if (session('validation.kode_poli')) : ?> is-invalid <?php endif ?>" autofocus placeholder="Masukan Kode Poli" value="<?= old('kode_poli'); ?>">
                    <div class="invalid-feedback">
                        <?= session('validation.kode_poli'); ?>
                    </div>
                </div>

                <div class="mb-2">
                    <label class="form-label" for="nama"><b>Nama Poli</b></label>
                    <input type="text" id="nama" name="nama" maxlength="100" class="form-control <?php if (session('validation.nama')) : ?> is-invalid <?php endif ?>" placeholder="Masukan Nama Pasien" value="<?= old('nama'); ?>">
                    <div class="invalid-feedback">
                        <?= session('validation.nama'); ?>
                    </div>
                </div>

                <div class="mb-2">
                    <label class="form-label" for="maksimal"><b>Batas Maksimal</b></label>
                    <input type="number" id="maksimal" max="100" min="0" name="maksimal" class="form-control <?php if (session('validation.maksimal')) : ?> is-invalid <?php endif ?>" autofocus placeholder="Masukan Batas Maksimal" value="<?= old('maksimal'); ?>">
                    <div class="invalid-feedback">
                        <?= session('validation.maksimal'); ?>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</div>
<?= $this->endSection(); ?>