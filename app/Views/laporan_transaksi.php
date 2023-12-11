<?= $this->extend('./templates/index'); ?>

<?= $this->section('page-content'); ?>

<?php if (session()->getFlashdata('error')) { ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Maaf,</strong> <?= session()->getFlashdata('error'); ?>.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php } ?>

<?php if (session()->getFlashdata('success')) { ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Berhasil,</strong> <?= session()->getFlashdata('success'); ?>.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php } ?>

<div class="card shadow">
    <div class="row card-header p-2 m-0">
        <div class="col-lg-6 col-xl-6 col-md-6 col-xs-6 col-sm-6 col-6">
            <h4 class="py-2 mt-2">Daftar Laporan Transaksi</h4>
        </div>

        <div class="col-lg-6 col-xl-6 col-md-6 col-xs-6 col-sm-6 col-6" align="right">
            <a href="javascript:history.back();" class="btn btn-dark btn-sm btn-icon-split mt-2">
                <span class="icon text-white-50"><i class="fas fa-backward"></i></span>
                <span class="text p-1">Kembali</span>
            </a>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive margin-tb">
            <table class="table table-hover display nowrap w-100" id="datatabel" cellspacing="0">
                <thead>
                    <tr class="first even" style="text-shadow: none; cursor: pointer;">
                        <th style="text-align: center; vertical-align: middle; margin: 5px; padding: 7px;">NO</th>
                        <th style="text-align: center; vertical-align: middle; margin: 5px; padding: 7px;">TANGGAL TRANSAKSI</th>
                        <th style="text-align: center; vertical-align: middle; margin: 5px; padding: 7px;">KODE TRANSAKSI</th>
                        <th style="text-align: center; vertical-align: middle; margin: 5px; padding: 7px;">NAMA PASIEN</th>
                        <th style="text-align: center; vertical-align: middle; margin: 5px; padding: 7px;">METODE PEMBAYARAN</th>
                        <th style="text-align: center; vertical-align: middle; margin: 5px; padding: 7px;">TOTAL BIAYA</th>
                        <th style="text-align: center; vertical-align: middle; margin: 5px; padding: 7px;">AKSI</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $nomor = 1; ?>
                    <?php foreach ($report as $value) : ?>
                        <tr style="vertical-align: middle; text-align: center; text-shadow: none;">
                            <td style="margin: 5px; padding: 3px; text-align: center;"><?= $nomor++; ?></td>
                            <td style="margin: 5px; padding: 3px; text-align: center;"><?= date('d/m/Y', strtotime($value["created_at"])); ?></td>
                            <td style="margin: 5px; padding: 3px; text-align: center;"><?= $value["kode_transaksi"]; ?></td>
                            <td style="margin: 5px; padding: 3px; text-align: justify;"><?= strtoupper($value["nama"]); ?></td>
                            <td style="margin: 5px; padding: 3px; text-align: center;"><?= strtoupper($value["metode_pembayaran"]); ?></td>
                            <td style="margin: 5px; padding: 3px; text-align: right;"><?= number_format($value["total_biaya"], 0, ',', '.'); ?></td>
                            <td style="margin: 5px; padding: 3px; text-align: center;">
                                <a href="<?= base_url('detail_laporan/' . $value['id']) ?>" class="btn btn-info" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Detail">
                                    <span class='icon'><i class='fas fa-eye'></i></span>
                                </a>
                                <button onclick="cetaklaporan(<?= $value['id'] ?>)" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Print">
                                    <span class='icon'><i class='fas fa-print'></i></span>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function cetaklaporan(id) {
        // Simpan data ke penyimpanan lokal atau variabel global
        const idTransaksi = sessionStorage.setItem('idTransaksi', id);

        console.log(JSON.stringify(idTransaksi))

        // Buka laporan.php
        window.location.href = '<?= base_url('laporanTransaksi/') ?>' + id;
    }
</script>

<?= $this->endSection(); ?>