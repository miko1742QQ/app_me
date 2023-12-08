<?= $this->extend('./templates/index'); ?>

<?= $this->section('page-content'); ?>

<div class="card shadow">
    <div class="row card-header p-2 m-0">
        <div class="col-lg-6 col-xl-6 col-md-6 col-xs-6 col-sm-6 col-6">
            <h4 class="mt-2">Tambah Data Pengguna</h4>
        </div>

        <div class="col-lg-6 col-xl-6 col-md-6 col-xs-6 col-sm-6 col-6" align="right">
            <a href="../daftar_pengguna" class="btn btn-success btn-sm btn-icon-split mt-2">
                <span class="icon text-white-50"><i class="fas fa-list"></i></span>
                <span class="text p-1">List</span>
            </a>
        </div>
    </div>

    <div class="card-body">
        <!-- Basic Layout -->
        <form method="POST" enctype="multipart/form-data" action="<?= base_url('save_pengguna') ?>">
            <?= csrf_field(); ?>

            <input type="hidden" id="force_pass_reset" name="force_pass_reset" value="0">
            <div class="mb-3">
                <label for="nik">Karyawan</label>
                <select name="nik" id="nik" class="form-select <?php if (session('validation.nik')) : ?> is-invalid <?php endif ?>">
                    <option value="" disabled selected>Pilih Karyawan</option>
                    <?php foreach ($karyawan as $value) { ?>
                        <option value="<?= $value['nik']; ?>" <?= old('nik') == $value['nik'] ? 'selected' : null ?>><?= $value['nik']; ?>|<?= $value['nama_karyawan']; ?></option>"
                    <?php } ?>
                </select>
                <div class="invalid-feedback">
                    <?= session('validation.nik'); ?>
                </div>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control <?php if (session('validation.email')) : ?> is-invalid <?php endif ?>" id="email" name="email" maxlength="100" placeholder="Please enter email" value="<?= old('email'); ?>">
                <div class="invalid-feedback">
                    <?= session('validation.email'); ?>
                </div>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control <?php if (session('validation.username')) : ?> is-invalid <?php endif ?>" id="username" name="username" maxlength="100" aria-describedby="username" placeholder="Please enter username" value="<?= old('username'); ?>">
                <div class="invalid-feedback">
                    <?= session('validation.username'); ?>
                </div>
            </div>
            <div class="mb-3">
                <label for="id_role">Role</label>
                <select name="id_role" class="form-select <?php if (session('validation.id_role')) : ?> is-invalid <?php endif ?>" id="id_role">
                    <option value="" disabled selected>Pilih Jenis Role</option>
                    <?php foreach ($level as $value) { ?>
                        <option value="<?= $value['id']; ?>" <?= old('id_role') == $value['id'] ? 'selected' : null ?>><?= $value['name']; ?></option>"
                    <?php } ?>
                </select>
                <div class="invalid-feedback">
                    <?= session('validation.id_role'); ?>
                </div>
            </div>
            <div class="mb-3 form-password-toggle">
                <div class="d-flex justify-content-between">
                    <label class="form-label" for="password">Password</label>
                </div>
                <div class="input-group input-group-merge">
                    <input type="password" id="password_hash" class="form-control <?php if (session('validation.password_hash')) : ?> is-invalid <?php endif ?>" name="password_hash" maxlength="100" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" value="<?= old('password_hash'); ?>">
                    <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                </div>
                <div class="invalid-feedback">
                    <?= session('validation.password_hash'); ?>
                </div>
            </div>
            <div class="mb-3">
                <label for="active">Status</label>
                <select name="active" class="form-select <?php if (session('validation.active')) : ?> is-invalid <?php endif ?>" id="active">
                    <option value="" disabled selected>Pilih Status Karyawan</option>
                    <option value="1">Aktif</option>
                    <option value="0">Tidak Aktif</option>
                </select>
                <div class="invalid-feedback">
                    <?= session('validation.active'); ?>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#nik').select2();
        $('#id_role').select2();
        $('#active').select2();
    });
</script>
<?= $this->endSection(); ?>