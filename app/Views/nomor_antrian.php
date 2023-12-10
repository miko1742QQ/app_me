<?= $this->extend('./templates/indexAntrian'); ?>

<?= $this->section('page-content'); ?>

<div class="d-flex gap-4 justify-content-between p-3">
    <div class="containerBidangPoli" id="containerBidangPoli">
        <div class="containerBranch">
            <h2>SELAMAT DATANG DI PUSKESMAS X KOTA PADANG</h2>
            <h3>Jl. Lubuk Begalung</h3>
        </div>
        <?php foreach ($poli as $p) : ?>
            <div class="cardNomorAntrian" data-id="<?= $p['id'] ?>">
                <h3><?= $p['nama_poli'] ?></h3>
                <button class="ambilnomor">Ambil Nomor Antrian</button>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="containerNomorAntrian" id="containerNomorAntrian">
        <div class="header-container">
            <img src="../../logopuskesmas.png" alt="" width="100">
            <div class="info-container">
                <span id="tanggal"></span>
                <span id="waktu"></span>
            </div>
        </div>

        <div class="container_nomorantrianberjalan" id="container_nomorantrianberjalan"></div>
        <div class="container_nomorselanjutnya" id="container_nomorselanjutnya"></div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ambilNomorBtns = document.querySelectorAll('.ambilnomor');
        const nomorAntrianBerjalanContainer = document.getElementById('container_nomorantrianberjalan');
        const nomorAntrianSelanjutnyaContainer = document.getElementById('container_nomorselanjutnya');
        var tanggalElement = document.getElementById('tanggal');
        var waktuElement = document.getElementById('waktu');

        function updateWaktu() {
            var sekarang = new Date();

            var tanggal = sekarang.toLocaleDateString();
            var waktu = sekarang.toLocaleTimeString();

            tanggalElement.textContent = 'Tanggal: ' + tanggal;
            waktuElement.textContent = 'Waktu: ' + waktu;
        }

        // Pertama kali, panggil fungsi pembaruan waktu
        updateWaktu();

        // Selanjutnya, atur pembaruan waktu setiap detik
        setInterval(updateWaktu, 1000);

        // Restore data from sessionStorage
        const storedNomorAntrianBerjalan = sessionStorage.getItem('nomorAntrianBerjalan');
        const storedNomorAntrianSelanjutnya = sessionStorage.getItem('nomorAntrianSelanjutnya');
        nomorAntrianBerjalanContainer.innerHTML = storedNomorAntrianBerjalan || '';
        nomorAntrianSelanjutnyaContainer.innerHTML = storedNomorAntrianSelanjutnya || '';

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

                    if (data.error !== undefined) {
                        const cardContainer = btn.closest('.cardNomorAntrian');
                        cardContainer.innerHTML += `
                            <div class="error-container">
                                <p class="css_cetak text-danger font-weight-bold">${data.error}</p>
                            </div>
                        `;
                    } else {
                        nomorAntrianBerjalanContainer.innerHTML = `
                            <div class="container_nomorantrianberjalan">
                            <span>Nomor Antrian</span>
                            <span style="font-size: 24px">${data.nama_poli}</span>
                            <span style="font-size: 58px;">${data.nomor_antrian}</span>
                            </div>` +
                            `<button class="css_cetak cetak-btn" data-nama="${data.nama_poli}" data-nomor="${data.nomor_antrian}">Cetak Nomor Antrian</button>`;

                        nomorAntrianSelanjutnyaContainer.innerHTML = `
                            <div class="container_nomorselanjutnya">
                            <span>Antrian Selanjutnya</span>
                            <span style="font-size: 24px">${data.nama_poli}</span>
                            <span style="font-size: 58px;">${data.nomor_antrianselanjutnya}</span>
                            </div>`;

                        // Store data in sessionStorage
                        sessionStorage.setItem('nomorAntrianBerjalan', nomorAntrianBerjalanContainer.innerHTML);
                        sessionStorage.setItem('nomorAntrianSelanjutnya', nomorAntrianSelanjutnyaContainer.innerHTML);
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
<?= $this->endSection(); ?>