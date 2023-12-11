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
            <h4 class="mt-2">Transaksi</h4>
        </div>

        <div class="col-lg-6 col-xl-6 col-md-6 col-xs-6 col-sm-6 col-6" align="right">
            <a href="../" class="btn btn-success btn-sm btn-icon-split mt-2">
                <span class="icon text-white-50"><i class="fas fa-list"></i></span>
                <span class="text p-1">Kembali</span>
            </a>
        </div>
    </div>

    <div class="card-body">
        <form method="POST" action="<?= base_url('daftar_transaksi/saveTransaksi') ?>" enctype="multipart/form-data">
            <?= csrf_field(); ?>
            <div class="mb-3">
                <label for="id_pasien" class="form-label">Pasien</label>
                <select name="id_pasien" id="id_pasien" class="form-control <?php if (session('validation.id_pasien')) : ?> is-invalid <?php endif ?>">
                    <option value="" disabled selected>Pilih Pasien</option>
                    <?php foreach ($pasien as $value) : ?>
                        <option value="<?= $value['id']; ?>" <?= old('id_pasien') == $value['id'] ? 'selected' : null ?>><?= $value['nama']; ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="invalid-feedback">
                    <?= session('validation.id_pasien'); ?>
                </div>
            </div>

            <div class="mb-3">
                <label for="id_obat" class="form-label">Obat</label>
                <select name="id_obat" id="id_obat" class="form-control">
                    <option value="" disabled selected>Pilih Jenis Obat</option>
                    <?php foreach ($obat as $value) : ?>
                        <option value="<?= $value['id']; ?>" data-harga="<?= $value['harga']; ?>"><?= $value['nama_obat']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="jumlah_obat" class="form-label">Jumlah Obat</label>
                <input type="number" name="jumlah_obat" id="jumlah_obat" class="form-control">
            </div>

            <button type="button" class="btn btn-primary" onclick="addRow()">Tambah Obat</button>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#paymentModal">Proses Pembayaran</button>

            <hr>

            <!-- Tabel untuk menampilkan data obat -->
            <div class="mb-3">
                <h4>Data Obat yang Diberikan ke Pasien</h4>
                <div class="table-responsive margin-tb">
                    <table class="table table-hover display nowrap w-100" id="datatabel" cellspacing="0">
                        <thead>
                            <tr class="first even" style="text-shadow: none; cursor: pointer;">
                                <th style="text-align: center; vertical-align: middle; margin: 5px; padding: 7px;">NO</th>
                                <th style="text-align: center; vertical-align: middle; margin: 5px; padding: 7px;">NAMA OBAT</th>
                                <th style="text-align: center; vertical-align: middle; margin: 5px; padding: 7px;">JUMLAH OBAT</th>
                                <th style="text-align: center; vertical-align: middle; margin: 5px; padding: 7px;">TOTAL HARGA</th>
                                <th style="text-align: center; vertical-align: middle; margin: 5px; padding: 7px;">AKSI</th>
                            </tr>
                        </thead>

                        <tbody id="data-obat">
                            <!-- Data obat akan ditampilkan di sini -->
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-end">Total Biaya</th>
                                <th class="text-end" id="total_biaya_obat">0</th>
                                <th class="text-end"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- Modal for Payment Method -->
            <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="paymentModalLabel">Pilih Metode Pembayaran</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">BPJS</h5>
                                    <p class="card-text">Pilih metode pembayaran BPJS untuk proses pembayaran.</p>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="paymentMethod" id="bpjsMethod" value="bpjs">
                                        <label class="form-check-label" for="bpjsMethod">
                                            Pilih BPJS
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Mandiri</h5>
                                    <p class="card-text">Pilih metode pembayaran Mandiri untuk proses pembayaran.</p>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="paymentMethod" id="mandiriMethod" value="mandiri">
                                        <label class="form-check-label" for="mandiriMethod">
                                            Pilih Mandiri
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="button" class="btn btn-primary" onclick="prosesPembayaran()">Proses Pembayaran</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    // Inisialisasi variabel total biaya
    let totalBiayaObat = 0;

    // Inisialisasi array untuk menyimpan data obat
    let dataObat = [];

    function hitungTotalBiaya() {
        // Kemudian panggil fungsi untuk menampilkan data
        tampilkanDataObat();
    }

    function tampilkanDataObat() {
        // Hapus semua baris yang sudah ada di dalam tabel
        $('#data-obat tr').remove();

        // Tampilkan data obat ke dalam tabel
        dataObat.forEach(function(item, index) {
            const rowNumber = index + 1; // Calculate the row number
            const row = `<tr data-index="${index}">
                        <td class="text-center">${rowNumber}</td>
                        <td>${item.obat}</td>
                        <td class="text-center">${item.jumlah}</td>
                        <td class="text-end">${item.totalBiaya.toLocaleString('id-ID')}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-danger btn-sm" onclick="hapusBaris(${index})">Hapus</button>
                        </td>
                    </tr>`;
            $('#data-obat').append(row);
        });

        // Hitung total biaya keseluruhan
        totalBiayaObat = dataObat.reduce((total, item) => total + item.totalBiaya, 0);

        // Tampilkan total biaya keseluruhan di dalam formulir
        $('#total_biaya_obat').text(totalBiayaObat.toLocaleString('id-ID'));
    }

    function hapusBaris(index) {
        // Hapus data obat dari array berdasarkan index
        dataObat.splice(index, 1);

        // Panggil fungsi untuk menampilkan data
        tampilkanDataObat();
    }

    function addRow() {
        // Ambil nilai obat dan jumlah obat dari form
        const idObat = $('#id_obat').val();
        const obat = $('#id_obat option:selected').text();
        const jumlahObat = $('#jumlah_obat').val();
        const hargaObat = parseFloat($('#id_obat option:selected').data('harga')) || 0;

        // Validasi
        if (idObat && jumlahObat && parseInt(jumlahObat) > 0) {
            // Periksa apakah obat sudah ada di dalam array
            const existingObatIndex = dataObat.findIndex(item => item.id_obat == idObat);

            if (existingObatIndex !== -1) {
                // Jika obat sudah ada, update jumlah dan total biaya
                dataObat[existingObatIndex].jumlah = parseInt(jumlahObat);
                dataObat[existingObatIndex].totalBiaya = hargaObat * parseInt(jumlahObat);
            } else {
                // Jika obat belum ada, tambahkan ke dalam array
                const obatData = {
                    id_obat: idObat,
                    obat: obat,
                    jumlah: parseInt(jumlahObat),
                    totalBiaya: hargaObat * parseInt(jumlahObat)
                };
                dataObat.push(obatData);
            }

            // Panggil fungsi untuk menampilkan data
            tampilkanDataObat();

            // Reset input fields
            $('#id_obat').val('').trigger('change');
            $('#jumlah_obat').val('');
        } else {
            alert('Harap pilih obat dan masukkan jumlah obat yang valid.');
        }
    }

    function prosesPembayaran() {
        // Check which payment method is selected
        const selectedPaymentMethod = $("input[name='paymentMethod']:checked").val();

        // Prepare data for server
        const transaksiData = {
            id_pasien: $('#id_pasien').val(),
            total_biaya: totalBiayaObat,
            metode_pembayaran: selectedPaymentMethod,
            dataObat: dataObat,
        };

        // Send data to server using AJAX
        // Contoh penyesuaian pada AJAX request
        $.ajax({
            url: 'daftar_transaksi/saveTransaksi',
            method: 'POST',
            data: transaksiData,
            dataType: 'json',
            success: function(response) {
                console.log(response);

                if (response.success) {
                    // Transaksi berhasil, munculkan pesan Flashdata
                    alert('Transaksi berhasil dilakukan.');
                    window.location.href = '<?= base_url('/daftar_transaksi') ?>';
                } else {
                    // Transaksi gagal, munculkan pesan Flashdata
                    alert('Transaksi gagal dilakukan.');
                }
            },
            error: function(error) {
                console.error('Error saving transaction:', error);
            }
        });

        // Close the modal
        $('#paymentModal').modal('hide');
    }

    // Document ready function
    $(document).ready(function() {
        $('#id_pasien').select2();
        $('#id_obat').select2();
    });
</script>

<?= $this->endSection(); ?>