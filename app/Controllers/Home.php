<?php

namespace App\Controllers;

use App\Models\DaftarPasienModel;
use App\Models\DaftarKaryawanModel;
use App\Models\DaftarPenggunaModel;


class Home extends BaseController
{
    protected $pasienModel;
    protected $karyawanModel;
    protected $penggunaModel;

    public function __construct()
    {
        $this->pasienModel = new DaftarPasienModel();
        $this->karyawanModel = new DaftarKaryawanModel();
        $this->penggunaModel = new DaftarPenggunaModel();
    }
    public function index(): string
    {
        $data['title'] = 'Login';
        return view('welcome_message');
    }

    public function dashboard()
    {
        $data['datauser'] = $this->karyawanModel->where(['nik' => user()->nik])->first();
        $data['pasien'] = $this->pasienModel->findAll();
        $data['karyawan'] = $this->karyawanModel->getKaryawan();
        $data['users'] = $this->penggunaModel->getPengguna();
        // dd($data);
        $data['title'] = 'Dashboard SISPUS';
        return view('dashboard', $data);
        // return view('dashboard');
    }
}
