<?= $this->extend('./templates/indexAntrian'); ?>

<?= $this->section('page-content'); ?>

<div class="container">
    <div class="card" id="nomor-antrian-card">
        <div id="nomor-antrian-terakhir-container"></div>
        <div id="nomor-antrian-berjalan-container"></div>
    </div>
</div>

<div class="containerNomorAntrian">
    <?php foreach ($poli as $p) : ?>
        <div class="cardNomorAntrian" data-id="<?= $p['id'] ?>">
            <h3 class="text-white"><?= $p['nama_poli'] ?></h3>
            <p>Kode Poli: <?= $p['kode_poli'] ?></p>
            <p>Kapasitas: <?= $p['kapasitas'] ?></p>
            <button class="ambil-nomor-btn">Ambil Nomor Antrian</button>
        </div>
    <?php endforeach; ?>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ambilNomorBtns = document.querySelectorAll('.ambil-nomor-btn');
        const nomorAntrianBerjalanContainer = document.getElementById('nomor-antrian-berjalan-container');

        nomorAntrianBerjalanContainer.addEventListener('click', function(event) {
            if (event.target.classList.contains('cetak-btn')) {
                const namaPoli = event.target.dataset.nama;
                const nomorAntrian = event.target.dataset.nomor;
                ambilNomorAntrian(namaPoli, nomorAntrian);
            }
        });

        ambilNomorBtns.forEach(btn => {
            btn.addEventListener('click', async function() {
                const idPoli = btn.closest('.cardNomorAntrian').dataset.id;

                try {
                    const response = await fetch('<?= base_url('ambil-nomor-antrian/') ?>' + parseInt(idPoli));
                    const data = await response.json();

                    console.log('Data yang diterima dari server:', data);

                    if (data.error !== undefined) {
                        const cardContainer = btn.closest('.cardNomorAntrian');
                        cardContainer.innerHTML += `
                            <div class="error-container">
                                <p class="error-message">${data.error}</p>
                            </div>
                        `;
                    } else {
                        console.log('Data yang akan ditampilkan:', data);
                        const lastProcessedQueueNumber = data.last_processed_queue_number;

                        nomorAntrianBerjalanContainer.innerHTML =
                            `
                            <div class="nomor-antrian-container">
                                <div class="d-flex">
                                    <div class="card">
                                        <span class="nomor-antrian-title text-white h-100">Nomor Antrian <br> ${data.nama_poli}</span>
                                        <p class="nomor-antrian-large-text">${data.nomor_antrian}</p>
                                    </div>

                                    <div class="card">
                                        <span class="nomor-antrian-title text-white h-100">Nomor Antrian Selanjutnya<br> ${data.nama_poli}</span>
                                        <p class="nomor-antrian-large-text">${data.nomor_antrianselanjutnya}</p>
                                    </div>
                                </div>
                            </div>
                            ` +
                            `<button class="css_cetak cetak-btn" data-nama="${data.nama_poli}" data-nomor="${data.nomor_antrian}">Cetak Nomor Antrian</button>`;

                        const nomorAntrianSebelumnya = document.querySelector('.nomor-antrian-sebelumnya');
                        if (nomorAntrianSebelumnya) {
                            nomorAntrianSebelumnya.remove();
                        }

                        nomorAntrianBerjalanContainer.classList.add('nomor-antrian-selesai');
                    }
                } catch (error) {
                    console.error('Error parsing JSON:', error);
                }
            });
        });

        function ambilNomorAntrian(namaPoli, nomorAntrian) {
            sessionStorage.setItem('namaPoli', namaPoli);
            sessionStorage.setItem('nomorAntrian', nomorAntrian);
            window.location.href = '<?= base_url('laporan.php') ?>';
        }
    });
</script>

<style>
    .container {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
    }

    .containerNomorAntrian {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
        width: 100%;
    }

    .nomor-antrian-large-text {
        font-size: 60px;
    }

    .nomor-antrian-title {
        font-size: 25px;
    }

    .card {
        width: 48%;
        box-sizing: border-box;
        margin: 10px;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 10px;
        background: linear-gradient(45deg, #4caf50, #00796b);
        color: #fff;
        position: relative;
        overflow: hidden;
        transition: transform 0.3s ease-in-out;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        text-align: center;
    }

    .card:hover {
        transform: scale(1.05);
    }

    .card::before {
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        background: linear-gradient(to bottom, rgba(255, 255, 255, 0.2), rgba(255, 255, 255, 0));
        top: 0;
        left: 0;
        z-index: -1;
        border-radius: 10px;
    }

    .cardNomorAntrian {
        margin: 10px;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 10px;
        background: linear-gradient(45deg, #4caf50, #00796b);
        color: #fff;
        position: relative;
        overflow: hidden;
        transition: transform 0.3s ease-in-out;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        text-align: center;
    }

    .cardNomorAntrian:hover {
        transform: scale(1.05);
    }

    .cardNomorAntrian::before {
        content: '';
        position: absolute;
        height: 100%;
        background: linear-gradient(to bottom, rgba(255, 255, 255, 0.2), rgba(255, 255, 255, 0));
        top: 0;
        left: 0;
        z-index: -1;
        border-radius: 10px;
    }

    .css_cetak {
        background-color: #fff;
        color: black;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s, transform 0.3s;
    }

    .css_cetak:hover {
        background-color: #00796b;
        transform: scale(1.1);
    }

    .ambil-nomor-btn {
        background-color: #fff;
        color: black;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s, transform 0.3s;
    }

    .ambil-nomor-btn:hover {
        background-color: #00796b;
        transform: scale(1.1);
    }

    .error-container {
        background-color: #ffebee;
        /* Warna latar belakang untuk pesan kesalahan */
        border: 1px solid #e57373;
        /* Warna batas untuk pesan kesalahan */
        padding: 10px;
        /* Ruang dalam untuk memberikan jarak dari batas */
        border-radius: 5px;
        /* Membuat sudut elemen menjadi sedikit melengkung */
        margin-top: 10px;
        /* Memberikan jarak dari elemen di atasnya */
    }

    .error-message {
        color: #d32f2f;
        /* Warna teks untuk pesan kesalahan */
        font-size: 16px;
        /* Ukuran font untuk pesan kesalahan */
        font-weight: bold;
        /* Menjadikan teks pesan kesalahan tebal */
        margin: 0;
        /* Menghapus margin bawaan dari elemen p */
    }

    @media (min-width: 768px) {
        .container {
            display: flex;
            flex-wrap: wrap;
        }

        .cardNomorAntrian {
            width: 48%;
        }
    }
</style>

<?= $this->endSection(); ?>