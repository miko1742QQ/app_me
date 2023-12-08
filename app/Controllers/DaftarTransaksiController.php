<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TransaksiModel;
use App\Models\TransaksiDetail;
use App\Models\DaftarPasienModel;
use App\Models\ObatModel;
use App\Models\DaftarKaryawanModel;

class DaftarTransaksiController extends BaseController
{
    protected $transaksiModel;
    protected $transaksiDetailModel;
    protected $pasienModel;
    protected $obatModel;
    protected $karyawanModel;

    public function __construct()
    {
        $this->transaksiModel = new TransaksiModel();
        $this->transaksiDetailModel = new TransaksiDetail();
        $this->pasienModel = new DaftarPasienModel();
        $this->obatModel = new ObatModel();
        $this->karyawanModel = new DaftarKaryawanModel();
    }

    public function index()
    {
        $data['title'] = 'Transaksi SISPUS';
        $data['datauser'] = $this->karyawanModel->where(['nik' => user()->nik])->first();
        $data['transaksi'] = $this->transaksiModel->findAll();
        $data['pasien'] = $this->pasienModel->findAll();
        $data['obat'] = $this->obatModel->findAll();

        return view('daftar_transaksi', $data);
    }

    public function saveTransaksi()
    {
        // Validasi Data Obat
        $dataObat = $this->request->getPost('dataObat');
        if (!is_array($dataObat) || empty($dataObat)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Data obat tidak valid.']);
        }

        // Validasi ID Pasien
        $idPasien = $this->request->getPost('id_pasien');
        if (!$this->pasienModel->find($idPasien)) {
            return $this->response->setJSON(['success' => false, 'message' => 'ID Pasien tidak valid.']);
        }

        // Mendapatkan tanggal saat ini
        $tanggalTransaksi = date('Ymd');

        // Mendapatkan jenis transaksi (misalnya, T untuk Transaksi)
        $jenisTransaksi = 'T';

        // Mendapatkan angka unik (misalnya, menggunakan time())
        $angkaUnik = time();

        // Membuat kode transaksi dengan format Tanggal-JenisTransaksi-AngkaUnik
        $kodeTransaksi = $tanggalTransaksi . $jenisTransaksi . $angkaUnik;

        // Setel nilai field kode transaksi di formulir
        $_POST['kode_transaksi'] = $kodeTransaksi;
        $_POST['hidden_kode_transaksi'] = $kodeTransaksi;

        // Simpan data transaksi utama dengan menyertakan kode transaksi
        $transaksi = $this->transaksiModel->insert([
            'kode_transaksi' => $kodeTransaksi,
            'id_pasien' => $idPasien,
            'total_biaya' => $this->request->getPost('total_biaya'),
            'metode_pembayaran' => $this->request->getPost('metode_pembayaran'),
        ]);

        if ($transaksi === false) {
            return $this->response->setJSON(['success' => false, 'message' => 'Gagal menyimpan transaksi utama.']);
        }

        // Simpan data detail transaksi (obat-obatan)
        foreach ($dataObat as $obat) {
            $detailInsertResult = $this->transaksiDetailModel->insert([
                'id_transaksi' => $transaksi,
                'id_obat' => $obat['id_obat'],
                'jumlah_obat' => $obat['jumlah'],
                'total_harga' => $obat['totalBiaya'],
            ]);

            if ($detailInsertResult === false) {
                $errorMessage = 'Gagal menyimpan detail transaksi obat. ID Obat: ' . $obat['id_obat'];
                return $this->response->setJSON(['success' => false, 'message' => $errorMessage]);
            }
        }

        // Transaksi berhasil
        return $this->response->setJSON(['success' => true, 'message' => 'Transaksi berhasil dilakukan.']);
    }
}
