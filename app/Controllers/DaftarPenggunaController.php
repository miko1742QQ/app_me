<?php

namespace App\Controllers;

use App\Models\DaftarRoleModel;
use App\Models\DaftarGroupsRoleModel;
use App\Models\DaftarPenggunaModel;
use Myth\Auth\Password;
use App\Models\DaftarKaryawanModel;

class DaftarPenggunaController extends BaseController
{
    protected $penggunaModel;
    protected $roleModel;
    protected $groupsroleModel;
    protected $karyawanModel;

    public function __construct()
    {
        $this->penggunaModel = new DaftarPenggunaModel();
        $this->roleModel = new DaftarRoleModel();
        $this->groupsroleModel = new DaftarGroupsRoleModel();
        $this->karyawanModel = new DaftarKaryawanModel();
    }

    public function index()
    {
        $data['title'] = 'Daftar Pengguna SISPUS';
        $data['datauser'] = $this->karyawanModel->where(['nik' => user()->nik])->first();
        $data['users'] = $this->penggunaModel->getPengguna();
        return view('daftar_pengguna', $data);
    }

    public function create_pengguna()
    {
        $data['title'] = 'Tambah Pengguna SISPUS';
        $data['datauser'] = $this->karyawanModel->where(['nik' => user()->nik])->first();
        $data['users'] = $this->penggunaModel->findAll();
        $data['level'] = $this->roleModel->findAll();
        $data['karyawan'] = $this->karyawanModel->findAll();

        return view('create_pengguna', $data);
    }

    public function save_pengguna()
    {
        // validation input
        if (!$this->validate([
            'nik' => [
                'rules' => 'required|is_unique[users.nik]',
                'errors' => [
                    'required' => 'Karyawan Harus Dipilih',
                    'is_unique' => 'Karyawan Sudah Menjadi Pengguna Sebelumnya',
                ],
            ],
            'id_role' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Role Belum Dipilih',
                ],
            ],
            'email' => [
                'rules' => 'required|valid_emails|max_length[50]',
                'errors' => [
                    'required' => 'Email Tidak Boleh Kosong',
                    'valid_emails' => 'There is no @ element',
                    'max_length' => 'Email Maksimal 50 Karakter',
                ],
            ],
            'username' => [
                'rules' => 'required|max_length[50]',
                'errors' => [
                    'required' => 'Username Tidak Boleh Kosong',
                    'max_length' => 'Username Maksimal 50 Karakter',
                ],
            ],
            'password_hash' => [
                'rules' => 'required|max_length[50]',
                'errors' => [
                    'required' => 'Username Tidak Boleh Kosong',
                    'max_length' => 'Username Maksimal 50 Karakter',
                ],
            ],
            'active' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Status Karyawan Belum Dipilih',
                ],
            ]
        ])) {
            $validation = \Config\Services::validation();
            return redirect()->back()->withInput()->with('validation', $this->validator->getErrors());
        }

        $nik                = $this->request->getVar('nik');
        $id_role            = $this->request->getVar('id_role');
        $email              = $this->request->getVar('email');
        $username           = $this->request->getVar('username');
        $password           = $this->request->getVar('password_hash');
        $password_hash      = Password::hash($this->request->getVar('password_hash'));
        $active             = $this->request->getVar('active');
        $force_pass_reset   = $this->request->getVar('force_pass_reset');

        $data = [
            'nik' => $nik,
            'id_role' => $id_role,
            'email' => $email,
            'username' => $username,
            'password' => $password,
            'password_hash' => $password_hash,
            'active' => $active,
            'force_pass_reset' => $force_pass_reset
        ];

        if ($this->penggunaModel->save($data) == true) {
            return redirect()->to(base_url('daftar_pengguna'))->with('success', 'Data Pengguna Berhasil Disimpan');
        } else {
            return redirect()->back()->with('error', 'Data Pengguna Gagal Disimpan');
        }
    }

    public function edit_pengguna($id = null)
    {
        $data['title'] = 'Edit Pengguna SISPUS';
        $data['datauser'] = $this->karyawanModel->where(['nik' => user()->nik])->first();
        $data['user'] = $this->penggunaModel->where(['id' => $id])->first();
        $data['level'] = $this->roleModel->findAll();
        return view('edit_pengguna', $data);
    }

    public function update_pengguna($id = null)
    {
        // validation input
        if (!$this->validate([
            'id_role' => [
                'rules' => 'permit_empty',
                'errors' => [],
            ],
            'email' => [
                'rules' => 'permit_empty|valid_emails|max_length[50]',
                'errors' => [
                    'valid_emails' => 'There is no @ element',
                    'max_length' => 'Email Maksimal 50 Karakter',
                ],
            ],
            'username' => [
                'rules' => 'permit_empty|max_length[50]',
                'errors' => [
                    'max_length' => 'Username Maksimal 50 Karakter',
                ],
            ],
            'password_hash' => [
                'rules' => 'permit_empty|max_length[50]',
                'errors' => [
                    'max_length' => 'Password Maksimal 50 Karakter',
                ],
            ],
            'active' => [
                'rules' => 'permit_empty',
                'errors' => [],
            ]
        ])) {
            $validation = \Config\Services::validation();
            return redirect()->back()->withInput()->with('validation', $this->validator->getErrors());
        }

        $email = $this->request->getVar('email');
        if ($email == null) {
            $namaEmail = $this->request->getVar('emailLama');
        } else {
            $namaEmail = $this->request->getVar('email');
        }

        $username           = $this->request->getVar('username');
        if ($username == null) {
            $namaUsername = $this->request->getVar('usernameLama');
        } else {
            $namaUsername = $this->request->getVar('username');
        }

        $id_role        = $this->request->getVar('id_role');
        if ($id_role == null) {
            $namaIDRole = $this->request->getVar('id_roleLama');
        } else {
            $namaIDRole = $this->request->getVar('id_role');
        }

        $password           = $this->request->getVar('password_hash');
        if ($password == null) {
            $namaPassword = $this->request->getVar('passwordLama');
        } else {
            $namaPassword = $this->request->getVar('password_hash');
        }

        $password_hash      = $this->request->getVar('password_hash');
        if ($password_hash == null) {
            $namaPasswordHash = $this->request->getVar('password_hashLama');
        } else {
            $namaPasswordHash = Password::hash($this->request->getVar('password_hash'));
        }

        $active             = $this->request->getVar('active');
        if ($active == null) {
            $namaActive = $this->request->getVar('activeLama');
        } else {
            $namaActive = $this->request->getVar('active');
        }

        $force_pass_reset   = $this->request->getVar('force_pass_reset');

        $data = [
            'email' => $namaEmail,
            'username' => $namaUsername,
            'id_role' => $namaIDRole,
            'password' => $namaPassword,
            'password_hash' => $namaPasswordHash,
            'active' => $namaActive,
            'force_pass_reset' => $force_pass_reset,
        ];

        if ($this->penggunaModel->update($id, $data) == true) {
            return redirect()->to(base_url('daftar_pengguna'))->with('success', 'Data Pengguna Berhasil Diperbaharui');
        } else {
            return redirect()->back()->with('error', 'Data Pengguna Gagal Diperbaharui');
        }
    }

    public function delete_pengguna($id = null)
    {
        if ($this->penggunaModel->delete($id) == true) {
            return redirect()->to(base_url('daftar_pengguna'))->with('success', 'Data Pengguna Berhasil Dihapus');
        } else {
            return redirect()->back()->with('error', 'Data Pengguna Gagal Dihapus');
        }
    }
}
