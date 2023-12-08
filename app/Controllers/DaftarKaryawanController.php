<?php

namespace App\Controllers;

use App\Models\DaftarKaryawanModel;
use App\Models\DaftarPenggunaModel;
use Myth\Auth\Password;

class DaftarKaryawanController extends BaseController
{
    protected $karyawanModel;
    protected $penggunaModel;

    public function __construct()
    {
        $this->karyawanModel = new DaftarKaryawanModel();
        $this->penggunaModel = new DaftarPenggunaModel();
    }

    public function index()
    {
        $data['title'] = 'Daftar Karyawan SISPUS';
        $data['datauser'] = $this->karyawanModel->where(['nik' => user()->nik])->first();
        $data['karyawan'] = $this->karyawanModel->findAll();
        return view('daftar_karyawan', $data);
    }

    public function create_karyawan()
    {
        $data['title'] = 'Tambah Data Karyawan SISPUS';
        $data['datauser'] = $this->karyawanModel->where(['nik' => user()->nik])->first();
        return view('create_karyawan', $data);
    }

    public function save_karyawan()
    {
        // validation input
        if (!$this->validate([
            'nik' => [
                'rules' => 'required|is_unique[karyawan.nik]|numeric|max_length[16]|min_length[5]',
                'errors' => [
                    'required' => 'NIK Tidak Boleh Kosong',
                    'is_unique' => 'NIK Sudah Ada Di Dalam Database',
                    'max_length' => 'Maximal NIK 16 Karakter',
                    'min_length' => 'Minimal NIK 16 Karakter',
                    'numeric' => 'NIK Hanya Bisa Diinputkan Dengan Angka',
                ],
            ],
            'nama' => [
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => 'Nama Tidak Boleh Kosong',
                    'max_length' => 'Nama Maksimal 100 Karakter',
                ],
            ]
        ])) {
            $validation = \Config\Services::validation();
            return redirect()->back()->withInput()->with('validation', $this->validator->getErrors());
        }

        $nik        = $this->request->getVar('nik');
        $nama       = $this->request->getVar('nama');

        $data = [
            'nik' => $nik,
            'nama_karyawan' => $nama,
        ];

        // dd($data);
        if ($this->karyawanModel->save($data) == true) {
            return redirect()->to(base_url('daftar_karyawan'))->with('success', 'Data Karyawan Berhasil Disimpan');
        } else {
            return redirect()->back()->with('error', 'Data Karyawan Gagal Disimpan');
        }
    }

    public function edit_karyawan($id = null)
    {
        $data['title'] = 'Edit Karyawan SISPUS';
        $data['datauser'] = $this->karyawanModel->where(['nik' => user()->nik])->first();
        $data['datakaryawan'] = $this->karyawanModel->where(['id_karyawan' => $id])->first();
        return view('edit_karyawan', $data);
    }

    public function update_karyawan($id_karyawan = null)
    {
        // validation input
        if (!$this->validate([
            'nik' => [
                'rules' => 'is_unique[karyawan.nik]|numeric|max_length[16]|min_length[16]|permit_empty',
                'errors' => [
                    'is_unique' => 'NIK Sudah Ada Di Dalam Database',
                    'max_length' => 'Maximal NIK 16 Karakter',
                    'min_length' => 'Minimal NIK 16 Karakter',
                    'numeric' => 'NIK Hanya Bisa Diinputkan Dengan Angka',
                ],
            ],
            'nama' => [
                'rules' => 'alpha_numeric_space|max_length[100]|permit_empty',
                'errors' => [
                    'max_length' => 'Nama Maksimal 100 Karakter',
                    'alpha_numeric_space' => 'Nama Hanya Bisa Diinputkan Dengan Huruf'
                ],
            ],
        ])) {
            $validation = \Config\Services::validation();
            return redirect()->back()->withInput()->with('validation', $this->validator->getErrors());
        }

        $nik    = $this->request->getVar('nik');
        if ($nik == null) {
            $dataNik = $this->request->getVar('nikLama');
        } else {
            $dataNik = $this->request->getVar('nik');
        }

        $nama       = $this->request->getVar('nama');
        if ($nama == null) {
            $dataNama = $this->request->getVar('namaLama');
        } else {
            $dataNama = $this->request->getVar('nama');
        }

        $nama   = $this->request->getVar('nama');

        $data = [
            'nik' => $dataNik,
            'nama_karyawan' => $dataNama,
        ];

        // dd($data);
        if ($this->karyawanModel->update($id_karyawan, $data) == true) {
            return redirect()->to(base_url('daftar_karyawan'))->with('success', 'Data Karyawan Berhasil Diperbaharui');
        } else {
            return redirect()->back()->with('error', 'Data Karyawan Gagal Diperbaharui');
        }
    }

    public function delete_karyawan($id_karyawan = null)
    {
        if ($this->karyawanModel->delete($id_karyawan) == true) {
            return redirect()->to(base_url('daftar_karyawan'))->with('success', 'Data Karyawan Berhasil Dihapus');
        } else {
            return redirect()->back()->with('error', 'Data Karyawan Gagal Dihapus');
        }
    }
}
