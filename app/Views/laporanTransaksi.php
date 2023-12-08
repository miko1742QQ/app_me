<div class="flex">
    <div>
        <span><b>Kode Transaksi</b></span>
        <span><b>Tanggal Transaksi</b></span>
        <span><b>Nama Pasien</b></span>
        <span><b>Tempat/Tanggal Lahir</b></span>
        <span><b>Alamat</b></span>
        <span><b>No. Telp</b></span>
        <span><b>Metode Pembayaran</b></span>
    </div>

    <div>
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

<table class="table table-hover display nowrap w-100" cellspacing="0">
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
                <td style="margin: 5px; padding: 3px; text-align: center;"><?= number_format($value["jumlah_obat"], 0, ',', '.'); ?> pcs</td>
                <td style="margin: 5px; padding: 3px; text-align: right;"><?= number_format($value["total_harga"], 0, ',', '.'); ?></td>
            </tr>
            <?php $totalBiaya += $value["total_harga"]; ?>
        <?php endforeach ?>
    </tbody>
    <!-- Footer Table -->
    <tfoot>
        <tr style="vertical-align: middle; text-align: center;">
            <td colspan="3" style="margin: 5px; padding: 3px; text-align: center;"><strong>Total Biaya</strong></td>
            <td style="margin: 5px; padding: 3px; text-align: right;"><strong><?= number_format($totalBiaya, 0, ',', '.'); ?></strong></td>
        </tr>
    </tfoot>
</table>

<style>
    /* Styling for the table */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center;
    }

    th {
        background-color: #f2f2f2;
    }

    /* Styling for the footer row */
    tfoot tr {
        font-weight: bold;
        background-color: #ddd;
    }

    .flex {
        display: flex;
        align-items: flex-start;
        gap: 20px;
        width: 100%;
    }

    .flex>div {
        /* Adjust the width as needed */
        margin-bottom: 20px;
    }

    span {
        display: block;
        margin-bottom: 5px;
    }
</style>


<script>
    // Print otomatis saat halaman terbuka
    window.onload = function() {
        window.print();
        // Kembali ke halaman laporan_transaksi setelah selesai print
        setTimeout(function() {
            window.location.href = '../laporan_transaksi'; // or whatever your URL is
        }, 1000); // Set the delay in milliseconds
    };
</script>