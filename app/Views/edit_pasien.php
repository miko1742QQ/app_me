<?= $this->extend('./templates/indexEdit'); ?>

<?= $this->section('page-content'); ?>

<div class="card shadow">
    <div class="row card-header p-2 m-0">
        <div class="col-lg-6 col-xl-6 col-md-6 col-xs-6 col-sm-6 col-6">
            <h4 class="mt-2">Edit Data Pasien</h4>
        </div>

        <div class="col-lg-6 col-xl-6 col-md-6 col-xs-6 col-sm-6 col-6" align="right">
            <a href="../daftar_pasien" class="btn btn-success btn-sm btn-icon-split mt-2">
                <span class="icon text-white-50"><i class="fas fa-list"></i></span>
                <span class="text p-1">List</span>
            </a>
        </div>
    </div>

    <div class="card-body">
        <!-- Basic Layout -->
        <form method="POST" action="<?= base_url('update_pasien/' . $datapasien['id']); ?>" enctype="multipart/form-data">
            <?= csrf_field(); ?>
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="nikLama" value="<?= $datapasien['nik']; ?>">
            <input type="hidden" name="namaLama" value="<?= $datapasien['nama']; ?>">
            <input type="hidden" name="jenkelLama" value="<?= $datapasien['id_jekel']; ?>">
            <input type="hidden" name="tempat_lahirLama" value="<?= $datapasien['tempat_lahir']; ?>">
            <input type="hidden" name="tanggal_lahirLama" value="<?= $datapasien['tanggal_lahir']; ?>">
            <input type="hidden" name="alamatLama" value="<?= $datapasien['alamat']; ?>">
            <input type="hidden" name="no_telpLama" value="<?= $datapasien['telp']; ?>">

            <div class="row pb-4">
                <div class="col-lg-6 col-xl-6 col-md-6 col-xs-12 col-sm-12 col-12">
                    <h6><b>Data Lama</b></h6>
                    <div class="mb-2">
                        <label class="form-label" for="nikold"><b>NIK</b></label>
                        <input type="text" id="nikold" name="nikold" class="form-control" value="<?= $datapasien['nik']; ?>" disabled>
                    </div>

                    <div class="mb-2">
                        <label class="form-label" for="namaold"><b>Nama Pasien</b></label>
                        <input type="text" id="namaold" name="namaold" class="form-control" value="<?= $datapasien['nama'] ?>" disabled>
                    </div>

                    <div class="mb-2">
                        <label class="form-label" for="jenkelold"><b>Jenis Kelamin</b></label>
                        <select name="jenkelold" id="jenkelold" class="form-select" disabled>
                            <option value="" disabled>Pilih Jenis Kelamin</option>
                            <?php foreach ($jeniskelamin as $value) : ?>
                                <option value="<?= $value['id']; ?>" <?= $datapasien['id_jekel'] == $value['id'] ? 'selected' : null ?>>
                                    <?= $value['nama_jenis']; ?>
                                </option>"
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="mb-2">
                        <label class="form-label" for="tempat_lahirold"><b>Tempat Lahir</b></label>
                        <input type="text" id="tempat_lahirold" name="tempat_lahirold" class="form-control" value="<?= $datapasien['tempat_lahir']; ?>" disabled>
                    </div>

                    <div class="mb-2">
                        <label class="form-label" for="tanggal_lahirold"><b>Tanggal Lahir</b></label>
                        <input type="date" id="tanggal_lahirold" name="tanggal_lahirold" class="form-control" value="<?= $datapasien['tanggal_lahir']; ?>" disabled>
                    </div>

                    <div class="mb-2">
                        <label class="form-label" for="alamatold"><b>Alamat Pasien</b></label>
                        <textarea type="text" id="alamatold" name="alamatold" rows="3" class="form-control" value="<?= $datapasien['alamat']; ?>" disabled><?= $datapasien['alamat']; ?></textarea>
                    </div>

                    <div class="mb-2">
                        <label class="form-label" for="no_telpold"><b>No. Telp</b></label>
                        <input type="text" id="no_telpold" name="no_telpold" class="form-control" value="<?= $datapasien['telp']; ?>" disabled>
                    </div>
                </div>

                <div class="col-lg-6 col-xl-6 col-md-6 col-xs-12 col-sm-12 col-12">
                    <h6><b>Data Baru</b></h6>
                    <div class="mb-2">
                        <label class="form-label" for="nik"><b>NIK</b></label>
                        <input type="text" id="nik" name="nik" maxlength="16" class="form-control <?php if (session('validation.nik')) : ?> is-invalid <?php endif ?>" autofocus placeholder="Masukan NIK Pasien" value="<?= old('nik'); ?>">
                        <div class="invalid-feedback">
                            <?= session('validation.nik'); ?>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label class="form-label" for="nama"><b>Nama Pasien</b></label>
                        <input type="text" id="nama" name="nama" maxlength="100" class="form-control <?php if (session('validation.nama')) : ?> is-invalid <?php endif ?>" placeholder="Masukan Nama Pasien" value="<?= old('nama'); ?>">
                        <div class="invalid-feedback">
                            <?= session('validation.nama'); ?>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label class="form-label" for="jenkel"><b>Jenis Kelamin</b></label>
                        <select name="jenkel" id="jenkel" class="form-select <?php if (session('validation.jenkel')) : ?> is-invalid <?php endif ?>">
                            <option value="" disabled selected>Pilih Jenis Kelamin</option>
                            <?php foreach ($jeniskelamin as $value) : ?>
                                <option value="<?= $value['id']; ?>" <?= old('jenkel') == $value['id'] ? 'selected' : null ?>><?= $value['nama_jenis']; ?></option>"
                            <?php endforeach ?>
                        </select>
                        <div class="invalid-feedback">
                            <?= session('validation.jenkel'); ?>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label class="form-label" for="tempat_lahir"><b>Tempat Lahir</b></label>
                        <input type="text" id="tempat_lahir" name="tempat_lahir" maxlength="100" class="form-control <?php if (session('validation.tempat_lahir')) : ?> is-invalid <?php endif ?>" placeholder="Masukan Tempat Lahir Pasien" value="<?= old('tempat_lahir'); ?>">
                        <div class="invalid-feedback">
                            <?= session('validation.tempat_lahir'); ?>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label class="form-label" for="tanggal_lahir"><b>Tanggal Lahir</b></label>
                        <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="form-control <?php if (session('validation.tanggal_lahir')) : ?> is-invalid <?php endif ?>" value="<?= old('tanggal_lahir'); ?>">
                        <div class="invalid-feedback">
                            <?= session('validation.tempat_lahir'); ?>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label class="form-label" for="alamat"><b>Alamat Pasien</b></label>
                        <textarea type="text" id="alamat" name="alamat" rows="3" maxlength="100" class="form-control <?php if (session('validation.alamat')) : ?> is-invalid <?php endif ?>" placeholder="Masukan Alamat Pasien" value="<?= old('alamat'); ?>"><?= old('alamat'); ?></textarea>
                        <div class="invalid-feedback">
                            <?= session('validation.alamat'); ?>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label class="form-label" for="no_telp"><b>No. Telp</b></label>
                        <input type="text" id="no_telp" name="no_telp" maxlength="15" class="form-control <?php if (session('validation.no_telp')) : ?> is-invalid <?php endif ?>" placeholder="Masukan No. Telp Pasien" value="<?= old('no_telp'); ?>">
                        <div class="invalid-feedback">
                            <?= session('validation.no_telp'); ?>
                        </div>
                    </div>

                </div>
            </div>

            <button type="submit" class="btn btn-warning">Update</button>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#jenkelold').select2();
        $('#jenkel').select2();
    });
</script>
<?= $this->endSection(); ?>