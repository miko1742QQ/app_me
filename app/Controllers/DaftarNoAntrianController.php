<?php

namespace App\Controllers;

use App\Controllers\BaseController;

// UNtuk View Database
use App\Models\DaftarKaryawanModel;
use App\Models\DaftarNomorAntrianModel;
use App\Models\DaftarPoliModel;

class DaftarNoAntrianController extends BaseController
{
    protected $karyawanModel;
    protected $poliModel;
    protected $antrianModel;

    public function __construct()
    {
        $this->karyawanModel = new DaftarKaryawanModel();
        $this->antrianModel = new DaftarNomorAntrianModel();
        $this->poliModel = new DaftarPoliModel();
    }

    public function index()
    {
        $data['title'] = 'Nomor Antrian SISPUS';
        $data['poli'] = $this->poliModel->findAll();

        // Ambil nomor antrian untuk setiap bidang poli
        foreach ($data['poli'] as &$poli) {
            $latestAntrian = $this->antrianModel->where('id_poli', $poli['id'])->orderBy('id', 'DESC')->first();
            $poli['nomor_antrian'] = $latestAntrian ? $latestAntrian['nomor_antrian'] : 'Belum Ada';
        }

        return view('nomor_antrian', $data);
    }

    public function hapus_nomorantrian()
    {
        $data['title'] = 'Nomor Antrian SISPUS';
        $data['datauser'] = $this->karyawanModel->where(['nik' => user()->nik])->first();
        $data['poli'] = $this->poliModel->findAll();
        $data['antrian'] = $this->antrianModel->getData();

        // dd($data);

        return view('hapus_nomorantrian', $data);
    }

    public function delete_antrian($id = null)
    {
        if ($this->antrianModel->delete($id) == true) {
            return redirect()->to(base_url('hapus_nomorantrian'))->with('success', 'Nomor Antrian Berhasil Dihapus');
        } else {
            return redirect()->back()->with('error', 'Nomor Antrian Gagal Dihapus');
        }
    }


    public function ambilNomorAntrian($id_poli)
    {
        // Ambil data poli berdasarkan ID
        $poli = $this->poliModel->find($id_poli);

        if (!$poli) {
            // Tampilkan pesan atau redirect jika data poli tidak ditemukan
            return $this->response->setJSON(['error' => 'Bidang poli tidak ditemukan']);
        }

        // Cek kapasitas poli
        $jumlahAntrian = $this->antrianModel->where('id_poli', $id_poli)->countAllResults();
        if ($jumlahAntrian >= $poli['kapasitas']) {
            // Set flashdata dengan pesan kapasitas penuh
            session()->setFlashdata('error', 'Kapasitas bidang poli sudah penuh. Silakan pilih bidang poli lain.');
            return $this->response->setJSON(['error' => 'Kapasitas penuh']);
        }

        // Tambahkan nomor antrian baru
        $data = [
            'nomor_antrian' => $jumlahAntrian + 1,
            'tanggal' => date('Y-m-d'),
            'id_poli' => $id_poli,
        ];

        // Tampilkan data yang akan diinsert ke dalam tabel
        log_message('info', 'Data nomor antrian yang akan diinsert: ' . print_r($data, true));

        $this->antrianModel->insert($data);

        $data['nomor_antrian'] = $data['nomor_antrian'];
        $data['nama_poli'] = $poli['nama_poli'];
        // Kirim data sebagai JSON
        return $this->response->setJSON($data);
    }
}
