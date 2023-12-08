<!-- File: public/laporan.php -->
<div style="margin: 0px; margin-left: -8px; width: 250px; text-align: center; font-family: Fake Receipt; font-size: 12px;">
    <div class="d-flex flex-wrap">
        <span style="font-size: 24px;"><b>SELAMAT DATANG</b></span><br>
        <span style="font-size: 20px;">Di Puskesmas X</span><br>
        <span style="font-size: 12px;">Jalan Kenangan Indah 4E No.16 RT.07 RW.98</span>
    </div>
    <span>====================================</span>

    <div class="d-flex flex-wrap ">
        <span style="font-size: 14px;">Tanggal :</span>
        <span id="tanggal" style="font-size: 14px;"></span><br>
        <span style="font-size: 32px;"><b>ANTRIAN</b></span> <br>
        <span id="namaPoli" style="font-size: 24px;"></span><br>
        <span id="nomorAntrian" style="font-size: 22px;"></span>
    </div>

    <span>====================================</span>

    <div style="text-align: center;">
        <span style="font-size: 26px;"><b>TERIMA KASIH</b></span>
    </div>
</div>

<script>
    // Ambil data dari penyimpanan lokal atau variabel global
    const idPoli = sessionStorage.getItem('idPoli');
    const namaPoli = sessionStorage.getItem('namaPoli');

    // Isi data pada laporan
    document.getElementById('tanggal').innerText = new Date().toLocaleDateString();
    // Ganti '123' dengan nomor antrian yang sesuai
    document.getElementById('nomorAntrian').innerText = idPoli;
    document.getElementById('namaPoli').innerText = namaPoli;

    // Print otomatis saat halaman terbuka
    window.onload = function() {
        window.print();
        // Kembali ke halaman nomor_antrian setelah selesai print
        setTimeout(function() {
            window.location.href = 'nomor_antrian'; // or whatever your URL is
        }, 1000); // Set the delay in milliseconds
    };
</script>