<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DaftarKaryawanModel;
use App\Models\DaftarNomorAntrianModel;
use App\Models\DaftarPasienModel;
use App\Models\DaftarPoliModel;
use App\Models\ObatModel;

class DaftarNoAntrianController extends BaseController
{
    protected $karyawanModel;
    protected $poliModel;
    protected $antrianModel;
    protected $pasienModel;
    protected $obatModel;

    public function __construct()
    {
        $this->karyawanModel = new DaftarKaryawanModel();
        $this->antrianModel = new DaftarNomorAntrianModel();
        $this->pasienModel = new DaftarPasienModel();
        $this->poliModel = new DaftarPoliModel();
        $this->obatModel = new ObatModel();
    }

    public function index()
    {
        $data['title'] = 'Nomor Antrian SISPUS';
        $data['poli'] = $this->poliModel->findAll();
        $data['pasien'] = $this->pasienModel->findAll();
        $data['obat'] = $this->obatModel->findAll();
        $data['dataAntrian'] = $this->antrianModel->getData1();

        foreach ($data['poli'] as &$poli) {
            $latestAntrian = $this->antrianModel->where('id_poli', $poli['id'])->orderBy('id', 'DESC')->first();
            $poli['nomor_antrian'] = $latestAntrian ? $latestAntrian['nomor_antrian'] : 'Belum Ada';
        }

        return view('nomor_antrian', $data);
    }

    public function nomorantrian_poli()
    {
        $data['title'] = 'Nomor Antrian SISPUS';
        $data['datauser'] = $this->karyawanModel->where(['nik' => user()->nik])->first();
        $data['poli'] = $this->poliModel->findAll();
        $data['pasien'] = $this->pasienModel->findAll();
        $data['obat'] = $this->obatModel->findAll();
        $data['antrian'] = $this->antrianModel->getData();

        return view('nomorantrian_poli', $data);
    }

    public function fetchDataByJenisPoli()
    {
        $jenisPoli = $this->request->getPost('jenis_poli');
        $data = $this->antrianModel->getDataByJenisPoli($jenisPoli);

        // Kembalikan data dalam format JSON
        return $this->response->setJSON($data);
    }

    public function fetchNomorAntrianSelanjutnya()
    {
        $data = $this->antrianModel->getData1();

        // Kembalikan data dalam format JSON
        return $this->response->setJSON($data);
    }

    public function fetchKapasitas()
    {
        $data = $this->antrianModel->getData1();
        $kapasitas = $data['kapasitas'];
        $antrian_waiting = $data['antrian_waiting'];

        $responseData = [
            'kapasitas' => $kapasitas,
            'antrian_waiting' => $antrian_waiting,
        ];
        // Kembalikan data dalam format JSON
        return $this->response->setJSON($responseData);
    }

    public function antrian_selesai($nomor_antrian = null, $id = null)
    {
        // Pastikan nomor_antrian dan id_poli tidak kosong
        if ($nomor_antrian === null || $id === null) {
            // Jika kosong, lakukan sesuatu, seperti menampilkan pesan error atau mengarahkan pengguna ke halaman lain
            return redirect()->to(base_url())->with('error', 'Nomor antrian atau ID poli tidak valid.');
        }

        $poli = $this->poliModel->find($id);
        $antrian_waiting = $poli['antrian_waiting'] - ($poli['antrian_end'] + 1);

        // Data yang akan diupdate
        $data = [
            'antrian_end' => $nomor_antrian,
            'antrian_waiting' => $antrian_waiting
        ];


        // Update data di dalam model
        if ($this->poliModel->update($id, $data)) {
            // Jika update berhasil, arahkan pengguna ke halaman tertentu dengan pesan sukses
            return redirect()->to(base_url('nomorantrian_poli'))->with('success', 'Nomor Antrian Telah Selesai');
        } else {
            // Jika update gagal, arahkan pengguna kembali ke halaman sebelumnya dengan pesan error
            return redirect()->back()->with('error', 'Nomor Antrian Gagal Diproses');
        }
    }

    public function ambilNomorAntrian($id_poli)
    {
        // Mendapatkan tanggal saat ini
        $todayDate = date('Y-m-d');
        $poli = $this->poliModel->find($id_poli);

        if ($poli['kapasitas'] <= $poli['antrian_waiting'] + $poli['antrian_proses'] - $poli['antrian_end']) {
            // Menampilkan alert kapasitas penuh jika kapasitas sudah mencapai batas
            return $this->response->setJSON(['error' => 'Kapasitas Poli Sudah Penuh']);
        } else {
            // Mencari entri antrian terbaru untuk poli dan tanggal saat ini
            $latestAntrian = $this->antrianModel
                ->where('id_poli', $id_poli)
                ->where('tanggal', $todayDate)
                ->orderBy('id', 'DESC')
                ->first();

            // Menentukan nomor antrian baru
            $jumlahAntrian = $latestAntrian ? $latestAntrian['nomor_antrian'] + 1 : 1;

            // Mencari entri antrian terbaru untuk poli dan tanggal saat ini
            $AntrianSelanjutnya = $this->antrianModel
                ->where('id_poli', $id_poli)
                ->where('status', 'end')
                ->orderBy('id', 'DESC')
                ->first();

            // Menentukan nomor antrian selanjutnya
            $jumlahAntrianSelanjutnya = $AntrianSelanjutnya ? $AntrianSelanjutnya['nomor_antrian'] + 1 : 1;

            // Data untuk disisipkan ke dalam tabel no_antrian
            $data = [
                'tanggal' => $todayDate,
                'nomor_antrian' => $jumlahAntrian,
                'id_poli' => $id_poli,
                'status' => 'waiting',
            ];

            // Menyisipkan data ke dalam tabel no_antrian
            $this->antrianModel->insert($data);

            // Menyiapkan data untuk respons JSON atau tindakan selanjutnya
            $responseData = [
                'idPoli' => $poli,
                'nomor_antrian' => $jumlahAntrian,
                'nomor_antrianselanjutnya' => $jumlahAntrianSelanjutnya,
                'nama_poli' => $poli['nama_poli'],  // Sesuaikan dengan properti yang sesuai
            ];

            // Mengembalikan respons dalam format JSON
            return $this->response->setJSON($responseData);
        }
    }
}
