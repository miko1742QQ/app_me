<?= $this->extend('./templates/indexAntrian'); ?>

<?= $this->section('page-content'); ?>

<div class="authentication-wrapper authentication-cover authentication-bg bg-success" style="width: 100%;">
    <div class="authentication-inner row">
        <div class="d-flex col-12 col-lg-12 p-sm-5 p-4">
            <div class="w-px-800 mx-auto text-center item-center">
                <h3 class="mb-4 text-white" align="center"><b>Silahkan pilih nomor antrian anda dibawah ini</b></h3>

                <div class="justify-content-center align-content-center">
                    <div class="d-flex flex-wrap mb-4" id="poli-container">
                        <?php foreach ($poli as $row) : ?>
                            <div class="card" data-id="<?= $row['id'] ?>">
                                <h3><?= $row['nama_poli'] ?></h3>
                                <p>Kapasitas: <?= $row['kapasitas'] ?></p>
                                <button class="ambil-nomor-btn btn-success">Ambil Nomor Antrian</button>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div id="nomor-antrian-berjalan-container" class="text-white" />
                </div>
            </div>
        </div>
        <!-- /Login -->
    </div>
</div>


<style>
    /* public/css/styles.css */
    .card-container {
        display: flex;
        flex-wrap: wrap;
        text-align: center;
    }

    .card {
        width: 100%;
        border: 1px solid #ddd;
        border-radius: 8px;
        margin: 5px;
        padding: 10px;
        /* Mengisi ruang yang tersedia secara merata */
    }

    .card img {
        width: 100%;
        height: auto;
    }

    .card-body {
        width: 100%;
    }

    .card-title {
        font-size: 1.5rem;
        margin-bottom: 10px;
    }

    .card-text {
        color: #666;
    }

    .btn-success {
        background-color: green;
        color: #fff;
        text-decoration: none;
        padding: 10px 15px;
        border-radius: 5px;
        display: inline-block;
    }

    /* Media query untuk tampilan mobile */
    @media screen and (max-width: 767px) {
        .card {
            width: 100%;
            display: flex;
            flex-wrap: wrap;
            /* Setiap kartu menjadi 100% lebar pada tampilan mobile */
        }
    }

    /* Media query untuk tampilan desktop */
    @media screen and (min-width: 768px) {
        .card {
            width: calc(33.333% - 20px);
            /* Mengatur lebar kartu pada tampilan desktop */
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ambilNomorBtns = document.querySelectorAll('.ambil-nomor-btn');
        const nomorAntrianBerjalanContainer = document.getElementById('nomor-antrian-berjalan-container');
        const nomorAntrianTerakhirContainer = document.getElementById('nomor-antrian-terakhir-container');

        ambilNomorBtns.forEach(btn => {
            btn.addEventListener('click', async function() {
                const idPoli = btn.closest('.card').dataset.id;
                try {
                    const response = await fetch('<?= base_url('ambil-nomor-antrian/') ?>' + parseInt(idPoli));
                    const data = await response.json();

                    if (data.error == undefined) {
                        // Tampilkan nomor antrian berjalan
                        nomorAntrianBerjalanContainer.innerHTML =
                            `<h2 class="text-white">Nomor Antrian<br> ${data.nama_poli}<br> ${data.nomor_antrian}</h2>` +
                            `<button class="btn-success" onclick="ambilNomorAntrian('${data.nama_poli}', ${data.nomor_antrian})">Cetak</button>`;

                        // Hapus elemen nomor antrian yang telah dipanggil sebelumnya
                        const nomorAntrianSebelumnya = document.querySelector('.nomor-antrian-sebelumnya');
                        if (nomorAntrianSebelumnya) {
                            nomorAntrianSebelumnya.remove();
                        }

                        // Tambahkan class 'nomor-antrian-selesai' pada elemen nomor antrian yang telah selesai
                        nomorAntrianBerjalanContainer.classList.add('nomor-antrian-selesai');
                    } else {
                        nomorAntrianBerjalanContainer.innerHTML =
                            `<h2 class="text-white"></h2>`;
                        alert('Bidang Poli Sedang Penuh');
                    }
                } catch (error) {
                    console.error('Error parsing JSON:', error);
                }
            });
        });
    });

    function ambilNomorAntrian(idPoli, namaPoli) {
        // Simpan data ke penyimpanan lokal atau variabel global
        sessionStorage.setItem('idPoli', idPoli);
        sessionStorage.setItem('namaPoli', namaPoli);

        // Buka laporan.php
        window.location.href = '<?= base_url('laporan.php') ?>';
    }
</script>
<?= $this->endSection(); ?>