<?= $this->extend('./templates/indexAntrian'); ?>

<?= $this->section('page-content'); ?>

<div class="row">
    <div class="col-lg-9 col-xl-9 col-md-9 col-xs-12 col-sm-12 col-12">
        <div class="containerBranch">
            <span>SELAMAT DATANG DI PUSKESMAS X KOTA PADANG</span>
            <span>Jl. Lubuk Begalung</span>
        </div>

        <div class="containerBidangPoli" id="containerBidangPoli">
            <?php foreach ($poli as $p) : ?>
                <div class="cardNomorAntrian" data-id="<?= $p['id'] ?>">
                    <span><?= $p['nama_poli'] ?></span>
                    <button class="ambilnomor">Ambil Nomor Antrian</button>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="col-lg-3 col-xl-3 col-md-3 col-xs-12 col-sm-12 col-12">
        <div class="containerNomorAntrian" id="containerNomorAntrian">
            <div class="header-container">
                <img src="../../logopuskesmas.png" alt="" width="100">
                <div class="info-container">
                    <span id="tanggal"></span>
                    <span id="waktu"></span>
                </div>
            </div>

            <div class="row container_dataAntrian">
                <div class="col-lg-12 col-xl-12 col-md-12 col-xs-12 col-sm-12 col-12">
                    <div class="table-responsive">
                        <table class="table" id="datatabel1">
                            <thead>
                                <tr>
                                    <th>BIDANG POLI</th>
                                    <th>ANTRIAN SELANJUTNYA</th>
                                </tr>
                            </thead>

                            <tbody>
                                <!-- Data tabel akan diisi menggunakan JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="container_nomorantrianberjalan" id="container_nomorantrianberjalan"></div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ambilNomorBtns = document.querySelectorAll('.ambilnomor');
        const nomorAntrianBerjalanContainer = document.getElementById('container_nomorantrianberjalan');
        var tanggalElement = document.getElementById('tanggal');
        var waktuElement = document.getElementById('waktu');

        // // Fungsi untuk memeriksa kapasitas setiap detik
        // function checkKapasitas() {
        //     fetch('fetch-kapasitas') // Ganti dengan URL atau metode lain yang sesuai
        //         .then(response => response.json())
        //         .then(data => {
        //             ambilNomorBtns.forEach(btn => {
        //                 const idPoli = btn.closest('.cardNomorAntrian').dataset.id;
        //                 const kapasitas = data.find(item => item.id === parseInt(idPoli)).kapasitas;
        //                 const antrian_waiting = data.find(item => item.id === parseInt(idPoli)).antrian_waiting;

        //                 // Aktifkan atau nonaktifkan tombol berdasarkan kapasitas
        //                 btn.disabled = kapasitas <= antrian_waiting;
        //             });
        //         })
        //         .catch(error => console.error('Error fetching kapasitas:', error));
        // }

        // // Pertama kali, panggil fungsi pemeriksa kapasitas
        // checkKapasitas();

        // // Selanjutnya, atur pembaruan kapasitas setiap detik
        // setInterval(checkKapasitas, 1000);

        function updateTableData() {
            fetch('fetch-nomor-antrian-selanjutnya') // Ganti dengan URL atau metode lain yang sesuai
                .then(response => response.json())
                .then(data => {
                    // Hapus data lama dari tabel
                    const tableBody = document.querySelector('#datatabel1 tbody');
                    tableBody.innerHTML = '';

                    // Tambahkan data baru ke tabel
                    data.forEach(item => {
                        const row = document.createElement('tr');
                        row.innerHTML = `<td>${item.nama_poli}</td><td>${parseInt(item.antrian_end) + 1}</td>`;
                        tableBody.appendChild(row);
                    });
                })
                .catch(error => console.error('Error fetching data:', error));
        }

        updateTableData();

        // Setel interval untuk memperbarui data setiap detik
        setInterval(updateTableData, 1000);

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
        nomorAntrianBerjalanContainer.innerHTML = storedNomorAntrianBerjalan || '';

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
                        console.log(JSON.stringify(data.error))
                        const cardContainer = btn.closest('.cardNomorAntrian');
                        cardContainer.innerHTML += `
                        <div class="error-container">
                            <p class="ambilnomor text-danger font-weight-bold">${data.error}</p>
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

                        // Store data in sessionStorage
                        sessionStorage.setItem('nomorAntrianBerjalan', nomorAntrianBerjalanContainer.innerHTML);

                        // Set timeout to activate animation effect
                        setTimeout(() => {
                            nomorAntrianBerjalanContainer.querySelector('.container_nomorantrianberjalan').style.opacity = 1;
                        }, 10);
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