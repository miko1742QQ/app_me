<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Myth\Auth\Password;

// UNtuk View Database
use App\Models\DaftarKaryawanModel;
use App\Models\DaftarPoliModel;
use CodeIgniter\HTTP\Header;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\AutoFilter\Column;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class DaftarPoliController extends BaseController
{
    protected $poliModel;
    protected $karyawanModel;

    public function __construct()
    {
        $this->karyawanModel = new DaftarKaryawanModel();
        $this->poliModel = new DaftarPoliModel();
    }

    public function index()
    {
        $data['title'] = 'Daftar Poli SISPUS';
        $data['datauser'] = $this->karyawanModel->where(['nik' => user()->nik])->first();
        $data['poli'] = $this->poliModel->findAll();

        return view('daftar_poli', $data);
    }

    public function create_poli()
    {
        $data['title'] = 'Tambah Data Poli SISPUS';
        $data['datauser'] = $this->karyawanModel->where(['nik' => user()->nik])->first();
        return view('create_poli', $data);
    }

    public function edit_poli($id = null)
    {
        $data['title'] = 'Edit Poli SISPUS';
        $data['datauser'] = $this->karyawanModel->where(['nik' => user()->nik])->first();
        $data['datapoli'] = $this->poliModel->where(['id' => $id])->first();
        return view('edit_poli', $data);
    }

    public function save_poli()
    {
        // validation input
        if (!$this->validate([
            'kode_poli' => [
                'rules' => 'required|max_length[10]',
                'errors' => [
                    'required' => 'Kode Poli Tidak Boleh Kosong',
                    'max_length' => 'Kode Poli Maksimal 10 Karakter',
                ],
            ],
            'nama' => [
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => 'Nama Tidak Boleh Kosong',
                    'max_length' => 'Nama Maksimal 100 Karakter',
                ],
            ],
            'maksimal' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Batas Maksimal Tidak Boleh Kosong',
                ],
            ],
        ])) {
            $validation = \Config\Services::validation();
            return redirect()->back()->withInput()->with('validation', $this->validator->getErrors());
        }

        $kode_poli  = $this->request->getVar('kode_poli');
        $nama       = $this->request->getVar('nama');
        $maksimal   = $this->request->getVar('maksimal');

        $data = [
            'kode_poli' => $kode_poli,
            'nama_poli' => $nama,
            'kapasitas' => $maksimal,
        ];

        // dd($data);
        if ($this->poliModel->save($data) == true) {
            return redirect()->to(base_url('daftar_poli'))->with('success', 'Data Poli Berhasil Disimpan');
        } else {
            return redirect()->back()->with('error', 'Data Poli Gagal Disimpan');
        }
    }

    public function update_poli($id = null)
    {
        // validation input
        if (!$this->validate([
            'kode_poli' => [
                'rules' => 'max_length[100]|permit_empty',
                'errors' => [
                    'max_length' => 'Kode Poli Maksimal 100 Karakter',
                ],
            ],
            'nama' => [
                'rules' => 'alpha_space|max_length[100]|permit_empty',
                'errors' => [
                    'max_length' => 'Nama Maksimal 100 Karakter',
                    'alpha_space' => 'Nama Hanya Bisa Diinputkan Dengan Huruf'
                ],
            ],
            'maksimal' => [
                'rules' => 'numeric|permit_empty',
                'errors' => [
                    'numeric' => 'Batas Maksimal Hanya Bisa Diinputkan Dengan Angka'
                ],
            ],
        ])) {
            $validation = \Config\Services::validation();
            return redirect()->back()->withInput()->with('validation', $this->validator->getErrors());
        }

        $kode_poli  = $this->request->getVar('kode_poli');
        if ($kode_poli == null) {
            $dataPoli = $this->request->getVar('kode_poliLama');
        } else {
            $dataPoli = $this->request->getVar('kode_poli');
        }

        $nama       = $this->request->getVar('nama');
        if ($nama == null) {
            $dataNama = $this->request->getVar('namaLama');
        } else {
            $dataNama = $this->request->getVar('nama');
        }

        $maksimal   = $this->request->getVar('maksimal');
        if ($maksimal == null) {
            $dataMaksimal = $this->request->getVar('maksimalLama');
        } else {
            $dataMaksimal = $this->request->getVar('maksimal');
        }

        $data = [
            'kode_poli' => $dataPoli,
            'nama_poli' => $dataNama,
            'kapasitas' => $dataMaksimal,
        ];

        if ($this->poliModel->update($id, $data) == true) {
            return redirect()->to(base_url('daftar_poli'))->with('success', 'Data Poli Berhasil Diperbaharui');
        } else {
            return redirect()->back()->with('error', 'Data Poli Gagal Diperbaharui');
        }
    }

    public function delete_poli($id = null)
    {
        if ($this->poliModel->delete($id) == true) {
            return redirect()->to(base_url('daftar_poli'))->with('success', 'Data Poli Berhasil Dihapus');
        } else {
            return redirect()->back()->with('error', 'Data Poli Gagal Dihapus');
        }
    }

    public function view_poli()
    {
    }
}
