<!-- app/Views/nomor_antrian.php -->

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
    <div class="row card-header p-2 m-0 align-items-center">
        <div class="col-lg-6 col-xl-6 col-md-6 col-xs-6 col-sm-6 col-6">
            <h4 class="py-2 mt-2">Daftar Nomor Antrian</h4>
        </div>

        <div class="col-lg-6 col-xl-6 col-md-6 col-xs-6 col-sm-6 col-6">
            <!-- Dropdown jenis poli -->
            <select id="jenispoli" class="form-select">
                <option value="" selected>Pilih Jenis Poli</option>
                <?php foreach ($poli as $jenis) : ?>
                    <option value="<?= $jenis['kode_poli']; ?>"><?= $jenis['nama_poli']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="card-body">
        <!-- Tabel daftar nomor antrian -->
        <div class="table-responsive margin-tb">
            <table class="table table-hover display nowrap w-100" id="datatabel" cellspacing="0">
                <thead>
                    <tr>
                        <th style="margin: 5px; padding: 3px; text-align: center;">No</th>
                        <th style="margin: 5px; padding: 3px; text-align: center;">Tanggal</th>
                        <th style="margin: 5px; padding: 3px; text-align: center;">Kode Poli</th>
                        <th style="margin: 5px; padding: 3px; text-align: center;">Nama Poli</th>
                        <th style="margin: 5px; padding: 3px; text-align: center;">Antrian Waiting</th>
                        <th style="margin: 5px; padding: 3px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data tabel akan diisi menggunakan JavaScript -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Fungsi untuk memperbarui tabel berdasarkan jenis poli yang dipilih
        function updateTableByJenisPoli(jenisPoli) {
            // URL ke server untuk mendapatkan data berdasarkan jenis poli
            var url = '<?= base_url('fetchDataByJenisPoli') ?>';

            // Kirim jenis poli yang dipilih ke server menggunakan Ajax
            $.ajax({
                url: url,
                data: {
                    jenis_poli: jenisPoli
                },
                method: 'POST',
                dataType: 'json',
                success: function(data) {
                    // Tambahkan log
                    console.log('Data yang diterima dari server:', data);

                    // Bersihkan tabel
                    $('#datatabel tbody').empty();

                    // Perbarui tabel dengan data yang diterima dari server
                    if (data.length > 0) {
                        $.each(data, function(index, value) {
                            // Konstruksi baris tabel baru
                            var row = '<tr style="vertical-align: middle; text-align: center; text-shadow: none;">';
                            row += '<td style="margin: 5px; padding: 3px; text-align: center;">' + (index + 1) + '</td>';
                            row += '<td style="margin: 5px; padding: 3px; text-align: center;">' + value.tanggal + '</td>';
                            row += '<td style="margin: 5px; padding: 3px; text-align: center;">' + value.kode_poli + '</td>';
                            row += '<td style="margin: 5px; padding: 3px; text-align: center;">' + value.nama_poli + '</td>';
                            row += '<td style="margin: 5px; padding: 3px; text-align: center;">' + value.nomor_antrian + '</td>';
                            row += '<td style="margin: 5px; padding: 3px; text-align: center;">';
                            row += '<a href="<?= base_url('antrian_selesai/') ?>' + value.nomor_antrian + '/' + value.id + '" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Proses">';
                            row += '<span class="icon"><i class="fas fa-check"></i></span>';
                            row += '</a>';
                            row += '</td>';

                            // Tambahkan baris ke tabel
                            $('#datatabel tbody').append(row);
                        });
                    } else {
                        // Tampilkan pesan jika tidak ada data
                        $('#datatabel tbody').append('<tr><td colspan="6" style="text-align: center;">Tidak ada data tersedia</td></tr>');
                    }
                },
                error: function(xhr, status, error) {
                    // Tambahkan log
                    console.error('Error:', error);
                }
            });
        }

        // Event listener untuk perubahan pada dropdown jenis poli
        $('#jenispoli').on('change', function() {
            var selectedJenisPoli = $(this).val();
            // Tambahkan log
            console.log('Jenis Poli yang dipilih:', selectedJenisPoli);
            updateTableByJenisPoli(selectedJenisPoli);
        });
    });
</script>


<?= $this->endSection(); ?>