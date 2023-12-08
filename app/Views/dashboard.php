<?= $this->extend('./templates/index'); ?>

<?= $this->section('page-content'); ?>
<?php if (session()->getFlashdata('status')) {
?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Selamat</strong> <?= session()->getFlashdata('status'); ?>.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php
} ?>

<div class="row">
    <!-- Overview -->
    <div class="col-lg-6 col-sm-6 mb-4">
        <div class="card bg-success">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-10 col-sm-10 mb-4 text-white">
                        <h5 class="text-white">Username : <?= user()->email ?></h5>
                        <span class="text-white">
                            <?php if (in_groups('Admin')) : ?>Admin<?php endif ?>
                            <?php if (in_groups('Pimpinan')) : ?>Pimpinan<?php endif ?>
                            <?php if (in_groups('Karyawan')) : ?>Karyawan<?php endif ?>
                        </span>
                    </div>
                    <div class="col-lg-2 col-sm-2 mb-4 text-white" align="right">
                        <i class="menu-icon tf-icons ti ti-user" style="font-size: 60px;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Overview -->

    <!-- Overview -->
    <div class="col-lg-6 col-sm-6 mb-4">
        <div class="card bg-success">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 col-sm-6 mb-4 text-white">
                        <h5 class="text-white">Total Pasien</h5>
                        <span class="text-white"><?= count($pasien) ?> Orang</span>
                    </div>
                    <div class="col-lg-6 col-sm-6 mb-4 text-white" align="right">
                        <i class="menu-icon tf-icons ti ti-user" style="font-size: 60px;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Overview -->
</div>
<?= $this->endSection(); ?>