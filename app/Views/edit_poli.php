<?= $this->extend('./templates/indexEdit'); ?>

<?= $this->section('page-content'); ?>

<div class="card shadow">
    <div class="row card-header p-2 m-0">
        <div class="col-lg-6 col-xl-6 col-md-6 col-xs-6 col-sm-6 col-6">
            <h4 class="mt-2">Edit Data Poli</h4>
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
        <form method="POST" action="<?= base_url('update_poli/' . $datapoli['id']); ?>">
            <?= csrf_field(); ?>
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="kode_poliLama" value="<?= $datapoli['kode_poli']; ?>">
            <input type="hidden" name="namaLama" value="<?= $datapoli['nama_poli']; ?>">
            <input type="hidden" name="maksimalLama" value="<?= $datapoli['kapasitas']; ?>">

            <div class="row pb-4">
                <div class="col-lg-6 col-xl-6 col-md-6 col-xs-12 col-sm-12 col-12">
                    <h6><b>Data Lama</b></h6>
                    <div class="mb-2">
                        <label class="form-label" for="nikold"><b>Kode Poli</b></label>
                        <input type="text" id="kode_poliold" name="kode_poliold" class="form-control" value="<?= $datapoli['kode_poli']; ?>" disabled>
                    </div>

                    <div class="mb-2">
                        <label class="form-label" for="namaold"><b>Nama Poli</b></label>
                        <input type="text" id="namaold" name="namaold" class="form-control" value="<?= $datapoli['nama_poli'] ?>" disabled>
                    </div>

                    <div class="mb-2">
                        <label class="form-label" for="maksimalold"><b>Maksimal</b></label>
                        <input type="text" id="maksimalold" name="maksimalold" class="form-control" value="<?= $datapoli['kapasitas']; ?>" disabled>
                    </div>
                </div>

                <div class="col-lg-6 col-xl-6 col-md-6 col-xs-12 col-sm-12 col-12">
                    <h6><b>Data Baru</b></h6>
                    <div class="mb-2">
                        <label class="form-label" for="kode_poli"><b>Kode Poli</b></label>
                        <input type="text" id="kode_poli" name="kode_poli" maxlength="16" class="form-control <?php if (session('validation.kode_poli')) : ?> is-invalid <?php endif ?>" autofocus placeholder="Masukan Kode Poli" value="<?= old('kode_poli'); ?>">
                        <div class="invalid-feedback">
                            <?= session('validation.kode_poli'); ?>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label class="form-label" for="nama"><b>Nama Poli</b></label>
                        <input type="text" id="nama" name="nama" maxlength="100" class="form-control <?php if (session('validation.nama')) : ?> is-invalid <?php endif ?>" placeholder="Masukan Nama Poli" value="<?= old('nama'); ?>">
                        <div class="invalid-feedback">
                            <?= session('validation.nama'); ?>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label class="form-label" for="maksimal"><b>Batas Maksimal</b></label>
                        <input type="number" id="maksimal" max="100" min="0" name="maksimal" class="form-control <?php if (session('validation.maksimal')) : ?> is-invalid <?php endif ?>" autofocus placeholder="Masukan Batas Maksimal" value="<?= old('kapasitas'); ?>">
                        <div class="invalid-feedback">
                            <?= session('validation.maksimal'); ?>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-warning">Update</button>
        </form>
    </div>
</div>
<?= $this->endSection(); ?>