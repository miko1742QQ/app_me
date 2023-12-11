<?= $this->extend('./templates/indexEdit'); ?>

<?= $this->section('page-content'); ?>

<div class="card shadow">
    <div class="row card-header p-2 m-0">
        <div class="col-lg-6 col-xl-6 col-md-6 col-xs-6 col-sm-6 col-6">
            <h4 class="mt-2">Detail Transaksi</h4>
        </div>

        <div class="col-lg-6 col-xl-6 col-md-6 col-xs-6 col-sm-6 col-6" align="right">
            <a href="../laporan_transaksi" class="btn btn-success btn-sm btn-icon-split mt-2">
                <span class="icon text-white-50"><i class="fas fa-list"></i></span>
                <span class="text p-1">List</span>
            </a>
        </div>
    </div>

    <div class="card-body">
        <div class="d-flex flex-row gap-4">
            <div class="d-flex flex-column">
                <span><b>Kode Transaksi</b></span>
                <span><b>Tanggal Transaksi</b></span>
                <span><b>Nama Pasien</b></span>
                <span><b>Tempat/Tanggal Lahir</b></span>
                <span><b>Alamat</b></span>
                <span><b>No. Telp</b></span>
                <span><b>Metode Pembayaran</b></span>
            </div>

            <div class="d-flex flex-column">
                <?php foreach ($detailpasien as $value) : ?>
                    <span>: <?= $value["kode_transaksi"]; ?></span>
                    <span>: <?= date('d/m/Y', strtotime($value["created_at"])); ?></span>
                    <span>: <?= strtoupper($value["nama"]); ?></span>
                    <span>: <?= strtoupper($value["tempat_lahir"]); ?>/<?= date('d M Y', strtotime($value["tanggal_lahir"])); ?></span>
                    <span>: <?= strtoupper($value["alamat"]); ?></span>
                    <span>: <?= $value["telp"]; ?></span>
                    <span>: <?= strtoupper($value["metode_pembayaran"]); ?></span>
                <?php endforeach ?>
            </div>
        </div>

        <!-- Basic Layout -->
        <div class="table-responsive margin-tb">
            <table class="table table-hover display nowrap w-100" id="datatabel" cellspacing="0">
                <thead>
                    <tr class="first even" style="text-shadow: none; cursor: pointer;">
                        <th style="text-align: center; vertical-align: middle; margin: 5px; padding: 7px;">NO</th>
                        <th style="text-align: center; vertical-align: middle; margin: 5px; padding: 7px;">NAMA OBAT</th>
                        <th style="text-align: center; vertical-align: middle; margin: 5px; padding: 7px;">JUMLAH OBAT</th>
                        <th style="text-align: center; vertical-align: middle; margin: 5px; padding: 7px;">TOTAL HARGA</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $nomor = 1; ?>
                    <?php $totalBiaya = 0; ?>
                    <?php foreach ($detailreport as $value) : ?>
                        <tr style="vertical-align: middle; text-align: center; text-shadow: none;">
                            <td style="margin: 5px; padding: 3px; text-align: center;"><?= $nomor++; ?></td>
                            <td style="margin: 5px; padding: 3px; text-align: justify;"><?= strtoupper($value["nama_obat"]); ?></td>
                            <td style="margin: 5px; padding: 3px; text-align: center;"><?= number_format($value["jumlah_obat"], 0, ',', '.'); ?></td>
                            <td style="margin: 5px; padding: 3px; text-align: right;"><?= number_format($value["total_harga"], 0, ',', '.'); ?></td>
                        </tr>
                        <?php $totalBiaya += $value["total_harga"]; ?>
                    <?php endforeach ?>
                </tbody>
                <!-- Footer Table -->
                <tfoot>
                    <tr style="vertical-align: middle; text-align: center;">
                        <td colspan="3" style="margin: 5px; padding: 3px; text-align: right;"><strong>Total Biaya</strong></td>
                        <td style="margin: 5px; padding: 3px; text-align: right;"><strong><?= number_format($totalBiaya, 0, ',', '.'); ?></strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>